Ext.define('Seic.store.Projetos.Orgao', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Projetos.Orgao',
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/projetos/listaOrgao.php'
        },

        reader: {
            type: 'json',
            root: 'orgaos',
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