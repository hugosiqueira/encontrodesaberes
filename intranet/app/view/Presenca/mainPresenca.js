Ext.define('Seic.view.Presenca.mainPresenca',{
	extend: 'Ext.panel.Panel',
	id: 'modpre_mainpresenca',
	alias: 'widget.modpre_mainpresenca',
	bodyBorder: false,
	layout: 'vbox',

	items: [{
		layout: 'hbox',
		dock: 'top',
		border: false,
		items: [{
			xtype: 'numberfield',
			fieldLabel: 'Código da credencial',
			labelAlign: 'top',
			itemId: 'codcred',
			width: 150,
			maxValue: 9999999999,
	        minValue: 0,
	        hideTrigger: true,
	        keyNavEnabled: false,
	        mouseWheelEnabled: false,
	        regex: (/^[0-9]*/),
	        height: 60,
            width: 250,
            padding: '0 0 15 50',// (top, right, bottom, left).
			fieldStyle: {
                'font-weight': 'bold',
                'fontSize': '40px',
                'text-align': 'center',
            }
		},{
			xtype: 'displayfield',
			labelAlign: 'top',
			itemId: 'nome_local',
			value: 'Sem local definido',
			padding: '25 0 0 25',// (top, right, bottom, left).
			border: false,
			width: 420,
			fieldStyle: {
	            'font-weight': 'bold',
	            'fontSize': '20px',
	            'color': '#3892D3',
	            'text-align': 'center'
	        }
		},{
		xtype: 'hiddenfield',
		itemId: 'id_local'
		}]
	},{
		xtype: 'panel',
		flex: 0.8,
		header: false,
		border: false,
		layout: 'fit',
		width: 798,
		items: [{
			xtype: 'grid',
			itemId: 'gridPresencas',
			border: false,
			store: 'Seic.store.Presenca.Inscritos',
			columns: [{
		    	xtype: 'datecolumn',
		    	text: 'Data - Hora',
		    	dataIndex: 'datahora_presenca',
		    	format: 'd/m/Y - H:i:s',
		    	flex: 0.25
		    },{
		        text: 'Nome',
		        dataIndex: 'nome',
		        flex: 0.4
		    },{
		        text: 'informação',
		        dataIndex: 'info_credencial',
		        flex: 0.35
		    }]
		}]
	}],

	dockedItems: [{
        xtype: 'toolbar',
        dock: 'top',
        items: [{
        	text: 'Estatísticas',
        	itemId: 'infoCheckpoints',
        	iconCls: 'icon-chart'
        },'->',{
            xtype: 'searchfield',
            store: 'Seic.store.Presenca.Inscritos',
            emptyText: 'Busca rápida...',
            paramName: 'filtro',
            width: 250
        },{
            text: 'Busca avançada',
            itemId: 'BA_presencas',
            width: 140
        }]
    },{
        xtype: 'toolbar',
        id: 'modpre_barraBusca',
        dock: 'top',
        hidden: true,
        style: {
            background: '#FF6666'
        }
    },{  
        xtype: 'pagingtoolbar',
        id: 'modpre_paggingPresenca',
        dock: 'bottom',
        store: 'Seic.store.Presenca.Inscritos',
        displayInfo: true,
        displayMsg: 'Exibindo {0} - {1} de {2} inscritos',
        emptyMsg: 'Nenhum inscrito encontrado.',
        hidden: true
    }]
});