Ext.define('Seic.store.Admin.GruposPermissoes', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Admin.GrupoPermissao',
	id: 'GruposPermissoes',
    remoteFilter: true,
	autoSync: true,
    proxy: {
        type: 'ajax',
		actionMethods :{
			read   : 'POST'
        },
        api: {
            read:	'Server/admin/listarGruposPermissoes.php',
			update: 'Server/admin/atualizarGruposPermissoes.php'
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
            root: 'grupopermissao'
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
    },
	listeners:{
		beforesync: function(){
			Ext.getCmp('gridGruposPermissoes').disable();
		}
	}
	,onUpdateRecords: function(records, operation, success) {
        Ext.getCmp('gridGruposPermissoes').enable();
    }
});