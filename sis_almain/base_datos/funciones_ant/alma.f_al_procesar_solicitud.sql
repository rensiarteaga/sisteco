QL ---------------

CREATE OR REPLACE FUNCTION alma.f_al_procesar_solicitud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  al_id_solicitud_salida integer,
  al_accion varchar
)
RETURNS varchar AS
$body$
DECLARE
 v_id_almacen				integer;	
 v_det_solicitud			record;
 v_res						varchar;
 v_res_det					record;
 v_max_id_mov				integer;
 v_max_id_sol				integer;
 v_control_cant				record;
 v_codigo					varchar;
 v_descripcion				varchar;
 
 v_id_tipo_mov				integer;
 
 v_proc_cod					record;
 v_cod_res					varchar;
 
 v_cod_ac						varchar;
 
 v_codigo_sol				text;
 
BEGIN

      if (al_accion = 'PROCSOL') THEN
        BEGIN
            select sol.id_almacen,sol.codigo,sol.descripcion into v_id_almacen,v_codigo,v_descripcion
            from alma.tal_solicitud_salida sol
            where sol.id_solicitud_salida = al_id_solicitud_salida;
            
            --id_tipo_movimiento -> se los busca segun el tipo='solicitud'
            select tm.id_tipo_movimiento into v_id_tipo_mov
            from alma.tal_tipo_movimiento tm
            where tm.tipo = 'solicitud';
     		
              --registro de la salida como movimiento 
              --id_tipo_movimiento=2 manejado por defecto 
 			  v_res = "alma"."f_tal_movimiento_iud"(pm_id_usuario,pm_ip_origen,''::text,'AL_MOVI_INS'::varchar,null
              									     ,null,v_id_tipo_mov,v_id_almacen,al_id_solicitud_salida,v_codigo
                                                     ,now()::TIMESTAMP,v_descripcion,'',null,null);
              
              select max(alma.tal_movimiento.id_movimiento) into v_max_id_mov
              from alma.tal_movimiento;
        
	  
      		for v_det_solicitud in (  select det.id_item,det.cantidad as cantidad_solicitada
                                      from alma.tal_solicitud_salida sol
                                      inner join alma.tal_detalle_solicitud det on det.id_solicitud_salida=sol.id_solicitud_salida
                                      left join alma.tal_item it on it.id_item=det.id_item
                                      where sol.id_solicitud_salida=al_id_solicitud_salida
                                      order by det.fecha_reg ASC
                                      )
      		loop
            	v_res = "alma"."f_tal_detalle_movimiento_iud"(pm_id_usuario,pm_ip_origen,''::text,'AL_DETMOV_INS',null
                												,null,v_max_id_mov,v_det_solicitud.id_item,v_det_solicitud.cantidad_solicitada,v_det_solicitud.cantidad_solicitada,'entregado',0,0);
                
            end loop;
            
        END;
      elsif (al_accion = 'FINSOL') then
      	begin
        		--control cantidades_solicitadas y cantidades
                --al_id_solicitud_salida = id_movimiento
                for v_control_cant in (
                                        select det.id_detalle_movimiento,det.cantidad,det.cantidad_solicitada,(det.cantidad_solicitada - det.cantidad) as diferencia,it.id_item,it.codigo
                                        from alma.tal_movimiento mov
                                        inner join alma.tal_detalle_movimiento det on det.id_movimiento=mov.id_movimiento
                                        inner join alma.tal_item it on it.id_item=det.id_item and it.estado='activo'
                                        where mov.id_movimiento = al_id_solicitud_salida	)
                loop
                			if (   (v_control_cant.cantidad > v_control_cant.cantidad_solicitada)	OR	(v_control_cant.diferencia < 0)	)
                            then 
                                                        
                            		raise exception '%','Error, verifique las cantidades de entrega  del movimiento.'||chr(10)||'Cantidad Solicitada: '||v_control_cant.cantidad_solicitada||chr(10)||
                                    					'Cantidad Entregada: '||v_control_cant.cantidad||chr(10)||'Item: '||v_control_cant.id_item||' - '||v_control_cant.codigo;
                            end if;
                end loop;
                
        		--al_id_solicitud_salida = id_movimiento
                /*
                *  1. se agarran los datos relacionados al id_movimiento,id_detalle_movimiento
                *	2. se registra la solicitud con estado_pendiente_entrega
                	2.1 FOR dato del detalle_movimiento -> se registran el detalle de la solicitud con tipo_salpo=por_entregar
                */
                                         
                  select  sal.id_almacen,sal.id_unidad_organizacional,sal.id_empleado,sal.id_aprobador,to_char(sal.fecha_solicitud,'mm/dd/YY') as fecha_solicitud,sal.descripcion  into v_det_solicitud
                  from alma.tal_movimiento mov
                  inner join alma.tal_solicitud_salida sal on sal.id_solicitud_salida=mov.id_solicitud_salida
                  where mov.id_movimiento=al_id_solicitud_salida;
               
                                                            
                  --toda solicitud generada apartir de un movimiento ya tiene generado un codigo de solicitud, por lo solo se debe usar ese codigo de solicitud y no generar otros
                     select mov.codigo/*,mov.nro_actual,mov.nro_siguiente*/ into v_proc_cod
                     from alma.tal_movimiento mov 
                     where mov.id_movimiento=al_id_solicitud_salida;
                    
                  v_codigo_sol = alma.f_al_cod_correlativo(v_proc_cod.codigo); 
                                                              
                                                            
                -- raise exception '%',v_cod_res;
                 select alma.f_tal_solicitud_salida_iud(	pm_id_usuario,pm_ip_origen,''::text,'AL_SOLSAL_INS2',null,null
                  											,v_det_solicitud.id_almacen
                  											,v_det_solicitud.id_unidad_organizacional
                                                            ,v_det_solicitud.id_empleado
                                                            ,v_det_solicitud.id_aprobador
                                                            ,v_det_solicitud.fecha_solicitud::TIMESTAMP
                                                            ,v_det_solicitud.descripcion
                                                            ,v_codigo_sol::varchar
                                                            ) into v_res;               
                                                            
               
                	select max(alma.tal_solicitud_salida.id_solicitud_salida) into v_max_id_sol
              		from alma.tal_solicitud_salida;
                    
                     --toda solicitud generada apartir de un movimiento ya tiene generado un codigo de solicitud, por lo solo se debe usar ese codigo de solicitud y no generar otro
                   
                 	--raise notice '%',v_res;
                    
                  FOR v_det_solicitud IN (	
                                            select  det.id_item,(det.cantidad_solicitada - det.cantidad) as diferencia,
                                                    CASE	
                                                        when (det.cantidad_solicitada - det.cantidad) < 0 THEN '0'
                                                        ELSE 	(det.cantidad_solicitada - det.cantidad) 
                                                    END 	as cantidad_solicitada
                                            from alma.tal_movimiento mov 
                                            inner join alma.tal_detalle_movimiento det on det.id_movimiento=mov.id_movimiento 
                                            where mov.id_movimiento=al_id_solicitud_salida and det.tipo_saldo='por_entregar'	 )
                  LOOP
                  			/*v_res = "alma"."f_tal_detalle_solicitud_iud"(	pm_id_usuario,pm_ip_origen,''::text,'AL_DETSOL_INS2',null,null
                            											,v_max_id_sol
                                                                        ,v_det_solicitud.id_item
                                                                        ,v_det_solicitud.cantidad_solicitada
                            										);*/
                            select alma.f_tal_detalle_solicitud_iud(	pm_id_usuario,pm_ip_origen,''::text,'AL_DETSOL_INS2',null,null
                            											,v_max_id_sol
                                                                        ,v_det_solicitud.id_item
                                                                        ,v_det_solicitud.cantidad_solicitada	) into v_res;
                  END LOOP;
        			--raise notice '%',v_res;
      	end;
      end if;

RETURN v_res;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;
