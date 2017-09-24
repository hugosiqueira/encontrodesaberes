Ext.define('Seic.store.Trabalhos.Status', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Trabalhos.Status',
	id: 'Status',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/trabalhos/listarStatus.php'
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