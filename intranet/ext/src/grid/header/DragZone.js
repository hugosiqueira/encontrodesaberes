/*
This file is part of Ext JS 4.2

Copyright (c) 2011-2013 Sencha Inc

Contact:  http://www.sencha.com/contact

GNU General Public License Usage
This file may be used under the terms of the GNU General Public License version 3.0 as
published by the Free Software Foundation and appearing in the file LICENSE included in the
packaging of this file.

Please review the following information to ensure the GNU General Public License version 3.0
requirements will be met: http://www.gnu.org/copyleft/gpl.html.

If you are unsure which license is appropriate for your use, please contact the sales department
at http://www.sencha.com/contact.

Build date: 2013-05-16 14:36:50 (f9be68accb407158ba2b1be2c226a6ce1f649314)
*/
/**
 * @private
 */
Ext.define('Ext.grid.header.DragZone', {
    extend: 'Ext.dd.DragZone',
    colHeaderSelector: '.' + Ext.baseCSSPrefix + 'column-header',
    colInnerSelector: '.' + Ext.baseCSSPrefix + 'column-header-inner',
    maxProxyWidth: 120,

    constructor: function(headerCt) {
        this.headerCt = headerCt;
        this.ddGroup =  this.getDDGroup();
        this.callParent([headerCt.el]);
        this.proxy.el.addCls(Ext.baseCSSPrefix + 'grid-col-dd');
    },
    
    getDDGroup: function() {
        return 'header-dd-zone-' + this.headerCt.up('[scrollerOwner]').id;
    },

    getDragData: function(e) {
        if (e.getTarget(this.colInnerSelector)) {
            var header = e.getTarget(this.colHeaderSelector),
                headerCmp,
                ddel;

            if (header) {
                headerCmp = Ext.getCmp(header.id);
                if (!this.headerCt.dragging && headerCmp.draggable && !(headerCmp.isOnLeftEdge(e) || headerCmp.isOnRightEdge(e))) {
                    ddel = document.createElement('div');
                    ddel.innerHTML = Ext.getCmp(header.id).text;
                    return {
                        ddel: ddel,
                        header: headerCmp
                    };
                }
            }
        }
        return false;
    },

    onBeforeDrag: function() {
        return !(this.headerCt.dragging || this.disabled);
    },

    onInitDrag: function() {
        this.headerCt.dragging = true;
        this.callParent(arguments);
    },

    onDragDrop: function() {
        this.headerCt.dragging = false;
        this.callParent(arguments);
    },

    afterRepair: function() {
        this.callParent();
        this.headerCt.dragging = false;
    },

    getRepairXY: function() {
        return this.dragData.header.el.getXY();
    },
    
    disable: function() {
        this.disabled = true;
    },
    
    enable: function() {
        this.disabled = false;
    }
});
