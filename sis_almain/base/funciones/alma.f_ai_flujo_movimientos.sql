--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_ai_flujo_movimientos (
  al_id_movimiento integer,
  al_accion varchar
)
RETURNS varchar AS
$body$
DECLARE
g_rec 			record;

g_datos			record;
g_det_items		record;
g_valorar		varchar;
g_codigo		varchar;

g_respuesta		varchar;
BEGIN

--obtencion de los datos del movimiento
if not EXISTS(select 1 from alma.tai_movimiento m where m.id_movimiento=al_id_movimiento)then
	raise exception 'El movimiento enviado no existe !!!';
end if;


     SELECT 	mov.codigo as mov_codigo,mov.estado,mov.fecha_movimiento,mov.fecha_finalizacion,mov.nro_compra
            ,alm.codigo as codigo_almacen,alm.nombre,alm.id_almacen
            ,tip.id_tipo_movimiento,tip.id_documento,tip.requiere_aprobacion,tip.tipo INTO g_rec
    FROM alma.tai_movimiento mov
    INNER JOIN alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
    INNER JOIN alma.tai_almacen alm on alm.id_almacen=mov.id_almacen AND alm.estado='activo'
    WHERE mov.id_movimiento = al_id_movimiento;
    
    
	if NOT EXISTS (SELECT 1 FROM alma.tai_detalle_movimiento d WHERE d.id_movimiento=al_id_movimiento) then
   		raise exception '%','El movimiento seleccionado ('||al_id_movimiento||')  no tiene un detalle de items registrados'; 
 	end if;




   
IF(al_accion = 'INICIAR')-- estados del movimiento {borrador}
THEN
	IF(g_rec.tipo = 'devolucion' AND g_rec.requiere_aprobacion = 'si' AND g_rec.estado='borrador')
    THEN
    		g_respuesta := alma.f_ai_flujo_movimientos(al_id_movimiento,'PENDIENTE_APROBACION');
            return g_respuesta;
        
    ELSIF (g_rec.tipo = 'devolucion' AND g_rec.requiere_aprobacion = 'no')THEN
    	BEGIN
    		g_respuesta := alma.f_ai_flujo_movimientos(al_id_movimiento,'FINALIZAR_DEVOLUCION');
            return g_respuesta;
    	END;
    ELSIF (g_rec.tipo = 'devolucion' AND g_rec.estado = 'pendiente_aprobacion')THEN--estado movimiento -> valorado
    	BEGIN
        	select alma.f_ai_flujo_movimientos(al_id_movimiento,'FINALIZAR_DEVOLUCION') INTO g_respuesta;
            return g_respuesta;
        END;
   ELSIF (g_rec.tipo = 'devolucion' AND g_rec.estado = 'valorado')THEN
        BEGIN
        	SELECT alma.f_ai_flujo_movimientos(al_id_movimiento,'FINALIZAR_MOVIMIENTO') INTO g_respuesta;
            RETURN g_respuesta;
        END;
    END IF;
    
    
ELSIF(al_accion = 'PENDIENTE_APROBACION')THEN
  BEGIN
      UPDATE alma.tai_movimiento 
      SET estado='pendiente_aprobacion'
      WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
      
      return 't';
  END;
ELSIF (al_accion = 'FINALIZAR_MOVIMIENTO')THEN
	BEGIN	
    	  --valorar movimiento
          g_valorar := alma.f_ai_valorizar_movimiento(al_id_movimiento); 
                
            if (g_valorar != 't')
            then
                	return g_valorar;
             else
             	--generar codigo movimiento
             	IF EXISTS(SELECT 1 FROM alma.tai_movimiento mov WHERE mov.codigo is NULL AND mov.id_movimiento=al_id_movimiento)
                THEN
                    g_codigo := alma.f_ai_generar_cod_movimiento(al_id_movimiento);
                        
                    --cambiar el estado del movimiento a finalizado
                    UPDATE alma.tai_movimiento
                    SET codigo = g_codigo,
                       	estado = 'valorado'
                    WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
                    return 't';
                ELSE
                    UPDATE alma.tai_movimiento
                    SET estado = 'valorado'
                    WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
                    return 't';
                END IF;
           end if;
	END;
ELSIF(al_accion = 'FINALIZAR_DEVOLUCION')THEN
	BEGIN
    		
    	-- SELECCION DE LOS ITEMS DEL MOVIMIENTO
        FOR g_datos IN (SELECT id_item,cantidad,id_detalle_movimiento,costo_unitario,costo_valorado 
                        		 FROM alma.tai_detalle_movimiento  
                                 WHERE id_movimiento = al_id_movimiento
                                 ORDER BY id_detalle_movimiento ASC)
        LOOP
        	if not EXISTS(select 1 from alma.tai_item_valoracion_pp a where a.id_item=g_datos.id_item AND a.id_almacen=g_rec.id_almacen)
            then 	return 'f';--uno de los items del movimiento nunca fua valorado en el almacen
            end if;
        	 IF(g_datos.costo_unitario = 0)
                     THEN
                          SELECT val.id_item_valoracion,val.costo_unitario,val.costo_valorado INTO g_det_items
                          FROM alma.tai_item_valoracion_pp val
                          WHERE val.id_almacen = g_rec.id_almacen AND val.id_item = g_datos.id_item;
                                 
                          UPDATE alma.tai_detalle_movimiento
                          SET costo_unitario = g_det_items.costo_unitario,
                              --costo_valorado = g_det_items.costo_valorado,
                              costo_total = (g_det_items.costo_unitario*g_datos.cantidad)
                          WHERE alma.tai_detalle_movimiento.id_detalle_movimiento = g_datos.id_detalle_movimiento;
             END IF;
        END LOOP;
        
        --CAMBIAR DEVOLUCION A VALORADO
        IF EXISTS(SELECT 1 FROM alma.tai_movimiento mov WHERE mov.codigo is NULL AND mov.id_movimiento=al_id_movimiento)
        THEN
            	g_codigo := alma.f_ai_generar_cod_movimiento(al_id_movimiento);
                        
                UPDATE alma.tai_movimiento
                SET codigo = g_codigo,
                 	estado = 'valorado'
                WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
                
        ELSE
                UPDATE alma.tai_movimiento
                SET estado = 'valorado'
                WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
        END IF;
    return 't';    
	END;
   
END IF;
  /* 
IF(g_rec.tipo = 'devolucion')
THEN
	/*
     si aprobacion 2 'si'
      1-> verificar el detalle de los items del movimiento
      2-> cambiar el estado a 'pendiente_aprobacion' 
    */
    	/*IF(g_rec.requiere_aprobacion = 'si' AND g_rec.estado='borrador')THEN
            UPDATE alma.tai_movimiento 
            SET estado='pendiente_aprobacion'
            WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
        ELSIF (g_rec.requiere_aprobacion = 'no' AND g_rec.estado='borrador')THEN
        	BEGIN        	
                /*
                 1.- seleccion de los ultimos datos de los items del movimiento 
                 */
                /* FOR g_datos IN (SELECT id_item,cantidad,id_detalle_movimiento,costo_unitario,costo_valorado 
                        		 FROM alma.tai_detalle_movimiento  
                                 WHERE id_movimiento = al_id_movimiento
                                 ORDER BY id_detalle_movimiento ASC)
                 LOOP
                 	 IF(g_datos.costo_unitario = 0 OR g_datos.costo_valorado = 0)
                     THEN
                          SELECT val.id_item_valoracion,val.costo_unitario,val.costo_valorado INTO g_det_items
                          FROM alma.tai_item_valoracion_pp val
                          WHERE val.id_almacen = g_rec.id_almacen AND val.id_item = g_datos.id_item;
                                 
                          UPDATE alma.tai_detalle_movimiento
                          SET costo_unitario = g_det_items.costo_unitario,
                              costo_valorado = g_det_items.costo_valorado,
                              costo_total = (g_det_items.costo_unitario*g_datos.cantidad)
                          WHERE alma.tai_detalle_movimiento.id_detalle_movimiento = g_datos.id_detalle_movimiento;
                     END IF;

                 END LOOP;
                
                --valorar movimiento
                --g_valorar := alma.f_al_valorizar_movimiento(al_id_movimiento); 
                
                --if (g_valorar != 't')
                --then
                	--raise exception 'Error al valorar la devolucion !!!';
                 --else
                 	--generar codigo movimiento
                    IF EXISTS(SELECT 1 FROM alma.tai_movimiento mov WHERE mov.codigo is NULL AND mov.id_movimiento=al_id_movimiento)
                    THEN
                    	g_codigo := alma.f_al_generar_cod_movimiento(al_id_movimiento);
                        
                        --cambiar el estado del movimiento a finalizado
                        UPDATE alma.tai_movimiento
                        SET codigo = g_codigo,
                        	estado = 'valorado'
                        WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
                    ELSE
                    	UPDATE alma.tai_movimiento
                        SET estado = 'valorado'
                        WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
                    END IF;

                --end if;
        	END;
        --finalizar la devoulucion
        ELSIF (g_rec.estado = 'pendiente_aprobacion')THEN
        BEGIN
        		--recorrido de  los items del movimiento
        		FOR g_datos IN (SELECT id_item,cantidad,id_detalle_movimiento,costo_unitario,costo_valorado 
                        		 FROM alma.tai_detalle_movimiento  
                                 WHERE id_movimiento = al_id_movimiento
                                 ORDER BY id_detalle_movimiento ASC)
                 LOOP
                 	 --se actualiza el costo unitario de la devolucion si es que no se tiene registrado  uno
                 	 IF(g_datos.costo_unitario = 0 AND g_datos.costo_valorado = 0)
                     THEN
                          SELECT val.id_item_valoracion,val.costo_unitario,val.costo_valorado INTO g_det_items
                          FROM alma.tai_item_valoracion_pp val
                          WHERE val.id_almacen = g_rec.id_almacen AND val.id_item = g_datos.id_item;
                                 
                          UPDATE alma.tai_detalle_movimiento
                          SET costo_unitario = g_det_items.costo_unitario,
                              costo_valorado = g_det_items.costo_valorado,
                              costo_total = (g_det_items.costo_unitario*g_det_items.costo_valorado)
                          WHERE alma.tai_detalle_movimiento.id_detalle_movimiento = g_datos.id_detalle_movimiento;
                     END IF;

                 END LOOP;
                 --valorar movimiento
               -- g_valorar := alma.f_al_valorizar_movimiento(al_id_movimiento); 
                
                --if (g_valorar != 't')
               -- then
                --	raise exception 'Error al valorar la devolucion !!!';
                -- else
                 	--generar codigo movimiento
                    IF EXISTS(SELECT 1 FROM alma.tai_movimiento mov WHERE mov.codigo is NULL AND mov.id_movimiento=al_id_movimiento)
                    THEN
                    	g_codigo := alma.f_al_generar_cod_movimiento(al_id_movimiento);
                        
                        --cambiar el estado del movimiento a finalizado
                        UPDATE alma.tai_movimiento
                        SET codigo = g_codigo,
                        	estado = 'valorado'
                        WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
                    ELSE
                    	UPDATE alma.tai_movimiento
                        SET estado = 'valorado'
                        WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
                    END IF;

                --end if;
        END;
        END IF;
END IF;*/


END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;