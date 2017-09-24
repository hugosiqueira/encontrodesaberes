Ext.define('Seic.view.Financeiro.detailBoleto', {
    extend: 'Ext.window.Window',
    alias: 'widget.modpfin_detailboleto',
    title: 'Informações de pagamento',
    iconCls: 'financeiro-minishortcut',
    layout: {
        type: 'fit',
        align: 'stretch'
    },
    width: 400,
    modal: true,
    constrain: true,
    resizable: false,

    requires: [
        'Ext.ux.CpfField',
        'Ext.ux.textMask'
    ],

    items: [{
        xtype: 'form',
        padding: '0 6 0 6',// (top, right, bottom, left).
        border: false,
        items: [{
            xtype: 'fieldset',
            id: 'modfin_fieldsetDetailIsc',
            title: 'Inscrito',
            items: [{
                layout: 'hbox',
                border: false,
                items: [{   
                    xtype: 'displayfield',
                    fieldLabel: 'CPF',
                    itemId: 'inscritoCPF',
                    name: 'cpf',
                    labelWidth: 40,
                    width: 150,
                    submitValue: true,
                    plugins: [{
                        ptype: 'ux.textMask',
                        mask: '999.999.999-99',
                        clearWhenInvalid: false
                    }]
                }]
            },{
                xtype: 'displayfield',
                id: 'modfin_formIscNome',
                name: 'aluno',
                fieldLabel: 'Nome',
                labelWidth: 40,
            },{
                xtype: 'displayfield',
                id: 'modfin_formIscEmail',
                name: 'aluno_email',
                fieldLabel: 'E-mail',
                labelWidth: 40,
            },{
                xtype: 'displayfield',
                id: 'modfin_formIscTipo',
                name: 'descricao_tipo',
                fieldLabel: 'Tipo',
                labelWidth: 35,
            }]
        },{
            xtype: 'fieldset',
            title: 'Boleto',
            items: [{
                xtype: 'displayfield',
                name: 'StatusBoleto',
                fieldLabel: 'Status',
                submitValue: true,
                labelWidth: 40,
            },{
                xtype: 'displayfield',
                name: 'Valor',
                fieldLabel: 'Valor',
                submitValue: true,
                labelWidth: 35,
                renderer: function(value, metaData){
                    Ext.apply(Ext.util.Format, {
                        thousandSeparator : ".",
                        decimalSeparator  : ","
                    });
                    return "R$ " + Ext.util.Format.number(value/100, '0.0,0');
                }
            },{
                xtype: 'displayfield',
                name: 'ValorPago',
                fieldLabel: 'Valor pago',
                submitValue: true,
                labelWidth: 70,
                renderer: function(value, metaData){
                    Ext.apply(Ext.util.Format, {
                        thousandSeparator : ".",
                        decimalSeparator  : ","
                    });
                    return "R$ " + Ext.util.Format.number(value/100, '0.0,0');
                }
            },{
                xtype: 'displayfield',
                name: 'Emissao',
                fieldLabel: 'Emissão',
                submitValue: true,
                labelWidth: 55,
            },{
                xtype: 'displayfield',
                name: 'Vencimento',
                fieldLabel: 'Vencimento',
                submitValue: true,
                labelWidth: 70,
            },{
                xtype: 'displayfield',
                name: 'Pagamento',
                fieldLabel: 'Pagamento',
                submitValue: true,
                labelWidth: 70,
            },{
                xtype: 'textfield',
                name: 'Link',
                fieldLabel: 'Link',
                submitValue: true,
                labelWidth: 35,
                anchor: '100%',
                allowBlank: false
            }]
        },{
            xtype: 'combobox',
            name: 'servico',
            fieldLabel: 'Serviço',
            labelAlign: 'top',
            anchor: '100%',
            valueField: 'id',
            displayField: 'descricao_servico', 
            store: 'Seic.store.Admin.Servicos',
            queryMode: 'remote',
            queryParam: 'filtro',
            forceSelection: true,
            allowBlank: false
        },{
            xtype: 'hiddenfield',
            name: 'Chave',
        }]
    }],

    dockedItems: [{
        xtype: 'toolbar',
        dock: 'bottom',
        border: false,
        bodyBorder: false,
        items: ['->',{
            text: 'Salvar boleto',
            itemId: 'btnConfirmar',
            iconCls: 'icon-check'
        }]
    }]
});