Ext.define('Seic.model.Posters.PostersTrabalhos', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', 						type: 'int'},
		{name: 'fgk_area',					type: 'int'},
		{name: 'fgk_area_especifica',		type: 'int'},
		{name: 'fgk_evento',				type: 'int'},
		{name: 'apresentacao_obrigatoria',	type: 'int'},
		{name: 'fgk_projeto',				type: 'int'},
		{name: 'fgk_orgao_fomento',			type: 'int'},
		{name: 'fgk_inscrito_responsavel',	type: 'int'},
		{name: 'fgk_categoria',				type: 'int'},
		{name: 'fgk_tipo_apresentacao',		type: 'int'},
		{name: 'sigla_orgao',				type: 'string'},
		{name: 'nome_orgao',				type: 'string'},
		{name: 'descricao_area',			type: 'string'},
		{name: 'descricao_area_especifica',			type: 'string'},
		{name: 'codigo_area',				type: 'string'},
		{name: 'palavras_chave',			type: 'string'},
		{name: 'palavras_chave_revisado',	type: 'string'},
		{name: 'resumo_revisado',			type: 'string'},
		{name: 'resumo_enviado',			type: 'string'},
		{name: 'titulo_revisado',			type: 'string'},
		{name: 'titulo_enviado',			type: 'string'},
		{name: 'titulo_a_mais',				type: 'string'},
		{name: 'fgk_status',				type: 'int'},
		{name: 'id_apresentacao',			type: 'int'},
		{name: 'cod_poster',				type: 'string'},
		{name: 'nome_sessao',				type: 'string'},
		{name: 'apresentador',				type: 'string'},
		{name: 'avaliador',					type: 'string'}
	]
});