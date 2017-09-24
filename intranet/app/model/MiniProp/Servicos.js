Ext.define('Seic.model.MiniProp.Servicos', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_servico', 		type: 'int'},
		{name: 'descricao_servico', type: 'string'},
		{name: 'valor_servico', type: 'int'}
	]
});