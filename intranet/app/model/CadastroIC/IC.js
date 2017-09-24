Ext.define('Seic.model.CadastroIC.IC', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', 					type: 'string'},
		{name: 'atual', 				type: 'int'},
		{name: 'nome', 					type: 'string'},
		{name: 'sigla', 				type: 'string'},
		{name: 'fgk_tipo_apresentacao',	type: 'int'}
	]
});