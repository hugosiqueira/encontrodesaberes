Ext.define('Seic.view.module.Anais', {
    extend: 'Ext.ux.desktop.Module',
	id: 'anais-win',
	init: function() {
		// AQUI CRIA O ATALHO NO MENU INICIAR
        this.launcher = {
            text: 'Anais',
            iconCls:'anais-minishortcut'
        };
    },
    createWindow: function() {
        var desktop = this.app.getDesktop();
        var win = desktop.getWindow('anais-win');
        if(!win){
             win = desktop.createWindow({
               id: 'anais-win',
				iconCls: 'anais-minishortcut',
                closeAction:'hide',
                title:'Anais',
                width:1200,
                height:800,
                layout:{
                        type:'fit'
                    },
                items:[
					{	xtype: 'modanais_gridAnais'	},
				],
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