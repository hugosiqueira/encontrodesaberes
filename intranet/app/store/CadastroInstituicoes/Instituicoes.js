Ext.define('Seic.store.CadastroInstituicoes.Instituicoes', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.CadastroInstituicoes.Instituicoes',
	id: 'Instituicoes',
    pageSize: 25,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/cadastroinstituicoes/listarInstituicoes.php',
			create: 	'Server/cadastroinstituicoes/criarInstituicoes.php', 
			update: 	'Server/cadastroinstituicoes/atualizarInstituicoes.php',
			destroy:	'Server/cadastroinstituicoes/apagarInstituicoes.php',
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
            root: 'instituicao'
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