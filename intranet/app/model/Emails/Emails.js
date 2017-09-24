Ext.define('Seic.model.Emails.Emails', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_email', 				type: 'int'},
		{name: 'fgk_evento',			type: 'int'},
		{name: 'cpf_destinatario',		type: 'string'},
		{name: 'nome_destinatario',		type: 'string'},
		{name: 'email_destinatario',	type: 'string'},
		{name: 'categoria',				type: 'string'},
		{name: 'assunto',				type: 'string'},
		{name: 'corpo_email',			type: 'string'},
		{name: 'datahora_envio', 		type: 'date', 	dateFormat: 'c'}
	]
});