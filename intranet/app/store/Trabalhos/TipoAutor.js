Ext.define('Seic.store.Trabalhos.TipoAutor', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Trabalhos.TipoAutor',
	id: 'TipoAutor',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/trabalhos/listarTipoAutor.php'
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