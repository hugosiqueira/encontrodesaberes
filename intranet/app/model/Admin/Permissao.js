Ext.define('Seic.model.Admin.Permissao', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_permissao', type: 'int'},
		{name: 'fgk_modulo', type: 'int'},
		{name: 'nome_modulo', type: 'string'},
		{name: 'permissao', type: 'string'},
		{name: 'permissao', type: 'string'},
		{name: 'descricao_permissao', type: 'string'}
	]
});