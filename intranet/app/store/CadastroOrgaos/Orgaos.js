Ext.define('Seic.store.CadastroOrgaos.Orgaos', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.CadastroOrgaos.Orgaos',
	id: 'Orgaos',
    pageSize: 25,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/cadastroorgaos/listarOrgaos.php',
			create: 	'Server/cadastroorgaos/criarOrgaos.php', 
			update: 	'Server/cadastroorgaos/atualizarOrgaos.php',
			destroy:	'Server/cadastroorgaos/apagarOrgaos.php',
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
            root: 'orgao'
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