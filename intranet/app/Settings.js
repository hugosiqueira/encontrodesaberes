/*!
 * Ext JS Library 4.0
 * Copyright(c) 2006-2011 Sencha Inc.
 * licensing@sencha.com
 * http://www.sencha.com/license
 */

Ext.define('Seic.Settings', {
    extend: 'Ext.window.Window',
	 // requires: [
		// 'Seic.store.Wallpapers'
	// ],
    uses: [
        'Ext.tree.Panel',
        'Ext.tree.View',
        'Ext.form.field.Checkbox',
        'Ext.layout.container.Anchor',
        'Ext.layout.container.Border',
        'Ext.ux.desktop.Wallpaper',
        'Seic.store.Wallpapers'
    ],

    layout: 'anchor',
    title: 'Definir tema',
    modal: true,
    width: 640,
    height: 480,
    border: false,

    initComponent: function () {
        var me = this;

        // me.selected = me.desktop.getWallpaper();
        // me.stretch = me.desktop.wallpaper.stretch;

        me.preview = Ext.create('widget.wallpaper');
        me.preview.setWallpaper(me.selected);
        me.tree = me.createTree();

        me.buttons = [
            { text: 'Salvar', iconCls: 'icon_salvar', handler: me.onOK, scope: me },
            { text: 'Cancelar',iconCls: 'icon_cancelar', handler: me.close, scope: me }
        ];

        me.items = [
            {
                anchor: '0 -30',
                border: false,
                layout: 'border',
                items: [
                    me.tree,
                    {   xtype: 'panel',
                        title: 'Wallpaper',
                        region: 'center',
                        layout: 'fit',
                        items: [ me.preview ]
                    }
                ]
            }			
        ];
        me.callParent();
    },

    createTree : function() {
        var me = this;

        var tree = new Ext.tree.Panel({
            title: 'Temas',
            rootVisible: false,
			id: 'treeWallpaper',
            lines: false,
            autoScroll: true,
            width: 150,
            region: 'west',
            split: true,
            minWidth: 130,
            listeners: {
                select: this.onSelect,
                scope: this
            },
            store: //'Wallpapers'
				new Ext.data.TreeStore({
					model: 'Seic.model.WallpaperModel',
					storeId: 'Wallpapers',
					autoLoad: true,
					proxy: {
						type: 'ajax',
						api: {
							read : 'Server/listarWallpapers.php',
						},
						reader: {
							type: 'json',
							root: 'resultado',
							successProperty: 'success'			
						},
					}					
				})
        });

        return tree;
    },

    getTextOfWallpaper: function (path) {
        var text = path, slash = path.lastIndexOf('/');
        if (slash >= 0) {
            text = text.substring(slash+1);
        }
        var dot = text.lastIndexOf('.');
        text = Ext.String.capitalize(text.substring(0, dot));
        text = text.replace(/[-]/g, ' ');
        return text;
    },

    onOK: function (button) {
		win		= button.up('window');
		tree   	= win.down('treepanel');		
		grid = Ext.getCmp('gridGrupos');
		var row = grid.getSelectionModel().getSelection()[0];
		var sm = tree.getSelectionModel();
        var sel = sm.getSelection();
		if(sm){
			Ext.Ajax.request({
				waitMsg: 'Aguarde...',
				url: 'Server/admin/alterarTema.php', 
				params: {	id_tema: sel[0].data.id_tema, id_grupo: row.data.id_grupo	},
				disableCaching: false ,
				success: function (res) {
					if(Ext.JSON.decode(res.responseText).success){
						Ext.Msg.alert('Sucesso', Ext.JSON.decode(res.responseText).msg);
					}
					else{
						Ext.Msg.alert('Falha', Ext.JSON.decode(res.responseText).msg);
					}
				}
			});
			this.destroy();
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um grupo para alterar o tema.',
			    buttons: Ext.Msg.OK
			});
		}
    },

    onSelect: function (tree, record) {
        var me = this;

        if (record.data.arquivo) {
            me.selected = 'resources/wallpapers/' + record.data.arquivo;
        } else {
            me.selected = Ext.BLANK_IMAGE_URL;
        }

        me.preview.setWallpaper(me.selected);
    },

    setInitialSelection: function () {
        var s = this.desktop.getWallpaper();
        if (s) {
            var path = '/Wallpaper/' + this.getTextOfWallpaper(s);
            this.tree.selectPath(path, 'text');
        }
    }
});
