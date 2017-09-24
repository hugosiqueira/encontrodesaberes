Ext.define('Seic.store.Inscritos.BoletosInscrito', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Inscritos.BoletoInscrito',
	id: 'BoletosInscrito',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/inscritos/listarBoletosInscrito.php'
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