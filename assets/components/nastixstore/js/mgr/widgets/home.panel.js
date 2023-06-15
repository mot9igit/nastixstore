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
            html: '<h2>' + _('nastixstore') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('nastixstore_address'),
                layout: 'anchor',
                items: [{
                    html: _('nastixstore_address_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'nastixstore-grid-address',
                    cls: 'main-wrapper',
                }]
            },{
                title: _('nastixstore_delivery'),
                layout: 'anchor',
                items: [{
                    html: _('nastixstore_delivery_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'nastixstore-grid-delivery',
                    cls: 'main-wrapper',
                }]
            },{
                title: _('nastixstore_status'),
                layout: 'anchor',
                items: [{
                    html: _('nastixstore_status_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'nastixstore-grid-status',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    nastixstore.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(nastixstore.panel.Home, MODx.Panel);
Ext.reg('nastixstore-panel-home', nastixstore.panel.Home);
