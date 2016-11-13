--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_ai_valorizar_movimiento (
  al_id_movimiento integer
)
RETURNS varchar AS
$body$
DECLARE
v_movimiento		record;
v_rec_ing			record;

v_rec_sal			record;

v_consulta			varchar;
v_costo_valorado	numeric;
v_datos_valorados	record;

--var calculos
cant_actualiz		numeric;
costo_actualiz		numeric;	--costo total
precio_unitario		numeric;

BEGIN

select tip.tipo,mov.* into v_movimiento
from alma.tai_movimiento mov
inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
where mov.id_movimiento=al_id_movimiento;

if v_movimiento.id_solicitud_salida is NULL
then
	--movimientos normales
    if (v_movimiento.tipo = 'ingreso' OR v_movimiento.tipo = 'transpaso_ingreso' OR v_movimiento.tipo = 'devolucion')
    then
		--detalle de los items del movimiento a valorizar
    	v_consulta:='		SELECT det.id_item,det.cantidad,det.costo_unitario,det.costo_valorado,mov.id_almacen,it.metodo_valoracion,det.id_detalle_movimiento,tip.tipo
                            FROM alma.tai_movimiento mov
                            INNER JOIN alma.tai_detalle_movimiento det on det.id_movimiento=mov.id_movimiento
                            INNER JOIN alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                            INNER JOIN alma.tai_item it on it.id_item=det.id_item
                            WHERE mov.id_movimiento='||al_id_movimiento||'
                            ORDER BY det.id_detalle_movimiento ASC';
    
    	for v_rec_ing in EXECUTE(v_consulta)
        loop
        	/*
             1)recorrido de los items del movimiento a valorar
             1.1) verifica el metodo de valoracion del item
            */
        	IF v_rec_ing.metodo_valoracion ='PP'
            THEN 
            	BEGIN
                	--control de costo de ingreso unitario del item
                    if v_rec_ing.costo_unitario < 0 then
                    	raise exception '%','Error: Verfique el costo unitario de ingreso del item :'||v_rec_ing.id_item||chr(10)||'Precio Unitario:'||v_rec_ing.costo_unitario;
                    end if;
                         --se verifica si el item fue valorado anteriormente en el almacen
                         if NOT EXISTS (	select 1 from alma.tai_item_valoracion_pp val
                                            where val.id_item=v_rec_ing.id_item 
                                            AND   val.id_almacen=v_rec_ing.id_almacen )
                          then
                             BEGIN
                          	  --raise notice '%',v_rec_ing.id_item;
                              v_costo_valorado=round((v_rec_ing.cantidad * v_rec_ing.costo_unitario)::numeric,6);--6 decimales 
                              --el item se valora por primera vez
                              INSERT INTO alma.tai_item_valoracion_pp( id_item	,cantidad	,costo_unitario
                              											,costo_valorado		,id_almacen,	id_detalle_movimiento)
                              VALUES(v_rec_ing.id_item,		v_rec_ing.cantidad,		v_rec_ing.costo_unitario
                              		,v_costo_valorado,		v_rec_ing.id_almacen	,v_rec_ing.id_detalle_movimiento);
                            
                          	 --se actualizan los datos de los costos valorados en la tabla alma.tai_detalle_movimiento
                             UPDATE alma.tai_detalle_movimiento
                             SET costo_valorado = v_rec_ing.costo_unitario --v_costo_valorado
                             WHERE alma.tai_detalle_movimiento.id_detalle_movimiento=v_rec_ing.id_detalle_movimiento;
                             
                             END;
                          else
                             --se agarran los montos de las ultimas valoraciones correspondientes al item del almacen
                             select val.* into v_datos_valorados
                             from alma.tai_item_valoracion_pp val
                             where val.id_item=v_rec_ing.id_item and val.id_almacen=v_rec_ing.id_almacen;
                             
                              --calculos
                             cant_actualiz = v_rec_ing.cantidad + v_datos_valorados.cantidad;
                             costo_actualiz =  (v_rec_ing.cantidad * v_rec_ing.costo_unitario ) + (v_datos_valorados.costo_valorado); 
                             precio_unitario = round((costo_actualiz/cant_actualiz)::numeric,6);
                             
                             
                             UPDATE alma.tai_item_valoracion_pp
                             SET 	cantidad = cant_actualiz
                             		,costo_unitario = precio_unitario
                                    ,costo_valorado = costo_actualiz
                                    ,id_detalle_movimiento = v_rec_ing.id_detalle_movimiento
                                    ,usuario_reg = "current_user"() 
                					,fecha_reg = now()
                             WHERE alma.tai_item_valoracion_pp.id_item=v_rec_ing.id_item AND alma.tai_item_valoracion_pp.id_almacen=v_rec_ing.id_almacen;
                             	 
                             --se actualizan los datos de los costos valorados en la tabla alma.tai_detalle movimiento
                             UPDATE alma.tai_detalle_movimiento
                             SET costo_valorado = precio_unitario --costo_actualiz
                             WHERE alma.tai_detalle_movimiento.id_detalle_movimiento=v_rec_ing.id_detalle_movimiento;
                             
                          end if;
            	END;
            elsif v_rec_ing.metodo_valoracion ='UEPS'
            then
            	--llamada a la funcion para la valoracion por UEPS
                raise exception '%','verifique el metodo de valoracion del item : '||v_rec_ing.id_item;
            elseif v_rec_ing.metodo_valoracion ='PEPS'
            then
            	--llamada a la funcion para la valoracion por UEPS
                raise exception '%','verifique el metodo de valoracion del item : '||v_rec_ing.id_item;
            END IF;
                    
        end loop;
    else --v_movimiento.tipo = 'salida' OR 'transpaso_salida'
    	BEGIN
        	--detalle de los items del movimiento a valorizar
    		v_consulta:='		SELECT det.id_item,det.cantidad,det.costo_unitario,det.costo_valorado,mov.id_almacen,it.metodo_valoracion,det.id_detalle_movimiento,tip.tipo
                                FROM alma.tai_movimiento mov
                                INNER JOIN alma.tai_detalle_movimiento det on det.id_movimiento=mov.id_movimiento
                                INNER JOIN alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                                INNER JOIN alma.tai_item it on it.id_item=det.id_item
                                WHERE mov.id_movimiento='||al_id_movimiento||'
                                ORDER BY det.id_detalle_movimiento ASC';	
            for v_rec_sal in EXECUTE(v_consulta)
            loop 
            	if v_rec_sal.metodo_valoracion = 'PP'
                then 
                BEGIN
                    --verificacion de existencia de la valoracion del item antes de la salida
                    if NOT EXISTS(select 1
                                    from alma.tai_item_valoracion_pp val
                                    where val.id_item=v_rec_sal.id_item AND val.id_almacen=v_rec_sal.id_almacen
                                    )
                    then 
                            raise exception '%','El Item:'||v_rec_sal.id_item||' no fue registrado nunca como ingreso, verifique la tabla alma.tai_item_valoracion_pp';
                    else
                            select val.* into v_datos_valorados
                            from alma.tai_item_valoracion_pp val
                            where val.id_item=v_rec_sal.id_item and val.id_almacen=v_rec_sal.id_almacen;
                            --verificacion de cantidad del item
                            if v_datos_valorados.cantidad < v_rec_sal.cantidad --ingresos < salidas
                            then
                                raise exception '%','Las existencias del item son insuficientes :'||v_rec_sal.id_item||
                                                    chr(10)||'Total ingresos :'||v_datos_valorados.cantidad||
                                                    chr(10)||'Cantidad solicitada :'||v_rec_sal.cantidad;
                            else
                            --colocar otros tipos de control de salida en esta seccion
                            
                            --calculos
                             cant_actualiz = v_datos_valorados.cantidad - v_rec_sal.cantidad;
                             precio_unitario = v_datos_valorados.costo_unitario;
                             costo_actualiz =  v_datos_valorados.costo_valorado - (v_rec_sal.cantidad * precio_unitario);
                             
                             if costo_actualiz < 0 then 
                             	raise exception '%','Error,verifique las cantidades de salida y los precios unitarios del item: '||v_rec_sal.id_item;
                             end if;
                             
                             UPDATE alma.tai_item_valoracion_pp
                             SET 	cantidad = cant_actualiz
                             		,costo_unitario = precio_unitario
                                    ,costo_valorado = costo_actualiz
                                    ,id_detalle_movimiento = v_rec_sal.id_detalle_movimiento
                                    ,usuario_reg = "current_user"() 
                					,fecha_reg = now()
                             WHERE alma.tai_item_valoracion_pp.id_item=v_rec_sal.id_item AND alma.tai_item_valoracion_pp.id_almacen=v_rec_sal.id_almacen;
                             	 
                             --se actualizan los datos de los costos valorados en la tabla alma.tai_detalle movimiento
                             UPDATE alma.tai_detalle_movimiento
                             SET costo_valorado = costo_actualiz
                    		 --añadido 11/08/2015 -> actualizacion del costo unitario para las salidas
                             ,costo_unitario = precio_unitario
                             WHERE alma.tai_detalle_movimiento.id_detalle_movimiento=v_rec_sal.id_detalle_movimiento;
                    
                            end if;
                    end if;
                END;
                elsif v_rec_sal.metodo_valoracion='UEPS'
                then
                    	--llamada a la funcion para la valoracion por UEPS
                        raise exception '%','verifique el metodo de valoracion del item : '||v_rec_sal.id_item;
                elsif v_rec_sal.metodo_valoracion='PEPS'
                then 
                    	--llamada a la funcion para la valoracion por PEPS
                        raise exception '%','verifique el metodo de valoracion del item : '||v_rec_sal.id_item;
                end if;
            end loop;
        END;
    end if;
else
	--movimiento generado a partir de una solicitud de salida
    if v_movimiento.tipo = 'solicitud'then
    	BEGIN
          v_consulta:='	  SELECT det.id_item,det.cantidad,det.cantidad_solicitada,det.costo_unitario,det.costo_valorado,mov.id_almacen,it.metodo_valoracion,det.id_detalle_movimiento,tip.tipo
                          FROM alma.tai_movimiento mov
                          INNER JOIN alma.tai_detalle_movimiento det on det.id_movimiento=mov.id_movimiento
                          INNER JOIN alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                          INNER JOIN alma.tai_item it on it.id_item=det.id_item
                          WHERE mov.id_movimiento='||al_id_movimiento||'
                          ORDER BY det.id_detalle_movimiento ASC';
                          
          for v_rec_sal in EXECUTE(v_consulta)
          loop
          		if v_rec_sal.metodo_valoracion = 'PP'
                then
                	BEGIN
                      --verificacion de existencia de la valoracion del item antes de la salida
                      if NOT EXISTS(select 1
                                      from alma.tai_item_valoracion_pp val
                                      where val.id_item=v_rec_sal.id_item AND val.id_almacen=v_rec_sal.id_almacen
                                      )
                      then 
                      		raise exception '%','El Item:'||v_rec_sal.id_item||'  no fue registrado nunca como ingreso, verifique la tabla alma.tai_item_valoracion';
                      else
                            select val.* into v_datos_valorados
                            from alma.tai_item_valoracion_pp val
                            where val.id_item=v_rec_sal.id_item and val.id_almacen=v_rec_sal.id_almacen;
                            
                            if v_datos_valorados.cantidad < v_rec_sal.cantidad 	--	ingresos < salidas
                            then
                                raise exception '%','Las existencias del item son insuficientes :'||v_rec_sal.id_item||
                                                    chr(10)||'Total ingresos :'||v_datos_valorados.cantidad||
                                                    chr(10)||'Cantidad solicitada :'||v_rec_sal.cantidad;
                            else
                             --colocar otros tipos de control de salida en esta seccion
                             
                             --calculos
                             cant_actualiz = v_datos_valorados.cantidad - v_rec_sal.cantidad;
                             precio_unitario = v_datos_valorados.costo_unitario;
                             costo_actualiz =  v_datos_valorados.costo_valorado - (v_rec_sal.cantidad * precio_unitario);
                             
                             if costo_actualiz < 0 then 
                             	raise exception '%','Error,verifique las cantidades entregadas y los precios unitarios del item: '||v_rec_sal.id_item;
                             end if;
                             
                             UPDATE alma.tai_item_valoracion_pp
                             SET 	cantidad = cant_actualiz
                             		,costo_unitario = precio_unitario
                                    ,costo_valorado = costo_actualiz
                                    ,id_detalle_movimiento = v_rec_sal.id_detalle_movimiento
                                    ,usuario_reg = "current_user"() 
                					,fecha_reg = now()
                             WHERE alma.tai_item_valoracion_pp.id_item=v_rec_sal.id_item AND alma.tai_item_valoracion_pp.id_almacen=v_rec_sal.id_almacen;
                             	 
                             --se actualizan los datos de los costos valorados en la tabla alma.tai_detalle movimiento
                             UPDATE alma.tai_detalle_movimiento
                             SET costo_valorado = costo_actualiz
                              --añadido 11/08/2015 -> actualizacion del costo unitario para las salidas
                             ,costo_unitario = precio_unitario
                             WHERE alma.tai_detalle_movimiento.id_detalle_movimiento=v_rec_sal.id_detalle_movimiento;
                             	
                            end if;
                            
                            
                      end if;
                    END;
                elsif v_rec_sal.metodo_valoracion='UEPS'
                then
                    	--llamada a la funcion para la valoracion por UEPS
                        raise exception '%','verifique el metodo de valoracion del item : '||v_rec_sal.id_item;
                elsif v_rec_sal.metodo_valoracion='PEPS'
                then 
                    	--llamada a la funcion para la valoracion por PEPS
                        raise exception '%','verifique el metodo de valoracion del item : '||v_rec_sal.id_item;
                end if;

          end loop;
   		END;
    end if;
      
end if;
	
return 't';
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;