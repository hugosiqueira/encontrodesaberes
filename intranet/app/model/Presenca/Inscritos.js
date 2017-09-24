Ext.define('Seic.model.Presenca.Inscritos', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'fgk_inscrito', type: 'int'},
		{name: 'fgk_local_presenca', type: 'string'},
		{name: 'nome', type: 'string'},
		{name: 'info_credencial', type: 'string'},
		{name: 'datahora_presenca', type: 'date', 	dateFormat: 'c'}
	]
});