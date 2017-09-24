Ext.define('Seic.store.Financeiro.TipoPagamentos',{
	extend: 'Ext.data.Store',
    model: 'Seic.model.Financeiro.TipoPagamentos',
    remoteFilter: true,
    autoLoad: false,
    proxy: {
        type: 'ajax',
        api: {
            read: 'Server/financeiro/listaTipoPagamentos.php'
        },

        reader: {
            type: 'json',
            root: 'tipo_pagamentos',
            successProperty: 'success'
        },

        listeners: {
            exception: function(proxy, response, operation){
                Ext.MessageBox.show({
                    title: 'Erro',
                    msg: operation.getError(),
                    icon: Ext.MessageBox.ERROR,
                    buttons: Ext.Msg.OK
                });
            }
        }
    }
});