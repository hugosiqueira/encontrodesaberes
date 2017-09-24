Ext.define('Seic.model.Inscritos.BoletoInscrito', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_boleto', 		type: 'int'},
		{name: 'data_emissao',	type: 'date', 	dateFormat: 'c'},
		{name: 'fgk_inscrito', 		type: 'int'},
		{name: 'chave', 			type: 'string'},
		{name: 'valor', 			type: 'int'},
		{name: 'data_vencimento',	type: 'date', 	dateFormat: 'c'},
		{name: 'link', 				type: 'string'},
		{name: 'status', 			type: 'int'},
		{name: 'data_pagamento',	type: 'date', 	dateFormat: 'c'},
		{name: 'valor_pago', 		type: 'int'}
	]
});