Ext.define('Seic.model.Avaliacoes.RankGeral', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', type: 'int'},
		{name: 'descricao_area', type: 'string'},
		{name: 'codigo_area', type: 'string'},
		{name: 'sigla_instituicao', type: 'string'},
		{name: 'titulo_enviado', type: 'string'},
		{name: 'nome_instituicao', type: 'string'},
		{name: 'tooltip', type: 'string'},
		{name: 'nota_geral', type: 'double'},
		{name: 'rank', type: 'int'}
	]
});