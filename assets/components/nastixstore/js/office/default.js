Ext.onReady(function () {
    nastixstore.config.connector_url = OfficeConfig.actionUrl;

    var grid = new nastixstore.panel.Home();
    grid.render('office-nastixstore-wrapper');

    var preloader = document.getElementById('office-preloader');
    if (preloader) {
        preloader.parentNode.removeChild(preloader);
    }
});