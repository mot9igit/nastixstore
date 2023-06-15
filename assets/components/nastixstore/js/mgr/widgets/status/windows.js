nastixstore.window.CreateStatus = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: _('nastixstore_status_create'),
        width: 600,
        baseParams: {
            action: 'mgr/status/create',
        },
    });
    nastixstore.window.CreateStatus.superclass.constructor.call(this, config);
};
Ext.extend(nastixstore.window.CreateStatus, nastixstore.window.Default, {

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
Ext.reg('nastixstore-window-status-create', nastixstore.window.CreateStatus);


nastixstore.window.UpdateStatus = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: _('nastixstore_status_update'),
        baseParams: {
            action: 'mgr/status/update',
        },
        bodyCssClass: 'tabs',
    });
    nastixstore.window.UpdateStatus.superclass.constructor.call(this, config);
};
Ext.extend(nastixstore.window.UpdateStatus, nastixstore.window.CreateStatus, {

    getFields: function (config) {
        return [{
            xtype: 'modx-tabs',
            items: [{
                title: _('nastixstore_status'),
                layout: 'form',
                items: nastixstore.window.CreateStatus.prototype.getFields.call(this, config),
            }]
        }];
    }

});
Ext.reg('nastixstore-window-status-update', nastixstore.window.UpdateStatus);