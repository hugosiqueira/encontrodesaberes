Ext.define('Seic.store.Projetos.Area', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Projetos.Area',
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/projetos/listaArea.php'
        },

        reader: {
            type: 'json',
            root: 'areas',
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