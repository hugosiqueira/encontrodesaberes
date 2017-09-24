Ext.define('Seic.model.Trabalhos.BuscarAutores', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', 	type: 'int'},		
		{name: 'tipo', 	type: 'string'},
		{name: 'cpf', 	type: 'string'},
		{name: 'matricula_siape',	type: 'string'},
		{name: 'email', type: 'string'},
		{name: 'nome', 	type: 'string'}
	]
});