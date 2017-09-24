Ext.define('Seic.store.Revisores.TrabalhosRevisores', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Revisores.TrabalhosRevisores',
	id: 'TrabalhosRevisores',
    proxy: {
        type: 'ajax',
        api: {
            read:	'Server/revisores/listarTrabalhosRevisores.php'
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