Ext.define('Seic.store.CadastrosUfop.AreasEspecificasCursos', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.CadastrosUfop.AreasEspecificas',
	id: 'AreasEspecificasCursos',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/cadastrosufop/listarAreasEspecificasCursos.php'
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