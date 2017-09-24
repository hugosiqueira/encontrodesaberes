Ext.define('Seic.view.Monitoria.gridMonitoria' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modmonitoria_gridMonitoria',
	id: 'modmonitoria_gridMonitoria',
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Ext.ux.form.SearchField'
	],
	plugins: [{
        ptype: 'rowexpander',
        expandOnDblClick: false,
        expandOnEnter: false,
        rowBodyTpl: ['<div><b>Título: </b>{titulo}</div>']
    }],
    store: 'Monitoria',
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
				dataIndex: 'aluno_cpf',
				width: 110,
				align: 'center'
			},
			{	header: "Aluno",
				dataIndex: 'aluno_nome',
				flex:1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Email",
				dataIndex: 'aluno_email',
				flex:0.7,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
				}
			},
			{	header: "Orientador",
				dataIndex: 'orientador_nome',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
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
			},
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
					{	text: 'Verificar',
						iconCls: 'icon-eye',
						itemId: 'btnVerificarMonitoria'
					},
					'-',
					{	xtype: 'searchfield',
						width: 150,
						store: 'Monitoria',
						emptyText: 'Busca rápida...',
						paramName: 'buscaRapida'
					},
					'-',
					{   text: 'Busca avançada',
						iconCls: 'icon-search',
						itemId: 'btnPesquisaAvancada'
					}
				]
			},
			{	xtype: 'toolbar',
				id: 'modmonitoria_toolBarPA',
				region: 'top',
				hidden: true,
				frame: true,
				height: 40,
				style:"background:IndianRed;",
				collapsible: true
			},
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'Monitoria',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum trabalho de monitoria encontrado."
			}
		];
		this.callParent(arguments);
	}
});
