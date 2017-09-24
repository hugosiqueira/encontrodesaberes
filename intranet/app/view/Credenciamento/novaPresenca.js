Ext.define('Seic.view.Credenciamento.novaPresenca', {
    extend: 'Ext.window.Window',
    alias: 'widget.modcre_novapresencapop',
    title: 'Nova presença',
    iconCls:'presenca-minishortcut',
    border: false,
    bodyBorder: false,
    height: 370,
    width: 325,             
    modal: true,
    constrain: true,
    bodyPadding: 5,
    layout:'anchor',
    items:[{
        xtype: 'hidden',
        itemId: 'id'
    },{   
        xtype: 'combobox',
        itemId: 'comboLocal',
        fieldLabel: 'Local (checkpoint)',
        queryMode: 'remote',
        queryParam: 'filtro',
        anchor: '100%',
        store: 'Seic.store.Presenca.Checkpoints',
        valueField: 'id_local_presenca',
        displayField: 'descricao_local',
        forceSelection: true,
        editable: true,
        labelAlign: 'top',
        anchor: '100%',
        allowBlank: true
    },{
        layout: 'column',
        border: false,
        items: [{
            columnWidth: 0.75,
            border: false,
            bodyBorder: false,
            items: [{
                xtype: 'datepicker',
                itemId: 'data'
            }]
        },{
            columnWidth: 0.25,
            autoScroll: true,
            border: false,
            bodyBorder: false,
            height: 236,
            layout: 'fit',
            items: [{
                xtype: 'timepicker',
                itemId: 'hora',
                format: 'H:i:s',
                autoScroll: true,
                increment: 30,
                // minValue: new Date(2015, 11, 24, 8);
            }]
        }]
    }],

    dockedItems:[{
        xtype: 'toolbar',
        dock: 'bottom',
        border: false, 
        bodyBorder: false,
        items: ['->',{
            text: 'Gravar',
            itemId: 'btnGrava',
            iconCls: 'icon-save',
            width: 100
        },{
            text: 'Cancelar',
            itemId: 'btnCancel',
            iconCls: 'icon-cancel',
            width: 100,
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