nastixstore.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'nastixstore-panel-home',
            renderTo: 'nastixstore-panel-home-div'
        }]
    });
    nastixstore.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(nastixstore.page.Home, MODx.Component);
Ext.reg('nastixstore-page-home', nastixstore.page.Home);