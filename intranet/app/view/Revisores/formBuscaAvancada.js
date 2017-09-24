Ext.define('Seic.view.Revisores.formBuscaAvancada', {
    extend: 'Ext.window.Window',
    alias : 'widget.modrevisores_formBuscaAvancada',
	id: 'modrevisores_formBuscaAvancada',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.form.field.ComboBox'
	],
    title : 'Busca avançada',
    layout: 'fit',
    autoShow: true,
    width: 400,
    autoHeight: true,
    modal: true,
    initComponent: function() {
		this.items = [
            {   xtype: 'form',
                border: false,
				padding: '5 5 5 5',
				fieldDefaults: {
					anchor: '100%',
					labelWidth: 55,
					labelAlign: 'left'
				},
				items:[
					{	xtype: 'textfield',
						name: 'nome',
						fieldLabel: 'Nome'
					},
					{	xtype: 'combobox',
						fieldLabel: 'Tipo',
						id: 'modrevisores_comboTipo-PA',
						name: 'fgk_tipo',
						queryMode: 'local',
						allowBlank: true,
						editable: true,
						store: "TipoInscrito",
						typeAhead: true,
						valueField: 'id_tipo_inscrito',
						displayField: 'descricao_tipo',
						triggerAction: 'all',
						minChars:1,
						forceSelection:false,
						anchor: '100%',
						padding: 1,
						flex: 1
					},
					{	xtype: 'combobox',
						fieldLabel: 'Área',
						id: 'modrevisores_comboArea-PA',
						name: 'fgk_area',
						queryMode: 'local',
						allowBlank: true,
						editable: true,
						store: "Area",
						typeAhead: true,
						valueField: 'id_area',
						displayField: 'codigo_area',
						triggerAction: 'all',
						minChars:1,
						forceSelection:false,
						anchor: '100%',
						padding: 1,
						flex: 1,
						listeners: {
							select: function (comboBox, records) {
								comboAreaEspecifica = Ext.getCmp('modrevisores_comboAreaEspecifica-PA');
								comboAreaEspecifica.getStore().getProxy().extraParams = {
									id_area	: comboBox.getValue()
								};
								comboAreaEspecifica.getStore().load();
								comboAreaEspecifica.setValue('');
							}
						}
					},
					{	xtype: 'combobox',
						fieldLabel: 'Área específica',
						id: 'modrevisores_comboAreaEspecifica-PA',
						name: 'fgk_area_especifica',
						queryMode: 'local',
						allowBlank: true,
						labelWidth: 100,
						editable: true,
						store: "AreaEspecifica",
						typeAhead: true,
						valueField: 'id',
						displayField: 'descricao_area_especifica',
						triggerAction: 'all',
						minChars:1,
						forceSelection:false,
						padding: 1,
						flex: 1,
						anchor: '100%'
					},
					{	xtype: 'fieldset',
						title: 'Trabalhos',
						items:[
							{	xtype: 'combobox',
								labelWidth: 80,
								labelAlign: 'top',
								fieldLabel: 'Revisores',
								queryMode: 'local',
								editable: false,
								store:  new Ext.data.ArrayStore({
									fields: ['id', 'value'],
									data : [
										['-1', 'Todos'],
										['1', 'Somente com trabalho vinculado'],
										['0', 'Somente sem trabalho vinculado']
									]
								}),
								value: '-1',
								flex: 1,
								typeAhead: false,
								valueField: 'id',
								displayField: 'value',
								triggerAction: 'all',
								name: 'com_trabalho',
								padding: 1,
								listeners: {
									change: function(combo, newValue, oldValue){
										if(newValue == '1'){
											Ext.getCmp('modrevisores_radioComPendencia').enable();
											Ext.getCmp('modrevisores_radioSemPendencia').enable();
											Ext.getCmp('modrevisores_radioAmbos').enable();
											Ext.getCmp('modrevisores_radioAmbos').setValue(true);

										}
										else{
											Ext.getCmp('modrevisores_radioComPendencia').disable();
											Ext.getCmp('modrevisores_radioAmbos').disable();
											Ext.getCmp('modrevisores_radioComPendencia').setValue(false);
											Ext.getCmp('modrevisores_radioAmbos').setValue(false);
											Ext.getCmp('modrevisores_radioSemPendencia').disable();
											Ext.getCmp('modrevisores_radioSemPendencia').setValue(false);
										}
									}
								}
							},
							{	xtype: 'radiofield',
								boxLabel  : 'Com pendências',
								name      : 'pendentes',
								id: 'modrevisores_radioComPendencia',
								disabled	: true,
								inputValue: '1'
							},
							{	xtype: 'radiofield',
								disabled	: true,
								id: 'modrevisores_radioSemPendencia',
								boxLabel  : 'Sem pendências',
								name      : 'pendentes',
								inputValue: '2'
							},
							{	xtype: 'radiofield',
								disabled	: true,
								id: 'modrevisores_radioAmbos',
								boxLabel  : 'Ambos',
								name      : 'pendentes',
								inputValue: '0'
							}
						/*
							{	xtype: 'checkbox',
								name: 'com_trabalho',
								allowBlank: false,
								boxLabel: 'Somente revisores com trabalhos',
								inputValue: '1',
								uncheckedValue: '0',
								labelWidth: 65,
								listeners:{
									change: function(check, newValue, oldValue, eOpts){
										if (check.getValue()){
											Ext.getCmp('modrevisores_radioComPendencia').enable();
											Ext.getCmp('modrevisores_radioSemPendencia').enable();
										}
										else{
											Ext.getCmp('modrevisores_radioComPendencia').disable();
											Ext.getCmp('modrevisores_radioComPendencia').setValue(false);
											Ext.getCmp('modrevisores_radioSemPendencia').disable();
											Ext.getCmp('modrevisores_radioSemPendencia').setValue(false);
										}
									}
								}
							},
							{	xtype: 'radiofield',
								boxLabel  : 'Revisores com pendências',
								name      : 'trabalhos',
								id: 'modrevisores_radioComPendencia',
								disabled	: true,
								inputValue: '1'
							},
							{	xtype: 'radiofield',
								disabled	: true,
								id: 'modrevisores_radioSemPendencia',
								boxLabel  : 'Revisores sem pendências',
								name      : 'trabalhos',
								inputValue: '2'
							}
						*/
						]
					},
					{	xtype: 'fieldset',
						title: 'Avadilador',
						layout: 'hbox',
						height: 75,
						items:[
							{	xtype: 'combobox',
								labelAlign: 'top',
								fieldLabel: 'PROGRAD',
								queryMode: 'local',
								editable: false,
								store:  new Ext.data.ArrayStore({
									fields: ['id', 'value'],
									data : [
										['-1', ' - '],
										['0', 'Não'],
										['1', 'Sim']
									]
								}),
								value: '-1',
								flex: 1,
								typeAhead: false,
								valueField: 'id',
								displayField: 'value',
								triggerAction: 'all',
								name: 'bool_avaliador_prograd',
								padding: 1
							},
							{	xtype: 'combobox',
								labelAlign: 'top',
								fieldLabel: 'PROEX',
								queryMode: 'local',
								editable: false,
								store:  new Ext.data.ArrayStore({
									fields: ['id', 'value'],
									data : [
										['-1', ' - '],
										['0', 'Não'],
										['1', 'Sim']
									]
								}),
								value: '-1',
								flex: 1,
								typeAhead: false,
								valueField: 'id',
								displayField: 'value',
								triggerAction: 'all',
								name: 'bool_avaliador_proex',
								padding: 1
							},
							{	xtype: 'combobox',
								labelAlign: 'top',
								fieldLabel: 'CAINT',
								queryMode: 'local',
								editable: false,
								store:  new Ext.data.ArrayStore({
									fields: ['id', 'value'],
									data : [
										['-1', ' - '],
										['0', 'Não'],
										['1', 'Sim']
									]
								}),
								value: '-1',
								flex: 1,
								typeAhead: false,
								valueField: 'id',
								displayField: 'value',
								triggerAction: 'all',
								name: 'bool_avaliador_caint',
								padding: 1
							},
							// {	xtype: 'checkbox',
								// name: 'bool_avaliador_prograd',
								// allowBlank: false,
								// fieldLabel: 'PROGRAD',
								// boxLabel: 'Sim',
								// labelAlign: 'top',
								// flex: 1,
								// inputValue: '1',
								// uncheckedValue: '0',
								// checked: false,
								// labelWidth: 65
							// },
							// {	xtype: 'checkbox',
								// name: 'bool_avaliador_proex',
								// allowBlank: false,
								// fieldLabel: 'PROEX',
								// boxLabel: 'Sim',
								// labelAlign: 'top',
								// flex: 1,
								// inputValue: '1',
								// uncheckedValue: '0',
								// checked: false,
								// labelWidth: 65
							// },
							// {	xtype: 'checkbox',
								// name: 'bool_avaliador_caint',
								// allowBlank: false,
								// flex: 1,
								// fieldLabel: 'CAINT',
								// boxLabel: 'Sim',
								// labelAlign: 'top',
								// inputValue: '1',
								// uncheckedValue: '0',
								// checked: false,
								// labelWidth: 65
							// }
						]
					}
				]
			}
        ];
        this.dockedItems = [{
            xtype: 'toolbar',
            dock: 'bottom',
            ui: 'footer',
            items: [
				'->',
				{	iconCls: 'icon-search-white',
					text: 'Buscar',
					itemId: 'btnBuscaAvancada'
				},{
					iconCls: 'icon-cancel',
					text: 'Cancelar',
					scope: this,
					handler: this.close
				}
			]
        }];
        this.callParent(arguments);
    }
});
