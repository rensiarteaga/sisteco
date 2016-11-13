QL ---------------

CREATE OR REPLACE FUNCTION alma.f_tal_solicitud_salida_sel (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  pm_cant integer,
  pm_puntero integer,
  pm_sortcol varchar,
  pm_sortdir varchar,
  pm_criterio_filtro varchar,
  pm_id_financiador varchar,
  pm_id_regional varchar,
  pm_id_programa varchar,
  pm_id_proyecto varchar,
  pm_id_actividad varchar
)
RETURNS SETOF record AS
$body$
/************************************************************************** SISTEMA ENDESIS - SISTEMA DE ALMACEN
***************************************************************************
 SCRIPT:          alma.f_tal_solicitud_salida_sel
 DESCRIPCIÃ???N:     Devuelve las consultas a la tabla train.tal_solicitud_salida
 AUTOR:           Ariel ayaviri Omonte
 FECHA:           11-09-2013 10:55:00
 COMENTARIOS:    

***************************************************************************/
--------------------------
-- CUERPO DE LA FUNCIÃ???N --
--------------------------

-- PARÃ??Ã?ÃMETROS FIJOS
/*
pm_id_usuario                               integer (si))
pm_ip_origen                                varchar(40) (si)
pm_mac_maquina                              macaddr (si)
pm_log_error                                varchar -- log -- error //variable interna (si)
pm_codigo_procedimiento                     varchar  // valor que identifica el tipo
                                                        de operacion a realizar
                                                        insert  (insertar)
                                                        delete  (eliminar)
                                                        update  (actualizar)
                                                        select  (visualizar)
pm_proc_almacenado                          varchar  // para colocar el nombre del procedimiento en caso de ser llamado
                                                        por otro procedimiento
pm_cant
pm_puntero
pm_sortcol
pm_sortdir
pm_criterio_filtro
pm_id_financiador
pm_id_regional
pm_id_programa
pm_id_proyecto
pm_id_actividad

*/

-- DECLARACIÃ???N DE VARIABLES PARTICULARES


-- DECLARACIÃ???N DE VARIABLES DE LA FUNCIÃ???N (LOCALES)

DECLARE

  --PARÃ??Ã?ÃMETROS FIJOS
  g_id_subsistema integer; -- ID SUBSISTEMA
  g_id_lugar integer; -- ID LUGAR
  g_numero_error varchar; -- ALMACENA EL NÃ???MERO DE ERROR
  g_mensaje_error varchar; -- ALMACENA MENSAJE DEL ERROR

  g_privilegio_procedimiento boolean;
  -- BANDERA PARA VERIFICAR LLAMADA DE PROCEDIMIENTO
  g_privilegio_procedimiento_administrador_cobra boolean;
  --BANDERA PARA VERIFICAR LLAMADA DE PROCEDIMIENTO
  g_privilegio_procedimiento_resp_dist boolean;
  -- BANDERA PARA VERIFICAR LLAMADA DE PROCEDIMIENTO
  g_privilegio_procedimiento_resp_sis_dist boolean;
  -- BANDERA PARA VERIFICAR LLAMADA DE PROCEDIMIENTO
  g_privilegio_procedimiento_resp_entifin boolean;
  -- BANDERA PARA VERIFICAR LLAMADA DE PROCEDIMIENTO
  g_privilegio_procedimiento_supervisor_sucursal boolean;
  -- BANDERA PARA VERIFICAR LLAMADA DE PROCEDIMIENTO
  g_privilegio_procedimiento_supervisor_agencia boolean;
  -- BANDERA PARA VERIFICAR LLAMADA DE PROCEDIMIENTO
  g_privilegio_procedimiento_cajero boolean;
  -- BANDERA PARA VERIFICAR LLAMADA DE PROCEDIMIENTO

  g_descripcion_log_error text; -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
  g_reg_evento boolean;
  g_reg_error boolean;
  g_registros record;
  -- PARA ALMACENAR EL CONJUNTO DE DATOS RESULTADO DEL SELECT
  g_respuesta varchar; -- VARIABLE QUE CONTENDRÃ??Ã?Ã LOS MENSAJES DE ERROR
  g_consulta text; -- VARIABLE QUE CONTENDRÃ??Ã?Ã LA CONSULTA DINÃ??Ã?ÃMICA PARA EL FILTRO
  g_nivel_error varchar; -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
  --      ERROR DE SINTAXIS (cuando llega a exception) = 1
  --      ERROR LÃ???GICO (CRÃ??Ã?ÃTICO) = 2
  --      ERROR LÃ???GICO (INTERMEDIO) = 3
  --      ERROR LÃ???GICO (ADVERTENCIA) = 4
  g_nombre_funcion varchar; --NOMBRE FÃ??Ã?ÃSICO DE LA FUNCIÃ???N
  g_separador varchar(10);
  --Caracteres que servirÃ??Ã?Ã¡n para separar el mensaje, nivel y origen del error
  g_rol_adm boolean; -- Identifica si el usuario tiene rol administrador

  g_id_usuario_rol integer;
  g_id_regional integer;
  g_id_solicitud_salida integer;
  g_where varchar;
  g_id_rol_admin_cobra integer;
  
BEGIN

  ---*** INICIACIÃ???N DE VARIABLES
  g_privilegio_procedimiento := FALSE;
  g_separador = '#@@@#'; --Separador para mensajes devueltos por la funciÃ??Ã?Ã³n
  g_nombre_funcion :='f_tal_solicitud_salida_sel';
  g_rol_adm:= false;
  ---*** VERIFICACIÃ???N ROL ADMINISTRADOR

  IF EXISTS(
    SELECT 1
    FROM sss.tsg_usuario_rol usrol
    WHERE usrol.id_usuario = pm_id_usuario AND
          usrol.id_rol = 1) THEN
    g_rol_adm := true;
  END IF;

  ---*** OBTENCIÃ???N DEL ID DEL SUBSISTEMA

  SELECT id_subsistema
  INTO g_id_subsistema
  FROM sss.tsg_procedimiento_db
  WHERE codigo_procedimiento = pm_codigo_procedimiento;

  ---*** OBTENCIÃ???N DEL ID DEL LUGAR ASIGNADO AL USUARIO

  SELECT ul.id_lugar
  INTO g_id_lugar
  FROM sss.tsg_usuario_lugar ul
  WHERE ul.id_usuario = pm_id_usuario;

  ---*** VALIDACIÃ???N DE LLAMADA POR USUARIO O FUNCIÃ???N
  IF pm_proc_almacenado IS NOT NULL THEN
    IF NOT EXISTS(
      SELECT 1
      FROM pg_proc
      WHERE proname = pm_proc_almacenado) THEN
      g_descripcion_log_error := 'Procedimiento ejecutor inexistente';
      g_nivel_error := '2';
      g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error,
        g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

      --REGISTRA EL LOG
      g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario            ,
        g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
        pm_ip_origen              ,pm_mac_maquina            ,'error'
          ,NULL,
        pm_codigo_procedimiento   ,pm_proc_almacenado);
      --DEVUELVE MENSAJE DE ERROR
      RAISE EXCEPTION '%', g_respuesta;
      ELSE
      g_privilegio_procedimiento := TRUE;
    END IF;
  END IF;

  ---*** VERIFICACIÃ???N DE PERMISOS DEL USUARIO
  IF NOT g_privilegio_procedimiento THEN
    g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(
      pm_id_usuario,pm_codigo_procedimiento,NULL);
  END IF;
  IF NOT g_privilegio_procedimiento_administrador_cobra THEN
    g_privilegio_procedimiento_administrador_cobra :=
      sss.f_sg_validacion_administrador_cobra(pm_id_usuario);
  END IF;
  IF NOT g_privilegio_procedimiento_resp_dist THEN
    g_privilegio_procedimiento_resp_dist := sss.f_sg_validacion_resp_dist_cobra(
      pm_id_usuario);
  END IF;
  IF NOT g_privilegio_procedimiento_resp_sis_dist THEN
    g_privilegio_procedimiento_resp_sis_dist :=
      sss.f_sg_validacion_resp_sis_dist_cobra(pm_id_usuario);
  END IF;
  IF NOT g_privilegio_procedimiento_resp_entifin THEN
    g_privilegio_procedimiento_resp_entifin :=
      sss.f_sg_validacion_resp_enti_fin_cobra(pm_id_usuario);
  END IF;
  IF NOT g_privilegio_procedimiento_supervisor_sucursal THEN
    g_privilegio_procedimiento_supervisor_sucursal :=
      sss.f_sg_validacion_supervisor_sucursal_cobra(pm_id_usuario);
  END IF;
  IF NOT g_privilegio_procedimiento_supervisor_agencia THEN
    g_privilegio_procedimiento_supervisor_agencia :=
      sss.f_sg_validacion_supervisor_agencia_cobra(pm_id_usuario);
  END IF;
  IF NOT g_privilegio_procedimiento_cajero THEN
    g_privilegio_procedimiento_cajero := sss.f_sg_validacion_cajero_cobra(
      pm_id_usuario);
  END IF;

  ---*** SI NO SE TIENE PERMISOS DE EJECUCIÃ???N SE RETORNA EL MENSAJE DE ERROR
  --IF NOT g_privilegio_procedimiento THEN
  IF NOT (g_privilegio_procedimiento OR
    g_privilegio_procedimiento_administrador_cobra OR
    g_privilegio_procedimiento_resp_entifin) THEN

    g_nivel_error := '3';
    g_descripcion_log_error :=
      'El usuario no tiene permisos de ejecuciÃ??Ã?Ã³n del procedimiento';
    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error,
      g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

    --REGISTRA EL LOG
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,
      g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
      pm_ip_origen              ,pm_mac_maquina            ,'error'            ,
        NULL,
      pm_codigo_procedimiento   ,pm_proc_almacenado);
    --DEVUELVE MENSAJE DE ERROR
    RAISE EXCEPTION '%',g_descripcion_log_error;
  END IF;

  ---***SELECCIÃ???N DE OPERACIÃ???N A REALIZAR
  IF pm_codigo_procedimiento  = 'AL_SOLSAL_SEL' THEN
    BEGIN
		
      g_consulta := 'SELECT
                                COALESCE(to_char(sol.fecha_reg,''dd-mm-yyyy HH:MI:SS am''),''0'') AS fecha_reg,
                                sol.usuario_reg,
                                sol.id_solicitud_salida,
                                sol.id_almacen,
                                sol.id_unidad_organizacional,
                                uo.nombre_unidad as uo_empleado,
                                sol.id_empleado,
                                COALESCE(peremp.nombre||'' ''||peremp.apellido_paterno||'' ''||peremp.apellido_materno,'' '') as nombre_empleado,
                                sol.cargo_empleado,
                                sol.id_aprobador,
                                uo2.nombre_unidad as uo_aprobador,
                                COALESCE(peremp2.nombre||'' ''||peremp2.apellido_paterno||'' ''||peremp2.apellido_materno,'' '') as nombre_aprobador,
                                COALESCE(to_char(sol.fecha_solicitud,''dd-mm-yyyy HH:MI:SS am''),''0'') AS fecha_solicitud,
                                sol.descripcion,
                                sol.estado,sol.codigo
							FROM alma.tal_solicitud_salida sol
        					LEFT JOIN kard.tkp_unidad_organizacional uo ON uo.id_unidad_organizacional = sol.id_unidad_organizacional
                            LEFT JOIN kard.tkp_empleado emp ON emp.id_empleado = sol.id_empleado
                            LEFT JOIN sss.tsg_persona peremp ON peremp.id_persona = emp.id_persona
                            LEFT JOIN param.tpm_config_aprobador apr ON apr.id_config_aprobador = sol.id_aprobador
                            LEFT JOIN kard.tkp_unidad_organizacional uo2 ON uo2.id_unidad_organizacional = apr.id_uo
                            LEFT JOIN kard.tkp_empleado emp2 ON emp2.id_empleado = apr.id_empleado
                            LEFT JOIN sss.tsg_persona peremp2 ON peremp2.id_persona = emp2.id_persona
                            WHERE ';
      
      g_consulta := g_consulta || pm_criterio_filtro;
      -- SE AUMENTA EL ORDEN Y LOS PARÃ??Ã?ÃMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
      g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
      g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' ||
        pm_puntero;

      FOR g_registros in      EXECUTE (g_consulta)
      LOOP
        RETURN NEXT g_registros;
      END LOOP;

      -- DESCRIPCIÃ???N DE Ã???XITO PARA GUARDAR EN EL LOG
      g_descripcion_log_error := 'Consulta ejecutada';
    END;

    -- PARA LA CONSULTA DE CONTEO  
    ELSIF pm_codigo_procedimiento  = 'AL_SOLSAL_COUNT' THEN

    BEGIN
      --Cuenta todos los registros
      g_consulta :=     '	SELECT count(sol.id_solicitud_salida) as total
                          	FROM alma.tal_solicitud_salida sol
        					LEFT JOIN kard.tkp_unidad_organizacional uo ON uo.id_unidad_organizacional = sol.id_unidad_organizacional
                            LEFT JOIN kard.tkp_empleado emp ON emp.id_empleado = sol.id_empleado
                            LEFT JOIN sss.tsg_persona peremp ON peremp.id_persona = emp.id_persona
                            LEFT JOIN param.tpm_config_aprobador apr ON apr.id_config_aprobador = sol.id_aprobador
                            LEFT JOIN kard.tkp_unidad_organizacional uo2 ON uo2.id_unidad_organizacional = apr.id_uo
                            LEFT JOIN kard.tkp_empleado emp2 ON emp2.id_empleado = apr.id_empleado
                            LEFT JOIN sss.tsg_persona peremp2 ON peremp2.id_persona = emp2.id_persona 
                            WHERE ';
		
      g_consulta := g_consulta || pm_criterio_filtro;

      FOR g_registros in      EXECUTE (g_consulta)
      LOOP
        RETURN NEXT g_registros;
      END LOOP;

      -- DESCRIPCIÃ???N DE Ã???XITO PARA GUARDAR EN EL LOG
      g_descripcion_log_error := 'Consulta de cantidad registrada';
    END;

    ELSE
    --Procedimiento inexistente
    g_nivel_error := '2';
    g_descripcion_log_error := 'Procedimiento inexistente';
    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error,
      g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

    --REGISTRA EL LOG
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario            ,
      g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
      pm_ip_origen              ,pm_mac_maquina            ,'log'              ,
        NULL,
      pm_codigo_procedimiento   ,pm_proc_almacenado);
    --DEVUELVE MENSAJE DE ERROR
    RAISE EXCEPTION '%', g_respuesta;
  END IF;

  ---*** REGISTRO EN EL LOG EL Ã???XITO DE LA EJECUCIÃ???N DEL PROCEDIMIENTO
  g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,
    g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
    pm_ip_origen              ,pm_mac_maquina            ,'log'              ,
      NULL,
    pm_codigo_procedimiento   ,pm_proc_almacenado);
  RETURN;

  EXCEPTION

  WHEN others THEN
  BEGIN

    --SE OBTIENE EL MENSAJE Y EL NÃ???MERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
    g_mensaje_error:=SQLERRM;
    g_numero_error:=SQLSTATE;
    g_reg_error:= sss.f_tsg_registro_evento (pm_id_usuario            ,
      g_id_subsistema          ,g_id_lugar         ,g_mensaje_error,
      pm_ip_origen             ,pm_mac_maquina           ,'error'            ,
        g_numero_error,
      pm_codigo_procedimiento  ,pm_proc_almacenado);

    --SE DEVUELVE EL MENSAJE DE ERROR
    g_nivel_error := '1';
    g_descripcion_log_error := g_numero_error || ' - ' || g_mensaje_error;
    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error,
      g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

    RAISE EXCEPTION '%', 'f' || g_separador || g_respuesta;

  END;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;
