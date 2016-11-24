--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_al_valorar_transferencia (
  al_id_ingreso integer,
  al_id_almacen_logico integer,
  p_lazar_error varchar
)
RETURNS varchar [] AS
$body$
DECLARE
   v_retorno			 		varchar[]; 
   g_registro					record;
   g_aux_cotos_det				numeric; 
   g_correlativo_ing			varchar;
   
   g_cursor                      CURSOR(ID integer) FOR
                                  SELECT
                                     INGDET.id_ingreso_detalle,INGDET.id_item, INGDET.cantidad, ITEM.peso_kg, ITEM.costo_estimado,ITEM.codigo
                                  FROM almin.tal_ingreso_detalle INGDET
                                  INNER JOIN almin.tal_item ITEM
                                  ON ITEM.id_item = INGDET.id_item
                                  WHERE INGDET.id_ingreso = ID;
   
   g_id_transferencia			integer;
   g_correl						varchar;
                                  
                                  
BEGIN

	
                      select 
                        t.id_transferencia,
                        s.correlativo_sal::varchar
                     into
                        g_id_transferencia,
                        g_correl
                     from almin.tal_transferencia t
                     inner join almin.tal_salida s on s.id_salida = t.id_salida
                     where t.id_ingreso = v_registros_ingreso.id_ingreso;
                     
                     IF g_id_transferencia is null THEN
                     	raise exception 'no se encontro la transferencia para el ingreso id: %',al_id_ingreso;
                     END IF;
         
                                                   
                      --RECORRE EL DETALLE DEL INGRESO Y VALORA CADA ITEM
                      OPEN g_cursor(al_id_ingreso);

                      LOOP
                          FETCH g_cursor INTO g_registro;
                          EXIT WHEN NOT FOUND;

                          IF NOT g_registro.cantidad IS NULL AND g_registro.cantidad > 0 THEN
                              
                               -- obtener el ulitmo costo de la tranferencia
                               g_aux_cotos_det = NULL;
                               
                              
                              SELECT
                                 COALESCE(costo_unitario  ,0)
                                into
                                g_aux_cotos_det 
                              FROM almin.tal_transferencia_det td
                          	  WHERE id_transferencia = g_id_transferencia 
                              		and  td.id_item = g_registro.id_item;  
                                
                              
                              IF g_aux_cotos_det = 0 THEN
                                  
                                  if p_lazar_error = 'si' then
                                      raise exception 'La salida del prestamo % para el item item % no fue valorada, primero  costee los ingresos y salidas previos en el almacen origen', g_correl, g_registro.codigo;
                                  else  
                                     v_retorno[1] = 'fallo';   
                                     v_retorno[2] = 'La salida del prestamo '||g_correl::varchar ||'para el item item '||g_registro.codigo||' no fue valorada, primero  costee los ingresos y salidas previos en el almacen origen';
                                     return v_retorno;
                                  end if;
                              
                              END IF;
                              
                               IF g_aux_cotos_det is null THEN
                                  
                                  if p_lazar_error = 'si' then
                                      raise exception 'No se encontro una salida por transferencia  una ultima salida para el material %',  g_registro.codigo;
                                   else  
                                     v_retorno[1] = 'fallo';   
                                     v_retorno[2] = 'No se encontro una salida por transferencia  una ultima salida para el material '||g_registro.codigo;
                                     return v_retorno;
                                  end if;
                              END IF;
                             

                              -- ACTUALZA EL PRECIO UNITARIO EN LA BD
                              UPDATE almin.tal_ingreso_detalle SET
                                 costo_unitario = g_aux_cotos_det,
                                 costo = g_aux_cotos_det * g_registro.cantidad
                              WHERE id_ingreso_detalle = g_registro.id_ingreso_detalle;  
                              
                          END IF;

                      END LOOP;
                      CLOSE g_cursor; 

  
                
   v_retorno[1] = 'exito';

   return v_retorno;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;