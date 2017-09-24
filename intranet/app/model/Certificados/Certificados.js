Ext.define('Seic.model.Certificados.Certificados', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_certificado', 		type: 'int'},
		{name: 'fgk_tipo',				type: 'int'},
		{name: 'descricao_certificado',	type: 'string'},
		{name: 'dizeres_certificado',	type: 'string'},
		{name: 'cpf',					type: 'string'},
		{name: 'nome',					type: 'string'},
		{name: 'chave_autenticidade',	type: 'string'},
		{name: 'email',					type: 'string'},
		{name: 'data_emissao', 		type: 'date', 	dateFormat: 'c'}
	]
});