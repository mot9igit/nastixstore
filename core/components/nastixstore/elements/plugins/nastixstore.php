<?php
/** @var modX $modx */
switch ($modx->event->name) {
    case 'OnLoadWebDocument':
        $scriptProperties = array();
        $corePath = $modx->getOption('nastixstore_core_path', array(), $modx->getOption('core_path') . 'components/nastixstore/');
        $nastixstore = $modx->getService('nastixstore', 'nastixstore', $corePath . 'model/');
        if (!$nastixstore) {
            $modx->log(xPDO::LOG_LEVEL_ERROR, 'Could not load nastixstore class!');
        }else{
            $nastixstore->initialize($modx->context->key);
        }
        break;
}