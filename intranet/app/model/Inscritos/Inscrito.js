Ext.define('Seic.model.Inscritos.Inscrito', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', 						type: 'int'},
		{name: 'fgk_evento', 				type: 'int'},
		{name: 'bool_coordenador', 			type: 'int'},
		{name: 'fgk_area_coordenacao', 		type: 'int'},
		{name: 'descricao_evento', 			type: 'string'},
		{name: 'fgk_instituicao',			type: 'string'},
		{name: 'nome_instituicao',			type: 'string'},
		{name: 'sigla_instituicao',			type: 'string'},
		{name: 'rend_inst',					type: 'string'},
		{name: 'cpf',						type: 'string'},
		{name: 'fgk_tipo', 					type: 'int'},
		{name: 'descricao_tipo', 			type: 'string'},
		{name: 'mobilidade_ano_passado', 	type: 'int'},
		{name: 'mobilidade_ano_atual',	 	type: 'int'},
		{name: 'autoriza_envio_emails', 	type: 'int'},
		{name: 'bool_monitoria',			type: 'int'},
		{name: 'valor_inscricao',			type: 'int'},
		{name: 'valor_pago',				type: 'int'},
		{name: 'bool_revisor',				type: 'int'},
		{name: 'bool_inscricao_paga',		type: 'int'},
		{name: 'conta_ativada', 			type: 'int'},
		{name: 'bool_temp', 				type: 'int'},
		{name: 'fgk_departamento', 			type: 'string'},
		{name: 'departamento',				type: 'string'},
		{name: 'fgk_curso', 				type: 'int'},
		{name: 'curso',						type: 'string'},
		{name: 'descricao_curso',			type: 'string'},
		{name: 'password',					type: 'string'},
		{name: 'numero', 					type: 'string'},
		{name: 'email', 					type: 'string'},
		{name: 'email_alternativo',			type: 'string'},
		{name: 'matricula',					type: 'string'},
		{name: 'nome', 						type: 'string'},
		{name: 'cep', 						type: 'string'},
		{name: 'cidade', 					type: 'string'},
		{name: 'bairro',					type: 'string'},
		{name: 'endereco', 					type: 'string'},
		{name: 'id_estado', 				type: 'int'},
		{name: 'estado', 					type: 'string'},
		{name: 'telefone', 					type: 'string'},
		{name: 'telefone_celular', 			type: 'string'},
		{name: 'datahora_registro', 		type: 'date', 	dateFormat: 'c'},
		{name: 'last_login', 				type: 'string'},
		{name: 'complemento', 				type: 'string'}
		// ,{name: 'link_boleto', 				type: 'string'}
	]
});