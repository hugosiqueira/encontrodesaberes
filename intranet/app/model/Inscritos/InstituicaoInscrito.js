Ext.define('Seic.model.Inscritos.InstituicaoInscrito', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_instituicao', 			type: 'int'},
		{name: 'nome', 				type: 'string'},
		{name: 'sigla', 				type: 'string'},
		{name: 'rend_inst', 				type: 'string'}
	]
});