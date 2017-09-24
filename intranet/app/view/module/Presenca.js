Ext.define('Seic.view.module.Presenca', {
    extend: 'Ext.ux.desktop.Module',
	id: 'presenca-win',
	init: function() {
        this.launcher = {
            text: 'Registro de presença',
            iconCls: 'presenca-minishortcut'
        };
    },
    createWindow: function() {
        var desktop = this.app.getDesktop();
        var win = desktop.getWindow('presenca-win');
        if(!win){
            win = desktop.createWindow({
                id: 'presenca-win',
                iconCls: 'presenca-minishortcut',
                closeAction: 'destroy',
                title:'Registro de presença',
                width: 800,
                height: 600,
                layout: 'fit',
                resizable: false,
                items: [{
                    xtype: 'modpre_mainpresenca'
                }]
            });
        }
        return win;
    }
});