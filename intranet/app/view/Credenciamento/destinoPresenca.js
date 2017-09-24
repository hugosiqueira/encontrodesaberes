Ext.define( 'Seic.view.Credenciamento.destinoPresenca',{
    extend: 'Ext.window.Window',
    alias: 'widget.modcre_tranpresenca',
    title: 'Selecione o inscrito',
    iconCls: 'presenca-minishortcut',
    width: 400,
    height: 100,
    modal: true,
    bodyBorder: false,
    resizable: false,
    layout: 'anchor',
    bodyPadding: 5,
    items: [{
        xtype: 'combobox',
        itemId: 'comboInscritos',
        fieldLabel: 'Inscritos',
        queryMode: 'remote',
        queryParam: 'filtro',
        store: 'Credenciamento.Inscritos',
        valueField: 'fgk_inscrito',
        displayField: 'display',
        forceSelection: true,
        editable: true,
        labelAlign: 'top',
        anchor: '100%'
    }]
});