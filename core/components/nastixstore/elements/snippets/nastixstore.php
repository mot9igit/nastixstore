<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var nastixstore $nastixstore */
$corePath = $modx->getOption('nastixstore_core_path', array(), $modx->getOption('core_path') . 'components/nastixstore/');
$nastixstore = $modx->getService('nastixstore', 'nastixstore', $corePath . 'model/');
if (!$nastixstore) {
    return 'Could not load nastixstore class!';
}

// Do your snippet code here. This demo grabs 5 items from our custom table.
$minicartTpl = $modx->getOption('minicartTpl', $scriptProperties, 'ns_minicart');
$cartTpl = $modx->getOption('cartTpl', $scriptProperties, 'ns_cart');
$mode = $modx->getOption('mode', $scriptProperties, 'cart');
$toPlaceholder = $modx->getOption('toPlaceholder', $scriptProperties, false);

$output = '';

$cart = $nastixstore->cartGet();
$count = 0;
$cost = 0;
foreach($cart as $key => $product){
    $count += $product["count"];
    $cost += $product["count"]*$product["price"];
}
if($mode == 'minicart'){
    $output = $nastixstore->pdoTools->getChunk($minicartTpl, array("count" => $count, "cost" => $cost));
}else{
    $data = array(
        "products" => $cart,
        "total" => array(
            "count" => $count,
            "cost" => $cost
        )
    );
    $output = $nastixstore->pdoTools->getChunk($cartTpl, $data);
}

return $output;
