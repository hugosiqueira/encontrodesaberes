Ext.define('Seic.store.CadastrosUfop.DepartamentosProfessoresTA', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.CadastrosUfop.DepartamentosProfessoresTA',
	id: 'DepartamentosProfessoresTA',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/cadastrosufop/listarDepartamentosProfessoresTA.php'
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