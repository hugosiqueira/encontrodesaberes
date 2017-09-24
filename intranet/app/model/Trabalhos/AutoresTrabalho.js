Ext.define('Seic.model.Trabalhos.AutoresTrabalho', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', 		type: 'int'},
		{name: 'sigla_instituicao', 		type: 'string'},
		{name: 'descricao_tipo', 		type: 'string'},
		{name: 'fgk_instituicao', 		type: 'int'},
		{name: 'fgk_trabalho', 		type: 'int'},
		{name: 'fgk_tipo_autor', 		type: 'int'},
		{name: 'cpf', 		type: 'string'},
		{name: 'nome', 		type: 'string'},
		{name: 'email', 		type: 'string'},
		{name: 'ordenacao', 		type: 'int'},
		{name: 'bool_apresentador', 	type: 'int'}
	]
});