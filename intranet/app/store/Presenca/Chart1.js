Ext.define('Seic.store.Presenca.Chart1', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Presenca.Chart1',
    pageSize: 20,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/presenca/infoCheckpoints.php'
        },

        reader: {
            type: 'json',
            root: 'info',
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