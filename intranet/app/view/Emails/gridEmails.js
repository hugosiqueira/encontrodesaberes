Ext.define('Seic.view.Emails.gridEmails' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modemails_gridEmails',
	id: 'modemails_gridEmails',
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Ext.ux.form.SearchField',
		'Seic.view.Emails.formCadEmail'
	],
    store: 'Emails',
    columns: {
		defaults: {
			menuDisabled: true,
			resizable: false
		},
		items: [
			{	header: "id_email",
				dataIndex: 'id_email',
				hidden:true
			},
			{	xtype: 'datecolumn',
				format:'d/m/Y H:i:s',
				header: "Enviado",
				width: 140,
				dataIndex: 'datahora_envio',
				align: 'center'
			},
			// {	header: "Categoria",
				// dataIndex: 'categoria',
				// flex: 1,
				// renderer: function(value, metaData, record, rowIndex, colIndex, store){
					// metaData.tdAttr = 'data-qtip="' + record.data.categoria + '"';
					// return value;
				// }
			// },
			{	header: "Nome",
				dataIndex: 'nome_destinatario',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + record.data.nome_destinatario + '"';
					return value;
				}
			},
			{	header: "Email",
				dataIndex: 'email_destinatario',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Assunto",
				dataIndex: 'assunto',
				flex: 1.5,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + record.data.assunto + '"';
					return value;
				}
			}
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
					{	text: 'Verificar email',
						iconCls: 'icon-eye',
						itemId: 'btnVerificarEmail'
					},'-',
					{	xtype: 'searchfield',
						width: 150,
						store: 'Emails',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					}
				]
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'Emails',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum email encontrado."
			}
		];
		this.callParent(arguments);
	}
});
