Ext.define('Seic.store.Revisores.TrabalhosAvaliacaoRevisores', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Revisores.TrabalhosAvaliacaoRevisores',
	id: 'TrabalhosAvaliacaoRevisores',
    proxy: {
        type: 'ajax',
        api: {
            read:	'Server/revisores/listarTrabalhosAvaliacaoRevisores.php'
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