nastixstore.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'nastixstore-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: false,
            hideMode: 'offsets',
            items: [{
                title: _('nastixstore_items'),
                layout: 'anchor',
                items: [{
                    html: _('nastixstore_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'nastixstore-grid-items',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    nastixstore.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(nastixstore.panel.Home, MODx.Panel);
Ext.reg('nastixstore-panel-home', nastixstore.panel.Home);
