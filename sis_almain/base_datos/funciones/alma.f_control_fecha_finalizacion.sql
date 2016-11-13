--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_control_fecha_finalizacion (
  al_id_movimiento integer
)
RETURNS boolean AS
$body$
DECLARE
  v_mov				record;
  res				boolean;
  v_max_fecha		date;
  v_cant			integer;
  v_solic			record;
BEGIN
res:=true;
--datos del  movimiento
select mov.*,tip.tipo,tip.requiere_aprobacion into v_mov
from alma.tai_movimiento mov
inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
where mov.id_movimiento=al_id_movimiento;

--control de fecha de una salida normal(sin solicitud)
if v_mov.id_solicitud_salida is NULL 	THEN
  BEGIN
      if (v_mov.tipo='ingreso')  then
        BEGIN
        	if v_mov.requiere_aprobacion='si' 
            then
              	select max(mov.fecha_movimiento)::date into v_max_fecha
                from alma.tai_movimiento mov
                inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                where mov.estado in ('pendiente_aprobacion') AND tip.tipo='ingreso' AND mov.id_almacen=v_mov.id_almacen;
                
                if (v_max_fecha IS NOT NULL) AND (v_max_fecha > v_mov.fecha_movimiento)
                then
                	--error fecha movimiento < fecha del ultimo movimiento pendiente de aprobacion
                    select count(mov.id_movimiento) into v_cant
                    from alma.tai_movimiento mov
                    inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                    where mov.estado in ('pendiente_aprobacion') AND v_max_fecha <= mov.fecha_movimiento AND (tip.tipo='ingreso' OR tip.tipo='transpaso_ingreso' ) AND mov.id_almacen=v_mov.id_almacen ;
                    raise exception '%','Se tiene '||v_cant||' movimientos, pendientes de aprobacion. Verifique las fechas de los movimientos.';
                	--raise notice 'AAAA';
                end if;
                res:=false;
                
            else
            	select max(mov.fecha_finalizacion)::date into v_max_fecha
                from alma.tai_movimiento mov
                inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                where mov.estado in ('finalizado') AND tip.tipo='ingreso' AND mov.id_almacen=v_mov.id_almacen;
                if (v_max_fecha IS NOT NULL) AND (v_max_fecha >  v_mov.fecha_movimiento)
                then
                	--el movimiento de ingreso a finalizar tiene un fecha anterior a la fecha del ultimo movimiento finalizado
                	raise exception '%','Verifique la fecha del movimiento a finalizar.'||chr(10)||'Fecha movimiento :'||v_mov.fecha_movimiento||chr(10)||'Fecha Ultimo Movimiento Finalizado:'||v_max_fecha;
                end if;
                res:=false;
            end if;
                
        END;
      --transpaso_ingreso
      elsif v_mov.tipo='transpaso_ingreso' then
      BEGIN
      	if v_mov.requiere_aprobacion='si' 
        then
              	select max(mov.fecha_movimiento)::date into v_max_fecha
                from alma.tai_movimiento mov
                inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                where mov.estado in ('pendiente_aprobacion') AND tip.tipo='transpaso_ingreso' AND mov.id_almacen=v_mov.id_almacen;
                
                if (v_max_fecha IS NOT NULL) AND (v_max_fecha > v_mov.fecha_movimiento)
                then
                	--error fecha movimiento < fecha del ultimo movimiento pendiente de aprobacion
                    select count(mov.id_movimiento) into v_cant
                    from alma.tai_movimiento mov
                    inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                    where mov.estado in ('pendiente_aprobacion') AND v_max_fecha <= mov.fecha_movimiento AND tip.tipo='transpaso_ingreso' AND mov.id_almacen=v_mov.id_almacen ;
                    raise exception '%','Se tiene '||v_cant||' movimientos, pendientes de aprobacion. Verifique las fechas de los movimientos.';
                	--raise notice 'AAAA';
                end if;
                res:=false;
                
        else
            	select max(mov.fecha_finalizacion)::date into v_max_fecha
                from alma.tai_movimiento mov
                inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                where mov.estado in ('finalizado') AND tip.tipo='transpaso_ingreso' AND mov.id_almacen=v_mov.id_almacen;
                if (v_max_fecha IS NOT NULL) AND (v_max_fecha >  v_mov.fecha_movimiento)
                then
                	--el movimiento de transpaso_ingreso a finalizar tiene un fecha anterior a la fecha del ultimo transpaso_ingreso finalizado
                	raise exception '%','Verifique la fecha del movimiento a finalizar.'||chr(10)||'Fecha movimiento :'||v_mov.fecha_movimiento||chr(10)||'Fecha Ultimo Movimiento Finalizado:'||v_max_fecha;
                end if;
                res:=false;
        end if;
      END;
      
      --transpaso_salida
      elsif v_mov.tipo='transpaso_salida' then
      BEGIN
        if v_mov.requiere_aprobacion='si'
              then
                  select max(mov.fecha_movimiento)::date into v_max_fecha
                  from alma.tai_movimiento mov
                  inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                  where mov.estado in ('pendiente_aprobacion') AND tip.tipo='transpaso_salida' AND mov.id_almacen=v_mov.id_almacen ;
                  
                  if (v_max_fecha IS NOT NULL) AND (v_max_fecha > v_mov.fecha_movimiento)
                  then
                      --error la fecha de salida del movimiento es mayor a las fecha de salida pendientes de aprobacion del sistema
                      select count(mov.id_movimiento) into v_cant
                      from alma.tai_movimiento mov
                      inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                      where mov.estado in ('pendiente_aprobacion') AND v_max_fecha <= mov.fecha_movimiento  AND tip.tipo='transpaso_salida' AND mov.id_almacen=v_mov.id_almacen;
                      raise exception '%','Se tiene '||v_cant||' movimientos (salidas) ,pendientes de aprobacion. Verifique las fechas de los movimientos.';
                  end if;
                  res:=false;
              else
                  --mov salida sin aprobacion
                  select max(mov.fecha_finalizacion)::date into v_max_fecha
                  from alma.tai_movimiento mov
                  inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                  where mov.estado in ('finalizado') AND tip.tipo='transpaso_salida' AND mov.id_almacen=v_mov.id_almacen;
                  
                  if (v_max_fecha IS NOT NULL) AND (v_max_fecha > v_mov.fecha_movimiento)
                  then
                      --el movimiento de salida a finalizar tiene un fecha anterior a la fecha del ultimo movimiento(salida) finalizado
                      raise exception '%','Verifique la fecha de finalizacion deL transpaso de salida. El ultimo transpaso de salida en el almacen fue registrado en fecha: '||v_max_fecha||chr(10)||
                                      'Fecha Movimiento: '||v_mov.fecha_movimiento;
                  end if;
                  res:=false;
          
              end if;
      END;
      
      --salida
      elsif v_mov.tipo='salida' then
      BEGIN
        	if v_mov.requiere_aprobacion='si'
            then
            	select max(mov.fecha_movimiento)::date into v_max_fecha
                from alma.tai_movimiento mov
                inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                where mov.estado in ('pendiente_aprobacion') AND tip.tipo='salida' AND mov.id_almacen=v_mov.id_almacen ;
                
                if (v_max_fecha IS NOT NULL) AND (v_max_fecha > v_mov.fecha_movimiento)
                then
                	--error la fecha de salida del movimiento es mayor a las fecha de salida pendientes de aprobacion del sistema
                    select count(mov.id_movimiento) into v_cant
                    from alma.tai_movimiento mov
                    inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                    where mov.estado in ('pendiente_aprobacion') AND v_max_fecha <= mov.fecha_movimiento  AND tip.tipo='salida' AND mov.id_almacen=v_mov.id_almacen;
                    raise exception '%','Se tiene '||v_cant||' movimientos (salidas) ,pendientes de aprobacion. Verifique las fechas de los movimientos.';
                end if;
                res:=false;
            else
            	--mov salida sin aprobacion
                select max(mov.fecha_finalizacion)::date into v_max_fecha
                from alma.tai_movimiento mov
                inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                where mov.estado in ('finalizado') AND tip.tipo='salida' AND mov.id_almacen=v_mov.id_almacen;
                
                if (v_max_fecha IS NOT NULL) AND (v_max_fecha > v_mov.fecha_movimiento)
                then
                	--el movimiento de salida a finalizar tiene un fecha anterior a la fecha del ultimo movimiento(salida) finalizado
                	raise exception '%','Verifique la fecha de finalizacion de la salida. La ultima  salida en el almacen fue registrado en fecha: '||v_max_fecha||chr(10)||
                    				'Fecha Movimiento: '||v_mov.fecha_movimiento;
                end if;
                res:=false;
        
            end if;
      END;  
  end if;
  END;
else
	if  v_mov.tipo='solicitud' then
    BEGIN
    	--movimentos generados a partir de solicitudes de salida
        select max(mov.fecha_movimiento)::date into v_max_fecha
        from alma.tai_movimiento mov
        inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
        where mov.estado in ('finalizado') AND /*tip.tipo='salida' AND*/ mov.id_almacen=v_mov.id_almacen AND mov.id_solicitud_salida IS NOT NULL ;
        
        if (v_max_fecha IS NOT NULL) AND (v_max_fecha > v_mov.fecha_movimiento)
        then
        	raise exception '%','La fecha de la solicitud de salida a ser entregada, tiene una fecha de registro anterior a la ultima fecha de salida ('||v_max_fecha||')';
        end if;
        res:=false;  
    END;
    end if;
end if;
 return res;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;