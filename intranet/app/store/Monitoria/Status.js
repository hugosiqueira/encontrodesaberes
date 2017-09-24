Ext.define('Seic.store.Monitoria.Status', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Monitoria.Status',
	id: 'Status',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/monitoria/listarStatus.php'
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