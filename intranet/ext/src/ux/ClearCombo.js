Ext.define('Ext.ux.ClearCombo', {
    extend: 'Ext.form.field.ComboBox',
    alias: 'widget.clearcombo',

    trigger2Cls: 'x-form-clear-trigger',

    initComponent: function () {
        var me = this;


        me.addEvents(
            /**
            * @event beforeclear
            *
            * @param {FilterCombo} FilterCombo The filtercombo that triggered the event
            */
            'beforeclear',
            /**
            * @event beforeclear
            *
            * @param {FilterCombo} FilterCombo The filtercombo that triggered the event
            */
            'clear'
        );

        me.callParent(arguments);

        me.on('specialkey', this.onSpecialKeyDown, me);
        me.on('select', function (me, rec) {
            me.onShowClearTrigger(true); 
        }, me);
        me.on('afterrender', function () { me.onShowClearTrigger(false); }, me);
    },

    /**
    * @private onSpecialKeyDown
    * eventhandler for special keys
    */
    onSpecialKeyDown: function (obj, e, opt) {
        if ( e.getKey() == e.ESC )
        {
            this.clear();
        }
    },

    onShowClearTrigger: function (show) {
        var me = this;

        if (show) {
            me.triggerEl.each(function (el, c, i) {
                if (i === 1) {
                    el.setWidth(el.originWidth, false);
                    el.setVisible(true);
                    me.active = true;
                }
            });
        } else {
            me.triggerEl.each(function (el, c, i) {
                if (i === 1) {
                    el.originWidth = el.getWidth();
                    el.setWidth(0, false);
                    el.setVisible(false);
                    me.active = false;
                }
            });
        }
        // ToDo -> Version specific methods
        if (Ext.lastRegisteredVersion.shortVersion > 407) {
            me.updateLayout();
        } else {
            me.updateEditState();
        }
    },

    /**
    * @override onTrigger2Click
    * eventhandler
    */
    onTrigger2Click: function (args) {
        this.clear();
    },

    /**
    * @private clear
    * clears the current search
    */
    clear: function () {
        var me = this;
        me.fireEvent('beforeclear', me);
        me.clearValue();
        me.onShowClearTrigger(false);
        me.fireEvent('clear', me);
    }
});