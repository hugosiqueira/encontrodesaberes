Ext.define('Seic.view.Admin.formCadTipoCertificado', {
    extend: 'Ext.window.Window',
    alias : 'widget.modadmin_formCadTipoCertificado',
    id : 'modadmin_formCadTipoCertificado',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
	],
    layout: 'fit',
    autoShow: true,
	jsonSubmit: true,
	border: false,
    width: 800,
	title:  'Certificado',
	autoHeight: true,
    modal: true,
    initComponent: function() {
		this.items = [
			{	xtype: 'form',
                border: false,
				items: [
					{	xtype: 'hiddenfield', name: 'id_tipo_certificado'},
					{	xtype: 'tabpanel',
						items:[
							{   xtype: 'form',
								title: 'Principal',
								height: 600,
								padding: '5 5 5 5',
								border: false,
								fieldDefaults: {
									anchor: '100%',
									labelAlign: 'top'
								},
								items:[
									{	xtype: 'textfield',
										name: 'descricao_certificado',
										fieldLabel: 'Descrição'
									},
									{	xtype: 'fieldset',
										title: 'Modelo',
										items:[
											{	xtype: 'htmleditor',
												height: 500,
												name: 'modelo_padrao'
											}
										]
									}
								]
							},
							{	xtype: 'panel',
								title: 'Imagem de fundo',
								height: 600,
								border: false,
								disabled: true,
								id: 'modadmin_panelImagemCertificado',
								html: '',
								dockedItems : [
									{	xtype: 'toolbar',
										dock: 'bottom',
										items: [
										'->',
										{	iconCls: 'icon-add',
											text: 'Enviar',
											itemId: 'btnUploadImagemCertificado'
										},'-',{
											iconCls: 'icon-delete',
											text: 'Apagar',
											disabled: true,
											id: 'modadmin_btnApagarImagemCertificado'
										},'->'
										]
									}
								]
							},
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
					itemId: 'btnSalvarTipoCertificado'
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
