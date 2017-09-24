Ext.define('Seic.view.module.Avaliacoes', {
    extend: 'Ext.ux.desktop.Module',
	id: 'avaliacoes-win',
	init: function() {
		// AQUI CRIA O ATALHO NO MENU INICIAR
        this.launcher = {
            text: 'Avaliações',
            iconCls:'avaliacoes-minishortcut'
        };
    },
    createWindow: function() {
        var desktop = this.app.getDesktop();
        var win = desktop.getWindow('avaliacoes-win');
        if(!win){
             win = desktop.createWindow({
               id: 'avaliacoes-win',
				iconCls: 'avaliacoes-minishortcut',
                closeAction:'hide',
                title:'Avaliações',
                width:1200,
                height:800,
                layout:{
                        type:'fit'
                    },
                items:[
					{	xtype: 'modaval_gridAvaliacoes'	},
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