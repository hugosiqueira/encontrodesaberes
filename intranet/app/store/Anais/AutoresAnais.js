Ext.define('Seic.store.Anais.AutoresAnais', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Anais.AutoresAnais',
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
        	create: 	'Server/anais/criarAutoresAnais.php', 
            read: 		'Server/anais/listarAutoresAnais.php',
			update: 	'Server/anais/atualizarAutoresAnais.php',
			destroy:	'Server/anais/apagarAutoresAnais.php',
        },
        reader: {
            type: 'json',
            root: 'resultado',
            successProperty: 'success'
        }
		,writer: {
            type: 'json',
            writeAllFields: true,
            encode: true,
            root: 'autores'
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