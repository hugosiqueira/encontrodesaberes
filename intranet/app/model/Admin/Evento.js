Ext.define('Seic.model.Admin.Evento', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', 							type: 'int'},
		{name: 'sigla', 						type: 'string'},
		{name: 'titulo', 						type: 'string'},
		{name: 'edicao', 						type: 'string'},
		{name: 'tema_arquivo', 					type: 'string'},

		{name: 'data_evento_ini', 				type: 'date', 	dateFormat: 'c', submitFormat:'Y-m-d'},
		{name: 'data_evento_fim', 				type: 'date', 	dateFormat: 'c', submitFormat:'Y-m-d'},
		{name: 'hora_evento_ini', 				type: 'string'},
		{name: 'hora_evento_fim', 				type: 'string'},

		{name: 'data_inscricao_ini', 			type: 'date', 	dateFormat: 'c'},
		{name: 'data_inscricao_fim', 			type: 'date', 	dateFormat: 'c'},
		{name: 'hora_inscricao_ini', 			type: 'string'},
		{name: 'hora_inscricao_fim', 			type: 'string'},

		{name: 'data_avaliacao_ini', 			type: 'date', 	dateFormat: 'c'},
		{name: 'data_avaliacao_fim', 			type: 'date', 	dateFormat: 'c'},
		{name: 'hora_avaliacao_ini', 			type: 'string'},
		{name: 'hora_avaliacao_fim', 			type: 'string'},

		{name: 'data_reavaliacao_ini', 			type: 'date', 	dateFormat: 'c'},
		{name: 'data_reavaliacao_fim', 			type: 'date', 	dateFormat: 'c'},
		{name: 'hora_reavaliacao_ini', 			type: 'string'},
		{name: 'hora_reavaliacao_fim', 			type: 'string'},

		{name: 'data_submissao_ini', 			type: 'date', 	dateFormat: 'c'},
		{name: 'data_submissao_fim', 			type: 'date', 	dateFormat: 'c'},
		{name: 'hora_submissao_ini', 			type: 'string'},
		{name: 'hora_submissao_fim', 			type: 'string'},

		{name: 'data_submissao_adequacao_ini', 	type: 'date', 	dateFormat: 'c'},
		{name: 'data_submissao_adequacao_fim',	type: 'date', 	dateFormat: 'c'},
		{name: 'hora_submissao_adequacao_ini', 	type: 'string'},
		{name: 'hora_submissao_adequacao_fim',	type: 'string'},
		
		{name: 'data_ini_parecer_final', 	type: 'date', 	dateFormat: 'c'},
		{name: 'data_fim_parecer_final',	type: 'date', 	dateFormat: 'c'},
		{name: 'hora_ini_parecer_final', 	type: 'string'},
		{name: 'hora_fim_parecer_final',	type: 'string'},
		
		{name: 'data_ini_primeiro_parecer', type: 'date', 	dateFormat: 'c'},
		{name: 'data_fim_primeiro_parecer',	type: 'date', 	dateFormat: 'c'},
		{name: 'hora_ini_primeiro_parecer', type: 'string'},
		{name: 'hora_fim_primeiro_parecer',	type: 'string'},
		
		{name: 'data_ini_submissao_minicurso', 	type: 'date', 	dateFormat: 'c'},
		{name: 'data_fim_submissao_minicurso',	type: 'date', 	dateFormat: 'c'},
		{name: 'hora_ini_submissao_minicurso', 	type: 'string'},
		{name: 'hora_fim_submissao_minicurso',	type: 'string'},
		
		{name: 'data_max_vencimento_boleto', 	type: 'date', 	dateFormat: 'c'},

		{name: 'usuarios',						type: 'int'},
		{name: 'bool_logo',						type: 'int'},
		{name: 'bool_wall',						type: 'string'}
	]
});