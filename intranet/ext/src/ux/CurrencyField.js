/**
 * ExtJS CurrencyField
 * Updated version of http://develtech.wordpress.com/2011/03/06/number-field-with-currency-symbol-thousand-separator-with-international-support/#respond
 * 
 * Settings configurable via default Ext.util.Format properties:
 * Ext.util.Format.currencyAtEnd      = false;
 * Ext.util.Format.currencyPrecision  = 2;
 * Ext.util.Format.currencySign       = '$ ';
 * Ext.util.Format.thousandSeparator  = ',';
 * Ext.util.Format.decimalSeparator   = '.';
 */

Ext.define('Ext.ux.CurrencyField', {
  extend: 'Ext.form.field.Text',
  alias: ['widget.currencyfield','widget.currency'],
  maskRe: /[0-9 .,-]/,
  fieldStyle: 'text-align: right;',

  onFocus: function(){
    this.setRawValue(this.removeFormat(this.getRawValue()));
  },
  
  onBlur: function(){
    if (this.hasFormat()) {
      this.setRawValue(Ext.util.Format.currency(this.getRawValue()/100));
    }
  },
  
  setValue: function(v){
    this.setRawValue(Ext.util.Format.currency(v/100));
  },

  getValue: function() {
      var me = this,
          val = me.rawToValue(me.processRawValue(me.getRawValue()));
      me.value = val;
      return val.replace(/\D/g, '');;
  },
  
  removeFormat: function(v){
    if (Ext.isEmpty(v) || !this.hasFormat())  {
      return v;
    } else {
      v = v.replace(Ext.util.Format.currencySign, '');
      v = !Ext.isEmpty(Ext.util.Format.thousandSeparator) ? v.replace(new RegExp('[' + Ext.util.Format.thousandSeparator + ']', 'g'), '') : v;
      v = Ext.isEmpty(Ext.util.Format.decimalSeparator) ? v.replace(new RegExp('[' + Ext.util.Format.decimalSeparator + ']', 'g'), '') : v;
      return v;
    }
  },
  
  hasFormat: function(){
    return Ext.util.Format.thousandSeparator != '.' || !Ext.isEmpty(Ext.util.Format.currencySign) || Ext.util.Format.currencyPrecision > 0;  
  },
  
  processRawValue: function(val) {
    return this.removeFormat(val);
  }
});