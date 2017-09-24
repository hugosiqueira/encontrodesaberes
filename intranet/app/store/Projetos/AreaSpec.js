Ext.define('Seic.store.Projetos.AreaSpec', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Projetos.AreaSpec',
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/projetos/listaAreaSpec.php'
        },

        reader: {
            type: 'json',
            root: 'cursos',
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