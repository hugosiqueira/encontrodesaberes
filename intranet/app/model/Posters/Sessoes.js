Ext.define('Seic.model.Posters.Sessoes', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', 		type: 'int'},
		{name: 'dia',		type: 'date', 	dateFormat: 'c'},
		{name: 'hora_ini',	type: 'string'},
		{name: 'hora_fim',	type: 'string'},
		{name: 'nome',		type: 'string'},
		{name: 'sessao',	type: 'string'}		
	]
});