Ext.define('Seic.model.Posters.AlocaSessao', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', 		type: 'int'},
		{name: 'nome', 		type: 'string'},
		{name: 'fgk_area', 		type: 'int'},
		{name: 'capacidade',	type: 'int'},
		{name: 'total',	type: 'int'}
	]
});