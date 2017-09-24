Ext.define('Seic.store.Revisores.TipoInscrito', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Revisores.TipoInscrito',
	id: 'TipoInscrito',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/revisores/listarTipoInscrito.php'
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
    },
	onCreateRecords: function(records, operation, success) {
		this.load();
    },
    onUpdateRecords: function(records, operation, success) {
        this.load();
    },
    onDestroyRecords: function(records, operation, success) {
        this.load();
    }
});