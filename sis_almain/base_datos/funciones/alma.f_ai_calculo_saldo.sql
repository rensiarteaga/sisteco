--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_ai_calculo_saldo (
  al_id_movimiento integer,
  al_id_solicitud integer,
  al_id_almacen integer,
  al_id_item integer,
  al_procedimiento varchar,
  out al_cantidad_item numeric,
  out al_saldo_item numeric
)
RETURNS record AS
$body$
DECLARE
    saldo		numeric;
    g_registros	record;
    saldo_sol	numeric;
    
    g_rec		record;
BEGIN
	--verificacion de existencia  del almacen e item
   /* if  not exists (select 1 from alma.tai_almacen where alma.tai_almacen.id_almacen=al_id_almacen AND alma.tai_almacen.estado='activo')
    then
    	raise exception '%','No existe el almacen o verifique el estado del almacen'; 
    else
    	if not exists (select 1 from alma.tai_item where alma.tai_item.id_item=al_id_item AND alma.tai_item.estado='activo')
        then
        	raise exception '%','El item no fue registrado o verifique su estado'; 
        end if;
    end if;*/
    --valores registrados de al_procedimiento=['MOVIM','SOLIC']
    IF al_procedimiento = 'MOVIM'
    THEN
    	
            saldo:= 0;
            for g_registros in EXECUTE(	' select al.id_almacen,it.id_item,det_mov.cantidad,tip_mov.tipo
                                          from alma.tai_movimiento mov
                                          inner join alma.tai_detalle_movimiento det_mov on det_mov.id_movimiento=mov.id_movimiento
                                          inner join alma.tai_tipo_movimiento tip_mov on tip_mov.id_tipo_movimiento=mov.id_tipo_movimiento
                                          inner join alma.tai_item it on it.id_item=det_mov.id_item and it.estado=''activo''
                                          inner join alma.tai_almacen al on al.id_almacen=mov.id_almacen and al.estado=''activo''
                                          where mov.estado=''finalizado'' and al.id_almacen='||al_id_almacen||' and it.id_item='||al_id_item||'
                                          order by mov.fecha_movimiento ASC'
                                      )
            loop
            		
                    if(g_registros.tipo = 'ingreso' OR g_registros.tipo = 'transpaso_ingreso' OR g_registros.tipo = 'devolucion') 
                    then 
                            saldo	=	saldo	+	g_registros.cantidad;
                    else
                            saldo	=	saldo 	- 	g_registros.cantidad;
                    end if;
                    
            end loop;
            	al_saldo_item = saldo;
            RETURN ;
 
    ELSIF al_procedimiento = 'SOLIC' THEN
    	
            saldo_sol:=0;
            for g_registros in EXECUTE ('	select sal.id_solicitud_salida,det.id_detalle_solicitud,sal.id_almacen,det.id_item,det.cantidad
                                            from alma.tai_solicitud_salida sal
                                            inner join alma.tai_detalle_solicitud det on det.id_solicitud_salida=sal.id_solicitud_salida
                                            where  sal.estado IN (''pendiente_entrega'', ''proceso_entrega'')  
                                            	and sal.id_almacen='||al_id_almacen||' and det.id_item='||al_id_item||'
                                            order by sal.id_solicitud_salida ASC '
            							)
            loop
            		saldo_sol = saldo_sol 	+	 g_registros.cantidad;
            end loop;
            	al_saldo_item = saldo_sol;
            RETURN ;
    END IF;
EXCEPTION

WHEN others THEN BEGIN
		if al_id_movimiento is NULL then
       		raise exception '%','VERIFIQUE LA EXISTENCIA DE LA SOLICITUD '||al_id_solicitud;   
        else
        	raise exception '%','VERIFIQUE LA EXISTENCIA DEL MOVIMIENTO '||al_id_movimiento;  
        end if;  
END;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;