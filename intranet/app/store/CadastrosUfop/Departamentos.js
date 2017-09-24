Ext.define('Seic.store.CadastrosUfop.Departamentos', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.CadastrosUfop.Departamentos',
	id: 'Departamentos',
    pageSize: 25,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/cadastrosufop/listarDepartamentos.php',
			create: 	'Server/cadastrosufop/criarDepartamentos.php', 
			update: 	'Server/cadastrosufop/atualizarDepartamentos.php',
			destroy:	'Server/cadastrosufop/apagarDepartamentos.php',
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
            root: 'departamento'
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