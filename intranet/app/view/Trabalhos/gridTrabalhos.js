Ext.define('Seic.view.Trabalhos.gridTrabalhos' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modtrabalhos_gridtrabalhos',
	id: 'modtrabalhos_gridtrabalhos',
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Ext.ux.form.SearchField',
		'Seic.view.Trabalhos.formBuscaAvancada'
	],
	plugins: [{
        ptype: 'rowexpander',
        expandOnDblClick: false,
        expandOnEnter: false,
        rowBodyTpl: ['<div><b>Título: </b>{titulo_enviado}</div>']
    }],
    store: 'Trabalhos',
    columns: {
		defaults: {
			menuDisabled: true,
			resizable: false
		},
		items: [
		// Sequência das colunas: | Apresentação (img) | Obrigatório (img) | Situação (img)
			{	header: "id",
				dataIndex: 'id',
				hidden:true
			},
			{	header: "Categoria",
				dataIndex: 'sigla_categoria',
				width: 80,
				align: 'center',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + record.data.descricao_categoria + '"';
					return value;
				}
			},
			{	header: "Autores",
				dataIndex: 'todos_autores',
				flex: 1.5,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + record.data.todos_autores + '"';
					return value;
				}
			},
			{	header: "Orientador",
				dataIndex: 'orientador',
				flex: 1.5,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Área",
				dataIndex: 'codigo_area',
				width: 60,
				align: 'center',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + record.data.descricao_area + '"';
					return value;
				}
			},
			{	header: "Instituição",
				dataIndex: 'sigla',
				width: 110,
				align: 'center',
				// renderer: function(value, metaData, record, rowIndex, colIndex, store){
				// 	if(value == 1){
				// 		metaData.tdAttr = 'data-qtip="Apresentação em poster."';
				// 		metaData.tdCls = 'icon-apresentacao_poster';
				// 	}
				// 	else if(value == 2){
				// 		metaData.tdAttr = 'data-qtip="Apresentação oral."';
				// 		metaData.tdCls = 'icon-apresentacao_oral';
				// 	}
				// }
			},
			{	header: "Obrigatório",
				dataIndex: 'apresentacao_obrigatoria',
				width: 100,
				align: 'center',
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					if(value){
						metaData.tdAttr = 'data-qtip="Apresentação obrigatória."';
						metaData.tdCls = 'icon-check';
					}else{
						metaData.tdAttr = 'data-qtip="Apresentação não obrigatória."';
						metaData.tdCls = 'icon-none';
					}
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
					else if(value == 17)
						metaData.tdCls = 'icon-naoapresentado';
				}
			},{   
	            header: 'Projeto',
	            dataIndex: 'fgk_projeto',
	            width: 60,
	            renderer: function(value, metaData, record, rowIndex, colIndex, store){
	                if(value){
	                    metaData.tdAttr = 'data-qtip="Contém projeto relacionado."';
	                    metaData.tdCls = 'projetos-minishortcut';
	                }else{
	                    metaData.tdAttr = 'data-qtip="Não contém projeto relacionado."';
	                    metaData.tdCls = 'icon-none';
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
					{	text: 'Desalocar',
						iconCls: 'icon-designado',
						disabled: true,
						id: 'btnDesalocarTrabalho'
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
					{	xtype: 'searchfield',
						width: 200,
						store: 'Trabalhos',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					},
					'-',
					{   text: 'Busca avançada',
						iconCls: 'icon-search',
						itemId: 'btnPesquisaAvancada'
					},'->',
					{   text: 'Exportar',
			            itemId: 'btnExport',
			            iconCls: 'icon-excel'
			        },
				]
			},
			{	xtype: 'toolbar',
				id: 'modtrabalhos_toolBarPA',
				region: 'top',
				hidden: true,
				frame: true,
				height: 40,
				style:"background:IndianRed;",
				collapsible: true
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'Trabalhos',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum trabalho encontrado."
			}
		];
		this.callParent(arguments);
	}
});
