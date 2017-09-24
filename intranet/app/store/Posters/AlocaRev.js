Ext.define('Seic.store.Posters.AlocaRev', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Posters.AlocaRev',
    pageSize: 25,
    remoteFilter: true,
	id: 'AlocaRev',
    proxy: {
        type: 'ajax',
        api: {
            read: 	'Server/posters/listarAlocaRev.php'
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