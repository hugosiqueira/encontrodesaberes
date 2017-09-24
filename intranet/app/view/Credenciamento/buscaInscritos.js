Ext.define('Seic.view.Credenciamento.buscaInscritos',{
    extend: 'Ext.window.Window',
    id: 'modpre_buscainscritos',
    iconCls:'credenciamento-minishortcut',
    alias: 'widget.modcrebuscainscritos',
    title: 'Buscar inscritos',
    height: 335,
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
                    xtype: 'textfield',
                    fieldLabel: 'CPF / PASSAPORTE',
                    labelAlign: 'top',
                    name: 'cpf',
                    labelWidth: 150,
                    width: 150,
                    padding: '0 50 0 0'
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
                displayField: 'sig_nome', 
                store: 'Seic.store.Financeiro.Instituicoes',
                queryMode: 'remote',
                queryParam: 'filtro',
                forceSelection: true
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