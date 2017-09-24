Ext.define('Seic.store.Admin.Servicos',{
	extend: 'Ext.data.Store',
    model: 'Seic.model.Admin.Servicos',
    remoteFilter: true,
    autoLoad: false,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/admin/listaServicos.php',
            create: 'Server/admin/criaServico.php',
            destroy: 'Server/admin/apagaServico.php',
            update: 'Server/admin/atualizaServico.php'
        },

        reader: {
            type: 'json',
            root: 'servicos',
            successProperty: 'success'
        },

        writer:{
            type: 'json',
            writeAllFields: true,
            encode: true,
            root: 'servico'
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