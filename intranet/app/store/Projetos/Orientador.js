Ext.define('Seic.store.Projetos.Orientador', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Projetos.Orientador',
    pageSize: 15,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/projetos/listaAllOrientador.php'
        },

        reader: {
            type: 'json',
            root: 'orientadores',
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