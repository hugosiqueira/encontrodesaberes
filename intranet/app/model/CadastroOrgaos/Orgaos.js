Ext.define('Seic.model.CadastroOrgaos.Orgaos', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', 					type: 'string'},
		{name: 'atual', 				type: 'int'},
		{name: 'nome', 					type: 'string'},
		{name: 'sigla', 				type: 'string'}
	]
});