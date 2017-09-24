Ext.define('Seic.store.Certificados.Certificados', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Certificados.Certificados',
	id: 'Certificados',
    pageSize: 25,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/certificados/listarCertificados.php',
			create: 	'Server/certificados/criarCertificados.php', 
			update: 	'Server/certificados/atualizarCertificados.php',
			destroy:	'Server/certificados/apagarCertificados.php',
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
            root: 'certificado'
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