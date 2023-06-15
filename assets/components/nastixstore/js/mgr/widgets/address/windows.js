nastixstore.window.CreateAddress = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: _('nastixstore_delivery_create'),
        width: 600,
        baseParams: {
            action: 'mgr/delivery/create',
        },
    });
    nastixstore.window.CreateAddress.superclass.constructor.call(this, config);
};
Ext.extend(nastixstore.window.CreateAddress, nastixstore.window.Default, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id'
        }, {
            xtype: 'nastixstore-combo-user',
            fieldLabel: _('nastixstore_user'),
            name: 'user_id',
            anchor: '99%',
            id: config.id + '-user_id',
            allowBlank: false
        }, {
            xtype: 'textfield',
            fieldLabel: _('nastixstore_index'),
            name: 'index',
            anchor: '99%',
            id: config.id + '-index',
            allowBlank: false
        }, {
            xtype: 'textfield',
            fieldLabel: _('nastixstore_region'),
            name: 'region',
            anchor: '99%',
            id: config.id + '-region',
            allowBlank: false
        }, {
            xtype: 'textfield',
            fieldLabel: _('nastixstore_settlement'),
            name: 'settlement',
            anchor: '99%',
            id: config.id + '-settlement',
            allowBlank: false
        }, {
            xtype: 'textfield',
            fieldLabel: _('nastixstore_street'),
            name: 'street',
            anchor: '99%',
            id: config.id + '-street',
            allowBlank: false
        }, {
            xtype: 'textfield',
            fieldLabel: _('nastixstore_house'),
            name: 'house',
            anchor: '99%',
            id: config.id + '-house',
            allowBlank: false
        }, {
            xtype: 'textfield',
            fieldLabel: _('nastixstore_room'),
            name: 'room',
            anchor: '99%',
            id: config.id + '-room',
            allowBlank: false
        }, {
            xtype: 'textarea',
            fieldLabel: _('nastixstore_description'),
            name: 'description',
            anchor: '99%',
            id: config.id + '-description',
            allowBlank: false
        }];
    },
});
Ext.reg('nastixstore-window-address-create', nastixstore.window.CreateAddress);


nastixstore.window.UpdateAddress = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: _('nastixstore_address_update'),
        baseParams: {
            action: 'mgr/address/update',
        },
        bodyCssClass: 'tabs',
    });
    nastixstore.window.UpdateAddress.superclass.constructor.call(this, config);
};
Ext.extend(nastixstore.window.UpdateAddress, nastixstore.window.CreateAddress, {

    getFields: function (config) {
        return [{
            xtype: 'modx-tabs',
            items: [{
                title: _('nastixstore_address'),
                layout: 'form',
                items: nastixstore.window.CreateAddress.prototype.getFields.call(this, config),
            }]
        }];
    }

});
Ext.reg('nastixstore-window-address-update', nastixstore.window.UpdateAddress);