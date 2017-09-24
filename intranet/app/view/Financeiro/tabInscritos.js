Ext.define('Seic.view.Financeiro.tabInscritos',{
	extend: 'Ext.grid.Panel',
	alias: 'widget.modfin_tabinscritos',
    id: 'modfin_tabinscritos',

	store: 'Seic.store.Financeiro.gridPrincipal',
    resizable: false,
    border: false,
    padding: 3,

    columns: {
        defaults: {
            menuDisabled: true,
            resizable: false
        },

        items: [{
            text: 'Nome',  
            dataIndex: 'nome',
            flex: 3.6
        },{ 
            text: 'CPF', 
            dataIndex: 'cpf',
            flex: 1.2
        },{ 
            text: 'Tipo', 
            dataIndex: 'descricao_tipo',
            flex: 1.2
        },{ 
            text: 'Instituição', 
            dataIndex: 'sigla_instituicao',
            flex: 1
        },{ 
            text: 'Status', 
            dataIndex: 'quite',
            flex: 1,
            renderer: function(value, metaData, record, rowIndex, colIndex, store){
    			if(record.data.quite == 1){
    				metaData.tdCls = 'icon-boleto_confirmado'
    				metaData.tdAttr = 'data-qtip="Inscrito sem pedências"';
    			}else if(record.data.quite == 2){
                    metaData.tdCls = 'icon-inscrito_semServicos'
                    metaData.tdAttr = 'data-qtip="Sem serviços"';
                }else{
    				metaData.tdCls = 'icon-boleto_inadimplente'
    				metaData.tdAttr = 'data-qtip="Inscrito com pendência(s)"';
    			}
    		}
        },{ 
            text: 'Credenciado', 
            itemId: 'credenciado',
            dataIndex: 'credencial',
            flex: 1,
            renderer: function(value, metaData, record, rowIndex, colIndex, store){
                if(record.data.credencial == 1){
                    metaData.tdCls = 'icon-credencial_ok'
                    metaData.tdAttr = 'data-qtip="Inscrito credenciado"';
                }else{
                    metaData.tdCls = 'icon-credencial_bad'
                    metaData.tdAttr = 'data-qtip="Inscrito não credenciado"';
                }
            }
        }]
    },

    dockedItems: [{
        xtype: 'toolbar',
        dock: 'top',
        defaults: {
        	width: 140
        },

        items: [{
            text: 'Informações',
            itemId: 'modfin_btnInformacao',
            iconCls: 'icon-info',
            disabled: true
        },{
            text: 'Inserir chave',
            itemId: 'modfin_btnDetalhamento',
            iconCls: 'icon-gerencianet',
            hidden: true
        },'->',{
            xtype: 'searchfield',
            store: 'Seic.store.Financeiro.gridPrincipal',
            emptyText: 'Busca rápida...',
            paramName: 'filtro',
            width: 250
        },{
            text: 'Busca avançada',
            itemId: 'BA_inscritos'
        }]
    },{
        xtype: 'toolbar',
        id: 'modcfin_barraBuscaInscritos',
        dock: 'top',
        hidden: true,
        style: {
            background: '#FF6666'
        }
    },{  
        xtype: 'pagingtoolbar',
        dock: 'bottom',
        store: 'Seic.store.Financeiro.gridPrincipal',
        displayInfo: true,
        displayMsg: 'Exibindo {0} - {1} de {2} inscritos',
        emptyMsg: "Nenhum inscrito encontrado."
    }]
});