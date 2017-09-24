Ext.define('Seic.store.Trabalhos.Projetos', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Trabalhos.Projeto',
	id: 'Projetos',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/trabalhos/listarProjetos.php'
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