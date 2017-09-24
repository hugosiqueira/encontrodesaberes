Ext.define('Seic.view.Credenciamento.InscRapida', {
    extend: 'Ext.window.Window',
    alias: 'widget.modcre_inscrapida',
    id: 'modcre_inscrapida',
    title: 'Inscrição rápida',
    iconCls: 'credenciamento-minishortcut',

    modal: true,
    constrain: true,
    resizable: false,
    border: false,
    bodyBorder: false,
    width: 500,
    height: 610,

    items: [{
        xtype: 'form',
        itemId: 'formIscrito',
        padding: 5,
        border: false,
        items: [{
            xtype: 'fieldset',
            title: 'Pessoal',
            layout: 'anchor',
            defaults: {
                allowBlank: false,
                labelAlign: 'top',
                anchor: '100%'
            },
            items: [{
                xtype: 'textfield',
                name: 'nome',
                fieldLabel: 'Nome',
                labelWidth: 40
            },{
                layout: 'hbox',
                border: false,
                items:[{
                    xtype: 'textfield',
                    itemId: 'passInsc',
                    fieldLabel: 'Passaporte',
                    name: 'passaporte',
                    allowBlank: false,
                    labelAlign: 'top',
                    labelWidth: 45,
                    width: 110,
                    padding: '0 20 0 0 ',
                    hidden: true,
                    disabled: true
                },{
                    xtype: 'cpffield',
                    itemId: 'cpfInsc',
                    fieldLabel: 'CPF',
                    name: 'cpf',
                    allowBlank: false,
                    labelAlign: 'top',
                    labelWidth: 40,
                    width: 110,
                    padding: '0 20 0 0 ',
                    plugins: [{
                        ptype: 'ux.textMask',
                        mask: '999.999.999-99',
                        clearWhenInvalid: false
                    }],
                    hidden: true,
                    disabled: true
                },{
                    xtype: 'combobox',
                    itemId: 'tipocombo',
                    fieldLabel: 'Tipo',
                    name: 'fgk_tipo',
                    // queryMode: 'remote',
                    // queryParam: 'filtro',
                    labelWidth: 40,
                    width: 327,
                    store: 'TipoInscritos',
                    valueField: 'id_tipo_inscrito',
                    displayField: 'descricao_tipo',
                    forceSelection: true,
                    editable: true,
                    allowBlank: false,
                    labelAlign: 'top',
                    queryMode: 'local',
                    listeners:{
                        render: function(combo){
                            combo.getStore().load();
                        }
                    }
                }]
            },{
                xtype: 'combobox',
                itemId: 'instCombo',
                fieldLabel: 'Instituição',
                name: 'fgk_instituicao',
                // queryParam: 'filtro',
                store: 'InstituicaoInscrito',
                valueField: 'id',
                displayField: 'rend_inst',
                forceSelection: true,
                editable: true,
                allowBlank: false,
                labelAlign: 'top',
                queryMode: 'local',
                listeners:{
                    render: function(combo){
                        combo.getStore().load();
                    }
                }
            },{
                layout: 'hbox',
                border: false,
                items: [{
                    xtype: 'textfield',
                    name: 'email',
                    fieldLabel: 'Email',
                    vtype: 'email',
                    allowBlank: false,
                    labelAlign: 'top',
                    width: 200
                },{
                    xtype: 'textfield',
                    name: 'email_alternativo',
                    fieldLabel: 'Email Alternativo',
                    vtype: 'email',
                    allowBlank: true,
                    labelAlign: 'top',
                    padding: '0 0 0 55',
                    width: 200
                }]
            },{
                layout: 'hbox',
                border: false,
                items: [{
                    xtype: 'textfield',
                    name: 'telefone_celular',
                    fieldLabel: 'Celular',
                    allowBlank: true,
                    labelAlign: 'top',
                    plugins: [{
                        ptype: 'ux.textMask2',
                        mask: '(99)9999-99999',
                        clearWhenInvalid: false
                    }],
                    width: 200
                },{
                    xtype: 'textfield',
                    name: 'telefone',
                    fieldLabel: 'Telefone fixo',
                    allowBlank: true,
                    labelAlign: 'top',
                    padding: '0 0 0 55',
                    plugins: [{
                        ptype: 'ux.textMask2',
                        mask: '(99)9999-99999',
                        clearWhenInvalid: false
                    }],
                    width: 200
                }]
            },{
                layout: 'hbox',
                border: false,
                items: [{
                    xtype: 'radiogroup',
                    fieldLabel: 'Autoriza envio de e-mails',
                    padding: 1,
                    width: 350,
                    labelWidth: 160,
                    items: [{
                        boxLabel: 'Sim',
                        name: 'autoriza_envio_emails',
                        inputValue: '1',
                        checked: true
                    },{
                        boxLabel: 'Não',
                        name: 'autoriza_envio_emails',
                        inputValue: '0'
                    }]
                }]
            },{
                xtype: 'hidden',
                itemId: 'estrangeiro',
                name: 'estrangeiro',
                submitValue: true
            }]
        },{
            xtype: 'fieldset',
            itemId: 'fieldEndereco',
            title: 'Endereço',
            layout: 'anchor',
            // disabled: true,
            defaults: {
                labelAlign: 'top'
            },
            items: [{
                layout: 'hbox',
                border: false,
                items: [{
                    xtype: 'textfield',
                    itemId: 'textEstado',
                    fieldLabel: 'Estado',
                    labelWidth: 60,
                    width: 185,
                    labelAlign: 'top',
                    hidden: true,
                    submitValue: false
                },{
                    xtype: 'combobox',
                    itemId: 'comboEstado',
                    fieldLabel: 'Estado',
                    name: 'estado',
                    // queryMode: 'remote',
                    // queryParam: 'filtro',
                    store: "Estados",
                    valueField: 'uf',
                    displayField: 'descricao_estado_uf',
                    labelWidth: 60,
                    width: 185,
                    forceSelection: true,
                    editable: true,
                    labelAlign: 'top',
                    hidden: true,
                    disabled: true,
                    queryMode: 'local',
                    listeners:{
                        render: function(combo){
                            combo.getStore().load();
                        }
                    }
                    
                },{
                    xtype: 'textfield',
                    itemId: 'textCidade',
                    fieldLabel: 'Cidade',
                    name: 'cidade',
                    labelWidth: 30,
                    width: 260,
                    padding: '0 0 0 10',
                    labelAlign: 'top',
                    hidden: true,
                    disabled: true
                },{
                    xtype: 'combobox',
                    itemId: 'comboCidade',
                    fieldLabel: 'Cidade',
                    name: 'cidade',
                    // queryMode: 'remote',
                    // queryParam: 'filtro',
                    labelWidth: 30,
                    width: 260,
                    store: "Cidades",
                    valueField: 'descricao_cidade',
                    displayField: 'descricao_cidade',
                    forceSelection:true,
                    editable: true,
                    disabled: true,
                    padding: '0 0 0 10',
                    labelAlign: 'top',
                    hidden: true,
                    queryMode: 'local'
                }]
            },{
                layout: 'hbox',
                border: false,
                items: [{
                    xtype: 'textfield',
                    name: 'bairro',
                    fieldLabel: 'Bairro',
                    labelWidth: 40,
                    labelAlign: 'top'
                },{
                    xtype: 'textfield',
                    name: 'endereco',
                    labelWidth: 60,
                    width: 263,
                    fieldLabel: 'Logradouro',
                    labelAlign: 'top',
                    padding: '0 0 0 10'
                }]
            },{
                layout: 'hbox',
                border: false,
                padding: '0 0 9 0',
                items: [{
                    xtype: 'textfield',
                    name: 'numero',
                    fieldLabel: 'Número',
                    labelWidth: 50,
                    width: 60,
                    labelAlign: 'top'
                },{
                    xtype: 'textfield',
                    name: 'complemento',
                    fieldLabel: 'Complemento',
                    labelWidth: 80,
                    width: 285,
                    labelAlign: 'top',
                    padding: '0 0 0 10'
                },{
                    xtype: 'textfield',
                    itemId: 'inscCEP',
                    name: 'cep',
                    fieldLabel: 'CEP',
                    labelAlign: 'top',
                    labelWidth: 35,
                    width: 90,
                    padding: '0 0 0 10',
                    plugins: [{
                        ptype: 'ux.textMask',
                        mask: '99999-999',
                        clearWhenInvalid: true
                    }]
                }]
            }]
        },{
            xtype: 'combobox',
            itemId: 'servCombo',
            fieldLabel: 'Serviço de inscrição',
            name: 'fgk_servico',
            // queryMode: 'remote',
            // queryParam: 'filtro',
            store: 'Seic.store.Admin.Servicos',
            valueField: 'id',
            displayField: 'descricao_servico',
            forceSelection: true,
            editable: true,
            allowBlank: false,
            labelAlign: 'top',
            width: 480,
            queryMode: 'local',
            listeners:{
                render: function(combo){
                    combo.getStore().load();
                }
            }
        }]
    }],

    dockedItems: [{
        xtype: 'toolbar',
        dock: 'bottom',
        border: false,
        items: ['->',{
            text: 'Gravar',
            itemId: 'gravarNovo',
            iconCls: 'icon-save',
            // disabled: true
        },{
            text: 'Cancelar',
            iconCls: 'icon-cancel',
            listeners: {
                click: {
                    fn: function(button){
                        button.up('window').close();
                    }
                }
            }
        }]
    }]
});