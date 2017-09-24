Ext.define('Seic.store.Admin.Modulos', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Admin.Modulo',
	id: 'Modulos',
	// autoLoad: true,
    pageSize: 20,
	// autoLoad: {start: 0, limit: 23},
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
        	create: 	'Server/admin/criarModulos.php', 
            read: 		'Server/admin/listarModulos.php',
			update: 	'Server/admin/atualizarModulos.php',
			destroy:	'Server/admin/apagarModulos.php',
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
            root: 'modulo'
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