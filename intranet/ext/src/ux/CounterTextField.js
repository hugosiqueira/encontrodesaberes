Ext.define('Ext.ux.CounterTextField', {
    extend: 'Ext.util.Observable',
    alias: 'plugin.counter',

    constructor: function (config)
    {
        Ext.apply(this, config || {});
        this.callParent(arguments);
    },

    init: function (field)
    {
        field.on({
            scope: field,
            keyup: this.updateCounter,
            focus: this.updateCounter
        });
        if (!field.rendered)
            field.on('afterrender', this.handleAfterRender, field);
        else
            this.handleAfterRender(field);
    },

    handleAfterRender: function(field)
    {
        field.counterEl = field.bodyEl.createChild({
            tag: 'span',
            // style: 'width: 10%;padding-left:5px;top:4px;position:absolute;',
            // style: 'position:absolute;',
            html: 'Limite de caracteres: '+field.maxLength
        });
        setTimeout(function() {field.inputEl.setStyle(
			{	display:'inline',
				width:'100%'
			}
		);
		});
        field.enableKeyEvents = true;
    },

    updateCounter: function(textField)
    {
        textField.counterEl.update('Limite de caracteres: ' + 
            (textField.maxLength - textField.getValue().length));
    }
});