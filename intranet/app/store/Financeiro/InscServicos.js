Ext.define('Seic.store.Financeiro.InscServicos',{
	extend: 'Ext.data.Store',
    model: 'Seic.model.Financeiro.InscServicos',
    remoteFilter: true,
    autoLoad: false,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/financeiro/listaInscServicos.php',
            create: 'Server/financeiro/criaInscServicos.php',
            destroy: 'Server/financeiro/apagaInscServicos.php'
        },

        reader: {
            type: 'json',
            root: 'servicos',
            successProperty: 'success',
            messageProperty: 'msg'
        },

        writer: {
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