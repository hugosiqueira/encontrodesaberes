Ext.define('Seic.view.Admin.gridDefinirEventos' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.griddefinireventos',
	id: 'gridDefinirEventos',
    requires: [
		'Ext.toolbar.Paging'
	],
    store: 'UsuarioEventos',
	columns: {
		defaults: {
			menuDisabled: true,
			resizable: false
		},
		items: [
			{	header: "id_usuario_evento",
				dataIndex: 'id_usuario_evento',
				hidden:true
			},
			{ 	xtype: 'checkcolumn',
				header: "#",
				width: 35,
				dataIndex: 'bool_liberado'
				
			},
			{	xtype: 'datecolumn',
				format:'d/m/Y',
				header: "Data de início",
				width: 100,
				dataIndex: 'data_evento_ini',
				align: 'center'
			},
			{	header: "Evento",
				dataIndex: 'tituo',
				flex:1,
				renderer: function(value, metaData, record, rowIdx, colIdx, store) {
					retorno = record.data.sigla + " - " + record.data.titulo;
					metaData.tdAttr = 'data-qtip="' + retorno + '"';
					return retorno;
				}
			}
		]		
	},	
	initComponent: function(a) {
		this.callParent(arguments);
	}
});
