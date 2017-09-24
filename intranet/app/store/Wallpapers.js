Ext.define('Seic.store.Wallpapers', {
    extend: 'Ext.data.TreeStore',
    model: 'Seic.model.WallpaperModel',
    storeId: 'Wallpapers',
    autoLoad: true,
    proxy: {
        type: 'ajax',
        api: {
            read : 'Server/listarWallpapers',
        },
        reader: {
            type: 'json',
            root: 'resultado',
            successProperty: 'success'			
        },
    },

    // bug in extjs4.1 autoLoad is ignored
    // specifying "loaded: true" resolves the problem
    root: {
        expanded: true,
        loaded: true,
    },
});