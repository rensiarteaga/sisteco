--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_tal_salida_reporte_sel (
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
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ...
***************************************************************************
 SCRIPT:         almin.f_tal_salida
 DESCRIPCIÓN:     Devuelve las consultas a la tabla almin.tal_salida
 AUTOR:         (Generado Automaticamente)
 FECHA:            2007-10-25 15:07:51
 COMENTARIOS:    
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCIÓN:  Modificacion para salida de pedidos PEDSAL
 AUTOR: Rensi Arteaga Copari
 FECHA: 2007-10-25 15:55     
 
 HISTORIA DE MODIFICACIONES:

 DESCRIPCIÓN:  Modificacion para salida de pedidos SALIDA
 AUTOR: Fernando Prudencio Cardona
 FECHA: 2007-10-26 15:22

***************************************************************************/
--------------------------
-- CUERPO DE LA FUNCIÓN --
--------------------------

-- PARÁMETROS FIJOS
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

*/

-- DECLARACIÓN DE VARIABLES PARTICULARES


-- DECLARACIÓN DE VARIABLES DE LA FUNCIÓN (LOCALES)

DECLARE

    --PARÁMETROS FIJOS
    g_id_subsistema            integer; -- ID SUBSISTEMA
    g_id_lugar                 integer; -- ID LUGAR
    g_numero_error             varchar; -- ALMACENA EL NÚMERO DE ERROR
    g_mensaje_error            varchar; -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento boolean; -- BANDERA PARA VERIFICAR LLAMADA DE PROCEDIMIENTO
    g_descripcion_log_error    text;    -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento               boolean;
    g_reg_error                boolean;
    g_registros                record;  -- PARA ALMACENAR EL CONJUNTO DE DATOS RESULTADO DEL SELECT
    g_respuesta                varchar; -- VARIABLE QUE CONTENDRÁ LOS MENSAJES DE ERROR
    g_consulta                 text;    -- VARIABLE QUE CONTENDRÁ LA CONSULTA DINÁMICA PARA EL FILTRO
    g_nivel_error              varchar; -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                        --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                        --      ERROR LÓGICO (CRÍTICO) = 2
                                        --      ERROR LÓGICO (INTERMEDIO) = 3
                                        --      ERROR LÓGICO (ADVERTENCIA) = 4
    g_nombre_funcion           varchar; --NOMBRE FÍSICO DE LA FUNCIÓN
    g_separador                varchar(10); --Caracteres que servirán para separar el mensaje, nivel y origen del error
    g_rol_adm                   boolean;    -- Identifica si el usuario tiene rol administrador
    
    g_id_empleado            integer; -- ID EMPLEADO
    
    
    

BEGIN

    ---*** INICIACIÓN DE VARIABLES
    g_privilegio_procedimiento := FALSE;
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion := 'almin.f_tal_salida_reporte_sel'; 
    
    
  g_id_empleado:= id_empleado FROM kard.tkp_empleado EMPLEA INNER JOIN sss.tsg_persona PERSON ON PERSON.id_persona=EMPLEA.id_persona INNER JOIN sss.tsg_usuario USUARI ON PERSON.id_persona = USUARI.id_persona WHERE  USUARI.id_usuario=pm_id_usuario;
    
    
    ---*** VERIFICACIÓN ROL ADMINISTRADOR
    IF EXISTS(SELECT 1 FROM sss.tsg_usuario_rol usrol WHERE usrol.id_usuario = pm_id_usuario AND usrol.id_rol=1) THEN
        g_rol_adm := true;
    END IF;
    
    ---*** OBTENCIÓN DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;

    ---*** OBTENCIÓN DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT sss.tsg_usuario_lugar.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar
    WHERE  sss.tsg_usuario_lugar.id_usuario = pm_id_usuario;


    ---*** VALIDACIÓN DE LLAMADA POR USUARIO O FUNCIÓN
    IF pm_proc_almacenado IS NOT NULL THEN
        IF NOT EXISTS(SELECT 1 FROM pg_proc WHERE proname = pm_proc_almacenado) THEN
            g_descripcion_log_error := 'Procedimiento ejecutor inexistente';
            g_nivel_error := '2';
            g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
            
            --REGISTRA EL LOG
            g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario            ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                pm_codigo_procedimiento   ,pm_proc_almacenado);
            --DEVUELVE MENSAJE DE ERROR
            RAISE EXCEPTION '%', g_respuesta;
        ELSE
           g_privilegio_procedimiento := TRUE;
        END IF;
    END IF;

    ---*** VERIFICACIÓN DE PERMISOS DEL USUARIO
    IF NOT g_privilegio_procedimiento THEN
       g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;

    ---*** SI NO SE TIENE PERMISOS DE EJECUCIÓN SE RETORNA EL MENSAJE DE ERROR
    IF NOT g_privilegio_procedimiento THEN
        g_nivel_error := '3';
        g_descripcion_log_error := 'El usuario no tiene permisos de ejecución del procedimiento';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                             pm_codigo_procedimiento   ,pm_proc_almacenado);
        --DEVUELVE MENSAJE DE ERROR
        RAISE EXCEPTION '%',g_descripcion_log_error;
    END IF;  
 
    --raise exception 'llega';

    ---***SELECCIÓN DE OPERACIÓN A REALIZAR
   IF pm_codigo_procedimiento  = 'AL_PEDIDOREP_SEL' THEN
        BEGIN
            g_consulta := 'SELECT
                               SALIDA.id_salida       ,SALIDA.correlativo_sal             ,SALIDA.correlativo_vale,
                               SALIDA.descripcion     ,SALIDA.contabilizar                ,SALIDA.contabilizado,SALIDA.estado_salida,
                               SALIDA.estado_registro ,SALIDA.motivo_cancelacion          ,SALIDA.id_responsable_almacen,
                               SALIDA.id_almacen_logico,
                               ALMLOG.nombre as desc_almacen_logico                       ,SALIDA.id_empleado,
                               ALMACE.nombre as desc_almacen,
                               FINANC.nombre_financiador,
                               REGION.nombre_regional                  ,PROGRA.nombre_programa                ,PROYEC.nombre_proyecto,
                               ACTIVI.nombre_actividad                 ,FINANC.id_financiador                 ,REGION.id_regional,
                               PROGRA.id_programa                      ,PROYEC.id_proyecto                    ,ACTIVI.id_actividad,
                               FINANC.codigo_financiador               ,REGION.codigo_regional                ,PROGRA.codigo_programa,
                               PROYEC.codigo_proyecto                  ,ACTIVI.codigo_actividad               ,SALIDA.emergencia,
                               SALIDA.observaciones                    ,SALIDA.tipo_pedido                    ,SALIDA.receptor,
                               SALIDA.id_tramo_subactividad            ,SALIDA.id_tramo_unidad_constructiva   ,
                               SALIDA.fecha_borrador,
                               SALIDA.id_supervisor					   ,SALIDA.receptor_ci					  ,SALIDA.solicitante,
                               SALIDA.solicitante_ci				   ,SALIDA.num_contrato,
                               ALMACE.id_almacen
                           FROM almin.tal_salida SALIDA
                           INNER JOIN almin.tal_almacen_logico ALMLOG ON ALMLOG.id_almacen_logico=SALIDA.id_almacen_logico
                           INNER JOIN almin.tal_almacen_ep ALMAEP ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
            			   INNER JOIN almin.tal_almacen ALMACE ON ALMACE.id_almacen = ALMAEP.id_almacen
            			   INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA ON FRPPA.id_fina_regi_prog_proy_acti = ALMAEP.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC ON FINANC.id_financiador = FRPPA.id_financiador
                           INNER JOIN param.tpm_regional REGION ON REGION.id_regional = FRPPA.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC ON PGPYAC.id_prog_proy_acti = FRPPA.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA ON PROGRA.id_programa = PGPYAC.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC ON PROYEC.id_proyecto = PGPYAC.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI ON ACTIVI.id_actividad = PGPYAC.id_actividad
                           WHERE SALIDA.tipo_reg = ''reporte'' AND ';
            
            g_consulta := g_consulta || pm_criterio_filtro;
          --  para que los usuarios  solo puedan ver los pedidos realizados por ellos
            IF NOT g_rol_adm  THEN
                g_consulta := g_consulta || ' SALIDA.id_usuario=' || pm_id_susario ||'  AND ';
            END IF;
            
            
            
            -- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;

    -- PARA LA CONSULTA DE SELECCIÓN     
    ELSIF pm_codigo_procedimiento  = 'AL_PEDIDOREP_COUNT' THEN

        BEGIN
        --Cuenta todos los registros
            g_consulta := 'SELECT
                              COUNT(SALIDA.id_salida) AS total
                           FROM almin.tal_salida SALIDA
                           INNER JOIN almin.tal_almacen_logico ALMLOG ON ALMLOG.id_almacen_logico=SALIDA.id_almacen_logico
                           INNER JOIN almin.tal_almacen_ep ALMAEP ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
            			   INNER JOIN almin.tal_almacen ALMACE ON ALMACE.id_almacen = ALMAEP.id_almacen
            			   INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA ON FRPPA.id_fina_regi_prog_proy_acti = ALMAEP.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC ON FINANC.id_financiador = FRPPA.id_financiador
                           INNER JOIN param.tpm_regional REGION ON REGION.id_regional = FRPPA.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC ON PGPYAC.id_prog_proy_acti = FRPPA.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA ON PROGRA.id_programa = PGPYAC.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC ON PROYEC.id_proyecto = PGPYAC.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI ON ACTIVI.id_actividad = PGPYAC.id_actividad
                           WHERE SALIDA.tipo_reg = ''reporte'' AND '; 
             --  para que los usuarios  solo puedan ver los pedidos realizados por ellos
            IF NOT g_rol_adm  THEN
                g_consulta := g_consulta || ' SALIDA.id_usuario=' || pm_id_susario ||'  AND ';
            END IF;

            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;  

 ELSE
        --Procedimiento inexistente
        g_nivel_error := '2';
        g_descripcion_log_error := 'Procedimiento inexistente';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario            ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                            pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                            pm_codigo_procedimiento   ,pm_proc_almacenado);
        --DEVUELVE MENSAJE DE ERROR
        RAISE EXCEPTION '%', g_respuesta;
    END IF;


    ---*** REGISTRO EN EL LOG EL ÉXITO DE LA EJECUCIÓN DEL PROCEDIMIENTO
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);


    ---*** SE DEVUELVE EL CONJUNTO DE DATOS
    RETURN;


EXCEPTION

    WHEN others THEN BEGIN
    
        --SE OBTIENE EL MENSAJE Y EL NÚMERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
        g_mensaje_error:=SQLERRM;
        g_numero_error:=SQLSTATE;
        g_reg_error:= sss.f_tsg_registro_evento (pm_id_usuario            ,g_id_subsistema          ,g_id_lugar         ,g_mensaje_error,
                                             pm_ip_origen             ,pm_mac_maquina           ,'error'            ,g_numero_error,
                                             pm_codigo_procedimiento  ,pm_proc_almacenado);

        --SE DEVUELVE EL MENSAJE DE ERROR
        g_nivel_error := '1';
        g_descripcion_log_error := g_numero_error || ' - ' || g_mensaje_error;
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        RAISE EXCEPTION '%', 'f' || g_separador || g_respuesta;

    END;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;