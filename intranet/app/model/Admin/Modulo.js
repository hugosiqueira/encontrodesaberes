Ext.define('Seic.model.Admin.Modulo', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_modulo', type: 'int'},
		{name: 'nome_modulo', type: 'string'},
		{name: 'js', type: 'string'},
		{name: 'name', type: 'string'},
		{name: 'iconCls', type: 'string'},
		{name: 'module', type: 'string'},
		{name: 'iconLaunch', type: 'string'},
		{name: 'bool_ativo', type: 'int'},
		{name: 'bool_mod_super_adm', type: 'bool'}	
	]
});