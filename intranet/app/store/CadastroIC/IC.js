Ext.define('Seic.store.CadastroIC.IC', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.CadastroIC.IC',
	id: 'IC',
    pageSize: 25,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/cadastroic/listarIC.php',
			create: 	'Server/cadastroic/criarIC.php', 
			update: 	'Server/cadastroic/atualizarIC.php',
			destroy:	'Server/cadastroic/apagarIC.php',
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
            root: 'ic'
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