<?php

/**
 * The home manager controller for nastixstore.
 *
 */
class nastixstoreHomeManagerController extends modExtraManagerController
{
    /** @var nastixstore $nastixstore */
    public $nastixstore;


    /**
     *
     */
    public function initialize()
    {
        $corePath = $this->modx->getOption('nastixstore_core_path', array(), $this->modx->getOption('core_path') . 'components/nastixstore/');
        $this->nastixstore = $this->modx->getService('nastixstore', 'nastixstore', $corePath . 'model/');
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['nastixstore:default'];
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('nastixstore');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->nastixstore->config['cssUrl'] . 'mgr/main.css');
        $this->addJavascript($this->nastixstore->config['jsUrl'] . 'mgr/nastixstore.js');
        $this->addJavascript($this->nastixstore->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->nastixstore->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->nastixstore->config['jsUrl'] . 'mgr/misc/default.grid.js');
        $this->addJavascript($this->nastixstore->config['jsUrl'] . 'mgr/misc/default.windows.js');
        $this->addJavascript($this->nastixstore->config['jsUrl'] . 'mgr/widgets/delivery/grid.js');
        $this->addJavascript($this->nastixstore->config['jsUrl'] . 'mgr/widgets/delivery/windows.js');
        $this->addJavascript($this->nastixstore->config['jsUrl'] . 'mgr/widgets/status/grid.js');
        $this->addJavascript($this->nastixstore->config['jsUrl'] . 'mgr/widgets/status/windows.js');
        $this->addJavascript($this->nastixstore->config['jsUrl'] . 'mgr/widgets/address/grid.js');
        $this->addJavascript($this->nastixstore->config['jsUrl'] . 'mgr/widgets/address/windows.js');
        $this->addJavascript($this->nastixstore->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->nastixstore->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        nastixstore.config = ' . json_encode($this->nastixstore->config) . ';
        nastixstore.config.connector_url = "' . $this->nastixstore->config['connectorUrl'] . '";
        Ext.onReady(function() {MODx.load({ xtype: "nastixstore-page-home"});});
        </script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .= '<div id="nastixstore-panel-home-div"></div>';

        return '';
    }
}