Ext.define('Seic.store.CadastrosUfop.CursosAluno', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.CadastrosUfop.CursosAluno',
	id: 'CursosAluno',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/cadastrosufop/listarCursosAluno.php'
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