<?php

class nastixstore
{
    /** @var modX $modx */
    public $modx;


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = [])
    {
        $this->modx =& $modx;
        $corePath = $this->modx->getOption('nastixstore_core_path', $config, $this->modx->getOption('core_path') . 'components/nastixstore/');
        $assetsUrl = $this->modx->getOption('nastixstore_assets_url', $config, $this->modx->getOption('assets_url') . 'components/nastixstore/');
        $assetsPath = $this->modx->getOption('nastixstore_assets_path', $config, $this->modx->getOption('base_path') . 'assets/components/nastixstore/');

        $this->config = array_merge([
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',
            'assetsUrl' => $assetsPath,

            'connectorUrl' => $assetsUrl . 'connector.php',
            'actionUrl' => $assetsUrl . 'action.php',
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
        ], $config);

        $this->modx->addPackage('nastixstore', $this->config['modelPath']);
        $this->modx->lexicon->load('nastixstore:default');

        if ($this->pdoTools = $this->modx->getService('pdoFetch')) {
            $this->pdoTools->setConfig($this->config);
        }
    }

    /**
     * Initializes component into different contexts.
     *
     * @param string $ctx The context to load. Defaults to web.
     * @param array $scriptProperties Properties for initialization.
     *
     * @return bool
     */
    public function initialize($ctx = 'web', $scriptProperties = array())
    {
        if (isset($this->initialized[$ctx])) {
            return $this->initialized[$ctx];
        }

        if ($ctx != 'mgr' && (!defined('MODX_API_MODE') || !MODX_API_MODE) && !$this->config['json_response']) {
            $js_setting = array(
                'cssUrl' => $this->config['cssUrl'] . 'web/',
                'jsUrl' => $this->config['jsUrl'] . 'web/',
                'actionUrl' => $this->config['actionUrl'],

                'ctx' => $ctx
            );

            // dadata css
            $this->modx->regClientCSS($js_setting["cssUrl"]."default.css");
            $this->modx->regClientScript($js_setting["jsUrl"]."default.js");

            $data = json_encode($js_setting, true);
            $this->modx->regClientStartupScript(
                '<script>nastixstoreConfig = ' . $data . ';</script>',
                true
            );
        }
        $this->initialized[$ctx] = true;

        return true;
    }

    /**
     * Handle frontend requests with actions
     *
     * @param $action
     * @param array $data
     *
     * @return array|bool|string
     */
    public function handleRequest($action, $data = array())
    {
        $ctx = !empty($data['ctx'])
            ? (string)$data['ctx']
            : 'web';
        if ($ctx != 'web') {
            $this->modx->switchContext($ctx);
        }
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
        $this->initialize($ctx, array('json_response' => $isAjax));
        switch ($action) {
            case 'cart/add':
                $response = $this->cartAdd($data);
                break;
            case 'cart/change':
                $response = $this->cartChange($data);
                break;
            case 'cart/remove':
                $response = $this->cartDelete($data);
                break;
            case 'order/submit':
                $response = $this->order($data);
                break;
        }
        return $response;
    }

    public function cartGet(){
        return $_SESSION['nastixstore']['cart'];
    }

    public function cartAdd($data){
        if(isset($_SESSION['nastixstore']['cart'][$data['id']])){
            $_SESSION['nastixstore']['cart'][$data['id']]['count'] += $data['count'];
        }else{
            $_SESSION['nastixstore']['cart'][$data['id']]['count'] = $data['count'];
            $_SESSION['nastixstore']['cart'][$data['id']]['price'] = $data['price'];
        }
        $cart = $this->cartGet();
        $count = 0;
        $cost = 0;
        foreach($cart as $key => $product){
            $count += $product["count"];
            $cost += $product["count"]*$product["price"];
        }
        return array(
            "success" => true,
            "show_success" => true,
            "total_count" => $count,
            "total_cost" => $cost
        );
    }

    public function cartChange($data){
        if(isset($_SESSION['nastixstore']['cart'][$data['key']])){
            $_SESSION['nastixstore']['cart'][$data['key']]['count'] = $data['count'];
        }
        $cart = $this->cartGet();
        $count = 0;
        $cost = 0;
        foreach($cart as $key => $product){
            $count += $product["count"];
            $cost += $product["count"]*$product["price"];
        }
        return array(
            "success" => true,
            "show_success" => false,
            "total_count" => $count,
            "total_cost" => $cost
        );
    }

    public function cartDelete($data){
        if(isset($_SESSION['nastixstore']['cart'][$data['key']])){
            unset($_SESSION['nastixstore']['cart'][$data['key']]);
        }
        $cart = $this->cartGet();
        $count = 0;
        $cost = 0;
        foreach($cart as $key => $product){
            $count += $product["count"];
            $cost += $product["count"]*$product["price"];
        }
        return array(
            "success" => true,
            "show_success" => false,
            "total_count" => $count,
            "total_cost" => $cost,
            "remove_key" => $data['key']
        );
    }

    public function order($data){
        // создаем пользователя
        $count = $this->modx->getCount('modUser', array('username' => $data['email']));
        if($count > 0){
            $user = $this->modx->getObject('modUser', array('username' => $data['email']));
        }else{
            // создаем пользователя
            $user = $this->modx->newObject('modUser');
            // задаем имя пользователя и пароль
            $user->set('username', $data['email']);
            // TODO: сделать генерацию рандомную
            $user->set('password', '1d2Q3g456T78hn90');
            // сохраняем
            $user->save();
            // создаем профиль
            $profile = $this->modx->newObject('modUserProfile');
            // инициализируем поля
            $profile->set('fullname', $data['fullname']);
            $profile->set('email', $data['email']);
            $profile->set('phone', $data['phone']);
            // добавляем профиль к пользователю
            $user->addOne($profile);
            // сохраняем
            $profile->save();
            $user->save();
        }

        $user_id = $user->get("id");

        $address = $this->modx->newObject("nsAddress");
        $address->set("user_id", $user_id);
        $address->set("index", $data["index"]);
        $address->set("region", $data["region"]);
        $address->set("settlement", $data["settlement"]);
        $address->set("street", $data["street"]);
        $address->set("house", $data["house"]);
        $address->set("room", $data["room"]);
        $address->save();

        $address_id = $address->get("id");

        $cart = $this->cartGet();
        $count = 0;
        $cost = 0;
        foreach($cart as $key => $product){
            $count += $product["count"];
            $cost += $product["count"]*$product["price"];
        }

        $order = $this->modx->newObject("nsOrder");
        $order->set("user_id", $user_id);
        $order->set("status_id", 1);
        $order->set("delivery_id", $data["delivery"]);
        $order->set("address_id", $address_id);
        $order->set("date", time());
        $order->set("cost", $cost);
        $order->save();

        $order_id = $order->get("id");

        foreach($cart as $key => $product){
            $order_product = $this->modx->newObject("nsOrderProducts");
            $order_product->set("order_id", $order_id);
            $order_product->set("product_id", $key);
            $order_product->set("price", $product["price"]);
            $order_product->set("count", $product["count"]);
            $order_product->save();
        }

        unset($_SESSION['nastixstore']);
        $redirect = $this->modx->makeUrl(10, '', array('nsorder' => $order_id));

        return array(
            "success" => true,
            "show_success" => false,
            "total_count" => $count,
            "total_cost" => $cost,
            "redirect" => $redirect
        );
    }
}