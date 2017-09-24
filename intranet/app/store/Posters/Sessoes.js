Ext.define('Seic.store.Posters.Sessoes', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Posters.Sessoes',
	id: 'Sessoes',
    pageSize: 25,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/posters/listarSessoes.php',
			create: 	'Server/posters/criarSessoes.php', 
			update: 	'Server/posters/atualizarSessoes.php',
			destroy:	'Server/posters/apagarSessoes.php',
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
            root: 'sessao'
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