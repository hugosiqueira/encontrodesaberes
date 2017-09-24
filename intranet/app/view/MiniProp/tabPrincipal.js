Ext.define('Seic.view.MiniProp.tabPrincipal', {
    extend: 'Ext.tab.Panel',
    alias : 'widget.modminiprop_tabPrincipal',
    requires: [
		'Ext.tab.Panel'
	],
    layout: 'fit',
    autoShow: true,
    initComponent: function() {
        this.items = [
			{	xtype: 'modminiprop_gridMiniCursosAprovados'	},
			{	xtype: 'modminiprop_gridMiniCursosPropostos'	},
			{	xtype: 'modminiprop_gridMiniCursosInscritos'	},
        ];    
        this.callParent(arguments);
    }
}); 