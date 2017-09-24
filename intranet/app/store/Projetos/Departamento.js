Ext.define('Seic.store.Projetos.Departamento', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Projetos.Departamento',
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/projetos/listaDepartamento.php'
        },

        reader: {
            type: 'json',
            root: 'departamentos',
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