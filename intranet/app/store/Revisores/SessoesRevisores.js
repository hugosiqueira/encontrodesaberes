Ext.define('Seic.store.Revisores.SessoesRevisores', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Revisores.SessoesRevisores',
	id: 'SessoesRevisores',
    remoteFilter: true,
	autoSync: true,
    proxy: {
        type: 'ajax',
		actionMethods :{
			read   : 'POST'
        },
        api: {
            read:	'Server/revisores/listarSessoesRevisores.php',
			update: 'Server/revisores/atualizarSessoesRevisores.php'
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
            root: 'sessaorevisor'
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