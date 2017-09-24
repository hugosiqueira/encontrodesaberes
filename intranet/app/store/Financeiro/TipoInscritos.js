Ext.define('Seic.store.Financeiro.TipoInscritos',{
	extend: 'Ext.data.Store',
    model: 'Seic.model.Financeiro.TipoInscritos',
    remoteFilter: true,
    autoLoad: false,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/financeiro/listaTipoInscritos.php'
        },

        reader: {
            type: 'json',
            root: 'tipo_inscritos',
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