Ext.define('Seic.model.Admin.Grupo', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_grupo', type: 'int'},
		{name: 'grupo', type: 'string'},
		{name: 'descricao_grupo', type: 'string'},
		{name: 'bool_ativo', type: 'int'},
		{name: 'bool_grp_super_adm', type: 'bool'},
		{name: 'usuarios', type: 'int'}		
	]
});