Ext.define('Seic.model.Inscritos.Estado', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_estado', 		type: 'int'},
		{name: 'descricao_estado', 	type: 'string'},
		{name: 'descricao_estado_uf', 	type: 'string'},
		{name: 'uf', 	type: 'string'},
	]
});