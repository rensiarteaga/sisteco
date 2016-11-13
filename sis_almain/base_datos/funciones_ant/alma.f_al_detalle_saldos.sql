QL ---------------

CREATE OR REPLACE FUNCTION alma.f_al_detalle_saldos (
  al_id_almacen integer,
  al_id_item integer,
  al_procedimiento varchar,
  al_id_movimiento integer
)
RETURNS varchar AS
$body$
DECLARE
v_rec			record;
v_det_it		record;
v_saldo			numeric;
BEGIN

--detalle del movimiento
select mov.*,tip.tipo  into v_rec
from alma.tal_movimiento mov
inner join alma.tal_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
where mov.id_movimiento = al_id_movimiento;

if al_procedimiento = 'MOVIMIENTO' then
BEGIN
	v_saldo := 0;
	--detalle de los items del movimiento
    FOR v_det_it IN EXECUTE('
    							select mov.id_movimiento,mov.id_almacen,det.id_item,det.cantidad,tip.tipo,det.fecha_reg::date
                                from alma.tal_movimiento mov
                                inner join alma.tal_detalle_movimiento det on det.id_movimiento=mov.id_movimiento
                                inner join alma.tal_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
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

end if;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;
