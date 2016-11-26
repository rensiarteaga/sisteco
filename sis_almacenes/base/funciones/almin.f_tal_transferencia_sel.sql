--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_tal_transferencia_sel (
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
 SCRIPT: 		almin.f_tal_transferencia
 DESCRIPCIÓN: 	Devuelve las consultas a la tabla almin.tal_transferencia
 AUTOR: 		(Generado Automaticamente)
 FECHA:			2007-11-21 08:58:15
 COMENTARIOS:	
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCIÓN:
 AUTOR:
 FECHA:

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
    g_rol_adm		           boolean;	-- Identifica si el usuario tiene rol administrador

BEGIN

    ---*** INICIACIÓN DE VARIABLES
    g_privilegio_procedimiento := FALSE;
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion := 'almin.f_tal_transferencia_sel';

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

    ---***SELECCIÓN DE OPERACIÓN A REALIZAR
    IF pm_codigo_procedimiento  = 'AL_TRABOR_SEL' THEN --TRABOR: Transferencia Borrador
        BEGIN
            g_consulta := 'SELECT
                               TRANSF.id_transferencia,
                               TRANSF.prestamo,
                               TRANSF.estado_transferencia,
                               TRANSF.motivo,
                               TRANSF.descripcion,
                               TRANSF.observaciones,
                               TRANSF.fecha_pendiente_sal,
                               TRANSF.fecha_pendiente_ing,
                               TRANSF.fecha_finalizado_anulado,
                               TRANSF.id_empleado,
                               COALESCE(PERSON1.nombre,'' '') || ''  ''||COALESCE(PERSON1.apellido_paterno,'' '')||''  ''||COALESCE(PERSON1.apellido_materno, '' '') as desc_empleado,
                               TRANSF.id_firma_autorizada_transf,
                               COALESCE(PERSON.apellido_paterno,'' '')||''  ''||COALESCE(PERSON.apellido_materno,'' '')||''  ''||COALESCE(PERSON.nombre,'' '') as desc_firma_autorizada,
                               TRANSF.id_almacen_logico,
                               ALMLOG.nombre as desc_almacen_logico_orig,
                               TRANSF.id_almacen_logico_destino,
                               ALMLOG1.nombre as desc_almacen_logico_dest,
                               TRANSF.id_motivo_ingreso_cuenta,
                               MOINCU.descripcion as desc_motivo_ingreso_cuenta,
                               ALMACE.nombre as desc_almacen_orig,
                               FINANC.nombre_financiador,
                               REGION.nombre_regional                  ,PROGRA.nombre_programa                ,PROYEC1.nombre_proyecto,
                               ACTIVI.nombre_actividad                 ,FINANC.id_financiador                 ,REGION1.id_regional,
                               PROGRA.id_programa                      ,PROYEC.id_proyecto                    ,ACTIVI1.id_actividad,
                               FINANC.codigo_financiador               ,REGION.codigo_regional                ,PROGRA1.codigo_programa,
                               PROYEC.codigo_proyecto                  ,ACTIVI.codigo_actividad,
                               ALMACE1.nombre as desc_almacen_dest,
                               FINANC1.nombre_financiador as nombre_financiador_dest,
                               REGION1.nombre_regional as nombre_regional_dest             ,PROGRA1.nombre_programa as nombre_programa_dest         ,PROYEC1.nombre_proyecto as nombre_proyecto_dest,
                               ACTIVI1.nombre_actividad as nombre_actividad_dest           ,FINANC1.id_financiador as id_financiador_dest           ,REGION1.id_regional as id_regional_dest,
                               PROGRA1.id_programa as id_programa_dest                     ,PROYEC1.id_proyecto as id_proyecto_dest                 ,ACTIVI1.id_actividad as id_actividad_dest,
                               FINANC1.codigo_financiador as codigo_financiador_dest       ,REGION1.codigo_regional as codigo_regional_dest         ,PROGRA1.codigo_programa as codigo_programa_dest,
                               PROYEC1.codigo_proyecto as codigo_proyecto_dest             ,ACTIVI1.codigo_actividad as codigo_actividad_dest,
                               TRANSF.fecha_borrador   ,TRANSF.fecha_pendiente    ,TRANSF.fecha_rechazado   ,TRANSF.id_ingreso,
                               TRANSF.id_salida,
                               TRANSF.id_tipo_material ,TIPMAT.nombre as desc_tipo_material,
                               TRANSF.id_motivo_salida_cuenta, MOSACU.descripcion as desc_motivo_salida_cuenta,
                               MOTING.nombre as desc_motivo_ingreso ,MOTSAL.nombre as desc_motivo_salida,
                               TRANSF.id_ingreso_prestamo           ,TRANSF.id_salida_prestamo,
                               ALMACE1.id_almacen as id_almacen_dest,                             
                               ALMACE.id_almacen as id_almacen_orig,
                               MOTSAL.id_motivo_salida,
                               MOTING.id_motivo_ingreso,
                               COALESCE(TRANSF.id_transferencia_dev,0) as id_transferencia_dev,
                               TRANSF.tipo_transferencia,
                               TRANSF.importe_abierto
                              
                               
						   FROM almin.tal_transferencia TRANSF
						   LEFT JOIN kard.tkp_empleado EMPLEA
            			   ON EMPLEA.id_empleado=TRANSF.id_empleado
                           INNER JOIN almin.tal_almacen_logico ALMLOG
            			   ON ALMLOG.id_almacen_logico=TRANSF.id_almacen_logico
	                       INNER JOIN almin.tal_almacen_logico ALMLOG1
            			   ON ALMLOG1.id_almacen_logico=TRANSF.id_almacen_logico_destino
             			   INNER JOIN almin.tal_almacen_ep ALMAEP
             			   ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
             			   INNER JOIN almin.tal_almacen_ep ALMAEP1
             			   ON ALMAEP1.id_almacen_ep = ALMLOG1.id_almacen_ep
             			   INNER JOIN almin.tal_almacen ALMACE
             			   ON ALMACE.id_almacen = ALMAEP.id_almacen
             			   INNER JOIN almin.tal_almacen ALMACE1
             			   ON ALMACE1.id_almacen = ALMAEP1.id_almacen
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                           ON FRPPA.id_fina_regi_prog_proy_acti = ALMAEP.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC
                           ON FINANC.id_financiador = FRPPA.id_financiador
                           INNER JOIN param.tpm_regional REGION
                           ON REGION.id_regional = FRPPA.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC
                           ON PGPYAC.id_prog_proy_acti = FRPPA.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA
                           ON PROGRA.id_programa = PGPYAC.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC
                           ON PROYEC.id_proyecto = PGPYAC.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI
                           ON ACTIVI.id_actividad = PGPYAC.id_actividad
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA1
                           ON FRPPA1.id_fina_regi_prog_proy_acti = ALMAEP1.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC1
                           ON FINANC1.id_financiador = FRPPA1.id_financiador
                           INNER JOIN param.tpm_regional REGION1
                           ON REGION1.id_regional = FRPPA1.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC1
                           ON PGPYAC1.id_prog_proy_acti = FRPPA1.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA1
                           ON PROGRA1.id_programa = PGPYAC1.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC1
                           ON PROYEC1.id_proyecto = PGPYAC1.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI1
                           ON ACTIVI1.id_actividad = PGPYAC1.id_actividad
                           INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			   ON MOINCU.id_motivo_ingreso_cuenta=TRANSF.id_motivo_ingreso_cuenta
            			   INNER JOIN almin.tal_motivo_ingreso MOTING
            			   ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			   INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			   ON MOSACU.id_motivo_salida_cuenta=TRANSF.id_motivo_salida_cuenta
            			   INNER JOIN almin.tal_motivo_salida MOTSAL
            			   ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
            			   INNER JOIN almin.tal_firma_autorizada_transf FIRAUT
            			   ON FIRAUT.id_firma_autorizada_transf = TRANSF.id_firma_autorizada_transf
                           INNER JOIN kard.tkp_empleado EMPLEA2
                           ON EMPLEA2.id_empleado = FIRAUT.id_empleado
                           INNER JOIN sss.tsg_persona PERSON
                           ON PERSON.id_persona = EMPLEA2.id_persona
                           INNER JOIN almin.tal_tipo_material TIPMAT
                           ON TIPMAT.id_tipo_material = TRANSF.id_tipo_material
                           INNER JOIN kard.tkp_empleado EMPLEA3 ON EMPLEA3.id_empleado= TRANSF.id_empleado
                           INNER JOIN sss.tsg_persona PERSON1 ON PERSON1.id_persona= EMPLEA3.id_persona
                           WHERE (TRANSF.estado_transferencia = ''Borrador'') AND ';
            g_consulta := g_consulta || pm_criterio_filtro;
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
    ELSIF pm_codigo_procedimiento  = 'AL_TRABOR_COUNT' THEN --TRABOR: Transferencia Borrador

        BEGIN
        --Cuenta todos los registros
            g_consulta := 'SELECT
                           COUNT(TRANSF.id_transferencia) AS total
                           FROM almin.tal_transferencia TRANSF
						   LEFT JOIN kard.tkp_empleado EMPLEA
            			   ON EMPLEA.id_empleado=TRANSF.id_empleado
                           INNER JOIN almin.tal_almacen_logico ALMLOG
            			   ON ALMLOG.id_almacen_logico=TRANSF.id_almacen_logico
	                       INNER JOIN almin.tal_almacen_logico ALMLOG1
            			   ON ALMLOG1.id_almacen_logico=TRANSF.id_almacen_logico_destino
             			   INNER JOIN almin.tal_almacen_ep ALMAEP
             			   ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
             			   INNER JOIN almin.tal_almacen_ep ALMAEP1
             			   ON ALMAEP1.id_almacen_ep = ALMLOG1.id_almacen_ep
             			   INNER JOIN almin.tal_almacen ALMACE
             			   ON ALMACE.id_almacen = ALMAEP.id_almacen
             			   INNER JOIN almin.tal_almacen ALMACE1
             			   ON ALMACE1.id_almacen = ALMAEP1.id_almacen
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                           ON FRPPA.id_fina_regi_prog_proy_acti = ALMAEP.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC
                           ON FINANC.id_financiador = FRPPA.id_financiador
                           INNER JOIN param.tpm_regional REGION
                           ON REGION.id_regional = FRPPA.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC
                           ON PGPYAC.id_prog_proy_acti = FRPPA.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA
                           ON PROGRA.id_programa = PGPYAC.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC
                           ON PROYEC.id_proyecto = PGPYAC.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI
                           ON ACTIVI.id_actividad = PGPYAC.id_actividad
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA1
                           ON FRPPA1.id_fina_regi_prog_proy_acti = ALMAEP1.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC1
                           ON FINANC1.id_financiador = FRPPA1.id_financiador
                           INNER JOIN param.tpm_regional REGION1
                           ON REGION1.id_regional = FRPPA1.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC1
                           ON PGPYAC1.id_prog_proy_acti = FRPPA1.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA1
                           ON PROGRA1.id_programa = PGPYAC1.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC1
                           ON PROYEC1.id_proyecto = PGPYAC1.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI1
                           ON ACTIVI1.id_actividad = PGPYAC1.id_actividad
                           INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			   ON MOINCU.id_motivo_ingreso_cuenta=TRANSF.id_motivo_ingreso_cuenta
            			   INNER JOIN almin.tal_motivo_ingreso MOTING
            			   ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			   INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			   ON MOSACU.id_motivo_salida_cuenta=TRANSF.id_motivo_salida_cuenta
            			   INNER JOIN almin.tal_motivo_salida MOTSAL
            			   ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
            			   INNER JOIN almin.tal_firma_autorizada_transf FIRAUT
            			   ON FIRAUT.id_firma_autorizada_transf = TRANSF.id_firma_autorizada_transf
                           INNER JOIN kard.tkp_empleado EMPLEA2
                           ON EMPLEA2.id_empleado = FIRAUT.id_empleado
                           INNER JOIN sss.tsg_persona PERSON
                           ON PERSON.id_persona = EMPLEA2.id_persona
                           INNER JOIN almin.tal_tipo_material TIPMAT
                           ON TIPMAT.id_tipo_material = TRANSF.id_tipo_material
                           INNER JOIN kard.tkp_empleado EMPLEA3 ON EMPLEA3.id_empleado= TRANSF.id_empleado
                           INNER JOIN sss.tsg_persona PERSON1 ON PERSON1.id_persona= EMPLEA3.id_persona
						   WHERE (TRANSF.estado_transferencia = ''Borrador'') AND ';
            g_consulta := g_consulta || pm_criterio_filtro;
          

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;

    ELSIF pm_codigo_procedimiento  = 'AL_TRAPEN_SEL' THEN --TRAPEN: Transferencias Pendientes de aprobación
        BEGIN
            g_consulta := 'SELECT
				           TRANSF.id_transferencia,
						   TRANSF.prestamo,
						   TRANSF.estado_transferencia,
						   TRANSF.motivo,
						   TRANSF.descripcion,
						   TRANSF.observaciones,
						   TRANSF.fecha_pendiente_sal,
						   TRANSF.fecha_pendiente_ing,
						   TRANSF.fecha_finalizado_anulado,
						   TRANSF.id_empleado,
                           (SELECT COALESCE(PERSON.nombre,'' '') || ''  ''||COALESCE(PERSON.apellido_paterno,'' '')||''  ''||COALESCE(PERSON.apellido_materno, '' '')
                            FROM kard.tkp_empleado EMPLEA
                            INNER JOIN sss.tsg_persona PERSON ON PERSON.id_persona = EMPLEA.id_persona
                            WHERE EMPLEA.id_empleado = TRANSF.id_empleado) as desc_empleado,
						   TRANSF.id_firma_autorizada_transf,
						   COALESCE(PERSON.apellido_paterno,'' '')||''  ''||COALESCE(PERSON.apellido_materno,'' '')||''  ''||COALESCE(PERSON.nombre,'' '') as desc_firma_autorizada,
                           TRANSF.id_almacen_logico,
						   ALMLOG.nombre as desc_almacen_logico_orig,
						   TRANSF.id_almacen_logico_destino,
						   ALMLOG1.nombre as desc_almacen_logico_dest,
						   TRANSF.id_motivo_ingreso_cuenta,
						   MOINCU.descripcion as desc_motivo_ingreso_cuenta,
						   ALMACE.nombre as desc_almacen_orig,
						   FINANC.nombre_financiador,
                           REGION.nombre_regional                  ,PROGRA.nombre_programa                ,PROYEC1.nombre_proyecto,
                           ACTIVI.nombre_actividad                 ,FINANC.id_financiador                 ,REGION1.id_regional,
                           PROGRA.id_programa                      ,PROYEC.id_proyecto                    ,ACTIVI1.id_actividad,
                           FINANC.codigo_financiador               ,REGION.codigo_regional                ,PROGRA1.codigo_programa,
                           PROYEC.codigo_proyecto                  ,ACTIVI.codigo_actividad,
   						   ALMACE1.nombre as desc_almacen_dest,
                           FINANC1.nombre_financiador as nombre_financiador_dest,
                           REGION1.nombre_regional as nombre_regional_dest             ,PROGRA1.nombre_programa as nombre_programa_dest         ,PROYEC1.nombre_proyecto as nombre_proyecto_dest,
                           ACTIVI1.nombre_actividad as nombre_actividad_dest           ,FINANC1.id_financiador as id_financiador_dest           ,REGION1.id_regional as id_regional_dest,
                           PROGRA1.id_programa as id_programa_dest                     ,PROYEC1.id_proyecto as id_proyecto_dest                 ,ACTIVI1.id_actividad as id_actividad_dest,
                           FINANC1.codigo_financiador as codigo_financiador_dest       ,REGION1.codigo_regional as codigo_regional_dest         ,PROGRA1.codigo_programa as codigo_programa_dest,
                           PROYEC1.codigo_proyecto as codigo_proyecto_dest             ,ACTIVI1.codigo_actividad as codigo_actividad_dest,
                           TRANSF.fecha_borrador   ,TRANSF.fecha_pendiente    ,TRANSF.fecha_rechazado   ,TRANSF.id_ingreso,
                           TRANSF.id_salida,
                           TRANSF.id_tipo_material ,TIPMAT.nombre as desc_tipo_material,
                           TRANSF.id_motivo_salida_cuenta, MOSACU.descripcion as desc_motivo_salida_cuenta,
                           MOTING.nombre as desc_motivo_ingreso, MOTSAL.nombre as desc_motivo_salida,
                           TRANSF.id_ingreso_prestamo            ,TRANSF.id_salida_prestamo
						   FROM almin.tal_transferencia TRANSF
						   LEFT JOIN kard.tkp_empleado EMPLEA
            			   ON EMPLEA.id_empleado=TRANSF.id_empleado
                           INNER JOIN almin.tal_almacen_logico ALMLOG
            			   ON ALMLOG.id_almacen_logico=TRANSF.id_almacen_logico
	                       INNER JOIN almin.tal_almacen_logico ALMLOG1
            			   ON ALMLOG1.id_almacen_logico=TRANSF.id_almacen_logico_destino
             			   INNER JOIN almin.tal_almacen_ep ALMAEP
             			   ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
             			   INNER JOIN almin.tal_almacen_ep ALMAEP1
             			   ON ALMAEP1.id_almacen_ep = ALMLOG1.id_almacen_ep
             			   INNER JOIN almin.tal_almacen ALMACE
             			   ON ALMACE.id_almacen = ALMAEP.id_almacen
             			   INNER JOIN almin.tal_almacen ALMACE1
             			   ON ALMACE1.id_almacen = ALMAEP1.id_almacen
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                           ON FRPPA.id_fina_regi_prog_proy_acti = ALMAEP.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC
                           ON FINANC.id_financiador = FRPPA.id_financiador
                           INNER JOIN param.tpm_regional REGION
                           ON REGION.id_regional = FRPPA.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC
                           ON PGPYAC.id_prog_proy_acti = FRPPA.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA
                           ON PROGRA.id_programa = PGPYAC.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC
                           ON PROYEC.id_proyecto = PGPYAC.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI
                           ON ACTIVI.id_actividad = PGPYAC.id_actividad
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA1
                           ON FRPPA1.id_fina_regi_prog_proy_acti = ALMAEP1.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC1
                           ON FINANC1.id_financiador = FRPPA1.id_financiador
                           INNER JOIN param.tpm_regional REGION1
                           ON REGION1.id_regional = FRPPA1.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC1
                           ON PGPYAC1.id_prog_proy_acti = FRPPA1.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA1
                           ON PROGRA1.id_programa = PGPYAC1.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC1
                           ON PROYEC1.id_proyecto = PGPYAC1.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI1
                           ON ACTIVI1.id_actividad = PGPYAC1.id_actividad
                           INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			   ON MOINCU.id_motivo_ingreso_cuenta=TRANSF.id_motivo_ingreso_cuenta
            			   INNER JOIN almin.tal_motivo_ingreso MOTING
            			   ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			   INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			   ON MOSACU.id_motivo_salida_cuenta=TRANSF.id_motivo_salida_cuenta
            			   INNER JOIN almin.tal_motivo_salida MOTSAL
            			   ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
            			   INNER JOIN almin.tal_firma_autorizada_transf FIRAUT
            			   ON FIRAUT.id_firma_autorizada_transf = TRANSF.id_firma_autorizada_transf
                           INNER JOIN kard.tkp_empleado EMPLEA2
                           ON EMPLEA2.id_empleado = FIRAUT.id_empleado
                           INNER JOIN sss.tsg_persona PERSON
                           ON PERSON.id_persona = EMPLEA2.id_persona
                           INNER JOIN almin.tal_tipo_material TIPMAT
                           ON TIPMAT.id_tipo_material = TRANSF.id_tipo_material
						   WHERE TRANSF.estado_transferencia = ''Pendiente'' AND ';
            g_consulta := g_consulta || pm_criterio_filtro;
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
    ELSIF pm_codigo_procedimiento  = 'AL_TRAPEN_COUNT' THEN --TRAPEN: Transferencias Pendientes de aprobación

        BEGIN
        --Cuenta todos los registros
            g_consulta := 'SELECT
                           COUNT(TRANSF.id_transferencia) AS total
                           FROM almin.tal_transferencia TRANSF
						   LEFT JOIN kard.tkp_empleado EMPLEA
            			   ON EMPLEA.id_empleado=TRANSF.id_empleado
                           INNER JOIN almin.tal_almacen_logico ALMLOG
            			   ON ALMLOG.id_almacen_logico=TRANSF.id_almacen_logico
	                       INNER JOIN almin.tal_almacen_logico ALMLOG1
            			   ON ALMLOG1.id_almacen_logico=TRANSF.id_almacen_logico_destino
             			   INNER JOIN almin.tal_almacen_ep ALMAEP
             			   ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
             			   INNER JOIN almin.tal_almacen_ep ALMAEP1
             			   ON ALMAEP1.id_almacen_ep = ALMLOG1.id_almacen_ep
             			   INNER JOIN almin.tal_almacen ALMACE
             			   ON ALMACE.id_almacen = ALMAEP.id_almacen
             			   INNER JOIN almin.tal_almacen ALMACE1
             			   ON ALMACE1.id_almacen = ALMAEP1.id_almacen
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                           ON FRPPA.id_fina_regi_prog_proy_acti = ALMAEP.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC
                           ON FINANC.id_financiador = FRPPA.id_financiador
                           INNER JOIN param.tpm_regional REGION
                           ON REGION.id_regional = FRPPA.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC
                           ON PGPYAC.id_prog_proy_acti = FRPPA.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA
                           ON PROGRA.id_programa = PGPYAC.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC
                           ON PROYEC.id_proyecto = PGPYAC.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI
                           ON ACTIVI.id_actividad = PGPYAC.id_actividad
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA1
                           ON FRPPA1.id_fina_regi_prog_proy_acti = ALMAEP1.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC1
                           ON FINANC1.id_financiador = FRPPA1.id_financiador
                           INNER JOIN param.tpm_regional REGION1
                           ON REGION1.id_regional = FRPPA1.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC1
                           ON PGPYAC1.id_prog_proy_acti = FRPPA1.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA1
                           ON PROGRA1.id_programa = PGPYAC1.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC1
                           ON PROYEC1.id_proyecto = PGPYAC1.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI1
                           ON ACTIVI1.id_actividad = PGPYAC1.id_actividad
                           INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			   ON MOINCU.id_motivo_ingreso_cuenta=TRANSF.id_motivo_ingreso_cuenta
            			   INNER JOIN almin.tal_motivo_ingreso MOTING
            			   ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			   INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			   ON MOSACU.id_motivo_salida_cuenta=TRANSF.id_motivo_salida_cuenta
            			   INNER JOIN almin.tal_motivo_salida MOTSAL
            			   ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
            			   INNER JOIN almin.tal_firma_autorizada_transf FIRAUT
            			   ON FIRAUT.id_firma_autorizada_transf = TRANSF.id_firma_autorizada_transf
                           INNER JOIN kard.tkp_empleado EMPLEA2
                           ON EMPLEA2.id_empleado = FIRAUT.id_empleado
                           INNER JOIN sss.tsg_persona PERSON
                           ON PERSON.id_persona = EMPLEA2.id_persona
                           INNER JOIN almin.tal_tipo_material TIPMAT
                           ON TIPMAT.id_tipo_material = TRANSF.id_tipo_material
						   WHERE TRANSF.estado_transferencia = ''Pendiente'' AND ';
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;
                                               
        
    ELSIF pm_codigo_procedimiento  = 'AL_BAJPEN_SEL' THEN --BAJPEN: Bajas Pendientes de aprobación
        BEGIN
            g_consulta := 'SELECT
				           TRANSF.id_transferencia,
						   TRANSF.prestamo,
						   TRANSF.estado_transferencia,
						   TRANSF.motivo,
						   TRANSF.descripcion,
						   TRANSF.observaciones,
						   TRANSF.fecha_pendiente_sal,
						   TRANSF.fecha_pendiente_ing,
						   TRANSF.fecha_finalizado_anulado,
						   TRANSF.id_empleado,   
                           (SELECT COALESCE(PERSON.nombre,'' '') || ''  ''||COALESCE(PERSON.apellido_paterno,'' '')||''  ''||COALESCE(PERSON.apellido_materno, '' '')
                           FROM kard.tkp_empleado EMPLEA
                           INNER JOIN sss.tsg_persona PERSON ON PERSON.id_persona = EMPLEA.id_persona
                           WHERE EMPLEA.id_empleado = TRANSF.id_empleado) as desc_empleado,
						   TRANSF.id_firma_autorizada_transf,
						   COALESCE(PERSON.apellido_paterno,'' '')||''  ''||COALESCE(PERSON.apellido_materno,'' '')||''  ''||COALESCE(PERSON.nombre,'' '') as desc_firma_autorizada,
                           TRANSF.id_almacen_logico,
						   ALMLOG.nombre as desc_almacen_logico_orig,
						   TRANSF.id_almacen_logico_destino,
						   ALMLOG1.nombre as desc_almacen_logico_dest,
						   TRANSF.id_motivo_ingreso_cuenta,
						   MOINCU.descripcion as desc_motivo_ingreso_cuenta,
						   ALMACE.nombre as desc_almacen_orig,
						   FINANC.nombre_financiador,
                           REGION.nombre_regional                  ,PROGRA.nombre_programa                ,PROYEC1.nombre_proyecto,
                           ACTIVI.nombre_actividad                 ,FINANC.id_financiador                 ,REGION1.id_regional,
                           PROGRA.id_programa                      ,PROYEC.id_proyecto                    ,ACTIVI1.id_actividad,
                           FINANC.codigo_financiador               ,REGION.codigo_regional                ,PROGRA1.codigo_programa,
                           PROYEC.codigo_proyecto                  ,ACTIVI.codigo_actividad,
   						   ALMACE1.nombre as desc_almacen_dest,
                           FINANC1.nombre_financiador as nombre_financiador_dest,
                           REGION1.nombre_regional as nombre_regional_dest             ,PROGRA1.nombre_programa as nombre_programa_dest         ,PROYEC1.nombre_proyecto as nombre_proyecto_dest,
                           ACTIVI1.nombre_actividad as nombre_actividad_dest           ,FINANC1.id_financiador as id_financiador_dest           ,REGION1.id_regional as id_regional_dest,
                           PROGRA1.id_programa as id_programa_dest                     ,PROYEC1.id_proyecto as id_proyecto_dest                 ,ACTIVI1.id_actividad as id_actividad_dest,
                           FINANC1.codigo_financiador as codigo_financiador_dest       ,REGION1.codigo_regional as codigo_regional_dest         ,PROGRA1.codigo_programa as codigo_programa_dest,
                           PROYEC1.codigo_proyecto as codigo_proyecto_dest             ,ACTIVI1.codigo_actividad as codigo_actividad_dest,
                           TRANSF.fecha_borrador   ,TRANSF.fecha_pendiente    ,TRANSF.fecha_rechazado   ,TRANSF.id_ingreso,
                           TRANSF.id_salida,
                           TRANSF.id_tipo_material ,TIPMAT.nombre as desc_tipo_material,
                           TRANSF.id_motivo_salida_cuenta, MOSACU.descripcion as desc_motivo_salida_cuenta,
                           MOTING.nombre as desc_motivo_ingreso, MOTSAL.nombre as desc_motivo_salida,
                           TRANSF.id_ingreso_prestamo            ,TRANSF.id_salida_prestamo
						   FROM almin.tal_transferencia TRANSF
						   LEFT JOIN kard.tkp_empleado EMPLEA
            			   ON EMPLEA.id_empleado=TRANSF.id_empleado
                           INNER JOIN almin.tal_almacen_logico ALMLOG
            			   ON ALMLOG.id_almacen_logico=TRANSF.id_almacen_logico
	                       INNER JOIN almin.tal_almacen_logico ALMLOG1
            			   ON ALMLOG1.id_almacen_logico=TRANSF.id_almacen_logico_destino
             			   INNER JOIN almin.tal_almacen_ep ALMAEP
             			   ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
             			   INNER JOIN almin.tal_almacen_ep ALMAEP1
             			   ON ALMAEP1.id_almacen_ep = ALMLOG1.id_almacen_ep
             			   INNER JOIN almin.tal_almacen ALMACE
             			   ON ALMACE.id_almacen = ALMAEP.id_almacen
             			   INNER JOIN almin.tal_almacen ALMACE1
             			   ON ALMACE1.id_almacen = ALMAEP1.id_almacen
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                           ON FRPPA.id_fina_regi_prog_proy_acti = ALMAEP.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC
                           ON FINANC.id_financiador = FRPPA.id_financiador
                           INNER JOIN param.tpm_regional REGION
                           ON REGION.id_regional = FRPPA.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC
                           ON PGPYAC.id_prog_proy_acti = FRPPA.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA
                           ON PROGRA.id_programa = PGPYAC.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC
                           ON PROYEC.id_proyecto = PGPYAC.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI
                           ON ACTIVI.id_actividad = PGPYAC.id_actividad
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA1
                           ON FRPPA1.id_fina_regi_prog_proy_acti = ALMAEP1.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC1
                           ON FINANC1.id_financiador = FRPPA1.id_financiador
                           INNER JOIN param.tpm_regional REGION1
                           ON REGION1.id_regional = FRPPA1.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC1
                           ON PGPYAC1.id_prog_proy_acti = FRPPA1.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA1
                           ON PROGRA1.id_programa = PGPYAC1.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC1
                           ON PROYEC1.id_proyecto = PGPYAC1.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI1
                           ON ACTIVI1.id_actividad = PGPYAC1.id_actividad
                           INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			   ON MOINCU.id_motivo_ingreso_cuenta=TRANSF.id_motivo_ingreso_cuenta
            			   INNER JOIN almin.tal_motivo_ingreso MOTING
            			   ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			   INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			   ON MOSACU.id_motivo_salida_cuenta=TRANSF.id_motivo_salida_cuenta
            			   INNER JOIN almin.tal_motivo_salida MOTSAL
            			   ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
            			   INNER JOIN almin.tal_firma_autorizada_transf FIRAUT
            			   ON FIRAUT.id_firma_autorizada_transf = TRANSF.id_firma_autorizada_transf
                           INNER JOIN kard.tkp_empleado EMPLEA2
                           ON EMPLEA2.id_empleado = FIRAUT.id_empleado
                           INNER JOIN sss.tsg_persona PERSON
                           ON PERSON.id_persona = EMPLEA2.id_persona
                           INNER JOIN almin.tal_tipo_material TIPMAT
                           ON TIPMAT.id_tipo_material = TRANSF.id_tipo_material
						   WHERE TRANSF.estado_transferencia = ''Pendiente'' AND 
                           MOTSAL.tipo = ''Baja'' AND ';
            g_consulta := g_consulta || pm_criterio_filtro;
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
    ELSIF pm_codigo_procedimiento  = 'AL_BAJPEN_COUNT' THEN --BAJPEN: Bajas Pendientes de aprobación

        BEGIN
        --Cuenta todos los registros
            g_consulta := 'SELECT
                           COUNT(TRANSF.id_transferencia) AS total
                           FROM almin.tal_transferencia TRANSF
						   LEFT JOIN kard.tkp_empleado EMPLEA
            			   ON EMPLEA.id_empleado=TRANSF.id_empleado
                           INNER JOIN almin.tal_almacen_logico ALMLOG
            			   ON ALMLOG.id_almacen_logico=TRANSF.id_almacen_logico
	                       INNER JOIN almin.tal_almacen_logico ALMLOG1
            			   ON ALMLOG1.id_almacen_logico=TRANSF.id_almacen_logico_destino
             			   INNER JOIN almin.tal_almacen_ep ALMAEP
             			   ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
             			   INNER JOIN almin.tal_almacen_ep ALMAEP1
             			   ON ALMAEP1.id_almacen_ep = ALMLOG1.id_almacen_ep
             			   INNER JOIN almin.tal_almacen ALMACE
             			   ON ALMACE.id_almacen = ALMAEP.id_almacen
             			   INNER JOIN almin.tal_almacen ALMACE1
             			   ON ALMACE1.id_almacen = ALMAEP1.id_almacen
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                           ON FRPPA.id_fina_regi_prog_proy_acti = ALMAEP.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC
                           ON FINANC.id_financiador = FRPPA.id_financiador
                           INNER JOIN param.tpm_regional REGION
                           ON REGION.id_regional = FRPPA.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC
                           ON PGPYAC.id_prog_proy_acti = FRPPA.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA
                           ON PROGRA.id_programa = PGPYAC.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC
                           ON PROYEC.id_proyecto = PGPYAC.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI
                           ON ACTIVI.id_actividad = PGPYAC.id_actividad
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA1
                           ON FRPPA1.id_fina_regi_prog_proy_acti = ALMAEP1.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC1
                           ON FINANC1.id_financiador = FRPPA1.id_financiador
                           INNER JOIN param.tpm_regional REGION1
                           ON REGION1.id_regional = FRPPA1.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC1
                           ON PGPYAC1.id_prog_proy_acti = FRPPA1.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA1
                           ON PROGRA1.id_programa = PGPYAC1.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC1
                           ON PROYEC1.id_proyecto = PGPYAC1.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI1
                           ON ACTIVI1.id_actividad = PGPYAC1.id_actividad
                           INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			   ON MOINCU.id_motivo_ingreso_cuenta=TRANSF.id_motivo_ingreso_cuenta
            			   INNER JOIN almin.tal_motivo_ingreso MOTING
            			   ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			   INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			   ON MOSACU.id_motivo_salida_cuenta=TRANSF.id_motivo_salida_cuenta
            			   INNER JOIN almin.tal_motivo_salida MOTSAL
            			   ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
            			   INNER JOIN almin.tal_firma_autorizada_transf FIRAUT
            			   ON FIRAUT.id_firma_autorizada_transf = TRANSF.id_firma_autorizada_transf
                           INNER JOIN kard.tkp_empleado EMPLEA2
                           ON EMPLEA2.id_empleado = FIRAUT.id_empleado
                           INNER JOIN sss.tsg_persona PERSON
                           ON PERSON.id_persona = EMPLEA2.id_persona
                           INNER JOIN almin.tal_tipo_material TIPMAT
                           ON TIPMAT.id_tipo_material = TRANSF.id_tipo_material
						   WHERE TRANSF.estado_transferencia = ''Pendiente'' AND 
                           MOTSAL.tipo = ''Baja'' AND ';
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;
    
    ELSIF pm_codigo_procedimiento  = 'AL_TRASEG_SEL' THEN --TRASEG: Transferencia Seguimiento
        BEGIN
            g_consulta := 'SELECT
                               TRANSF.id_transferencia,
                               TRANSF.prestamo,
                               TRANSF.estado_transferencia,
                               TRANSF.motivo,
                               TRANSF.descripcion,
                               TRANSF.observaciones,
                               TRANSF.fecha_pendiente_sal,
                               TRANSF.fecha_pendiente_ing,
                               TRANSF.fecha_finalizado_anulado,
                               TRANSF.id_empleado,
                               COALESCE(PERSON1.nombre,'' '') || ''  ''||COALESCE(PERSON1.apellido_paterno,'' '')||''  ''||COALESCE(PERSON1.apellido_materno, '' '') as desc_empleado,
                               TRANSF.id_firma_autorizada_transf,
                               COALESCE(PERSON.apellido_paterno,'' '')||''  ''||COALESCE(PERSON.apellido_materno,'' '')||''  ''||COALESCE(PERSON.nombre,'' '') as desc_firma_autorizada,
                               TRANSF.id_almacen_logico,
                               ALMLOG.nombre as desc_almacen_logico_orig,
                               TRANSF.id_almacen_logico_destino,
                               ALMLOG1.nombre as desc_almacen_logico_dest,
                               TRANSF.id_motivo_ingreso_cuenta,
                               MOINCU.descripcion as desc_motivo_ingreso_cuenta,
                               ALMACE.nombre as desc_almacen_orig,
                               FINANC.nombre_financiador,
                               REGION.nombre_regional                  ,PROGRA.nombre_programa                ,PROYEC1.nombre_proyecto,
                               ACTIVI.nombre_actividad                 ,FINANC.id_financiador                 ,REGION1.id_regional,
                               PROGRA.id_programa                      ,PROYEC.id_proyecto                    ,ACTIVI1.id_actividad,
                               FINANC.codigo_financiador               ,REGION.codigo_regional                ,PROGRA1.codigo_programa,
                               PROYEC.codigo_proyecto                  ,ACTIVI.codigo_actividad,
                               ALMACE1.nombre as desc_almacen_dest,
                               FINANC1.nombre_financiador as nombre_financiador_dest,
                               REGION1.nombre_regional as nombre_regional_dest             ,PROGRA1.nombre_programa as nombre_programa_dest         ,PROYEC1.nombre_proyecto as nombre_proyecto_dest,
                               ACTIVI1.nombre_actividad as nombre_actividad_dest           ,FINANC1.id_financiador as id_financiador_dest           ,REGION1.id_regional as id_regional_dest,
                               PROGRA1.id_programa as id_programa_dest                     ,PROYEC1.id_proyecto as id_proyecto_dest                 ,ACTIVI1.id_actividad as id_actividad_dest,
                               FINANC1.codigo_financiador as codigo_financiador_dest       ,REGION1.codigo_regional as codigo_regional_dest         ,PROGRA1.codigo_programa as codigo_programa_dest,
                               PROYEC1.codigo_proyecto as codigo_proyecto_dest             ,ACTIVI1.codigo_actividad as codigo_actividad_dest,

                               TRANSF.fecha_borrador   ,TRANSF.fecha_pendiente    ,TRANSF.fecha_rechazado   ,TRANSF.id_ingreso,
                               TRANSF.id_salida,
                               TRANSF.id_tipo_material ,TIPMAT.nombre as desc_tipo_material,
                               TRANSF.id_motivo_salida_cuenta, MOSACU.descripcion as desc_motivo_salida_cuenta,
                               MOTING.nombre as desc_motivo_ingreso, MOTSAL.nombre as desc_motivo_salida,
                               INGRES.correlativo_ing      ,SALIDA.correlativo_sal,
                               TRANSF.id_ingreso_prestamo  ,TRANSF.id_salida_prestamo,
                                COALESCE(TRANSF.id_transferencia_dev,0) as id_transferencia_dev,
                               TRANSF.tipo_transferencia,
                               TRANSF.importe_abierto
						   FROM almin.tal_transferencia TRANSF 
                           LEFT JOIN kard.tkp_empleado EMPLEA ON EMPLEA.id_empleado=TRANSF.id_empleado
                           INNER JOIN almin.tal_almacen_logico ALMLOG ON ALMLOG.id_almacen_logico=TRANSF.id_almacen_logico
	                       INNER JOIN almin.tal_almacen_logico ALMLOG1 ON ALMLOG1.id_almacen_logico=TRANSF.id_almacen_logico_destino
             			   INNER JOIN almin.tal_almacen_ep ALMAEP ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
             			   INNER JOIN almin.tal_almacen_ep ALMAEP1 ON ALMAEP1.id_almacen_ep = ALMLOG1.id_almacen_ep
             			   INNER JOIN almin.tal_almacen ALMACE ON ALMACE.id_almacen = ALMAEP.id_almacen
             			   INNER JOIN almin.tal_almacen ALMACE1 ON ALMACE1.id_almacen = ALMAEP1.id_almacen
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA ON FRPPA.id_fina_regi_prog_proy_acti = ALMAEP.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC ON FINANC.id_financiador = FRPPA.id_financiador
                           INNER JOIN param.tpm_regional REGION ON REGION.id_regional = FRPPA.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC ON PGPYAC.id_prog_proy_acti = FRPPA.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA ON PROGRA.id_programa = PGPYAC.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC ON PROYEC.id_proyecto = PGPYAC.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI ON ACTIVI.id_actividad = PGPYAC.id_actividad
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA1 ON FRPPA1.id_fina_regi_prog_proy_acti = ALMAEP1.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC1 ON FINANC1.id_financiador = FRPPA1.id_financiador
                           INNER JOIN param.tpm_regional REGION1 ON REGION1.id_regional = FRPPA1.id_regional 
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC1 ON PGPYAC1.id_prog_proy_acti = FRPPA1.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA1 ON PROGRA1.id_programa = PGPYAC1.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC1 ON PROYEC1.id_proyecto = PGPYAC1.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI1 ON ACTIVI1.id_actividad = PGPYAC1.id_actividad
                           INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU ON MOINCU.id_motivo_ingreso_cuenta=TRANSF.id_motivo_ingreso_cuenta
            			   INNER JOIN almin.tal_motivo_ingreso MOTING ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			   INNER JOIN almin.tal_motivo_salida_cuenta MOSACU ON MOSACU.id_motivo_salida_cuenta=TRANSF.id_motivo_salida_cuenta
            			   INNER JOIN almin.tal_motivo_salida MOTSAL ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
            			   INNER JOIN almin.tal_firma_autorizada_transf FIRAUT ON FIRAUT.id_firma_autorizada_transf = TRANSF.id_firma_autorizada_transf
                           INNER JOIN kard.tkp_empleado EMPLEA2 ON EMPLEA2.id_empleado = FIRAUT.id_empleado
                           INNER JOIN sss.tsg_persona PERSON ON PERSON.id_persona = EMPLEA2.id_persona
                           INNER JOIN almin.tal_tipo_material TIPMAT ON TIPMAT.id_tipo_material = TRANSF.id_tipo_material
                           LEFT JOIN almin.tal_ingreso INGRES ON INGRES.id_ingreso = TRANSF.id_ingreso
                           LEFT JOIN almin.tal_salida SALIDA ON SALIDA.id_salida = TRANSF.id_salida
                           INNER JOIN kard.tkp_empleado EMPLEA3 ON EMPLEA3.id_empleado= TRANSF.id_empleado
                           INNER JOIN sss.tsg_persona PERSON1 ON PERSON1.id_persona= EMPLEA3.id_persona
						   WHERE ';
            g_consulta := g_consulta || pm_criterio_filtro;
	        -- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;
        
    ELSIF pm_codigo_procedimiento  = 'AL_TRASEG_COUNT' THEN --TRASEG: Transferencias seguimiento

        BEGIN
        --Cuenta todos los registros
            g_consulta := 'SELECT
                           COUNT(TRANSF.id_transferencia) AS total
                           FROM almin.tal_transferencia TRANSF
						   LEFT JOIN kard.tkp_empleado EMPLEA
            			   ON EMPLEA.id_empleado=TRANSF.id_empleado
                           INNER JOIN almin.tal_almacen_logico ALMLOG
            			   ON ALMLOG.id_almacen_logico=TRANSF.id_almacen_logico
	                       INNER JOIN almin.tal_almacen_logico ALMLOG1
            			   ON ALMLOG1.id_almacen_logico=TRANSF.id_almacen_logico_destino
             			   INNER JOIN almin.tal_almacen_ep ALMAEP
             			   ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
             			   INNER JOIN almin.tal_almacen_ep ALMAEP1
             			   ON ALMAEP1.id_almacen_ep = ALMLOG1.id_almacen_ep
             			   INNER JOIN almin.tal_almacen ALMACE
             			   ON ALMACE.id_almacen = ALMAEP.id_almacen
             			   INNER JOIN almin.tal_almacen ALMACE1
             			   ON ALMACE1.id_almacen = ALMAEP1.id_almacen
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                           ON FRPPA.id_fina_regi_prog_proy_acti = ALMAEP.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC
                           ON FINANC.id_financiador = FRPPA.id_financiador
                           INNER JOIN param.tpm_regional REGION
                           ON REGION.id_regional = FRPPA.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC
                           ON PGPYAC.id_prog_proy_acti = FRPPA.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA
                           ON PROGRA.id_programa = PGPYAC.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC
                           ON PROYEC.id_proyecto = PGPYAC.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI
                           ON ACTIVI.id_actividad = PGPYAC.id_actividad
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA1
                           ON FRPPA1.id_fina_regi_prog_proy_acti = ALMAEP1.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC1
                           ON FINANC1.id_financiador = FRPPA1.id_financiador
                           INNER JOIN param.tpm_regional REGION1
                           ON REGION1.id_regional = FRPPA1.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC1
                           ON PGPYAC1.id_prog_proy_acti = FRPPA1.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA1
                           ON PROGRA1.id_programa = PGPYAC1.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC1
                           ON PROYEC1.id_proyecto = PGPYAC1.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI1
                           ON ACTIVI1.id_actividad = PGPYAC1.id_actividad
                           INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			   ON MOINCU.id_motivo_ingreso_cuenta=TRANSF.id_motivo_ingreso_cuenta
            			   INNER JOIN almin.tal_motivo_ingreso MOTING
            			   ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			   INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			   ON MOSACU.id_motivo_salida_cuenta=TRANSF.id_motivo_salida_cuenta
            			   INNER JOIN almin.tal_motivo_salida MOTSAL
            			   ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
            			   INNER JOIN almin.tal_firma_autorizada_transf FIRAUT
            			   ON FIRAUT.id_firma_autorizada_transf = TRANSF.id_firma_autorizada_transf
                           INNER JOIN kard.tkp_empleado EMPLEA2
                           ON EMPLEA2.id_empleado = FIRAUT.id_empleado
                           INNER JOIN sss.tsg_persona PERSON
                           ON PERSON.id_persona = EMPLEA2.id_persona
                           INNER JOIN almin.tal_tipo_material TIPMAT
                           ON TIPMAT.id_tipo_material = TRANSF.id_tipo_material
                           LEFT JOIN almin.tal_ingreso INGRES
                           ON INGRES.id_ingreso = TRANSF.id_ingreso
                           LEFT JOIN almin.tal_salida SALIDA
                           ON SALIDA.id_salida = TRANSF.id_salida
                           INNER JOIN kard.tkp_empleado EMPLEA3 ON EMPLEA3.id_empleado= TRANSF.id_empleado
                           INNER JOIN sss.tsg_persona PERSON1 ON PERSON1.id_persona= EMPLEA3.id_persona
						   WHERE ';
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;
        
    ELSIF pm_codigo_procedimiento  = 'AL_PREPEN_SEL' THEN --PREPEN: Préstamos pendientes
        BEGIN
            g_consulta := 'SELECT
				           TRANSF.id_transferencia,
						   TRANSF.prestamo,
						   TRANSF.estado_transferencia,
						   TRANSF.motivo,
						   TRANSF.descripcion,
						   TRANSF.observaciones,
						   TRANSF.fecha_pendiente_sal,
						   TRANSF.fecha_pendiente_ing,
						   TRANSF.fecha_finalizado_anulado,
						   TRANSF.id_empleado,
                           COALESCE(PERSON1.nombre,'' '') || ''  ''||COALESCE(PERSON1.apellido_paterno,'' '')||''  ''||COALESCE(PERSON1.apellido_materno, '' '') as desc_empleado,
						   TRANSF.id_firma_autorizada_transf,
						   COALESCE(PERSON.apellido_paterno,'' '')||''  ''||COALESCE(PERSON.apellido_materno,'' '')||''  ''||COALESCE(PERSON.nombre,'' '') as desc_firma_autorizada,
                           TRANSF.id_almacen_logico,
						   ALMLOG.nombre as desc_almacen_logico_orig,
						   TRANSF.id_almacen_logico_destino,
						   ALMLOG1.nombre as desc_almacen_logico_dest,
						   TRANSF.id_motivo_ingreso_cuenta,
						   MOINCU.descripcion as desc_motivo_ingreso_cuenta,
						   ALMACE.nombre as desc_almacen_orig,
						   FINANC.nombre_financiador,
                           REGION.nombre_regional                  ,PROGRA.nombre_programa                ,PROYEC1.nombre_proyecto,
                           ACTIVI.nombre_actividad                 ,FINANC.id_financiador                 ,REGION1.id_regional,
                           PROGRA.id_programa                      ,PROYEC.id_proyecto                    ,ACTIVI1.id_actividad,
                           FINANC.codigo_financiador               ,REGION.codigo_regional                ,PROGRA1.codigo_programa,
                           PROYEC.codigo_proyecto                  ,ACTIVI.codigo_actividad,
   						   ALMACE1.nombre as desc_almacen_dest,
                           FINANC1.nombre_financiador as nombre_financiador_dest,
                           REGION1.nombre_regional as nombre_regional_dest             ,PROGRA1.nombre_programa as nombre_programa_dest         ,PROYEC1.nombre_proyecto as nombre_proyecto_dest,
                           ACTIVI1.nombre_actividad as nombre_actividad_dest           ,FINANC1.id_financiador as id_financiador_dest           ,REGION1.id_regional as id_regional_dest,
                           PROGRA1.id_programa as id_programa_dest                     ,PROYEC1.id_proyecto as id_proyecto_dest                 ,ACTIVI1.id_actividad as id_actividad_dest,
                           FINANC1.codigo_financiador as codigo_financiador_dest       ,REGION1.codigo_regional as codigo_regional_dest         ,PROGRA1.codigo_programa as codigo_programa_dest,
                           PROYEC1.codigo_proyecto as codigo_proyecto_dest             ,ACTIVI1.codigo_actividad as codigo_actividad_dest,
                           TRANSF.fecha_borrador   ,TRANSF.fecha_pendiente    ,TRANSF.fecha_rechazado   ,TRANSF.id_ingreso,
                           TRANSF.id_salida,
                           TRANSF.id_tipo_material ,TIPMAT.nombre as desc_tipo_material,
                           TRANSF.id_motivo_salida_cuenta, MOSACU.descripcion as desc_motivo_salida_cuenta,
                           MOTING.nombre as desc_motivo_ingreso, MOTSAL.nombre as desc_motivo_salida,
                           TRANSF.id_ingreso_prestamo            ,TRANSF.id_salida_prestamo
						   FROM almin.tal_transferencia TRANSF
						   LEFT JOIN kard.tkp_empleado EMPLEA
            			   ON EMPLEA.id_empleado=TRANSF.id_empleado
                           INNER JOIN almin.tal_almacen_logico ALMLOG
            			   ON ALMLOG.id_almacen_logico=TRANSF.id_almacen_logico
	                       INNER JOIN almin.tal_almacen_logico ALMLOG1
            			   ON ALMLOG1.id_almacen_logico=TRANSF.id_almacen_logico_destino
             			   INNER JOIN almin.tal_almacen_ep ALMAEP
             			   ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
             			   INNER JOIN almin.tal_almacen_ep ALMAEP1
             			   ON ALMAEP1.id_almacen_ep = ALMLOG1.id_almacen_ep
             			   INNER JOIN almin.tal_almacen ALMACE
             			   ON ALMACE.id_almacen = ALMAEP.id_almacen
             			   INNER JOIN almin.tal_almacen ALMACE1
             			   ON ALMACE1.id_almacen = ALMAEP1.id_almacen
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                           ON FRPPA.id_fina_regi_prog_proy_acti = ALMAEP.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC
                           ON FINANC.id_financiador = FRPPA.id_financiador
                           INNER JOIN param.tpm_regional REGION
                           ON REGION.id_regional = FRPPA.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC
                           ON PGPYAC.id_prog_proy_acti = FRPPA.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA
                           ON PROGRA.id_programa = PGPYAC.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC
                           ON PROYEC.id_proyecto = PGPYAC.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI
                           ON ACTIVI.id_actividad = PGPYAC.id_actividad
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA1
                           ON FRPPA1.id_fina_regi_prog_proy_acti = ALMAEP1.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC1
                           ON FINANC1.id_financiador = FRPPA1.id_financiador
                           INNER JOIN param.tpm_regional REGION1
                           ON REGION1.id_regional = FRPPA1.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC1
                           ON PGPYAC1.id_prog_proy_acti = FRPPA1.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA1
                           ON PROGRA1.id_programa = PGPYAC1.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC1
                           ON PROYEC1.id_proyecto = PGPYAC1.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI1
                           ON ACTIVI1.id_actividad = PGPYAC1.id_actividad
                           INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			   ON MOINCU.id_motivo_ingreso_cuenta=TRANSF.id_motivo_ingreso_cuenta
            			   INNER JOIN almin.tal_motivo_ingreso MOTING
            			   ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			   INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			   ON MOSACU.id_motivo_salida_cuenta=TRANSF.id_motivo_salida_cuenta
            			   INNER JOIN almin.tal_motivo_salida MOTSAL
            			   ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
            			   INNER JOIN almin.tal_firma_autorizada_transf FIRAUT
            			   ON FIRAUT.id_firma_autorizada_transf = TRANSF.id_firma_autorizada_transf
                           INNER JOIN kard.tkp_empleado EMPLEA2
                           ON EMPLEA2.id_empleado = FIRAUT.id_empleado
                           INNER JOIN sss.tsg_persona PERSON
                           ON PERSON.id_persona = EMPLEA2.id_persona
                           INNER JOIN almin.tal_tipo_material TIPMAT
                           ON TIPMAT.id_tipo_material = TRANSF.id_tipo_material
                           INNER JOIN kard.tkp_empleado EMPLEA3 ON EMPLEA3.id_empleado= TRANSF.id_empleado
                           INNER JOIN sss.tsg_persona PERSON1 ON PERSON1.id_persona= EMPLEA3.id_persona
						   WHERE TRANSF.prestamo = ''si'' AND (TRANSF.estado_transferencia = ''Ingreso_prestamo''
                           OR TRANSF.estado_transferencia = ''Salida_prestamo''
                           OR TRANSF.estado_transferencia = ''Pendiente_ingreso'') AND ';
            g_consulta := g_consulta || pm_criterio_filtro;
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
    ELSIF pm_codigo_procedimiento  = 'AL_PREPEN_COUNT' THEN --PREREC: Préstamos Recepción

        BEGIN
        --Cuenta todos los registros
            g_consulta := 'SELECT
                           COUNT(TRANSF.id_transferencia) AS total
                           FROM almin.tal_transferencia TRANSF
						   LEFT JOIN kard.tkp_empleado EMPLEA
            			   ON EMPLEA.id_empleado=TRANSF.id_empleado
                           INNER JOIN almin.tal_almacen_logico ALMLOG
            			   ON ALMLOG.id_almacen_logico=TRANSF.id_almacen_logico
	                       INNER JOIN almin.tal_almacen_logico ALMLOG1
            			   ON ALMLOG1.id_almacen_logico=TRANSF.id_almacen_logico_destino
             			   INNER JOIN almin.tal_almacen_ep ALMAEP
             			   ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
             			   INNER JOIN almin.tal_almacen_ep ALMAEP1
             			   ON ALMAEP1.id_almacen_ep = ALMLOG1.id_almacen_ep
             			   INNER JOIN almin.tal_almacen ALMACE
             			   ON ALMACE.id_almacen = ALMAEP.id_almacen
             			   INNER JOIN almin.tal_almacen ALMACE1
             			   ON ALMACE1.id_almacen = ALMAEP1.id_almacen
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                           ON FRPPA.id_fina_regi_prog_proy_acti = ALMAEP.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC
                           ON FINANC.id_financiador = FRPPA.id_financiador
                           INNER JOIN param.tpm_regional REGION
                           ON REGION.id_regional = FRPPA.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC
                           ON PGPYAC.id_prog_proy_acti = FRPPA.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA
                           ON PROGRA.id_programa = PGPYAC.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC
                           ON PROYEC.id_proyecto = PGPYAC.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI
                           ON ACTIVI.id_actividad = PGPYAC.id_actividad
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA1
                           ON FRPPA1.id_fina_regi_prog_proy_acti = ALMAEP1.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC1
                           ON FINANC1.id_financiador = FRPPA1.id_financiador
                           INNER JOIN param.tpm_regional REGION1
                           ON REGION1.id_regional = FRPPA1.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC1
                           ON PGPYAC1.id_prog_proy_acti = FRPPA1.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA1
                           ON PROGRA1.id_programa = PGPYAC1.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC1
                           ON PROYEC1.id_proyecto = PGPYAC1.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI1
                           ON ACTIVI1.id_actividad = PGPYAC1.id_actividad
                           INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			   ON MOINCU.id_motivo_ingreso_cuenta=TRANSF.id_motivo_ingreso_cuenta
            			   INNER JOIN almin.tal_motivo_ingreso MOTING
            			   ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			   INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			   ON MOSACU.id_motivo_salida_cuenta=TRANSF.id_motivo_salida_cuenta
            			   INNER JOIN almin.tal_motivo_salida MOTSAL
            			   ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
            			   INNER JOIN almin.tal_firma_autorizada_transf FIRAUT
            			   ON FIRAUT.id_firma_autorizada_transf = TRANSF.id_firma_autorizada_transf
                           INNER JOIN kard.tkp_empleado EMPLEA2
                           ON EMPLEA2.id_empleado = FIRAUT.id_empleado
                           INNER JOIN sss.tsg_persona PERSON
                           ON PERSON.id_persona = EMPLEA2.id_persona
                           INNER JOIN almin.tal_tipo_material TIPMAT
                           ON TIPMAT.id_tipo_material = TRANSF.id_tipo_material
                           INNER JOIN kard.tkp_empleado EMPLEA3 ON EMPLEA3.id_empleado= TRANSF.id_empleado
                           INNER JOIN sss.tsg_persona PERSON1 ON PERSON1.id_persona= EMPLEA3.id_persona
						   WHERE TRANSF.prestamo = ''si'' AND (TRANSF.estado_transferencia = ''Ingreso_prestamo''
                           OR TRANSF.estado_transferencia = ''Salida_prestamo''
                           OR TRANSF.estado_transferencia = ''Pendiente_ingreso'') AND ';
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;

    ELSIF pm_codigo_procedimiento  = 'AL_PREDEV_SEL' THEN --PREDEV: Préstamos devolución
        BEGIN
            g_consulta := 'SELECT
				           TRANSF.id_transferencia,
						   TRANSF.prestamo,
						   TRANSF.estado_transferencia,
						   TRANSF.motivo,
						   TRANSF.descripcion,
						   TRANSF.observaciones,
						   TRANSF.fecha_pendiente_sal,
						   TRANSF.fecha_pendiente_ing,
						   TRANSF.fecha_finalizado_anulado,
						   TRANSF.id_empleado,
                           COALESCE(PERSON1.nombre,'' '') || ''  ''||COALESCE(PERSON1.apellido_paterno,'' '')||''  ''||COALESCE(PERSON1.apellido_materno, '' '') as desc_empleado,
						   TRANSF.id_firma_autorizada_transf,
						   COALESCE(PERSON.apellido_paterno,'' '')||''  ''||COALESCE(PERSON.apellido_materno,'' '')||''  ''||COALESCE(PERSON.nombre,'' '') as desc_firma_autorizada,
                           TRANSF.id_almacen_logico,
						   ALMLOG.nombre as desc_almacen_logico_orig,
						   TRANSF.id_almacen_logico_destino,
						   ALMLOG1.nombre as desc_almacen_logico_dest,
						   TRANSF.id_motivo_ingreso_cuenta,
						   MOINCU.descripcion as desc_motivo_ingreso_cuenta,
						   ALMACE.nombre as desc_almacen_orig,
						   FINANC.nombre_financiador,
                           REGION.nombre_regional                  ,PROGRA.nombre_programa                ,PROYEC1.nombre_proyecto,
                           ACTIVI.nombre_actividad                 ,FINANC.id_financiador                 ,REGION1.id_regional,
                           PROGRA.id_programa                      ,PROYEC.id_proyecto                    ,ACTIVI1.id_actividad,
                           FINANC.codigo_financiador               ,REGION.codigo_regional                ,PROGRA1.codigo_programa,
                           PROYEC.codigo_proyecto                  ,ACTIVI.codigo_actividad,
   						   ALMACE1.nombre as desc_almacen_dest,
                           FINANC1.nombre_financiador as nombre_financiador_dest,
                           REGION1.nombre_regional as nombre_regional_dest             ,PROGRA1.nombre_programa as nombre_programa_dest         ,PROYEC1.nombre_proyecto as nombre_proyecto_dest,
                           ACTIVI1.nombre_actividad as nombre_actividad_dest           ,FINANC1.id_financiador as id_financiador_dest           ,REGION1.id_regional as id_regional_dest,
                           PROGRA1.id_programa as id_programa_dest                     ,PROYEC1.id_proyecto as id_proyecto_dest                 ,ACTIVI1.id_actividad as id_actividad_dest,
                           FINANC1.codigo_financiador as codigo_financiador_dest       ,REGION1.codigo_regional as codigo_regional_dest         ,PROGRA1.codigo_programa as codigo_programa_dest,
                           PROYEC1.codigo_proyecto as codigo_proyecto_dest             ,ACTIVI1.codigo_actividad as codigo_actividad_dest,
                           TRANSF.fecha_borrador   ,TRANSF.fecha_pendiente    ,TRANSF.fecha_rechazado   ,TRANSF.id_ingreso,
                           TRANSF.id_salida,
                           TRANSF.id_tipo_material ,TIPMAT.nombre as desc_tipo_material,
                           TRANSF.id_motivo_salida_cuenta, MOSACU.descripcion as desc_motivo_salida_cuenta,
                           MOTING.nombre as desc_motivo_ingreso, MOTSAL.nombre as desc_motivo_salida,
                           TRANSF.id_ingreso_prestamo            ,TRANSF.id_salida_prestamo
						   FROM almin.tal_transferencia TRANSF
						   LEFT JOIN kard.tkp_empleado EMPLEA
            			   ON EMPLEA.id_empleado=TRANSF.id_empleado
                           INNER JOIN almin.tal_almacen_logico ALMLOG
            			   ON ALMLOG.id_almacen_logico=TRANSF.id_almacen_logico
	                       INNER JOIN almin.tal_almacen_logico ALMLOG1
            			   ON ALMLOG1.id_almacen_logico=TRANSF.id_almacen_logico_destino
             			   INNER JOIN almin.tal_almacen_ep ALMAEP
             			   ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
             			   INNER JOIN almin.tal_almacen_ep ALMAEP1
             			   ON ALMAEP1.id_almacen_ep = ALMLOG1.id_almacen_ep
             			   INNER JOIN almin.tal_almacen ALMACE
             			   ON ALMACE.id_almacen = ALMAEP.id_almacen
             			   INNER JOIN almin.tal_almacen ALMACE1
             			   ON ALMACE1.id_almacen = ALMAEP1.id_almacen
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                           ON FRPPA.id_fina_regi_prog_proy_acti = ALMAEP.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC
                           ON FINANC.id_financiador = FRPPA.id_financiador
                           INNER JOIN param.tpm_regional REGION
                           ON REGION.id_regional = FRPPA.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC
                           ON PGPYAC.id_prog_proy_acti = FRPPA.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA
                           ON PROGRA.id_programa = PGPYAC.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC
                           ON PROYEC.id_proyecto = PGPYAC.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI
                           ON ACTIVI.id_actividad = PGPYAC.id_actividad
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA1
                           ON FRPPA1.id_fina_regi_prog_proy_acti = ALMAEP1.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC1
                           ON FINANC1.id_financiador = FRPPA1.id_financiador
                           INNER JOIN param.tpm_regional REGION1
                           ON REGION1.id_regional = FRPPA1.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC1
                           ON PGPYAC1.id_prog_proy_acti = FRPPA1.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA1
                           ON PROGRA1.id_programa = PGPYAC1.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC1
                           ON PROYEC1.id_proyecto = PGPYAC1.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI1
                           ON ACTIVI1.id_actividad = PGPYAC1.id_actividad
                           INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			   ON MOINCU.id_motivo_ingreso_cuenta=TRANSF.id_motivo_ingreso_cuenta
            			   INNER JOIN almin.tal_motivo_ingreso MOTING
            			   ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			   INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			   ON MOSACU.id_motivo_salida_cuenta=TRANSF.id_motivo_salida_cuenta
            			   INNER JOIN almin.tal_motivo_salida MOTSAL
            			   ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
            			   INNER JOIN almin.tal_firma_autorizada_transf FIRAUT
            			   ON FIRAUT.id_firma_autorizada_transf = TRANSF.id_firma_autorizada_transf
                           INNER JOIN kard.tkp_empleado EMPLEA2
                           ON EMPLEA2.id_empleado = FIRAUT.id_empleado
                           INNER JOIN sss.tsg_persona PERSON
                           ON PERSON.id_persona = EMPLEA2.id_persona
                           INNER JOIN almin.tal_tipo_material TIPMAT
                           ON TIPMAT.id_tipo_material = TRANSF.id_tipo_material
                           INNER JOIN kard.tkp_empleado EMPLEA3 ON EMPLEA3.id_empleado= TRANSF.id_empleado
                           INNER JOIN sss.tsg_persona PERSON1 ON PERSON1.id_persona= EMPLEA3.id_persona
						   WHERE TRANSF.estado_transferencia = ''Salida_prestamo'' AND ';
            g_consulta := g_consulta || pm_criterio_filtro;
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
    ELSIF pm_codigo_procedimiento  = 'AL_PREDEV_COUNT' THEN --PREREC: Préstamos Recepción

        BEGIN
        --Cuenta todos los registros
            g_consulta := 'SELECT
                           COUNT(TRANSF.id_transferencia) AS total
                           FROM almin.tal_transferencia TRANSF
						   LEFT JOIN kard.tkp_empleado EMPLEA
            			   ON EMPLEA.id_empleado=TRANSF.id_empleado
                           INNER JOIN almin.tal_almacen_logico ALMLOG
            			   ON ALMLOG.id_almacen_logico=TRANSF.id_almacen_logico
	                       INNER JOIN almin.tal_almacen_logico ALMLOG1
            			   ON ALMLOG1.id_almacen_logico=TRANSF.id_almacen_logico_destino
             			   INNER JOIN almin.tal_almacen_ep ALMAEP
             			   ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
             			   INNER JOIN almin.tal_almacen_ep ALMAEP1
             			   ON ALMAEP1.id_almacen_ep = ALMLOG1.id_almacen_ep
             			   INNER JOIN almin.tal_almacen ALMACE
             			   ON ALMACE.id_almacen = ALMAEP.id_almacen
             			   INNER JOIN almin.tal_almacen ALMACE1
             			   ON ALMACE1.id_almacen = ALMAEP1.id_almacen
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                           ON FRPPA.id_fina_regi_prog_proy_acti = ALMAEP.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC
                           ON FINANC.id_financiador = FRPPA.id_financiador
                           INNER JOIN param.tpm_regional REGION
                           ON REGION.id_regional = FRPPA.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC
                           ON PGPYAC.id_prog_proy_acti = FRPPA.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA
                           ON PROGRA.id_programa = PGPYAC.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC
                           ON PROYEC.id_proyecto = PGPYAC.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI
                           ON ACTIVI.id_actividad = PGPYAC.id_actividad
                           INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA1
                           ON FRPPA1.id_fina_regi_prog_proy_acti = ALMAEP1.id_fina_regi_prog_proy_acti
                           INNER JOIN param.tpm_financiador FINANC1
                           ON FINANC1.id_financiador = FRPPA1.id_financiador
                           INNER JOIN param.tpm_regional REGION1
                           ON REGION1.id_regional = FRPPA1.id_regional
                           INNER JOIN param.tpm_programa_proyecto_actividad PGPYAC1
                           ON PGPYAC1.id_prog_proy_acti = FRPPA1.id_prog_proy_acti
                           INNER JOIN param.tpm_programa PROGRA1
                           ON PROGRA1.id_programa = PGPYAC1.id_programa
                           INNER JOIN param.tpm_proyecto PROYEC1
                           ON PROYEC1.id_proyecto = PGPYAC1.id_proyecto
                           INNER JOIN param.tpm_actividad ACTIVI1
                           ON ACTIVI1.id_actividad = PGPYAC1.id_actividad
                           INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			   ON MOINCU.id_motivo_ingreso_cuenta=TRANSF.id_motivo_ingreso_cuenta
            			   INNER JOIN almin.tal_motivo_ingreso MOTING
            			   ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			   INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			   ON MOSACU.id_motivo_salida_cuenta=TRANSF.id_motivo_salida_cuenta
            			   INNER JOIN almin.tal_motivo_salida MOTSAL
            			   ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
            			   INNER JOIN almin.tal_firma_autorizada_transf FIRAUT
            			   ON FIRAUT.id_firma_autorizada_transf = TRANSF.id_firma_autorizada_transf
                           INNER JOIN kard.tkp_empleado EMPLEA2
                           ON EMPLEA2.id_empleado = FIRAUT.id_empleado
                           INNER JOIN sss.tsg_persona PERSON
                           ON PERSON.id_persona = EMPLEA2.id_persona
                           INNER JOIN almin.tal_tipo_material TIPMAT
                           ON TIPMAT.id_tipo_material = TRANSF.id_tipo_material
                           INNER JOIN kard.tkp_empleado EMPLEA3 ON EMPLEA3.id_empleado= TRANSF.id_empleado
                           INNER JOIN sss.tsg_persona PERSON1 ON PERSON1.id_persona= EMPLEA3.id_persona
						   WHERE TRANSF.estado_transferencia = ''Salida_prestamo'' AND ';
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