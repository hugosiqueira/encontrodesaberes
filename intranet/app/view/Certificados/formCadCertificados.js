Ext.define('Seic.view.Certificados.formCadCertificados', {
    extend: 'Ext.window.Window',
    alias : 'widget.modcertificados_formCadCertificados',
    id : 'modcertificados_formCadCertificados',
    requires: [
		'Ext.ux.CpfField',
	],
    layout: 'fit',
    autoShow: true,
	jsonSubmit: true,
	border: false,
    width: 800,
    autoHeight: true,
    modal: true,
    initComponent: function() {
		this.items = [
			{	xtype: 'form',
				padding: '5 5 0 5',
				id: 'modcertificados_camposCertificado',
				border: false,
				fieldDefaults: {
					anchor: '100%',
					labelAlign: 'top'
				},
				items: [
					{	xtype: 'fieldcontainer',
						layout: 'hbox',
						items:[
							{	xtype: 'datefield',
								name: 'data_emissao',
								submitFormat: 'Y-m-d',
								allowBlank: false,
								readOnly: true,
								flex: 1,
								fieldLabel: 'Data emissão',
								padding: 1,
								value: new Date()
							},
							{	xtype: 'combobox',
								flex: 2,
								fieldLabel: 'Tipo',
								id: 'modcertificados_comboTipoCertificado',
								name: 'fgk_tipo',
								padding: 1,
								queryMode: 'local',
								allowBlank: false,
								editable: false,
								store: "TipoCertificado",
								anchor: '60%',
								valueField: 'id_tipo_certificado',
								displayField: 'descricao_certificado',
								triggerAction: 'all',
								forceSelection:true,
								listeners: {
									select: function (comboBox, records) {
										Ext.Msg.show({
											title:   'Confirmação',
											msg:     'Deseja substituir o texto pelo modelo do tipo: <b>'+comboBox.getRawValue()+'</b>?',
											buttons: Ext.Msg.YESNO,
											fn: function(button){
												if(button=="yes"){
													var record = records[0];
													Ext.getCmp('modcertificados_textoCetificado').setValue(record.get('modelo_padrao'));
												}
											},
											animEl: 'elId',
											icon:   Ext.MessageBox.QUESTION
										});
									}
								}
							},
							{	xtype: 'cpffield',
								fieldLabel: 'CPF',
								id: 'modcertificados_cpf',
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
						]
					},
					{	xtype: 'fieldcontainer',
						layout: 'hbox',
						items:[
							{	xtype: 'textfield',
								name: 'nome',
								fieldLabel: 'Nome',
								allowBlank: false,
								flex: 1,
								padding: 1
							},
							{	xtype: 'textfield',
								name: 'email',
								fieldLabel: 'Email',
								vtype: 'email',
								flex: 1,
								padding: 1,
								allowBlank: false
							}
						]
					},
					{	xtype: 'htmleditor',
						height: 500,
						id: 'modcertificados_textoCetificado',
						name: 'dizeres_certificado'
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
					itemId: 'btnSalvarCertificado'
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
