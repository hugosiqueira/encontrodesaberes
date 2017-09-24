Ext.define('Seic.store.CadastrosUfop.Areas', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.CadastrosUfop.Areas',
	id: 'Areas',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/cadastrosufop/listarAreas.php',
			create: 	'Server/cadastrosufop/criarAreas.php', 
			update: 	'Server/cadastrosufop/atualizarAreas.php',
			destroy:	'Server/cadastrosufop/apagarAreas.php',
        },
        reader: {
            type: 'json',
            root: 'resultado',
            successProperty: 'success'
        },
		writer: {
            type: 'json',
            writeAllFields: true,
            encode: true,
            root: 'area'
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