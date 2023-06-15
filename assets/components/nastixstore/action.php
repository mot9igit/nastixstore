<?php
define('MODX_API_MODE', true);
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/index.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/index.php';
} else {
    require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/index.php';
}

$modx->getService('error', 'error.modError');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->setLogTarget('FILE');

$scriptProperties = array();
$corePath = $modx->getOption('nastixstore_core_path', array(), $modx->getOption('core_path') . 'components/nastixstore/');
$nastixstore = $modx->getService('nastixstore', 'nastixstore', $corePath . 'model/');
if (!$nastixstore) {
    return 'Could not load nastixstore class!';
}

if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    $modx->sendRedirect($modx->makeUrl($modx->getOption('site_start'), '', '', 'full'));
}else{
    $out = $nastixstore->handleRequest($_REQUEST['ns_action'], @$_REQUEST);
    if(is_array ($out)){
        echo $response = json_encode($out);
    }else{
        echo $response = $out;
    }
}
@session_write_close();