Ext.define('Seic.store.Financeiro.gridPrincipal',{
	extend: 'Ext.data.Store',
    model: 'Seic.model.Financeiro.gridPrincipal',
    remoteFilter: true,
    autoLoad: false,
    pageSize: 23,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/financeiro/listaInscritos.php'
        },

        reader: {
            type: 'json',
            root: 'inscritos',
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