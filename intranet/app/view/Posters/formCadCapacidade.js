Ext.define('Seic.view.Posters.formCadCapacidade', {
    extend: 'Ext.window.Window',
    alias : 'widget.modposters_formCadCapacidade',
    id : 'modposters_formCadCapacidade',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.form.field.ComboBox'
	],
    layout: 'fit',
    autoShow: true,
	jsonSubmit: true,
	border: false,
    width: 400,
	autoHeight: true,
    modal: true,
    initComponent: function() {
		this.items = [
			{	xtype: 'form',
				padding: '5 5 0 5',
                border: false,
				fieldDefaults: {
					anchor: '100%',
					labelWidth: 65
				},
				items: [
					{	xtype: 'hiddenfield', name: 'id_sessao_capacidade'},
					{	xtype: 'hiddenfield', name: 'fgk_sessao', id: 'modposters_fgk_sessao'},
					{	xtype: 'combobox',
						fieldLabel: 'Área',
						id: 'modposters_comboAreaCapacidade',
						name: 'fgk_area',
						queryMode: 'local',
						allowBlank: false,
						editable: true,
						labelWidth: 75,
						store: new Ext.data.JsonStore({
							proxy: {
								type: 'ajax',
								url: 'Server/posters/listarAreaCapacidade.php',
								reader: {
									type: 'json',
									root: 'resultado'
								}
							},
							fields: [
								{name:'id_area',	type: 'int'},
								{name:'descricao_area', type:'string'}
							]
						}),
						typeAhead: true,
						valueField: 'id_area',
						displayField: 'descricao_area',
						triggerAction: 'all',
						minChars:1,
						forceSelection:true,
						anchor: '100%',
						flex: 1,
						padding: 1
					},
					{	xtype: 'textfield',
						labelWidth: 75,
						anchor: '50%',
						name: 'capacidade',
						fieldLabel: 'Capacidade',
						allowBlank: false,
						padding: 1,
						flex: 1
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
					itemId: 'btnSalvarCapacidade'
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
