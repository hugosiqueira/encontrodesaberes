Ext.define('Seic.store.Credenciamento.Presencas', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Credenciamento.Presencas',
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/credenciamento/listaPresencas.php'
        },

        reader: {
            type: 'json',
            root: 'presencas',
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