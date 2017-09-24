Ext.define('Seic.model.CadastrosUfop.Departamentos', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_departamento', 			type: 'string'},
		{name: 'fgk_area', 			type: 'int'},
		{name: 'descricao_area', 			type: 'string'},
		{name: 'nome_departamento', 				type: 'string'}
	]
});