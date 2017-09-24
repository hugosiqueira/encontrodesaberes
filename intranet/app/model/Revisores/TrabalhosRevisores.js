Ext.define('Seic.model.Revisores.TrabalhosRevisores', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_trabalho', 		type: 'int'},
		{name: 'id_avaliacao_revisao', 		type: 'int'},
		{name: 'status', 		type: 'int'},
		{name: 'titulo_enviado', 	type: 'string'},		
		{name: 'status_avaliacao_revisao', 	type: 'int'}
	]
});