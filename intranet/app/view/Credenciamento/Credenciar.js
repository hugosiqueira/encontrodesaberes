Ext.define('Seic.view.Credenciamento.Credenciar', {
    extend: 'Ext.window.Window',
    id: 'modcre_credenciarinscrito',
    alias: 'widget.modcre_credenciarinscrito',
    title: 'Credenciar inscrito',
    iconCls: 'credenciamento-minishortcut',

    modal: true,
    constrain: true,
    resizable: false,
    border: false,
    bodyBorder: false,
    padding: 3,

    width: 400,
    layout: {
        type: 'form',
        align: 'stretch'
    },

    items: [{
        xtype: 'form',
        border: false,
        items: [{
            xtype:'fieldset',
            title: 'Inscrito',
            id: 'modcre_formInscrito',
            items:[{
                xtype: 'hiddenfield',
                name: 'id',
                itemId: 'id'
            },{  
                xtype: 'cpffield',
                itemId: 'modcre_cpfinscrito',
                readOnly: true,
                fieldLabel: 'CPF',
                name: 'cpf',
                allowBlank: false,
                labelWidth: 40,
                width: 150,
                submitValue: false
            },{
                xtype: 'displayfield',
                itemId: 'inscNome',
                name: 'nome',
                fieldLabel: 'Nome',
                allowBlank: false,
                labelWidth: 35,
                anchor: '100%'
            },{
                xtype: 'displayfield',
                itemId: 'inscEmail',
                name: 'email',
                fieldLabel: 'E-mail',
                labelWidth: 37,
                anchor: '100%'
            }]
        },{
            xtype:'fieldset',
            id: 'divCredencial',
            title: 'Encontro de saberes',
            items: [{
                xtype: 'textfield',
                id: 'nomeCred',
                name: 'nome_credencial',
                hideLabel: true,
                height: 30,
                width: 360,
                padding: '0 0 8 0',// (top, right, bottom, left).
                fieldStyle: {
                    'font-weight': 'bold',
                    'fontSize': '20px',
                    'text-align': 'center',
                }
            },{
                xtype: 'displayfield',
                id: 'inscBarcode',
                name: 'barcode',
                allowBlank: false,
                submitValue: true,
                anchor: '100%',
                height: 35,
                fieldStyle: {
                    'fontFamily': 'BarCode',
                    'fontSize': '45px',
                    'text-align': 'center',
                    'overflow': 'visible'
                }
            },{
                xtype: 'textfield',
                id: 'nomeInst',
                name: 'nome_instituicao',
                hideLabel: true,
                height: 30,
                width: 360,
                border: false,
                fieldStyle: {
                    'text-align': 'center'
                }
            }]
        }]
    }],

    dockedItems: [{
        xtype: 'toolbar',
        dock: 'bottom',
        layout:{
            pack: 'center'
        },
        border: false,
        items: [{
            text: 'Criar credencial',
            itemId: 'salvarCredencial',
            iconCls: 'icon-save',
            hidden: true
        },{
            text: 'Salvar alterações',
            itemId: 'gravarCredencial',
            iconCls: 'icon-save',
            hidden: true
        },{
            text: 'Imprimir credencial',
            itemId: 'modcre_btnPrint',
            iconCls: 'icon-print',
            hidden: true
        }]
    }]
});