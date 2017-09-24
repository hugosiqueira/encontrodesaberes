Ext.define('Seic.store.Avaliacoes.AutoresTrabalho', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Avaliacoes.AutoresTrabalho',
    remoteFilter: true,
	autoSync: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/avaliacoes/listarAutoresTrabalho.php',
			update: 'Server/avaliacoes/atualizarApresentadorTrabalho.php'
        },
        reader: {
            type: 'json',
            root: 'resultado',
            successProperty: 'success'
        },
		writer: {
            type: 'json',
            writeAllFields: true,
            encode: true,
            root: 'apresentador'
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