Ext.define('Seic.view.Anais.formAutorAnais', {
    extend: 'Ext.window.Window',
    alias : 'widget.modanais_formAutorAnais',
	id: 'modanais_formAutorAnais',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.form.field.ComboBox'
	],
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
					labelWidth: 70,
					labelAlign: 'left'
				},
				items:[
					{	xtype: 'hiddenfield', name: 'id', id: 'modanais_id_autores_anais'},
					{	xtype: 'hiddenfield', name: 'fgk_trabalho_anais', id: 'modanais_fgk_trabalho_anais'},
					{	xtype: 'textfield',
						fieldLabel: 'Nome',
						name: 'nome',
						allowBlank: false
					},
					{	xtype: 'textfield',
						fieldLabel: 'Citação',
						name: 'nome_citacao',
						allowBlank: false
					},
					{	xtype: 'textfield',
						fieldLabel: 'Email',
						name: 'email',
						vtype: 'email',
						allowBlank: false
					},
					{	xtype: 'textfield',
						fieldLabel: 'Instituição',
						name: 'instituicao',
						allowBlank: false
					},
					{	xtype: 'combobox',
						fieldLabel: 'Tipo',
						id: 'modanais_comboTipoAutor',
						name: 'fgk_tipo',
						queryMode: 'local',
						allowBlank: false,
						editable: false,
						store: new Ext.data.JsonStore({
							proxy: {
								type: 'ajax',
								url: 'Server/anais/listarTipoAutor.php',
								reader: {
									type: 'json',
									root: 'resultado'
								}
							},
							fields: [
								{name:'id_tipo_autor',	type: 'int'},
								{name:'descricao_tipo', type:'string'}
							]
						}),
						valueField: 'id_tipo_autor',
						displayField: 'descricao_tipo',
						triggerAction: 'all',
						forceSelection:true,
						anchor: '70%',
						padding: 1
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
					itemId: 'btnSalvarAutorAnais'
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
