/*
 * Ext JS Library 1.0.1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 *
 * http://www.extjs.com/license
 */


Ext.namespace('Ext.partida_traspaso_combo');



Ext.partida_traspaso_combo.estado= [
       
        ['1', 'Verificación'],
        ['2', 'Concluido'], 
        ['3', 'Autorización'],
        ['4', 'Aprobado'],
        ['5', 'Autorización - Origen'],
        ['6', 'Autorización - Destino'],
        ['7', 'Rechazado']        
        ];
        

Ext.partida_traspaso_combo.tipo_pres= [
       
        ['1', 'Recurso'],
        ['2', 'Gasto'],
        ['3', 'Inversión']
        /*['4', 'PNO - Recurso'],
        ['5', 'PNO - Gasto'],
        ['6', 'PNO - Inversión']*/
        
        ];
        
Ext.partida_traspaso_combo.tipo_pres_sin_inv= [
       
        ['1', 'Recurso'],
        ['2', 'Gasto']        
        
        ];
        
Ext.partida_traspaso_combo.tipo_traspaso= [
       
        ['1', 'Traspaso'],
        ['2', 'Reformulación'],
        ['3', 'Incremento']
        ];
 