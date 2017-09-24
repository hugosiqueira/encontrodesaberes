Ext.define('Seic.view.Inscritos.formCadInscritos', {
    extend: 'Ext.window.Window',
    alias : 'widget.modinscritos_formcadinscritos',
    id : 'modinscritos_formCadInscritos',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.form.field.ComboBox',
		'Ext.ux.CpfField',
	    'Ext.ux.textMask',
	    'Ext.ux.textMask2',
	],
    layout: 'fit',
    autoShow: true,
	jsonSubmit: true,
    width: 750,
    height: 650,
    modal: true,
    initComponent: function() {
		Ext.apply(Ext.form.field.VTypes, {
			password: function(val, field) {
				if (field.initialPassField) {
					var pwd = field.up('form').down('#' + field.initialPassField);
					return (val == pwd.getValue());
				}
				return true;
			},
			passwordText: 'As senhas não conferem.'
		});
		this.items = [
			{   xtype: 'form',
				layout: 'fit',
				border: false,
				items: [
					{	xtype: 'tabpanel',
						items:[
							{	title: 'Principal',
								layout: 'form',
								padding: '5 5 5 5',
								items: [
									{	xtype: 'hiddenfield', name: 'id'},
										{	xtype: 'fieldset',
											title: 'Principal',
											fieldDefaults: {
												anchor: '100%'
											},
											items: [
												{	xtype: 'fieldcontainer',
													layout: {
														type: 'hbox'
													},
													items: [
														{	xtype: 'textfield',
															name: 'nome',
															fieldLabel: 'Nome',
															allowBlank: false,
															anchor: '100%',
															flex: 2,
															padding: 1,
															labelWidth: 40
														},
														{	xtype: 'cpffield',
															id: 'modinscritos_cpfInscrito',
															fieldLabel: 'CPF',
															name: 'cpf',
															flex: 1,
															padding: 1,
															allowBlank: false,
															labelWidth: 35,
															plugins: [{
																ptype: 'ux.textMask',
																mask: '999.999.999-99',
																clearWhenInvalid: true
															}]
														}
													]
												},
												{	xtype: 'fieldcontainer',
													layout: {
														type: 'hbox',
														columns: 3
													},
													items: [
														{	xtype: 'combobox',
															fieldLabel: 'Tipo',
															id: 'modinscritos_comboTipoInscrito',
															name: 'fgk_tipo',
															queryMode: 'local',
															labelWidth: 40,
															allowBlank: false,
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
														},
														{	xtype: 'checkbox',
															name: 'bool_monitoria',
															allowBlank: false,
															fieldLabel: 'Seminário de monitoria?',
															boxLabel: 'Sim',
															labelAlign: 'left',
															inputValue: '1',
															uncheckedValue: '0',
															checked: false,
															flex: 1.5,
															labelWidth: 150
														},
														{	xtype: 'checkbox',
															name: 'bool_temp',
															allowBlank: false,
															fieldLabel: 'Pré-cadastro',
															boxLabel: 'Sim',
															labelWidth: 90,
															flex: 1,
															inputValue: '1',
															uncheckedValue: '0',
															checked: false,
															padding: 1.5
														},
													]
												},
												/*
												{	xtype: 'fieldcontainer',
													layout: {
														type: 'hbox'
													},
													items: [
														{	xtype: 'textfield',
															inputType: 'password',
															allowBlank: true,
															name: 'password',
															id: 'modinscritos_passwordInscrito',
															itemId : 'password',
															fieldLabel: 'Senha',
															flex: 1,
															padding: 1,
															listeners: {
																validitychange: function(field){
																	field.next().validate();
																},
																blur: function(field){
																	field.next().validate();
																}
															}
														},
														{	xtype: 'textfield',
															labelWidth: 80,
															inputType: 'password',
															allowBlank: true,
															fieldLabel: 'Conf. Senha',
															flex: 1,
															padding: 1,
															vtype: 'password',
															initialPassField: 'password'
														}
													]
												}
												*/
											]
										},
										{	xtype: 'fieldset',
											title: 'Contato',
											fieldDefaults: {
												labelAlign: 'top',
												anchor: '100%'
											},
											items: [
												{	xtype: 'fieldcontainer',
													layout: {
														type: 'hbox'
													},
													items: [
														{	xtype: 'textfield',
															name: 'email',
															fieldLabel: 'Email',
															vtype: 'email',
															allowBlank: false,
															padding: 1,
															flex: 1
														},
														{	xtype: 'textfield',
															name: 'email_alternativo',
															fieldLabel: 'Email Alternativo',
															vtype: 'email',
															allowBlank: true,
															padding: 1,
															flex: 1
														},
														{	xtype: 'checkboxgroup',
															flex: 0.5,
															fieldLabel: 'Autoriza',
															padding: 1,
															items: [
																{ boxLabel: 'Sim', name: 'autoriza_envio_emails', inputValue: '1'}
															]
														},
														{


															xtype: 'textfield',
															name: 'telefone',
															fieldLabel: 'Telefone',
															allowBlank: true,
															plugins: [{
																ptype: 'ux.textMask2',
																mask: '(99)9999-99999',
																clearWhenInvalid: false
															}],
															padding: 1,
															flex: 0.6



														},
														{	xtype: 'textfield',
															name: 'telefone_celular',
															fieldLabel: 'Celular',
															allowBlank: true,
															plugins: [{
																ptype: 'ux.textMask2',
																mask: '(99)9999-99999',
																clearWhenInvalid: false
															}],
															padding: 1,
															flex: 0.6
														}
													]
												}
											]
										},
										{   xtype: 'fieldset',
											title: 'Institucional',
											fieldDefaults: {
												labelAlign: 'top',
												anchor: '100%'
											},
											items: [

												{	xtype: 'fieldcontainer',
													layout: {
														type: 'hbox'
													},
													items: [
														{	xtype: 'combobox',
															fieldLabel: 'Instituição',
															id: 'modinscritos_comboInstituicaoInscrito',
															name: 'fgk_instituicao',
															queryMode: 'local',
															allowBlank: false,
															editable: true,
															store: "InstituicaoInscrito",
															typeAhead: true,
															valueField: 'id',
															displayField: 'sigla',
															triggerAction: 'all',
															minChars:1,
															forceSelection:true,
															labelWidth: 85,
															padding: 1,
															flex: 1,
															listeners: {
																select: function (comboBox, records) {
																	comboDepartamento 	= Ext.getCmp('modinscritos_comboDepartamentoInscrito');
																	comboCurso		 	= Ext.getCmp('modinscritos_comboCursoInscrito');
																	textDepartamento	= Ext.getCmp('modinscritos_textDepartamentoInscrito');
																	textCurso	= Ext.getCmp('modinscritos_textCursoInscrito');
																	if(comboBox.getValue() == 1 ){
																		textDepartamento.hide();
																		textDepartamento.disable();
																		textCurso.hide();
																		textCurso.disable();
																		comboDepartamento.enable();
																		comboDepartamento.show();
																		comboCurso.enable();
																		comboCurso.show();
																		comboDepartamento.getStore().load();
																	}
																	else{
																		comboDepartamento.hide();
																		comboDepartamento.disable();
																		comboCurso.hide();
																		comboCurso.disable();
																		textDepartamento.show();
																		textDepartamento.enable();
																		textCurso.show();
																		textCurso.enable();
																	}
																}
															}
														},
														{	xtype: 'checkbox',
															name: 'bool_revisor',
															allowBlank: false,
															fieldLabel: 'Revisor',
															boxLabel: 'Sim',
															labelWidth: 60,
															flex: 0.3,
															inputValue: '1',
															uncheckedValue: '0',
															checked: false,
															padding: 1
														},
														{	xtype: 'combobox',
															labelWidth: 85,
															fieldLabel: 'Departamento',
															id: 'modinscritos_comboDepartamentoInscrito',
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
															flex: 2,
															hidden: true,
															listeners: {
																select: function (comboBox, records) {
																	comboCurso 	= Ext.getCmp('modinscritos_comboCursoInscrito');
																	comboCurso.getStore().getProxy().extraParams = {
																		id_departamento	: comboBox.getValue()
																	};
																	comboCurso.getStore().load();
																}
															}
														},
														{	xtype: 'textfield',
															id: 'modinscritos_textDepartamentoInscrito',
															name: 'departamento',
															fieldLabel: 'Departamento',
															allowBlank: true,
															anchor: '100%',
															labelWidth: 85,
															padding: 1,
															flex: 2
														}
													]
												},
												{	xtype: 'fieldcontainer',
													layout: {
														type: 'hbox'
													},
													items: [
														{	xtype: 'combobox',
															fieldLabel: 'Curso',
															id: 'modinscritos_comboCursoInscrito',
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
															id: 'modinscritos_textCursoInscrito',
															name: 'curso',
															fieldLabel: 'Curso',
															allowBlank: false,
															anchor: '100%',
															padding: 1,
															flex: 1.8
														},
														{	xtype: 'textfield',
															name: 'matricula',
															fieldLabel: 'Matrícula',
															allowBlank: true,
															flex: 0.7,
															padding: 1
														},
														{	xtype: 'checkboxgroup',
															flex: 1,
															padding: 1,
															fieldLabel: 'Mobilidade ano passado',
															items: [
																{ boxLabel: 'Sim', name: 'mobilidade_ano_passado', inputValue: '1'}
															]
														},
														{	xtype: 'checkboxgroup',
															padding: 1,
															fieldLabel: 'Mobilidade este ano',
															flex: 0.9,
															items: [
																{ boxLabel: 'Sim', name: 'mobilidade_ano_atual', inputValue: '1'}
															]
														}
													]
												}
											]
										},
										{	xtype: 'fieldset',
											title: 'Coordenação de grande área',
											flex: 1,
											height: 80,
											layout: {
												type: 'hbox'
											},
											fieldDefaults: {
												anchor: '100%'
											},
											items:[
												{	xtype: 'checkbox',
													name: 'bool_coordenador',
													allowBlank: false,
													fieldLabel: 'Coordenador',
													boxLabel: 'Sim',
													labelAlign: 'top',
													flex: 1,
													inputValue: '1',
													uncheckedValue: '0',
													checked: false,
													padding: 1,
													listeners: {
														change: function () {
															console.log(this.getValue());
															combo = Ext.getCmp('modinscritos_comboAreaCoordenacao');
															if(this.getValue()){
																combo.enable();
																combo.getStore().load();
															}
															else{
																combo.setValue();
																combo.disable();
															}
														}
													}
												},
												{	xtype: 'combobox',
													fieldLabel: 'Área de coordenação',
													id: 'modinscritos_comboAreaCoordenacao',
													name: 'fgk_area_coordenacao',
													queryMode: 'local',
													disabled: true,
													labelAlign: 'top',
													allowBlank: false,
													editable: true,
													store: "Area",
													typeAhead: true,
													valueField: 'id_area',
													displayField: 'descricao_area',
													triggerAction: 'all',
													minChars:1,
													forceSelection:false,
													anchor: '100%',
													padding: 1,
													flex: 5
												},
											]
										},
										{   xtype: 'fieldset',
											title: 'Endereço',
											flex: 1,
											items: [
												{	xtype: 'fieldcontainer',
													layout: {
														type: 'hbox'
													},
													items: [
														{	xtype: 'combobox',
															fieldLabel: 'Estado',
															id: 'modinscritos_comboEstados',
															name: 'estado',
															queryMode: 'local',
															allowBlank: true,
															editable: true,
															store: "Estados",
															typeAhead: true,
															valueField: 'uf',
															displayField: 'uf',
															triggerAction: 'all',
															minChars:1,
															forceSelection:true,
															anchor: '100%',
															labelWidth: 60,
															padding: 1,
															flex: 1 ,
															listeners: {
																select: function (comboBox, records) {
																	var data = comboBox.findRecordByValue(comboBox.getValue()).data;
																	comboCidade 	= Ext.getCmp('modinscritos_comboCidades');
																	comboCidade.getStore().getProxy().extraParams = {
																		id_estado	: data.id_estado
																	};
																	comboCidade.getStore().load();
																}
															}
														},
														{	xtype: 'combobox',
															fieldLabel: 'Cidade',
															id: 'modinscritos_comboCidades',
															name: 'cidade',
															queryMode: 'local',
															allowBlank: true,
															labelWidth: 50,
															editable: true,
															store: "Cidades",
															typeAhead: true,
															valueField: 'descricao_cidade',
															displayField: 'descricao_cidade',
															triggerAction: 'all',
															minChars:1,
															forceSelection:true,
															anchor: '100%',
															padding: 1,
															flex: 2
														},
														{	xtype: 'textfield',
															name: 'bairro',
															fieldLabel: 'Bairro',
															allowBlank: true,
															anchor: '100%',
															labelWidth: 40,
															flex: 2,
															padding: 1
														}
													]
												},
												{	xtype: 'fieldcontainer',
													layout: {
														type: 'hbox'
													},
													items: [
														{	xtype: 'textfield',
															name: 'endereco',
															labelWidth: 60,
															fieldLabel: 'Endereço',
															allowBlank: true,
															anchor: '100%',
															padding: 1,
															flex: 2.5
														},
														{	xtype: 'textfield',
															name: 'numero',
															fieldLabel: 'Número',
															allowBlank: true,
															anchor: '100%',
															labelWidth: 50,
															flex: 0.8,
															padding: 1
														},
														{	xtype: 'textfield',
															name: 'complemento',
															fieldLabel: 'Complemento',
															allowBlank: true,
															labelWidth: 80,
															anchor: '100%',
															padding: 1,
															flex: 1.3
														},
														{	xtype: 'textfield',
															name: 'cep',
															fieldLabel: 'CEP',
															allowBlank: true,
															anchor: '100%',
															labelWidth: 35,
															flex: 1,
															padding: 1,
															plugins: [{
																ptype: 'ux.textMask',
																mask: '99999-999',
																clearWhenInvalid: true
															}]
														},

													]
												}
											]
										}
								]
							},
							{	xtype: 'gridpanel',
								title: 'Minicursos',
								disabled: true,
								id: 'modinscritos_gridMiniCursos',
								store: 'MiniCursosInscrito',
								listeners: {
									render: function(){
										
										var row = Ext.getCmp('modinscritos_gridInscritos').getSelectionModel().getSelection()[0];
										this.getStore().getProxy().extraParams = {
											id_inscrito: row.data.id
										};
										this.getStore().load();
									}
								},
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
										{ 	text: 'Título',
											dataIndex: 'titulo',
											flex: 1
										}
									]
								}
							}
						]
					}
				]
			}
        ];
        this.dockedItems = [{
            xtype: 'toolbar',
            dock: 'bottom',
            id:'buttons',
            ui: 'footer',
            items: [
				'->',
				{	iconCls: 'icon-access',
					text: 'Alterar senha',
					id: 'modinscritos_btnAlterarSenha',
					hidden: true
				},
				{	iconCls: 'icon-save',
					text: 'Salvar',
					itemId: 'btnSalvarInscrito'
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
