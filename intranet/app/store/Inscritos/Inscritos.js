Ext.define('Seic.store.Inscritos.Inscritos', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Inscritos.Inscrito',
	id: 'Inscritos',
    pageSize: 25,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/inscritos/listarInscritos.php',
			create: 	'Server/inscritos/criarInscritos.php', 
			update: 	'Server/inscritos/atualizarInscritos.php',
			// destroy:	'Server/admin/apagarUsuarios.php',
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
            root: 'inscrito'
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