Ext.define('Seic.view.Admin.viewUsuariosVinculados',{
	extend: 'Ext.window.Window',
	alias: 'widget.modadmin_viewusuariosvinculados',
	title: 'Selecione o usuário',
	iconCls: 'presenca-minishortcut',
	constrain: true,
	resizable: false,
	modal: true,
	width: 300,
	height: 300,
	bodyBorder: false,

    items:[{
    	xtype: 'gridpanel',
		border: false,
		store: 'UsuariosDoEvento',
		columns: [{
			text: 'Nome',
			dataIndex: 'nome_usuario',
			menuDisabled: true,
			resizable: false,
			flex: 1
		}],
		listeners: {
			render: function(){
				var row = Ext.getCmp('gridEventos').getSelectionModel().getSelection()[0];
				this.getStore().load({
					params:{
						id_evento: row.data.id
					}
				});
			}
		}
	},],

    dockedItems:[{
		xtype: 'toolbar',
		dock: 'bottom',
		layout:{
            pack: 'center'
        },
		items: [{
			text: 'Selecionar',
			itemId: 'okSelect',
			iconCls: 'icon-check'
		}]
	}]
});