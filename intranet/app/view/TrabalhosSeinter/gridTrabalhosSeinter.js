Ext.define('Seic.view.TrabalhosSeinter.gridTrabalhosSeinter' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modtrabalhosseinter_gridtrabalhosseinter',
	id: 'modtrabalhosseinter_gridtrabalhosSeinter',
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Seic.view.TrabalhosSeinter.formCadTrabalhosSeinter',
		'Ext.ux.form.SearchField'
	],
    store: 'TrabalhosSeinter',
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

			{	header: "CPF",
				dataIndex: 'cpf',
				align: 'center',
				width: 110
			},
			{	header: "Nome",
				dataIndex: 'nome_aluno',
				flex: 1
			},
			{	header: "País destino",
				dataIndex: 'pais_destino',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Tipo",
				dataIndex: 'tipo_mobilidade',
				flex: 0.75,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(value == 1)
						return "Ciência sem Fronteiras";
					else
						return "Mobilidade CAINT";
				}
			},
			{	header: "Afastamento",
				dataIndex: 'tempo_afastamento',
				align: 'center',
				width: 100,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					retorno = "";
					if(value == 1)
						retorno = value + " mês";
					else if (value > 1)
						retorno = value + " meses";
					metaData.tdAttr = 'data-qtip="' + retorno + '"';
					return retorno;
				}
			},
			{	header: "Situação",
				dataIndex: 'fgk_status',
				width: 80,
				align: 'center',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="'+record.data.descricao_status+'."';
					if(value == 1)
						metaData.tdCls = 'icon-aguardando_submissao';
					else if(value == 2)
						metaData.tdCls = 'icon-submetido';
					else if(value == 3)
						metaData.tdCls = 'icon-designado';
					else if(value == 6)
						metaData.tdCls = 'icon-aprovado';
					else if(value == 7)
						metaData.tdCls = 'icon-aprovado_restricoes';
					else if(value == 8)
						metaData.tdCls = 'icon-reprovado'
					else if(value == 9)
						metaData.tdCls = 'icon-edit';
					else if(value == 10)
						metaData.tdCls = 'icon-justificativa_enviada';
					else if(value == 11)
						metaData.tdCls = 'icon-justificativa_aceita';
					else if(value == 12)
						metaData.tdCls = 'icon-justificativa_rejeitada';
					else if(value == 13)
						metaData.tdCls = 'icon-aprovado_restricoes';
					else if(value == 14)
						metaData.tdCls = 'icon-aprovado';
					else if(value == 15)
						metaData.tdCls = 'icon-reprovado';
					else if(value == 16)
						metaData.tdCls = 'icon-trabalho_apresentado';
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
						itemId: 'btnAdicionarTrabalho'
					},
					{	text: 'Editar',
						iconCls: 'icon-edit',
						itemId: 'btnEditarTrabalho'
					},
					{	text: 'Apagar',
						iconCls: 'icon-delete',
						itemId: 'btnApagarTrabalho'
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
						width: 200,
						store: 'TrabalhosSeinter',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					},
					'-',
					{   text: 'Busca avançada',
						iconCls: 'icon-search',
						itemId: 'btnPesquisaAvancada'
					},'->',{
			            text: 'Exportar',
			            itemId: 'btnExport',
			            iconCls: 'icon-excel'
			        }
				]
			},
			{	xtype: 'toolbar',
				id: 'modtrabalhosseinter_toolBarPA',
				region: 'top',
				hidden: true,
				frame: true,
				height: 40,
				style:"background:IndianRed;",
				collapsible: true
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'TrabalhosSeinter',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum inscrito encontrado."
			}
		];
		this.callParent(arguments);
	}
});
