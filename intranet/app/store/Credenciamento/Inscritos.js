Ext.define('Seic.store.Credenciamento.Inscritos', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Credenciamento.Inscritos',
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/credenciamento/listaInscritos.php'
        },

        reader: {
            type: 'json',
            root: 'inscritos',
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