Ext.define('Seic.store.Inscritos.Cidades', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Inscritos.Cidade',
	id: 'Cidades',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/inscritos/listarCidades.php'
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