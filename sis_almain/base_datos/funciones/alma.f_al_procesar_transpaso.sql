--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_al_procesar_transpaso (
  al_id_movimiento integer,
  pm_id_usuario integer,
  pm_ip_origen varchar
)
RETURNS varchar AS
$body$
DECLARE
g_rec				record; -- variable para almacenar todos los datos del movimiento 
g_cod				text; 	--codigo transpaso		
g_valorizacion		varchar;--'t'-> valorizo correctamento
g_id_tipo_mov		integer;--tipo movimiento  en el almacen destino
g_res				varchar;
g_res1				varchar;
g_det_mov			record;
g_max_id_mov		integer;

BEGIN
 
select mov.* into g_rec
from alma.tal_movimiento mov
where mov.id_movimiento=al_id_movimiento;

/*
*	1 generar el codigo del transpaso -> llamada a la funcion generar codigo
*	2 valoriza la salida en el almacen origen -> llamada a la funcion para valorizar el movimiento
*	3 generar el   ingreso en el almacen destino y su respectivo detalle
*
*/
if g_rec.codigo is NULL
then
	g_cod 	:= 	alma.f_al_generar_cod_movimiento(al_id_movimiento);
else
	g_cod 	:= g_rec.codigo;
end if;

	g_valorizacion = alma.f_al_valorizar_movimiento(al_id_movimiento);
    
if (g_valorizacion != 't')
then
	raise exception 'Error al valorizar el movimiento';
end if;

	--insert en alma.tal_movimiento
	select tip.id_tipo_movimiento into g_id_tipo_mov
    from alma.tal_tipo_movimiento tip
    where tip.tipo='transpaso_ingreso';
    
    update alma.tal_movimiento set codigo=g_cod where id_movimiento=al_id_movimiento;
    

	--llamada a la funcion para insertar un movimiento
    select alma.f_tal_movimiento_iud(	pm_id_usuario,pm_ip_origen,''::text,'AL_MOVI_INS',NULL
    									,NULL,g_id_tipo_mov,g_rec.id_almacen_trans,NULL,NULL
                                        ,now()::timestamp,'Descripcion Transpaso de materiales','Observacion transpaso de materiales',NULL,g_rec.id_movimiento) into g_res;
                                        
                                        
    select max(alma.tal_movimiento.id_movimiento) into g_max_id_mov
    from alma.tal_movimiento;
    
    
	--detalle del movimiento
    FOR g_det_mov IN EXECUTE('	select det.id_movimiento,det.id_item,det.cantidad
                                from alma.tal_detalle_movimiento det
                                where det.id_movimiento = '||al_id_movimiento||'
    						')
  	LOOP
    		g_res1 := alma.f_tal_detalle_movimiento_iud(pm_id_usuario,pm_ip_origen,''::text,'AL_DETMOV_INS',NULL
            											,NULL,g_max_id_mov,g_det_mov.id_item,g_det_mov.cantidad,NULL
                                                        ,'entregado',0,0
                                                        ) ;
  	END LOOP;                          

RETURN 't';
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;