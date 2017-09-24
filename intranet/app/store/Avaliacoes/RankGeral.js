Ext.define('Seic.store.Avaliacoes.RankGeral', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Avaliacoes.RankGeral',
    pageSize: 20,
    remoteFilter: true,
	autoSync: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/avaliacoes/rankGeral.php'
        },
        reader: {
            type: 'json',
            root: 'resultado',
            successProperty: 'success'
        },
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