/*
 * Ext JS Library 1.0.1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://www.extjs.com/license
 */


Ext.namespace('Ext.proc_depreciacionCombo');


Ext.proc_depreciacionCombo.meses = [
        ['1', 'Enero'],
        ['2', 'Febrero'],
        ['3', 'Marzo'],
        ['4', 'Abril'],
        ['5', 'Mayo'],
        ['6', 'Junio'],
        ['7', 'Julio'],
        ['8', 'Agosto'],
        ['9', 'Septiembre'],
        ['10', 'Octubre'],
        ['11', 'Noviembre'],
        ['12', 'Diciembre']
    ];
    
    Ext.proc_depreciacionCombo.anos = new Array()
    
    //for(var i=1950; i <= 2050; i ++)
    for(var i=2000; i <= 2050; i ++)
    {
       Ext.proc_depreciacionCombo.anos.push([i]);     
    }
    
  