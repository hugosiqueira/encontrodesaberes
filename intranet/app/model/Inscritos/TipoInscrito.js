Ext.define('Seic.model.Inscritos.TipoInscrito', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_tipo_inscrito', 			type: 'int'},
		{name: 'fgk_evento', 				type: 'int'},
		{name: 'descricao_tipo', 			type: 'string'},
		{name: 'valor_inscricao',			type: 'int'},
		{name: 'valor_minicurso',			type: 'int'}
	]
});