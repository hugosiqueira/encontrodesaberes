Ext.define('Seic.view.Inscritos.gridInscritos' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modinscritos_gridinscritos',
	id: 'modinscritos_gridInscritos',
    requires: [
		'Seic.view.Inscritos.formCadInscritos',
		'Ext.toolbar.Paging',
		'Ext.ux.form.SearchField'
	],
    store: 'Inscritos',
    columns: {
		defaults: {
			menuDisabled: true,
			resizable: false
		},
		items: [
			{	header: "id",
				dataIndex: 'id',
				hidden:true
			},
			{	header: "Nome",
				flex: 1,
				dataIndex: 'nome',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "CPF",
				width: 110,
				align: 'center',
				dataIndex: 'cpf',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Tipo",
				width: 125,
				// align: 'center',
				dataIndex: 'descricao_tipo',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Instituição",
				width: 80,
				align: 'center',
				dataIndex: 'sigla_instituicao',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + record.data.nome_instituicao + '"';
					return record.data.sigla_instituicao;
				}
			},
			{   header: 'Coordenador',
				width: 100,
				align: 'center',
				dataIndex: 'bool_coordenador',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(record.data.bool_coordenador){
						metaData.tdCls = 'icon-check'
					}
					// else{
						// metaData.tdCls = 'icon-none'
					// }
				}
			},
			{   header: 'Revisor',
				width: 75,
				align: 'center',
				dataIndex: 'bool_revisor',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(record.data.bool_revisor){
						metaData.tdCls = 'icon-check'
					}
				}
			},
			{   header: 'Monitoria',
				width: 80,
				align: 'center',
				dataIndex: 'bool_monitoria',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(record.data.bool_monitoria){
						metaData.tdCls = 'icon-check'
					}
				}
			},
			{   header: 'Mobilidade',
				width: 90,
				align: 'center',
				dataIndex: 'mobilidade_ano_passado',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(record.data.mobilidade_ano_passado){
						metaData.tdCls = 'icon-check'
					}
				}
			},
			{   header: 'Pré-cadastro',
				width: 100,
				align: 'center',
				dataIndex: 'bool_temp',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(record.data.bool_temp){
						metaData.tdCls = 'icon-check'
					}
				}
			},
			// {   header: 'PG',
				// width: 50,
				// align: 'center',
				// dataIndex: 'bool_inscricao_paga',
				// renderer: function(value, metaData, record, rowIndex, colIndex, store){
					// if(record.data.bool_inscricao_paga == 1){
						// metaData.tdAttr = 'data-qtip="Pagamento confirmado"';
						// metaData.tdCls = 'icon-boleto_confirmado'
					// }else{
						// metaData.tdAttr = 'data-qtip="Inadimplente"';
						// metaData.tdCls = 'icon-boleto_inadimplente'
					// }
				// }
			// },
			{   header: 'Ativo',
				width: 50,
				align: 'center',
				dataIndex: 'conta_ativada',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(record.data.conta_ativada){
						metaData.tdAttr = 'data-qtip="Conta ativa"';
						metaData.tdCls = 'icon-unlock'
					}
					else{
						metaData.tdAttr = 'data-qtip="Conta inativa"';
						metaData.tdCls = 'icon-lock'
					}
				}
			}
		]
	},
	listeners: {
		render: function(){
			this.getStore().clearFilter();
			// this.getStore().load();
		}
	},
	initComponent: function() {
		this.dockedItems = [
			{	xtype: 'toolbar',
				items: [
					{	text: 'Adicionar',
						iconCls: 'icon-add',
						itemId: 'btnAdicionarInscrito'
					},
					{	text: 'Editar',
						iconCls: 'icon-edit',
						itemId: 'btnEditarInscrito'
					},
					{	text: 'Apagar',
						iconCls: 'icon-delete',
						itemId: 'btnApagarInscrito'
					},
					{	text: 'Ativar conta',
						// itemId: 'btnAtivarInscrito',
						iconCls: 'icon-unlock',
						id: 'modinscritos_btnAtivarInscrito'
					},
					{	xtype: 'splitbutton',
						text: 'Mensagem',
						itemId: 'btnMensagem',
						iconCls: 'icon-email',
						handler: function() {
							this.showMenu();
						},
						menu: new Ext.menu.Menu({
							items: [
								{	text: 'Email',									
									itemId:'itemMensagemEmail'
								},
								{	text: 'SMS',
									iconCls: 'icon-sms',
									itemId:'itemMensagemSMS'
								}
							]
						})
					},
					'-',
					{	xtype: 'searchfield',
						width: 150,
						store: 'Inscritos',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					},
					'-',
					{   text: 'Busca avançada',
						iconCls: 'icon-search',
						itemId: 'btnBuscaAvancada'
					},{  
						text: 'Etiquetas',
						iconCls: 'icon-print',
						itemId: 'btnPrintEtiquetas'
					},'->',{
			            text: 'Exportar',
			            itemId: 'btnExport',
			            iconCls: 'icon-excel'
			        },
					{   text: 'Logar como...',
						iconCls: 'icon-login_as',
						id: 'modinscritos_btnLogarComo',
						disabled: true
					},

				]
			},
			{	xtype: 'toolbar',
				id: 'modinscritos_toolBarPA',
				region: 'top',
				hidden: true,
				frame: true,
				height: 40,
				style:"background:IndianRed;",
				collapsible: true
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'Inscritos',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum inscrito encontrado."
			}
		];
		this.callParent(arguments);
	}
});
