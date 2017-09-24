Ext.define('Seic.store.Inscritos.CursoInscrito', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Inscritos.CursoInscrito',
	id: 'CursoInscrito',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/inscritos/listarCursoInscrito.php'
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