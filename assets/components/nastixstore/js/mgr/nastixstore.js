var nastixstore = function (config) {
    config = config || {};
    nastixstore.superclass.constructor.call(this, config);
};
Ext.extend(nastixstore, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('nastixstore', nastixstore);

nastixstore = new nastixstore();