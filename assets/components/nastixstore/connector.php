<?php
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
} else {
    require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/config.core.php';
}
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var nastixstore $nastixstore */
$corePath = $modx->getOption('nastixstore_core_path', array(), $modx->getOption('core_path') . 'components/nastixstore/');
$nastixstore = $modx->getService('nastixstore', 'nastixstore', $corePath . 'model/');
$modx->lexicon->load('nastixstore:default');

// handle request
// $corePath = $modx->getOption('nastixstore_core_path', null, $modx->getOption('core_path') . 'components/nastixstore/');
$path = $modx->getOption('processorsPath', $nastixstore->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest([
    'processors_path' => $path,
    'location' => '',
]);