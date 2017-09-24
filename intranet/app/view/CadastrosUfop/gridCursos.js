Ext.define('Seic.view.CadastrosUfop.gridCursos' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.modcadufop_gridCursos',
	id: 'modcadufop_gridCursos',
	title: 'Cursos',
	emptyText: "<img src='resources/css/icons/grid-vazio.png' class='gridVazio' id='gidvazio'></div>",
    requires: [
		'Ext.toolbar.Paging',
		'Ext.ux.form.SearchField'
	],
    store: 'Cursos',
    columns: {
		defaults: {
			menuDisabled: true,
			resizable: false
		},
		items: [
			{	header: "id",
				dataIndex: 'id_curso',
				hidden:true
			},
			{	header: "Departamento",
				dataIndex: 'fgk_departamento',
				width: 100,
				align: 'center'
			},			
			{	header: "Codigo",
				dataIndex: 'codigo',
				align: 'center',
				width: 100
			},
			{	header: "Curso",
				dataIndex: 'descricao_curso',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + record.data.descricao_curso + '"';
					return value;
				}
			},
			{	header: "Área específica",
				dataIndex: 'descricao_area_especifica',
				flex: 1,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + record.data.descricao_area_especifica + '"';
					return value;
				}
			},
			{	header: "Modalidade",
				dataIndex: 'modalidade',
				align: 'center',
				width: 140,
				renderer: function(value, metaData, record, rowIndex, colIndex, store){
					metaData.tdAttr = 'data-qtip="' + value + '"';
					return value;
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
						itemId: 'btnAdicionarCurso'
					},
					{	text: 'Editar',
						iconCls: 'icon-edit',
						itemId: 'btnEditarCurso'
					},
					{	text: 'Apagar',
						iconCls: 'icon-delete',
						itemId: 'btnApagarCurso'
					},
					'-',
					{	xtype: 'searchfield',
						width: 200,
						store: 'Cursos',
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
			// {	xtype: 'toolbar',
				// id: 'modcadufop_toolBarAlunos',
				// region: 'top',
				// hidden: true,
				// frame: true,
				// height: 40,
				// style:"background:IndianRed;",
				// collapsible: true
			// },
			{	xtype: 'pagingtoolbar',
				dock:'bottom',
				store: 'Cursos',
				displayInfo: true,
				displayMsg: 'Exibindo {0} - {1} de {2}',
				emptyMsg: "Nenhum registro encontrado."
			}
		];
		this.callParent(arguments);
	}
});
