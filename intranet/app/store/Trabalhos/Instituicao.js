Ext.define('Seic.store.Trabalhos.Instituicao', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Trabalhos.Instituicao',
	id: 'Instituicao',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/trabalhos/listarInstituicao.php'
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