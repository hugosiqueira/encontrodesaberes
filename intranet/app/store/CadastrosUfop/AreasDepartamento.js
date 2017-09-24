Ext.define('Seic.store.CadastrosUfop.AreasDepartamento', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.CadastrosUfop.AreasDepartamento',
	id: 'AreasDepartamento',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/cadastrosufop/listarAreasDepartamento.php'
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