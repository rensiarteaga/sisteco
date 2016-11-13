/*
 * Ext JS Library 1.0.1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://www.extjs.com/license
 */


Ext.namespace('Ext.proc_cuadroCombo');
Ext.proc_cuadroCombo.meses = [
        ['01', 'Enero'],
        ['02', 'Febrero'],
        ['03', 'Marzo'],
        ['04', 'Abril'],
        ['05', 'Mayo'],
        ['06', 'Junio'],
        ['07', 'Julio'],
        ['08', 'Agosto'],
        ['09', 'Septiembre'],
        ['10', 'Octubre'],
        ['11', 'Noviembre'],
        ['12', 'Diciembre']
    ];
 
    
    Ext.proc_cuadroCombo.anos = new Array()
    for(var i=2000; i <= 2050; i ++)
    {      Ext.proc_cuadroCombo.anos.push([i]);     
    }
    
  
Ext.proc_cuadroCombo.tipo = [
        ['pri', 'Actual'],
        ['sec', 'Histórico']
    ];
    
    Ext.proc_cuadroCombo.tipo_rep = [['det','Detalle'],['tot','Totales']];
    
    Ext.proc_cuadroCombo.tipo_data = [['men','Mensual'],['acum','Acumulado']];