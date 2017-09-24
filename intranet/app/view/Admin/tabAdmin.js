Ext.define('Seic.view.Admin.tabAdmin', {
    extend: 'Ext.tab.Panel',
    alias : 'widget.tabadmin',
    requires: [
		'Ext.tab.Panel',
		'Ext.grid.Panel'
	],
    layout: 'fit',
    autoShow: true,
    initComponent: function() {
        this.items = [
			{	xtype: 'gridusuarios'	},
			{	xtype: 'grideventos'	},			
			{	xtype: 'gridgrupos'		},
			{	xtype: 'gridmodulos'	}
        ];    
        this.callParent(arguments);
    }
}); 