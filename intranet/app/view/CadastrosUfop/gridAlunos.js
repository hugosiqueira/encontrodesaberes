Ext.define('Seic.view.CadastrosUfop.gridAlunos' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modcadufop_gridAlunos',
	id: 'modcadufop_gridAlunos',
	title: 'Alunos',
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Seic.view.CadastrosUfop.formCadAlunos',
		'Ext.ux.form.SearchField'
	],
    store: 'Alunos',
    columns: {
		defaults: {
			menuDisabled: true,
			resizable: false
		},
		items: [
			{	header: "id",
				dataIndex: 'id_aluno',
				hidden:true
			},
			{	header: "Matrícula",
				dataIndex: 'matricula',
				width: 100,
				align: 'center'
			},			
			{	header: "CPF",
				dataIndex: 'cpf',
				width: 110
			},
			{	header: "Nome",
				dataIndex: 'nome',
				flex: 1
			},
			{	header: "Curso",
				dataIndex: 'descricao_curso',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
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
			{	header: "CAINT",
				dataIndex: 'mobilidade_ano_passado',
				align: 'center',
				width: 90,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(record.data.mobilidade_ano_passado){
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
						itemId: 'btnAdicionarAluno'
					},
					{	text: 'Editar',
						iconCls: 'icon-edit',
						itemId: 'btnEditarAluno'
					},
					{	text: 'Apagar',
						iconCls: 'icon-delete',
						itemId: 'btnApagarAluno'
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
						store: 'Alunos',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					},
					'-',
					{   text: 'Busca avançada',
						iconCls: 'icon-search',
						itemId: 'btnPesquisaAvancadaAluno'
					}
				]
			},
			{	xtype: 'toolbar',
				id: 'modcadufop_toolBarAlunoPA',
				region: 'top',
				hidden: true,
				frame: true,
				height: 40,
				style:"background:IndianRed;",
				collapsible: true
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'Alunos',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum registro encontrado."
			}
		];
		this.callParent(arguments);
	}
});
