--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_ai_generar_cod_movimiento (
  al_id_movimiento integer
)
RETURNS text AS
$body$
DECLARE
v_datos_correlativo		record;
v_datos_cod 			record;
v_res					text;
v_id_empresa			integer;
v_correlativo			integer;
v_id_gestion			integer;
v_id_periodo			integer;
v_periodo				numeric;
v_cad_periodo			varchar;

v_aux					integer;
v_cad					varchar;

BEGIN

IF EXISTS(	SELECT 1 
			FROM alma.tai_movimiento mov
          	INNER JOIN alma.tai_almacen al on al.id_almacen=mov.id_almacen and al.estado='activo'
          	INNER JOIN alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
          	INNER JOIN param.tpm_documento doc on doc.id_documento=tip.id_documento
          	INNER JOIN param.tpm_depto depto on depto.id_depto=al.id_depto and depto.estado='activo'
          	WHERE mov.id_movimiento=al_id_movimiento
            )
THEN
          
          --id_empresa,id_gestion
          	SELECT ges.id_gestion,ges.id_empresa into v_id_gestion,v_id_empresa
         	FROM param.tpm_gestion ges
        	WHERE ges.gestion = (	select to_char(now(),'YYYY')::integer	);--quitar la resta
            
            --id_periodo
            select	per.id_periodo into v_id_periodo
            from param.tpm_periodo per
            where per.id_gestion = v_id_gestion and per.periodo =(	select to_char(now(),'mm')::integer	);
          
         
          
          
          SELECT 'ALMA'::varchar as nombre_corto,doc.codigo::varchar as codigo_documento,depto.id_depto INTO v_datos_correlativo
          FROM alma.tai_movimiento mov
          INNER JOIN alma.tai_almacen al on al.id_almacen=mov.id_almacen and al.estado='activo'
          INNER JOIN alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
          INNER JOIN param.tpm_documento doc on doc.id_documento=tip.id_documento
          INNER JOIN param.tpm_depto depto on depto.id_depto=al.id_depto and depto.estado='activo'
          WHERE mov.id_movimiento=al_id_movimiento;
		
			SELECT param.f_pm_get_num_dep_gral(  v_datos_correlativo.nombre_corto
            											 ,v_datos_correlativo.codigo_documento
                                                         ,v_id_periodo
                                                         ,v_id_empresa
                                                         ,v_datos_correlativo.id_depto) INTO v_correlativo;
                                                         
           -- raise notice '%',v_correlativo;
          if v_correlativo > 0
          then
              select trunc(	(log(v_correlativo)+1)	) into v_aux;
              
              if 	v_aux = 1
              then
              		v_cad = '000'||v_correlativo;
              elsif v_aux = 2 then
              		v_cad = '00'||v_correlativo;
              elsif	v_aux = 3 then
              		v_cad = '0'||v_correlativo;
              else
              		v_cad = v_correlativo;
              end if;
          end if;
		
			--raise notice '%',v_cad;
          --periodo dado el id_periodo
          select per.periodo into v_periodo	
          from param.tpm_periodo per
          where per.id_periodo=v_id_periodo;
          
          --se le añade el 0 por delante si tiene solo 1 digito
          if v_periodo < 10 
          then v_cad_periodo='0'||v_periodo;
          else v_cad_periodo=v_periodo; 
          end if;
		
		

          SELECT 'ALMA'::varchar as nombre_corto,al.codigo as codigo_almacen,doc.codigo as codigo_documento INTO v_datos_cod
          FROM alma.tai_movimiento mov
          INNER JOIN alma.tai_almacen al on al.id_almacen=mov.id_almacen and al.estado='activo'
          INNER JOIN alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
          INNER JOIN param.tpm_documento doc on doc.id_documento=tip.id_documento
          INNER JOIN param.tpm_depto depto on depto.id_depto=al.id_depto and depto.estado='activo'
          WHERE mov.id_movimiento=al_id_movimiento;

		  v_res = /*v_datos_cod.nombre_corto||*/v_datos_cod.codigo_almacen||'-'||v_datos_cod.codigo_documento||'-'||v_cad_periodo||v_cad;
          
          if EXISTS(select 1 from alma.tai_movimiento mov where mov.codigo like(v_res))
          then
          		--codigo de movimiento generado -> error
                raise exception '%','Error, El codigo generado :'||v_res||' ya existe, verificar : param.tpm_correlativo_general y alma.tai_movimiento';
          end if;
          
ELSE 
	raise exception '%','Error al generar el codigo del movimiento, verifique que el movimiento a finalizar exista';
END IF;

RETURN v_res;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;