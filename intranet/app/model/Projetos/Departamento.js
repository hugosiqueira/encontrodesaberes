Ext.define('Seic.model.Projetos.Departamento', {
    extend: 'Ext.data.Model',
    fields: [{
    	name: 'id_departamento', 
    	type: 'string'
    },{
    	name: 'fgk_area',
    	type: 'int'
    },{
    	name: 'nome_departamento',
    	type: 'string'
    }]
});