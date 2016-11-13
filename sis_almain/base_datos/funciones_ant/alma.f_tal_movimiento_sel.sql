QL ---------------

CREATE OR REPLACE FUNCTION alma.f_tal_movimiento_sel (
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
/************************************************************************** SISTEMA ENDESIS - SISTEMA DE ALMACEN***************************************************************************
 SCRIPT:          alma.f_tal_movimiento_sel
 DESCRIPCION:     Devuelve las consultas a la tabla train.tal_movimiento
 AUTOR:           Ruddy Lujan Bravo
 FECHA:           06-09-2013 17:10:00
 COMENTARIOS:    

***************************************************************************/
--------------------------
-- CUERPO DE LA FUNCION --
--------------------------

-- PARAMETROS FIJOS
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

-- DECLARACION DE VARIABLES PARTICULARES


-- DECLARACION DE VARIABLES DE LA FUNCION (LOCALES)

DECLARE

  --PARÃ?ÃMETROS FIJOS
  g_id_subsistema integer; -- ID SUBSISTEMA
  g_id_lugar integer; -- ID LUGAR
  g_numero_error varchar; -- ALMACENA EL NUMERO DE ERROR
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
  g_respuesta varchar; -- VARIABLE QUE CONTENDRA LOS MENSAJES DE ERROR
  g_consulta text; -- VARIABLE QUE CONTENDRA LA CONSULTA DINAMICA PARA EL FILTRO
  
  g_nivel_error varchar; -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
  --      ERROR DE SINTAXIS (cuando llega a exception) = 1
  --      ERROR LOGICO (CRITICO) = 2
  --      ERROR LOGICO (INTERMEDIO) = 3
  --      ERROR LOGICO (ADVERTENCIA) = 4
  g_nombre_funcion varchar; --NOMBRE FISICO DE LA FUNCION
  g_separador varchar(10);
  --Caracteres que serviran para separar el mensaje, nivel y origen del error
  g_rol_adm boolean; -- Identifica si el usuario tiene rol administrador

BEGIN

  ---*** INICIACION DE VARIABLES
  g_privilegio_procedimiento := FALSE;
  g_separador = '#@@@#'; --Separador para mensajes devueltos por la funcion
  g_nombre_funcion :='f_tal_movimiento_sel';
  g_rol_adm:= false;
  ---*** VERIFICACION ROL ADMINISTRADOR

  IF EXISTS(
    SELECT 1
    FROM sss.tsg_usuario_rol usrol
    WHERE usrol.id_usuario = pm_id_usuario AND
          usrol.id_rol = 1) THEN
    g_rol_adm := true;
  END IF;

  ---*** OBTENCION DEL ID DEL SUBSISTEMA

  SELECT id_subsistema
  INTO g_id_subsistema
  FROM sss.tsg_procedimiento_db
  WHERE codigo_procedimiento = pm_codigo_procedimiento;

  ---*** OBTENCION DEL ID DEL LUGAR ASIGNADO AL USUARIO

  SELECT ul.id_lugar
  INTO g_id_lugar
  FROM sss.tsg_usuario_lugar ul
  WHERE ul.id_usuario = pm_id_usuario;

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

  ---*** SI NO SE TIENE PERMISOS DE EJECUCIÃ??N SE RETORNA EL MENSAJE DE ERROR
  --IF NOT g_privilegio_procedimiento THEN
  IF NOT (g_privilegio_procedimiento OR
      g_privilegio_procedimiento_administrador_cobra OR
      g_privilegio_procedimiento_resp_entifin) THEN

    g_nivel_error := '3';
    g_descripcion_log_error :=
    'El usuario no tiene permisos de ejecuciÃ?Ã³n del procedimiento';
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

  ---***SELECCION DE OPERACION A REALIZAR
  IF pm_codigo_procedimiento  = 'AL_MOVI_SEL' THEN
    BEGIN

      g_consulta := 'SELECT
            					COALESCE(to_char(al.fecha_reg,''dd-mm-yyyy''),''0'') AS fecha_reg,
                                al.usuario_reg,
                            	al.id_movimiento,
                				al.id_tipo_movimiento,
                				al.id_almacen,
                                al.id_solicitud_salida,
    							al.codigo,
                                COALESCE(to_char(al.fecha_movimiento,''dd-mm-yyyy''),''0'') AS fecha_movimiento,
                                COALESCE(to_char(al.fecha_finalizacion,''dd-mm-yyyy''),''0'') AS fecha_finalizacion,
                                al.descripcion,
                                al.observaciones,
                                al.estado,
                                tip.tipo as nombre_tipo,
                                tip.requiere_aprobacion as requiere_aprobacion,
                                doc.descripcion as descripcion_tipo
                                ,al.id_almacen_trans
                                ,alm.nombre as desc_almacen 
                                ,al.id_movimiento_fk
                                ,alm2.nombre as almacen_destino
							FROM alma.tal_movimiento al
                            INNER JOIN alma.tal_tipo_movimiento tip ON tip.id_tipo_movimiento = al.id_tipo_movimiento
                            INNER JOIN param.tpm_documento doc ON doc.id_documento = tip.id_documento
                            LEFT JOIN alma.tal_almacen alm on alm.id_almacen=al.id_almacen
                            LEFT JOIN alma.tal_almacen alm2 on alm2.id_almacen=al.id_almacen_trans
                            WHERE ';
      g_consulta := g_consulta || pm_criterio_filtro;
      -- SE AUMENTA EL ORDEN Y LOS PARAMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
      
      g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
      g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' ||
      pm_puntero;

      FOR g_registros in      EXECUTE (g_consulta)
      LOOP
        RETURN NEXT g_registros;
      END LOOP;

      -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
      g_descripcion_log_error := 'Consulta ejecutada';
    END;

    -- PARA LA CONSULTA DE CONTEO  
    ELSIF pm_codigo_procedimiento  = 'AL_MOVI_COUNT' THEN

    BEGIN
      --Cuenta todos los registros
      g_consulta := 'SELECT
                           		COUNT(al.id_movimiento) AS total
        					FROM alma.tal_movimiento al
                            INNER JOIN alma.tal_tipo_movimiento tip ON tip.id_tipo_movimiento = al.id_tipo_movimiento
                            INNER JOIN param.tpm_documento doc ON doc.id_documento = tip.id_documento
                            LEFT JOIN alma.tal_almacen alm on alm.id_almacen=al.id_almacen
                            LEFT JOIN alma.tal_almacen alm2 on alm2.id_almacen=al.id_almacen_trans
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

  ---*** REGISTRO EN EL LOG EL EXITO DE LA EJECUCION DEL PROCEDIMIENTO
  g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,
    g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
    pm_ip_origen              ,pm_mac_maquina            ,'log'              ,
    NULL,
    pm_codigo_procedimiento   ,pm_proc_almacenado);
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
