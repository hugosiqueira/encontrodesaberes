Ext.define('Seic.view.TrabalhosSeinter.formCadTrabalhosSeinter', {
    extend: 'Ext.window.Window',
    alias : 'widget.modtrabalhosseinter_formcadtrabalhosseinter',
    id : 'modtrabalhosseinter_formCadTrabalhosSeinter',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.ux.CounterTextField',
		'Seic.view.TrabalhosSeinter.formBuscaAvancada',
		'Ext.form.field.ComboBox'
	],
    layout: 'fit',
    autoShow: true,
	jsonSubmit: true,
	border: false,
    width: 750,
    height: 630,
    modal: true,
    initComponent: function() {
		this.items = [
			{	xtype: 'form',
				autoScroll : true,
                border: false,
				fieldDefaults: {
					anchor: '100%',
					labelAlign: 'top',
					padding: '5 0 5 5'
				},
				items: [
					{	xtype: 'tabpanel',
						border: false,
						items:[
							{	title: 'Dados',
								layout: 'form',
								padding: '5 5 5 5',
								border: false,
								items: [
									{	xtype: 'hiddenfield', name: 'id', id: 'modtrabalhosseinter_id_trabalho'},
									{	xtype: 'fieldset',
										title: 'Principal',
										items:[
											{	xtype: 'fieldcontainer',
												layout: {
													type: 'hbox'
												},
												items: [
													{	xtype: 'textfield',
														fieldLabel: 'Nome',
														flex: 3,
														allowBlank: false,
														name: 'nome_aluno',
														padding: 1,
														fieldStyle: 'font-weight: bold;'
													},
													{	xtype: 'cpffield',
														fieldLabel: 'CPF',
														name: 'cpf',
														flex: 1,
														anchor: '50%',
														allowBlank: false,
														labelWidth: 65,
														fieldStyle: 'font-weight: bold;',
														plugins: [{
															ptype: 'ux.textMask',
															mask: '999.999.999-99',
															clearWhenInvalid: true
														}],
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
														fieldLabel: 'Curso',
														flex: 3,
														allowBlank: false,
														fieldStyle: 'font-weight: bold;',
														name: 'curso_aluno',
														padding: 1
													},
													{	xtype: 'numberfield',
														fieldStyle: 'font-weight: bold;',
														fieldLabel: 'Período que cursava',
														flex: 1,
														allowBlank: false,
														name: 'periodo_cursava',
														padding: 1,
														maxValue: 99,
														minValue: 0
													}

												]
											},
											{	xtype: 'fieldcontainer',
												layout: {
													type: 'hbox'
												},
												items: [
													{	xtype: 'textfield',
														fieldLabel: 'Universidade de Destino',
														flex: 1,
														allowBlank: true,
														fieldStyle: 'font-weight: bold;',
														name: 'universidade_destino',
														padding: 1
													},
													{	xtype: 'textfield',
														fieldLabel: 'Curso de Destino',
														flex: 1,
														allowBlank: true,
														name: 'curso_destino',
														fieldStyle: 'font-weight: bold;',
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
														fieldLabel: 'Páis de Destino',
														flex: 1,
														allowBlank: true,
														name: 'pais_destino',
														fieldStyle: 'font-weight: bold;',
														padding: 1
													},
													{	xtype: 'textfield',
														fieldLabel: 'Cidade de Destino',
														flex: 1,
														allowBlank: true,
														fieldStyle: 'font-weight: bold;',
														name: 'cidade_destino',
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
														fieldLabel: 'Tipo de mobilidade',
														queryMode: 'local',
														fieldStyle: 'font-weight: bold;',
														allowBlank: false,
														editable: false,
														store:  new Ext.data.ArrayStore({
															fields: ['id', 'descricao'],
															data : [
																[1, 'Ciência sem fronteiras'],
																[2, 'Mobilidade CAINT']
															]
														}),
														flex: 1,
														typeAhead: false,
														valueField: 'id',
														displayField: 'descricao',
														triggerAction: 'all',
														forceSelection:true,
														name: 'tipo_mobilidade',
														padding: 1
													},
													{	xtype: 'numberfield',
														fieldLabel: 'Meses afastado',
														flex: 1,
														fieldStyle: 'font-weight: bold;',
														allowBlank: false,
														name: 'tempo_afastamento',
														padding: 1,
														maxValue: 99,
														minValue: 0
													},
													{	xtype: 'combobox',
														fieldLabel: 'Situação',
														id: 'modtrabalhosseinter_comboStatus',
														name: 'fgk_status',
														queryMode: 'local',
														allowBlank: false,
														editable: true,
														labelWidth: 65,
														store: "Status",
														typeAhead: true,
														fieldStyle: 'font-weight: bold;',
														valueField: 'id_status',
														displayField: 'descricao_status',
														triggerAction: 'all',
														minChars:1,
														forceSelection:false,
														anchor: '100%',
														padding: 1,
														flex: 1
													}

												]
											}
										]
									},
									{	xtype: 'textareafield',
										height: 100,
										allowBlank: true,
										fieldLabel: 'Quais são áreas/cursos de destaque da Universidade em que você esteve?',
										labelSeparator: '',
										fieldStyle: 'font-weight: bold;',
										plugins: ['counter'],
										maxLength: 70,
										name: 'curso_area_destaque'
									},
									{	xtype: 'textareafield',
										height: 120,
										allowBlank: true,
										fieldLabel: ' Fale sobre a questão linguística na Universidade de destino: se haviam cursos de idiomas, como funcionavam, se haviam disciplinas ofertadas em outros idiomas, a dificuldades enfrentadas.',
										labelSeparator: '',
										plugins: ['counter'],
										fieldStyle: 'font-weight: bold;',
										maxLength: 500,
										name: 'questoes_linguisticas'
									},
									{	xtype: 'textareafield',
										height: 120,
										allowBlank: true,
										fieldLabel: 'Descreva o tipo de moradia que você utilizou durante sua mobilidade (gratuita ou não, compartilhada, demais ofertas de imóveis e possibilidades, valores, estrutura...).',
										labelSeparator: '',
										plugins: ['counter'],
										fieldStyle: 'font-weight: bold;',
										maxLength: 500,
										name: 'tipo_moradia'
									},
									{	xtype: 'textareafield',
										height: 120,
										allowBlank: true,
										fieldLabel: 'Descreva como é o sistema de avaliação e notas da Universidade onde esteve (Formas de avaliação, grau de dificuldade, formas de preparação para as avaliações, curiosidades...).',
										labelSeparator: '',
										plugins: ['counter'],
										fieldStyle: 'font-weight: bold;',
										maxLength: 700,
										name: 'sistema_avaliacao'
									},
									{	xtype: 'textareafield',
										height: 140,
										fieldStyle: 'font-weight: bold;',
										allowBlank: true,
										fieldLabel: 'Descreva como é a dinâmica/metodologia das aulas na Universidade de destino. Fale sobre o formato das aulas, atividades práticas e teóricas, trabalhos em grupo, monitorias. Aproveite e faça um comparativo com o nosso modelo aqui na UFOP.',
										labelSeparator: '',
										plugins: ['counter'],
										maxLength: 700,
										name: 'dinamica_metodologia_aulas'
									},
									{	xtype: 'textareafield',
										height: 120,
										allowBlank: true,
										fieldLabel: 'Descreva o custo de vida para um estudante na cidade/país onde você morou. Fale sobre alguns preços, comparativos, principais despesas, vantagens, desvantagens...',
										labelSeparator: '',
										plugins: ['counter'],
										fieldStyle: 'font-weight: bold;',
										maxLength: 500,
										name: 'custo_vida'
									},
									{	xtype: 'textareafield',
										height: 120,
										allowBlank: true,
										fieldLabel: 'Fale sobre a infra estrutura da Universidade em que esteve: laboratórios, bibliotecas, centros esportivos, parte administrativa, salas de aula e estudo...',
										labelSeparator: '',
										fieldStyle: 'font-weight: bold;',
										plugins: ['counter'],
										maxLength: 700,
										name: 'infra_universidade'
									},
									{	xtype: 'textareafield',
										height: 100,
										allowBlank: true,
										fieldLabel: ' Como funciona o serviço de acolhimento e suporte a alunos estrangeiros na Universidade de destino?',
										labelSeparator: '',
										fieldStyle: 'font-weight: bold;',
										plugins: ['counter'],
										maxLength: 500,
										name: 'servico_acolhimento'
									},
									{	xtype: 'textareafield',
										height: 120,
										allowBlank: true,
										fieldLabel: 'Com relação ao estágio? Como ele é considerado e avaliado na Universidade onde estudou? E em relação à oferta? Como localizar um estágio? A Universidade dá algum suporte? Como foi a experiência ao realizar o estágio.',
										labelSeparator: '',
										plugins: ['counter'],
										maxLength: 700,
										fieldStyle: 'font-weight: bold;',
										name: 'estagio'
									},
									{	xtype: 'textareafield',
										height: 120,
										allowBlank: true,
										fieldLabel: ' Quais atividades são oferecidas pela Universidade de destino: Fale sobre grupos de estudos, atividades de pesquisa, esporte, atividades culturais, lazer...',
										labelSeparator: '',
										fieldStyle: 'font-weight: bold;',
										plugins: ['counter'],
										maxLength: 700,
										name: 'atividades_universidade'
									},
									{	xtype: 'textareafield',
										height: 120,
										allowBlank: true,
										fieldLabel: 'Como foi o seu processo de adaptação à cidade e ao país de destino? Dificuldades com clima, idioma, receptividade, inserção cultural.',
										labelSeparator: '',
										plugins: ['counter'],
										maxLength: 500,
										fieldStyle: 'font-weight: bold;',
										name: 'processo_adaptacao'
									},
									{	xtype: 'textareafield',
										height: 180,
										allowBlank: true,
										fieldLabel: 'Relato  pessoal.  Fale  sobre  a  sua  experiência  pessoal  de  maneira  geral,  sobre  demais  atividades acadêmicas,  esportivas, culturais que desenvolveu, experiências profissionais,  amadurecimento, rede  decontatos  (tente  priorizar  as  atividades  relacionadas  à  sua  formação  pessoal,  acadêmica  e  profissional,evitando expor elementos exclusivamente de entreterimento).',
										labelSeparator: '',
										plugins: ['counter'],
										fieldStyle: 'font-weight: bold;',
										maxLength: 700,
										name: 'relato_pessoal'
									},
									{	xtype: 'textareafield',
										height: 120,
										allowBlank: true,
										fieldLabel: 'Quais conselhos você poderia dar para um calouro que quer se preparar para fazer mobilidade na mesma Universidade/país que você esteve?',
										labelSeparator: '',
										fieldStyle: 'font-weight: bold;',
										name: 'conselhos_calouro'
									}
								]
							},
							{	xtype: 'form',
								title: 'Avaliação',
								id: 'modtrabalhosseinter_abaAvaliacao',
								disabled: true,
								border: false,
								padding: '5 5 5 5',
								fieldDefaults: {
									labelAlign: 'top',
									anchor: '100%'
								},
								items: [
									{	xtype: 'hiddenfield', name: 'id_avaliacao'},
									{	xtype: 'fieldcontainer',
										layout: {
											type: 'hbox'
										},
										items: [
											// {	xtype: 'textfield',
												// fieldLabel: 'Coordenador',
												// readOnly: true,
												// name: 'nome_coordenador',
												// padding: 1,
												// flex: 3
											// },
											{	xtype: 'combobox',
												fieldLabel: 'Situação',
												queryMode: 'local',
												editable: false,
												store:  new Ext.data.ArrayStore({
													fields: ['id', 'value'],
													data : [
														['0', 'Não avaliado'],
														['1', 'Em edição'],
														['2', 'Avaliação submetida']
													]
												}),
												flex: 1,
												typeAhead: false,
												readOnly: true,
												valueField: 'id',
												displayField: 'value',
												triggerAction: 'all',
												name: 'status',
												padding: 1
											},
											{	xtype: 'textfield',
												fieldLabel: 'Nota',
												readOnly: true,
												flex: 0.5,
												name: 'nota',
												padding: 1
											},
											{	xtype: 'textfield',
												fieldLabel: 'Resultado',
												readOnly: true,
												labelWidth: 70,
												flex: 1,
												padding: 1,
												name: 'resultado'
											}
										]
									},
									// {	xtype: 'fieldcontainer',
										// layout: {
											// type : 'hbox',
											// pack : 'end'
										// },
										// items: [
											// {	xtype: 'textfield',
												// labelAlign: 'left',
												// fieldLabel: 'Resultado',
												// readOnly: true,
												// width: 215,
												// labelWidth: 70,
												
												// padding: 1,
												// name: 'resultado'
											// }
										// ]
									// },
									{	xtype: 'fieldset',
										title: 'Primeiro revisor',
										fieldDefaults: {
											anchor: '100%',
											labelAlign: 'top',
											labelWidth: 45
										},
										items:[
											{	xtype: 'fieldcontainer',
												layout: {
													type: 'hbox'
												},
												items: [
													{	xtype: 'displayfield', 
														fieldLabel: 'Nome',
														readOnly: true,
														flex: 3,
														padding: 1,
														name: 'nome_revisor1'
													},
													{	xtype: 'displayfield', 
														fieldLabel: 'Tipo',
														readOnly: true,
														flex: 1,
														padding: 1,
														name: 'tipo_revisor1'
													},
													{	xtype: 'displayfield', 
														fieldLabel: 'Nota',
														readOnly: true,
														flex: 1,
														padding: 1,
														name: 'nota1'
													}
												]
											},
											{	xtype: 'fieldcontainer',
												layout: {
													type: 'hbox'
												},
												items: [
													{	xtype: 'displayfield', 
														fieldLabel: 'Avaliação Conclusão',
														readOnly: true,
														flex: 1,
														padding: 1,
														name: 'aval_conclusao1'
													},
													{	xtype: 'displayfield', 
														fieldLabel: 'Avaliação Metodologia',
														readOnly: true,
														flex: 1,
														padding: 1,
														name: 'aval_metodologia1'
													},
													{	xtype: 'displayfield', 
														fieldLabel: 'Avaliação Redação',
														readOnly: true,
														flex: 1,
														padding: 1,
														name: 'aval_redacao1'
													}
												]
											},
											{	xtype: 'fieldcontainer',
												layout: {
													type: 'hbox'
												},
												items: [
													{	xtype: 'displayfield', 
														fieldLabel: 'Avaliação Resultados',
														readOnly: true,
														flex: 1,
														padding: 1,
														name: 'aval_resultado1'
													},
													// {	xtype: 'displayfield', 
														// fieldLabel: 'Avaliação Titulo',
														// readOnly: true,
														// flex: 1,
														// padding: 1,
														// name: 'aval_titulo1'
													// },
													{	xtype: 'displayfield', 
														fieldLabel: 'Resultado Final',
														readOnly: true,
														flex: 1,
														padding: 1,
														name: 'resultado1'
													}
												]
											},
											{	xtype: 'fieldcontainer',
												layout: {
													type: 'hbox'
												},
												items: [
													{	xtype: 'textareafield',
														height: 80,
														
														allowBlank: true,
														readOnly: true,
														flex: 1,
														padding: '1 1 10 1',
														fieldLabel: 'Justificativa',
														name: 'justificativa1'
													},
													{	xtype: 'textareafield',
														height: 80,
														
														flex: 1,
														allowBlank: true,
														padding: '1 1 10 1',
														readOnly: true,
														fieldLabel: 'Parecer ao coordenador',
														name: 'parecer1'
													},
												]
											}
										]
									},
									{	xtype: 'fieldset',
										title: 'Segundo revisor',
										fieldDefaults: {
											anchor: '100%',
											labelAlign: 'top',
											labelWidth: 45
										},
										items:[
											{	xtype: 'fieldcontainer',
												layout: {
													type: 'hbox'
												},
												items: [
													{	xtype: 'displayfield', 
														fieldLabel: 'Nome',
														readOnly: true,
														flex: 3,
														padding: 1,
														name: 'nome_revisor2'
													},
													{	xtype: 'displayfield', 
														fieldLabel: 'Tipo',
														readOnly: true,
														flex: 1,
														padding: 1,
														name: 'tipo_revisor2'
													},
													{	xtype: 'displayfield', 
														fieldLabel: 'Nota',
														readOnly: true,
														flex: 1,
														padding: 1,
														name: 'nota2'
													}
												]
											},
											{	xtype: 'fieldcontainer',
												layout: {
													type: 'hbox'
												},
												items: [
													{	xtype: 'displayfield', 
														fieldLabel: 'Avaliação Conclusão',
														readOnly: true,
														flex: 1,
														padding: 1,
														name: 'aval_conclusao2'
													},
													{	xtype: 'displayfield', 
														fieldLabel: 'Avaliação Metodologia',
														readOnly: true,
														flex: 1,
														padding: 1,
														name: 'aval_metodologia2'
													},
													{	xtype: 'displayfield', 
														fieldLabel: 'Avaliação Redação',
														readOnly: true,
														flex: 1,
														padding: 1,
														name: 'aval_redacao2'
													}
												]
											},
											{	xtype: 'fieldcontainer',
												layout: {
													type: 'hbox'
												},
												items: [
													{	xtype: 'displayfield', 
														fieldLabel: 'Avaliação Resultados',
														readOnly: true,
														flex: 1,
														padding: 1,
														name: 'aval_resultado2'
													},
													// {	xtype: 'displayfield', 
														// fieldLabel: 'Avaliação Titulo',
														// readOnly: true,
														// flex: 1,
														// padding: 1,
														// name: 'aval_titulo2'
													// },
													{	xtype: 'displayfield', 
														fieldLabel: 'Resultado Final',
														readOnly: true,
														flex: 1,
														padding: 1,
														name: 'resultado2'
													}
												]
											},
											{	xtype: 'fieldcontainer',
												layout: {
													type: 'hbox'
												},
												items: [
													{	xtype: 'textareafield',
														height: 80,
														
														allowBlank: true,
														readOnly: true,
														flex: 1,
														padding: '1 1 10 1',
														fieldLabel: 'Justificativa',
														name: 'justificativa2'
													},
													{	xtype: 'textareafield',
														height: 80,
														
														flex: 1,
														allowBlank: true,
														padding: '1 1 10 1',
														readOnly: true,
														fieldLabel: 'Parecer ao coordenador',
														name: 'parecer2'
													},
												]
											}
										]
									},
									{	xtype: 'textareafield',
										height: 115,
										allowBlank: true,
										readOnly: true,
										fieldLabel: 'Parecer',
										name: 'parecer'
									},
									{	xtype: 'textareafield',
										height: 115,
										allowBlank: true,
										readOnly: true,
										fieldLabel: 'Parecer',
										name: 'parecer_ar'
									}
								],
								listeners:{
									render: function(){
										var myMask = new Ext.LoadMask({
											msg: 'Aguarde, Buscando avaliação...',
											target: Ext.getCmp('modtrabalhosseinter_abaAvaliacao')
										});
										myMask.show();
										Ext.Ajax.request({
											url: 'Server/trabalhosseinter/listarAvaliacaoTrabalho.php',
											params: {
												id_trabalho: Ext.getCmp('modtrabalhosseinter_id_trabalho').getValue()
											},
											success: function(conn, response, options, eOpts){
												var result = Ext.JSON.decode(conn.responseText);
												myMask.hide();
												if(result.success){
													form = Ext.getCmp('modtrabalhosseinter_abaAvaliacao');
													// form.getForm().findField('nome_coordenador').setValue(result.nome_coordenador);
													form.getForm().findField('status').setValue(result.status);
													form.getForm().findField('nota').setValue(result.nota);
													form.getForm().findField('resultado').setValue(result.resultado);
													form.getForm().findField('nome_revisor1').setValue(result.nome_revisor1);
													form.getForm().findField('tipo_revisor1').setValue(result.tipo_revisor1);
													form.getForm().findField('nota1').setValue(result.nota1);
													form.getForm().findField('aval_conclusao1').setValue(result.aval_conclusao1);
													form.getForm().findField('aval_metodologia1').setValue(result.aval_metodologia1);
													form.getForm().findField('aval_resultado1').setValue(result.aval_resultado1);
													// form.getForm().findField('aval_titulo1').setValue(result.aval_titulo1);
													form.getForm().findField('aval_redacao1').setValue(result.aval_redacao1);
													form.getForm().findField('justificativa1').setValue(result.justificativa1);
													form.getForm().findField('parecer1').setValue(result.parecer1);
													form.getForm().findField('resultado1').setValue(result.resultado1);
													form.getForm().findField('resultado2').setValue(result.resultado2);
													form.getForm().findField('nome_revisor2').setValue(result.nome_revisor2);
													form.getForm().findField('tipo_revisor2').setValue(result.tipo_revisor2);
													form.getForm().findField('nota2').setValue(result.nota2);
													form.getForm().findField('aval_conclusao2').setValue(result.aval_conclusao2);
													form.getForm().findField('aval_metodologia2').setValue(result.aval_metodologia2);
													form.getForm().findField('aval_resultado2').setValue(result.aval_resultado2);
													// form.getForm().findField('aval_titulo2').setValue(result.aval_titulo2);
													form.getForm().findField('aval_redacao2').setValue(result.aval_redacao2);
													form.getForm().findField('justificativa2').setValue(result.justificativa2);
													form.getForm().findField('parecer2').setValue(result.parecer2);
													form.getForm().findField('parecer').setValue(result.parecer);
													form.getForm().findField('parecer_ar').setValue(result.parecer_ar);
													if(result.resultado == "Aprovado com restrições")
														form.getForm().findField('parecer').hide();
													else
														form.getForm().findField('parecer_ar').hide();
												}
											},
											failure: function(conn, response, options, eOpts) {
												myMask.hide();
												Ext.Msg.show({
													title:'Erro',
													msg: 'Entre em contato com o administrador do sistema. ERRO_01CON',
													icon: Ext.Msg.ERROR,
													buttons: Ext.Msg.OK
												});
											}
										});
									}
								}
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
					itemId: 'btnSalvarTrabalhoSeinter'
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
