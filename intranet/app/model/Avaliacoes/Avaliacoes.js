Ext.define('Seic.model.Avaliacoes.Avaliacoes', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', type: 'int'},
		{name: 'status', type: 'int'},
		{name: 'fgk_revisor', type: 'int'},
		{name: 'fgk_trabalho', type: 'int'},
		{name: 'nota_a', type: 'int'},
		{name: 'nota_b', type: 'int'},
		{name: 'nota_c', type: 'int'},
		{name: 'nota_d', type: 'int'},
		{name: 'nota_e', type: 'int'},
		{name: 'nome_sessao', type: 'string'},
		{name: 'descricao_area', type: 'string'},
		{name: 'nome_avaliador', type: 'string'},
		{name: 'cod_poster', type: 'string'},
		{name: 'titulo_enviado', type: 'string'},
		{name: 'codigo_area', type: 'string'},
	]
});