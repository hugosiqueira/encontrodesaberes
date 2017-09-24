Ext.define('Seic.view.Admin.formCadUsuario', {
    extend: 'Ext.window.Window',
    alias : 'widget.formcadusuario',
    requires: [
		'Ext.form.Panel',
		'Ext.form.field.Text',
		'Ext.form.field.ComboBox',
		'Ext.ux.CpfField',
	    'Ext.ux.textMask'
	],
    title : 'Criar usuário',
    layout: 'fit',
    autoShow: true,
    width: 450,
    autoHeight: true,
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
			{	xtype: 'tabpanel',
				items:[
					{   xtype: 'form',
						title: 'Principal',
						padding: '5 5 0 5',
						border: false,
						height: 330,
						fieldDefaults: {
							anchor: '60%',
							labelAlign: 'top',
							msgTarget: 'side'
						},
						items: [
							{	xtype: 'hiddenfield', name: 'id_usuario'},
							{	xtype: 'textfield',
								name: 'nome_usuario',
								fieldLabel: 'Nome completo',
								allowBlank: false,
								anchor: '100%',
								padding: 3
							},
							{	xtype: 'textfield',
								name: 'email',
								fieldLabel: 'Email',
								vtype: 'email',
								allowBlank: false,
								anchor: '100%',
								padding: 3
							},
							{	xtype: 'fieldset',
								title: 'Credenciais para login',
								padding: '5 5 5 5',
								// layout: 'form',
								fieldDefaults: {
									anchor: '60%',
									labelAlign: 'top',
									msgTarget: 'side'
								},
								items:[
									{	xtype: 'cpffield',
										fieldLabel: 'CPF',
										name: 'login',
										padding: 3,
										allowBlank: false,
										labelWidth: 35,
										anchor: '60%',
										plugins: [{
											ptype: 'ux.textMask',
											mask: '999.999.999-99',
											clearWhenInvalid: true
										}]
									},
									{	xtype: 'textfield',
										inputType: 'password',
										allowBlank: true,
										name: 'password',
										id: 'senhaUsuario',
										itemId : 'password',
										fieldLabel: 'Senha',
										anchor: '60%',
										padding: 3,
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
										inputType: 'password',
										allowBlank: true,
										name: 'confpassword',
										fieldLabel: 'Confirmar Senha',
										anchor: '60%',
										padding: 3,
										vtype: 'password',
										initialPassField: 'password'
									}
								]
							}
						]
					}
					,
					{	xtype: 'gridpanel',
						title: 'Eventos vinculados',
						id: 'gridEventosUsuario',
						border: false,
						disabled: true,
						height: 330,
						store: 'EventosDoUsuario',
						columns: {
							defaults: {
								menuDisabled: true,
								resizable: false
							},
							items:[
								{	xtype: 'datecolumn',
									format:'d/m/Y',
									header: "Data início",
									width: 90,
									dataIndex: 'data_evento_ini',
									align: 'center'
								},
								{	header: "Sigla",
									width: 100,
									align: 'center',
									dataIndex: 'sigla'
								},
								{	header: "Título",
									flex: 1,
									dataIndex: 'titulo'
								}
							]
						},						
						listeners: {
							render: function(){
								var row = Ext.getCmp('gridUsuarios').getSelectionModel().getSelection()[0];
								this.getStore().load({
									params:{
										id_usuario: row.data.id_usuario
									}
								});			
							}
						}
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
					action: 'salvarUsuario'
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
