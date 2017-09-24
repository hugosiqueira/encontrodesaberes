Ext.define('Seic.store.Inscritos.DepartamentoInscrito', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Inscritos.DepartamentoInscrito',
	id: 'DepartamentoInscrito',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/inscritos/listarDepartamentoInscrito.php'
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