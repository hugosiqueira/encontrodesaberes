Ext.define('Seic.model.Posters.AlocaRev', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', 		type: 'int'},
		{name: 'nome', 		type: 'string'},
		{name: 'descricao_area_especifica', 		type: 'string'},
		{name: 'tooltip', 		type: 'string'},
		{name: 'alocados',	type: 'int'}
	]
});