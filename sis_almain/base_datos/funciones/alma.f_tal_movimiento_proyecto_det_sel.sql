--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_tal_movimiento_proyecto_det_sel (
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
/************************************************************************** SISTEMA ENDESIS - SISTEMA ALMACENES*************************************************************************** 
 SCRIPT:         alma.f_tal_movimiento_proyecto_det_sel
 DESCRIPCIÃ????N:      Devuelve las consultas a la tabla alma.tal_detalle_movimiento
 AUTOR:         Ruddy Limbert Lujan Bravo
 FECHA:            09-09-2013
***************************************************************************/

DECLARE

  --PARAMETROS FIJOS
  g_id_subsistema integer; -- ID SUBSISTEMA
  g_id_lugar integer; -- ID LUGAR
  g_numero_error varchar; -- ALMACENA EL NUMERO DE ERROR
  g_mensaje_error varchar; -- ALMACENA MENSAJE DEL ERROR
  g_privilegio_procedimiento boolean;
  -- BANDERA PARA VERIFICAR LLAMADA DE PROCEDIMIENTO
  g_descripcion_log_error text; -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
  g_reg_evento boolean;
  g_reg_error boolean;
  g_registros record;
  -- PARA ALMACENAR EL CONJUNTO DE DATOS RESULTADO DEL SELECT
  g_respuesta varchar; -- VARIABLE QUE CONTENDRAÂ LOS MENSAJES DE ERROR
  g_consulta text;
  -- VARIABLE QUE CONTENDRAÂ LA CONSULTA DINAMICA PARA EL FILTRO
  g_nivel_error varchar; -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
  --      ERROR DE SINTAXIS (cuando llega a exception) = 1
  --      ERROR LOGICO (CRIÂTICO) = 2
  --      ERROR LOGICO (INTERMEDIO) = 3
  --      ERROR LOGICO (ADVERTENCIA) = 4
  g_nombre_funcion varchar; --NOMBRE FISICO DE LA FUNCION
  g_separador varchar(10);
  --Caracteres que servirÃ???Ã??Ã?Â¡n para separar el mensaje, nivel y origen del error

BEGIN

  ---*** INICIACION DE VARIABLES
  g_privilegio_procedimiento := FALSE;
  g_separador = '#@@@#'; --Separador para mensajes devueltos por la funcion
  g_nombre_funcion := 'f_tal_movimiento_proyecto_det_sel';

  ---*** OBTENCION DEL ID DEL SUBSISTEMA

  SELECT id_subsistema
  INTO g_id_subsistema
  FROM sss.tsg_procedimiento_db
  WHERE codigo_procedimiento = pm_codigo_procedimiento;

  ---*** OBTENCION DEL ID DEL LUGAR ASIGNADO AL USUARIO

  SELECT sss.tsg_usuario_lugar.id_lugar
  INTO g_id_lugar
  FROM sss.tsg_usuario_lugar
  WHERE sss.tsg_usuario_lugar.id_usuario = pm_id_usuario;

  ---*** VALIDACION DE LLAMADA POR USUARIO O FUNCION
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

  ---*** VERIFICACION DE PERMISOS DEL USUARIO
  IF NOT g_privilegio_procedimiento THEN
    g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(
      pm_id_usuario,pm_codigo_procedimiento,NULL);
  END IF;

  ---*** SI NO SE TIENE PERMISOS DE EJECUCION SE RETORNA EL MENSAJE DE ERROR
  IF NOT g_privilegio_procedimiento THEN
    g_nivel_error := '3';
    g_descripcion_log_error :=
    'El usuario no tiene permisos de ejecucion del procedimiento';
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

  -- Seleccion de operacion a realizar
  IF pm_codigo_procedimiento  = 'AL_DETPROYMOV_SEL' THEN
    BEGIN
      g_consulta := 'SELECT COALESCE(to_char(movdet.fecha_reg,''dd-mm-yyyy HH:MI:SS am''),''0'') AS fecha_reg,
                           movdet.usuario_reg,movdet.id_proyecto_mov_det,movdet.id_movimiento_proyecto,
                           movdet.cantidad,movdet.unidad_medida
                           ,it.id_item,it.codigo||'' - ''||it.nombre as desc_item
                           ,um.id_unidad_medida_base,um.nombre as nombre_medida
                           
                    FROM alma.tal_movimiento_proyecto_det movdet
                    INNER JOIN alma.tal_item it ON it.id_item=movdet.id_item
                    INNER JOIN alma.tal_movimiento_proyecto movpro ON movpro.id_movimiento_proyecto=movdet.id_movimiento_proyecto
                    LEFT JOIN param.tpm_unidad_medida_base um ON um.id_unidad_medida_base=it.id_unidad_medida AND um.estado_registro=''activo''
                    WHERE  ';

      g_consulta := g_consulta || pm_criterio_filtro;

      -- SE AUMENTA EL ORDEN Y LOS PARAMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
      g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol || ' ' ||pm_sortdir
      ;
      g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' ||
      pm_puntero;

      FOR g_registros in      EXECUTE (g_consulta)
      LOOP
        RETURN NEXT g_registros;
      END LOOP;

      -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
      g_descripcion_log_error := 'Consulta ejecutada';
    END;

    ELSIF pm_codigo_procedimiento  = 'AL_DETPROYMOV_COUNT' THEN

    BEGIN
      --Cuenta todos los registros de tasa_categoria sin condiciones
      g_consulta := ' SELECT count(movdet.id_movimiento_proyecto) as total
                      FROM alma.tal_movimiento_proyecto_det movdet
                      INNER JOIN alma.tal_item it ON it.id_item=movdet.id_item
                      INNER JOIN alma.tal_movimiento_proyecto movpro ON movpro.id_movimiento_proyecto=movdet.id_movimiento_proyecto
                      WHERE ';
      g_consulta := g_consulta || pm_criterio_filtro;

      FOR g_registros in      EXECUTE (g_consulta)
      LOOP
        RETURN NEXT g_registros;
      END LOOP;

      -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
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

  ---*** REGISTRO EN EL LOG EL Ã????XITO DE LA EJECUCION DEL PROCEDIMIENTO
  g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,
    g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
    pm_ip_origen              ,pm_mac_maquina            ,'log'              ,
    NULL,
    pm_codigo_procedimiento   ,pm_proc_almacenado);

  ---*** SE DEVUELVE EL CONJUNTO DE DATOS
  RETURN;

  EXCEPTION

  WHEN others THEN
  BEGIN

    --SE OBTIENE EL MENSAJE Y EL NUMERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
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