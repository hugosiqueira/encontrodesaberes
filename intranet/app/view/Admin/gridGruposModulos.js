Ext.define('Seic.view.Admin.gridGruposModulos' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.gridgruposmodulos',
	id: 'gridGruposModulos',
    requires: [
		'Ext.toolbar.Paging'
		,'Seic.store.Admin.GruposModulos'
	],
	title: 'Módulos',
    store: 'GruposModulos',
	columns: {
		defaults: {
			menuDisabled: true,
			resizable: false
		},
		items: [
			{	header: "id_modulo",
				dataIndex: 'id_modulo',
				hidden:true
			},
			{ 	xtype: 'checkcolumn',
				header: "#",
				width: 35,
				disabled: false,
				dataIndex: 'bool_liberado'
			},
			{	header: "Módulo",
				dataIndex: 'nome_modulo',
				flex:1
			}
		]
	},
	listeners: {
		render: function(){
			var row = Ext.getCmp('gridGrupos').getSelectionModel().getSelection()[0];
			this.getStore().load({
				params:{
					id_grupo: row.data.id_grupo
				}
			});
		}
	},
	initComponent: function(a) {
		this.callParent(arguments);
	}
});
