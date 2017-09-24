Ext.define('Seic.store.Projetos.Programa_ic', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Projetos.Programa_ic',
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/projetos/listaProgramas_ic.php'
        },

        reader: {
            type: 'json',
            root: 'programas',
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