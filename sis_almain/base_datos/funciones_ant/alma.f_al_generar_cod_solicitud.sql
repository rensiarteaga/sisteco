QL ---------------

CREATE OR REPLACE FUNCTION alma.f_al_generar_cod_solicitud (
  al_id_solicitud integer
)
RETURNS text AS
$body$
DECLARE

v_res					text;

v_id_empresa			integer;		--id_empresa  en  param.f_pm_get_num_dep_gral
v_id_gestion			integer;		--id_gestion
v_id_periodo			integer;
v_cod_doc				varchar;
v_id_depto				integer;
v_cod_alm				varchar;
v_periodo				numeric;

v_cad_periodo			varchar;

v_correlativo			integer;

v_aux					integer;
v_cad					varchar;

BEGIN

IF EXISTS(	SELECT 1 
			FROM alma.tal_solicitud_salida sal
            WHERE sal.id_solicitud_salida=al_id_solicitud
            )
THEN
			--id_empresa,id_gestion
          	SELECT ges.id_gestion,ges.id_empresa into v_id_gestion,v_id_empresa
         	FROM param.tpm_gestion ges
        	WHERE ges.gestion = (	select to_char(now(),'YYYY')::integer	)-1;--quitar la resta
            
            --id_periodo
            select	per.id_periodo into v_id_periodo
            from param.tpm_periodo per
            where per.id_gestion = v_id_gestion and per.periodo =(	select to_char(now(),'mm')::integer	);
            
            --cod_documento
            select doc.codigo into v_cod_doc
            from alma.tal_tipo_movimiento tm
            inner join param.tpm_documento doc on doc.id_documento=tm.id_documento
            where tm.tipo='solicitud'
            order by tm.id_tipo_movimiento DESC
            limit 1;
            
            --id_depto,codigo_almacen
            select depto.id_depto,al.codigo into v_id_depto,v_cod_alm
            from alma.tal_solicitud_salida sal
            inner join alma.tal_almacen al on al.id_almacen=sal.id_almacen and al.estado='activo'
            inner join param.tpm_depto depto on depto.id_depto=al.id_depto and depto.estado='activo'
            where  sal.id_solicitud_salida=al_id_solicitud;

		
			SELECT param.f_pm_get_num_dep_gral(  		 'ALMA'
            											 ,v_cod_doc
                                                         ,v_id_periodo
                                                         ,v_id_empresa
                                                         ,v_id_depto) INTO v_correlativo;
                                                         
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
		
		--periodo dado el id_periodo
        select per.periodo into v_periodo	
        from param.tpm_periodo per
        where per.id_periodo=v_id_periodo;
        
        --se le añ el 0 por delante si tiene solo 1 digito
        if v_periodo < 10 
        then v_cad_periodo='0'||v_periodo;
        else v_cad_periodo=''||v_periodo; 
        end if;
		--raise notice '%',v_cad;

		  v_res = v_cod_alm||'-'||v_cod_doc||'-'||v_cad_periodo||v_cad;
          
          if EXISTS(select 1 from alma.tal_solicitud_salida sal where sal.codigo like(v_res))
          then
          		--codigo de movimiento generado -> error
                raise exception '%','Error, El codigo generado:'||v_res||' ya existe, verificar : param.tpm_correlativo_general y alma.tal_solicitud_salida';
          end if;
          
ELSE 
	raise exception '%','Error al generar el codigo de la solicitud, verifique que la solicitud a finalizar exista';
END IF;

RETURN v_res;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;
