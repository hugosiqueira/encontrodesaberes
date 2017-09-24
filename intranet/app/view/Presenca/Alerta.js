Ext.define('Seic.view.Presenca.Alerta',{
	extend: 'Ext.window.Window',
    border: false,
    resizable: false,
    draggable: false,
    closable: false,
    modal: true,
    width: 550,
    height: 142,
    items: [{
        xtype: 'panel',
        items: [{
            layout: 'hbox',
            items: [{
                xtype: 'image',
                src: 'resources/images/Error-128.png',
                height: 128,
                width: 128
            },{
                xtype: 'displayfield',
                itemId: 'messageWarning',
                labelAlign: 'top',
                value: '',
                padding: '20 0 0 10',// (top, right, bottom, left).
                border: false,
                fieldStyle: {
                    'font-weight': 'bold',
                    'fontSize': '30px',
                    'color': '#FF0D1D',
                    'text-align': 'right',
                    'line-height': '200%'
                }
            }]
        }]
    }],
    listeners:{
        show: function(winAlert) {
            setTimeout(function() {
                winAlert.destroy()
                Ext.getCmp('modpre_mainpresenca').down('#codcred').focus();
            },3000);
        }
    }
});