Ext.define('Seic.store.Revisores.Revisores', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Revisores.Revisores',
	id: 'Revisores',
    pageSize: 25,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/revisores/listarRevisores.php',
			create: 	'Server/revisores/criarRevisores.php', 
			update: 	'Server/revisores/atualizarRevisores.php',
			destroy:	'Server/revisores/apagarRevisores.php',
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
            root: 'revisor'
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