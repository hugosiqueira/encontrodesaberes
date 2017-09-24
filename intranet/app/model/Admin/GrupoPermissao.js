Ext.define('Seic.model.Admin.GrupoPermissao', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_permissao', type: 'int'},
		{name: 'id_grupo', type: 'int'},		
		{name: 'permissao', type: 'string'},
		{name: 'descricao_permissao', type: 'string'},
		{name: 'permissao', type: 'string'},
		{name: 'bool_liberado', type: 'bool'}		
	]
});