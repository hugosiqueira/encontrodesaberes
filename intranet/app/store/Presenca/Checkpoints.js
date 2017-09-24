Ext.define('Seic.store.Presenca.Checkpoints', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Presenca.Checkpoints',
    pageSize: 20,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/presenca/listaCheckpoints.php'
        },

        reader: {
            type: 'json',
            root: 'locais',
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