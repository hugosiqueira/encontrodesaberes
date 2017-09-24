Ext.define('Seic.view.module.Financeiro', {
    extend: 'Ext.ux.desktop.Module',
	id: 'financeiro-win',
    alias: 'widget.financeirowin',

	init: function() {
		// AQUI CRIA O ATALHO NO MENU INICIAR
        this.launcher = {
            text: 'Financeiro',
            iconCls:'financeiro-minishortcut'
        };
    },
    createWindow: function() {
        var desktop = this.app.getDesktop();
        var win = desktop.getWindow('financeiro-win');
        if(!win){
            win = desktop.createWindow({
                id: 'financeiro-win',
				iconCls: 'financeiro-minishortcut',
                closeAction:'hide',
                title:'Financeiro',
                layout: 'fit',
                modal: true,
                constrain: true,
                resizable: false,
                width: 1000,
                height: 773,
                items:[{ xtype: 'modfin_main' }],
				listeners: {
					beforerender: function(){
						if(screen.height < 800){
							this.setHeight(650)
						}						
					}
				}
            });
        }
        return win;
    }

});