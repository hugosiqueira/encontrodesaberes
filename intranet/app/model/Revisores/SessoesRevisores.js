Ext.define('Seic.model.Revisores.SessoesRevisores', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', type: 'int'},
		{name: 'fgk_revisor', type: 'int'},
		{name: 'nome', type: 'string'},
		{name: 'hora_ini', type: 'string'},
		{name: 'hora_fim', type: 'string'},
		{name: 'check', type: 'bool'},
		{name: 'dia',	type: 'date',	dateFormat: 'c'}
	]
});