Ext.define('Seic.view.Inscritos.formBuscaAvancada', {
    extend: 'Ext.window.Window',
    alias : 'widget.modinscritos_formbuscaavancada',
	id: 'modinscritos_formBuscaAvancada',
    requires: [
		'Ext.form.Panel',
		'Ext.ux.CpfFieldBlank',
		'Ext.form.field.ComboBox'
	],
    title : 'Buscar por...',
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
					labelAlign: 'left',
					msgTarget: 'side'
				},
				items:[
					{	xtype: 'fieldcontainer',
						layout: {
							type: 'hbox'
						},
						items: [
							{	xtype: 'combobox',
								fieldLabel: 'Tipo de inscrição',
								id: 'modinscritos_comboTipoInscrito-PA',
								name: 'fgk_tipo',
								queryMode: 'local',
								labelWidth: 110,
								allowBlank: true,
								editable: true,
								store: "TipoInscritos",
								typeAhead: true,
								valueField: 'id_tipo_inscrito',
								displayField: 'descricao_tipo',
								triggerAction: 'all',
								minChars:1,
								forceSelection:true,
								anchor: '100%',
								padding: 1,
								flex: 2,
								listeners: {
									render: function(){
										this.getStore().load();
									}
								}
							}
						]
					},
					{	xtype: 'cpffieldblank',
						fieldLabel: 'CPF',
						name: 'cpf',
						anchor: '50%',
						flex: 1,
						padding: 1,
						allowBlank: true,
						labelWidth: 85,
						plugins: [{
							ptype: 'ux.textMask',
							mask: '999.999.999-99',
							clearWhenInvalid: true
						}]
					},
					{	xtype: 'combobox',
						fieldLabel: 'Instituição',
						id: 'modinscritos_comboInstituicaoInscrito-PA',
						name: 'fgk_instituicao',
						queryMode: 'local',
						allowBlank: true,
						editable: true,
						store: "InstituicaoInscrito",
						typeAhead: true,
						valueField: 'id',
						displayField: 'rend_inst',
						triggerAction: 'all',
						minChars:1,
						forceSelection:true,
						labelWidth: 85,
						padding: 1,
						flex: 1,
						listeners: {
							render: function(){
								this.getStore().load();
							},
							select: function (comboBox, records) {
								comboDepartamento 	= Ext.getCmp('modinscritos_comboDepartamentoInscrito-PA');
								comboCurso		 	= Ext.getCmp('modinscritos_comboCursoInscrito-PA');
								textDepartamento	= Ext.getCmp('modinscritos_textDepartamentoInscrito-PA');
								textCurso			= Ext.getCmp('modinscritos_textCursoInscrito-PA');
								if(comboBox.getValue() == 1 ){
									textDepartamento.hide();
									textDepartamento.setValue('');
									textCurso.hide();
									textCurso.setValue('');
									comboDepartamento.enable();
									comboDepartamento.show();
									comboCurso.enable();
									comboCurso.show();
									comboDepartamento.getStore().load();
								}
								else{
									comboDepartamento.hide();
									comboDepartamento.setValue('');
									comboCurso.hide();
									comboCurso.setValue('');
									textDepartamento.show();
									textDepartamento.enable();
									textCurso.show();
									textCurso.enable();
								}
							}
						}
					},
					{	xtype: 'combobox',
						labelWidth: 85,
						fieldLabel: 'Departamento',
						id: 'modinscritos_comboDepartamentoInscrito-PA',
						name: 'fgk_departamento',
						queryMode: 'local',
						allowBlank: true,
						editable: true,
						store: "DepartamentoInscrito",
						typeAhead: true,
						valueField: 'id_departamento',
						displayField: 'nome_departamento',
						triggerAction: 'all',
						minChars:1,
						forceSelection:true,
						padding: 1,
						flex: 1,
						hidden: true,
						listeners: {
							select: function (comboBox, records) {
								comboCurso 	= Ext.getCmp('modinscritos_comboCursoInscrito-PA');
								comboCurso.getStore().getProxy().extraParams = {
									id_departamento	: comboBox.getValue()
								};
								comboCurso.getStore().load();
							}
						}
					},
					{	xtype: 'textfield',
						id: 'modinscritos_textDepartamentoInscrito-PA',
						name: 'departamento',
						fieldLabel: 'Departamento',
						allowBlank: true,
						anchor: '100%',
						labelWidth: 85,
						padding: 1,
						flex: 1
					},
					{	xtype: 'combobox',
						fieldLabel: 'Curso',
						id: 'modinscritos_comboCursoInscrito-PA',
						labelWidth: 85,
						name: 'fgk_curso',
						queryMode: 'local',
						allowBlank: true,
						editable: true,
						store: "CursoInscrito",
						typeAhead: true,
						valueField: 'id_curso',
						displayField: 'rend_curso',
						triggerAction: 'all',
						minChars:1,
						forceSelection:true,
						anchor: '100%',
						padding: 1,
						flex:1.8,
						hidden: true
					},
					{	xtype: 'textfield',
						labelWidth: 85,
						id: 'modinscritos_textCursoInscrito-PA',
						name: 'curso',
						fieldLabel: 'Curso',
						allowBlank: true,
						anchor: '100%',
						padding: 1
					},
					{	xtype: 'fieldcontainer',
						layout: {
							type: 'hbox'
						},
						items: [
							{	xtype: 'combobox',
								name: 'mobilidade_ano_passado',
								fieldLabel: 'Mobilidade ano passado?',
								labelAlign: 'top',
								queryMode: 'local',
								editable: false,
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
								padding: 1
							},
							{	xtype: 'combobox',
								name: 'bool_monitoria',
								fieldLabel: 'Seminário de monitoria?',
								labelAlign: 'top',
								queryMode: 'local',
								editable: false,
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
								padding: 1
							},
							{	xtype: 'combobox',
								name: 'bool_temp',
								fieldLabel: 'Pré cadastro?',
								labelAlign: 'top',
								queryMode: 'local',
								editable: false,
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
								padding: 1
							}
						]
					},
					{	xtype: 'fieldcontainer',
						layout: {
							type: 'hbox'
						},
						items: [
							{	xtype: 'combobox',
								name: 'conta_ativada',
								fieldLabel: 'Ativo?',
								labelAlign: 'top',
								queryMode: 'local',
								editable: false,
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
								padding: 1
							},
							{	xtype: 'combobox',
								name: 'bool_coordenador',
								fieldLabel: 'Coordenador?',
								labelAlign: 'top',
								queryMode: 'local',
								editable: false,
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
								padding: 1
							},
							{	xtype: 'combobox',
								name: 'bool_revisor',
								fieldLabel: 'Revisor?',
								labelAlign: 'top',
								queryMode: 'local',
								editable: false,
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
								padding: 1
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
					itemId: 'btnBuscarInscrito',
				},{
					iconCls: 'icon-cancel',
					text: 'Cancelar',
					scope: this,
					handler: this.hide
				}
			]
        }];
        this.callParent(arguments);
    }
});
