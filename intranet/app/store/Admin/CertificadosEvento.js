Ext.define('Seic.store.Admin.CertificadosEvento', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Admin.CertificadosEvento',
	id: 'CertificadosEvento',
    pageSize: 20,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
        	create: 	'Server/admin/criarCertificadosEvento.php', 
            read: 		'Server/admin/listarCertificadosEvento.php',
			update: 	'Server/admin/atualizarCertificadosEvento.php',
			destroy:	'Server/admin/apagarCertificadosEvento.php',
        },
        reader: {
            type: 'json',
            root: 'resultado',
            successProperty: 'success'
        }
		,writer: {
            type: 'json',
            writeAllFields: true,
            encode: true,
            root: 'certificado'
        }
		,
        listeners: {
            exception: function(proxy, response, operation){
                Ext.MessageBox.show({
                    title: 'REMOTE EXCEPTION',
                    msg: operation.getError(),
                    icon: Ext.MessageBox.ERROR,
                    buttons: Ext.Msg.OK
                });
            }
        }
    }
});