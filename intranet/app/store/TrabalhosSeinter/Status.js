Ext.define('Seic.store.TrabalhosSeinter.Status', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.TrabalhosSeinter.Status',
	id: 'Status',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/trabalhosseinter/listarStatus.php'
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