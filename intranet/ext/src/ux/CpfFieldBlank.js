Ext.define('Ext.ux.CpfFieldBlank', {
   extend: 'Ext.form.field.Text',
   alias: ['widget.cpffieldblank'],
   allowBlank: true, 
   autocomplete: "off",
   soNumero: false,
   maxLength: (this.soNumero) ? 11 : 14,
 
   initComponent: function(){
      var me = this;
 
      Ext.apply(Ext.form.VTypes, {
         cpf: function(b, a) {
            return me.validacpf(b);
         },
         cpfText: "CPF inválido!"
      });
 
      Ext.apply(me, { vtype: 'cpf' });
      me.callParent();
   },
   
   validacpf: function(e) {
      if (e == "" || e == "___.___.___-__")
         return true;
      var b;
      s = e.replace(/\D/g, "");
      if (parseInt(s, 10) == 0) {
         return false;
      }
 
      var iguais = true;
      for (i = 0; i < s.length - 1; i++){
         if (s.charAt(i) != s.charAt(i + 1)){
            iguais = false;
         }
      }
 
      if (iguais)
         return false;
 
      var h = s.substr(0, 9);
      var a = s.substr(9, 2);
      var d = 0;
      for (b = 0; b < 9; b++) {
         d += h.charAt(b) * (10 - b);
      }
      if (d == 0) {
         return false;
      }
      d = 11 - (d % 11);
      if (d > 9) {
         d = 0;
      }
      if (a.charAt(0) != d) {
         return false;
      }
      d *= 2;
      for (b = 0; b < 9; b++) {
         d += h.charAt(b) * (11 - b);
      }
      d = 11 - (d % 11);
      if (d > 9) {
         d = 0;
      }
      if (a.charAt(1) != d) {
         return false;
      }
      return true;
   }
});