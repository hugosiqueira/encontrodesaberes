Ext.define('Seic.view.Credenciamento.mainCredenciamento', {
    extend: 'Ext.grid.Panel',
    id: 'modcre_maincredenciamento',
    alias: 'widget.modcre_maincredenciamento',
    store: 'Seic.store.Financeiro.gridPrincipal',

    layout: {
        type: 'fit',
        align: 'stretch'
    },

    requires: [
        'Ext.ux.textMask'
    ],

    resizable: false,
    border: false,
    padding: 3,

    columns: [{
        text: 'Nome',  
        dataIndex: 'nome',
        flex: 3.6
    },{ 
        text: 'Doc. identificação', 
        dataIndex: 'cpf',
        flex: 1.2
    },{ 
        text: 'Tipo', 
        dataIndex: 'descricao_tipo',
        flex: 1.2
    },{ 
        text: 'Instituição', 
        dataIndex: 'sigla_instituicao',
        flex: 1
    },{ 
        text: 'Status', 
        dataIndex: 'quite',
        flex: 0.6,
        renderer: function(value, metaData, record, rowIndex, colIndex, store){
            if(record.data.quite == 1){
                metaData.tdCls = 'icon-boleto_confirmado'
                metaData.tdAttr = 'data-qtip="Sem pedências"';
            }else if(record.data.quite == 2){
                metaData.tdCls = 'icon-inscrito_semServicos'
                metaData.tdAttr = 'data-qtip="Sem serviços"';
            }else{
                metaData.tdCls = 'icon-boleto_inadimplente'
                metaData.tdAttr = 'data-qtip="Com pendência(s)"';
            }
        }
    },{ 
        text: 'Credenciado', 
        itemId: 'credenciado',
        dataIndex: 'credencial',
        flex: 1,
        renderer: function(value, metaData, record, rowIndex, colIndex, store){
            if(record.data.credencial == 1){
                metaData.tdCls = 'icon-credencial_ok'
                metaData.tdAttr = 'data-qtip="Credenciado"';
            }else{
                metaData.tdCls = 'icon-credencial_bad'
                metaData.tdAttr = 'data-qtip="Não credenciado"';
            }
        }
    },{ 
        text: 'Crachá', 
        itemId: 'bool_cracha',
        dataIndex: 'bool_cracha',
        flex: 0.6,
        renderer: function(value, metaData, record, rowIndex, colIndex, store){
            if(record.data.bool_cracha == 1){
                metaData.tdCls = 'icon-highlight'
            }else{
                metaData.tdCls = 'icon-lowlight'
            }
        }
    }],

    dockedItems: [{
        xtype: 'toolbar',
        dock: 'top',
        items: [{
            text: 'Nova inscrição',
            itemId: 'modcre_btnCadR',
            iconCls: 'icon-add'
        },{
            text: 'Gerar crachá',
            itemId: 'modcre_btnCredenciar',
            iconCls: 'icon-barcode'
        },{
            text: 'Imprimir crachá',
            itemId: 'modcre_btnEdit',
            iconCls: 'icon-print',
            disabled: true
        },{
            text: 'Presença',
            iconCls: 'presenca-minishortcut',
            itemId: 'presencaBtn',
            disabled: true
        },{
            text: 'Relatório',
            itemId: 'printRelatorio',
            iconCls: 'icon-submetido',
            hidden: true
        },'->',{
            xtype: 'searchfield',
            store: 'Seic.store.Financeiro.gridPrincipal',
            emptyText: 'Busca rápida...',
            paramName: 'filtro',
            width: 250
        },{
            text: 'Busca avançada',
            itemId: 'buscaAvancada'
        }]
    },{
        xtype: 'toolbar',
        id: 'modcre_barraBusca',
        dock: 'top',
        hidden: true,
        style: {
            background: '#FF6666'
        }
    },{  
        xtype: 'pagingtoolbar',
        dock: 'bottom',
        store: 'Seic.store.Financeiro.gridPrincipal',
        displayInfo: true,
        displayMsg: 'Exibindo {0} - {1} de {2} inscritos',
        emptyMsg: 'Nenhum inscrito encontrado.'
    }]
});