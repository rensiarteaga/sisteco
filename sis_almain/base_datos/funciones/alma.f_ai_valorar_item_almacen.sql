--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_ai_valorar_item_almacen (
  al_accion varchar,
  al_id_almacen integer,
  al_id_item integer
)
RETURNS varchar AS
$body$
DECLARE
v_consulta 		varchar;
v_rec			record;
v_datos_valorados	record;

--var calculos
cant_actualiz		numeric;
costo_actualiz		numeric;	--costo total
precio_unitario		numeric;
v_res				varchar;

BEGIN

IF al_accion = 'VAL_IT_ALM' THEN	
	BEGIN
    	        
		--datos generales del item en el almacen
		DELETE FROM alma.tai_item_valoracion_pp 
		WHERE id_almacen= al_id_almacen AND id_item = al_id_item;
    
    	v_consulta := 'SELECT 	det.id_detalle_movimiento,tip.tipo,it.id_item,det.cantidad,det.cantidad_solicitada
        						,it.metodo_valoracion,det.tipo_saldo,det.costo_unitario,det.costo_valorado
        	            FROM alma.tai_detalle_movimiento det
            	        INNER JOIN alma.tai_movimiento mov on mov.id_movimiento=det.id_movimiento
                	    INNER JOIN  alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                    	INNER JOIN alma.tai_item it on it.id_item=det.id_item
	                    WHERE mov.estado=''finalizado'' AND mov.id_almacen='||al_id_almacen||' AND det.id_item='||al_id_item||' ORDER BY mov.fecha_finalizacion ASC';
        
        FOR v_rec IN EXECUTE(v_consulta)
        LOOP
        		
        		IF v_rec.metodo_valoracion = 'PP' THEN
                
                	IF v_rec.tipo IN ('ingreso','transpaso_ingreso','devolucion') THEN
              
                      --control de costo de ingreso unitario del item
                      if v_rec.costo_unitario < 0 then
                          raise exception '%','Error: Verfique el costo unitario de ingreso del item :'||v_rec.id_item||chr(10)||'Precio Unitario:'||v_rec.costo_unitario;
                      end if;
                      
                      --se verifica si el item fue valorado anteriormente en el almacen
                      IF NOT EXISTS (	select 1 from alma.tai_item_valoracion_pp val
                                            where val.id_item=al_id_item 
                                            AND   val.id_almacen=al_id_almacen ) THEN
                                            
                      		INSERT INTO alma.tai_item_valoracion_pp(id_almacen,id_item,cantidad,costo_unitario,costo_valorado,id_detalle_movimiento)
                            VALUES(al_id_almacen,al_id_item,v_rec.cantidad,v_rec.costo_unitario,(round((v_rec.cantidad * v_rec.costo_unitario),6))::numeric ,v_rec.id_detalle_movimiento);
                            
                             --se actualizan los datos de los costos valorados en la tabla alma.tai_detalle_movimiento
                             UPDATE alma.tai_detalle_movimiento
                             SET costo_valorado = v_rec.costo_unitario --v_costo_valorado
                             WHERE alma.tai_detalle_movimiento.id_detalle_movimiento=v_rec.id_detalle_movimiento;
                      
                      ELSE
                      		
                      		 --se agarran los montos de las ultimas valoraciones correspondientes al item del almacen
                             select val.* into v_datos_valorados
                             from alma.tai_item_valoracion_pp val
                             where val.id_item=al_id_item and val.id_almacen=al_id_almacen;
                             
                              --calculos
                             cant_actualiz = v_rec.cantidad + v_datos_valorados.cantidad;
                             costo_actualiz =  (v_rec.cantidad * v_rec.costo_unitario ) + (v_datos_valorados.costo_valorado); 
                             precio_unitario = round((costo_actualiz/cant_actualiz)::numeric,6);
                             
                             
                             UPDATE alma.tai_item_valoracion_pp
                             SET 	cantidad = cant_actualiz
                             		,costo_unitario = precio_unitario
                                    ,costo_valorado = costo_actualiz
                                    ,id_detalle_movimiento = v_rec.id_detalle_movimiento
                                    ,usuario_reg = "current_user"() 
                					,fecha_reg = now()
                             WHERE alma.tai_item_valoracion_pp.id_item=al_id_item AND alma.tai_item_valoracion_pp.id_almacen=al_id_almacen;
                             
                             --se actualizan los datos de los costos valorados en la tabla alma.tai_detalle movimiento
                             UPDATE alma.tai_detalle_movimiento
                             SET costo_valorado = precio_unitario --costo_actualiz
                             WHERE alma.tai_detalle_movimiento.id_detalle_movimiento=v_rec.id_detalle_movimiento;
                      
                      END IF;
                    
                    ELSE ----v_movimiento.tipo = 'salida' OR 'transpaso_salida'  
                 
                    	--verificacion de existencia de la valoracion del item antes de la salida
                    	if NOT EXISTS(select 1 from alma.tai_item_valoracion_pp val where val.id_item=al_id_item AND val.id_almacen=al_id_almacen)then
                        	raise exception '%','El Item:'||v_rec.id_item||' no fue registrado nunca como ingreso, verifique la tabla alma.tai_item_valoracion_pp';	
                        else
                        
                        	select val.* into v_datos_valorados
                            from alma.tai_item_valoracion_pp val
                            where val.id_item=al_id_item and val.id_almacen=al_id_almacen;
                            
                            if v_datos_valorados.cantidad < v_rec.cantidad --ingresos < salidas
                            then
                                raise exception '%','Las existencias del item son insuficientes :'||v_rec.id_item||
                                                    chr(10)||'Total ingresos :'||v_datos_valorados.cantidad||
                                                    chr(10)||'Cantidad solicitada :'||v_rec.cantidad;
                            
                            else
                            
                             	cant_actualiz = v_datos_valorados.cantidad - v_rec.cantidad;
                             	precio_unitario = v_datos_valorados.costo_unitario;
                             	costo_actualiz =  v_datos_valorados.costo_valorado - (v_rec.cantidad * precio_unitario);
                                
                                if costo_actualiz < 0 then 
                             		raise exception '%','Error,verifique las cantidades de salida y los precios unitarios del item: '||v_rec.id_item;
                                end if;
                                
                                UPDATE alma.tai_item_valoracion_pp
                             	SET 	cantidad = cant_actualiz
                             			,costo_unitario = precio_unitario
                                    	,costo_valorado = costo_actualiz
	                                    ,id_detalle_movimiento = v_rec.id_detalle_movimiento
	                                    ,usuario_reg = "current_user"() 
	                					,fecha_reg = now()
                             	WHERE alma.tai_item_valoracion_pp.id_item=al_id_item AND alma.tai_item_valoracion_pp.id_almacen=al_id_almacen;
                                
                               --se actualizan los datos de los costos valorados en la tabla alma.tai_detalle movimiento
                               UPDATE alma.tai_detalle_movimiento
                               SET costo_valorado = costo_actualiz
                               --añadido 11/08/2015 -> actualizacion del costo unitario para las salidas
                               ,costo_unitario = precio_unitario
                               WHERE alma.tai_detalle_movimiento.id_detalle_movimiento=v_rec.id_detalle_movimiento;
                                
                             end if;
                            
                            
                            
                        end if;
                                                
                    END IF;
                
                ELSIF  v_rec.metodo_valoracion = 'UEPS' THEN
                	--llamada a la funcion para la valoracion por UEPS
                	raise exception '%','verifique el metodo de valoracion del item : '||v_rec.id_item;
                
                ELSIF  v_rec.metodo_valoracion = 'PEPS' THEN
                	--llamada a la funcion para la valoracion por PEPS
                	raise exception '%','verifique el metodo de valoracion del item : '||v_rec.id_item;
                END IF;

        END LOOP;
        
  
    RETURN 't';
 END;
 
 ELSIF al_accion = 'ALMAC_TODO' THEN
 	
 	FOR v_rec IN (SELECT DISTINCT det.id_item
                  FROM alma.tai_movimiento mov
                  INNER JOIN alma.tai_detalle_movimiento det on det.id_movimiento = mov.id_movimiento
                  WHERE mov.estado = 'finalizado' AND mov.id_almacen = al_id_almacen)
    LOOP
    
    	SELECT alma.f_ai_valorar_item_almacen('VAL_IT_ALM',al_id_almacen,v_rec.id_item) INTO v_res;
    
    END LOOP;
 
 	RETURN 't';
    
    
 END IF;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;