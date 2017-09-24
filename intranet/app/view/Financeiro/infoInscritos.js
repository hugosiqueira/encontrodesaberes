Ext.define('Seic.view.Financeiro.infoInscritos',{
	extend: 'Ext.window.Window',
	alias: 'widget.modfin_infoinscritos',
	title: 'Informações do inscrito',
	iconCls:'financeiro-minishortcut',
	constrain: true,		
	bodyBorder: false,
	border: false,
	constrain: true,
	modal: true,
	width: 750,
	padding: 4,
	layout: {
        type: 'fit',
        align: 'stretch'
    },

	items:[{
		xtype: 'form',
		id: 'modfin_formInscINFO',
		border: false,
		items: [{
			xtype: 'fieldset',
			title: 'Pessoal',
			items:[{
				xtype: 'hiddenfield',
				name: 'id'
			},{
				xtype: 'displayfield',
				fieldLabel: 'Nome',
				labelStyle: 'font-weight:bold;',
		        name: 'nome',
		        labelWidth: 40
			},{
				layout: 'hbox',
				border: false,
				items: [{
					xtype: 'displayfield',
					fieldLabel: 'CPF',
					labelStyle: 'font-weight:bold;',
			        name: 'cpf',
			        labelWidth: 30
				},{
					xtype: 'displayfield',
					fieldLabel: 'Tipo',
					labelStyle: 'font-weight:bold;',
			        name: 'descricao_tipo',
			        labelWidth: 30,
			        padding: '0 0 0 30' //(top, right, bottom, left).
				},{
					xtype: 'displayfield',
					fieldLabel: 'Instituição',
					labelStyle: 'font-weight:bold;',
			        name: 'sigla_instituicao',
			        labelWidth: 75,
			        padding: '0 0 0 30'
				},{
					xtype: 'displayfield',
					fieldLabel: 'Telefone',
					labelStyle: 'font-weight:bold;',
			        name: 'telefone_celular',
			        labelWidth: 65,
			        padding: '0 0 0 30'
				}]
			}]
		},{
			xtype: 'fieldset',
			title: 'Serviços',
			items:[{
				xtype: 'grid',
				itemId: 'inscServicos',
				store: 'Seic.store.Financeiro.InscServicos',
				border: false,
				minHeight: 100,
				hideHeaders: true,
			    columns: {
			        defaults: {
			            menuDisabled: true,
			            resizable: false
			        },

			        items: [{
				    	text: 'Serviço',  
				    	dataIndex: 'descricao_servico',
				    	flex: 7
				    },{
				    	text: 'Pago', 
				    	dataIndex: 'bool_pago',
				    	flex: 3,
	    	            renderer: function(value, metaData, record, rowIndex, colIndex, store){
			    			if(record.data.bool_pago == 1)
			    				metaData.tdCls = 'tag-pago'
			    			else if(record.data.bool_pago == 0)
			    				metaData.tdCls = 'tag-aguardando'
			    		}
				    }]
				}
			},{
				xtype: 'toolbar',
				border: false,
				items:['->',{
					itemId: 'addServico',
					iconCls: 'icon-add',
					tooltip: 'Adicionar serviço'
				},{
					itemId: 'removeServico',
					iconCls: 'icon-delete',
					tooltip: 'Remover serviço',
					disabled: true
				},{
					itemId: 'receberServico',
					iconCls: 'icon-pg-add',
					tooltip: 'Pagamento',
					disabled: true
				}]
			}]
		},{
			xtype: 'fieldset',
			title: 'Boletos',
			items:[{
				xtype: 'grid',
				itemId: 'inscBoletos',
				store: 'Seic.store.Financeiro.Boletos',
				border: false,
				minHeight: 120,
			    columns: {
			        defaults: {
			            menuDisabled: true,
			            resizable: false
			        },

			        items: [{
				    	text: 'Serviço',  
				    	dataIndex: 'descricao_servico',
				    	flex: 1.6
				    },{
				    	text: 'Vencimento',
				    	dataIndex: 'data_vencimento',
				    	xtype: 'datecolumn',
				    	format:'d-m-Y',
				    	align: 'center',
				    	flex: 0.5
				    },{ 
				    	text: 'Valor', 
				    	dataIndex: 'valor_servico',
				    	flex: 0.4,
				    	renderer: function(value, metaData){
				        	Ext.apply(Ext.util.Format, {
			                    thousandSeparator : ".",
			                    decimalSeparator  : ","
			                });
				        	return "R$" + Ext.util.Format.number(value/100, '0.0,0');
				        }
				    },{
				    	text: 'Valor pago', 
				    	dataIndex: 'valor_pago',
				    	flex: 0.4,
				    	renderer: function(value, metaData, record, rowIndex, colIndex, store){
			    			if(record.data.valor_pago == 0){
			    				return '';
			    			}else{
			    				Ext.apply(Ext.util.Format, {
				                    thousandSeparator : ".",
				                    decimalSeparator  : ","
				                });
					        	return "R$" + Ext.util.Format.number(value/100, '0.0,0');
			    			}
			    		}
				    },{
				    	text: 'Data pagamento', 
				    	dataIndex: 'data_pagamento',
				    	flex: 0.6,
				    	align: 'center',
	    	            renderer: function(value, metaData, record, rowIndex, colIndex, store){
			    			if(record.data.bool_pago == 0){
			    				var hoje = new Date();
			    				var vencimento = record.data.data_vencimento;
			    				if(hoje > vencimento){
			    					metaData.tdCls = 'tag-vencido'
			    				}else
			    					metaData.tdCls = 'tag-aguardando'
			    			}else
			    				return Ext.util.Format.date(value, 'd-m-Y');
			    		}
				    }]
				}
			},{
				xtype: 'toolbar',
				border: false,
				items:['->',{
					itemId: 'visualizarBoleto',
					iconCls: 'icon-eye',
					tooltip: 'Visualizar boleto',
					disabled: true
				},{
					itemId: 'editarBoleto',
					iconCls: 'icon-edit',
					tooltip: 'Mudar vencimento',
					disabled: true,
					hidden: true
				},{
					itemId: 'reenviarEmail',
					iconCls: 'icon-email',
					tooltip: 'Reenviar e-mail de notificação',
					disabled: true
				}]
			}]
		}]
	}]
});