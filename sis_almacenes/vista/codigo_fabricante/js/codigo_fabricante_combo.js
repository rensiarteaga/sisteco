/*
 * Ext JS Library 1.0.1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 *
 * http://www.extjs.com/license
 */


Ext.namespace('Ext.codigo_fabricanteCombo');
Ext.codigo_fabricanteCombo.estado = [
		['activo', 'activo'],        
        ['inactivo', 'inactivo'],
        ['eliminado', 'eliminado']
        
    ];
 Ext.codigo_fabricanteCombo.anos = new Array()
    
    for(var i=1950; i <= 2050; i ++)
    {
       Ext.codigo_fabricanteCombo.anos.push([i]);     
    }