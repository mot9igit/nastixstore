nastixstore.grid.Address = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'nastixstore-grid-address';
    }
    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/address/getlist'
        },
        stateful: true,
    });
    nastixstore.grid.Address.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(nastixstore.grid.Address, nastixstore.grid.Default, {
    getListeners: function () {
        return {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateAddress(grid, e, row);
            },
        };
    },
    createAddress: function (btn, e) {
        var w = Ext.getCmp('nastixstore-window-address-create');
        if (w) {
            w.hide().getEl().remove();
        }

        w = MODx.load({
            xtype: 'nastixstore-window-address-create',
            id: 'nastixstore-window-address-create',
            record: this.menu.record,
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        w.fp.getForm().reset();
        w.show(e.target);
    },

    updateAddress: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }

        var w = Ext.getCmp('nastixstore-window-address-update');
        if (w) {
            w.close();
        }
        w = MODx.load({
            xtype: 'nastixstore-window-address-update',
            id: 'nastixstore-window-address-update',
            record: this.menu.record,
            title: this.menu.record['name'],
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        w.fp.getForm().reset();
        w.fp.getForm().setValues(this.menu.record);
        w.show(e.target);
    },

    removeAddress: function () {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.msg.confirm({
            title: ids.length > 1
                ? _('nastixstore_remove')
                : _('nastixstore_remove'),
            text: ids.length > 1
                ? _('nastixstore_remove_confirm')
                : _('nastixstore_remove_confirm'),
            url: this.config.url,
            params: {
                action: 'mgr/delivery/remove',
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });
        return true;
    },

    getFields: function () {
        return ['id', 'user', 'user_id', 'index', 'region', 'settlement', 'street', 'house', 'room', 'description', 'actions'];
    },

    getColumns: function () {
        return [{
            header: _('nastixstore_id'),
            dataIndex: 'id',
            sortable: true,
            width: 100,
        },{
            header: _('nastixstore_user'),
            dataIndex: 'user',
            sortable: true,
            width: 100,
        },{
            header: _('nastixstore_index'),
            dataIndex: 'index',
            sortable: true,
            width: 100,
        },{
            header: _('nastixstore_region'),
            dataIndex: 'region',
            sortable: true,
            width: 100,
        },{
            header: _('nastixstore_settlement'),
            dataIndex: 'settlement',
            sortable: true,
            width: 100,
        },{
            header: _('nastixstore_street'),
            dataIndex: 'street',
            sortable: true,
            width: 100,
        },{
            header: _('nastixstore_house'),
            dataIndex: 'house',
            sortable: true,
            width: 100,
        },{
            header: _('nastixstore_room'),
            dataIndex: 'room',
            sortable: true,
            width: 100,
        }, {
            header: _('nastixstore_grid_actions'),
            dataIndex: 'actions',
            renderer: nastixstore.utils.renderActions,
            sortable: false,
            width: 100,
            id: 'actions'
        }];
    },

    getTopBar: function () {
        return [{
            text: '<i class="icon icon-plus"></i>&nbsp;' + _('nastixstore_create'),
            handler: this.createAddress,
            scope: this
        }, '->', {
            xtype: 'nastixstore-field-search',
            width: 250,
            listeners: {
                search: {
                    fn: function (field) {
                        this._doSearch(field);
                    }, scope: this
                },
                clear: {
                    fn: function (field) {
                        field.setValue('');
                        this._clearSearch();
                    }, scope: this
                },
            }
        }];
    },
});
Ext.reg('nastixstore-grid-address', nastixstore.grid.Address);