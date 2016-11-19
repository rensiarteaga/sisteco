--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_ai_saldo_fecha (
  al_accion varchar,
  al_id_almacen integer,
  al_id_item integer,
  al_fecha date
)
RETURNS numeric AS
$body$
DECLARE
 v_res 			numeric;
 v_record		record;
BEGIN

	IF al_accion = 'SALDO_ITEM_FECHA' THEN
    	
    	v_res :=0;
    
    	FOR v_record IN EXECUTE('SELECT mov.id_movimiento,tip.tipo,det.cantidad,mov.fecha_finalizacion
                        FROM alma.tai_movimiento mov
                        INNER JOIN alma.tai_detalle_movimiento det on det.id_movimiento=mov.id_movimiento
                        INNER JOIN alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                        WHERE mov.estado=''finalizado'' AND mov.id_almacen='||al_id_almacen||' AND det.id_item='||al_id_item||' AND mov.fecha_finalizacion<'''||al_fecha||' 00:00:00'''||'    
                        ORDER BY mov.fecha_finalizacion ASC;')
        LOOP
        
        		IF(v_record.tipo IN ('ingreso','transpaso_ingreso','devolucion'))
                THEN
                	v_res = v_res + v_record.cantidad;
                ELSE
                	v_res = v_res - v_record.cantidad;
                END IF;
                
        END LOOP;
    	IF v_res < 0 THEN
        	RAISE EXCEPTION '%,%,%','ERROR, verifique los movimientos relacionados con el item '||al_id_item||' en el almacen '||al_id_almacen||' hasta antes de fecha '||al_fecha;
        END IF;
    ELSIF al_accion = 'SALDO_EXISTENCIAS' THEN
    	v_res :=0;
        		
    	FOR v_record IN EXECUTE('SELECT mov.id_movimiento,tip.tipo,det.cantidad,mov.fecha_finalizacion
                        FROM alma.tai_movimiento mov
                        INNER JOIN alma.tai_detalle_movimiento det on det.id_movimiento=mov.id_movimiento
                        INNER JOIN alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                        WHERE mov.estado=''finalizado'' AND mov.id_almacen='||al_id_almacen||' AND det.id_item='||al_id_item||' AND mov.fecha_finalizacion<='''||al_fecha||' 23:59:59'''||'    
                        ORDER BY mov.fecha_finalizacion ASC;')
        LOOP
        
        		IF(v_record.tipo IN ('ingreso','transpaso_ingreso','devolucion'))
                THEN
                	v_res = v_res + v_record.cantidad;
                ELSE
                	v_res = v_res - v_record.cantidad;
                END IF;
                
        END LOOP;        
        
    END IF;
	
    RETURN v_res;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;