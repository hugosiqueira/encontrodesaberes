Ext.define('Seic.view.Admin.formCadEvento', {
    extend: 'Ext.window.Window',
    alias : 'widget.formcadevento',
    requires: ['Ext.form.Panel','Ext.form.field.Text','Seic.view.Admin.formCadTipoCertificado',
	    'Ext.ux.textMask'],
    layout: 'fit',
    autoShow: true,
    width: 850,
    autoHeight: true,
    modal: true,
    initComponent: function() {
        this.items = [
            {   xtype: 'form',
                border: false,
                items: [
					{	xtype: 'tabpanel',
						items:[
							{   xtype: 'form',
								title: 'Principal',
								height: 420,
								padding: '5 5 0 5',
								border: false,
								fieldDefaults: {
									anchor: '100%',
									labelAlign: 'left',
									msgTarget: 'side',
									labelWidth: 45
								},
								items:[
									{	xtype: 'hiddenfield', name: 'id', id: 'modadmin_tabIdEvento'},
									{   xtype: 'fieldcontainer',
										layout: {
											type: 'hbox',
											labelWidth: 60

										},
										items: [
											{	xtype: 'textfield',
												name: 'titulo',
												fieldLabel: 'Título',
												allowBlank: false,
												padding: 1,
												flex: 3
											},
											{	xtype: 'textfield',
												name: 'edicao',
												fieldLabel: 'Edição',
												allowBlank: false,
												padding: 1,
												flex: 1
											},
											{	xtype: 'textfield',
												name: 'sigla',
												fieldLabel: 'Sigla',
												allowBlank: false,
												padding: 1,
												flex: 1
											}
										]
									},
									{	xtype: 'fieldset',
										title: 'Datas',
										items:[
											{   xtype: 'fieldcontainer',
												layout: {
													type: 'hbox',
													labelWidth: 60
												},
												items: [
													{	xtype: 'datefield',
														fieldLabel: 'Inicío',
														name: 'data_evento_ini',
														submitFormat: 'Y-m-d',
														submitValue : true,
														allowBlank: false,
														padding: 3,
														flex: 0.9
													},
													{	xtype: 'textfield',
														name: 'hora_evento_ini',
														emptyText: 'Hora',
														allowBlank: false,
														padding: 3,
														flex: 0.45,
														plugins: [{
															ptype: 'ux.textMask',
															mask: '99:99:99',
															clearWhenInvalid: true
														}]
													},
													{	xtype: 'datefield',
														labelWidth: 35,
														fieldLabel: 'Fim',
														name: 'data_evento_fim',
														submitValue : true,
														submitFormat: 'Y-m-d',
														allowBlank: false,
														padding: 3,
														flex: 0.9
													},
													{	xtype: 'textfield',
														name: 'hora_evento_fim',
														emptyText: 'Hora',
														allowBlank: false,
														padding: 3,
														flex: 0.45,
														plugins: [{
															ptype: 'ux.textMask',
															mask: '99:99:99',
															clearWhenInvalid: true
														}]
													},
													{	xtype: 'datefield',
														fieldLabel: 'Venc. Boleto',
														name: 'data_max_vencimento_boleto',
														submitValue : true,
														labelWidth: 80,
														submitFormat: 'Y-m-d',
														allowBlank: false,
														padding: 3,
														flex: 1.0
													}
												]
											}
										]
									},
									{	xtype: 'panel',
										title: 'Prazos',
										border: false,
										layout: 'form',
										items:[
											{   xtype: 'fieldcontainer',
												layout: {
													type: 'hbox'
												},
												items: [
													{	xtype: 'datefield',
														name: 'data_inscricao_ini',
														submitFormat: 'Y-m-d',
														allowBlank: true,
														labelWidth: 100,
														padding: 1,
														flex: 1.4,
														hideLabel: false,
														fieldLabel: 'Inscrição',
														emptyText: "Data inicial"
													},
													{	xtype: 'textfield',
														name: 'hora_inscricao_ini',
														emptyText: 'Hora inicial',
														allowBlank: true,
														hideLabel: true,
														padding: 1,
														flex: 0.70,
														plugins: [{
															ptype: 'ux.textMask',
															mask: '99:99:99',
															clearWhenInvalid: true
														}]
													},
													{	xtype: 'label',
														text: 'até',
														padding: 7,
														flex: 0.15
													},
													{	xtype: 'datefield',
														name: 'data_inscricao_fim',
														submitFormat: 'Y-m-d',
														allowBlank: true,
														padding: 1,
														flex: 1,
														hideLabel: true,
														emptyText: 'Data final'
													},
													{	xtype: 'textfield',
														name: 'hora_inscricao_fim',
														emptyText: 'Hora final',
														allowBlank: true,
														padding: 1,
														flex: 0.70,
														hideLabel: true,
														plugins: [{
															ptype: 'ux.textMask',
															mask: '99:99:99',
															clearWhenInvalid: true
														}]
													}
												]
											},
											{   xtype: 'fieldcontainer',
												flex: 1,
												layout: {
													type: 'hbox'
												},
												items: [
													{	xtype: 'datefield',
														name: 'data_submissao_ini',
														submitFormat: 'Y-m-d',
														allowBlank: true,
														padding: 1,
														labelWidth: 100,
														flex: 1.4,
														hideLabel: false,
														fieldLabel: 'Submissão',
														emptyText: "Data inicial"
													},
													{	xtype: 'textfield',
														name: 'hora_submissao_ini',
														emptyText: 'Hora inicial',
														allowBlank: true,
														padding: 1,
														flex: 0.70,
														hideLabel: true,
														plugins: [{
															ptype: 'ux.textMask',
															mask: '99:99:99',
															clearWhenInvalid: true
														}]
													},
													{	xtype: 'label',
														text: 'até',
														padding: 7,
														flex: 0.15
													},
													{	xtype: 'datefield',
														name: 'data_submissao_fim',
														submitFormat: 'Y-m-d',
														allowBlank: true,
														padding: 1,
														flex: 1,
														hideLabel: true,
														emptyText: 'Data final'
													},
													{	xtype: 'textfield',
														name: 'hora_submissao_fim',
														emptyText: 'Hora final',
														allowBlank: true,
														padding: 1,
														flex: 0.70,
														hideLabel: true,
														plugins: [{
															ptype: 'ux.textMask',
															mask: '99:99:99',
															clearWhenInvalid: true
														}]
													}
												]
											},
											{   xtype: 'fieldcontainer',
												layout: {
													type: 'hbox'
												},
												items: [
													{	xtype: 'datefield',
														fieldLabel: 'Avaliação',
														name: 'data_avaliacao_ini',
														submitFormat: 'Y-m-d',
														allowBlank: true,
														padding: 1,
														flex: 1.4,
														labelWidth: 100,
														hideLabel: false,
														emptyText: "Data inicial"
													},
													{	xtype: 'textfield',
														name: 'hora_avaliacao_ini',
														emptyText: 'Hora inicial',
														allowBlank: true,
														padding: 1,
														flex: 0.70,
														hideLabel: true,
														plugins: [{
															ptype: 'ux.textMask',
															mask: '99:99:99',
															clearWhenInvalid: true
														}]
													},
													{	xtype: 'label',
														text: 'até',
														padding: 7,
														flex: 0.15
													},
													{	xtype: 'datefield',
														name: 'data_avaliacao_fim',
														submitFormat: 'Y-m-d',
														allowBlank: true,
														padding: 1,
														flex: 1,
														hideLabel: true,
														emptyText: 'Data final'
													},
													{	xtype: 'textfield',
														name: 'hora_avaliacao_fim',
														emptyText: 'Hora final',
														allowBlank: true,
														padding: 1,
														flex: 0.70,
														hideLabel: true,
														plugins: [{
															ptype: 'ux.textMask',
															mask: '99:99:99',
															clearWhenInvalid: true
														}]
													}
												]
											},
											{   xtype: 'fieldcontainer',
												layout: {
													type: 'hbox'
												},
												items: [
													{	xtype: 'datefield',
														fieldLabel: '1º Parecer',
														name: 'data_ini_primeiro_parecer',
														submitFormat: 'Y-m-d',
														allowBlank: true,
														padding: 1,
														labelWidth: 100,
														flex: 1.4,
														hideLabel: false,
														emptyText: "Data inicial"
													},
													{	xtype: 'textfield',
														name: 'hora_ini_primeiro_parecer',
														emptyText: 'Hora inicial',
														allowBlank: true,
														padding: 1,
														flex: 0.70,
														hideLabel: true,
														plugins: [{
															ptype: 'ux.textMask',
															mask: '99:99:99',
															clearWhenInvalid: true
														}]
													},
													{	xtype: 'label',
														text: 'até',
														padding: 7,
														flex: 0.15
													},
													{	xtype: 'datefield',
														name: 'data_fim_primeiro_parecer',
														submitFormat: 'Y-m-d',
														allowBlank: true,
														padding: 1,
														flex: 1,
														hideLabel: true,
														emptyText: 'Data final'
													},
													{	xtype: 'textfield',
														name: 'hora_fim_primeiro_parecer',
														emptyText: 'Hora final',
														allowBlank: true,
														padding: 1,
														flex: 0.70,
														hideLabel: true,
														plugins: [{
															ptype: 'ux.textMask',
															mask: '99:99:99',
															clearWhenInvalid: true
														}]
													}
												]
											},
											{   xtype: 'fieldcontainer',
												layout: {
													type: 'hbox'
												},
												items: [
													{	xtype: 'datefield',
														fieldLabel: 'Sub. minicurso',
														name: 'data_ini_submissao_minicurso',
														submitFormat: 'Y-m-d',
														allowBlank: true,
														padding: 1,
														flex: 1.4,
														labelWidth: 100,
														hideLabel: false,
														emptyText: "Data inicial"
													},
													{	xtype: 'textfield',
														name: 'hora_ini_submissao_minicurso',
														emptyText: 'Hora inicial',
														allowBlank: true,
														padding: 1,
														flex: 0.70,
														hideLabel: true,
														plugins: [{
															ptype: 'ux.textMask',
															mask: '99:99:99',
															clearWhenInvalid: true
														}]
													},
													{	xtype: 'label',
														text: 'até',
														padding: 7,
														flex: 0.15
													},
													{	xtype: 'datefield',
														name: 'data_fim_submissao_minicurso',
														submitFormat: 'Y-m-d',
														allowBlank: true,
														padding: 1,
														flex: 1,
														hideLabel: true,
														emptyText: 'Data final'
													},
													{	xtype: 'textfield',
														name: 'hora_fim_submissao_minicurso',
														emptyText: 'Hora final',
														allowBlank: true,
														padding: 1,
														flex: 0.70,
														hideLabel: true,
														plugins: [{
															ptype: 'ux.textMask',
															mask: '99:99:99',
															clearWhenInvalid: true
														}]
													}
												]
											},
											{   xtype: 'fieldcontainer',
												layout: {
													type: 'hbox'
												},
												items: [
													{	xtype: 'datefield',
														fieldLabel: 'Adequação',
														name: 'data_submissao_adequacao_ini',
														submitFormat: 'Y-m-d',
														allowBlank: true,
														labelWidth: 100,
														padding: 1,
														flex: 1.4,
														hideLabel: false,
														emptyText: "Data inicial"
													},
													{	xtype: 'textfield',
														name: 'hora_submissao_adequacao_ini',
														emptyText: 'Hora inicial',
														allowBlank: true,
														padding: 1,
														flex: 0.70,
														hideLabel: true,
														plugins: [{
															ptype: 'ux.textMask',
															mask: '99:99:99',
															clearWhenInvalid: true
														}]
													},
													{	xtype: 'label',
														text: 'até',
														padding: 7,
														flex: 0.15
													},
													{	xtype: 'datefield',
														fieldLabel: 'Final',
														name: 'data_submissao_adequacao_fim',
														submitFormat: 'Y-m-d',
														allowBlank: true,
														padding: 1,
														flex: 1,
														hideLabel: true,
														emptyText: 'Data final'
													},
													{	xtype: 'textfield',
														name: 'hora_submissao_adequacao_fim',
														emptyText: 'Hora final',
														allowBlank: true,
														padding: 1,
														flex: 0.70,
														hideLabel: true,
														plugins: [{
															ptype: 'ux.textMask',
															mask: '99:99:99',
															clearWhenInvalid: true
														}]
													}
												]
											},
											{   xtype: 'fieldcontainer',
												layout: {
													type: 'hbox'
												},
												items: [
													{	xtype: 'datefield',
														fieldLabel: 'Reavaliação',
														name: 'data_reavaliacao_ini',
														submitFormat: 'Y-m-d',
														allowBlank: true,
														padding: 1,
														flex: 1.4,
														labelWidth: 100,
														hideLabel: false,
														emptyText: "Data inicial"
													},
													{	xtype: 'textfield',
														name: 'hora_reavaliacao_ini',
														emptyText: 'Hora inicial',
														allowBlank: true,
														padding: 1,
														flex: 0.70,
														hideLabel: true,
														plugins: [{
															ptype: 'ux.textMask',
															mask: '99:99:99',
															clearWhenInvalid: true
														}]
													},
													{	xtype: 'label',
														text: 'até',
														padding: 7,
														flex: 0.15
													},
													{	xtype: 'datefield',
														fieldLabel: 'Final',
														name: 'data_reavaliacao_fim',
														submitFormat: 'Y-m-d',
														allowBlank: true,
														padding: 1,
														flex: 1,
														hideLabel: true,
														emptyText: 'Data final'
													},
													{	xtype: 'textfield',
														name: 'hora_reavaliacao_fim',
														emptyText: 'Hora final',
														allowBlank: true,
														padding: 1,
														flex: 0.70,
														hideLabel: true,
														plugins: [{
															ptype: 'ux.textMask',
															mask: '99:99:99',
															clearWhenInvalid: true
														}]
													}
												]
											},
											{   xtype: 'fieldcontainer',
												layout: {
													type: 'hbox'
												},
												items: [
													{	xtype: 'datefield',
														fieldLabel: 'Parecer final',
														name: 'data_ini_parecer_final',
														submitFormat: 'Y-m-d',
														allowBlank: true,
														padding: 1,
														flex: 1.4,
														labelWidth: 100,
														hideLabel: false,
														emptyText: "Data inicial"
													},
													{	xtype: 'textfield',
														name: 'hora_ini_parecer_final',
														emptyText: 'Hora inicial',
														allowBlank: true,
														padding: 1,
														flex: 0.70,
														hideLabel: true,
														plugins: [{
															ptype: 'ux.textMask',
															mask: '99:99:99',
															clearWhenInvalid: true
														}]
													},
													{	xtype: 'label',
														text: 'até',
														padding: 7,
														flex: 0.15
													},
													{	xtype: 'datefield',
														fieldLabel: 'Final',
														name: 'data_fim_parecer_final',
														submitFormat: 'Y-m-d',
														allowBlank: true,
														padding: 1,
														flex: 1,
														hideLabel: true,
														emptyText: 'Data final'
													},
													{	xtype: 'textfield',
														name: 'hora_fim_parecer_final',
														emptyText: 'Hora final',
														allowBlank: true,
														padding: 1,
														flex: 0.70,
														hideLabel: true,
														plugins: [{
															ptype: 'ux.textMask',
															mask: '99:99:99',
															clearWhenInvalid: true
														}]
													}
												]
											}
										]
									}
								]
							},
							{	xtype: 'gridpanel',
								title: 'Usuários vinculados',
								border: false,
								disabled: true,
								id: 'modadmin_gridUsuariosEvento',
								height: 420,
								store: 'UsuariosDoEvento',
								columns: {
									defaults: {
										menuDisabled: true,
										resizable: false
									},
									items:[
										{	header: "Nome",
											flex: 1.5,
											dataIndex: 'nome_usuario'
										},
										{	header: "Grupo",
											flex: 1,
											dataIndex: 'grupo'
										}
									]
								},
								listeners: {
									render: function(){
										var row = Ext.getCmp('gridEventos').getSelectionModel().getSelection()[0];
										this.getStore().load({
											params:{
												id_evento: row.data.id
											}
										});
									}
								}
							},
							{	xtype: 'panel',
								title: 'Logo',
								height: 420,
								border: false,
								disabled: true,
								id: 'modadmin_panelLogoEvento',
								html: '',
								dockedItems : [
									{	xtype: 'toolbar',
										dock: 'bottom',
										items: [
										'->',
										{	iconCls: 'icon-add',
											text: 'Enviar',
											itemId: 'btnUploadLogoEvento'
										},'-',{
											iconCls: 'icon-delete',
											text: 'Apagar',
											disabled: true,
											id: 'modadmin_btnApagarLogoEvento',
											itemId: 'btnApagarLogoEvento'
										},'->'
										]
									}
								]
							},
							{	xtype: 'panel',
								title: 'Plano de fundo',
								border: false,
								height: 420,
								disabled: true,
								id: 'modadmin_panelWallpaperEvento',
								html: '',
								dockedItems : [
									{	xtype: 'toolbar',
										dock: 'bottom',
										items: [
										'->',
										{	iconCls: 'icon-add',
											text: 'Enviar',
											itemId: 'btnUploadWallpaperEvento'
										},'-',{
											iconCls: 'icon-delete',
											text: 'Apagar',
											disabled: true,
											id: 'modadmin_btnApagarWallpaperEvento',
											itemId: 'btnApagarWallpaperEvento'
										},'->'
										]
									}
								]
							},
							{   title: 'Serviços',
								disabled: true,
								id: 'modadmin_gridServicosEvento',
				                layout: 'fit',
								height: 420,
				                items:[{
				                    xtype: 'modadmin_tabservicos'
				                }]
				            },{
				                title: 'Checkpoints',
				                layout: 'fit',
				                height: 420,
				                items:[{
				                    xtype: 'modadmin_tabcheckpoints'
				                }]
				            },{
				            	xtype: 'gridpanel',
								title: 'Certificados',
								disabled: true,
								id: 'modadmin_gridCertificadosEvento',
								border: false,
								height: 420,
								store: 'CertificadosEvento',
								tbar:[
									{	text: 'Adicionar',
										iconCls: 'icon-add',
										itemId: 'btnAdicionarTipoCertificado'
									},
									{	text: 'Editar',
										iconCls: 'icon-edit',
										itemId: 'btnEditarTipoCertificado'
									},
									{	text: 'Apagar',
										iconCls: 'icon-delete',
										itemId: 'btnApagarTipoCertificado'
									}
								],
								columns: {
									defaults: {
										menuDisabled: true,
										resizable: false
									},
									items:[
										{	header: "id_tipo_certificado",
											hidden: true,
											dataIndex: 'id_tipo_certificado'
										},
										{	header: "IMG",
											width: 40,
											align: 'center',
											dataIndex: 'bool_imagem',
											renderer: function(value, metaData, record, rowIndex, colIndex, store){
												if(value){
													metaData.tdCls = 'icon-check'
												}
											}
										},
										{	header: "Descrição",
											flex: 1,
											dataIndex: 'descricao_certificado'
										}
									]
								},
								listeners: {
									render: function(){
										var row = Ext.getCmp('gridEventos').getSelectionModel().getSelection()[0];
										this.getStore().load({
											params:{
												id_evento: row.data.id
											}
										});
									},
									itemdblclick: function(grid, record){
										Seic.app.getController('Admin').editarTipoCertificadoGrid(grid, record);
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
            id:'buttons',
            ui: 'footer',
            items: [
				'->',
				{	iconCls: 'icon-save',
					text: 'Salvar',
					action: 'salvarEvento'
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
