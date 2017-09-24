Ext.define('Seic.view.Avaliacoes.formCadAvaliacao', {
    extend: 'Ext.window.Window',
    alias : 'widget.modaval_formCadAvaliacao',
    id : 'modaval_formCadAvaliacao',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.form.field.ComboBox'
	],
    layout: 'fit',
    autoShow: true,
	jsonSubmit: true,
	border: false,
    width: 750,
    autoHeight: true,
    modal: true,
    initComponent: function() {
		this.items = [
			{	xtype: 'form',
				autoScroll : true,
				padding: '5 5 5 5',
                border: false,
				fieldDefaults: {
					anchor: '100%',
					labelAlign: 'top'
				},
				items: [
					{	xtype: 'hiddenfield', name: 'id', id: 'modaval_id_avaliacao'},
					{	xtype: 'hiddenfield', name: 'status', id: 'modaval_status_avaliacao'},
					{	xtype: 'textareafield',
						height: 75,
						readOnly: true,
						fieldLabel: 'Título',
						id: 'modaval_tituloTrabalho',
						allowBlank: false,
						padding: 1,
						flex: 3,
						name: 'titulo_enviado'
					},
					{	xtype: 'fieldcontainer',
						layout:'hbox',
						items:[
							{	xtype: 'textfield',
								name: 'descricao_area',
								fieldLabel: 'Área',
								anchor: '100%',
								flex: 2,
								padding: 1,
								readOnly: true
							},
							{	xtype: 'textfield',
								name: 'cod_poster',
								fieldLabel: 'Poster',
								anchor: '100%',
								flex: 1,
								padding: 1,
								readOnly: true
							},
							{	xtype: 'textfield',
								name: 'nome_sessao',
								fieldLabel: 'Sessão',
								anchor: '100%',
								flex: 1,
								padding: 1,
								readOnly: true
							}
						]
					},
					{	xtype: 'gridpanel',
						title: 'Apresentador',
						border: true,
						height: 200,
						disabled: true,
						id: 'modaval_gridAutores',
						store: 'Seic.store.Avaliacoes.AutoresTrabalho',
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
									header: "Apresentador",
									width: 100,
									dataIndex: 'bool_apresentador'
								},
								{	text: 'Nome',
									dataIndex: 'nome',
									flex: 1.5
								},
								{	text: 'Tipo autor',
									dataIndex: 'descricao_tipo',
									flex: 1
								},
								{ 	text: 'CPF',
									dataIndex: 'cpf',
									align: 'center',
									width: 125
								}
							]
						}
					},
					{	xtype: 'form',
						title: 'Avaliador',
						border: false,
						fieldDefaults: {
							anchor: '100%',
							labelAlign: 'top',
						},
						items: [
							{	xtype: 'combobox',
								fieldLabel: 'Revisor',
								hideLabel: true,
								id: 'modaval_comboRevisor',
								name: 'fgk_revisor',
								queryMode: 'local',
								allowBlank: false,
								padding: '5 5 0 5',
								editable: true,
								store: new Ext.data.JsonStore({
									proxy: {
										type: 'ajax',
										url: 'Server/avaliacoes/listarRevisor.php',
										reader: {
											type: 'json',
											root: 'resultado'
										}
									},
									fields: [
										{name:'id',	type: 'int'},
										{name:'nome', type:'string'}
									]
								}),
								typeAhead: true,
								valueField: 'id',
								displayField: 'nome',
								triggerAction: 'all',
								minChars:1,
								forceSelection:false,
								flex: 1
							}
						]
					},
					{	title: 'Notas',
						layout: 'form',
						border: false,
						fieldDefaults: {
							anchor: '100%',
							labelAlign: 'top'
						},
						items:[
							{	xtype: 'fieldcontainer',
								layout: 'hbox' ,
								items:[
									{	xtype: 'numberfield',
										fieldLabel: 'NOTA A',
										id: 'modaval_notaA',
										labelAlign: 'top',
										flex: 1,
										allowBlank: false,
										name: 'nota_a',
										maxValue: 10,
										minValue: 0,
										hideTrigger: true,
										regex: (/^[0-9]*/),
										height: 60,
										padding: '1 1 15 1',// (top, right, bottom, left).
										fieldStyle: {
											'font-weight': 'bold',
											'fontSize': '40px',
											'text-align': 'center',
										}
									},
									{	xtype: 'numberfield',
										fieldLabel: 'NOTA B',
										labelAlign: 'top',
										flex: 1,
										name: 'nota_b',
										allowBlank: false,
										maxValue: 10,
										minValue: 0,
										hideTrigger: true,
										regex: (/^[0-9]*/),
										height: 60,
										padding: '1 1 15 1',// (top, right, bottom, left).
										fieldStyle: {
											'font-weight': 'bold',
											'fontSize': '40px',
											'text-align': 'center',
										}
									},{	xtype: 'numberfield',
										fieldLabel: 'NOTA C',
										labelAlign: 'top',
										flex: 1,
										allowBlank: false,
										name: 'nota_c',
										maxValue: 10,
										minValue: 0,
										hideTrigger: true,
										regex: (/^[0-9]*/),
										height: 60,
										padding: '1 1 15 1',// (top, right, bottom, left).
										fieldStyle: {
											'font-weight': 'bold',
											'fontSize': '40px',
											'text-align': 'center',
										}
									},{	xtype: 'numberfield',
										fieldLabel: 'NOTA D',
										labelAlign: 'top',
										flex: 1,
										allowBlank: false,
										name: 'nota_d',
										maxValue: 10,
										minValue: 0,
										hideTrigger: true,
										regex: (/^[0-9]*/),
										height: 60,
										padding: '1 1 15 1',// (top, right, bottom, left).
										fieldStyle: {
											'font-weight': 'bold',
											'fontSize': '40px',
											'text-align': 'center',
										}
									},{	xtype: 'numberfield',
										fieldLabel: 'NOTA E',
										allowBlank: false,
										labelAlign: 'top',
										flex: 1,
										name: 'nota_e',
										maxValue: 10,
										minValue: 0,
										hideTrigger: true,
										regex: (/^[0-9]*/),
										height: 60,
										padding: '1 1 15 1',// (top, right, bottom, left).
										fieldStyle: {
											'font-weight': 'bold',
											'fontSize': '40px',
											'text-align': 'center',
										}
									}
								]
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
				{	iconCls: 'icon-reprovado',
					text: 'Apresentador ausente',
					itemId: 'btnReprovar'
				},
				{	iconCls: 'icon-save',
					text: 'Salvar',
					itemId: 'btnSalvarAvaliacao'
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
