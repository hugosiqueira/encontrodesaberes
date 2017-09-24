Ext.define('Seic.store.Anais.Anais', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Anais.Anais',
    pageSize: 25,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/anais/listarAnais.php',
			create: 	'Server/anais/criarAnais.php', 
			update: 	'Server/anais/atualizarAnais.php',
			destroy:	'Server/anais/apagarAnais.php',
        },
		writer: {
            type: 'json',
            writeAllFields: true,
            encode: true,
            root: 'trabalho'
        },
        reader: {
            type: 'json',
            root: 'resultado',
            successProperty: 'success'
        },
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