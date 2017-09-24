Ext.define('Seic.model.Financeiro.Instituicoes',{
	extend: 'Ext.data.Model',
    fields: [
    	{ name: 'id', type: 'int' },
    	{ name: 'sigla', type: 'string' },
    	{ name: 'sig_nome', type: 'string' }
    ]
});