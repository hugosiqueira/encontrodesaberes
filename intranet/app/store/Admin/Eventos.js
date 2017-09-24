Ext.define('Seic.store.Admin.Eventos', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Admin.Evento',
	id: 'Eventos',
    pageSize: 20,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
        	create: 	'Server/admin/criarEventos.php', 
            read: 		'Server/admin/listarEventos.php',
			update: 	'Server/admin/atualizarEventos.php',
			destroy:	'Server/admin/apagarEventos.php',
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
            root: 'evento'
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