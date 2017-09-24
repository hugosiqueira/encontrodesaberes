Ext.define('Seic.view.Revisores.formCadRevisor', {
    extend: 'Ext.window.Window',
    alias : 'widget.modrevisores_formCadRevisor',
    id : 'modrevisores_formCadRevisor',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.ux.CounterTextField',
		'Ext.ux.UpperTextField',
		'Ext.form.field.ComboBox',
		'Ext.ux.CpfField',
	    'Ext.ux.textMask'
	],
    layout: 'fit',
    autoShow: true,
	jsonSubmit: true,
	border: false,
    width: 600,
    autoHeight: true,
    modal: true,
    initComponent: function() {
		this.items = [
			{	xtype: 'form',
                border: false,
				items: [
					{	xtype: 'tabpanel',
						items:[
							{	xtype: 'form',
								border: false,
								padding: '5 5 5 5',
								height: 300,
								title: 'Principal',
								fieldDefaults: {
									anchor: '100%',
									labelWidth: 50,
								},
								items: [
									{	xtype: 'hiddenfield', name: 'id'},
									{	xtype: 'hiddenfield', name: 'tipo_revisor'},
									{	xtype: 'fieldcontainer',
										layout: {
											type: 'hbox'
										},
										items: [
											{	xtype: 'cpffield',
												fieldLabel: 'CPF',
												id: 'modrevisores_cpfRevisor',
												name: 'cpf',
												allowBlank: false,
												plugins: [{
													ptype: 'ux.textMask',
													mask: '999.999.999-99',
													clearWhenInvalid: true
												}],
												width: 200,
												padding: 1
											},
											{	xtype: 'button',
												iconCls: 'icon-search-white',
												id: 'modrevisores_btnLupa',
												itemId: 'btnBuscarRevisor'
											}
										]
									},
									{	xtype: 'fieldcontainer',
										layout: 'form',
										id: 'modrevisores_camposRevisor',
										disabled: true,
										fieldDefaults: {
											anchor: '100%',
											labelWidth: 50,
										},
										items: [
											{	xtype: 'textfield',
												fieldLabel: 'Nome',
												allowBlank: false,
												readOnly: true,
												name: 'nome'
											},
											{	xtype: 'textfield',
												name: 'email',
												readOnly: true,
												fieldLabel: 'Email',
												vtype: 'email',
												allowBlank: true
											},
											{	xtype: 'textfield',
												fieldLabel: 'Depart.',
												id: 'modrevisores_textDepartamento',
												name: 'rend_departamento',
												readOnly: true,
												anchor: '100%'
											},
											{	xtype: 'fieldcontainer',
												layout: {
													type: 'hbox'
												},
												items:[
													{	xtype: 'combobox',
														fieldLabel: 'Área',
														labelWidth: 50,
														id: 'modrevisores_comboArea',
														name: 'fgk_area',
														queryMode: 'local',
														allowBlank: false,
														editable: true,
														store: "Area",
														typeAhead: true,
														valueField: 'id_area',
														displayField: 'codigo_area',
														triggerAction: 'all',
														minChars:1,
														forceSelection:true,
														anchor: '100%',
														padding: 1,
														flex: 0.5,
														listeners: {
															select: function (comboBox, records) {
																comboAreaEspecifica = Ext.getCmp('modrevisores_comboAreaEspecifica');
																comboAreaEspecifica.getStore().getProxy().extraParams = {
																	id_area	: comboBox.getValue()
																};
																comboAreaEspecifica.getStore().load();
																// comboAreaEspecifica.setValue('');
															}
														}
													},
													{	xtype: 'combobox',
														fieldLabel: 'Área específica',
														id: 'modrevisores_comboAreaEspecifica',
														name: 'fgk_area_especifica',
														queryMode: 'local',
														allowBlank: true,
														editable: true,
														labelWidth: 110,
														store: "AreaEspecifica",
														typeAhead: true,
														valueField: 'id',
														displayField: 'descricao_area_especifica',
														triggerAction: 'all',
														minChars:1,
														forceSelection:true,
														padding: 1,
														flex: 1,
														anchor: '100%'
													}
												]
											},
											{	xtype: 'fieldcontainer',
												layout: {
													type: 'hbox'
												},
												items: [
													{	xtype: 'checkbox',
														name: 'bool_avaliador_prograd',
														allowBlank: false,
														fieldLabel: 'PROGRAD',
														boxLabel: 'Sim',
														labelAlign: 'top',
														flex: 1,
														inputValue: '1',
														uncheckedValue: '0',
														checked: false,
														labelWidth: 65
													},
													{	xtype: 'checkbox',
														name: 'bool_avaliador_proex',
														allowBlank: false,
														fieldLabel: 'PROEX',
														boxLabel: 'Sim',
														labelAlign: 'top',
														flex: 1,
														inputValue: '1',
														uncheckedValue: '0',
														checked: false,
														labelWidth: 65
													},
													{	xtype: 'checkbox',
														name: 'bool_avaliador_caint',
														allowBlank: false,
														flex: 1,
														fieldLabel: 'CAINT',
														boxLabel: 'Sim',
														labelAlign: 'top',
														inputValue: '1',
														uncheckedValue: '0',
														checked: false,
														labelWidth: 65
													}
												]
											}
										]
									}
								]
							},
							{	xtype: 'gridpanel',
								title: 'Trabalhos para revisão',
								id: 'modrevisores_gridTrabalhosRevisores',
								border: false,
								disabled: true,
								height: 300,
								store: 'TrabalhosRevisores',
								plugins: [{
									ptype: 'rowexpander',
									expandOnDblClick: false,
									expandOnEnter: false,
									rowBodyTpl: ['<div>{titulo_enviado}</div>']
								}],
								viewConfig:{
									enableTextSelection: true
								},
								columns: {
									defaults: {
										menuDisabled: true,
										resizable: false
									},
									items:[
										{	header: "Título",
											flex: 1,
											dataIndex: 'titulo_enviado',
											renderer: function(value, metaData, record, rowIndex, colIndex, store){
												metaData.tdAttr = 'data-qtip="' + value + '"';
												return value;
											}
										},
										{	header: "Situação",
											width: 80,
											dataIndex: 'status',
											align: 'center',
											renderer: function(value, metaData, record, rowIndex, colIndex, store){
												if(value == 1){
													metaData.tdAttr = 'data-qtip="Em edição."';
													metaData.tdCls = 'icon-edit';
												}
												else if(value == 2){
													metaData.tdAttr = 'data-qtip="Revisão submetida."';
													metaData.tdCls = 'icon-submetido';
												}
												else if(value == 0){
													metaData.tdAttr = 'data-qtip="Aguardando revisão."';
													metaData.tdCls = 'icon-aguardando_submissao';
												}
											}
										}
									]
								},
								listeners: {
									render: function(){
										var row = Ext.getCmp('modrevisores_gridRevisores').getSelectionModel().getSelection()[0];
										this.getStore().load({
											params:{
												id_revisor: row.data.id
											}
										});
									}
								}
							},
							{	xtype: 'gridpanel',
								title: 'Avaliações (Sessões)',
								id: 'modrevisores_gridSessoesRevisores',
								border: false,
								disabled: true,
								height: 300,
								store: 'SessoesRevisores',
								columns: {
									defaults: {
										menuDisabled: true,
										resizable: false
									},
									items:[
										{	header: "id",
											dataIndex: 'id',
											hidden:true
										},
										{ 	xtype: 'checkcolumn',
											header: "#",
											width: 35,
											dataIndex: 'check'
										},
										{	header: "Sessão",
											dataIndex: 'nome',
											flex:1
										},
										{	xtype: 'datecolumn',
											format:'d/m/Y',
											header: "Dia",
											width: 90,
											dataIndex: 'dia',
											align: 'center'
										},
										{	header: "Início",
											dataIndex: 'hora_ini',
											width: 70,
											align: 'center'
										},
										{	header: "Fim",
											dataIndex: 'hora_fim',
											width: 70,
											align: 'center'
										}

									]
								},
								listeners: {
									render: function(){
										var row = Ext.getCmp('modrevisores_gridRevisores').getSelectionModel().getSelection()[0];
										this.getStore().load({
											params:{
												id_revisor: row.data.id
											}
										});
									}
								}
							},
							{	xtype: 'gridpanel',
								title: 'Trabalhos para avaliação',
								id: 'modrevisores_gridTrabalhosAvaliacaoRevisores',
								border: false,
								disabled: true,
								height: 300,
								store: 'TrabalhosAvaliacaoRevisores',
								plugins: [{
									ptype: 'rowexpander',
									expandOnDblClick: false,
									expandOnEnter: false,
									rowBodyTpl: ['<div>{titulo_enviado}</div>']
								}],
								viewConfig:{
									enableTextSelection: true
								},
								columns: {
									defaults: {
										menuDisabled: true,
										resizable: false
									},
									items:[
										{	header: "Título",
											flex: 1,
											dataIndex: 'titulo_enviado',
											renderer: function(value, metaData, record, rowIndex, colIndex, store){
												metaData.tdAttr = 'data-qtip="' + value + '"';
												return value;
											}
										},
										{	header: "Cód. Poster",
											width: 100,
											dataIndex: 'cod_poster',
											align: 'center'
										}
									]
								},
								listeners: {
									render: function(){
										var row = Ext.getCmp('modrevisores_gridRevisores').getSelectionModel().getSelection()[0];
										this.getStore().load({
											params:{
												id_revisor: row.data.id
											}
										});
									}
								}
							}
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
				{	iconCls: 'icon-save',
					text: 'Salvar',
					itemId: 'btnSalvarRevisor'
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
