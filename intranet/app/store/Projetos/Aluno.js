Ext.define('Seic.store.Projetos.Aluno', {
    extend: 'Ext.data.Store',
    model: 'Seic.model.Projetos.Aluno',
    pageSize: 15,
    remoteFilter: true,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/projetos/listaAllAluno.php'
        },

        reader: {
            type: 'json',
            root: 'alunos',
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