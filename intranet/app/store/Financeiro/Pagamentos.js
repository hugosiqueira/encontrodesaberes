Ext.define('Seic.store.Financeiro.Pagamentos',{
	extend: 'Ext.data.Store',
    model: 'Seic.model.Financeiro.Pagamentos',
    remoteFilter: true,
    autoLoad: false,
    pageSize: 23,
    proxy: {
        type: 'ajax',
        api: { read: 'Server/financeiro/listaPagamentos.php' },

        reader: {
            type: 'json',
            root: 'pagamentos',
            successProperty: 'success'
        },

        listeners: {
            exception: function(proxy, response, operation){
                Ext.MessageBox.show({
                    title: 'Erro',
                    msg: operation.getError(),
                    icon: Ext.MessageBox.ERROR,
                    buttons: Ext.Msg.OK
                });
            }
        }
    },

    listeners: {
        load: function( store, records, successful, eOpts ){ 

            var valor = Ext.getCmp('modfin_receitaEventoTotal').getValue();
            if(valor == 0){
                var total = store.getProxy().getReader().jsonData.somaPgto;
                Ext.getCmp('modfin_receitaEventoTotal').setValue('R$ '+Ext.util.Format.number(total/100, '0.0,0'));
                Ext.getCmp('modfin_receitaEventoFiltro').setValue('R$ '+Ext.util.Format.number(total/100, '0.0,0'));
            }else{
                var filtrado = store.getProxy().getReader().jsonData.somaPgto;
                Ext.getCmp('modfin_receitaEventoFiltro').setValue('R$ '+Ext.util.Format.number(filtrado/100, '0.0,0'));
            }
        }
    }
});