Ext.define('Seic.model.Credenciamento.Presencas', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_presenca', type: 'int'},
		{name: 'checkpoint', type: 'string'},
		{name: 'datahora_presenca', type: 'date', 	dateFormat: 'c'}
	]
});