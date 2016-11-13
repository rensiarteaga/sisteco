--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_ai_control_ubicacion_item (
  al_procedimiento varchar,
  al_id_movimiento integer
)
RETURNS boolean AS
$body$
DECLARE
v_res 					boolean 	DEFAULT false;
v_movimiento			record;
v_detalle_item			record;
v_detalle_almacen		record;
v_det_ubic_item			record;
v_det_stock_item		record;
v_rec					record;

BEGIN

SELECT mov.id_almacen,mov.id_tipo_movimiento,mov.codigo,tip.requiere_aprobacion,tip.tipo INTO v_movimiento
FROM alma.tai_movimiento mov 
INNER JOIN alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
WHERE mov.id_movimiento = al_id_movimiento;


IF v_movimiento.tipo IN ('ingreso','devolucion','transpaso_ingreso') AND al_procedimiento = 'CONTROL_UBIC_INGRESOS' THEN --control de todos los movimientos relacionados con los ingresos

	/*
    1) recorrer todos los items del movimiento
    	1.1)verificar que cada item del movimiento tenga una ubicacion asignada
        	SINO -> manda la excepcion pidiendo de que se establezca una ubicacion para el item
        1.2) verificar que el monto ingresado del item sea <= al monto establecido en la ubicacion para el item(1ra ubicacion)
        	si tiene mas de 1 ubicacion en el almacen:
            1.2.1) si el monto del item ingresado con el movimiento sobrepasa la primera ubicacion 
        	
    */

    FOR v_rec IN (SELECT det.id_item,mov.id_almacen,det.cantidad
    				FROM alma.tai_movimiento mov
                    INNER JOIN alma.tai_detalle_movimiento det on det.id_movimiento=mov.id_movimiento
                    WHERE mov.id_movimiento = al_id_movimiento)
    LOOP
    
    	IF NOT EXISTS (	select 1 
        				from alma.tai_ubicacion_item_detalle a 
        				where a.id_almacen = v_rec.id_almacen AND a.id_item=v_rec.id_item)
        THEN 
        
        	v_res:=false;
            
            select it.codigo||' - '||it.nombre as det_item  into v_detalle_item
            from alma.tai_item it
            where it.id_item = v_rec.id_item;
            
            select a.codigo||' - '||a.nombre as desc_almacen into v_detalle_almacen
            from alma.tai_almacen a
            where a.id_almacen = v_rec.id_almacen;
            
            RAISE EXCEPTION '%','Error verifique que el item :'||v_detalle_item.det_item||' ,tenga una ubicación asignada en el almacen :'||v_detalle_almacen.desc_almacen;
        
        ELSE
        --el item del almacen tiene 1 ubicacion por lo menos
        	/*
            1) POR CADA ITEM DELE MOVIMIENTO SE LLAMA A LA FUNCION QUE ACOMODA LOS ITEMS EN LA UBICACION DEL ALMACEN RESPECTIVO(DE ACUERDO AL ORDEN PARAMETRIZADO EN LAS UBICACIONES)
            */
            
            v_res:= alma.f_ai_control_espacio_ubicacion('REG_INGRESO',v_rec.id_almacen,v_rec.id_item,v_rec.cantidad,NULL);
            

        END IF;
    
    END LOOP;

ELSIF v_movimiento.tipo IN ('salida','transpaso_salida','solicitud') AND al_procedimiento = 'CONTROL_UBIC_SALIDAS' THEN

	BEGIN
    	
    	
      FOR v_rec IN (SELECT det.id_item,mov.id_almacen,det.cantidad
                      FROM alma.tai_movimiento mov
                      INNER JOIN alma.tai_detalle_movimiento det on det.id_movimiento=mov.id_movimiento
                      WHERE mov.id_movimiento = al_id_movimiento)
      LOOP
      		 	
                IF NOT EXISTS (	select 1 
                                from alma.tai_ubicacion_item_detalle a 
                                where a.id_almacen = v_rec.id_almacen AND a.id_item=v_rec.id_item)
                THEN 
                
                    v_res:=false;
                    
                    select it.codigo||' - '||it.nombre as det_item  into v_detalle_item
                    from alma.tai_item it
                    where it.id_item = v_rec.id_item;
                    
                    select a.codigo||' - '||a.nombre as desc_almacen into v_detalle_almacen
                    from alma.tai_almacen a
                    where a.id_almacen = v_rec.id_almacen;
                    
                    RAISE EXCEPTION '%','Error verifique que el item :'||v_detalle_item.det_item||' ,tenga una ubicación asignada en el almacen :'||v_detalle_almacen.desc_almacen;
                
                ELSE
                --el item del almacen tiene 1 ubicacion por lo menos
                    /*
                    1) POR CADA ITEM DELE MOVIMIENTO SE LLAMA A LA FUNCION QUE ACOMODA LOS ITEMS EN LA UBICACION DEL ALMACEN RESPECTIVO(DE ACUERDO AL ORDEN PARAMETRIZADO EN LAS UBICACIONES)
                    */
                    
                    v_res:= alma.f_ai_control_espacio_ubicacion('REG_SALIDAS',v_rec.id_almacen,v_rec.id_item,v_rec.cantidad,NULL);
                    

       			END IF;
      
      END LOOP;    
    
    END;
    
END IF;


RETURN v_res;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;