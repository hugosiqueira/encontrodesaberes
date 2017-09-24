Ext.define('Seic.store.Trabalhos.OrgaoFomento', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Trabalhos.OrgaoFomento',
	id: 'OrgaoFomento',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/trabalhos/listarOrgaoFomento.php'
        },
        reader: {
            type: 'json',
            root: 'resultado',
            successProperty: 'success'
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
    }
});