--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_ai_detalle_procesos (
  al_id_almacen integer,
  al_procedimiento varchar
)
RETURNS varchar AS
$body$
/*
*	funcion que detalle el proceso de valoracion de todos los items de un almacen, baso en la fecha de finalizacion del movimiento finalizado
*	la tabla donde se registran los datos de la valoracion del item estan en alma.tal_valoracion_tmp
*	para validar estos item, se los debe comparar con los datos de la tabla alma.tal_item_valoracion_pp
*/


DECLARE
v_registros		record;
v_items			record;
v_det_mov		record;
v_total_items	numeric;
v_costo_item	numeric;
v_costo_act		numeric;
v_id_val		integer;
v_datos_val		record;

v_aux			boolean;
v_id_item		integer;
v_id_tem_ant	integer;
v_det_it		record;
v_saldo			numeric;
v_res		    varchar;
v_valor1		record;
v_valor2		record;


BEGIN

if al_procedimiento = 'VALORIZACION' then
BEGIN
	DELETE FROM alma.tai_valoracion_tmp;
    ALTER SEQUENCE alma.tai_valoracion_tmp_id_valoracion_temp_seq restart 1;
    
    for v_items in (	select  det.id_item
                        from alma.tai_movimiento mov
                        inner join alma.tai_detalle_movimiento det on det.id_movimiento = mov.id_movimiento
                        inner join alma.tai_almacen alm on alm.id_almacen = mov.id_almacen
                        inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento = mov.id_tipo_movimiento
                        where mov.estado = 'finalizado' and alm.id_almacen = al_id_almacen
                        group by det.id_item
                        order by det.id_item ASC	)	
    loop
   		v_total_items = 0;
        v_costo_item = 0;
        v_costo_act = 0	;	
    
    	FOR v_det_mov in EXECUTE('select  det.id_item,mov.id_almacen,tip.tipo,det.cantidad,det.costo_unitario,det.costo_total,mov.id_movimiento,det.id_detalle_movimiento,mov.fecha_finalizacion,count(mov.id_movimiento) as aux
                                  from alma.tai_movimiento mov
                                  inner join alma.tai_detalle_movimiento det on det.id_movimiento=mov.id_movimiento
                                  inner join alma.tai_almacen alm on alm.id_almacen=mov.id_almacen
                                  inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                                  where mov.estado=''finalizado'' and alm.id_almacen='||al_id_almacen||' and det.id_item='||v_items.id_item||'
                                  group by det.id_item,mov.id_almacen,tip.tipo,det.cantidad,det.costo_unitario,det.costo_total,mov.id_movimiento,det.id_detalle_movimiento,mov.fecha_finalizacion
                                  order by mov.fecha_finalizacion ASC')
        loop
        			if not EXISTS(select 1 from alma.tai_valoracion_tmp v where v.id_item=v_det_mov.id_item)then
                    /*
                    	   --if v_det_mov.tipo='ingreso' OR v_det_mov.tipo='transpaso_ingreso' then
                           v_total_items = v_total_items + v_det_mov.cantidad;
                           -- v_costo_act = v_costo_act + v_det_mov.costo_total;
                           v_costo_act = v_costo_act +	(v_det_mov.cantidad * v_det_mov.costo_unitario);
                           v_costo_item = round((v_costo_act/v_total_items)::numeric,6);
                           */
                    
                    			INSERT INTO alma.tai_valoracion_tmp(id_almacen,			id_item,		tipo_movimiento
                                									,cantidad_item,		costo_unitario_item,	costo_item
                                                                    ,cantidad_total 	,costo_unitario_act  ,costo_act
                                                                    ,id_movimiento,		id_detalle_movimiento,	fecha_fin_mov)
                                VALUES(v_det_mov.id_almacen         ,v_det_mov.id_item						,v_det_mov.tipo
                                		,v_det_mov.cantidad			,v_det_mov.costo_unitario				,v_det_mov.costo_total
                                        ,v_det_mov.cantidad			,v_det_mov.costo_unitario				,v_det_mov.costo_total
                                        ,v_det_mov.id_movimiento	,v_det_mov.id_detalle_movimiento		,v_det_mov.fecha_finalizacion	);
                       -- end if;
                        
                    	
                    else
                            select max(v.id_valoracion_temp) into v_id_val
                            from alma.tai_valoracion_tmp v;
                            
                            select  val.* into v_datos_val
                            from alma.tai_valoracion_tmp val
                            where val.id_valoracion_temp = v_id_val;
                            
                    	if v_det_mov.tipo = 'ingreso'  OR v_det_mov.tipo = 'transpaso_ingreso' OR v_det_mov.tipo = 'devolucion' then
                        
                        	v_total_items = v_datos_val.cantidad_total + v_det_mov.cantidad;
                            v_costo_act = v_datos_val.costo_act + v_det_mov.costo_total;
                            v_costo_item = round((v_costo_act/v_total_items)::numeric,6);
                            
                            INSERT INTO alma.tai_valoracion_tmp(id_almacen,		id_item,		tipo_movimiento
                                									,cantidad_item,		costo_unitario_item,	costo_item
                                                                    ,cantidad_total ,costo_unitario_act  ,costo_act
                                                                    ,id_movimiento,	id_detalle_movimiento,	fecha_fin_mov)
                            VALUES(		v_det_mov.id_almacen,			v_det_mov.id_item		,v_det_mov.tipo
                            			,v_det_mov.cantidad			,v_det_mov.costo_unitario	,v_det_mov.costo_total
                                		,v_total_items				,v_costo_item				,v_costo_act
                                        ,v_det_mov.id_movimiento	,v_det_mov.id_detalle_movimiento		,v_det_mov.fecha_finalizacion	);
                           
                                        
                        elsif (v_det_mov.tipo = 'transpaso_salida' OR v_det_mov.tipo = 'salida' OR v_det_mov.tipo = 'solicitud') then
                        
                        	v_total_items =  v_datos_val.cantidad_total - v_det_mov.cantidad ;
                            --v_costo_item = round((v_costo_act/v_total_items)::numeric,6);
                            v_costo_item = v_datos_val.costo_unitario_act;
                            v_costo_act =round((v_total_items * v_costo_item)::numeric,6); 
                            
                            INSERT INTO alma.tai_valoracion_tmp(id_almacen,		id_item,		tipo_movimiento
                                									,cantidad_item,		costo_unitario_item,	costo_item
                                                                    ,cantidad_total ,costo_unitario_act  ,costo_act
                                                                    ,id_movimiento,	id_detalle_movimiento,	fecha_fin_mov)
                            VALUES(		v_det_mov.id_almacen        ,v_det_mov.id_item			,v_det_mov.tipo
                            			,v_det_mov.cantidad			,v_det_mov.costo_unitario	,v_det_mov.costo_total
                                		,v_total_items				,v_costo_item				,v_costo_act
                                        ,v_det_mov.id_movimiento	,v_det_mov.id_detalle_movimiento		,v_det_mov.fecha_finalizacion	);
                            
                        end if;
                            
                    end if;
        end loop;
    
    end loop;   
END;


elsif al_procedimiento = 'UPD_COSTOS_ITEMS' then
BEGIN
	FOR v_registros IN (	select det.id_detalle_movimiento,tip.tipo,det.cantidad,det.costo_unitario,det.costo_total 
                            from alma.tai_movimiento mov
                            inner join alma.tai_detalle_movimiento det on det.id_movimiento=mov.id_movimiento
                            inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                            where mov.id_almacen = al_id_almacen and mov.estado='finalizado'
                            )
    loop
    	if (v_registros.tipo = 'ingreso'  AND v_registros.cantidad > 0 AND v_registros.costo_unitario > 0 )
        then 
        	UPDATE alma.tai_detalle_movimiento
            SET costo_total = (v_registros.cantidad * v_registros.costo_unitario)
            WHERE alma.tai_detalle_movimiento.id_detalle_movimiento = v_registros.id_detalle_movimiento;
        end if;
    end loop;
END;

--procedimiento que permite actualizar la tabla alma.tai_item_valoracion_pp
ELSIF al_procedimiento = 'VAL_MOV_GRUP' THEN
BEGIN
			/*DELETE FROM alma.tai_item_valoracion_pp WHERE id_almacen = al_id_almacen;
			SELECT alma.f_al_detalle_procesos(al_id_almacen,'VALORIZACION') INTO v_res;
	
             for v_items in (	select  det.id_item
                        from alma.tai_movimiento mov
                        inner join alma.tai_detalle_movimiento det on det.id_movimiento = mov.id_movimiento
                        inner join alma.tai_almacen alm on alm.id_almacen = mov.id_almacen
                        inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento = mov.id_tipo_movimiento
                        where mov.estado = 'finalizado' and alm.id_almacen = al_id_almacen
                        group by det.id_item
                        order by det.id_item ASC	)	
            loop
                  
              FOR v_det_mov in EXECUTE('select  det.id_item,mov.id_almacen,tip.tipo,det.cantidad,det.costo_unitario,det.costo_total,mov.id_movimiento,det.id_detalle_movimiento,mov.fecha_finalizacion,count(mov.id_movimiento) as aux
                                        from alma.tai_movimiento mov
                                        inner join alma.tai_detalle_movimiento det on det.id_movimiento=mov.id_movimiento
                                        inner join alma.tai_almacen alm on alm.id_almacen=mov.id_almacen
                                        inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                                        where mov.estado=''finalizado'' and alm.id_almacen='||al_id_almacen||' and det.id_item='||v_items.id_item||'
                                        group by det.id_item,mov.id_almacen,tip.tipo,det.cantidad,det.costo_unitario,det.costo_total,mov.id_movimiento,det.id_detalle_movimiento,mov.fecha_finalizacion
                                        order by mov.fecha_finalizacion ASC')
              LOOP
              			
                        --seleccion del ultimo registro valorado en alma.tai_valoracion_tpm de acuerdo a id_almacen e id_item
                        SELECT a.cantidad_total,a.costo_unitario_act,a.costo_act INTO v_valor1
                        FROM alma.tai_valoracion_tmp a
                        WHERE a.id_almacen=al_id_almacen AND a.id_item=v_det_mov.id_item
                        ORDER BY a.fecha_fin_mov DESC
                        LIMIT 1;
              
              			if EXISTS(SELECT 1 FROM alma.tai_item_valoracion_pp a WHERE a.id_almacen=al_id_almacen AND a.id_item=v_det_mov.id_item) then
                        	
                        		select b.cantidad,b.costo_unitario,b.costo_valorado INTO v_valor2
                                from alma.tai_item_valoracion_pp b
                                where b.id_almacen = al_id_almacen AND b.id_item = v_det_mov.id_item;
                                
                                if (		v_valor1.cantidad_total != v_valor2.cantidad
                                	 AND 	v_valor1.costo_unitario_act != v_valor2.costo_unitario
                                     AND	v_valor1.costo_act != v_valor2.costo_valorado
                                	) then
                                    	
                                    	DELETE FROM alma.tai_item_valoracion_pp WHERE id_almacen = al_id_almacen AND id_item = v_det_mov.id_item;
                                    	
                                end if;
                        	
                        end if;
              
              END LOOP;
           
        end loop;*/
        
        FOR v_registros in (  select DISTINCT mov.id_movimiento,mov.fecha_finalizacion
                              from alma.tai_movimiento mov
                              inner join alma.tai_detalle_movimiento det on det.id_movimiento = mov.id_movimiento
                              inner join alma.tai_almacen alm on alm.id_almacen = mov.id_almacen
                              inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento = mov.id_tipo_movimiento
                              where mov.estado = 'finalizado' and alm.id_almacen = al_id_almacen
                              --group by det.id_item, mov.id_movimiento
                               order by mov.fecha_finalizacion,mov.id_movimiento ASC	)	
        LOOP
        	raise notice '%',v_registros.id_movimiento; 
        	SELECT alma.f_ai_valorizar_movimiento(v_registros.id_movimiento) INTO v_res;
        END LOOP;
		
END;

end if;

return  null;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;