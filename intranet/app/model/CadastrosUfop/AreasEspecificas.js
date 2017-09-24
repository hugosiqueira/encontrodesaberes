Ext.define('Seic.model.CadastrosUfop.AreasEspecificas', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', 						type: 'int'},
		{name: 'fgk_area', 					type: 'int'},
		{name: 'descricao_area', 			type: 'string'},
		{name: 'descricao_area_especifica',	type: 'string'}
	]
});