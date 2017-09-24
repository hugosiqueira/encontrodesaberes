Ext.define('Seic.model.Admin.Responsaveis',{
	extend: 'Ext.data.Model',
    fields: [{
        name: 'id_usuario',
        type: 'int'
    },{
        name: 'nome_usuario', 
        type: 'string'
    },{
        name: 'id_local', 
        type: 'int'
    }]
});