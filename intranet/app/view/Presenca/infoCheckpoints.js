Ext.define('Seic.view.Presenca.infoCheckpoints',{
    alias: 'widget.infocheckpointschart',
	extend: 'Ext.window.Window',
    modal: true,
    width: 550,
    height: 420,
    title: 'Informações de credenciamentos',
    iconCls: 'presenca-minishortcut',
    layout: 'fit',
    items: [{
        xtype: 'chart',
        id: 'checkpointsChart',
        legend: {
            position: 'right'
        },
        insetPadding: 20,
        animate: true,
        store: 'Seic.store.Presenca.Chart1',
        theme: 'Base:gradients',
        series: [{
            type: 'pie',
            angleField: 'num_inscritos',
            showInLegend: true,
            donut: false,
            tips: {
                trackMouse: true,
                width: 150,
                renderer: function(storeItem, item){
                    var store = Ext.getCmp('checkpointsChart').getStore();
                    // calculate and display percentage on hover
                    var total = 0;
                    store.each(function(rec) {
                        total += rec.get('num_inscritos');
                    });
                    this.setTitle(storeItem.get('num_inscritos') +' inscritos: '+ Math.round(storeItem.get('num_inscritos') / total * 100) + '%');
                }
            },
            highlight: {
                segment: {
                    margin: 20
                }
            },
            label: {
                field: 'checkpoint',
                display: 'rotate',
                contrast: true,
                font: '11px Arial',
                hideLessThan: 18
            }
        }]
    },{
        xtype: 'label',
        itemId: 'labelTotal',
        text: 'Total:'
    }]
});