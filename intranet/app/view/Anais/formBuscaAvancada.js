Ext.define('Seic.view.Anais.formBuscaAvancada', {
    extend: 'Ext.window.Window',
    alias : 'widget.modanais_formBuscaAvancada',
	id: 'modanais_formBuscaAvancada',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.form.field.ComboBox'
	],
    title : 'Busca avançada',
    layout: 'fit',
    autoShow: true,
    width: 500,
    autoHeight: true,
    modal: true,
    initComponent: function() {
		this.items = [
            {   xtype: 'form',
                border: false,
				padding: '5 5 5 5',
				fieldDefaults: {
					anchor: '100%',
					labelWidth: 115,
					labelAlign: 'left'
				},
				items:[
					{	xtype: 'combobox',
						fieldLabel: 'Área específica',
						id: 'modanais_comboAreaEspecifica-PA',
						name: 'fgk_area_especifica',
						queryMode: 'local',
						allowBlank: true,
						editable: true,
						store: new Ext.data.JsonStore({
							proxy: {
								type: 'ajax',
								url: 'Server/anais/listarAreaEspecificaPA.php',
								reader: {
									type: 'json',
									root: 'resultado'
								}
							},
							fields: [
								{name:'id',	type: 'int'},
								{name:'descricao_area_especifica', type:'string'}
							]
						}),
						typeAhead: true,
						valueField: 'id',
						displayField: 'descricao_area_especifica',
						triggerAction: 'all',
						minChars:1,
						forceSelection:true,
						anchor: '100%',
						padding: 1,
						flex: 1
					},					
					{	xtype: 'combobox',
						fieldLabel: 'Premiado',
						queryMode: 'local',
						editable: false,
						anchor: '60%',
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
						name: 'bool_premiado',
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
				{	iconCls: 'icon-search-white',
					text: 'Buscar',
					itemId: 'btnPesquisar'
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
