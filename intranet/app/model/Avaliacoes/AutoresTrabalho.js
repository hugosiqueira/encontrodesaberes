Ext.define('Seic.model.Avaliacoes.AutoresTrabalho', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', 		type: 'int'},
		{name: 'fgk_trabalho', 		type: 'int'},
		{name: 'nome', 		type: 'string'},
		{name: 'cpf', 		type: 'string'},
		{name: 'descricao_tipo', 		type: 'string'},
		{name: 'bool_apresentador', 	type: 'bool'}
	]
});