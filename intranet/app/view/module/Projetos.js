Ext.define('Seic.view.module.Projetos', {
    extend: 'Ext.ux.desktop.Module',
	id: 'projetos-win',

	init: function() {
		// AQUI CRIA O ATALHO NO MENU INICIAR
        this.launcher = {
            text: 'Projetos',
            iconCls:'projetos-minishortcut'
        };
    },
    createWindow: function() {
        var desktop = this.app.getDesktop();
        var win = desktop.getWindow('projetos-win');
        if(!win){
            win = desktop.createWindow({
                id: 'projetos-win',
				iconCls: 'projetos-minishortcut',
                closeAction:'hide',
                title:'Projetos',
                layout: 'fit',
                modal: true,
                constrain: true,
                resizable: false,
                width:1200,
                height:755,
                items:[{ xtype: 'modprojetos_mainprojetos' }],
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