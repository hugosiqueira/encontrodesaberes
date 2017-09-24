Ext.define('Seic.view.Admin.gridGruposPermissoes' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.gridgrupospermissoes',
	id: 'gridGruposPermissoes',
    requires: [
		'Ext.toolbar.Paging'
		,'Seic.store.Admin.GruposPermissoes'
	],
	title: 'Permissões',
    store: 'GruposPermissoes',
	columns: {
		defaults: {
			menuDisabled: true,
			resizable: false
		},
		items: [
			{	header: "id_permissao",
				dataIndex: 'id_permissao',
				hidden:true
			},
			{ 	xtype: 'checkcolumn',
				header: "#",
				width: 35,
				dataIndex: 'bool_liberado'
				
			},
			{	header: "Permissão",
				dataIndex: 'permissao',
				flex:1,
				renderer: function(value, metaData, record, rowIdx, colIdx, store) {
					metaData.tdAttr = 'data-qtip="' + record.data.descricao_permissao + '"';
					return value;
				}
			}
		]		
	},
	listeners: {
		render: function(){
			this.getStore().load({
				params:{
					id_grupo: 0,
					id_modulo: 0
				}
			});			
		}
	},	
	initComponent: function(a) {
		this.callParent(arguments);
	}
});
