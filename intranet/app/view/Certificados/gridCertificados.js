Ext.define('Seic.view.Certificados.gridCertificados' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modcertificados_gridCertificados',
	id: 'modcertificados_gridCertificados',
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Ext.ux.form.SearchField'
	],
    store: 'Certificados',
    columns: {
		defaults: {
			menuDisabled: true,
			resizable: false
		},
		items: [
			{	header: "id_certificado",
				dataIndex: 'id_certificado',
				hidden:true
			},
			{	xtype: 'datecolumn',
				format:'d/m/Y H:i:s',
				header: "Emissão",
				width: 140,
				dataIndex: 'data_emissao',
				align: 'center'
			},
			{	header: "CPF",
				dataIndex: 'cpf',
				align: 'center',
				width: 120
			},
			{	header: "Nome",
				dataIndex: 'nome',
				flex:1.5,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Email",
				dataIndex: 'email',
				flex:1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Tipo",
				dataIndex: 'descricao_certificado',
				flex: 1
			},
		]
	},
	listeners: {
		render: function(){
			this.getStore().clearFilter();
		}
	},
	initComponent: function() {
		this.dockedItems = [
			{	xtype: 'toolbar',
				items: [
					{	text: 'Adicionar',
						iconCls: 'icon-add',
						itemId: 'btnAdicionarCertificado'
					},
					{	text: 'Editar',
						iconCls: 'icon-edit',
						itemId: 'btnEditarCertificado'
					},
					{	text: 'Apagar',
						iconCls: 'icon-delete',
						itemId: 'btnApagarCertificado'
					},
					{	text: 'Enviar email',
						iconCls: 'icon-email',
						itemId: 'btnEnviarEmail'
					},
					{	text: 'Visualizar',
						iconCls: 'icon-eye',
						itemId: 'btnVisualizarCertificado'
					},
					'-',
					{	xtype: 'searchfield',
						width: 150,
						store: 'Certificados',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					}
				]
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'Certificados',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum certificado encontrado."
			}
		];
		this.callParent(arguments);
	}
});
