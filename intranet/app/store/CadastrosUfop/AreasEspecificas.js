Ext.define('Seic.store.CadastrosUfop.AreasEspecificas', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.CadastrosUfop.AreasEspecificas',
	id: 'AreasEspecificas',
    proxy: {
        type: 'ajax',
        api: {
            read: 		'Server/cadastrosufop/listarAreasEspecificas.php',
			create: 	'Server/cadastrosufop/criarAreasEspecificas.php', 
			update: 	'Server/cadastrosufop/atualizarAreasEspecificas.php',
			destroy:	'Server/cadastrosufop/apagarAreasEspecificas.php',
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
            root: 'areaespecifica'
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