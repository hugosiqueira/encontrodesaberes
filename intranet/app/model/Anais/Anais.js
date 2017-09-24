Ext.define('Seic.model.Anais.Anais', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', type: 'int'},
		{name: 'fgk_evento', type: 'int'},
		{name: 'fgk_area_especifica', type: 'int'},
		{name: 'resumo', type: 'string'},
		{name: 'descricao_area_especifica', type: 'string'},
		{name: 'titulo', type: 'string'},
		{name: 'palavras_chave', type: 'string'},
		{name: 'bool_premiado', type: 'int'}
	]
});