/*
 * Ext JS Library 1.0.1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 *
 * http://www.extjs.com/license
 */


Ext.namespace('Ext.estado_solicitud_combo');   

Ext.estado_solicitud_combo.tipo_solicitud = [
        
        ['Todos', 'TODOS'],
   		['solicitud_viatico', 'Solicitud de Viaticos'],
   		['solicitud_avance', 'Fondos en Avance'],
   		['solicitud_efectivo', 'Solicitud de Efectivo']
];

Ext.estado_solicitud_combo.estado_solicitud= [       
	            
        ['Todos', 'Todos'],
        ['anulado', 'Anulado'],
        ['borrador', 'Borrador'],
        ['pagado', 'Pagado'],
        ['caja_fin', 'Caja Fin'],         
		['solicitud_pago', 'Solicitud Pago'],
        ['cheque_fin', 'Cheque Fin'],
        ['comprometido', 'Comprometido'],
        ['en_finaliz', 'En Finalizacion'],
        ['conta_pago', 'Conta Pago'],
        ['pago_cheque', 'Pago Cheque'],
        ['pago_efectivo', 'Pago Efectivo'],
        ['finalizado', 'Finalizado']   
];      


Ext.estado_solicitud_combo.tipo_reporte = [
        
		['Por Responsable Registro', 'Por Responsable Registro'],
		['Por Funcionario Solicitante', 'Por Funcionario Solicitante'],
		['Por Unidad Organizacional', 'Por Unidad Organizacional'],
		['Por Departamento Contable', 'Por Departamento Contable']       
];