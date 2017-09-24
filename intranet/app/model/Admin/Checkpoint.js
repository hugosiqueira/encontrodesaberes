Ext.define('Seic.model.Admin.Checkpoint', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_local_presenca', type: 'int'},
		{name: 'descricao_local', type: 'string'},
		{name: 'apelido_local', type: 'string'},
		{name: 'num_resp', type: 'int'}
	]
});