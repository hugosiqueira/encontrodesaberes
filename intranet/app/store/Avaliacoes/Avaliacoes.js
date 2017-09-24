Ext.define('Seic.store.Avaliacoes.Avaliacoes', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Avaliacoes.Avaliacoes',
    pageSize: 25,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/avaliacoes/listarAvaliacoes.php'
        },
        reader: {
            type: 'json',
            root: 'resultado',
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