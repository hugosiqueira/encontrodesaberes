Ext.define('Seic.model.Projetos.AreaSpec', {
    extend: 'Ext.data.Model',
    fields: [{
    	name: 'id', 
    	type: 'int'
    },{
    	name: 'fgk_area',
    	type: 'string'
    },{
    	name: 'descricao_area_especifica',
    	type: 'string'
    }]
});