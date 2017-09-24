Ext.define('Seic.store.Inscritos.Estados', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Inscritos.Estado',
	id: 'Estados',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/inscritos/listarEstados.php'
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