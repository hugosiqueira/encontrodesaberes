Ext.define('Seic.view.CadastrosUfop.gridProfessoresTA' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modcadufop_gridProfessoresTA',
	id: 'modcadufop_gridProfessoresTA',
	title: 'Professores/TA',
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Ext.ux.form.SearchField'
	],
    store: 'ProfessoresTA',
    columns: {
		defaults: {
			menuDisabled: true,
			resizable: false
		},
		items: [
			{	header: "id",
				dataIndex: 'id_professor',
				hidden:true
			},
			{	header: "Cód. Siape",
				dataIndex: 'cod_siape',
				width: 90,
				align: 'center'
			},
			{	header: "CPF",
				dataIndex: 'cpf',
				width: 110,
				align: 'center'
			},
			{	header: "Nome",
				dataIndex: 'nome',
				flex: 1
			},
			{	header: "Tipo",
				dataIndex: 'fgk_tipo',
				width: 170,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(record.data.fgk_tipo == 1){
						return "Professor";
					}else{
						return "Técnico administrativo";
					}
				}
			},
			{	header: "Departamento",
				dataIndex: 'fgk_departamento',
				align: 'center',
				width: 100,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Avaliador",
				dataIndex: 'bool_avaliador',
				width: 90,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(record.data.bool_avaliador){
						metaData.tdCls = 'icon-check'
					}
				}
			},
			{	header: "Monitoria",
				dataIndex: 'bool_monitoria',
				align: 'center',
				width: 85,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(value){
						metaData.tdCls = 'icon-check'
					}
				}
			},
			{	header: "Coordenador",
				dataIndex: 'bool_coordenador',
				width: 100,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(record.data.bool_coordenador){
						metaData.tdCls = 'icon-check'
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
						itemId: 'btnAdicionarProfessorTA'
					},
					{	text: 'Editar',
						iconCls: 'icon-edit',
						itemId: 'btnEditarProfessorTA'
					},
					{	text: 'Apagar',
						iconCls: 'icon-delete',
						itemId: 'btnApagarProfessorTA'
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
						store: 'ProfessoresTA',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					},
					'-',
					// {   text: 'Busca avançada',
						// iconCls: 'icon-search',
						// itemId: 'btnPesquisaAvancada'
					// }
				]
			},
			{	xtype: 'toolbar',
				id: 'modcadufop_toolBarPA',
				region: 'top',
				hidden: true,
				frame: true,
				height: 40,
				style:"background:IndianRed;",
				collapsible: true
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'ProfessoresTA',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum registro encontrado."
			}
		];
		this.callParent(arguments);
	}
});
