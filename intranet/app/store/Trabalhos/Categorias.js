Ext.define('Seic.store.Trabalhos.Categorias', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Trabalhos.Categoria',
	id: 'Categorias',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/trabalhos/listarCategorias.php'
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