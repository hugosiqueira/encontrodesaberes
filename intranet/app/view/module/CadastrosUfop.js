/*
 * File: app/view/module/Company.js
 *
 * This file was generated by Sencha Architect version 3.0.0.
 * http://www.sencha.com/products/architect/
 *
 * This file requires use of the Ext JS 4.2.x library, under independent license.
 * License of Sencha Architect does not include license for Ext JS 4.2.x. For more
 * details see http://www.sencha.com/license or contact license@sencha.com.
 *
 * This file will be auto-generated each and everytime you save your project.
 *
 * Do NOT hand edit this file.

 */

Ext.define('Seic.view.module.CadastrosUfop', {
    extend: 'Ext.ux.desktop.Module',
	id: 'cadastrosufop-win',
	init: function() {
		// AQUI CRIA O ATALHO NO MENU INICIAR
        this.launcher = {
            text: 'Cadastros UFOP',
            iconCls:'cadastrosufop-minishortcut'
        };
    },
    createWindow: function() {
        var desktop = this.app.getDesktop();
        var win = desktop.getWindow('cadastrosufop-win');
        if(!win){
            win = desktop.createWindow({
                id: 'cadastrosufop-win',
				iconCls: 'cadastrosufop-minishortcut',
                closeAction:'hide',
                title:'Cadastros UFOP',
                width:1000,
                height:820,
                layout:{
					type:'fit'
				},
				items:[
					{xtype:'modcadufop_tabcadastrosufop'}
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