Ext.define('Seic.model.Admin.GrupoModulo', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_modulo', type: 'int'},
		{name: 'id_grupo', type: 'int'},		
		{name: 'nome_modulo', type: 'string'},
		{name: 'bool_liberado', type: 'bool'},
		{name: 'bool_mod_super_adm', type: 'bool'}
	]
});