Ext.define('Seic.view.CadastroInstituicoes.formCadInstituicao', {
    extend: 'Ext.window.Window',
    alias : 'widget.modcadinstituicao_formCadInstituicao',
    id : 'modcadinstituicao_formCadInstituicao',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.ux.UpperTextField'
	],
    layout: 'fit',
    autoShow: true,
	jsonSubmit: true,
	border: false,
    width: 500,
    autoHeight: true,
    modal: true,
    initComponent: function() {
		this.items = [
			{	xtype: 'form',
                border: false,
				autoHeight: true,
				padding: '5 5 5 5',
				fieldDefaults: {
					anchor: '100%',
					labelWidth: 65
				},
				items: [
					{	xtype: 'hiddenfield', name: 'id'	},
					{	xtype: 'uppertextfield',
						fieldLabel: 'Sigla',
						allowBlank: false,
						name: 'sigla',
						anchor: '50%'
					},
					{	xtype: 'textfield',
						fieldLabel: 'Instituição',
						allowBlank: false,
						name: 'nome'
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
					itemId: 'btnSalvarInstituicao'
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
