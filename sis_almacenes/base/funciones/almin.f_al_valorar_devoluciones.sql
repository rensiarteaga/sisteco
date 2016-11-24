--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_al_valorar_devoluciones (
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
                                  
                                  
BEGIN

	


 --RECORRE EL DETALLE DEL INGRESO Y VALORA CADA ITEM
                OPEN g_cursor(al_id_ingreso);

                LOOP
                    FETCH g_cursor INTO g_registro;
                    EXIT WHEN NOT FOUND;

                    IF NOT g_registro.cantidad IS NULL AND g_registro.cantidad > 0 THEN
                        
                         -- obtener el ulitmo costo de la ultima salida del mismo matearial (no importa si es de otra gestion)
                        g_aux_cotos_det = NULL;
                         
                         select 
                            COALESCE(sad.costo_unitario,0),
                            s.correlativo_sal
                         into
                            g_aux_cotos_det,
                            g_correlativo_ing
                         from almin.tal_salida_detalle sad
                         inner join almin.tal_salida s on s.id_salida = sad.id_salida
                         where sad.id_item = g_registro.id_item
                         		AND s.id_almacen_logico = al_id_almacen_logico
                                AND s.estado_salida = 'Finalizado'
                          ORDER BY sad.id_salida_detalle DESC
                          LIMIT 1 OFFSET 0;
                        
                        IF g_aux_cotos_det = 0 THEN
                          
                            if p_lazar_error = 'si' then
                            	raise exception 'La salida % del item % no fue valorada, primero  costee los ingresos y salidas previos', g_correlativo_ing, g_registro.codigo;
                            else  
                               v_retorno[1] = 'fallo';   
                               v_retorno[2] = 'La salida  '||g_correlativo_ing ||' del item '|| g_registro.codigo||' no fue valorada, primero  costee los ingresos y salidas previos';
                               return v_retorno;
                            end if;
                       
                     END IF;
                        
                         IF g_aux_cotos_det is null THEN
                            if p_lazar_error = 'si' then
                                raise exception 'No existe una ultima salida finalizada para el material %, no puede ingresar por devolucion',  g_registro.codigo;
                            else  
                                v_retorno[1] = 'fallo';   
                                v_retorno[2] = 'No existe una ultima salida finalizada para el material '||g_registro.codigo||', no puede ingresar por devolucion';
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