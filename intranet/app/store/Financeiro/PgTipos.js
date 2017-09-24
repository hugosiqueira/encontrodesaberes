Ext.define('Seic.store.Financeiro.PgTipos',{
	extend: 'Ext.data.Store',
    model: 'Seic.model.Financeiro.PgTipos',
    remoteFilter: true,
    autoLoad: false,
    pageSize: 23,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/financeiro/listaPgTipos.php'
        },

        reader: {
            type: 'json',
            root: 'tipospg',
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
    }
});