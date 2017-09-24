Ext.define('Seic.store.Projetos.Categoria', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Projetos.Categoria',
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/projetos/listaCategoria.php'
        },

        reader: {
            type: 'json',
            root: 'categorias',
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