Ext.define('Seic.view.Financeiro.buscaPagamentos',{
    extend: 'Ext.window.Window',
    id: 'modfin_buscapagamentos',
    iconCls:'financeiro-minishortcut',
    alias: 'widget.buscapagamentos',
    title: 'Buscar pagamentos',
    height: 350,
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
            items:[{
                xtype: 'clearcombo',
                name: 'servico',
                fieldLabel: 'Serviço',
                labelAlign: 'top',
                anchor: '100%',
                valueField: 'id',
                displayField: 'descricao_servico', 
                store: 'Seic.store.Admin.Servicos',
                queryMode: 'remote',
                queryParam: 'filtro',
                forceSelection: true
            },{
                xtype: 'clearcombo',
                name: 'tipo_pagamento',
                fieldLabel: 'Tipo de pagamento',
                labelAlign: 'top',
                anchor: '100%',
                valueField: 'id_tipo_pagamento',
                displayField: 'descricao_pagamento', 
                store: 'Seic.store.Financeiro.TipoPagamentos',
                queryMode: 'remote',
                queryParam: 'filtro',
                forceSelection: true
            },{
                xtype: 'clearcombo',
                name: 'tipo_inscrito',
                fieldLabel: 'Tipo de inscrito',
                labelAlign: 'top',
                anchor: '100%',
                valueField: 'id_tipo_inscrito',
                displayField: 'descricao_tipo', 
                store: 'Seic.store.Financeiro.TipoInscritos',
                queryMode: 'remote',
                queryParam: 'filtro',
                forceSelection: true
            },{
                xtype: 'clearcombo',
                name: 'fgk_instituicao',
                fieldLabel: 'Instituição',
                labelAlign: 'top',
                anchor: '100%',
                valueField: 'id',
                displayField: 'rend_inst', 
                store: 'InstituicaoInscrito',
                queryMode: 'remote',
                queryParam: 'filtro',
                forceSelection: true
            },{
                layout: 'hbox',
                padding: '10 0 0 0',
                border: false,
                items: [{
                    xtype: 'datefield',
                    name: 'dataMin',
                    fieldLabel: 'Data de pagamento, entre:',
                    format:'d/m',
                    submitFormat: 'Y/m/d',
                    fieldStyle: 'text-align: center',
                    labelWidth: 160,
                    width: 240,
                    padding: '0 0 0 1'
                },{
                    xtype: 'datefield',
                    name: 'dataMax',
                    fieldLabel: 'e',
                    format:'d/m',
                    submitFormat: 'Y/m/d',
                    fieldStyle: 'text-align: center',
                    labelWidth: 10,
                    width: 85,
                    padding: '0 0 10 5'
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