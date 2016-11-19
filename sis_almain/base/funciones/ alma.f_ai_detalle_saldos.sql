--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_ai_detalle_saldos (
  al_id_almacen integer,
  al_id_item integer,
  al_procedimiento varchar,
  al_id_movimiento integer
)
RETURNS numeric AS
$body$
DECLARE
v_rec			record;
v_det_it		record;
v_saldo			numeric;

--variables alma.tal_item_valorizacion_pp
v_det_valoriz		record;
v_cant				numeric;
v_costo_unit		numeric;
v_costo_total		numeric;
v_rec_temp			record;
BEGIN
/*
--detalle del movimiento
select mov.*,tip.tipo  into v_rec
from alma.tai_movimiento mov
inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
where mov.id_movimiento = al_id_movimiento;*/

if al_procedimiento = 'MOVIMIENTO' then
BEGIN
	v_saldo := 0;
	--detalle de los items del movimiento
    FOR v_det_it IN EXECUTE('
    							select mov.id_movimiento,mov.id_almacen,det.id_item,det.cantidad,tip.tipo,det.fecha_reg::date
                                from alma.tai_movimiento mov
                                inner join alma.tai_detalle_movimiento det on det.id_movimiento=mov.id_movimiento
                                inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                                where mov.estado = ''finalizado'' AND mov.id_almacen='||al_id_almacen||' AND det.id_item='||al_id_item||'
                                order by det.fecha_reg ASC
    						')
                            loop 
                            
                                if v_det_it.tipo = 'ingreso' OR v_det_it.tipo = 'transpaso_ingreso'
                                then
                                    BEGIN
                                        v_saldo = v_saldo + v_det_it.cantidad;
                                    END;
                                elsif v_det_it.tipo = 'salida' OR  v_det_it.tipo = 'solicitud' OR v_det_it.tipo = 'transpaso_salida'
                                then
                                    BEGIN
                                        v_saldo = v_saldo - v_det_it.cantidad;
                                    END;
                                end if;
           
                            end loop;
END;

elsif al_procedimiento = 'SOLICITUD'
then
BEGIN
END;
elsif al_procedimiento = 'UPD_VALORIZACION' THEN
BEGIN
	--creacion de la tabla temporal donde se guardaran los datos para la valorizacion del item
    EXECUTE('create temp table tt_valorizaciones( 	id_almacen integer
    											 	,id_item integer, cantidad_item numeric
                                                    ,costo_unitario numeric,costo_actualizado numeric) ON COMMIT DROP;');
    
	--datos de la ultima valorizacion de :  al_id_item en al_id_almacen
    if EXISTS (select 1 from alma.tai_item_valoracion_pp val where val.id_almacen=al_id_almacen AND val.id_item=al_id_item)then
    	SELECT val.cantidad,val.costo_unitario,val.costo_valorado,val.id_item_valoracion INTO v_det_valoriz
        FROM alma.tai_item_valoracion_pp val
        WHERE val.id_almacen=al_id_almacen AND val.id_item=al_id_item;
        
        FOR v_rec IN EXECUTE( 'select alm.id_almacen,det.id_item,mov.estado,tip.tipo,det.cantidad,det.costo_unitario,det.fecha_reg,tip.id_tipo_movimiento 
                              from alma.tai_movimiento mov
                              inner join alma.tai_detalle_movimiento det on det.id_movimiento =  mov.id_movimiento
                              inner join alma.tai_almacen alm on alm.id_almacen=mov.id_almacen
                              inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                              where alm.id_almacen='||al_id_almacen|| ' and '||' det.id_item='||al_id_item|| ' and mov.estado=''finalizado''
                              order by mov.fecha_finalizacion ASC'
                        )
        LOOP
            if (v_rec.tipo = 'ingreso' OR v_rec.tipo = 'transpaso_ingreso')
            then
            	if not EXISTS(select 1 from tt_valorizaciones tt where tt.id_almacen=v_rec.id_almacen AND tt.id_item=v_rec.id_item)
                then
                	 EXECUTE('insert into tt_valorizaciones values('||v_rec.id_almacen||','||v_rec.id_item||','||v_rec.cantidad||','||v_rec.costo_unitario||','||v_rec.cantidad*v_rec.costo_unitario||')');
                     --insert into tt_valorizaciones values(v_rec.id_almacen,v_rec.id_item,v_rec.cantidad,v_rec.costo_unitario,(v_rec.cantidad*v_rec.costo_unitario));
                     
                else
                 	 select tt.* into v_rec_temp from tt_valorizaciones tt;
                     v_cant  = v_cant + v_rec_temp.cantidad_item;
                     v_costo_total =  (v_rec_temp.cantidad_item * v_rec_temp.costo_unitario) + (v_rec_temp.costo_actualizado); 	
                     v_costo_unit = round((v_costo_total/v_cant)::numeric,6);
                     
                     EXECUTE('update tt_valorizaciones set  cantidad_item='||v_cant||'
                     										,costo_unitario='||v_costo_unit||'
                                                            ,costo_actualizado='||v_costo_unit||
                     		'where  id_item='||v_rec_temp.id_item);
                     raise notice '%',v_rec_temp.id_almacen;
                end if;
            	
                
               
            end if;
        END LOOP;
        
    else
    	raise exception '%','ERROR, imposible actualizar la valoracion del item en el almacen, el item no fue valorizado antes, en el almacen';
    end if;
     
END;
end if;
		raise notice '%',v_saldo;
		RETURN v_saldo;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;