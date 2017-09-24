Ext.define('Seic.store.Projetos.Projetos', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Projetos.Projetos',
    pageSize: 24,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/projetos/listaProjetos.php',
            create: 'Server/projetos/criaProjeto.php',
            destroy: 'Server/projetos/deletaProjeto.php',
            update: 'Server/projetos/atualizaProjeto.php'
        },

        reader: {
            type: 'json',
            root: 'projetos',
            successProperty: 'success'
        },

        writer: {
            type: 'json',
            writeAllFields: true,
            encode: true,
            root: 'projeto'
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