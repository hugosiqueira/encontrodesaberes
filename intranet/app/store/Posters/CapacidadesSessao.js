Ext.define('Seic.store.Posters.CapacidadesSessao', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Posters.CapacidadesSessao',
	id: 'CapacidadesSessao',
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/posters/listarCapacidadesSessao.php',
			create: 	'Server/posters/criarCapacidadesSessao.php', 
			update: 	'Server/posters/atualizarCapacidadesSessao.php',
			destroy:	'Server/posters/apagarCapacidadesSessao.php'
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
            root: 'capacidade'
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