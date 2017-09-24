Ext.define('Seic.store.Trabalhos.Trabalhos', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Trabalhos.Trabalho',
	id: 'Trabalhos',
    pageSize: 25,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/trabalhos/listarTrabalhos.php',
			create: 	'Server/trabalhos/criarTrabalho.php', 
			update: 	'Server/trabalhos/atualizarTrabalho.php',
			destroy:	'Server/trabalhos/apagarTrabalho.php'
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
            root: 'trabalho'
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