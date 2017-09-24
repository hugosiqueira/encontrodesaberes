Ext.define('Seic.store.Admin.Usuarios', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Admin.Usuario',
	id: 'Usuarios',
    pageSize: 20,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
        	create: 	'Server/admin/criarUsuarios.php', 
            read: 		'Server/admin/listarUsuarios.php',
			update: 	'Server/admin/atualizarUsuarios.php',
			destroy:	'Server/admin/apagarUsuarios.php',
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
            root: 'usuario'
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