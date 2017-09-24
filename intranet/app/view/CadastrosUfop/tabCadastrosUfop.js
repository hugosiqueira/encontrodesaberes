Ext.define('Seic.view.CadastrosUfop.tabCadastrosUfop', {
    extend: 'Ext.tab.Panel',
    alias : 'widget.modcadufop_tabcadastrosufop',
    requires: [
		'Ext.tab.Panel',
		'Ext.grid.Panel'
	],
    layout: 'fit',
    autoShow: true,
    initComponent: function() {
        this.items = [
			{	xtype: 'modcadufop_gridProfessoresTA'	},
			{	xtype: 'modcadufop_gridAlunos'	},
			{	xtype: 'modcadufop_gridCursos'	},
			{	xtype: 'modcadufop_gridDepartamentos'	},
			{	xtype: 'modcadufop_gridAreas'	},
			{	xtype: 'modcadufop_gridAreasEspecificas'	},
			
        ];    
        this.callParent(arguments);
    }
}); 