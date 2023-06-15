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
$tpl = $modx->getOption('tpl', $scriptProperties, 'ns_getorder');
$toPlaceholder = $modx->getOption('toPlaceholder', $scriptProperties, false);

$output = '';

$data = array();

if($_GET["nsorder"]){
    $order = $modx->getObject("nsOrder", $_GET["nsorder"]);
    if($order){
        $data['order'] = $order->toArray();
        $products = $order->getMany("OrderProducts");
        foreach($products as $product){
            $id = $product->get("id");
            $data['products'][$id] = $product->toArray();
        }
    }
    $output = $nastixstore->pdoTools->getChunk($tpl, $data);
    return $output;
}