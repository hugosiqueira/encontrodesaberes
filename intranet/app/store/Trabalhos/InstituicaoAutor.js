Ext.define('Seic.store.Trabalhos.InstituicaoAutor', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Trabalhos.InstituicaoAutor',
	id: 'InstituicaoAutor',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/trabalhos/listarInstituicaoAutor.php'
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