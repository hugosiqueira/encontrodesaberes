Ext.define('Seic.view.Credenciamento.viewPresenca', {
    extend: 'Ext.window.Window',
    id: 'modcre_viewpresenca',
    alias: 'widget.modcre_viewpresenca',
    title: 'Presenças',
    iconCls: 'presenca-minishortcut',
    modal: true,
    constrain: true,
    resizable: false,
    bodyBorder: false,
    width: 450,
    height: 500,
    layout: 'fit',

    items: [{
        xtype: 'grid',
        itemId: 'gridPresenca',
        autoScroll: true,
        border: false,
        store: 'Credenciamento.Presencas',
        allowDeselect: true,
        columns: [{     
            xtype: 'checkcolumn',
            header: "#",
            width: 35,
            dataIndex: 'check'
        },{
            xtype: 'datecolumn',
            text: 'Data - Hora',
            dataIndex: 'datahora_presenca',
            format: 'd/m/Y - H:i:s',
            flex: 0.5
        },{
            text: 'Checkpoint',
            dataIndex: 'checkpoint',
            flex: 0.5
        }],
        viewConfig: {
            plugins: {
                ptype: 'gridviewdragdrop',
                dragGroup: 'gridPresenca',
                dropGroup: 'gridInscritos'
            }
        },

        listeners: {
            afterrender: {
                fn: function(grid){ grid.getStore().load(); }
            }
        }
    }],
    // },{
    //     header: false,
    //     border: false,
    //     bodyBorder: false,
    //     columnWidth: 0.5,
    //     items: [{
    //         xtype: 'grid',
    //         itemId: 'gridInscritos',
    //         autoScroll: true,
    //         store: 'Credenciamento.Inscritos',
    //         columns: [{
    //             text: 'Nome',
    //             dataIndex: 'nome',
    //             flex: 0.6
    //         },{
    //             text: 'CPF',
    //             dataIndex: 'cpf',
    //             flex: 0.4
    //         }],
    //         viewConfig: {
    //             plugins: {
    //                 ptype: 'gridviewdragdrop',
    //                 dragGroup: 'gridInscritos',
    //                 dropGroup: 'gridPresenca'
    //             }
    //         },

    //         listeners: {
    //             afterrender: {
    //                 fn: function(grid){ grid.getStore().load(); }
    //             }
    //         }
    //     }]
    // }],

    dockedItems: [{
        xtype: 'toolbar',
        dock: 'top',
        border: false,
        items: [{
            text: 'Adicionar',
            itemId: 'btnAdd',
            iconCls: 'icon-add'
        },{
            text: 'Apagar',
            itemId: 'btnApaga',
            iconCls: 'icon-delete'
        },{
            text: 'Transferir',
            itemId: 'btnTrans',
            iconCls: 'icon-update'
        }]
    },{
        xtype: 'toolbar',
        dock: 'top',
        border: false,
        layout: {
            pack: 'center'
        },
        items: [{
            xtype: 'displayfield',
            hideLabel: true,
            itemId: 'nomeInscrito',
            name: 'nome',
            fieldStyle: {
                'font-weight': 'bold',
                'color': '#3892D3'
            }
        }]
    }]
});