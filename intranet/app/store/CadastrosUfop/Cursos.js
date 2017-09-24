Ext.define('Seic.store.CadastrosUfop.Cursos', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.CadastrosUfop.Cursos',
	id: 'Cursos',
    pageSize: 25,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/cadastrosufop/listarCursos.php',
			create: 	'Server/cadastrosufop/criarCursos.php', 
			update: 	'Server/cadastrosufop/atualizarCursos.php',
			destroy:	'Server/cadastrosufop/apagarCursos.php',
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
            root: 'curso'
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