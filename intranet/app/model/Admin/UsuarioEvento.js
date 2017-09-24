Ext.define('Seic.model.Admin.UsuarioEvento', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id', type: 'int'},
		{name: 'fgk_usuario', type: 'int'},
		{name: 'titulo', type: 'string'},
		{name: 'sigla', type: 'string'},
		{name: 'bool_liberado', type: 'bool'}		,
		{name: 'data_evento_ini',	type: 'date', 	dateFormat: 'c', submitFormat:'Y-m-d'}
	]
});