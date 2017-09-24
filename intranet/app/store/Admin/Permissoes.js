Ext.define('Seic.store.Admin.Permissoes', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Admin.Permissao',
	id: 'Permissoes',
    pageSize: 20,
	// autoLoad: {start: 0, limit: 23},
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
        	create: 	'Server/admin/criarPermissoes.php', 
            read: 		'Server/admin/listarPermissoes.php',
			update: 	'Server/admin/atualizarPermissoes.php',
			destroy:	'Server/admin/apagarPermissoes.php',
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
            root: 'permissao'
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