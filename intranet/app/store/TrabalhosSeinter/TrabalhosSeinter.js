Ext.define('Seic.store.TrabalhosSeinter.TrabalhosSeinter', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.TrabalhosSeinter.TrabalhosSeinter',
	id: 'TrabalhosSeinter',
    pageSize: 25,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/trabalhosseinter/listarTrabalhosSeinter.php',
			create: 	'Server/trabalhosseinter/criarTrabalhosSeinter.php', 
			update: 	'Server/trabalhosseinter/atualizarTrabalhosSeinter.php',
			destroy:	'Server/trabalhosseinter/apagarTrabalhosSeinter.php'
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
            root: 'trabalhoseinter'
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