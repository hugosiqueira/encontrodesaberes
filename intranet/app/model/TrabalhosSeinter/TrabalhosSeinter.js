Ext.define('Seic.model.TrabalhosSeinter.TrabalhosSeinter', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', 						type: 'int'},
		{name: 'fgk_evento',				type: 'int'},
		{name: 'fgk_status',				type: 'int'},
		{name: 'descricao_status',			type: 'string'},
		{name: 'cpf',						type: 'string'},
		{name: 'nome_aluno',				type: 'string'},
		{name: 'curso_aluno',				type: 'string'},
		{name: 'periodo_cursava',			type: 'int'},
		{name: 'tempo_afastamento',			type: 'int'},
		{name: 'tipo_mobilidade',			type: 'int'},
		{name: 'universidade_destino',		type: 'string'},
		{name: 'cidade_destino',			type: 'string'},
		{name: 'pais_destino',				type: 'string'},
		{name: 'curso_destino',				type: 'string'},
		{name: 'curso_area_destaque',		type: 'string'},
		{name: 'questoes_linguisticas',		type: 'string'},
		{name: 'tipo_moradia',				type: 'string'},
		{name: 'sistema_avaliacao',			type: 'string'},
		{name: 'dinamica_metodologia_aulas',type: 'string'},
		{name: 'custo_vida',				type: 'string'},
		{name: 'infra_universidade',		type: 'string'},
		{name: 'servico_acolhimento',		type: 'string'},
		{name: 'estagio',					type: 'string'},
		{name: 'atividades_universidade',	type: 'string'},
		{name: 'processo_adaptacao',		type: 'string'},
		{name: 'relato_pessoal',			type: 'string'},
		{name: 'conselhos_calouro',			type: 'string'}
	]
});