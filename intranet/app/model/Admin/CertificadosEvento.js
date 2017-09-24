Ext.define('Seic.model.Admin.CertificadosEvento', {
    extend: 'Ext.data.Model',
    fields: [
		{name: 'id_tipo_certificado', 	type: 'int'},
		{name: 'fgk_evento', 			type: 'int'},
		{name: 'bool_imagem', 			type: 'int'},
		{name: 'descricao_certificado', type: 'string'},
		{name: 'modelo_padrao',			type: 'string'}
	]
});