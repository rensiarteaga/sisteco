--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_al_valorar_ingresos (
  al_id_ingreso integer,
  al_id_almacen_logico integer,
  al_id_parametro_almacen integer,
  al_correlativo_ing varchar,
  al_codigo_motivo_ingreso varchar
)
RETURNS varchar [] AS
$body$
DECLARE
   v_retorno			 		varchar[]; 
   g_registro					record;
   v_reg_ingreso_det			record;
   g_aux_cotos_det				numeric; 
   g_correlativo_ing			varchar;
   v_msg_ret		 	    	varchar[]; 
   
    g_cant 						numeric;
    g_costo_unit 				numeric;
    g_id_kardex_logico 			integer;
    g_cant_tot					numeric;
    g_nuevo_costo_tot			numeric;
    g_costo_total				numeric;
    g_nuevo_costo_unit			numeric;
    g_id_transferencia			integer;
   
  
                                  
                                  
BEGIN
 
	       -- si es un ingreso por devolucion lo costea
           IF al_codigo_motivo_ingreso = 'DEV' THEN                                            
              v_msg_ret = almin.f_al_valorar_devoluciones(al_id_ingreso, al_id_almacen_logico, 'no');
              if v_msg_ret[1] = 'fallo' then
                 return v_msg_ret;
              end if;                                            
           end if;
              
                                    
          -- si es un ingeso por transferencia lo costea
          IF al_codigo_motivo_ingreso = 'TAA' THEN 
              v_msg_ret =  almin.f_al_valorar_transferencia(al_id_ingreso, al_id_almacen_logico, 'no');
              if v_msg_ret[1] = 'fallo' then
                 return v_msg_ret;
              end if;
          END IF;
          /*
          IF al_id_ingreso = 59 THEN
             raise exception 'pasa...';
          END IF; */
        
              
                               
               
          --  FOR listar el detalle de item del ingreso
          FOR v_reg_ingreso_det in (
                                      select *
                                      from almin.tal_ingreso_detalle id
                                      where id.id_ingreso = al_id_ingreso 
                                  ) LOOP     
                                             
                -- si algun ingreso no tiene costos forzar salida y mostrar referencia del ingreso sin valorar al usuario
                if v_reg_ingreso_det.costo_unitario = 0 then
                   v_retorno[0] = 'fallo';
                   v_retorno[1] = format('El ingreso %s tiene item sin valorar',  al_correlativo_ing::varchar);
                   return  v_retorno;
                end if;
                                             
                  --  valorar el kardex logico item por item 
                                                
                  g_cant = 0; 
                  g_costo_unit = 0;
                  g_id_kardex_logico = NULL; 
                  
                                             
                                               
                  SELECT 
                      cantidad, costo_unitario, id_kardex_logico
                  INTO 
                      g_cant, g_costo_unit, g_id_kardex_logico
                  FROM almin.tal_kardex_logico_aux k
                  WHERE id_item = v_reg_ingreso_det.id_item
                  AND estado_item = v_reg_ingreso_det.estado_item
                  AND id_almacen_logico = al_id_almacen_logico
                  AND id_parametro_almacen = al_id_parametro_almacen;
                  
               

                  IF g_id_kardex_logico is not  null THEN                 
                        --RAC 28/11/2016 ,cambiar el calculo para que se haga por promedio poderado y no por promedio simple
                                                                        
                        g_cant_tot := g_cant + v_reg_ingreso_det.cantidad; 
                        g_nuevo_costo_tot := (g_cant * g_costo_unit) + (v_reg_ingreso_det.cantidad * v_reg_ingreso_det.costo_unitario);
                        g_nuevo_costo_unit :=   g_nuevo_costo_tot /g_cant_tot;
                                                                       
                                                     
                        UPDATE almin.tal_kardex_logico_aux SET
                          cantidad = g_cant_tot,
                          costo_unitario = COALESCE(g_nuevo_costo_unit,0),
                          costo_total = COALESCE(g_nuevo_costo_tot,0)
                        WHERE id_kardex_logico = g_id_kardex_logico;
                         raise notice '<<<<<< *****  actuliza kardex  item %, cu =%, , ct=%, cantidad = %',v_reg_ingreso_det.id_item , g_nuevo_costo_unit, g_nuevo_costo_tot,g_cant_tot;
                        
                  ELSE
                     --cuando el item es el primero del almacen el costo se repite
                       INSERT INTO almin.tal_kardex_logico_aux(
                           estado_item             ,stock_minimo           ,cantidad             ,costo_unitario,
                           costo_total             ,reservado              ,id_item,
                           id_almacen_logico       ,id_parametro_almacen
                       ) VALUES(
                           v_reg_ingreso_det.estado_item ,   10                    , v_reg_ingreso_det.cantidad ,COALESCE(v_reg_ingreso_det.costo_unitario,0),
                           v_reg_ingreso_det.costo,           0                   ,  v_reg_ingreso_det.id_item,
                           al_id_almacen_logico, 			al_id_parametro_almacen
                       );
                       raise notice '<<<<<<   crea kardex  item %, cu =%, , ct=%, cantidad = %',v_reg_ingreso_det.id_item , v_reg_ingreso_det.costo_unitario, v_reg_ingreso_det.costo_unitario,v_reg_ingreso_det.cantidad;
                                                
                  END IF;
                                                    
                                                
           END LOOP;

  
   v_retorno[1] = 'exito';

   return v_retorno;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;