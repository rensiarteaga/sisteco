/*
 * Ext JS Library 1.0.1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://www.extjs.com/license
 */


Ext.namespace('Ext.proc_depreciacionCombo');


Ext.proc_depreciacionCombo.meses = [
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
    
    Ext.proc_depreciacionCombo.periodico = [
        ['Si','Determinar'],
        ['No','Todos']
        
    ];
    
    Ext.proc_depreciacionCombo.anos = new Array()
    
    for(var i=1950; i <= 2050; i ++)
    {
       Ext.proc_depreciacionCombo.anos.push([i]);     
    }
    
    Ext.proc_depreciacionCombo.tipo = [
        ['pri', 'Actual'],
        ['sec', 'Histórico']
    ];
    
  