/*
 * Ext JS Library 1.0.1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://www.extjs.com/license
 */
Ext.namespace('Ext.parametro_adquisicion_combo');
Ext.parametro_adquisicion_combo.estado = [['activo','activo'],['congelado','congelado'],['cerrado','cerrado']];


//Ext.namespace('Ext.parametro_adquisicion_gestion');
Ext.parametro_adquisicion_combo.gestion=new Array();
  for(var i=1990;i<=2050;i ++){
      Ext.parametro_adquisicion_combo.gestion.push([i])
    }
    
   Ext.parametro_adquisicion_combo.periodo=new Array();
  for(var j=1;j<=12;j ++){
      Ext.parametro_adquisicion_combo.periodo.push([j])
    }