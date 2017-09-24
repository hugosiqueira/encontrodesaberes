Ext.define('Seic.controller.Monitoria', {
    extend: 'Ext.app.Controller',
    stores: [
		'Monitoria.Monitoria'
	],
    views: [
		'Monitoria.gridMonitoria',
		'Monitoria.formCadMonitoria'
	],

    init: function() {
		Ext.create('Seic.store.Monitoria.Monitoria');
		this.control({
			'modmonitoria_gridMonitoria button#btnVerificarMonitoria': {
				click: this.verificarMonitoria
            },
			'modmonitoria_gridMonitoria dataview': {
                itemdblclick: this.verificarMonitoriaGrid
            },
			'modmonitoria_gridMonitoria button#btnPesquisaAvancada': {
            	click: this.pesquisaAvancada
            },
			'modmonitoria_formBuscaAvancada button#btnBuscaAvancada': {
                click: this.pesquisarMonitoria
            },
			'modmonitoria_gridMonitoria button#modmonitoria_btnLimparBusca': {
            	click : this.limparBuscaAvancada
            },
		});
    },
	limparBuscaAvancada: function(button) {
		Ext.getCmp('modmonitoria_toolBarPA').hide();
		Ext.getCmp('modmonitoria_btnLimparBusca').hide();
		Ext.getCmp('modmonitoria_formBuscaAvancada').close();
		var gridMonitoria = Ext.getCmp('modmonitoria_gridMonitoria');
		gridMonitoria.getStore().getProxy().extraParams = {};
		gridMonitoria.getStore().load();
    },
	pesquisarMonitoria: function(button){
		win    = button.up('window'),
		form   = win.down('form'),
		values = form.getValues();

		gridMonitoria = Ext.getCmp('modmonitoria_gridMonitoria');
		gridMonitoria.getStore().getProxy().extraParams = {
			pa				: '1',
			aluno_nome		: values.aluno_nome,
			aluno_cpf		: values.aluno_cpf,
			orientador_nome	: values.orientador_nome,
			orientador_cpf	: values.orientador_cpf,
			fgk_status		: values.fgk_status
		};
		gridMonitoria.getStore().loadPage(1);

		var toolBar = Ext.getCmp("modmonitoria_toolBarPA");
		toolBar.removeAll();
		toolBar.show();
		toolBar.add(
			{	xtype: 'label',
				text: 'Filtros aplicados: ',
				margin: '0 10 0 5',
				style:"color:white;font-weight:bold;"
			}
		);
		if(values.aluno_nome!=""){
			texto = "Nome aluno";
			toolBar.add({xtype:'button',text: texto});
		}
		if(values.aluno_cpf!=""){
			texto = "CPF aluno";
			toolBar.add({xtype:'button',text: texto});
		}
		if(values.orientador_nome!=""){
			texto = "Nome orientador";
			toolBar.add({xtype:'button',text: texto});
		}
		if(values.orientador_cpf!=""){
			texto = "CPF oridentador";
			toolBar.add({xtype:'button',text: texto});
		}
		if(values.fgk_status!=""){
			texto = "Situação";
			toolBar.add({xtype:'button',text: texto});
		}
		toolBar.add('->');
		toolBar.add(
			{	text: 'Cancelar',
				iconCls: 'icon-clear',
				id: 'modmonitoria_btnLimparBusca'
			}
		);
		win.hide();
	},
	pesquisaAvancada: function(button) {
		var win = Ext.getCmp('modmonitoria_formBuscaAvancada');
		if (!win)
			Ext.create('Seic.view.Monitoria.formBuscaAvancada');
		else
			win.show();
		Ext.getCmp('modmonitoria_comboStatus-PA').getStore().load();
	},
	verificarMonitoriaGrid: function(grid, record) {
		var win = Ext.create('Seic.view.Monitoria.formCadMonitoria').show();
		win.setTitle('Trabalho de monitoria');
		win.down('form').loadRecord(record);
	},
	verificarMonitoria: function(button) {
		var grid = button.up('grid');
		if(grid.getSelectionModel().hasSelection()){
			var row = grid.getSelectionModel().getSelection()[0];
			var win = Ext.create('Seic.view.Monitoria.formCadMonitoria').show();
			win.setTitle('Trabalho de monitoria');
			win.down('form').loadRecord(row);
		}
		else{
			Ext.Msg.alert({
			    title: 'Atenção',
			    msg: 'Selecione um trabalho para verificar.',
			    buttons: Ext.Msg.OK,
				icon:   Ext.MessageBox.WARNING
			});
		}
	},
});
