nastixstore.grid.Status = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'nastixstore-grid-status';
    }
    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/status/getlist'
        },
        stateful: true,
    });
    nastixstore.grid.Status.superclass.constructor.call(this, config);

    // Clear selection on grid refresh
    this.store.on('load', function () {
        if (this._getSelectedIds().length) {
            this.getSelectionModel().clearSelections();
        }
    }, this);
};
Ext.extend(nastixstore.grid.Status, nastixstore.grid.Default, {
    getListeners: function () {
        return {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateStatus(grid, e, row);
            },
        };
    },
    createStatus: function (btn, e) {
        var w = Ext.getCmp('nastixstore-window-status-create');
        if (w) {
            w.hide().getEl().remove();
        }

        w = MODx.load({
            xtype: 'nastixstore-window-status-create',
            id: 'nastixstore-window-status-create',
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

    updateStatus: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }

        var w = Ext.getCmp('nastixstore-window-status-update');
        if (w) {
            w.close();
        }
        w = MODx.load({
            xtype: 'nastixstore-window-status-update',
            id: 'nastixstore-window-status-update',
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

    removeStatus: function () {
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
                action: 'mgr/status/remove',
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
        return ['id', 'name', 'actions'];
    },

    getColumns: function () {
        return [{
            header: _('nastixstore_id'),
            dataIndex: 'id',
            sortable: true,
            width: 100,
        },{
            header: _('nastixstore_name'),
            dataIndex: 'name',
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
            handler: this.createStatus,
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
Ext.reg('nastixstore-grid-status', nastixstore.grid.Status);