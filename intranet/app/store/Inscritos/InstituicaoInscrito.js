Ext.define('Seic.store.Inscritos.InstituicaoInscrito', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Inscritos.InstituicaoInscrito',
	id: 'InstituicaoInscrito',
    // remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/inscritos/listarInstituicaoInscrito.php'
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