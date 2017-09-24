Ext.define('Seic.model.Posters.CapacidadesSessao', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', 		type: 'int'},
		{name: 'id_sessao_capacidade', 		type: 'int'},
		{name: 'fgk_area',	type: 'int'},
		{name: 'id_area',	type: 'int'},
		{name: 'fgk_sessao',	type: 'int'},
		{name: 'capacidade',		type: 'int'},
		{name: 'descricao_area',	type: 'string'}
	]
});