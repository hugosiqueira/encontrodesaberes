Ext.define('Seic.view.Posters.formBuscaAvancada', {
    extend: 'Ext.window.Window',
    alias : 'widget.modposters_formBuscaAvancada',
	id: 'modposters_formBuscaAvancada',
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
					labelWidth: 75,
					labelAlign: 'left'
				},
				items:[
					{	xtype: 'combobox',
						fieldLabel: 'Área',
						id: 'modposters_comboArea-PA',
						name: 'fgk_area',
						queryMode: 'local',
						allowBlank: true,
						editable: true,
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
						padding: 1,
						flex: 1
					},
					{	xtype: 'combobox',
						fieldLabel: 'Sessão',
						id: 'modposters_comboSessao-PA',
						name: 'fgk_sessao',
						queryMode: 'local',
						allowBlank: true,
						editable: true,
						store: new Ext.data.JsonStore({
							proxy: {
								type: 'ajax',
								url: 'Server/posters/listarSessaoPA.php',
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
						forceSelection:true,
						anchor: '100%',
						padding: 1,
						flex: 1
					},
					{	xtype: 'combobox',
						fieldLabel: 'Revisor',
						id: 'modposters_comboRevisor-PA',
						name: 'fgk_revisor',
						queryMode: 'local',
						allowBlank: true,
						editable: true,
						store: new Ext.data.JsonStore({
							proxy: {
								type: 'ajax',
								url: 'Server/posters/listarRevisorPA.php',
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
						forceSelection:true,
						anchor: '100%',
						padding: 1,
						flex: 1
					},
					{	xtype: 'combobox',
						fieldLabel: 'Situação',
						queryMode: 'local',
						editable: false,
						store:  new Ext.data.ArrayStore({
							fields: ['id', 'value'],
							data : [
								['-1', ' - '],
								['1', 'Alocados'],
								['0', 'Não alocados']
							]
						}),
						value: '-1',
						flex: 1,
						typeAhead: false,
						valueField: 'id',
						displayField: 'value',
						triggerAction: 'all',
						name: 'bool_alocado',
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
