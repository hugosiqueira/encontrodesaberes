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
 * This class provides a container DD instance that allows dropping on multiple child target nodes.
 *
 * By default, this class requires that child nodes accepting drop are registered with {@link Ext.dd.Registry}.
 * However a simpler way to allow a DropZone to manage any number of target elements is to configure the
 * DropZone with an implementation of {@link #getTargetFromEvent} which interrogates the passed
 * mouse event to see if it has taken place within an element, or class of elements. This is easily done
 * by using the event's {@link Ext.EventObject#getTarget getTarget} method to identify a node based on a
 * {@link Ext.DomQuery} selector.
 *
 * Once the DropZone has detected through calling getTargetFromEvent, that the mouse is over
 * a drop target, that target is passed as the first parameter to {@link #onNodeEnter}, {@link #onNodeOver},
 * {@link #onNodeOut}, {@link #onNodeDrop}. You may configure the instance of DropZone with implementations
 * of these methods to provide application-specific behaviour for these events to update both
 * application state, and UI state.
 *
 * For example to make a GridPanel a cooperating target with the example illustrated in
 * {@link Ext.dd.DragZone DragZone}, the following technique might be used:
 *
 *     myGridPanel.on('render', function() {
 *         myGridPanel.dropZone = new Ext.dd.DropZone(myGridPanel.getView().scroller, {
 *
 *             // If the mouse is over a grid row, return that node. This is
 *             // provided as the "target" parameter in all "onNodeXXXX" node event handling functions
 *             getTargetFromEvent: function(e) {
 *                 return e.getTarget(myGridPanel.getView().rowSelector);
 *             },
 *
 *             // On entry into a target node, highlight that node.
 *             onNodeEnter : function(target, dd, e, data){
 *                 Ext.fly(target).addCls('my-row-highlight-class');
 *             },
 *
 *             // On exit from a target node, unhighlight that node.
 *             onNodeOut : function(target, dd, e, data){
 *                 Ext.fly(target).removeCls('my-row-highlight-class');
 *             },
 *
 *             // While over a target node, return the default drop allowed class which
 *             // places a "tick" icon into the drag proxy.
 *             onNodeOver : function(target, dd, e, data){
 *                 return Ext.dd.DropZone.prototype.dropAllowed;
 *             },
 *
 *             // On node drop we can interrogate the target to find the underlying
 *             // application object that is the real target of the dragged data.
 *             // In this case, it is a Record in the GridPanel's Store.
 *             // We can use the data set up by the DragZone's getDragData method to read
 *             // any data we decided to attach in the DragZone's getDragData method.
 *             onNodeDrop : function(target, dd, e, data){
 *                 var rowIndex = myGridPanel.getView().findRowIndex(target);
 *                 var r = myGridPanel.getStore().getAt(rowIndex);
 *                 Ext.Msg.alert('Drop gesture', 'Dropped Record id ' + data.draggedRecord.id +
 *                     ' on Record id ' + r.id);
 *                 return true;
 *             }
 *         });
 *     }
 *
 * See the {@link Ext.dd.DragZone DragZone} documentation for details about building a DragZone which
 * cooperates with this DropZone.
 */
Ext.define('Ext.dd.DropZone', {
    extend: 'Ext.dd.DropTarget',
    requires: ['Ext.dd.Registry'],

    /**
     * Returns a custom data object associated with the DOM node that is the target of the event.  By default
     * this looks up the event target in the {@link Ext.dd.Registry}, although you can override this method to
     * provide your own custom lookup.
     * @param {Event} e The event
     * @return {Object} data The custom data
     */
    getTargetFromEvent : function(e){
        return Ext.dd.Registry.getTargetFromEvent(e);
    },

    /**
     * Called when the DropZone determines that a {@link Ext.dd.DragSource} has entered a drop node
     * that has either been registered or detected by a configured implementation of {@link #getTargetFromEvent}.
     * This method has no default implementation and should be overridden to provide
     * node-specific processing if necessary.
     * @param {Object} nodeData The custom data associated with the drop node (this is the same value returned from 
     * {@link #getTargetFromEvent} for this node)
     * @param {Ext.dd.DragSource} source The drag source that was dragged over this drop zone
     * @param {Event} e The event
     * @param {Object} data An object containing arbitrary data supplied by the drag source
     */
    onNodeEnter : function(n, dd, e, data){
        
    },

    /**
     * Called while the DropZone determines that a {@link Ext.dd.DragSource} is over a drop node
     * that has either been registered or detected by a configured implementation of {@link #getTargetFromEvent}.
     * The default implementation returns this.dropAllowed, so it should be
     * overridden to provide the proper feedback.
     * @param {Object} nodeData The custom data associated with the drop node (this is the same value returned from
     * {@link #getTargetFromEvent} for this node)
     * @param {Ext.dd.DragSource} source The drag source that was dragged over this drop zone
     * @param {Event} e The event
     * @param {Object} data An object containing arbitrary data supplied by the drag source
     * @return {String} status The CSS class that communicates the drop status back to the source so that the
     * underlying {@link Ext.dd.StatusProxy} can be updated
     * @template
     */
    onNodeOver : function(n, dd, e, data){
        return this.dropAllowed;
    },

    /**
     * Called when the DropZone determines that a {@link Ext.dd.DragSource} has been dragged out of
     * the drop node without dropping.  This method has no default implementation and should be overridden to provide
     * node-specific processing if necessary.
     * @param {Object} nodeData The custom data associated with the drop node (this is the same value returned from
     * {@link #getTargetFromEvent} for this node)
     * @param {Ext.dd.DragSource} source The drag source that was dragged over this drop zone
     * @param {Event} e The event
     * @param {Object} data An object containing arbitrary data supplied by the drag source
     * @template
     */
    onNodeOut : function(n, dd, e, data){
        
    },

    /**
     * Called when the DropZone determines that a {@link Ext.dd.DragSource} has been dropped onto
     * the drop node.  The default implementation returns false, so it should be overridden to provide the
     * appropriate processing of the drop event and return true so that the drag source's repair action does not run.
     * @param {Object} nodeData The custom data associated with the drop node (this is the same value returned from
     * {@link #getTargetFromEvent} for this node)
     * @param {Ext.dd.DragSource} source The drag source that was dragged over this drop zone
     * @param {Event} e The event
     * @param {Object} data An object containing arbitrary data supplied by the drag source
     * @return {Boolean} True if the drop was valid, else false
     * @template
     */
    onNodeDrop : function(n, dd, e, data){
        return false;
    },

    /**
     * Called while the DropZone determines that a {@link Ext.dd.DragSource} is being dragged over it,
     * but not over any of its registered drop nodes.  The default implementation returns this.dropNotAllowed, so
     * it should be overridden to provide the proper feedback if necessary.
     * @param {Ext.dd.DragSource} source The drag source that was dragged over this drop zone
     * @param {Event} e The event
     * @param {Object} data An object containing arbitrary data supplied by the drag source
     * @return {String} status The CSS class that communicates the drop status back to the source so that the
     * underlying {@link Ext.dd.StatusProxy} can be updated
     * @template
     */
    onContainerOver : function(dd, e, data){
        return this.dropNotAllowed;
    },

    /**
     * Called when the DropZone determines that a {@link Ext.dd.DragSource} has been dropped on it,
     * but not on any of its registered drop nodes.  The default implementation returns false, so it should be
     * overridden to provide the appropriate processing of the drop event if you need the drop zone itself to
     * be able to accept drops.  It should return true when valid so that the drag source's repair action does not run.
     * @param {Ext.dd.DragSource} source The drag source that was dragged over this drop zone
     * @param {Event} e The event
     * @param {Object} data An object containing arbitrary data supplied by the drag source
     * @return {Boolean} True if the drop was valid, else false
     * @template
     */
    onContainerDrop : function(dd, e, data){
        return false;
    },

    /**
     * The function a {@link Ext.dd.DragSource} calls once to notify this drop zone that the source is now over
     * the zone.  The default implementation returns this.dropNotAllowed and expects that only registered drop
     * nodes can process drag drop operations, so if you need the drop zone itself to be able to process drops
     * you should override this method and provide a custom implementation.
     * @param {Ext.dd.DragSource} source The drag source that was dragged over this drop zone
     * @param {Event} e The event
     * @param {Object} data An object containing arbitrary data supplied by the drag source
     * @return {String} status The CSS class that communicates the drop status back to the source so that the
     * underlying {@link Ext.dd.StatusProxy} can be updated
     * @template
     */
    notifyEnter : function(dd, e, data){
        return this.dropNotAllowed;
    },

    /**
     * The function a {@link Ext.dd.DragSource} calls continuously while it is being dragged over the drop zone.
     * This method will be called on every mouse movement while the drag source is over the drop zone.
     * It will call {@link #onNodeOver} while the drag source is over a registered node, and will also automatically
     * delegate to the appropriate node-specific methods as necessary when the drag source enters and exits
     * registered nodes ({@link #onNodeEnter}, {@link #onNodeOut}). If the drag source is not currently over a
     * registered node, it will call {@link #onContainerOver}.
     * @param {Ext.dd.DragSource} source The drag source that was dragged over this drop zone
     * @param {Event} e The event
     * @param {Object} data An object containing arbitrary data supplied by the drag source
     * @return {String} status The CSS class that communicates the drop status back to the source so that the
     * underlying {@link Ext.dd.StatusProxy} can be updated
     * @template
     */
    notifyOver : function(dd, e, data){
        var n = this.getTargetFromEvent(e);
        if(!n) { // not over valid drop target
            if(this.lastOverNode){
                this.onNodeOut(this.lastOverNode, dd, e, data);
                this.lastOverNode = null;
            }
            return this.onContainerOver(dd, e, data);
        }
        if(this.lastOverNode != n){
            if(this.lastOverNode){
                this.onNodeOut(this.lastOverNode, dd, e, data);
            }
            this.onNodeEnter(n, dd, e, data);
            this.lastOverNode = n;
        }
        return this.onNodeOver(n, dd, e, data);
    },

    /**
     * The function a {@link Ext.dd.DragSource} calls once to notify this drop zone that the source has been dragged
     * out of the zone without dropping.  If the drag source is currently over a registered node, the notification
     * will be delegated to {@link #onNodeOut} for node-specific handling, otherwise it will be ignored.
     * @param {Ext.dd.DragSource} source The drag source that was dragged over this drop target
     * @param {Event} e The event
     * @param {Object} data An object containing arbitrary data supplied by the drag zone
     * @template
     */
    notifyOut : function(dd, e, data){
        if(this.lastOverNode){
            this.onNodeOut(this.lastOverNode, dd, e, data);
            this.lastOverNode = null;
        }
    },

    /**
     * The function a {@link Ext.dd.DragSource} calls once to notify this drop zone that the dragged item has
     * been dropped on it.  The drag zone will look up the target node based on the event passed in, and if there
     * is a node registered for that event, it will delegate to {@link #onNodeDrop} for node-specific handling,
     * otherwise it will call {@link #onContainerDrop}.
     * @param {Ext.dd.DragSource} source The drag source that was dragged over this drop zone
     * @param {Event} e The event
     * @param {Object} data An object containing arbitrary data supplied by the drag source
     * @return {Boolean} False if the drop was invalid.
     * @template
     */
    notifyDrop : function(dd, e, data){
        var me = this,
            n = me.getTargetFromEvent(e),
            result = n ?
                me.onNodeDrop(n, dd, e, data) :
                me.onContainerDrop(dd, e, data);

        // Exit the overNode upon drop.
        // Must do this after dropping because exiting a node may perform actions which invalidate a drop.
        if (me.lastOverNode) {
            me.onNodeOut(me.lastOverNode, dd, e, data);
            me.lastOverNode = null;
        }
        return result;
    },

    // private
    triggerCacheRefresh : function() {
        Ext.dd.DDM.refreshCache(this.groups);
    }
});