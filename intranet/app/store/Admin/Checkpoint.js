Ext.define('Seic.store.Admin.Checkpoint', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Admin.Checkpoint',
    pageSize: 20,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read:       'Server/admin/listarCheckpoint.php',
        	create: 	'Server/admin/criarCheckpoint.php', 
			update: 	'Server/admin/atualizarCheckpoint.php',
			destroy:	'Server/admin/apagarCheckpoint.php',
        },
        reader: {
            type: 'json',
            root: 'checkpoints',
            successProperty: 'success'
        }
		,writer: {
            type: 'json',
            writeAllFields: true,
            encode: true,
            root: 'checkpoint'
        }
		,
        listeners: {
            exception: function(proxy, response, operation){
                Ext.MessageBox.show({
                    title: 'REMOTE EXCEPTION',
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