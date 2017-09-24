Ext.define('Seic.store.Trabalhos.AutoresTrabalho', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Trabalhos.AutoresTrabalho',
	id: 'AutoresTrabalho',
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
        	create: 	'Server/trabalhos/criarAutoresTrabalho.php', 
            read: 		'Server/trabalhos/listarAutoresTrabalho.php',
			update: 	'Server/trabalhos/atualizarAutoresTrabalho.php',
			destroy:	'Server/trabalhos/apagarAutoresTrabalho.php',
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
            root: 'autores_trabalho'
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