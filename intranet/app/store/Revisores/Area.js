Ext.define('Seic.store.Revisores.Area', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Revisores.Area',
	id: 'Area',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/revisores/listarArea.php'
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