Ext.define('Seic.store.Trabalhos.AreaEspecifica', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Trabalhos.AreaEspecifica',
	id: 'AreaEspecifica',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/trabalhos/listarAreaEspecifica.php'
        },
        reader: {
            type: 'json',
            root: 'resultado',
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