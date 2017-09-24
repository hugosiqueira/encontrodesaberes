Ext.define('Seic.store.CadastrosUfop.ProfessoresTA', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.CadastrosUfop.ProfessoresTA',
	id: 'ProfessoresTA',
    pageSize: 25,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/cadastrosufop/listarProfessoresTA.php',
			create: 	'Server/cadastrosufop/criarProfessoresTA.php', 
			update: 	'Server/cadastrosufop/atualizarProfessoresTA.php',
			destroy:	'Server/cadastrosufop/apagarProfessoresTA.php'
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
            root: 'professoresta'
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