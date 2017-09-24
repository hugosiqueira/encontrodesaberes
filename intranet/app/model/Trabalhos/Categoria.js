Ext.define('Seic.model.Trabalhos.Categoria', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_categoria', 		type: 'int'},
		{name: 'descricao_categoria', 	type: 'string'},
		{name: 'sigla_categoria', 	type: 'string'}
	]
});