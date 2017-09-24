Ext.define('Seic.store.Trabalhos.InscritoResponsavel', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Trabalhos.InscritoResponsavel',
	id: 'InscritoResponsavel',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/trabalhos/listarInscritoResponsavel.php'
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