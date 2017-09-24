Ext.define('Seic.view.module.Credenciamento', {
    extend: 'Ext.ux.desktop.Module',
	id: 'credenciamento-win',

	init: function() {
		// AQUI CRIA O ATALHO NO MENU INICIAR
        this.launcher = {
            text: 'Credenciamento',
            iconCls:'credenciamento-minishortcut'
        };
    },
    createWindow: function() {
        var desktop = this.app.getDesktop();
        var win = desktop.getWindow('credenciamento-win');
        if(!win){
            win = desktop.createWindow({
                id: 'credenciamento-win',
				iconCls: 'credenciamento-minishortcut',
                closeAction:'hide',
                title:'Credenciamento',
                layout: 'fit',
                modal: true,
                constrain: true,
                resizable: false,
                width: 1000,
                height: 733,
                items:[{ xtype: 'modcre_maincredenciamento' }]
            });
        }
        return win;
    }

});