Ext.define('Seic.view.Projetos.buscaAluno',{
	extend: 'Ext.window.Window',
	alias: 'widget.modprojetos_buscaaluno',
	title: 'Buscar aluno',
	iconCls: 'projetos-minishortcut',
	width: 800,
	height: 530,
	layout: 'fit',
	constrain: true,
	modal: true,
	resizable: false,

	items:[{
		xtype: 'grid',
		itemId: 'gridAluno',
		border: false,
		store: 'Projetos.Aluno',
		columns: {
			defaults: {
				menuDisabled: true,
				resizable: false
			},

			items: [{	
				header: 'Nome',
				dataIndex: 'nome',
				flex: 0.4
			},{	
				header: 'CPF',
				dataIndex: 'cpf',
				flex: 0.2
			},{
				header: 'Curso',
				dataIndex: 'descricao_curso',
				flex: 0.2
			}]
		}
	}],

	dockedItems: [{
		xtype: 'toolbar',
		dock: 'top',
		border: false,
		items:[{
            xtype: 'searchfield',
            store: 'Projetos.Aluno',
            emptyText: 'Busca rápida...',
            paramName: 'filtro',
            width: 250
        },'->',{
			text: 'Selecionar',
			iconCls: 'icon-check',
			itemId: 'btnAddAluno',
			disabled: true
		}]
	},{	
		xtype: 'pagingtoolbar',
		dock:'bottom',
		border: false,
		store: 'Projetos.Aluno',
		displayInfo: true,
		displayMsg: 'Exibindo {0} - {1} de {2}',
		emptyMsg: "Nenhum orientador encontrado."
	}]
});