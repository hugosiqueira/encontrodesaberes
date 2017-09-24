Ext.define('Seic.store.Admin.Responsaveis', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Admin.Responsaveis',
    pageSize: 10,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/admin/listaResponsaveisLocais.php',
            create: 'Server/admin/criaResponsaveisLocais.php',
            destroy: 'Server/admin/apagaResponsaveisLocais.php',
        },

        reader: {
            type: 'json',
            root: 'resultado',
            successProperty: 'success'
        },

        writer:{
            type: 'json',
            writeAllFields: true,
            encode: true,
            root: 'responsavel'
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