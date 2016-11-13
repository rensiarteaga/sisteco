Ext.namespace('Ext.detalle_ingresos_combo');


Ext.detalle_ingresos_combo.estado= [

        ['Borrador', 'Borrador'],
        ['Pendiente', 'Pendiente'],
        ['Aprobado', 'Aprobado'],
        ['Rechazado', 'Rechazado'],
        ['Físico', 'Físico'],
        ['Valorado', 'Valorado'],
        ['Finalizado', 'Finalizado'],
        ['Anulado', 'Anulado'],
        
    ];
    
    Ext.detalle_ingresos_combo.desde = new Array()
    
    for(var i=1950; i <= 2050; i ++)
    {
       Ext.detalle_ingresos_combo.desde.push([i]);     
    }
    
  
    Ext.detalle_ingresos_combo.hasta = new Array()
    
    for(var i=1950; i <= 2050; i ++)
    {
       Ext.detalle_ingresos_combo.hasta.push([i]);     
    }