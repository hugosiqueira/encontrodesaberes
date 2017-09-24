Ext.define('Seic.model.Admin.Usuario', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_usuario', type: 'int'},
		{name: 'login', type: 'string'},
		{name: 'eventos_vinculados', type: 'string'},
		{name: 'nome_usuario', type: 'string'},
		{name: 'email', type: 'string'},
		{name: 'password', type: 'string'},
		{name: 'bool_ativo', type: 'int'},
		{name: 'fgk_grupo', type: 'int'},
		{name: 'grupo', type: 'string'},
		{name: 'descricao_grupo', type: 'string'}
	]
});