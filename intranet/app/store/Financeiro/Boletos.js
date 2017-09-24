Ext.define('Seic.store.Financeiro.Boletos',{
	extend: 'Ext.data.Store',
    model: 'Seic.model.Financeiro.Boletos',
    remoteFilter: true,
    autoLoad: false,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/financeiro/listaBoletos.php'
        },

        reader: {
            type: 'json',
            root: 'boletos',
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