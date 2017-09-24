Ext.define('Seic.view.Trabalhos.formCadTrabalho', {
    extend: 'Ext.window.Window',
    alias : 'widget.modtrabalhos_formcadtrabalho',
    id : 'modtrabalhos_formCadTrabalho',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.form.field.ComboBox',
		'Seic.view.Trabalhos.formCadAutor',
		'Seic.view.Trabalhos.gridBuscarAutor'
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
					labelAlign: 'top'
				},
				items: [
					{	xtype: 'hiddenfield', name: 'id', id: 'modtrabalhos_id_trabalho'},
					{	xtype: 'tabpanel',
						id: 'modtrabalhos_tabCadTrabalho',
						border: false,
						items:[
							{	title: 'Dados',
								layout: 'form',
								padding: '5 5 0 5',
								border: false,
								items: [
									{	xtype: 'textareafield',
										height: 60,
										fieldLabel: 'Título',
										allowBlank: false,
										padding: 1,
										flex: 3,
										name: 'titulo_enviado'
									},
									{	xtype: 'fieldcontainer',
										layout: {
											type: 'hbox'
										},
										items: [
											{	xtype: 'combobox',
												fieldLabel: 'Área',
												id: 'modtrabalhos_comboArea',
												name: 'fgk_area',
												queryMode: 'local',
												allowBlank: false,
												editable: true,
												labelWidth: 65,
												store: "Area",
												typeAhead: true,
												valueField: 'id_area',
												displayField: 'descricao_area',
												triggerAction: 'all',
												minChars:1,
												forceSelection:false,
												anchor: '100%',
												padding: 1,
												flex: 1,
												listeners: {
													select: function (comboBox, records) {
														comboAreaEspecifica = Ext.getCmp('modtrabalhos_comboAreaEspecifica');
														comboAreaEspecifica.getStore().getProxy().extraParams = {
															id_area	: comboBox.getValue()
														};
														comboAreaEspecifica.getStore().load();
													}
												}
											},
											{	xtype: 'combobox',
												fieldLabel: 'Área específica',
												id: 'modtrabalhos_comboAreaEspecifica',
												name: 'fgk_area_especifica',
												queryMode: 'local',
												allowBlank: true,
												editable: true,
												labelWidth: 65,
												store: "AreaEspecifica",
												typeAhead: true,
												valueField: 'id',
												displayField: 'descricao_area_especifica',
												triggerAction: 'all',
												minChars:1,
												forceSelection:false,
												anchor: '100%',
												padding: 1,
												flex: 1
											},
											{	xtype: 'combobox',
												fieldLabel: 'Tipo apresentação',
												id: 'modtrabalhos_comboTipoApresentacao',
												name: 'fgk_tipo_apresentacao',
												queryMode: 'local',
												allowBlank: false,
												editable: true,
												labelWidth: 65,
												store: "TipoApresentacao",
												typeAhead: true,
												valueField: 'id_tipo_apresentacao',
												displayField: 'descricao_tipo',
												triggerAction: 'all',
												minChars:1,
												forceSelection:false,
												anchor: '100%',
												padding: 1,
												flex: 1
											}
										]
									},
									{	xtype: 'fieldcontainer',
										layout: {
											type: 'hbox'
										},
										items: [
											{	xtype: 'combobox',
												fieldLabel: 'Órgão fomento',
												id: 'modtrabalhos_comboOrgao',
												name: 'fgk_orgao_fomento',
												queryMode: 'local',
												allowBlank: false,
												editable: true,
												labelWidth: 95,
												store: "OrgaoFomento",
												typeAhead: true,
												valueField: 'id',
												displayField: 'sigla',
												triggerAction: 'all',
												minChars:1,
												forceSelection:false,
												anchor: '100%',
												padding: 1,
												flex: 1
											},
											{	xtype: 'combobox',
												fieldLabel: 'Categoria',
												labelWidth: 65,
												id: 'modtrabalhos_comboCategoria',
												name: 'fgk_categoria',
												queryMode: 'local',
												allowBlank: false,
												editable: true,
												store: "Categorias",
												typeAhead: true,
												valueField: 'id_categoria',
												displayField: 'sigla_categoria',
												triggerAction: 'all',
												minChars:1,
												forceSelection:false,
												anchor: '100%',
												padding: 1,
												flex: 1
											},
											{	xtype      : 'fieldcontainer',
												fieldLabel : 'Apresentação obrigatória',
												defaultType: 'radiofield',
												labelWidth: 100,
												flex: 1,
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
									},

									{	xtype: 'fieldcontainer',
										layout: {
											type: 'hbox'
										},
										items: [

											{	xtype: 'combobox',
												fieldLabel: 'Responsável pela submissão',
												id: 'modtrabalhos_comboInscritoResponsavel',
												name: 'fgk_inscrito_responsavel',
												queryMode: 'local',
												allowBlank: true,
												editable: true,
												flex: 1,
												labelWidth: 95,
												store: "InscritoResponsavel",
												typeAhead: true,
												valueField: 'id',
												displayField: 'nome',
												triggerAction: 'all',
												minChars:1,
												forceSelection:false,
												anchor: '100%',
												padding: 1
											},
											{	xtype: 'combobox',
												fieldLabel: 'Instituição',
												id: 'modtrabalhos_comboInstituicao',
												name: 'fgk_instituicao',
												queryMode: 'local',
												allowBlank: false,
												editable: true,
												labelWidth: 95,
												store: "Instituicao",
												typeAhead: true,
												valueField: 'id',
												displayField: 'sigla',
												triggerAction: 'all',
												minChars:1,
												forceSelection:false,
												anchor: '100%',
												padding: 1,
												flex: 0.5
											},
											{	xtype: 'combobox',
												fieldLabel: 'Situação',
												id: 'modtrabalhos_comboStatus',
												name: 'fgk_status',
												queryMode: 'local',
												allowBlank: false,
												editable: true,
												labelWidth: 65,
												store: "Status",
												typeAhead: true,
												valueField: 'id_status',
												displayField: 'descricao_status',
												triggerAction: 'all',
												minChars:1,
												forceSelection:false,
												anchor: '100%',
												padding: 1,
												flex: 0.5
											},
										]
									},
									{	xtype: 'gridpanel',
										title: 'Autoria',
										padding: '0 0 0 0',
										border: true,
										height: 280,
										disabled: true,
										id: 'modtrabalhos_gridAutores',
										alias : 'widget.modtrabalhos_gridAutores',
										store: 'AutoresTrabalho',
										 viewConfig: {
											plugins: {
												ptype: 'gridviewdragdrop',
												dragText: 'Arraste para reordenar.'
											},
											listeners: {
												drop: function(node, data, overModel, dropPosition){
													var myMask = new Ext.LoadMask({
														msg: 'Aguarde, alterando ordem...',
														target: this
													});
													myMask.show();
													ordem = [];
													this.getStore().each(function(record) {
														ordem.push(record.data.id);
													});
													Ext.Ajax.request({
														url: 'Server/trabalhos/ordenaAutores.php',
														params: {
															id_trabalho: Ext.getCmp('modtrabalhos_id_trabalho').getValue(),
															autores_ordenados: Ext.encode(ordem)
														},
														success: function(conn, response, options, eOpts){
															Ext.getCmp('modtrabalhos_gridAutores').getStore().load();
															myMask.hide();
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
										listeners: {
											itemdblclick: function(grid, record){
												Seic.app.getController('Trabalhos').editarAutorGrid(grid, record);
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
												{ 	text: '#',
													dataIndex: 'ordenacao',
													width: 25
												},
												{ 	text: 'Nome',
													dataIndex: 'nome',
													flex: 1
												},
												{ 	text: 'CPF',
													dataIndex: 'cpf',
													align: 'center',
													width: 105
												},
												{ 	text: 'Email',
													dataIndex: 'email',
													width: 150
												},
												{ 	text: 'Tipo',
													dataIndex: 'descricao_tipo',
													width: 100
												},
												{ 	text: 'Instituição',
													dataIndex: 'sigla_instituicao',
													align: 'center',
													width: 110
												},
												{	header: "Apresentador",
													dataIndex: 'bool_apresentador',
													width: 100,
													align: 'center',
													renderer: function(value, metaData, record, rowIndex, colIndex, store){
														if(value){
															metaData.tdAttr = 'data-qtip="Apresentação obrigatória."';
															metaData.tdCls = 'icon-check';
														}else{
															metaData.tdAttr = 'data-qtip="Apresentação não obrigatória."';
															metaData.tdCls = 'icon-none';
														}
													}
												}
											]
										},
										tbar:[
											{	text: 'Adicionar',
												iconCls: 'icon-add',
												itemId: 'btnAdicionarAutor'
											},
											{	text: 'Editar',
												iconCls: 'icon-edit',
												itemId: 'btnEditarAutor'
											},
											{	text: 'Remover',
												iconCls: 'icon-delete',
												itemId: 'btnApagarAutor'
											}
										]
									}

								]
							},
							{	xtype: 'form',
								id: 'modtrabalhos_formAba2',
								title: 'Submissão',
								border: false,
								padding: '5 5 0 5',
								fieldDefaults: {
									labelAlign: 'top',
									anchor: '100%'
								},
								items: [
									{	xtype: 'textfield',
										fieldLabel: 'Palavras chaves',
										allowBlank: true,
										readOnly: true,
										name: 'palavras_chave'
									},
									{	xtype: 'textareafield',
										height: 200,
										readOnly: true,
										allowBlank: true,
										fieldLabel: 'Resumo',
										labelWidth: 75,
										name: 'resumo_enviado'
									},
									{	xtype: 'textareafield',
										height: 200,
										readOnly: true,
										allowBlank: true,
										fieldLabel: 'Justificativa do orientador',
										labelWidth: 75,
										name: 'descricao'
									},
									{	border: false,
										layout: {
											type: 'vbox'
											,align: 'right'
											,pack: 'center'
										},
										items:[
											{	layout: 'hbox',
												border: false,
												padding: 2,
												items:[
													{	xtype: 'button',
														text: 'Aceitar',
														flex: 1,
														padding: 2,
														disabled: true,
														id: 'modtrabalhos_btnAceitarJustificativa',
														iconCls: 'icon-active'
													},

													{	xtype: 'button',
														flex: 1,
														disabled: true,
														id: 'modtrabalhos_btnRejeitarJustificativa',
														padding: 2,
														iconCls: 'icon-inactive',
														text: 'Rejeitar'
													}
												]
											}
										]

									}
								]
							},
							{	xtype: 'form',
								title: 'Avaliação',
								id: 'modtrabalhos_abaAvaliacao',
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
											{	xtype: 'combobox',
												fieldLabel: 'Situação',
												queryMode: 'local',
												editable: false,
												store:  new Ext.data.ArrayStore({
													fields: ['id', 'value'],
													data : [
														['0', 'Não avaliado'],
														['1', 'Em edição'],
														['2', 'Avaliação submetida'],
														['3', '1º Parecer emitido'],
														['4', 'Parecer final emitido']
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
										fieldLabel: 'Parecer geral',
										name: 'parecer'
									},
									{	xtype: 'textareafield',
										height: 115,
										allowBlank: true,
										readOnly: true,
										fieldLabel: 'Parecer geral (se aprovado com restrições)',
										name: 'parecer_ar'
									}
								],
								listeners:{
									render: function(){
										var myMask = new Ext.LoadMask({
											msg: 'Aguarde, Buscando avaliação...',
											target: Ext.getCmp('modtrabalhos_abaAvaliacao')
										});
										myMask.show();
										Ext.Ajax.request({
											url: 'Server/trabalhos/listarAvaliacaoTrabalho.php',
											params: {
												id_trabalho: Ext.getCmp('modtrabalhos_id_trabalho').getValue()
											},
											success: function(conn, response, options, eOpts){
												var result = Ext.JSON.decode(conn.responseText);
												myMask.hide();
												if(result.success){
													form = Ext.getCmp('modtrabalhos_abaAvaliacao');
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

													// if(result.resultado == "Aprovado com restrições")
														// form.getForm().findField('parecer').hide();
													// else
														// form.getForm().findField('parecer_ar').hide();
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
							{	layout: 'form',
								title: 'Trabalho revisado',
								id: 'modtrabalhos_abaRevisado',
								border: false,
								disabled: true,
								padding: '5 5 0 5',
								fieldDefaults: {
									labelAlign: 'top',
									anchor: '100%'
								},
								items: [
									{	xtype: 'textareafield',
										height: 80,
										fieldLabel: 'Título',
										readOnly: true,
										name: 'titulo_revisado'
									},
									{	xtype: 'textfield',
										fieldLabel: 'Palavras chaves',
										readOnly: true,
										name: 'palavras_chave_revisado'
									},
									{	xtype: 'textareafield',
										height: 350,
										readOnly: true,
										fieldLabel: 'Resumo',
										labelWidth: 75,
										name: 'resumo_revisado'
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
					itemId: 'btnSalvarTrabalho'
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
