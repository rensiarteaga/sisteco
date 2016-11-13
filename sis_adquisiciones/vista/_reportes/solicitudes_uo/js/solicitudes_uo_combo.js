/*
 * Ext JS Library 1.0.1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://www.extjs.com/license
 */


Ext.namespace('Ext.proc_existenciasCombo');


Ext.proc_existenciasCombo.meses = [

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
//Ext.proc_tipo_reporteCombo.tipo_reporte
Ext.proc_existenciasCombo.tipo_reporte = [['Bien','Bienes'],['Servicio','Servicios']];
Ext.proc_existenciasCombo.estado = [['Todos','Todos'],['Pendientes','Pendiente'],['Aprobados','Aprobados'],['Finalizados','Finalizados']];
//Ext.proc_existenciasCombo.solic = [['contratista','Contratista'],['empleado','Empleado']];
    
    Ext.proc_existenciasCombo.anos = new Array()
    
    for(var i=1950; i <= 2050; i ++)
    {
       Ext.proc_existenciasCombo.anos.push([i]);     
    }
    
  