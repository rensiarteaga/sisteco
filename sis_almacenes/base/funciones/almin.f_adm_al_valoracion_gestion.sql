--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_adm_al_valoracion_gestion (
  al_id_parametro_almacen_logico integer
)
RETURNS varchar [] AS
$body$
/**************************************************************************
 SISTEMA ENDESIS -  SISTEMA DE ALMACENES (ALMIN)
***************************************************************************
 SCRITP:         almin.f_adm_al_valoracion_gestion
 DESCRIPCION:    Función que realiza la valoración de las salidas de toda una gestión
 				 de un almacén lógico específico. Guarda la valoración en la tabla
                 almin.tal_salida_detalle
 AUTOR:          Rensi Arteaga Copari
 FECHA:          19/12/2016
 COMENTARIOS:    
***************************************************************************

***************************************************************************/

-----------------------------------------
-- CUERPO DE LA FUNCIÓN --
-----------------------------------------

DECLARE
    
      v_registros					record;
      v_reg_salida 					record;
      v_reg_ingreso					record;
      v_reg_ingreso_det				record;
      v_reg_salida_det				record;
      v_registros_aux				record;
      v_registros_kl				record;
      v_id_ingeso_valorado_aux		integer;
      v_msg_ret						varchar[];
      v_retorno						varchar[];
      g_cant_tot					numeric;
      g_nuevo_costo_tot				numeric;
      g_cant						numeric;
      g_nuevo_costo_unit			numeric;
      g_costo_total_kardex			numeric;
      g_costo_unit					numeric;
      g_id_kardex_logico			integer;
      v_aux_sal_modificada			boolean;
      v_fecha_exacta_utm_ingreso_val		timestamp;
      g_id_transferencia			integer;
       
BEGIN

    --   0) boorar todos los datos del kardex auxiliar 
         
           TRUNCATE TABLE almin.tal_kardex_logico_aux;
    --   1) recuperar datos del almacen logico y gestion
    
         select 
            pal.id_almacen_logico,
            pal.id_parametro_almacen,
            pal.estado,
            pal.costeo_pendiente
         into
           v_registros
         from almin.tal_parametro_almacen_logico pal
         where pal.id_parametro_almacen_logico = al_id_parametro_almacen_logico;
    
    
    --   2) validar que el almacen no este cerrado

        if v_registros.estado = 'cerrado' then
             raise exception 'el almacen se encuentra cerrado';
        end if;
        
        if v_registros.costeo_pendiente = 'no' then
             raise exception 'el almacen no tiene costeos pendientes';
        end if;
        
        v_id_ingeso_valorado_aux = 0;
        v_fecha_exacta_utm_ingreso_val = NULL;
    
    --   3) FOR lista toda las salidas de la gestion para el almacen logico correspondiente ordenadas por fecha
            FOR  v_reg_salida in (   
									select
                                       s.*,
                                       ms.codigo as codigo_motivo_salida 
                                    from almin.tal_salida s
                                     INNER JOIN almin.tal_motivo_salida_cuenta msc ON msc.id_motivo_salida_cuenta = s.id_motivo_salida_cuenta
           							 INNER JOIN almin.tal_motivo_salida ms ON ms.id_motivo_salida = msc.id_motivo_salida
                                    where 	 s.id_parametro_almacen_logico = al_id_parametro_almacen_logico AND s.estado_salida = 'Finalizado'
                                    order by s.fecha_finalizado_cancelado , s.fecha_finalizado_exacta 
                                  )  LOOP   
                            
                              raise notice 'primer ciclo salida %',v_reg_salida.id_salida;
                     ---------------------------------------------------------------------------------------------------------
                     --3.1 FOR listar todos los ingresos previos (hora exacta) con el id mayor al ultimo ingreso valorado
                     -------------------------------------------------------------------------------------------------------
                              FOR v_reg_ingreso in ( 
                                                   select
                                                     i.*,
                                                     mi.codigo as codigo_motivo_ingreso 
                                                  from almin.tal_ingreso i
                                                   INNER JOIN almin.tal_motivo_ingreso_cuenta mic ON mic.id_motivo_ingreso_cuenta = i.id_motivo_ingreso_cuenta
                                                   INNER JOIN almin.tal_motivo_ingreso mi ON mi.id_motivo_ingreso = mic.id_motivo_ingreso
                                                  where 	 i.id_parametro_almacen_logico = al_id_parametro_almacen_logico AND i.estado_ingreso = 'Finalizado'
                                                          and  i.fecha_finalizado_exacta <= v_reg_salida.fecha_finalizado_exacta
                                                          and  
																  case when v_fecha_exacta_utm_ingreso_val is not null then
                                                                		  i.fecha_finalizado_exacta > v_fecha_exacta_utm_ingreso_val
                                                                  else 
                                                                     0=0 
                                                                  end
                                                  order by  i.fecha_finalizado_exacta asc
                           
                           						)LOOP
                     
                           
                                       v_msg_ret =  almin.f_al_valorar_ingresos(v_reg_ingreso.id_ingreso, v_reg_ingreso.id_almacen_logico, v_reg_ingreso.id_parametro_almacen, v_reg_ingreso.correlativo_ing, v_reg_ingreso.codigo_motivo_ingreso);
                                       
                                       if v_msg_ret[1] = 'fallo' then
                                         return v_msg_ret;
                                       end if; 
                                       
                                       -- almacena el ingreso como ulitmo ingreso valorado (id_ingeso_valorado_aux)
                                       v_fecha_exacta_utm_ingreso_val = v_reg_ingreso.fecha_finalizado_exacta;
                             END LOOP;
                             
                          
                            
                     -- 3.2) iniciar variable de  salida modificada en false  (v_aux_sal_modificada)
                     
                           v_aux_sal_modificada = false;
                     ------------------------------------------------
                     -- 3.3)  FOR listar los item de la salida 
                     -------------------------------------------------
                           FOR  v_reg_salida_det in (
                              							select *
                                                        from almin.tal_salida_detalle sd
                                                        where sd.id_salida = v_reg_salida.id_salida	
                             							)  LOOP
                                 
                                  --  valorar la salida y actualizar kardex logico 
                                   g_cant = 0;
                                   g_costo_unit = 0; 
                                   g_id_kardex_logico = NULL;
                                   g_costo_total_kardex = 0;
                                  
                                  SELECT 
                                     cantidad, costo_unitario, id_kardex_logico, k.costo_total
                                  into
                                      g_cant, g_costo_unit, g_id_kardex_logico, g_costo_total_kardex
                                  FROM almin.tal_kardex_logico_aux k 
                                  WHERE id_item = v_reg_salida_det.id_item
                                  AND estado_item = v_reg_salida_det.estado_item
                                  AND id_almacen_logico = v_reg_salida.id_almacen_logico
                                  AND id_parametro_almacen = v_reg_salida.id_parametro_almacen;
                                  
                                  UPDATE almin.tal_salida_detalle  SET                                   
                                    costo_unitario = g_costo_unit,
                                    costo = g_costo_unit * v_reg_salida_det.cant_entregada
                                  WHERE id_salida_detalle= v_reg_salida_det.id_salida_detalle;
                                  
                                  raise notice '******>>> almacena costo de la salida %, item %,   cu=% , ct= %',   v_reg_salida.id_salida,v_reg_salida_det.id_salida_detalle,g_costo_unit,g_costo_unit * v_reg_salida_det.cant_entregada;
                            
                                  
                                  
                                  g_cant_tot := g_cant - ROUND(coalesce(v_reg_salida_det.cant_entregada,0),2); 
                                  g_nuevo_costo_tot = g_costo_total_kardex - (g_costo_unit * v_reg_salida_det.cant_entregada);
                                  
                                  IF g_cant_tot != 0 THEN
                                      g_nuevo_costo_unit =   ROUND(coalesce(g_nuevo_costo_tot / g_cant_tot,0),2);       
                                  ELSE
                                      g_nuevo_costo_unit = 0;
                                  END IF;                          
                                
                                  UPDATE almin.tal_kardex_logico_aux SET
                                      cantidad = ROUND(g_cant_tot,2),
                                      costo_unitario = ROUND(COALESCE(g_nuevo_costo_unit,0),2),
                                      costo_total = ROUND(COALESCE(g_nuevo_costo_tot,0),2)
                                  WHERE id_kardex_logico = g_id_kardex_logico;
                                  
                                  ------------------------------------------------
                                  --  Si es transferencia ajustamos los costos .. 
                                  --  revalorizar la transferencia detalle
                                  -----------------------------------------------
                                  
                                  IF v_reg_salida.codigo_motivo_salida = 'TRM' THEN                                     
                                       UPDATE  almin.tal_transferencia_det set
                                         costo_unitario = g_costo_unit,
                                         costo = g_costo_unit*cantidad
                                       WHERE id_transferencia = g_id_transferencia 
                                              and id_item = v_reg_salida_det.id_item
                                              and estado_item = v_reg_salida_det.estado_item;    
                                  
                                  END IF;                                               
                                 
                                  
                                  --  si los valores cambiaron marcar la bandera   (v_aux_sal_modificada)
                                  IF v_reg_salida_det.costo_unitario !=   ROUND(COALESCE(g_nuevo_costo_unit,0),2)  THEN
                                       v_aux_sal_modificada = true;
                                  END IF;
                                  
                                  raise notice '>>> almacena Kardex aux  item = %,   cu=%, ct = %, CANTIDAD = %',v_reg_salida_det.id_item,ROUND(COALESCE(g_nuevo_costo_unit,0),2), ROUND(COALESCE(g_nuevo_costo_tot,0),2),g_cant_tot;
                            
                            END LOOP;
                     
                     --3.4) si es una salida  por transferencia y los valores cambiaron (v_aux_sal_modificada)  
                          IF v_reg_salida.codigo_motivo_salida = 'TRM' THEN                        
                             
                              --  marcar el almacen destino para revalorizacion solo si los valores de algun costo fueron modificados v_aux_sal_modificada = true)
                             
                                 IF v_aux_sal_modificada THEN 
                                 
                                       --recupera el almcen del ingreso 
                                            select 
                                                  pal.estado ,
                                                  pal.id_parametro_almacen_logico
                                              INTO
                                                 v_registros_aux
                                            from almin.tal_transferencia t
                                            inner join almin.tal_ingreso i on i.id_ingreso = t.id_ingreso
                                            inner join almin.tal_parametro_almacen_logico pal on pal.id_parametro_almacen_logico = i.id_parametro_almacen_logico
                                            where t.id_salida = v_reg_salida.id_salida;
                                       
                                            --si esta cerrado lanzar un error
                                            if v_registros_aux.estado = 'cerrado' then
                                                raise exception 'existen transferencias finalizas y cerradas en el almacen destino, no puede re-costear la salida %' , v_reg_salida.correlativo_sal;
                                            else 
                                               --marcar el parametro almacen logico para obligar a revalorar antes de cerrar gestion  
                                               UPDATE almin.tal_parametro_almacen_logico  set
                                                        costeo_pendiente = 'si'
                                               WHERE id_parametro_almacen_logico =  v_registros_aux.id_parametro_almacen_logico;
                                            
                                            end if;
                                 
                                     
                                 
                                 END IF;
                             
                     
                          END IF;
                    
           END LOOP;
           
           --  raise exception '----llega----';
     ----------------------------------------------------------------------------------     
     --5)  FOR revalorar kardex para todos los ingresos superiores a la ultima salida  
     --------------------------------------------------------------------------------------
     
          FOR v_reg_ingreso in ( 
                                 select
                                   i.*,
                                   mi.codigo as codigo_motivo_ingreso 
                                from almin.tal_ingreso i
                                 INNER JOIN almin.tal_motivo_ingreso_cuenta mic ON mic.id_motivo_ingreso_cuenta = i.id_motivo_ingreso_cuenta
                                 INNER JOIN almin.tal_motivo_ingreso mi ON mi.id_motivo_ingreso = mic.id_motivo_ingreso
                                where 	 i.id_parametro_almacen_logico = al_id_parametro_almacen_logico AND i.estado_ingreso = 'Finalizado'
                                        and  i.fecha_finalizado_exacta >v_reg_salida.fecha_finalizado_exacta
                                order by  i.fecha_finalizado_exacta asc
                           
                              )LOOP
                     
                      raise notice '----> id_ingreso %', v_reg_ingreso.id_ingreso;     
                     v_msg_ret =  almin.f_al_valorar_ingresos(v_reg_ingreso.id_ingreso, v_reg_ingreso.id_almacen_logico, v_reg_ingreso.id_parametro_almacen, v_reg_ingreso.correlativo_ing, v_reg_ingreso.codigo_motivo_ingreso);
                     if v_msg_ret[1] = 'fallo' then
                       return v_msg_ret;
                     end if; 
                                       
          END LOOP;                      
      
        -- raise exception '----llega----';
     ------------------------------------------------------------------------------------------------------------------------------------------------------
     -- 6)  si llega al final logro revalorar todas las salidas e ingresos ->  modificamos el parametro_lamcen_logico para que permita cerrar la gestion
     ------------------------------------------------------------------------------------------------------------------------------------------------------
     	  UPDATE almin.tal_parametro_almacen_logico  set
                 costeo_pendiente = 'no'
           WHERE id_parametro_almacen_logico =  al_id_parametro_almacen_logico;
     -------------------------------------------------------------
     --7) actuizamos el kardex logigo oficial para todos los item
     --------------------------------------------------------------
     
        -- validamos que las cantidas sean iguales (al final siempre deberian ser iguales)
        
           FOR v_registros_kl in (
           						select 
                                	*
                                from almin.tal_kardex_logico kl
                                where      kl.id_almacen_logico = v_registros.id_almacen_logico
                                	  and  kl.id_parametro_almacen = v_registros.id_parametro_almacen
           						) LOOP
                        
                        v_registros_aux = NULL;
                		
                        
                        --buscamos el equivalente en el kardex auxiliar
                         select
                               ka.costo_total,
                               ka.costo_unitario,
                               ka.cantidad
                            into
                               v_registros_aux
                         from almin.tal_kardex_logico_aux ka
                         where      ka.id_item =  v_registros_kl.id_item     		
                               and  ka.id_almacen_logico =  v_registros.id_almacen_logico    		
                               and  ka.id_parametro_almacen =  v_registros.id_parametro_almacen
                               and  ka.estado_item = v_registros_kl.estado_item ;    
                               
                             
                               
                         IF v_registros_aux.cantidad != v_registros_kl.cantidad THEN
                               raise exception 'Al final las cantidades calcula y real no igualan aparentemente la base de datos  fue distorcionada,  las cantidades fisicas no pueden veriar  (KL % , KA %)',v_registros_kl.cantidad, v_registros_aux.cantidad;
                         END IF;      
                               
        				-- actulizamos costos unitarios y total del kardex logico
                        update almin.tal_kardex_logico  SET
                           costo_total = v_registros_aux.costo_total, 
                           costo_unitario = v_registros_aux.costo_unitario
                        where id_kardex_logico = v_registros_kl.id_kardex_logico;
                        
          END  LOOP;
          
          v_retorno[1] = 'exito';
          v_retorno[2] = 'Valoración realizada.';
          
       
	RETURN v_retorno;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;