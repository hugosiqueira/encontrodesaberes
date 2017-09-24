Ext.define('Seic.model.Certificados.TipoCertificado', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_tipo_certificado', 		type: 'int'},
		{name: 'descricao_certificado',		type: 'string'},
		{name: 'modelo_padrao',				type: 'string'},
	]
});