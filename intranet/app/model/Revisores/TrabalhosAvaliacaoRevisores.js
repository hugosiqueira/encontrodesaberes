Ext.define('Seic.model.Revisores.TrabalhosAvaliacaoRevisores', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_trabalho', 		type: 'int'},
		// {name: 'id_avaliacao_revisao', 		type: 'int'},
		// {name: 'fgk_status', 		type: 'int'},
		{name: 'titulo_enviado', 	type: 'string'},
		{name: 'cod_poster', 	type: 'string'}
		// {name: 'status_avaliacao_revisao', 	type: 'int'}
	]
});