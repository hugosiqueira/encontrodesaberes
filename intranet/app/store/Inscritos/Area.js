Ext.define('Seic.store.Inscritos.Area', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Inscritos.Area',
	id: 'Area',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/inscritos/listarArea.php'
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