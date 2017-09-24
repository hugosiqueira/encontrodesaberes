Ext.define('Seic.view.Financeiro.buscaInscritos',{
    extend: 'Ext.window.Window',
    id: 'modfin_buscainscritos',
    iconCls:'financeiro-minishortcut',
    alias: 'widget.buscainscritos',
    title: 'Buscar inscritos',
    height: 375,
    width: 400,
    autoShow: true,
    modal: true,
    constrain: true,
    resizable: false,
    bodyBorder: false,
    layout: 'fit',
    
    items: {
            xtype: 'form',
            border: false,
            padding: '7 7 7 7', //(top, right, bottom, left).  
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
            items:[{
                layout: 'hbox',
                border: false,
                items: [{
                    xtype: 'cpffield',
                    fieldLabel: 'CPF',
                    labelAlign: 'top',
                    name: 'cpf',
                    labelWidth: 30,
                    width: 105,
                    padding: '0 50 0 0', //(top, right, bottom, left). 
                    plugins: [{
                        ptype: 'ux.textMask',
                        mask: '999.999.999-99',
                        clearWhenInvalid: true
                    }]
                },{
                    xtype: 'numberfield',
                    name: 'num_servicos',
                    fieldLabel: 'Quantidade de serviços vinculados',
                    labelAlign: 'top',
                    maxValue: 99,
                    minValue: 0,
                    hideTrigger: true
                }]
            },{
                xtype: 'textfield',
                fieldLabel: 'Nome do inscrito',
                labelAlign: 'top',
                name: 'nome'
            },{
                xtype: 'clearcombo',
                name: 'tipo_inscrito',
                fieldLabel: 'Tipo de inscrito',
                labelAlign: 'top',
                valueField: 'id_tipo_inscrito',
                displayField: 'descricao_tipo', 
                store: 'Seic.store.Financeiro.TipoInscritos',
                queryMode: 'remote',
                queryParam: 'filtro',
                forceSelection: true
            },{
                xtype: 'clearcombo',
                name: 'instituicao',
                fieldLabel: 'Instituição',
                labelAlign: 'top',
                valueField: 'id',
                displayField: 'sigla', 
                store: 'Seic.store.Financeiro.Instituicoes',
                queryMode: 'remote',
                queryParam: 'filtro',
                forceSelection: true
            },{
                layout: 'hbox',
                border: false,
                items: [{
                    xtype: 'radiogroup',
                    fieldLabel: 'Pagamentos',
                    labelAlign: 'top',
                    anchor: '100%',
                    columns: 3,
                    vertical: true,
                    allowBlank: true,
                    items: [{ 
                        boxLabel: 'Pendentes', 
                        width: 120,
                        height: 43,
                        name: 'quite', 
                        inputValue: '0',
                        padding: '0 0 0 60', //(top, right, bottom, left). 
                    },{ 
                        boxLabel: 'Sem pedências', 
                        width: 120,
                        height: 43,
                        name: 'quite', 
                        inputValue: '1'
                    },{ 
                        boxLabel: 'Ambos', 
                        checked: true,
                        width: 120,
                        height: 43,
                        name: 'quite', 
                        inputValue: '2'
                    }]
                }]
            },{
                layout: 'hbox',
                border: false,
                items: [{
                    xtype: 'radiogroup',
                    fieldLabel: 'Credenciado',
                    labelAlign: 'top',
                    anchor: '100%',
                    columns: 3,
                    vertical: true,
                    allowBlank: true,
                    items: [{ 
                        boxLabel: 'Sim', 
                        width: 120,
                        height: 43,
                        name: 'credenciado', 
                        inputValue: '1',
                        padding: '0 0 0 60', //(top, right, bottom, left). 
                    },{ 
                        boxLabel: 'Não', 
                        width: 120,
                        height: 43,
                        name: 'credenciado', 
                        inputValue: '0'
                    },{ 
                        boxLabel: 'Ambos', 
                        checked: true,
                        width: 120,
                        height: 43,
                        name: 'credenciado', 
                        inputValue: '2'
                    }]
                }]
            }]
        },

    dockedItems: {
        xtype: 'toolbar',
        dock: 'bottom',
        itemId:'buttons',
        ui: 'footer',
        items: ['->',{
            iconCls: 'icon-clear',
            text: 'Limpar filtros',
            itemId: 'btnLimpar',
            width: 110
        },{
            iconCls: 'icon-search-white',
            text: 'Buscar',
            itemId: 'btnBuscar',
            width: 110
        }]
    }
});