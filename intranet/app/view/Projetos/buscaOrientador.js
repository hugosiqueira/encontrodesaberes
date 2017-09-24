Ext.define('Seic.view.Projetos.buscaOrientador',{
	extend: 'Ext.window.Window',
	alias: 'widget.modprojetos_buscaoritador',
	title: 'Buscar orientador',
	iconCls: 'projetos-minishortcut',
	width: 600,
	height: 530,
	layout: 'fit',
	constrain: true,
	modal: true,
	resizable: false,

	items:[{
		xtype: 'grid',
		itemId: 'gridOrientador',
		border: false,
		store: 'Projetos.Orientador',
		columns: {
			defaults: {
				menuDisabled: true,
				resizable: false
			},

			items: [{	
				header: 'Nome',
				dataIndex: 'nome',
				flex: 0.65
			},{	
				header: 'CPF',
				dataIndex: 'cpf',
				flex: 0.2
			},{
				header: 'Depart.',
				dataIndex: 'fgk_departamento',
				flex: 0.15
			}]
		}
	}],

	dockedItems: [{
		xtype: 'toolbar',
		dock: 'top',
		border: false,
		items:[{
            xtype: 'searchfield',
            store: 'Projetos.Orientador',
            emptyText: 'Busca rápida...',
            paramName: 'filtro',
            width: 250
        },'->',{
			text: 'Selecionar',
			iconCls: 'icon-check',
			itemId: 'btnAddOrientador',
			disabled: true
		}]
	},{	
		xtype: 'pagingtoolbar',
		dock:'bottom',
		border: false,
		store: 'Projetos.Orientador',
		displayInfo: true,
		displayMsg: 'Exibindo {0} - {1} de {2}',
		emptyMsg: "Nenhum orientador encontrado."
	}]
});