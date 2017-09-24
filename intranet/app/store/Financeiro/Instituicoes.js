Ext.define('Seic.store.Financeiro.Instituicoes',{
	extend: 'Ext.data.Store',
    model: 'Seic.model.Financeiro.Instituicoes',
    remoteFilter: true,
    autoLoad: false,
    proxy: {
        type: 'ajax',
        api: { read: 'Server/financeiro/listaInstituicoes.php' },

        reader: {
            type: 'json',
            root: 'instituicoes',
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