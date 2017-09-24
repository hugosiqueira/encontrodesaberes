Ext.define('Seic.view.Presenca.buscaAvancada',{
	extend: 'Ext.window.Window',
    id: 'modpre_modpre_buscavancada',
	alias: 'widget.modpre_buscavancada',
	height: 238,
	width: 300,
	title: 'Busca avaçada',
	iconCls: 'presenca-minishortcut',
	constrain: true,
	resizable: false,
	closable: true,
	modal: true,
	layout: 'anchor',
	bodyPadding: 8,
	bodyBorder: false,
	items: [{
		xtype: 'form',
		border: false,
		items: [{
			xtype: 'textfield',
            fieldLabel: 'Nome',
            name: 'nome',
            labelAlign: 'top',
            labelWidth: 35,
            anchor: '100%'
		},{   
            xtype: 'combobox',
            fieldLabel: 'Local (checkpoint)',
            name: 'id_checkpoint',
            queryMode: 'remote',
            queryParam: 'filtro',
            labelWidth: 40,
            store: 'Seic.store.Presenca.Checkpoints',
            valueField: 'id_local_presenca',
            displayField: 'descricao_local',
            forceSelection: true,
            editable: true,
            labelAlign: 'top',
            anchor: '100%'
        },{
            xtype: 'label',
            text: 'Data:',
            padding: '12 0 0 0'
        },{
            layout: 'hbox',
            border: false,
            padding: '5 0 0 15',
            anchor: '100%',
            items: [{
                xtype: 'datefield',
                name: 'dateMin',
                fieldLabel: 'entre',
                format:'d/m',
                submitFormat: 'Y-m-d',
                fieldStyle: 'text-align: center',
                labelWidth: 35,
                width: 110,
                padding: '0 0 0 15' //(top, right, bottom, left).
            },{
                xtype: 'datefield',
                name: 'dateMax',
                fieldLabel: 'e',
                format:'d/m',
                submitFormat: 'Y-m-d',
                fieldStyle: 'text-align: center',
                labelWidth: 10,
                width: 85,
                padding: '0 0 0 5' //(top, right, bottom, left).
            }]
        }]
	}],

	dockedItems: [{
		xtype: 'toolbar',
		border: false,
		dock: 'bottom',
		items: ['->',{
			text: 'Buscar',
			itemId: 'busca',
			iconCls: 'icon-search',
			width: 100
		},{
			text: 'Cancelar',
			itemId: 'fechar',
			iconCls: 'icon-cancel',
			width: 100
		}]
	}]
});