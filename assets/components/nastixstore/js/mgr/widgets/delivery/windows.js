nastixstore.window.CreateDelivery = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: _('nastixstore_delivery_create'),
        width: 600,
        baseParams: {
            action: 'mgr/delivery/create',
        },
    });
    nastixstore.window.CreateDelivery.superclass.constructor.call(this, config);
};
Ext.extend(nastixstore.window.CreateDelivery, nastixstore.window.Default, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id'
        }, {
            xtype: 'textfield',
            fieldLabel: _('nastixstore_name'),
            name: 'name',
            anchor: '99%',
            id: config.id + '-name',
            allowBlank: false
        }];
    },
});
Ext.reg('nastixstore-window-delivery-create', nastixstore.window.CreateDelivery);


nastixstore.window.UpdateDelivery = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: _('nastixstore_delivery_update'),
        baseParams: {
            action: 'mgr/delivery/update',
        },
        bodyCssClass: 'tabs',
    });
    nastixstore.window.UpdateDelivery.superclass.constructor.call(this, config);
};
Ext.extend(nastixstore.window.UpdateDelivery, nastixstore.window.CreateDelivery, {

    getFields: function (config) {
        return [{
            xtype: 'modx-tabs',
            items: [{
                title: _('nastixstore_delivery'),
                layout: 'form',
                items: nastixstore.window.CreateDelivery.prototype.getFields.call(this, config),
            }]
        }];
    }

});
Ext.reg('nastixstore-window-delivery-update', nastixstore.window.UpdateDelivery);