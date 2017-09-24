Ext.define('Seic.model.Inscritos.EventoInscrito', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', 		type: 'int'},
		{name: 'titlo', 	type: 'string'},
		{name: 'sigla', 	type: 'string'},
		{name: 'rend_evento',type: 'string'},
		{name: 'edicao', 	type: 'string'}
	]
});