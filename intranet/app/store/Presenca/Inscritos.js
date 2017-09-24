Ext.define('Seic.store.Presenca.Inscritos', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Presenca.Inscritos',
    pageSize: 20,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/presenca/listaPresencas.php'
        },

        reader: {
            type: 'json',
            root: 'presencas',
            successProperty: 'success'
        },

        listeners: {
            exception: function(proxy, response, operation){
                Ext.MessageBox.show({
                    title: 'REMOTE EXCEPTION',
                    msg: operation.getError(),
                    icon: Ext.MessageBox.ERROR,
                    buttons: Ext.Msg.OK
                });
            }
        }
    }
});