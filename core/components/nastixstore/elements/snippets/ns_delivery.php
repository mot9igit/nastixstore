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
$tpl = $modx->getOption('tpl', $scriptProperties, 'ns_delivery');
$toPlaceholder = $modx->getOption('toPlaceholder', $scriptProperties, false);

$output = '';

$deliverys = $modx->getCollection("nsDelivery");
foreach($deliverys as $delivery){
    $output .= $nastixstore->pdoTools->getChunk($tpl, $delivery->toArray());
}

echo $output;