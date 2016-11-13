--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_al_calcular_saldo_movimento (
  al_id_movimiento integer,
  al_id_almacen integer,
  al_id_item integer
)
RETURNS numeric AS
$body$
DECLARE
    saldo		numeric;
    g_registros	record;
BEGIN
	--verificacion de existencia  del almacen e item
    if  not exists (select 1 from alma.tal_almacen where alma.tal_almacen.id_almacen=al_id_almacen AND alma.tal_almacen.estado='activo')
    then
    	raise exception '%','No existe el almacen, para el movimiento o verifique el estado del almacen'; 
    else
    	if not exists (select 1 from alma.tal_item where alma.tal_item.id_item=al_id_item AND alma.tal_item.estado='activo')
        then
        	raise exception '%','El item no fue registrado o puede que el estado del item  haya sido cambiado'; 
        end if;
    end if;
    saldo:= 0;
    --Calculo del saldo para un item en un almacen
    for g_registros in EXECUTE(	' select al.id_almacen,it.id_item,det_mov.cantidad,tip_mov.tipo
                                  from alma.tal_movimiento mov
                                  inner join alma.tal_detalle_movimiento det_mov on det_mov.id_movimiento=mov.id_movimiento
                                  inner join alma.tal_tipo_movimiento tip_mov on tip_mov.id_tipo_movimiento=mov.id_tipo_movimiento
                                  inner join alma.tal_item it on it.id_item=det_mov.id_item and it.estado=''activo''
                                  inner join alma.tal_almacen al on al.id_almacen=mov.id_almacen and al.estado=''activo''
                                  where mov.estado=''finalizado'' and al.id_almacen='||al_id_almacen||' and it.id_item='||al_id_item||'
                                  order by mov.fecha_movimiento ASC'
     						  )
    loop
    		
            if(g_registros.tipo = 'ingreso') 
            then 
            		saldo	=	saldo	+	g_registros.cantidad;
            else
            		saldo	=	saldo 	- 	g_registros.cantidad;
            end if;
    end loop;
	
    RETURN saldo;
EXCEPTION

    WHEN others THEN BEGIN
           raise exception 'ERROR';     
    END;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;