/*
 * Ext JS Library 1.0.1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 *
 * http://www.extjs.com/license
 */


Ext.namespace('Ext.estado_rendicion_combo');   

Ext.estado_rendicion_combo.tipo_solicitud = [
        
        ['Todos', 'TODOS'],
   		['rendicion_viatico', 'Rendición de Solicitudes de Viáticos'],
   		['solicitud_avance', 'Rendición de Fondos en Avance'],
   		['rendicion_caja', 'Rendicion de Solicitud de Efectivo']
];

Ext.estado_rendicion_combo.estado_rendicion= [       
	
		//["'en_rendicion,conta_rendicion,fin_rendicion'", 'Todos'],
		
		//["Todos", 'Todos'],
		//['"Todos"', 'Todos'],
		//["'Todos'", 'Todos'],
        /*["'en_rendicion'", 'En Rendición'],
        ["'conta_rendicion'", 'Conta Rendición'],
        ["'fin_rendicion'", 'Fin Rendición'] */  
            
        ['Todos', 'TODOS'],
        ['en_rendicion', 'Rendición - En Rendición'],
        ['conta_rendicion', 'Rendición - Conta Rendición'],
        ['fin_rendicion', 'Rendición - Fin Rendición'], 
        
        //rendiciones de caja
        ['borrador', 'Solicitud - Borrador'],
        //['conta_rendicion', 'Conta Rendición'],
       
        ['conta_pago', 'Solicitud - Conta Pago'],
        ['pago_cheque', 'Solicitud - Pago Cheque'],
		['rendicion_validado', 'Solicitud - Rendición Validado'],
        ['finalizado', 'Solicitud - Finalizado']   
];        

Ext.estado_rendicion_combo.tipo_reporte = [
        
		['Por Responsable Registro', 'Por Responsable Registro'],
		['Por Funcionario Solicitante', 'Por Funcionario Solicitante'],
		['Por Unidad Organizacional', 'Por Unidad Organizacional'],
		['Por Departamento Contable', 'Por Departamento Contable']       
];
