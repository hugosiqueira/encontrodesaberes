Ext.define('Seic.store.Admin.GruposModulos', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Admin.GrupoModulo',
	id: 'GruposModulos',
    remoteFilter: true,
    proxy: {
        type: 'ajax',
		actionMethods :{
			read   : 'POST'
        },
        api: {
        	// create: 	'Server/admin/criarGrupos.php', 
            read: 		'Server/admin/listarGruposModulos.php',
			update: 	'Server/admin/atualizarGruposModulos.php',
			// destroy:	'Server/admin/apagarGrupos.php',
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
            root: 'grupomodulo'
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