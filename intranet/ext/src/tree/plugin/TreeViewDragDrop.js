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
 * This plugin provides drag and/or drop functionality for a TreeView.
 *
 * It creates a specialized instance of {@link Ext.dd.DragZone DragZone} which knows how to drag out of a
 * {@link Ext.tree.View TreeView} and loads the data object which is passed to a cooperating
 * {@link Ext.dd.DragZone DragZone}'s methods with the following properties:
 *
 *   - copy : Boolean
 *
 *     The value of the TreeView's `copy` property, or `true` if the TreeView was configured with `allowCopy: true` *and*
 *     the control key was pressed when the drag operation was begun.
 *
 *   - view : TreeView
 *
 *     The source TreeView from which the drag originated.
 *
 *   - ddel : HtmlElement
 *
 *     The drag proxy element which moves with the mouse
 *
 *   - item : HtmlElement
 *
 *     The TreeView node upon which the mousedown event was registered.
 *
 *   - records : Array
 *
 *     An Array of {@link Ext.data.Model Models} representing the selected data being dragged from the source TreeView.
 *
 * It also creates a specialized instance of {@link Ext.dd.DropZone} which cooperates with other DropZones which are
 * members of the same ddGroup which processes such data objects.
 *
 * Adding this plugin to a view means that two new events may be fired from the client TreeView, {@link #beforedrop} and
 * {@link #drop}.
 *
 * Note that the plugin must be added to the tree view, not to the tree panel. For example using viewConfig:
 *
 *     viewConfig: {
 *         plugins: { ptype: 'treeviewdragdrop' }
 *     }
 */
Ext.define('Ext.tree.plugin.TreeViewDragDrop', {
    extend: 'Ext.AbstractPlugin',
    alias: 'plugin.treeviewdragdrop',

    uses: [
        'Ext.tree.ViewDragZone',
        'Ext.tree.ViewDropZone'
    ],

    /**
     * @event beforedrop
     *
     * **This event is fired through the TreeView. Add listeners to the TreeView object**
     *
     * Fired when a drop gesture has been triggered by a mouseup event in a valid drop position in the TreeView.
     * 
     * Returning `false` to this event signals that the drop gesture was invalid, and if the drag proxy will animate
     * back to the point from which the drag began.
     *
     * The dropHandlers parameter can be used to defer the processing of this event. For example to wait for the result of 
     * a message box confirmation or an asynchronous server call. See the details of this property for more information.
     *  
     *     @example
     *     view.on('beforedrop', function(node, data, overModel, dropPosition, dropHandlers) {
     *         // Defer the handling
     *         dropHandlers.wait = true;
     *         Ext.MessageBox.confirm('Drop', 'Are you sure', function(btn){
     *             if (btn === 'yes') {
     *                 dropHandlers.processDrop();
     *             } else {
     *                 dropHandlers.cancelDrop();
     *             }
     *         });
     *     });
     *
     * Any other return value continues with the data transfer operation, unless the wait property is set.
     *
     * @param {HTMLElement} node The TreeView node **if any** over which the mouse was positioned.
     *
     * @param {Object} data The data object gathered at mousedown time by the cooperating
     * {@link Ext.dd.DragZone DragZone}'s {@link Ext.dd.DragZone#getDragData getDragData} method it contains the following
     * properties:
     * @param {Boolean} data.copy The value of the TreeView's `copy` property, or `true` if the TreeView was configured with
     * `allowCopy: true` and the control key was pressed when the drag operation was begun
     * @param {Ext.tree.View} data.view The source TreeView from which the drag originated.
     * @param {HTMLElement} data.ddel The drag proxy element which moves with the mouse
     * @param {HTMLElement} data.item The TreeView node upon which the mousedown event was registered.
     * @param {Ext.data.Model[]} data.records An Array of {@link Ext.data.Model Model}s representing the selected data being
     * dragged from the source TreeView.
     *
     * @param {Ext.data.Model} overModel The Model over which the drop gesture took place.
     *
     * @param {String} dropPosition `"before"`, `"after"` or `"append"` depending on whether the mouse is above or below
     * the midline of the node, or the node is a branch node which accepts new child nodes.
     *
     * @param {Object} dropHandlers
     * This parameter allows the developer to control when the drop action takes place. It is useful if any asynchronous
     * processing needs to be completed before performing the drop. This object has the following properties:
     * 
     * @param {Boolean} dropHandlers.wait Indicates whether the drop should be deferred. Set this property to true to defer the drop.
     * @param {Function} dropHandlers.processDrop A function to be called to complete the drop operation.
     * @param {Function} dropHandlers.cancelDrop A function to be called to cancel the drop operation.
     */

    /**
     * @event drop
     *
     * **This event is fired through the TreeView. Add listeners to the TreeView object** Fired when a drop operation
     * has been completed and the data has been moved or copied.
     *
     * @param {HTMLElement} node The TreeView node **if any** over which the mouse was positioned.
     *
     * @param {Object} data The data object gathered at mousedown time by the cooperating
     * {@link Ext.dd.DragZone DragZone}'s {@link Ext.dd.DragZone#getDragData getDragData} method it contains the following
     * properties:
     * @param {Boolean} data.copy The value of the TreeView's `copy` property, or `true` if the TreeView was configured with
     * `allowCopy: true` and the control key was pressed when the drag operation was begun
     * @param {Ext.tree.View} data.view The source TreeView from which the drag originated.
     * @param {HTMLElement} data.ddel The drag proxy element which moves with the mouse
     * @param {HTMLElement} data.item The TreeView node upon which the mousedown event was registered.
     * @param {Ext.data.Model[]} data.records An Array of {@link Ext.data.Model Model}s representing the selected data being
     * dragged from the source TreeView.
     *
     * @param {Ext.data.Model} overModel The Model over which the drop gesture took place.
     *
     * @param {String} dropPosition `"before"`, `"after"` or `"append"` depending on whether the mouse is above or below
     * the midline of the node, or the node is a branch node which accepts new child nodes.
     */

    //<locale>
    /**
     * @cfg
     * The text to show while dragging.
     *
     * Two placeholders can be used in the text:
     *
     * - `{0}` The number of selected items.
     * - `{1}` 's' when more than 1 items (only useful for English).
     */
    dragText : '{0} selected node{1}',
    //</locale>

    /**
     * @cfg {Boolean} allowParentInserts
     * Allow inserting a dragged node between an expanded parent node and its first child that will become a sibling of
     * the parent when dropped.
     */
    allowParentInserts: false,

    /**
     * @cfg {Boolean} allowContainerDrops
     * True if drops on the tree container (outside of a specific tree node) are allowed.
     */
    allowContainerDrops: false,

    /**
     * @cfg {Boolean} appendOnly
     * True if the tree should only allow append drops (use for trees which are sorted).
     */
    appendOnly: false,

    /**
     * @cfg {String} ddGroup
     * A named drag drop group to which this object belongs. If a group is specified, then both the DragZones and
     * DropZone used by this plugin will only interact with other drag drop objects in the same group.
     */
    ddGroup : "TreeDD",
    
    /**
     * True to register this container with the Scrollmanager for auto scrolling during drag operations.
     * A {@link Ext.dd.ScrollManager} configuration may also be passed.
     * @cfg {Object/Boolean} containerScroll
     */
    containerScroll: false,

    /**
     * @cfg {String} dragGroup
     * The ddGroup to which the DragZone will belong.
     *
     * This defines which other DropZones the DragZone will interact with. Drag/DropZones only interact with other
     * Drag/DropZones which are members of the same ddGroup.
     */

    /**
     * @cfg {String} dropGroup
     * The ddGroup to which the DropZone will belong.
     *
     * This defines which other DragZones the DropZone will interact with. Drag/DropZones only interact with other
     * Drag/DropZones which are members of the same ddGroup.
     */

    /**
     * @cfg {Boolean} [sortOnDrop=false]
     * Configure as `true` to sort the target node into the current tree sort order after the dropped node is added.
     */

    /**
     * @cfg {Number} expandDelay
     * The delay in milliseconds to wait before expanding a target tree node while dragging a droppable node over the
     * target.
     */
    expandDelay : 1000,

    /**
     * @cfg {Boolean} enableDrop
     * Set to `false` to disallow the View from accepting drop gestures.
     */
    enableDrop: true,

    /**
     * @cfg {Boolean} enableDrag
     * Set to `false` to disallow dragging items from the View.
     */
    enableDrag: true,

    /**
     * @cfg {String} nodeHighlightColor
     * The color to use when visually highlighting the dragged or dropped node (default value is light blue).
     * The color must be a 6 digit hex value, without a preceding '#'. See also {@link #nodeHighlightOnDrop} and
     * {@link #nodeHighlightOnRepair}.
     */
    nodeHighlightColor: 'c3daf9',

    /**
     * @cfg {Boolean} nodeHighlightOnDrop
     * Whether or not to highlight any nodes after they are
     * successfully dropped on their target. Defaults to the value of `Ext.enableFx`.
     * See also {@link #nodeHighlightColor} and {@link #nodeHighlightOnRepair}.
     */
    nodeHighlightOnDrop: Ext.enableFx,

    /**
     * @cfg {Boolean} nodeHighlightOnRepair
     * Whether or not to highlight any nodes after they are
     * repaired from an unsuccessful drag/drop. Defaults to the value of `Ext.enableFx`.
     * See also {@link #nodeHighlightColor} and {@link #nodeHighlightOnDrop}.
     */
    nodeHighlightOnRepair: Ext.enableFx,
    
    /**
     * @cfg {String} displayField
     * The name of the model field that is used to display the text for the nodes
     */
    displayField: 'text',

    init : function(view) {
        view.on('render', this.onViewRender, this, {single: true});
    },

    /**
     * @private
     * AbstractComponent calls destroy on all its plugins at destroy time.
     */
    destroy: function() {
        Ext.destroy(this.dragZone, this.dropZone);
    },

    onViewRender : function(view) {
        var me = this,
            scrollEl;

        if (me.enableDrag) {
            if (me.containerScroll) {
                scrollEl = view.getEl();
            }
            me.dragZone = new Ext.tree.ViewDragZone({
                view: view,
                ddGroup: me.dragGroup || me.ddGroup,
                dragText: me.dragText,
                displayField: me.displayField,
                repairHighlightColor: me.nodeHighlightColor,
                repairHighlight: me.nodeHighlightOnRepair,
                scrollEl: scrollEl
            });
        }

        if (me.enableDrop) {
            me.dropZone = new Ext.tree.ViewDropZone({
                view: view,
                ddGroup: me.dropGroup || me.ddGroup,
                allowContainerDrops: me.allowContainerDrops,
                appendOnly: me.appendOnly,
                allowParentInserts: me.allowParentInserts,
                expandDelay: me.expandDelay,
                dropHighlightColor: me.nodeHighlightColor,
                dropHighlight: me.nodeHighlightOnDrop,
                sortOnDrop: me.sortOnDrop,
                containerScroll: me.containerScroll
            });
        }
    }
}, function(){
    var proto = this.prototype;
    proto.nodeHighlightOnDrop = proto.nodeHighlightOnRepair = Ext.enableFx;
});
