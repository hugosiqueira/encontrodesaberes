Ext.define('Seic.store.Trabalhos.TipoApresentacao', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Trabalhos.TipoApresentacao',
	id: 'TipoApresentacao',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/trabalhos/listarTipoApresentacao.php'
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