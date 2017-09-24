Ext.define('Seic.store.Trabalhos.BuscarAutores', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Trabalhos.BuscarAutores',
	id: 'BuscarAutores',
    pageSize: 15,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/trabalhos/listarBuscarAutores.php'
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