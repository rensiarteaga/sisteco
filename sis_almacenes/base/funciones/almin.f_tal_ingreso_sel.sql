--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_tal_ingreso_sel (
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
 SCRIPT: 		almin.f_tal_ingreso
 DESCRIPCIÓN: 	Devuelve las consultas a la tabla almin.tal_ingreso
 AUTOR: 		(Generado Automaticamente)
 FECHA:			2007-10-18 20:48:30
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
    g_nombre_funcion := 'almin.f_tal_ingreso_sel';

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
    --raise exception '%', pm_codigo_procedimiento; --INGRES.tipo_costeo
    ---***SELECCIÓN DE OPERACIÓN A REALIZAR
    IF pm_codigo_procedimiento  = 'AL_OINSOL_SEL' THEN
    --Selección de las ordenes de ingreso en borrador
        BEGIN
            g_consulta := 'SELECT  distinct
                              INGRES.id_ingreso                       ,INGRES.correlativo_ord_ing             ,INGRES.correlativo_ing,
                              INGRES.descripcion,
                              INGRES.costo_total                      ,INGRES.contabilizar                    ,INGRES.contabilizado,
                              INGRES.estado_ingreso                   ,INGRES.estado_registro                 ,INGRES.cod_inf_tec,
                              INGRES.resumen_inf_tec                  ,INGRES.fecha_borrador                  ,INGRES.fecha_pendiente,
                              INGRES.fecha_aprobado_rechazado         ,INGRES.fecha_ing_fisico                ,INGRES.fecha_ing_valorado,
                              INGRES.fecha_finalizado_cancelado       ,INGRES.fecha_reg                       ,INGRES.id_responsable_almacen,
                              RESALM.cargo as desc_responsable_almacen,INGRES.id_proveedor                    ,PROVEE.codigo as desc_proveedor,
                              INGRES.id_contratista                   ,CONTRA.codigo as desc_contratista      ,INGRES.id_empleado,
                              (COALESCE(PERSON.nombre,'' '' )||''  ''||COALESCE(PERSON.apellido_paterno,'' '')||''  ''||COALESCE(PERSON.apellido_materno,'' '')) as desc_empleado,
                              INGRES.id_almacen_logico               ,ALMLOG.nombre as desc_almacen_logico,
                              INGRES.id_firma_autorizada              ,FIRAUT.descripcion as desc_firma_autorizada ,INGRES.id_institucion,
                              INSTIT.nombre as desc_institucion       ,INGRES.id_motivo_ingreso_cuenta        ,MOINCU.descripcion as desc_motivo_ingreso_cuenta,
                              (SELECT CASE
                                        WHEN PROVEE.id_institucion IS NOT NULL THEN (SELECT INSTIT1.nombre FROM param.tpm_institucion INSTIT1 WHERE INSTIT1.id_institucion = PROVEE.id_institucion)
                                        WHEN PROVEE.id_persona IS NOT NULL THEN (SELECT COALESCE(PERSON1.nombre,'' '')||''  ''||COALESCE(PERSON1.apellido_paterno,'' '')||''  ''||COALESCE(PERSON1.apellido_materno,'' '') FROM sss.tsg_persona PERSON1 WHERE PERSON1.id_persona = PROVEE.id_persona)
                                      END) as nombre_proveedor,
                              (SELECT CASE
                                        WHEN CONTRA.id_institucion IS NOT NULL THEN (SELECT INSTIT.nombre FROM param.tpm_institucion INSTIT WHERE INSTIT.id_institucion = CONTRA.id_institucion)
                                        WHEN CONTRA.id_persona IS NOT NULL THEN (SELECT COALESCE(PERSON.nombre,'' '')||''  ''||COALESCE(PERSON.apellido_paterno,'' '')||''  ''||COALESCE(PERSON.apellido_materno,'' '') FROM sss.tsg_persona PERSON WHERE PERSON.id_persona = CONTRA.id_persona)
                                      END) as nombre_contratista,
                              (SELECT CUENTA.nro_cuenta FROM sci.tct_cuenta CUENTA WHERE CUENTA.id_cuenta = MOINCU.id_cuenta) as nro_cuenta,
                              MOTING.nombre as desc_motivo_ingreso    ,ALMACE.nombre as desc_almacen         ,FINANC.nombre_financiador,
                              REGION.nombre_regional                  ,PROGRA.nombre_programa                ,PROYEC.nombre_proyecto,
                              ACTIVI.nombre_actividad                 ,FINANC.id_financiador                 ,REGION.id_regional,
                              PROGRA.id_programa                      ,PROYEC.id_proyecto                    ,ACTIVI.id_actividad,
                              FINANC.codigo_financiador               ,REGION.codigo_regional                ,PROGRA.codigo_programa,
                              PROYEC.codigo_proyecto                  ,ACTIVI.codigo_actividad               ,INGRES.orden_compra,
                              INGRES.observaciones                    ,INGRES.id_usuario                     ,TIPALM.contabilizar
                              
						  FROM almin.tal_ingreso INGRES
	                      LEFT JOIN almin.tal_responsable_almacen RESALM
            			  ON RESALM.id_responsable_almacen=INGRES.id_responsable_almacen
	                      LEFT JOIN compro.tad_proveedor PROVEE
            			  ON PROVEE.id_proveedor=INGRES.id_proveedor
	                      LEFT JOIN param.tpm_contratista CONTRA
            			  ON CONTRA.id_contratista=INGRES.id_contratista
	                      LEFT JOIN kard.tkp_empleado EMPLEA
            			  ON EMPLEA.id_empleado=INGRES.id_empleado
	                      INNER JOIN almin.tal_almacen_logico ALMLOG
            			  ON ALMLOG.id_almacen_logico=INGRES.id_almacen_logico
	                      INNER JOIN almin.tal_firma_autorizada FIRAUT
            		      ON FIRAUT.id_firma_autorizada=INGRES.id_firma_autorizada
	                      LEFT JOIN param.tpm_institucion INSTIT
            			  ON INSTIT.id_institucion=INGRES.id_institucion
	                      INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			  ON MOINCU.id_motivo_ingreso_cuenta=INGRES.id_motivo_ingreso_cuenta
            			  INNER JOIN almin.tal_motivo_ingreso MOTING
            			  ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			  INNER JOIN almin.tal_almacen_ep ALMAEP
                          ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
                          INNER JOIN almin.tal_almacen ALMACE
                          ON ALMACE.id_almacen = ALMAEP.id_almacen
                          INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                          ON FRPPA.id_fina_regi_prog_proy_acti = MOINCU.id_fina_regi_prog_proy_acti
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
                          LEFT JOIN kard.tkp_empleado EMPLEA1 ON EMPLEA1.id_empleado = INGRES.id_empleado
                          LEFT JOIN sss.tsg_persona PERSON ON PERSON.id_persona= EMPLEA1.id_persona AND EMPLEA.id_empleado= EMPLEA1.id_empleado
                          INNER JOIN almin.tal_tipo_almacen TIPALM ON TIPALM.id_tipo_almacen= ALMLOG.id_tipo_almacen
						  WHERE INGRES.estado_ingreso = ''Borrador'' AND ';
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
    ELSIF pm_codigo_procedimiento  = 'AL_OINSOL_COUNT' THEN
    --Cuenta los registros de las órdenes de ingreso en Borrador
        BEGIN
        --Cuenta todos los registros
            g_consulta := 	'SELECT
    	                    COUNT(INGRES.id_ingreso) AS total
                          	FROM almin.tal_ingreso INGRES
	                        LEFT JOIN almin.tal_responsable_almacen RESALM
            			    ON RESALM.id_responsable_almacen=INGRES.id_responsable_almacen
	                        LEFT JOIN compro.tad_proveedor PROVEE
            			    ON PROVEE.id_proveedor=INGRES.id_proveedor
	                        LEFT JOIN param.tpm_contratista CONTRA
            			    ON CONTRA.id_contratista=INGRES.id_contratista
	                        LEFT JOIN kard.tkp_empleado EMPLEA
            			    ON EMPLEA.id_empleado=INGRES.id_empleado
	                        INNER JOIN almin.tal_almacen_logico ALMLOG
            			    ON ALMLOG.id_almacen_logico=INGRES.id_almacen_logico
	                        INNER JOIN almin.tal_firma_autorizada FIRAUT
            		        ON FIRAUT.id_firma_autorizada=INGRES.id_firma_autorizada
	                        LEFT JOIN param.tpm_institucion INSTIT
            			    ON INSTIT.id_institucion=INGRES.id_institucion
	                        INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			    ON MOINCU.id_motivo_ingreso_cuenta=INGRES.id_motivo_ingreso_cuenta
            			    INNER JOIN almin.tal_motivo_ingreso MOTING
            			    ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			    INNER JOIN almin.tal_almacen_ep ALMAEP
                            ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
                            INNER JOIN almin.tal_almacen ALMACE
                            ON ALMACE.id_almacen = ALMAEP.id_almacen
                            INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                            ON FRPPA.id_fina_regi_prog_proy_acti = MOINCU.id_fina_regi_prog_proy_acti
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
                            LEFT JOIN kard.tkp_empleado EMPLEA1 ON EMPLEA1.id_empleado = INGRES.id_empleado
                            LEFT JOIN sss.tsg_persona PERSON ON PERSON.id_persona= EMPLEA1.id_persona AND EMPLEA.id_empleado= EMPLEA1.id_empleado
                            INNER JOIN almin.tal_tipo_almacen TIPALM ON TIPALM.id_tipo_almacen= ALMLOG.id_tipo_almacen
						    WHERE INGRES.estado_ingreso = ''Borrador'' AND ';
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;


    ELSIF pm_codigo_procedimiento  = 'AL_OINAPR_SEL' THEN
        -- Seleccionar las òrdenes de ingreso para aprobación (estado = pendiente)
        BEGIN
            g_consulta := 'SELECT
						  INGRES.id_ingreso                       ,INGRES.correlativo_ord_ing             ,INGRES.correlativo_ing,
						  INGRES.descripcion,
						  INGRES.costo_total                      ,INGRES.contabilizar                    ,INGRES.contabilizado,
						  INGRES.estado_ingreso                   ,INGRES.estado_registro                 ,INGRES.cod_inf_tec,
						  INGRES.resumen_inf_tec                  ,INGRES.fecha_borrador                  ,INGRES.fecha_pendiente,
						  INGRES.fecha_aprobado_rechazado         ,INGRES.fecha_ing_fisico                ,INGRES.fecha_ing_valorado,
						  INGRES.fecha_finalizado_cancelado       ,INGRES.fecha_reg                       ,INGRES.id_responsable_almacen,
						  RESALM.cargo as desc_responsable_almacen,INGRES.id_proveedor                    ,PROVEE.codigo as desc_proveedor,
						  INGRES.id_contratista                   ,CONTRA.codigo as desc_contratista      ,INGRES.id_empleado,
						  (COALESCE(PERSON1.nombre,'' '' )||''  ''||COALESCE(PERSON1.apellido_paterno,'' '')||''  ''||COALESCE(PERSON1.apellido_materno,'' '')) as desc_empleado,
                          
                          INGRES.id_almacen_logico               ,ALMLOG.nombre as desc_almacen_logico,
						  INGRES.id_firma_autorizada,
                          COALESCE(PERSON.apellido_paterno,'' '')||''  ''||COALESCE(PERSON.apellido_materno,'' '')||''  ''||COALESCE(PERSON.nombre,'' '') as desc_firma_autorizada,
                          INGRES.id_institucion,
						  INSTIT.nombre as desc_institucion       ,INGRES.id_motivo_ingreso_cuenta        ,MOINCU.descripcion as desc_motivo_ingreso_cuenta,
						  (SELECT CASE
                                    WHEN PROVEE.id_institucion IS NOT NULL THEN (SELECT INSTIT1.nombre FROM param.tpm_institucion INSTIT1 WHERE INSTIT1.id_institucion = PROVEE.id_institucion)
                                    WHEN PROVEE.id_persona IS NOT NULL THEN (SELECT COALESCE(PERSON1.nombre,'' '')||''  ''||COALESCE(PERSON1.apellido_paterno,'' '')||''  ''||COALESCE(PERSON1.apellido_materno,'' '') FROM sss.tsg_persona PERSON1 WHERE PERSON1.id_persona = PROVEE.id_persona)
                                  END) as nombre_proveedor,
                          (SELECT CASE
                                    WHEN CONTRA.id_institucion IS NOT NULL THEN (SELECT INSTIT.nombre FROM param.tpm_institucion INSTIT WHERE INSTIT.id_institucion = CONTRA.id_institucion)
                                    WHEN CONTRA.id_persona IS NOT NULL THEN (SELECT COALESCE(PERSON.nombre,'' '')||''  ''||COALESCE(PERSON.apellido_paterno,'' '')||''  ''||COALESCE(PERSON.apellido_materno,'' '') FROM sss.tsg_persona PERSON WHERE PERSON.id_persona = CONTRA.id_persona)
                                  END) as nombre_contratista,
                          (SELECT CUENTA.nro_cuenta FROM sci.tct_cuenta CUENTA WHERE CUENTA.id_cuenta = MOINCU.id_cuenta) as nro_cuenta,
                          MOTING.nombre as desc_motivo_ingreso    ,ALMACE.nombre as desc_almacen         ,FINANC.nombre_financiador,
                          REGION.nombre_regional                  ,PROGRA.nombre_programa                ,PROYEC.nombre_proyecto,
                          ACTIVI.nombre_actividad                 ,INGRES.orden_compra                   ,INGRES.observaciones,
                          INGRES.id_usuario                       ,TIPALM.contabilizar
						  FROM almin.tal_ingreso INGRES                 
	                      LEFT JOIN almin.tal_responsable_almacen RESALM
            			  ON RESALM.id_responsable_almacen=INGRES.id_responsable_almacen
	                      LEFT JOIN compro.tad_proveedor PROVEE
            			  ON PROVEE.id_proveedor=INGRES.id_proveedor
	                      LEFT JOIN param.tpm_contratista CONTRA
            			  ON CONTRA.id_contratista=INGRES.id_contratista
	                      LEFT JOIN kard.tkp_empleado EMPLEA
            			  ON EMPLEA.id_empleado=INGRES.id_empleado
	                      INNER JOIN almin.tal_almacen_logico ALMLOG
            			  ON ALMLOG.id_almacen_logico=INGRES.id_almacen_logico
	                      INNER JOIN almin.tal_firma_autorizada FIRAUT
            		      ON FIRAUT.id_firma_autorizada=INGRES.id_firma_autorizada
	                      LEFT JOIN param.tpm_institucion INSTIT
            			  ON INSTIT.id_institucion=INGRES.id_institucion
	                      INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			  ON MOINCU.id_motivo_ingreso_cuenta=INGRES.id_motivo_ingreso_cuenta
            			  INNER JOIN almin.tal_motivo_ingreso MOTING
            			  ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			  INNER JOIN almin.tal_almacen_ep ALMAEP
                          ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
                          INNER JOIN almin.tal_almacen ALMACE
                          ON ALMACE.id_almacen = ALMAEP.id_almacen
                          INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                          ON FRPPA.id_fina_regi_prog_proy_acti = MOINCU.id_fina_regi_prog_proy_acti
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
                          INNER JOIN kard.tkp_empleado_tpm_frppa EMPFRP
                          ON EMPFRP.id_empleado_frppa = FIRAUT.id_empleado_frppa
                          INNER JOIN kard.tkp_empleado EMPLEA1
                          ON EMPLEA1.id_empleado = EMPFRP.id_empleado
                          INNER JOIN sss.tsg_persona PERSON
                          ON PERSON.id_persona = EMPLEA1.id_persona
                          LEFT JOIN kard.tkp_empleado EMPLEA2 ON EMPLEA2.id_empleado=INGRES.id_empleado
                          LEFT JOIN sss.tsg_persona PERSON1 ON PERSON1.id_persona = EMPLEA2.id_persona
                          INNER JOIN almin.tal_tipo_almacen TIPALM ON TIPALM.id_tipo_almacen= ALMLOG.id_tipo_almacen
						  WHERE INGRES.estado_ingreso = ''Pendiente'' AND ';
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
        
    ELSIF pm_codigo_procedimiento  = 'AL_OINAPR_COUNT' THEN
        -- Contar los registros para aprobación (estado= pendiente)
        BEGIN
        --Cuenta todos los registros
            g_consulta := 	'SELECT
                          	 COUNT(INGRES.id_ingreso) AS total
                          	 FROM almin.tal_ingreso INGRES
	                         LEFT JOIN almin.tal_responsable_almacen RESALM
            			     ON RESALM.id_responsable_almacen=INGRES.id_responsable_almacen
	                         LEFT JOIN compro.tad_proveedor PROVEE
            			     ON PROVEE.id_proveedor=INGRES.id_proveedor
	                         LEFT JOIN param.tpm_contratista CONTRA
            			     ON CONTRA.id_contratista=INGRES.id_contratista
	                         LEFT JOIN kard.tkp_empleado EMPLEA
            			     ON EMPLEA.id_empleado=INGRES.id_empleado
	                         INNER JOIN almin.tal_almacen_logico ALMLOG
            			     ON ALMLOG.id_almacen_logico=INGRES.id_almacen_logico
	                         INNER JOIN almin.tal_firma_autorizada FIRAUT
            		         ON FIRAUT.id_firma_autorizada=INGRES.id_firma_autorizada
	                         LEFT JOIN param.tpm_institucion INSTIT
            			     ON INSTIT.id_institucion=INGRES.id_institucion
	                         INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			     ON MOINCU.id_motivo_ingreso_cuenta=INGRES.id_motivo_ingreso_cuenta
            			     INNER JOIN almin.tal_motivo_ingreso MOTING
            			     ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			     INNER JOIN almin.tal_almacen_ep ALMAEP
                             ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
                             INNER JOIN almin.tal_almacen ALMACE
                             ON ALMACE.id_almacen = ALMAEP.id_almacen
                             INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                             ON FRPPA.id_fina_regi_prog_proy_acti = MOINCU.id_fina_regi_prog_proy_acti
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
                             INNER JOIN kard.tkp_empleado_tpm_frppa EMPFRP
                             ON EMPFRP.id_empleado_frppa = FIRAUT.id_empleado_frppa
                             INNER JOIN kard.tkp_empleado EMPLEA1
                             ON EMPLEA1.id_empleado = EMPFRP.id_empleado
                             INNER JOIN sss.tsg_persona PERSON
                             ON PERSON.id_persona = EMPLEA1.id_persona
                             LEFT JOIN kard.tkp_empleado EMPLEA2 ON EMPLEA2.id_empleado=INGRES.id_empleado
                             LEFT JOIN sss.tsg_persona PERSON1 ON PERSON1.id_persona = EMPLEA2.id_persona
                             INNER JOIN almin.tal_tipo_almacen TIPALM ON TIPALM.id_tipo_almacen= ALMLOG.id_tipo_almacen
						     WHERE INGRES.estado_ingreso = ''Pendiente'' AND ';
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;
        
    ELSIF pm_codigo_procedimiento  = 'AL_INGPEN_SEL' THEN
        -- Selección de los ingresos pendientes de recepción (estado = aprobado)
        BEGIN
            g_consulta := 'SELECT
						  INGRES.id_ingreso                       ,INGRES.correlativo_ord_ing             ,INGRES.correlativo_ing,
						  INGRES.descripcion,
						  INGRES.costo_total                      ,INGRES.contabilizar                    ,INGRES.contabilizado,
						  INGRES.estado_ingreso                   ,INGRES.estado_registro                 ,INGRES.cod_inf_tec,
						  INGRES.resumen_inf_tec                  ,INGRES.fecha_borrador                  ,INGRES.fecha_pendiente,
						  INGRES.fecha_aprobado_rechazado         ,INGRES.fecha_ing_fisico                ,INGRES.fecha_ing_valorado,
						  INGRES.fecha_finalizado_cancelado       ,INGRES.fecha_reg                       ,INGRES.id_responsable_almacen,
						  RESALM.cargo as desc_responsable_almacen,INGRES.id_proveedor                    ,PROVEE.codigo as desc_proveedor,
						  INGRES.id_contratista                   ,CONTRA.codigo as desc_contratista      ,INGRES.id_empleado,
 						 COALESCE(PERSON1.apellido_paterno,'' '')||''  ''||COALESCE(PERSON1.apellido_materno,'' '')||''  ''||COALESCE(PERSON1.nombre,'' '') as desc_empleado,
                          
                          INGRES.id_almacen_logico               ,ALMLOG.nombre as desc_almacen_logico,
						  INGRES.id_firma_autorizada,
                          COALESCE(PERSON.apellido_paterno,'' '')||''  ''||COALESCE(PERSON.apellido_materno,'' '')||''  ''||COALESCE(PERSON.nombre,'' '') as desc_firma_autorizada,
                          INGRES.id_institucion,
						  INSTIT.nombre as desc_institucion       ,INGRES.id_motivo_ingreso_cuenta        ,MOINCU.descripcion as desc_motivo_ingreso_cuenta,
						  (SELECT CASE
                                    WHEN PROVEE.id_institucion IS NOT NULL THEN (SELECT INSTIT1.nombre FROM param.tpm_institucion INSTIT1 WHERE INSTIT1.id_institucion = PROVEE.id_institucion)
                                    WHEN PROVEE.id_persona IS NOT NULL THEN (SELECT COALESCE(PERSON1.nombre,'' '')||''  ''||COALESCE(PERSON1.apellido_paterno,'' '')||''  ''||COALESCE(PERSON1.apellido_materno,'' '') FROM sss.tsg_persona PERSON1 WHERE PERSON1.id_persona = PROVEE.id_persona)
                                  END) as nombre_proveedor,
                          (SELECT CASE
                                    WHEN CONTRA.id_institucion IS NOT NULL THEN (SELECT INSTIT.nombre FROM param.tpm_institucion INSTIT WHERE INSTIT.id_institucion = CONTRA.id_institucion)
                                    WHEN CONTRA.id_persona IS NOT NULL THEN (SELECT COALESCE(PERSON.nombre,'' '')||''  ''||COALESCE(PERSON.apellido_paterno,'' '')||''  ''||COALESCE(PERSON.apellido_materno,'' '') FROM sss.tsg_persona PERSON WHERE PERSON.id_persona = CONTRA.id_persona)
                                  END) as nombre_contratista,
                          (SELECT CUENTA.nro_cuenta FROM sci.tct_cuenta CUENTA WHERE CUENTA.id_cuenta = MOINCU.id_cuenta) as nro_cuenta,
                          MOTING.nombre as desc_motivo_ingreso    ,ALMACE.nombre as desc_almacen         ,FINANC.nombre_financiador,
                          REGION.nombre_regional                  ,PROGRA.nombre_programa                ,PROYEC.nombre_proyecto,
                          ACTIVI.nombre_actividad                 ,INGRES.orden_compra                   ,INGRES.observaciones,
                          INGRES.id_usuario                       ,TIPALM.contabilizar
						  FROM almin.tal_ingreso INGRES
	                      LEFT JOIN almin.tal_responsable_almacen RESALM
            			  ON RESALM.id_responsable_almacen=INGRES.id_responsable_almacen
	                      LEFT JOIN compro.tad_proveedor PROVEE
            			  ON PROVEE.id_proveedor=INGRES.id_proveedor
	                      LEFT JOIN param.tpm_contratista CONTRA
            			  ON CONTRA.id_contratista=INGRES.id_contratista
	                      LEFT JOIN kard.tkp_empleado EMPLEA
            			  ON EMPLEA.id_empleado=INGRES.id_empleado
	                      INNER JOIN almin.tal_almacen_logico ALMLOG
            			  ON ALMLOG.id_almacen_logico=INGRES.id_almacen_logico
	                      INNER JOIN almin.tal_firma_autorizada FIRAUT
            		      ON FIRAUT.id_firma_autorizada=INGRES.id_firma_autorizada
	                      LEFT JOIN param.tpm_institucion INSTIT
            			  ON INSTIT.id_institucion=INGRES.id_institucion
	                      INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			  ON MOINCU.id_motivo_ingreso_cuenta=INGRES.id_motivo_ingreso_cuenta
            			  INNER JOIN almin.tal_motivo_ingreso MOTING
            			  ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			  INNER JOIN almin.tal_almacen_ep ALMAEP
                          ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
                          INNER JOIN almin.tal_almacen ALMACE
                          ON ALMACE.id_almacen = ALMAEP.id_almacen
                          INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                          ON FRPPA.id_fina_regi_prog_proy_acti = MOINCU.id_fina_regi_prog_proy_acti
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
                          INNER JOIN kard.tkp_empleado_tpm_frppa EMPFRP
                          ON EMPFRP.id_empleado_frppa = FIRAUT.id_empleado_frppa
                          INNER JOIN kard.tkp_empleado EMPLEA1
                          ON EMPLEA1.id_empleado = EMPFRP.id_empleado
                          INNER JOIN sss.tsg_persona PERSON
                          ON PERSON.id_persona = EMPLEA1.id_persona
                          LEFT JOIN kard.tkp_empleado EMPLEA2 ON EMPLEA2.id_empleado=INGRES.id_empleado
                          LEFT JOIN sss.tsg_persona PERSON1 ON PERSON1.id_persona = EMPLEA2.id_persona
                          INNER JOIN almin.tal_tipo_almacen TIPALM ON TIPALM.id_tipo_almacen= ALMLOG.id_tipo_almacen
						  WHERE INGRES.estado_ingreso = ''Aprobado'' AND ';
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
        
    ELSIF pm_codigo_procedimiento  = 'AL_INGPEN_COUNT' THEN
        -- Contar los ingresos pendientes de recepción (estado = aprobado)
        BEGIN
            g_consulta := 'SELECT
						  COUNT(INGRES.id_ingreso) AS total
						  FROM almin.tal_ingreso INGRES
	                      LEFT JOIN almin.tal_responsable_almacen RESALM
            			  ON RESALM.id_responsable_almacen=INGRES.id_responsable_almacen
	                      LEFT JOIN compro.tad_proveedor PROVEE
            			  ON PROVEE.id_proveedor=INGRES.id_proveedor
	                      LEFT JOIN param.tpm_contratista CONTRA
            			  ON CONTRA.id_contratista=INGRES.id_contratista
	                      LEFT JOIN kard.tkp_empleado EMPLEA
            			  ON EMPLEA.id_empleado=INGRES.id_empleado
	                      INNER JOIN almin.tal_almacen_logico ALMLOG
            			  ON ALMLOG.id_almacen_logico=INGRES.id_almacen_logico
	                      INNER JOIN almin.tal_firma_autorizada FIRAUT
            		      ON FIRAUT.id_firma_autorizada=INGRES.id_firma_autorizada
	                      LEFT JOIN param.tpm_institucion INSTIT
            			  ON INSTIT.id_institucion=INGRES.id_institucion
	                      INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			  ON MOINCU.id_motivo_ingreso_cuenta=INGRES.id_motivo_ingreso_cuenta
            			  INNER JOIN almin.tal_motivo_ingreso MOTING
            			  ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			  INNER JOIN almin.tal_almacen_ep ALMAEP
                          ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
                          INNER JOIN almin.tal_almacen ALMACE
                          ON ALMACE.id_almacen = ALMAEP.id_almacen
                          INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                          ON FRPPA.id_fina_regi_prog_proy_acti = MOINCU.id_fina_regi_prog_proy_acti
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
                          INNER JOIN kard.tkp_empleado_tpm_frppa EMPFRP
                          ON EMPFRP.id_empleado_frppa = FIRAUT.id_empleado_frppa
                          INNER JOIN kard.tkp_empleado EMPLEA1
                          ON EMPLEA1.id_empleado = EMPFRP.id_empleado
                          INNER JOIN sss.tsg_persona PERSON
                          ON PERSON.id_persona = EMPLEA1.id_persona
                          LEFT JOIN kard.tkp_empleado EMPLEA2 ON EMPLEA2.id_empleado=INGRES.id_empleado
                          LEFT JOIN sss.tsg_persona PERSON1 ON PERSON1.id_persona = EMPLEA2.id_persona
                          INNER JOIN almin.tal_tipo_almacen TIPALM ON TIPALM.id_tipo_almacen= ALMLOG.id_tipo_almacen
						  WHERE INGRES.estado_ingreso = ''Aprobado'' AND ';
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;
        
    ELSIF pm_codigo_procedimiento  = 'AL_INGVAL_SEL' THEN
        -- Selección de los ingresos pendientes de valoración (estado = fisico)
        BEGIN
            g_consulta := 'SELECT
						  INGRES.id_ingreso                       ,INGRES.correlativo_ord_ing             ,INGRES.correlativo_ing,
						  INGRES.descripcion,
						  INGRES.costo_total                      ,INGRES.contabilizar                    ,INGRES.contabilizado,
						  INGRES.estado_ingreso                   ,INGRES.estado_registro                 ,INGRES.cod_inf_tec,
						  INGRES.resumen_inf_tec                  ,INGRES.fecha_borrador                  ,INGRES.fecha_pendiente,
						  INGRES.fecha_aprobado_rechazado         ,INGRES.fecha_ing_fisico                ,INGRES.fecha_ing_valorado,
						  INGRES.fecha_finalizado_cancelado       ,INGRES.fecha_reg                       ,INGRES.id_responsable_almacen,
						  RESALM.cargo as desc_responsable_almacen,INGRES.id_proveedor                    ,PROVEE.codigo as desc_proveedor,
						  INGRES.id_contratista                   ,CONTRA.codigo as desc_contratista      ,INGRES.id_empleado,
						  COALESCE(PERSON1.apellido_paterno,'' '')||''  ''||COALESCE(PERSON1.apellido_materno,'' '')||''  ''||COALESCE(PERSON1.nombre,'' '') as desc_empleado,
                          INGRES.id_almacen_logico               ,ALMLOG.nombre as desc_almacen_logico,
						  INGRES.id_firma_autorizada,
                          COALESCE(PERSON.apellido_paterno,'' '')||''  ''||COALESCE(PERSON.apellido_materno,'' '')||''  ''||COALESCE(PERSON.nombre,'' '') as desc_firma_autorizada,
                          INGRES.id_institucion,
						  INSTIT.nombre as desc_institucion       ,INGRES.id_motivo_ingreso_cuenta        ,MOINCU.descripcion as desc_motivo_ingreso_cuenta,
						  (SELECT CASE
                                    WHEN PROVEE.id_institucion IS NOT NULL THEN (SELECT INSTIT1.nombre FROM param.tpm_institucion INSTIT1 WHERE INSTIT1.id_institucion = PROVEE.id_institucion)
                                    WHEN PROVEE.id_persona IS NOT NULL THEN (SELECT COALESCE(PERSON1.nombre,'' '')||''  ''||COALESCE(PERSON1.apellido_paterno,'' '')||''  ''||COALESCE(PERSON1.apellido_materno,'' '') FROM sss.tsg_persona PERSON1 WHERE PERSON1.id_persona = PROVEE.id_persona)
                                  END) as nombre_proveedor,
                          (SELECT CASE
                                    WHEN CONTRA.id_institucion IS NOT NULL THEN (SELECT INSTIT.nombre FROM param.tpm_institucion INSTIT WHERE INSTIT.id_institucion = CONTRA.id_institucion)
                                    WHEN CONTRA.id_persona IS NOT NULL THEN (SELECT COALESCE(PERSON.nombre,'' '')||''  ''||COALESCE(PERSON.apellido_paterno,'' '')||''  ''||COALESCE(PERSON.apellido_materno,'' '') FROM sss.tsg_persona PERSON WHERE PERSON.id_persona = CONTRA.id_persona)
                                  END) as nombre_contratista,
                          (SELECT CUENTA.nro_cuenta FROM sci.tct_cuenta CUENTA WHERE CUENTA.id_cuenta = MOINCU.id_cuenta) as nro_cuenta,
                          MOTING.nombre as desc_motivo_ingreso    ,ALMACE.nombre as desc_almacen         ,FINANC.nombre_financiador,
                          REGION.nombre_regional                  ,PROGRA.nombre_programa                ,PROYEC.nombre_proyecto,
                          ACTIVI.nombre_actividad                 ,INGRES.orden_compra                   ,INGRES.observaciones,
                          INGRES.id_usuario                       ,TIPALM.contabilizar
						  FROM almin.tal_ingreso INGRES
	                      LEFT JOIN almin.tal_responsable_almacen RESALM
            			  ON RESALM.id_responsable_almacen=INGRES.id_responsable_almacen
	                      LEFT JOIN compro.tad_proveedor PROVEE
            			  ON PROVEE.id_proveedor=INGRES.id_proveedor
	                      LEFT JOIN param.tpm_contratista CONTRA
            			  ON CONTRA.id_contratista=INGRES.id_contratista
	                      LEFT JOIN kard.tkp_empleado EMPLEA
            			  ON EMPLEA.id_empleado=INGRES.id_empleado
	                      INNER JOIN almin.tal_almacen_logico ALMLOG
            			  ON ALMLOG.id_almacen_logico=INGRES.id_almacen_logico
	                      INNER JOIN almin.tal_firma_autorizada FIRAUT
            		      ON FIRAUT.id_firma_autorizada=INGRES.id_firma_autorizada
	                      LEFT JOIN param.tpm_institucion INSTIT
            			  ON INSTIT.id_institucion=INGRES.id_institucion
	                      INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			  ON MOINCU.id_motivo_ingreso_cuenta=INGRES.id_motivo_ingreso_cuenta
            			  INNER JOIN almin.tal_motivo_ingreso MOTING
            			  ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			  INNER JOIN almin.tal_almacen_ep ALMAEP
                          ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
                          INNER JOIN almin.tal_almacen ALMACE
                          ON ALMACE.id_almacen = ALMAEP.id_almacen
                          INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                          ON FRPPA.id_fina_regi_prog_proy_acti = MOINCU.id_fina_regi_prog_proy_acti
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
                          INNER JOIN kard.tkp_empleado_tpm_frppa EMPFRP
                          ON EMPFRP.id_empleado_frppa = FIRAUT.id_empleado_frppa
                          INNER JOIN kard.tkp_empleado EMPLEA1
                          ON EMPLEA1.id_empleado = EMPFRP.id_empleado
                          INNER JOIN sss.tsg_persona PERSON
                          ON PERSON.id_persona = EMPLEA1.id_persona
                          LEFT JOIN kard.tkp_empleado EMPLEA2 ON EMPLEA2.id_empleado=INGRES.id_empleado
                          LEFT JOIN sss.tsg_persona PERSON1 ON PERSON1.id_persona = EMPLEA2.id_persona
                          INNER JOIN almin.tal_tipo_almacen TIPALM ON TIPALM.id_tipo_almacen= ALMLOG.id_tipo_almacen
						  WHERE INGRES.estado_ingreso = ''Físico'' AND ';
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

    ELSIF pm_codigo_procedimiento  = 'AL_INGVAL_COUNT' THEN
        -- Contar los ingresos pendientes de valoración (estado = fisico)
        BEGIN
            g_consulta := 'SELECT
						  COUNT(INGRES.id_ingreso) AS total
						  FROM almin.tal_ingreso INGRES
	                      LEFT JOIN almin.tal_responsable_almacen RESALM
            			  ON RESALM.id_responsable_almacen=INGRES.id_responsable_almacen
	                      LEFT JOIN compro.tad_proveedor PROVEE
            			  ON PROVEE.id_proveedor=INGRES.id_proveedor
	                      LEFT JOIN param.tpm_contratista CONTRA
            			  ON CONTRA.id_contratista=INGRES.id_contratista
	                      LEFT JOIN kard.tkp_empleado EMPLEA
            			  ON EMPLEA.id_empleado=INGRES.id_empleado
	                      INNER JOIN almin.tal_almacen_logico ALMLOG
            			  ON ALMLOG.id_almacen_logico=INGRES.id_almacen_logico
	                      INNER JOIN almin.tal_firma_autorizada FIRAUT
            		      ON FIRAUT.id_firma_autorizada=INGRES.id_firma_autorizada
	                      LEFT JOIN param.tpm_institucion INSTIT
            			  ON INSTIT.id_institucion=INGRES.id_institucion
	                      INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			  ON MOINCU.id_motivo_ingreso_cuenta=INGRES.id_motivo_ingreso_cuenta
            			  INNER JOIN almin.tal_motivo_ingreso MOTING
            			  ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			  INNER JOIN almin.tal_almacen_ep ALMAEP
                          ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
                          INNER JOIN almin.tal_almacen ALMACE
                          ON ALMACE.id_almacen = ALMAEP.id_almacen
                          INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                          ON FRPPA.id_fina_regi_prog_proy_acti = MOINCU.id_fina_regi_prog_proy_acti
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
                          INNER JOIN kard.tkp_empleado_tpm_frppa EMPFRP
                          ON EMPFRP.id_empleado_frppa = FIRAUT.id_empleado_frppa
                          INNER JOIN kard.tkp_empleado EMPLEA1
                          ON EMPLEA1.id_empleado = EMPFRP.id_empleado
                          INNER JOIN sss.tsg_persona PERSON
                          ON PERSON.id_persona = EMPLEA1.id_persona
                          LEFT JOIN kard.tkp_empleado EMPLEA2 ON EMPLEA2.id_empleado=INGRES.id_empleado
                          LEFT JOIN sss.tsg_persona PERSON1 ON PERSON1.id_persona = EMPLEA2.id_persona
                          INNER JOIN almin.tal_tipo_almacen TIPALM ON TIPALM.id_tipo_almacen= ALMLOG.id_tipo_almacen
						  WHERE INGRES.estado_ingreso = ''Físico'' AND ';
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;
        
    ELSIF pm_codigo_procedimiento  = 'AL_INGFIN_SEL' THEN
        -- Selección de los ingresos pendientes de finalización (estado = valorado)
        BEGIN
            g_consulta := 'SELECT
						  INGRES.id_ingreso                       ,INGRES.correlativo_ord_ing             ,INGRES.correlativo_ing,
						  INGRES.descripcion,
						  INGRES.costo_total                      ,INGRES.contabilizar                    ,INGRES.contabilizado,
						  INGRES.estado_ingreso                   ,INGRES.estado_registro                 ,INGRES.cod_inf_tec,
						  INGRES.resumen_inf_tec                  ,INGRES.fecha_borrador                  ,INGRES.fecha_pendiente,
						  INGRES.fecha_aprobado_rechazado         ,INGRES.fecha_ing_fisico                ,INGRES.fecha_ing_valorado,
						  INGRES.fecha_finalizado_cancelado       ,INGRES.fecha_reg                       ,INGRES.id_responsable_almacen,
						  RESALM.cargo as desc_responsable_almacen,INGRES.id_proveedor                    ,PROVEE.codigo as desc_proveedor,
						  INGRES.id_contratista                   ,CONTRA.codigo as desc_contratista      ,INGRES.id_empleado,
						  COALESCE(PERSON1.apellido_paterno,'' '')||''  ''||COALESCE(PERSON1.apellido_materno,'' '')||''  ''||COALESCE(PERSON1.nombre,'' '') as desc_empleado,
                          INGRES.id_almacen_logico               ,ALMLOG.nombre as desc_almacen_logico,
						  INGRES.id_firma_autorizada,
                          COALESCE(PERSON.apellido_paterno,'' '')||''  ''||COALESCE(PERSON.apellido_materno,'' '')||''  ''||COALESCE(PERSON.nombre,'' '') as desc_firma_autorizada,
                          INGRES.id_institucion,
						  INSTIT.nombre as desc_institucion       ,INGRES.id_motivo_ingreso_cuenta        ,MOINCU.descripcion as desc_motivo_ingreso_cuenta,
						  (SELECT CASE
                                    WHEN PROVEE.id_institucion IS NOT NULL THEN (SELECT INSTIT1.nombre FROM param.tpm_institucion INSTIT1 WHERE INSTIT1.id_institucion = PROVEE.id_institucion)
                                    WHEN PROVEE.id_persona IS NOT NULL THEN (SELECT COALESCE(PERSON1.nombre,'' '')||''  ''||COALESCE(PERSON1.apellido_paterno,'' '')||''  ''||COALESCE(PERSON1.apellido_materno,'' '') FROM sss.tsg_persona PERSON1 WHERE PERSON1.id_persona = PROVEE.id_persona)
                                  END) as nombre_proveedor,
                          (SELECT CASE
                                    WHEN CONTRA.id_institucion IS NOT NULL THEN (SELECT INSTIT.nombre FROM param.tpm_institucion INSTIT WHERE INSTIT.id_institucion = CONTRA.id_institucion)
                                    WHEN CONTRA.id_persona IS NOT NULL THEN (SELECT COALESCE(PERSON.nombre,'' '')||''  ''||COALESCE(PERSON.apellido_paterno,'' '')||''  ''||COALESCE(PERSON.apellido_materno,'' '') FROM sss.tsg_persona PERSON WHERE PERSON.id_persona = CONTRA.id_persona)
                                  END) as nombre_contratista,
                          (SELECT CUENTA.nro_cuenta FROM sci.tct_cuenta CUENTA WHERE CUENTA.id_cuenta = MOINCU.id_cuenta) as nro_cuenta,
                          MOTING.nombre as desc_motivo_ingreso    ,ALMACE.nombre as desc_almacen         ,FINANC.nombre_financiador,
                          REGION.nombre_regional                  ,PROGRA.nombre_programa                ,PROYEC.nombre_proyecto,
                          ACTIVI.nombre_actividad                 ,INGRES.orden_compra                   ,INGRES.observaciones,
                          INGRES.id_usuario                       ,TIPALM.contabilizar
                          FROM almin.tal_ingreso INGRES
	                      LEFT JOIN almin.tal_responsable_almacen RESALM
            			  ON RESALM.id_responsable_almacen=INGRES.id_responsable_almacen
	                      LEFT JOIN compro.tad_proveedor PROVEE
            			  ON PROVEE.id_proveedor=INGRES.id_proveedor
	                      LEFT JOIN param.tpm_contratista CONTRA
            			  ON CONTRA.id_contratista=INGRES.id_contratista
	                      LEFT JOIN kard.tkp_empleado EMPLEA
            			  ON EMPLEA.id_empleado=INGRES.id_empleado
	                      INNER JOIN almin.tal_almacen_logico ALMLOG
            			  ON ALMLOG.id_almacen_logico=INGRES.id_almacen_logico
	                      INNER JOIN almin.tal_firma_autorizada FIRAUT
            		      ON FIRAUT.id_firma_autorizada=INGRES.id_firma_autorizada
	                      LEFT JOIN param.tpm_institucion INSTIT
            			  ON INSTIT.id_institucion=INGRES.id_institucion
	                      INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			  ON MOINCU.id_motivo_ingreso_cuenta=INGRES.id_motivo_ingreso_cuenta
            			  INNER JOIN almin.tal_motivo_ingreso MOTING
            			  ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			  INNER JOIN almin.tal_almacen_ep ALMAEP
                          ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
                          INNER JOIN almin.tal_almacen ALMACE
                          ON ALMACE.id_almacen = ALMAEP.id_almacen
                          INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                          ON FRPPA.id_fina_regi_prog_proy_acti = MOINCU.id_fina_regi_prog_proy_acti
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
                          INNER JOIN kard.tkp_empleado_tpm_frppa EMPFRP
                          ON EMPFRP.id_empleado_frppa = FIRAUT.id_empleado_frppa
                          INNER JOIN kard.tkp_empleado EMPLEA1
                          ON EMPLEA1.id_empleado = EMPFRP.id_empleado
                          INNER JOIN sss.tsg_persona PERSON
                          ON PERSON.id_persona = EMPLEA1.id_persona
                          LEFT JOIN kard.tkp_empleado EMPLEA2 ON EMPLEA2.id_empleado=INGRES.id_empleado
                          LEFT JOIN sss.tsg_persona PERSON1 ON PERSON1.id_persona = EMPLEA2.id_persona
                          INNER JOIN almin.tal_tipo_almacen TIPALM ON TIPALM.id_tipo_almacen= ALMLOG.id_tipo_almacen
						  WHERE INGRES.estado_ingreso = ''Valorado'' AND ';
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
        
    ELSIF pm_codigo_procedimiento  = 'AL_INGFIN_COUNT' THEN
        -- Contar los ingresos pendientes de finalización (estado = valorado)
        BEGIN
            g_consulta := 'SELECT
						  COUNT(INGRES.id_ingreso) as total
                          FROM almin.tal_ingreso INGRES
	                      LEFT JOIN almin.tal_responsable_almacen RESALM
            			  ON RESALM.id_responsable_almacen=INGRES.id_responsable_almacen
	                      LEFT JOIN compro.tad_proveedor PROVEE
            			  ON PROVEE.id_proveedor=INGRES.id_proveedor
	                      LEFT JOIN param.tpm_contratista CONTRA
            			  ON CONTRA.id_contratista=INGRES.id_contratista
	                      LEFT JOIN kard.tkp_empleado EMPLEA
            			  ON EMPLEA.id_empleado=INGRES.id_empleado
	                      INNER JOIN almin.tal_almacen_logico ALMLOG
            			  ON ALMLOG.id_almacen_logico=INGRES.id_almacen_logico
	                      INNER JOIN almin.tal_firma_autorizada FIRAUT
            		      ON FIRAUT.id_firma_autorizada=INGRES.id_firma_autorizada
	                      LEFT JOIN param.tpm_institucion INSTIT
            			  ON INSTIT.id_institucion=INGRES.id_institucion
	                      INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			  ON MOINCU.id_motivo_ingreso_cuenta=INGRES.id_motivo_ingreso_cuenta
            			  INNER JOIN almin.tal_motivo_ingreso MOTING
            			  ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			  INNER JOIN almin.tal_almacen_ep ALMAEP
                          ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
                          INNER JOIN almin.tal_almacen ALMACE
                          ON ALMACE.id_almacen = ALMAEP.id_almacen
                          INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                          ON FRPPA.id_fina_regi_prog_proy_acti = MOINCU.id_fina_regi_prog_proy_acti
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
                          INNER JOIN kard.tkp_empleado_tpm_frppa EMPFRP
                          ON EMPFRP.id_empleado_frppa = FIRAUT.id_empleado_frppa
                          INNER JOIN kard.tkp_empleado EMPLEA1
                          ON EMPLEA1.id_empleado = EMPFRP.id_empleado
                          INNER JOIN sss.tsg_persona PERSON
                          ON PERSON.id_persona = EMPLEA1.id_persona
                          LEFT JOIN kard.tkp_empleado EMPLEA2 ON EMPLEA2.id_empleado=INGRES.id_empleado
                          LEFT JOIN sss.tsg_persona PERSON1 ON PERSON1.id_persona = EMPLEA2.id_persona
                          INNER JOIN almin.tal_tipo_almacen TIPALM ON TIPALM.id_tipo_almacen= ALMLOG.id_tipo_almacen
						  WHERE INGRES.estado_ingreso = ''Valorado'' AND ';
            g_consulta := g_consulta || pm_criterio_filtro;


            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;
    ELSIF pm_codigo_procedimiento  = 'AL_INGRPR_SEL' THEN
    --Selección de todos los ingresos para Proyectos
        BEGIN
            g_consulta := 'SELECT  distinct
                                INGRES.id_ingreso                       ,INGRES.correlativo_ord_ing             ,''I - '' || INGRES.correlativo_ing as correlativo_ing,
                                INGRES.descripcion,
                                INGRES.costo_total                      ,INGRES.contabilizar                    ,INGRES.contabilizado,
                                INGRES.estado_ingreso                   ,INGRES.estado_registro                 ,INGRES.cod_inf_tec,
                                INGRES.resumen_inf_tec                  ,INGRES.fecha_borrador                  ,INGRES.fecha_pendiente,
                                INGRES.fecha_aprobado_rechazado         ,INGRES.fecha_ing_fisico                ,INGRES.fecha_ing_valorado,
                                INGRES.fecha_finalizado_cancelado       ,INGRES.fecha_reg                       ,INGRES.id_responsable_almacen,
                                RESALM.cargo as desc_responsable_almacen,INGRES.id_proveedor                    ,PROVEE.codigo as desc_proveedor,
                                INGRES.id_contratista                   ,CONTRA.codigo as desc_contratista      ,INGRES.id_empleado,
                                (COALESCE(PERSON.nombre,'' '' )||''  ''||COALESCE(PERSON.apellido_paterno,'' '')||''  ''||COALESCE(PERSON.apellido_materno,'' '')) as desc_empleado,
                                INGRES.id_almacen_logico               ,ALMLOG.nombre as desc_almacen_logico,
                                INGRES.id_firma_autorizada              ,FIRAUT.descripcion as desc_firma_autorizada ,INGRES.id_institucion,
                                INSTIT.nombre as desc_institucion       ,INGRES.id_motivo_ingreso_cuenta        ,MOINCU.descripcion as desc_motivo_ingreso_cuenta,
                                (SELECT CASE
                                          WHEN PROVEE.id_institucion IS NOT NULL THEN (SELECT INSTIT1.nombre FROM param.tpm_institucion INSTIT1 WHERE INSTIT1.id_institucion = PROVEE.id_institucion)
                                          WHEN PROVEE.id_persona IS NOT NULL THEN (SELECT COALESCE(PERSON1.nombre,'' '')||''  ''||COALESCE(PERSON1.apellido_paterno,'' '')||''  ''||COALESCE(PERSON1.apellido_materno,'' '') FROM sss.tsg_persona PERSON1 WHERE PERSON1.id_persona = PROVEE.id_persona)
                                        END) as nombre_proveedor,
                                (SELECT CASE
                                          WHEN CONTRA.id_institucion IS NOT NULL THEN (SELECT INSTIT.nombre FROM param.tpm_institucion INSTIT WHERE INSTIT.id_institucion = CONTRA.id_institucion)
                                          WHEN CONTRA.id_persona IS NOT NULL THEN (SELECT COALESCE(PERSON.nombre,'' '')||''  ''||COALESCE(PERSON.apellido_paterno,'' '')||''  ''||COALESCE(PERSON.apellido_materno,'' '') FROM sss.tsg_persona PERSON WHERE PERSON.id_persona = CONTRA.id_persona)
                                        END) as nombre_contratista,
                                (SELECT CUENTA.nro_cuenta FROM sci.tct_cuenta CUENTA WHERE CUENTA.id_cuenta = MOINCU.id_cuenta) as nro_cuenta,
                                MOTING.nombre as desc_motivo_ingreso    ,ALMACE.nombre as desc_almacen         ,FINANC.nombre_financiador,
                                REGION.nombre_regional                  ,PROGRA.nombre_programa                ,PROYEC.nombre_proyecto,
                                ACTIVI.nombre_actividad                 ,FINANC.id_financiador                 ,REGION.id_regional,
                                PROGRA.id_programa                      ,PROYEC.id_proyecto                    ,ACTIVI.id_actividad,
                                FINANC.codigo_financiador               ,REGION.codigo_regional                ,PROGRA.codigo_programa,
                                PROYEC.codigo_proyecto                  ,ACTIVI.codigo_actividad               ,INGRES.orden_compra,
                                INGRES.observaciones                    ,INGRES.id_usuario                     ,TIPALM.contabilizar,
                                INGRES.num_factura					  ,INGRES.fecha_factura					 ,INGRES.responsable,
                                INGRES.importacion					  ,INGRES.flete							 ,INGRES.seguro,
                                INGRES.gastos_alm						  ,INGRES.gastos_aduana					 ,INGRES.iva,
                                INGRES.rep_form						  ,INGRES.peso_neto,
                                COALESCE(INGRES.importacion,0) + COALESCE(INGRES.flete,0) + COALESCE(INGRES.seguro,0) as tot_importacion,
                                COALESCE(INGRES.gastos_alm,0) + COALESCE(INGRES.gastos_aduana,0) + COALESCE(INGRES.iva,0) + + COALESCE(INGRES.rep_form,0) as tot_nacionaliz,
                                INGRES.id_moneda_import				  ,INGRES.id_moneda_nacionaliz,
                                (SELECT nombre FROM param.tpm_moneda WHERE id_moneda = INGRES.id_moneda_import) as desc_moneda_import,
                                (SELECT nombre FROM param.tpm_moneda WHERE id_moneda = INGRES.id_moneda_nacionaliz) as desc_moneda_nacionaliz,
                                INGRES.dui							  ,INGRES.monto_tot_factura				 ,MOTING.codigo as codigo_mot_ing,
                                PARALM.gestion                          ,MOTING.id_motivo_ingreso              ,ALMACE.id_almacen,
                                INGRES.tipo_costeo,
                                INGRES.nro_pedido_compra
						  FROM almin.tal_ingreso INGRES
	                      LEFT JOIN almin.tal_responsable_almacen RESALM
            			  ON RESALM.id_responsable_almacen=INGRES.id_responsable_almacen
	                      LEFT JOIN compro.tad_proveedor PROVEE
            			  ON PROVEE.id_proveedor=INGRES.id_proveedor
	                      LEFT JOIN param.tpm_contratista CONTRA
            			  ON CONTRA.id_contratista=INGRES.id_contratista
	                      LEFT JOIN kard.tkp_empleado EMPLEA
            			  ON EMPLEA.id_empleado=INGRES.id_empleado
	                      INNER JOIN almin.tal_almacen_logico ALMLOG
            			  ON ALMLOG.id_almacen_logico=INGRES.id_almacen_logico
	                      INNER JOIN almin.tal_firma_autorizada FIRAUT
            		      ON FIRAUT.id_firma_autorizada=INGRES.id_firma_autorizada
	                      LEFT JOIN param.tpm_institucion INSTIT
            			  ON INSTIT.id_institucion=INGRES.id_institucion
	                      INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			  ON MOINCU.id_motivo_ingreso_cuenta=INGRES.id_motivo_ingreso_cuenta
            			  INNER JOIN almin.tal_motivo_ingreso MOTING
            			  ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			  INNER JOIN almin.tal_almacen_ep ALMAEP
                          ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
                          INNER JOIN almin.tal_almacen ALMACE
                          ON ALMACE.id_almacen = ALMAEP.id_almacen
                          INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                          ON FRPPA.id_fina_regi_prog_proy_acti = MOINCU.id_fina_regi_prog_proy_acti
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
                          LEFT JOIN kard.tkp_empleado EMPLEA1 ON EMPLEA1.id_empleado = INGRES.id_empleado
                          LEFT JOIN sss.tsg_persona PERSON ON PERSON.id_persona= EMPLEA1.id_persona AND EMPLEA.id_empleado= EMPLEA1.id_empleado
                          INNER JOIN almin.tal_tipo_almacen TIPALM ON TIPALM.id_tipo_almacen= ALMLOG.id_tipo_almacen
                          INNER JOIN almin.tal_parametro_almacen PARALM
                          ON PARALM.id_parametro_almacen = INGRES.id_parametro_almacen
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

    -- PARA LA CONSULTA DE SELECCIÓN
    ELSIF pm_codigo_procedimiento  = 'AL_INGRPR_COUNT' THEN
    --Cuenta los registros de las órdenes de ingreso en Borrador
        BEGIN
        --Cuenta todos los registros
            g_consulta := 	'SELECT
    	                    COUNT(INGRES.id_ingreso) AS total
                          	FROM almin.tal_ingreso INGRES
	                        LEFT JOIN almin.tal_responsable_almacen RESALM
            			    ON RESALM.id_responsable_almacen=INGRES.id_responsable_almacen
	                        LEFT JOIN compro.tad_proveedor PROVEE
            			    ON PROVEE.id_proveedor=INGRES.id_proveedor
	                        LEFT JOIN param.tpm_contratista CONTRA
            			    ON CONTRA.id_contratista=INGRES.id_contratista
	                        LEFT JOIN kard.tkp_empleado EMPLEA
            			    ON EMPLEA.id_empleado=INGRES.id_empleado
	                        INNER JOIN almin.tal_almacen_logico ALMLOG
            			    ON ALMLOG.id_almacen_logico=INGRES.id_almacen_logico
	                        INNER JOIN almin.tal_firma_autorizada FIRAUT
            		        ON FIRAUT.id_firma_autorizada=INGRES.id_firma_autorizada
	                        LEFT JOIN param.tpm_institucion INSTIT
            			    ON INSTIT.id_institucion=INGRES.id_institucion
	                        INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            			    ON MOINCU.id_motivo_ingreso_cuenta=INGRES.id_motivo_ingreso_cuenta
            			    INNER JOIN almin.tal_motivo_ingreso MOTING
            			    ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            			    INNER JOIN almin.tal_almacen_ep ALMAEP
                            ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
                            INNER JOIN almin.tal_almacen ALMACE
                            ON ALMACE.id_almacen = ALMAEP.id_almacen
                            INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                            ON FRPPA.id_fina_regi_prog_proy_acti = MOINCU.id_fina_regi_prog_proy_acti
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
                            LEFT JOIN kard.tkp_empleado EMPLEA1 ON EMPLEA1.id_empleado = INGRES.id_empleado
                            LEFT JOIN sss.tsg_persona PERSON ON PERSON.id_persona= EMPLEA1.id_persona AND EMPLEA.id_empleado= EMPLEA1.id_empleado
                            INNER JOIN almin.tal_tipo_almacen TIPALM ON TIPALM.id_tipo_almacen= ALMLOG.id_tipo_almacen
                            INNER JOIN almin.tal_parametro_almacen PARALM
                            ON PARALM.id_parametro_almacen = INGRES.id_parametro_almacen
						    WHERE ';
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;   
        
ELSIF pm_codigo_procedimiento  = 'AL_INGREP_SEL' THEN
    --Para Reporte de Ingresos (RCM: san borja 12/06/2008)
        BEGIN
            g_consulta := 	'SELECT
							ALMACE.nombre as nombre_almacen,
							''I - '' || INGRES.correlativo_ing,
							ALMLOG.nombre as almacen_log,
							MOTING.nombre as motivo_ing,
							
							INGRES.num_factura,
							to_char(INGRES.fecha_factura,''dd/mm/YYYY'') as fecha_factura,
							to_char(INGRES.fecha_finalizado_cancelado,''dd/mm/YYYY'') as fecha_finalizado_cancelado,
							CASE COALESCE(INGRES.id_institucion,0)
							    WHEN 0 THEN
							        CASE COALESCE(INGRES.id_proveedor,0)
							            WHEN 0 THEN
							                CASE COALESCE(INGRES.id_contratista,0)
							            	    WHEN 0 THEN
							                    	(SELECT COALESCE(apellido_paterno,'''')||''  ''||COALESCE(apellido_materno,'''')||''  ''||COALESCE(nombre,'''') FROM sss.tsg_persona WHERE id_persona = EMPLEA.id_persona)
							                    ELSE
							                        (SELECT nombre FROM param.tpm_institucion WHERE id_institucion = CONTRA.id_institucion)
							                END    
							            ELSE
							        	    (SELECT nombre FROM param.tpm_institucion WHERE id_institucion = PROVEE.id_institucion)
							    	END
							    ELSE
							        (SELECT nombre FROM param.tpm_institucion WHERE id_institucion = INGRES.id_institucion)
							END as origen,
            				INGRES.descripcion, INGRES.responsable,
                            (SELECT COALESCE(P.nombre,'''') || '' '' || COALESCE(P.apellido_paterno,'''') || '' '' || COALESCE(P.apellido_materno,'''')
                             FROM kard.tkp_empleado E
                             INNER JOIN sss.tsg_persona P
                             ON P.id_persona = E.id_persona
                             WHERE E.id_empleado = RESALM.id_empleado) as almacenero,
                      (SELECT P.doc_id
                             FROM kard.tkp_empleado E
                             INNER JOIN sss.tsg_persona P
                             ON P.id_persona = E.id_persona
                             WHERE E.id_empleado = RESALM.id_empleado) as doc_almacenero,

                            (SELECT COALESCE(P.nombre,'''') || '' '' || COALESCE(P.apellido_paterno,'''') || '' '' || COALESCE(P.apellido_materno,'''')
                             FROM kard.tkp_empleado E
                             INNER JOIN sss.tsg_persona P
                             ON P.id_persona = E.id_persona
                             WHERE E.id_empleado = RESALM1.id_empleado) as jefe_almacen,
                      (SELECT P.doc_id
                             FROM kard.tkp_empleado E
                             INNER JOIN sss.tsg_persona P
                             ON P.id_persona = E.id_persona
                             WHERE E.id_empleado = RESALM1.id_empleado) as doc_jefe_almacen,

                           to_char(INGRES.fecha_reg,''dd/mm/YYYY'') as fecha_reg,
                          INGRES.observaciones,
                          INGRES.orden_compra,
                          INGRES.nro_pedido_compra
FROM almin.tal_ingreso INGRES
							INNER JOIN almin.tal_almacen_logico ALMLOG ON ALMLOG.id_almacen_logico = INGRES.id_almacen_logico
							INNER JOIN almin.tal_almacen_ep ALMAEP ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
							INNER JOIN almin.tal_almacen ALMACE ON ALMACE.id_almacen = ALMAEP.id_almacen 
							INNER JOIN almin.tal_motivo_ingreso_cuenta MIC ON MIC.id_motivo_ingreso_cuenta=INGRES.id_motivo_ingreso_cuenta
							INNER JOIN almin.tal_motivo_ingreso MOTING ON MOTING.id_motivo_ingreso=MIC.id_motivo_ingreso
							LEFT JOIN param.tpm_institucion INSTIT ON INSTIT.id_institucion = INGRES.id_institucion
							LEFT JOIN param.tpm_contratista CONTRA ON CONTRA.id_contratista = INGRES.id_contratista
							LEFT JOIN kard.tkp_empleado EMPLEA ON EMPLEA.id_empleado = INGRES.id_empleado
							LEFT JOIN compro.tad_proveedor PROVEE ON PROVEE.id_proveedor = INGRES.id_proveedor
                            LEFT JOIN almin.tal_responsable_almacen RESALM ON RESALM.id_responsable_almacen = INGRES.id_responsable_almacen 
                            LEFT JOIN almin.tal_responsable_almacen RESALM1 ON RESALM1.id_responsable_almacen = INGRES.id_jefe_almacen
                            
						    WHERE ';
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;
        
    ELSIF pm_codigo_procedimiento  = 'AL_RESING_SEL' THEN
        --Selección de todos los ingresos para Proyectos
        BEGIN
        
            g_consulta := 'SELECT
                          	INGRES.id_ingreso,
                          	INGRES.correlativo_ing, 
                          	SUPGRU.nombre,
                          	SUM(INGDET.costo), 
                            SUM(INGDET.cantidad)as cantidad,
                            INGRES.fecha_finalizado_cancelado
                          FROM almin.tal_ingreso_detalle INGDET
                          INNER JOIN almin.tal_ingreso INGRES
                          ON INGRES.id_ingreso = INGDET.id_ingreso
                          INNER JOIN almin.tal_item ITEM
                          ON ITEM.id_item = INGDET.id_item
                          INNER JOIN almin.tal_supergrupo SUPGRU
                          ON SUPGRU.id_supergrupo = ITEM.id_supergrupo
                          WHERE '; 
            g_consulta := g_consulta || pm_criterio_filtro;
            g_consulta := g_consulta ||
                         ' GROUP BY INGRES.correlativo_ing, SUPGRU.nombre,INGRES.id_ingreso,INGRES.fecha_finalizado_cancelado
                         ORDER BY INGRES.fecha_finalizado_cancelado, INGRES.id_ingreso';
                         
            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Resumen de Ingresos Generado';
                         
        
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