Ext.define('Seic.model.Trabalhos.TipoAutor', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_tipo_autor', 		type: 'int'},
		{name: 'descricao_tipo', 	type: 'string'},
		{name: 'sigla', 	type: 'string'}
	]
});