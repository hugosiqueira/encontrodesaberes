Ext.define('Seic.view.Financeiro.mainFinanceiro',{
    extend: 'Ext.panel.Panel',
    alias: 'widget.modfin_main',
    id: 'modfin_main',
    layout: 'fit',

    initComponent: function(){
        this.items = [{
            xtype: 'tabpanel',
            items:[{
                title: 'Inscritos',
                layout: 'fit',
                items:[{
                    xtype: 'modfin_tabinscritos'
                }]
            },{
                title: 'Pagamentos',
                layout: 'fit',
                items:[{
                    xtype: 'modfin_tabpagamentos'
                }]
            }]
        }];//THIS.ITEMS
        this.callParent(arguments);
    }
});