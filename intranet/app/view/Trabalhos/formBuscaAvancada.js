Ext.define('Seic.view.Trabalhos.formBuscaAvancada', {
    extend: 'Ext.window.Window',
    alias : 'widget.modtrabalhos_formbuscaavancada',
	id: 'modtrabalhos_formBuscaAvancada',
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
					labelWidth: 100,
					labelAlign: 'left'
				},
				items:[
					{	xtype: 'textfield',
						name: 'nome_autores',
						fieldLabel: 'Autores'
					},
					{	xtype: 'combobox',
						fieldLabel: 'Categoria',
						id: 'modtrabalhos_comboCategoria-PA',
						name: 'fgk_categoria',
						queryMode: 'local',
						allowBlank: true,
						editable: true,
						store: "Categorias",
						typeAhead: true,
						valueField: 'id_categoria',
						displayField: 'sigla_categoria',
						triggerAction: 'all',
						minChars:1,
						forceSelection:true,
						anchor: '100%',
							padding: 1,
							flex: 1
					},
					{	xtype: 'combobox',
						fieldLabel: 'Órgão fomento',
						id: 'modtrabalhos_comboOrgao-PA',
						name: 'fgk_orgao_fomento',
						queryMode: 'local',
						allowBlank: true,
						editable: true,
						store: "OrgaoFomento",
						typeAhead: true,
						valueField: 'id',
						displayField: 'sigla',
						triggerAction: 'all',
						minChars:1,
						forceSelection:true,
						anchor: '100%',
						padding: 1,
						flex: 1
					},
					{	xtype: 'combobox',
						fieldLabel: 'Área',
						id: 'modtrabalhos_comboArea-PA',
						name: 'fgk_area',
						queryMode: 'local',
						allowBlank: true,
						editable: true,
						store: "Area",
						typeAhead: true,
						valueField: 'id_area',
						displayField: 'descricao_area',
						triggerAction: 'all',
						minChars:1,
						forceSelection:true,
						anchor: '100%',
						padding: 1,
						flex: 1,
						listeners: {
							select: function (comboBox, records) {
								comboAreaEspecifica = Ext.getCmp('modtrabalhos_comboAreaEspecifica-PA');
								comboAreaEspecifica.getStore().getProxy().extraParams = {
									id_area	: comboBox.getValue()
								};
								comboAreaEspecifica.getStore().load();
							}
						}
					},
					{	xtype: 'combobox',
						fieldLabel: 'Área específica',
						id: 'modtrabalhos_comboAreaEspecifica-PA',
						name: 'fgk_area_especifica',
						queryMode: 'local',
						allowBlank: true,
						editable: true,
						store: "AreaEspecifica",
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
						fieldLabel: 'Apresentação',
						id: 'modtrabalhos_comboTipoApresentacao-PA',
						name: 'fgk_tipo_apresentacao',
						queryMode: 'local',
						allowBlank: true,
						editable: true,
						store: "TipoApresentacao",
						typeAhead: true,
						valueField: 'id_tipo_apresentacao',
						displayField: 'descricao_tipo',
						triggerAction: 'all',
						minChars:1,
						forceSelection:true,
						anchor: '100%',
						padding: 1,
						flex: 1
					},
					{	xtype: 'combobox',
						fieldLabel: 'Situação',
						id: 'modtrabalhos_comboStatus-PA',
						name: 'fgk_status',
						queryMode: 'local',
						allowBlank: true,
						editable: true,
						store: "Status",
						typeAhead: true,
						valueField: 'id_status',
						displayField: 'descricao_status',
						triggerAction: 'all',
						minChars:1,
						forceSelection:true,
						anchor: '100%',
						padding: 1,
						flex: 1
					},
					{	xtype: 'combobox',
						labelAlign: 'left',
						anchor: '100%',
						labelWidth: 100,
						fieldLabel: 'Avaliação',
						queryMode: 'local',
						editable: false,
						store:  new Ext.data.ArrayStore({
							fields: ['id', 'value'],
							data : [
								['-1', ' - '],
								['0', 'Trabalhos não avaliados'],
								['1', 'Trabalhos já avaliados']
							]
						}),
						value: '-1',
						flex: 1,
						typeAhead: false,
						valueField: 'id',
						displayField: 'value',
						triggerAction: 'all',
						name: 'avaliacao',
						padding: 1
					},
					{	xtype      : 'fieldcontainer',
						fieldLabel : 'Apresentação obrigatória',
						defaultType: 'radiofield',
						labelWidth: 100,
						defaults: {
							flex: 1
						},
						layout: 'hbox',
						items: [
							{	boxLabel  : 'Sim',
								name      : 'apresentacao_obrigatoria',
								inputValue: '1'
							},
							{	boxLabel  : 'Não',
								name      : 'apresentacao_obrigatoria',
								inputValue: '0'
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
