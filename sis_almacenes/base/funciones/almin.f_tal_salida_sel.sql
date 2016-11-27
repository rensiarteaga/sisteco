--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_tal_salida_sel (
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
    g_nombre_funcion := 'almin.f_tal_salida_sel'; 
    
    
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
    IF pm_codigo_procedimiento  = 'AL_SALIDA_SEL' THEN
        BEGIN
            g_consulta := 'SELECT 
                            SALIDA.id_salida,
                            SALIDA.correlativo_sal,
                            SALIDA.correlativo_vale,
                            SALIDA.descripcion,
                            SALIDA.contabilizar,
                            SALIDA.contabilizado,
                            SALIDA.estado_salida,
                            SALIDA.estado_registro,
                            SALIDA.motivo_cancelacion,
                            SALIDA.id_responsable_almacen,
                            RESALM.cargo as desc_responsable_almacen,
                            SALIDA.id_almacen_logico,
                            ALMLOG.codigo as desc_almacen_logico,
                            SALIDA.id_empleado,
                            (COALESCE(PERSON.nombre,'' '')||'' ''||COALESCE(PERSON.apellido_paterno,'' '')||'' ''|| COALESCE(PERSON.apellido_materno,'' '')) as desc_empleado,
                            SALIDA.id_firma_autorizada,
                            (COALESCE(PERSON2.nombre,'' '')||'' ''||COALESCE(PERSON2.apellido_paterno,'' '')||'' ''|| COALESCE(PERSON2.apellido_materno,'' '')) as desc_firma_autorizada,
                            SALIDA.id_contratista,
                            CONTRA.codigo as desc_contratista,
                            SALIDA.id_tipo_material,
                            TIPMAT.nombre as desc_tipo_material,
                            SALIDA.id_institucion,
                            INSTIT.nombre as desc_institucion,
                            SALIDA.id_subactividad,
                            SUBACT.codigo as desc_subactividad,
                            SALIDA.emergencia,
                            SALIDA.observaciones,
                            SALIDA.tipo_pedido
                            FROM almin.tal_salida SALIDA
                            LEFT JOIN almin.tal_responsable_almacen RESALM
                            ON RESALM.id_responsable_almacen=SALIDA.id_responsable_almacen
                            INNER JOIN almin.tal_almacen_logico ALMLOG
                            ON ALMLOG.id_almacen_logico=SALIDA.id_almacen_logico
                            INNER JOIN kard.tkp_empleado EMPLEA
                            ON EMPLEA.id_empleado=SALIDA.id_empleado
                            INNER JOIN sss.tsg_persona PERSON
                            ON PERSON.id_persona=EMPLEA.id_persona
                            
                            INNER JOIN almin.tal_firma_autorizada FIRAUT
                            ON FIRAUT.id_firma_autorizada=SALIDA.id_firma_autorizada
                            INNER JOIN kard.tkp_empleado_tpm_frppa EFRPPA
                            ON EFRPPA.id_empleado_frppa=FIRAUT.id_empleado_frppa
                            INNER JOIN kard.tkp_empleado EMPLEA2
                            ON EMPLEA2.id_empleado=EFRPPA.id_empleado
                            INNER JOIN sss.tsg_persona PERSON2
                            ON PERSON2.id_persona=EMPLEA2.id_persona
                            
                            
                            INNER JOIN param.tpm_contratista CONTRA
                            ON CONTRA.id_contratista=SALIDA.id_contratista
                            INNER JOIN almin.tal_tipo_material TIPMAT
                            ON TIPMAT.id_tipo_material=SALIDA.id_tipo_material
                            LEFT JOIN param.tpm_institucion INSTIT
                            ON INSTIT.id_institucion=SALIDA.id_institucion
                            INNER JOIN param.tpm_subactividad SUBACT
                             ON SUBACT.id_subactividad=SALIDA.id_subactividad
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
    ELSIF pm_codigo_procedimiento  = 'AL_SALIDA_COUNT' THEN

        BEGIN
        --Cuenta todos los registros
            g_consulta := 'SELECT
                           COUNT(SALIDA.id_salida) AS total
                           FROM almin.tal_salida SALIDA
                           LEFT JOIN almin.tal_responsable_almacen RESALM
                           ON RESALM.id_responsable_almacen=SALIDA.id_responsable_almacen
                           INNER JOIN almin.tal_almacen_logico ALMLOG
                           ON ALMLOG.id_almacen_logico=SALIDA.id_almacen_logico
                           LEFT JOIN kard.tkp_empleado EMPLEA
                           ON EMPLEA.id_empleado=SALIDA.id_empleado
                           LEFT JOIN sss.tsg_persona PERSON
                           ON PERSON.id_persona=EMPLEA.id_persona
                           LEFT JOIN almin.tal_firma_autorizada FIRAUT
                           ON FIRAUT.id_firma_autorizada=SALIDA.id_firma_autorizada
                           LEFT JOIN kard.tkp_empleado_tpm_frppa EFRPPA
                           ON EFRPPA.id_empleado_frppa=FIRAUT.id_empleado_frppa
                           LEFT JOIN kard.tkp_empleado EMPLEA2
                           ON EMPLEA2.id_empleado=EFRPPA.id_empleado
                           LEFT JOIN sss.tsg_persona PERSON2
                           ON PERSON2.id_persona=EMPLEA2.id_persona

                           LEFT JOIN param.tpm_contratista CONTRA
                           ON CONTRA.id_contratista=SALIDA.id_contratista
                           INNER JOIN almin.tal_tipo_material TIPMAT
                           ON TIPMAT.id_tipo_material=SALIDA.id_tipo_material
                           LEFT JOIN param.tpm_institucion INSTIT
                           ON INSTIT.id_institucion=SALIDA.id_institucion
                           LEFT JOIN param.tpm_subactividad SUBACT
                           ON SUBACT.id_subactividad=SALIDA.id_subactividad
                           INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			   ON MOSACU.id_motivo_salida_cuenta=SALIDA.id_motivo_salida_cuenta
            			   INNER JOIN almin.tal_almacen_ep ALMAEP
            			   ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
            			   INNER JOIN almin.tal_almacen ALMACE
            			   ON ALMACE.id_almacen = ALMAEP.id_almacen
            			   INNER JOIN almin.tal_motivo_salida MOTSAL
            			   ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
            			   INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                           ON FRPPA.id_fina_regi_prog_proy_acti = MOSACU.id_fina_regi_prog_proy_acti
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
                           WHERE SALIDA.estado_salida = ''Borrador'' AND '; 
            
                     g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;   
        
    ELSIF pm_codigo_procedimiento  = 'AL_PEDIDO_SEL' THEN
        BEGIN
            g_consulta := 'SELECT
                               SALIDA.id_salida       ,SALIDA.correlativo_sal             ,SALIDA.correlativo_vale,
                               SALIDA.descripcion     ,SALIDA.contabilizar                ,SALIDA.contabilizado,SALIDA.estado_salida,
                               SALIDA.estado_registro ,SALIDA.motivo_cancelacion          ,SALIDA.id_responsable_almacen,
                               RESALM.cargo as desc_responsable_almacen                   ,SALIDA.id_almacen_logico,
                               ALMLOG.nombre as desc_almacen_logico                       ,SALIDA.id_empleado,
                               (COALESCE(PERSON.nombre,'' '')||'' ''||COALESCE(PERSON.apellido_paterno,'' '')||'' ''|| COALESCE(PERSON.apellido_materno,'' '')) as desc_empleado,
                               SALIDA.id_firma_autorizada,
                               (COALESCE(PERSON2.nombre,'' '')||'' ''||COALESCE(PERSON2.apellido_paterno,'' '')||'' ''|| COALESCE(PERSON2.apellido_materno,'' '')) as desc_firma_autorizada,
                               SALIDA.id_contratista,


                               (SELECT nombre FROM param.tpm_institucion where id_institucion = CONTRA.id_institucion) as desc_contratista,
                               SALIDA.id_tipo_material,
                               TIPMAT.nombre as desc_tipo_material                         ,SALIDA.id_institucion,
                               INSTIT.nombre as desc_institucion                           ,SALIDA.id_subactividad,SUBACT.descripcion as desc_subactividad,
                               SALIDA.id_motivo_salida_cuenta                              ,MOSACU.descripcion as desc_motivo_salida_cuenta,
                               (SELECT CUENTA.nro_cuenta FROM sci.tct_cuenta CUENTA WHERE CUENTA.id_cuenta = MOSACU.id_cuenta) as nro_cuenta,
                               MOTSAL.nombre as desc_motivo_salida                        ,ALMACE.nombre as desc_almacen,
                               FINANC.nombre_financiador,
                               REGION.nombre_regional                  ,PROGRA.nombre_programa                ,PROYEC.nombre_proyecto,
                               ACTIVI.nombre_actividad                 ,FINANC.id_financiador                 ,REGION.id_regional,
                               PROGRA.id_programa                      ,PROYEC.id_proyecto                    ,ACTIVI.id_actividad,
                               FINANC.codigo_financiador               ,REGION.codigo_regional                ,PROGRA.codigo_programa,
                               PROYEC.codigo_proyecto                  ,ACTIVI.codigo_actividad               ,SALIDA.emergencia,
                               SALIDA.observaciones                    ,SALIDA.tipo_pedido                    ,SALIDA.receptor,
                               SALIDA.id_tramo_subactividad            ,SALIDA.id_tramo_unidad_constructiva   ,TRAMO.descripcion as desc_tramo,
                               UNICON.codigo as desc_unidad_cons	   ,SALIDA.fecha_borrador,
                               SALIDA.id_supervisor					   ,SALIDA.receptor_ci					  ,SALIDA.solicitante,
                               SALIDA.solicitante_ci				   ,SALIDA.num_contrato,
                               COALESCE(PERSON3.apellido_paterno,'''') || '' '' || COALESCE(PERSON3.apellido_materno,'''') || '' '' || COALESCE(PERSON3.nombre,'''') as nombre_superv,
                               PARALM.gestion                          ,MOTSAL.id_motivo_salida               ,ALMACE.id_almacen
                           FROM almin.tal_salida SALIDA
                           LEFT JOIN almin.tal_responsable_almacen RESALM
                           ON RESALM.id_responsable_almacen=SALIDA.id_responsable_almacen
                           INNER JOIN almin.tal_almacen_logico ALMLOG
                           ON ALMLOG.id_almacen_logico=SALIDA.id_almacen_logico
                           LEFT JOIN kard.tkp_empleado EMPLEA
                           ON EMPLEA.id_empleado=SALIDA.id_empleado
                           LEFT JOIN sss.tsg_persona PERSON
                           ON PERSON.id_persona=EMPLEA.id_persona
                           LEFT JOIN almin.tal_firma_autorizada FIRAUT
                           ON FIRAUT.id_firma_autorizada=SALIDA.id_firma_autorizada
                           LEFT JOIN kard.tkp_empleado_tpm_frppa EFRPPA
                           ON EFRPPA.id_empleado_frppa=FIRAUT.id_empleado_frppa
                           LEFT JOIN kard.tkp_empleado EMPLEA2
                           ON EMPLEA2.id_empleado=EFRPPA.id_empleado
                           LEFT JOIN sss.tsg_persona PERSON2
                           ON PERSON2.id_persona=EMPLEA2.id_persona
                           LEFT JOIN param.tpm_contratista CONTRA
                           ON CONTRA.id_contratista=SALIDA.id_contratista
                           INNER JOIN almin.tal_tipo_material TIPMAT
                           ON TIPMAT.id_tipo_material=SALIDA.id_tipo_material
                           LEFT JOIN param.tpm_institucion INSTIT
                           ON INSTIT.id_institucion=SALIDA.id_institucion
                           LEFT JOIN param.tpm_subactividad SUBACT
                           ON SUBACT.id_subactividad=SALIDA.id_subactividad
                           INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			   ON MOSACU.id_motivo_salida_cuenta=SALIDA.id_motivo_salida_cuenta
            			   INNER JOIN almin.tal_almacen_ep ALMAEP
            			   ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
            			   INNER JOIN almin.tal_almacen ALMACE
            			   ON ALMACE.id_almacen = ALMAEP.id_almacen
            			   INNER JOIN almin.tal_motivo_salida MOTSAL
            			   ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
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
                           LEFT JOIN almin.tal_tramo_subactividad TRASUB
                           ON TRASUB.id_tramo_subactividad = SALIDA.id_tramo_subactividad
                           LEFT JOIN almin.tal_tramo TRAMO
                           ON TRAMO.id_tramo = TRASUB.id_tramo
                           LEFT JOIN almin.tal_tramo_unidad_constructiva TRAUNI
                           ON TRAUNI.id_tramo_unidad_constructiva = SALIDA.id_tramo_unidad_constructiva
                           LEFT JOIN almin.tal_unidad_constructiva UNICON
                           ON UNICON.id_unidad_constructiva = TRAUNI.id_unidad_constructiva
                           LEFT JOIN almin.tal_supervisor SUPERV
                           ON SUPERV.id_supervisor = SALIDA.id_supervisor
                           LEFT JOIN sss.tsg_persona PERSON3
                           ON PERSON3.id_persona = SUPERV.id_persona
                           INNER JOIN almin.tal_parametro_almacen PARALM
                           ON PARALM.id_parametro_almacen = SALIDA.id_parametro_almacen
                           WHERE SALIDA.tipo_reg = ''movimiento'' AND SALIDA.estado_salida = ''Borrador'' AND ';
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
    ELSIF pm_codigo_procedimiento  = 'AL_PEDIDO_COUNT' THEN

        BEGIN
        --Cuenta todos los registros
            g_consulta := 'SELECT
                           COUNT(SALIDA.id_salida) AS total
                           FROM almin.tal_salida SALIDA
                           LEFT JOIN almin.tal_responsable_almacen RESALM
                           ON RESALM.id_responsable_almacen=SALIDA.id_responsable_almacen
                           INNER JOIN almin.tal_almacen_logico ALMLOG
                           ON ALMLOG.id_almacen_logico=SALIDA.id_almacen_logico
                           LEFT JOIN kard.tkp_empleado EMPLEA
                           ON EMPLEA.id_empleado=SALIDA.id_empleado
                           LEFT JOIN sss.tsg_persona PERSON
                           ON PERSON.id_persona=EMPLEA.id_persona
                           LEFT JOIN almin.tal_firma_autorizada FIRAUT
                           ON FIRAUT.id_firma_autorizada=SALIDA.id_firma_autorizada
                           LEFT JOIN kard.tkp_empleado_tpm_frppa EFRPPA
                           ON EFRPPA.id_empleado_frppa=FIRAUT.id_empleado_frppa
                           LEFT JOIN kard.tkp_empleado EMPLEA2
                           ON EMPLEA2.id_empleado=EFRPPA.id_empleado
                           LEFT JOIN sss.tsg_persona PERSON2
                           ON PERSON2.id_persona=EMPLEA2.id_persona
                           LEFT JOIN param.tpm_contratista CONTRA
                           ON CONTRA.id_contratista=SALIDA.id_contratista
                           INNER JOIN almin.tal_tipo_material TIPMAT
                           ON TIPMAT.id_tipo_material=SALIDA.id_tipo_material
                           LEFT JOIN param.tpm_institucion INSTIT
                           ON INSTIT.id_institucion=SALIDA.id_institucion
                           LEFT JOIN param.tpm_subactividad SUBACT
                           ON SUBACT.id_subactividad=SALIDA.id_subactividad
                           INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			   ON MOSACU.id_motivo_salida_cuenta=SALIDA.id_motivo_salida_cuenta
            			   INNER JOIN almin.tal_almacen_ep ALMAEP
            			   ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
            			   INNER JOIN almin.tal_almacen ALMACE
            			   ON ALMACE.id_almacen = ALMAEP.id_almacen
            			   INNER JOIN almin.tal_motivo_salida MOTSAL
            			   ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
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
                           LEFT JOIN almin.tal_tramo_subactividad TRASUB
                           ON TRASUB.id_tramo_subactividad = SALIDA.id_tramo_subactividad
                           LEFT JOIN almin.tal_tramo TRAMO
                           ON TRAMO.id_tramo = TRASUB.id_tramo
                           LEFT JOIN almin.tal_tramo_unidad_constructiva TRAUNI
                           ON TRAUNI.id_tramo_unidad_constructiva = SALIDA.id_tramo_unidad_constructiva
                           LEFT JOIN almin.tal_unidad_constructiva UNICON
                           ON UNICON.id_unidad_constructiva = TRAUNI.id_unidad_constructiva
                           LEFT JOIN almin.tal_supervisor SUPERV
                           ON SUPERV.id_supervisor = SALIDA.id_supervisor
                           LEFT JOIN sss.tsg_persona PERSON3
                           ON PERSON3.id_persona = SUPERV.id_persona
                           INNER JOIN almin.tal_parametro_almacen PARALM
                           ON PARALM.id_parametro_almacen = SALIDA.id_parametro_almacen
                           WHERE  SALIDA.tipo_reg = ''movimiento'' AND  SALIDA.estado_salida = ''Borrador'' AND '; 
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
        
        
   ELSIF  pm_codigo_procedimiento  = 'AL_SALPED_SEL' THEN
        BEGIN
            g_consulta := 'SELECT 
                            SALIDA.id_salida,                             
                            SALIDA.descripcion,
                            SALIDA.estado_salida,
                            SALIDA.id_almacen_logico,
                            ALMLOG.codigo as desc_almacen_logico,
                            SALIDA.id_empleado,
                            (COALESCE(PERSON.nombre,'' '')||'' ''||COALESCE(PERSON.apellido_paterno,'' '')||'' ''|| COALESCE(PERSON.apellido_materno,'' '')) as desc_empleado,
                            SALIDA.id_firma_autorizada,
                            (COALESCE(PERSON2.nombre,'' '')||'' ''||COALESCE(PERSON2.apellido_paterno,'' '')||'' ''|| COALESCE(PERSON2.apellido_materno,'' '')) as desc_firma_autorizada,
                            SALIDA.id_tipo_material,
                            TIPMAT.nombre as desc_tipo_material,
                            SALIDA.id_subactividad,
                            SUBACT.codigo as desc_subactividad,
                            SALIDA.emergencia,
                            SALIDA.observaciones,
                            SALIDA.tipo_pedido
                            FROM almin.tal_salida SALIDA
                            INNER JOIN almin.tal_almacen_logico ALMLOG
                            ON ALMLOG.id_almacen_logico=SALIDA.id_almacen_logico
                            INNER JOIN kard.tkp_empleado EMPLEA
                            ON EMPLEA.id_empleado=SALIDA.id_empleado
                            INNER JOIN sss.tsg_persona PERSON
                            ON PERSON.id_persona=EMPLEA.id_persona
                            INNER JOIN almin.tal_firma_autorizada FIRAUT
                            ON FIRAUT.id_firma_autorizada=SALIDA.id_firma_autorizada
                            INNER JOIN kard.tkp_empleado_tpm_frppa EFRPPA
                            ON EFRPPA.id_empleado_frppa=FIRAUT.id_empleado_frppa
                            INNER JOIN kard.tkp_empleado EMPLEA2
                            ON EMPLEA2.id_empleado=EFRPPA.id_empleado
                            INNER JOIN sss.tsg_persona PERSON2
                            ON PERSON2.id_persona=EMPLEA2.id_persona
                            INNER JOIN almin.tal_tipo_material TIPMAT
                            ON TIPMAT.id_tipo_material=SALIDA.id_tipo_material
                            INNER JOIN param.tpm_subactividad SUBACT
                            ON SUBACT.id_subactividad=SALIDA.id_subactividad
                            WHERE SALIDA.estado_salida=''Borrador'' AND SALIDA.id_empleado='||g_id_empleado||'AND  ';
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
    ELSIF pm_codigo_procedimiento  = 'AL_SALPED_COUNT' THEN

        BEGIN
        --Cuenta todos los registros 
               
            g_consulta :=     'SELECT
                              COUNT(SALIDA.id_salida) AS total
                              FROM almin.tal_salida SALIDA
                              INNER JOIN almin.tal_almacen_logico ALMLOG
                              ON ALMLOG.id_almacen_logico=SALIDA.id_almacen_logico
                              
                              INNER JOIN kard.tkp_empleado EMPLEA
                              ON EMPLEA.id_empleado=SALIDA.id_empleado
                              INNER JOIN sss.tsg_persona PERSON
                              ON PERSON.id_persona=EMPLEA.id_persona

                              INNER JOIN almin.tal_firma_autorizada FIRAUT
                              ON FIRAUT.id_firma_autorizada=SALIDA.id_firma_autorizada
                              INNER JOIN kard.tkp_empleado_tpm_frppa EFRPPA
                              ON EFRPPA.id_empleado_frppa=FIRAUT.id_empleado_frppa
                              INNER JOIN kard.tkp_empleado EMPLEA2
                              ON EMPLEA2.id_empleado=EFRPPA.id_empleado
                              INNER JOIN sss.tsg_persona PERSON2
                              ON PERSON2.id_persona=EMPLEA2.id_persona

                              INNER JOIN almin.tal_tipo_material TIPMAT
                              ON TIPMAT.id_tipo_material=SALIDA.id_tipo_material
                              INNER JOIN param.tpm_subactividad SUBACT
                              ON SUBACT.id_subactividad=SALIDA.id_subactividad
                              WHERE SALIDA.estado_salida=''Borrador'' AND SALIDA.id_empleado='||g_id_empleado||'AND  ';
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;
       ELSIF  pm_codigo_procedimiento  = 'AL_SAAPRO_SEL' THEN
        BEGIN
            g_consulta := 'SELECT
                            SALIDA.id_salida       ,SALIDA.correlativo_sal             ,SALIDA.correlativo_vale,
                            SALIDA.fecha_pendiente ,SALIDA.descripcion                 ,SALIDA.contabilizar            ,SALIDA.contabilizado,SALIDA.estado_salida,
                            SALIDA.estado_registro ,SALIDA.motivo_cancelacion          ,SALIDA.id_responsable_almacen,
                            RESALM.cargo as desc_responsable_almacen                   ,SALIDA.id_almacen_logico,
                            ALMLOG.codigo as desc_almacen_logico                       ,SALIDA.id_empleado,
                            (COALESCE(PERSON.nombre,'' '')||'' ''||COALESCE(PERSON.apellido_paterno,'' '')||'' ''|| COALESCE(PERSON.apellido_materno,'' '')) as desc_empleado,
                            SALIDA.id_firma_autorizada,
                            (COALESCE(PERSON2.nombre,'' '')||'' ''||COALESCE(PERSON2.apellido_paterno,'' '')||'' ''|| COALESCE(PERSON2.apellido_materno,'' '')) as desc_firma_autorizada,
                            SALIDA.id_contratista  ,CONTRA.codigo as desc_contratista   ,SALIDA.id_tipo_material,
                            TIPMAT.nombre as desc_tipo_material                         ,SALIDA.id_institucion,
                            INSTIT.nombre as desc_institucion                           ,SALIDA.id_subactividad,SUBACT.codigo as desc_subactividad,
                            SALIDA.id_motivo_salida_cuenta                              ,MOSACU.descripcion as desc_motivo_salida_cuenta,
                            (SELECT CUENTA.nro_cuenta FROM sci.tct_cuenta CUENTA WHERE CUENTA.id_cuenta = MOSACU.id_cuenta) as nro_cuenta,
                            SALIDA.emergencia,
                            SALIDA.observaciones,
                            MOTSAL.nombre as desc_motivo_salida,      SALIDA.tipo_pedido,SALIDA.tipo_entrega
                            FROM almin.tal_salida SALIDA
                            LEFT JOIN almin.tal_responsable_almacen RESALM
                            ON RESALM.id_responsable_almacen=SALIDA.id_responsable_almacen
                            INNER JOIN almin.tal_almacen_logico ALMLOG
                            ON ALMLOG.id_almacen_logico=SALIDA.id_almacen_logico
                            LEFT JOIN kard.tkp_empleado EMPLEA
                            ON EMPLEA.id_empleado=SALIDA.id_empleado
                            LEFT JOIN sss.tsg_persona PERSON
                            ON PERSON.id_persona=EMPLEA.id_persona
                            LEFT JOIN almin.tal_firma_autorizada FIRAUT
                            ON FIRAUT.id_firma_autorizada=SALIDA.id_firma_autorizada
                            LEFT JOIN kard.tkp_empleado_tpm_frppa EFRPPA
                            ON EFRPPA.id_empleado_frppa=FIRAUT.id_empleado_frppa
                            LEFT JOIN kard.tkp_empleado EMPLEA2
                            ON EMPLEA2.id_empleado=EFRPPA.id_empleado
                            LEFT JOIN sss.tsg_persona PERSON2
                            ON PERSON2.id_persona=EMPLEA2.id_persona
                            LEFT JOIN param.tpm_contratista CONTRA
                            ON CONTRA.id_contratista=SALIDA.id_contratista
                            INNER JOIN almin.tal_tipo_material TIPMAT
                            ON TIPMAT.id_tipo_material=SALIDA.id_tipo_material
                            LEFT JOIN param.tpm_institucion INSTIT
                            ON INSTIT.id_institucion=SALIDA.id_institucion
                            LEFT JOIN param.tpm_subactividad SUBACT
                            ON SUBACT.id_subactividad=SALIDA.id_subactividad
                            INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
                            ON MOSACU.id_motivo_salida_cuenta=SALIDA.id_motivo_salida_cuenta
                            INNER JOIN almin.tal_motivo_salida MOTSAL
            			    ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
                            WHERE ((SALIDA.estado_salida = ''Pendiente'' AND SALIDA.emergencia=''No'') OR (SALIDA.estado_salida=''Provisional'' AND SALIDA.emergencia=''Si'' AND SALIDA.fecha_aprobado_rechazado IS NULL)) AND ';
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
      ELSIF pm_codigo_procedimiento  = 'AL_SAAPRO_COUNT' THEN

        BEGIN
        --Cuenta todos los registros 
               
            g_consulta :=     'SELECT
                              COUNT(SALIDA.id_salida) AS total
                              FROM almin.tal_salida SALIDA
                            LEFT JOIN almin.tal_responsable_almacen RESALM
                            ON RESALM.id_responsable_almacen=SALIDA.id_responsable_almacen
                            INNER JOIN almin.tal_almacen_logico ALMLOG
                            ON ALMLOG.id_almacen_logico=SALIDA.id_almacen_logico
                            LEFT JOIN kard.tkp_empleado EMPLEA
                            ON EMPLEA.id_empleado=SALIDA.id_empleado
                            LEFT JOIN sss.tsg_persona PERSON
                            ON PERSON.id_persona=EMPLEA.id_persona
                            LEFT JOIN almin.tal_firma_autorizada FIRAUT
                            ON FIRAUT.id_firma_autorizada=SALIDA.id_firma_autorizada
                            LEFT JOIN kard.tkp_empleado_tpm_frppa EFRPPA
                            ON EFRPPA.id_empleado_frppa=FIRAUT.id_empleado_frppa
                            LEFT JOIN kard.tkp_empleado EMPLEA2
                            ON EMPLEA2.id_empleado=EFRPPA.id_empleado
                            LEFT JOIN sss.tsg_persona PERSON2
                            ON PERSON2.id_persona=EMPLEA2.id_persona
                            LEFT JOIN param.tpm_contratista CONTRA
                            ON CONTRA.id_contratista=SALIDA.id_contratista
                            INNER JOIN almin.tal_tipo_material TIPMAT
                            ON TIPMAT.id_tipo_material=SALIDA.id_tipo_material
                            LEFT JOIN param.tpm_institucion INSTIT
                            ON INSTIT.id_institucion=SALIDA.id_institucion
                            LEFT JOIN param.tpm_subactividad SUBACT
                            ON SUBACT.id_subactividad=SALIDA.id_subactividad
                            INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			    ON MOSACU.id_motivo_salida_cuenta=SALIDA.id_motivo_salida_cuenta
            			    INNER JOIN almin.tal_motivo_salida MOTSAL
            			    ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
                            WHERE ((SALIDA.estado_salida = ''Pendiente'' AND SALIDA.emergencia=''No'') OR (SALIDA.estado_salida=''Provisional'' AND SALIDA.emergencia=''Si'' AND SALIDA.fecha_aprobado_rechazado IS NULL)) AND ';
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;
         ELSIF  pm_codigo_procedimiento  = 'AL_SALFIN_SEL' THEN
        BEGIN
            g_consulta := 'SELECT
                            SALIDA.id_salida       ,SALIDA.correlativo_sal,SALIDA.correlativo_vale,
                            SALIDA.fecha_entregado ,SALIDA.descripcion     ,SALIDA.contabilizar                ,SALIDA.contabilizado,SALIDA.estado_salida,
                            SALIDA.estado_registro ,SALIDA.motivo_cancelacion          ,SALIDA.id_responsable_almacen,
                            RESALM.cargo as desc_responsable_almacen                   ,SALIDA.id_almacen_logico,
                            ALMLOG.codigo as desc_almacen_logico                       ,SALIDA.id_empleado,
                            (COALESCE(PERSON.nombre,'' '')||'' ''||COALESCE(PERSON.apellido_paterno,'' '')||'' ''|| COALESCE(PERSON.apellido_materno,'' '')) as desc_empleado,
                            SALIDA.id_firma_autorizada,
                            (COALESCE(PERSON2.nombre,'' '')||'' ''||COALESCE(PERSON2.apellido_paterno,'' '')||'' ''|| COALESCE(PERSON2.apellido_materno,'' '')) as desc_firma_autorizada,
                            SALIDA.id_contratista  ,CONTRA.codigo as desc_contratista   ,SALIDA.id_tipo_material,
                            TIPMAT.nombre as desc_tipo_material                         ,SALIDA.id_institucion,
                            INSTIT.nombre as desc_institucion                           ,SALIDA.id_subactividad,SUBACT.codigo as desc_subactividad,
                            SALIDA.id_motivo_salida_cuenta                              ,MOSACU.descripcion as desc_motivo_salida_cuenta,
                            (SELECT CUENTA.nro_cuenta FROM sci.tct_cuenta CUENTA WHERE CUENTA.id_cuenta = MOSACU.id_cuenta) as nro_cuenta,
                            SALIDA.emergencia,
                            SALIDA.observaciones,
                            MOTSAL.nombre,
                            SALIDA.tipo_pedido,
                            SALIDA.tipo_entrega
                            FROM almin.tal_salida SALIDA
                            LEFT JOIN almin.tal_responsable_almacen RESALM
                            ON RESALM.id_responsable_almacen=SALIDA.id_responsable_almacen
                            INNER JOIN almin.tal_almacen_logico ALMLOG
                            ON ALMLOG.id_almacen_logico=SALIDA.id_almacen_logico
                            LEFT JOIN kard.tkp_empleado EMPLEA
                            ON EMPLEA.id_empleado=SALIDA.id_empleado
                            LEFT JOIN sss.tsg_persona PERSON
                            ON PERSON.id_persona=EMPLEA.id_persona
                            LEFT JOIN almin.tal_firma_autorizada FIRAUT
                            ON FIRAUT.id_firma_autorizada=SALIDA.id_firma_autorizada
                            LEFT JOIN kard.tkp_empleado_tpm_frppa EFRPPA
                            ON EFRPPA.id_empleado_frppa=FIRAUT.id_empleado_frppa
                            LEFT JOIN kard.tkp_empleado EMPLEA2
                            ON EMPLEA2.id_empleado=EFRPPA.id_empleado
                            LEFT JOIN sss.tsg_persona PERSON2
                            ON PERSON2.id_persona=EMPLEA2.id_persona
                            LEFT JOIN param.tpm_contratista CONTRA
                            ON CONTRA.id_contratista=SALIDA.id_contratista
                            INNER JOIN almin.tal_tipo_material TIPMAT
                            ON TIPMAT.id_tipo_material=SALIDA.id_tipo_material
                            LEFT JOIN param.tpm_institucion INSTIT
                            ON INSTIT.id_institucion=SALIDA.id_institucion
                            LEFT JOIN param.tpm_subactividad SUBACT
                            ON SUBACT.id_subactividad=SALIDA.id_subactividad
                            INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			    ON MOSACU.id_motivo_salida_cuenta=SALIDA.id_motivo_salida_cuenta
            			    INNER JOIN almin.tal_motivo_salida MOTSAL ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
                            WHERE SALIDA.estado_salida = ''Entregado'' AND ';
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
      ELSIF pm_codigo_procedimiento  = 'AL_SALFIN_COUNT' THEN

        BEGIN
        --Cuenta todos los registros 
               
            g_consulta :=  'SELECT
                            COUNT(SALIDA.id_salida) AS total
                            FROM almin.tal_salida SALIDA
                            LEFT JOIN almin.tal_responsable_almacen RESALM
                            ON RESALM.id_responsable_almacen=SALIDA.id_responsable_almacen
                            INNER JOIN almin.tal_almacen_logico ALMLOG
                            ON ALMLOG.id_almacen_logico=SALIDA.id_almacen_logico
                            LEFT JOIN kard.tkp_empleado EMPLEA
                            ON EMPLEA.id_empleado=SALIDA.id_empleado
                            LEFT JOIN sss.tsg_persona PERSON
                            ON PERSON.id_persona=EMPLEA.id_persona
                            LEFT JOIN almin.tal_firma_autorizada FIRAUT
                            ON FIRAUT.id_firma_autorizada=SALIDA.id_firma_autorizada
                            LEFT JOIN kard.tkp_empleado_tpm_frppa EFRPPA
                            ON EFRPPA.id_empleado_frppa=FIRAUT.id_empleado_frppa
                            LEFT JOIN kard.tkp_empleado EMPLEA2
                            ON EMPLEA2.id_empleado=EFRPPA.id_empleado
                            LEFT JOIN sss.tsg_persona PERSON2
                            ON PERSON2.id_persona=EMPLEA2.id_persona
                            LEFT JOIN param.tpm_contratista CONTRA
                            ON CONTRA.id_contratista=SALIDA.id_contratista
                            INNER JOIN almin.tal_tipo_material TIPMAT
                            ON TIPMAT.id_tipo_material=SALIDA.id_tipo_material
                            LEFT JOIN param.tpm_institucion INSTIT
                            ON INSTIT.id_institucion=SALIDA.id_institucion
                            LEFT JOIN param.tpm_subactividad SUBACT
                            ON SUBACT.id_subactividad=SALIDA.id_subactividad
                            INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			    ON MOSACU.id_motivo_salida_cuenta=SALIDA.id_motivo_salida_cuenta
            			    INNER JOIN almin.tal_motivo_salida MOTSAL ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
                            WHERE SALIDA.estado_salida = ''Entregado'' AND ';
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;
          ELSIF  pm_codigo_procedimiento  = 'AL_SALCON_SEL' THEN
        BEGIN
            g_consulta := 'SELECT
                            SALIDA.id_salida       ,SALIDA.correlativo_sal,SALIDA.correlativo_vale,
                            SALIDA.fecha_provisional ,SALIDA.descripcion     ,SALIDA.contabilizar                ,SALIDA.contabilizado,SALIDA.estado_salida,
                            SALIDA.estado_registro ,SALIDA.motivo_cancelacion          ,SALIDA.id_responsable_almacen,
                            RESALM.cargo as desc_responsable_almacen                   ,SALIDA.id_almacen_logico,
                            ALMLOG.codigo as desc_almacen_logico                       ,SALIDA.id_empleado,
                            (COALESCE(PERSON.nombre,'' '')||'' ''||COALESCE(PERSON.apellido_paterno,'' '')||'' ''|| COALESCE(PERSON.apellido_materno,'' '')) as desc_empleado,
                            SALIDA.id_firma_autorizada,
                            (COALESCE(PERSON2.nombre,'' '')||'' ''||COALESCE(PERSON2.apellido_paterno,'' '')||'' ''|| COALESCE(PERSON2.apellido_materno,'' '')) as desc_firma_autorizada,
                            SALIDA.id_contratista  ,CONTRA.codigo as desc_contratista   ,SALIDA.id_tipo_material,
                            TIPMAT.nombre as desc_tipo_material                         ,SALIDA.id_institucion,
                            INSTIT.nombre as desc_institucion                           ,SALIDA.id_subactividad,SUBACT.codigo as desc_subactividad,
                            SALIDA.id_motivo_salida_cuenta                              ,MOSACU.descripcion as desc_motivo_salida_cuenta,
                            (SELECT CUENTA.nro_cuenta FROM sci.tct_cuenta CUENTA WHERE CUENTA.id_cuenta = MOSACU.id_cuenta) as nro_cuenta,
                            SALIDA.emergencia,
                            SALIDA.observaciones,
                            MOTSAL.nombre,
                            SALIDA.tipo_pedido,
                            SALIDA.tipo_entrega
                            FROM almin.tal_salida SALIDA
                            LEFT JOIN almin.tal_responsable_almacen RESALM
                            ON RESALM.id_responsable_almacen=SALIDA.id_responsable_almacen
                            INNER JOIN almin.tal_almacen_logico ALMLOG
                            ON ALMLOG.id_almacen_logico=SALIDA.id_almacen_logico
                            LEFT JOIN kard.tkp_empleado EMPLEA
                            ON EMPLEA.id_empleado=SALIDA.id_empleado
                            LEFT JOIN sss.tsg_persona PERSON
                            ON PERSON.id_persona=EMPLEA.id_persona
                            LEFT JOIN almin.tal_firma_autorizada FIRAUT
                            ON FIRAUT.id_firma_autorizada=SALIDA.id_firma_autorizada
                            LEFT JOIN kard.tkp_empleado_tpm_frppa EFRPPA
                            ON EFRPPA.id_empleado_frppa=FIRAUT.id_empleado_frppa
                            LEFT JOIN kard.tkp_empleado EMPLEA2
                            ON EMPLEA2.id_empleado=EFRPPA.id_empleado
                            LEFT JOIN sss.tsg_persona PERSON2
                            ON PERSON2.id_persona=EMPLEA2.id_persona
                            LEFT JOIN param.tpm_contratista CONTRA
                            ON CONTRA.id_contratista=SALIDA.id_contratista
                            INNER JOIN almin.tal_tipo_material TIPMAT
                            ON TIPMAT.id_tipo_material=SALIDA.id_tipo_material
                            LEFT JOIN param.tpm_institucion INSTIT
                            ON INSTIT.id_institucion=SALIDA.id_institucion
                            LEFT JOIN param.tpm_subactividad SUBACT
                            ON SUBACT.id_subactividad=SALIDA.id_subactividad
                            INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			    ON MOSACU.id_motivo_salida_cuenta=SALIDA.id_motivo_salida_cuenta
            			    INNER JOIN almin.tal_motivo_salida MOTSAL ON MOTSAL.id_motivo_salida=MOSACU.id_motivo_salida
                            WHERE SALIDA.estado_salida = ''Provisional'' AND SALIDA.fecha_aprobado_rechazado IS NOT NULL AND ';
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
      ELSIF pm_codigo_procedimiento  = 'AL_SALCON_COUNT' THEN

        BEGIN
        --Cuenta todos los registros 
               
            g_consulta :=  'SELECT
                            COUNT(SALIDA.id_salida) AS total
                            FROM almin.tal_salida SALIDA
                            LEFT JOIN almin.tal_responsable_almacen RESALM
                            ON RESALM.id_responsable_almacen=SALIDA.id_responsable_almacen
                            INNER JOIN almin.tal_almacen_logico ALMLOG
                            ON ALMLOG.id_almacen_logico=SALIDA.id_almacen_logico
                            LEFT JOIN kard.tkp_empleado EMPLEA
                            ON EMPLEA.id_empleado=SALIDA.id_empleado
                            LEFT JOIN sss.tsg_persona PERSON
                            ON PERSON.id_persona=EMPLEA.id_persona
                            LEFT JOIN almin.tal_firma_autorizada FIRAUT
                            ON FIRAUT.id_firma_autorizada=SALIDA.id_firma_autorizada
                            LEFT JOIN kard.tkp_empleado_tpm_frppa EFRPPA
                            ON EFRPPA.id_empleado_frppa=FIRAUT.id_empleado_frppa
                            LEFT JOIN kard.tkp_empleado EMPLEA2
                            ON EMPLEA2.id_empleado=EFRPPA.id_empleado
                            LEFT JOIN sss.tsg_persona PERSON2
                            ON PERSON2.id_persona=EMPLEA2.id_persona
                            LEFT JOIN param.tpm_contratista CONTRA
                            ON CONTRA.id_contratista=SALIDA.id_contratista
                            INNER JOIN almin.tal_tipo_material TIPMAT
                            ON TIPMAT.id_tipo_material=SALIDA.id_tipo_material
                            LEFT JOIN param.tpm_institucion INSTIT
                            ON INSTIT.id_institucion=SALIDA.id_institucion
                            LEFT JOIN param.tpm_subactividad SUBACT
                            ON SUBACT.id_subactividad=SALIDA.id_subactividad
                            INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			    ON MOSACU.id_motivo_salida_cuenta=SALIDA.id_motivo_salida_cuenta
            			    INNER JOIN almin.tal_motivo_salida MOTSAL ON MOTSAL.id_motivo_salida=MOSACU.id_motivo_salida
                            WHERE SALIDA.estado_salida = ''Provisional'' AND SALIDA.fecha_aprobado_rechazado IS NOT NULL AND ';
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;
    ELSIF  pm_codigo_procedimiento  = 'AL_SALPEN_SEL' THEN
        BEGIN
            g_consulta := 'SELECT
                            SALIDA.id_salida       ,SALIDA.correlativo_sal,SALIDA.correlativo_vale,
                            SALIDA.fecha_aprobado_rechazado ,SALIDA.descripcion     ,SALIDA.contabilizar                ,SALIDA.contabilizado,SALIDA.estado_salida,
                            SALIDA.estado_registro ,SALIDA.motivo_cancelacion          ,SALIDA.id_responsable_almacen,
                            RESALM.cargo as desc_responsable_almacen                   ,SALIDA.id_almacen_logico,
                            ALMLOG.codigo as desc_almacen_logico                       ,SALIDA.id_empleado,
                            (COALESCE(PERSON.nombre,'' '')||'' ''||COALESCE(PERSON.apellido_paterno,'' '')||'' ''|| COALESCE(PERSON.apellido_materno,'' '')) as desc_empleado,
                            SALIDA.id_firma_autorizada,
                            (COALESCE(PERSON2.nombre,'' '')||'' ''||COALESCE(PERSON2.apellido_paterno,'' '')||'' ''|| COALESCE(PERSON2.apellido_materno,'' '')) as desc_firma_autorizada,
                            SALIDA.id_contratista  ,CONTRA.codigo as desc_contratista   ,SALIDA.id_tipo_material,
                            TIPMAT.nombre as desc_tipo_material                         ,SALIDA.id_institucion,
                            INSTIT.nombre as desc_institucion                           ,SALIDA.id_subactividad,SUBACT.codigo as desc_subactividad,
                            SALIDA.id_motivo_salida_cuenta                              ,MOSACU.descripcion as desc_motivo_salida_cuenta,
                            (SELECT CUENTA.nro_cuenta FROM sci.tct_cuenta CUENTA WHERE CUENTA.id_cuenta = MOSACU.id_cuenta) as nro_cuenta,
                            SALIDA.emergencia,
                            SALIDA.observaciones,
                            MOTSAL.nombre as desc_motivo_salida,
                            SALIDA.tipo_pedido,
                            SALIDA.tipo_entrega
                            FROM almin.tal_salida SALIDA
                            LEFT JOIN almin.tal_responsable_almacen RESALM
                            ON RESALM.id_responsable_almacen=SALIDA.id_responsable_almacen
                            INNER JOIN almin.tal_almacen_logico ALMLOG
                            ON ALMLOG.id_almacen_logico=SALIDA.id_almacen_logico
                            LEFT JOIN kard.tkp_empleado EMPLEA
                            ON EMPLEA.id_empleado=SALIDA.id_empleado
                            LEFT JOIN sss.tsg_persona PERSON
                            ON PERSON.id_persona=EMPLEA.id_persona
                            LEFT JOIN almin.tal_firma_autorizada FIRAUT
                            ON FIRAUT.id_firma_autorizada=SALIDA.id_firma_autorizada
                            LEFT JOIN kard.tkp_empleado_tpm_frppa EFRPPA
                            ON EFRPPA.id_empleado_frppa=FIRAUT.id_empleado_frppa
                            LEFT JOIN kard.tkp_empleado EMPLEA2
                            ON EMPLEA2.id_empleado=EFRPPA.id_empleado
                            LEFT JOIN sss.tsg_persona PERSON2
                            ON PERSON2.id_persona=EMPLEA2.id_persona
                            LEFT JOIN param.tpm_contratista CONTRA
                            ON CONTRA.id_contratista=SALIDA.id_contratista
                            INNER JOIN almin.tal_tipo_material TIPMAT
                            ON TIPMAT.id_tipo_material=SALIDA.id_tipo_material
                            LEFT JOIN param.tpm_institucion INSTIT
                            ON INSTIT.id_institucion=SALIDA.id_institucion
                            LEFT JOIN param.tpm_subactividad SUBACT
                            ON SUBACT.id_subactividad=SALIDA.id_subactividad
                            INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			    ON MOSACU.id_motivo_salida_cuenta=SALIDA.id_motivo_salida_cuenta
            			    INNER JOIN almin.tal_motivo_salida MOTSAL ON MOTSAL.id_motivo_salida= MOSACU.id_motivo_salida
                            WHERE (SALIDA.estado_salida = ''Aprobado'' OR (SALIDA.estado_salida=''Pendiente'' AND SALIDA.emergencia=''Si'')) AND ';
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
      ELSIF pm_codigo_procedimiento  = 'AL_SALPEN_COUNT' THEN

        BEGIN
        --Cuenta todos los registros 
               
            g_consulta :=  'SELECT
                            COUNT(SALIDA.id_salida) AS total
                            FROM almin.tal_salida SALIDA
                            LEFT JOIN almin.tal_responsable_almacen RESALM
                            ON RESALM.id_responsable_almacen=SALIDA.id_responsable_almacen
                            INNER JOIN almin.tal_almacen_logico ALMLOG
                            ON ALMLOG.id_almacen_logico=SALIDA.id_almacen_logico
                            LEFT JOIN kard.tkp_empleado EMPLEA
                            ON EMPLEA.id_empleado=SALIDA.id_empleado
                            LEFT JOIN sss.tsg_persona PERSON
                            ON PERSON.id_persona=EMPLEA.id_persona
                            LEFT JOIN almin.tal_firma_autorizada FIRAUT
                            ON FIRAUT.id_firma_autorizada=SALIDA.id_firma_autorizada
                            LEFT JOIN kard.tkp_empleado_tpm_frppa EFRPPA
                            ON EFRPPA.id_empleado_frppa=FIRAUT.id_empleado_frppa
                            LEFT JOIN kard.tkp_empleado EMPLEA2
                            ON EMPLEA2.id_empleado=EFRPPA.id_empleado
                            LEFT JOIN sss.tsg_persona PERSON2
                            ON PERSON2.id_persona=EMPLEA2.id_persona
                            LEFT JOIN param.tpm_contratista CONTRA
                            ON CONTRA.id_contratista=SALIDA.id_contratista
                            INNER JOIN almin.tal_tipo_material TIPMAT
                            ON TIPMAT.id_tipo_material=SALIDA.id_tipo_material
                            LEFT JOIN param.tpm_institucion INSTIT
                            ON INSTIT.id_institucion=SALIDA.id_institucion
                            LEFT JOIN param.tpm_subactividad SUBACT
                            ON SUBACT.id_subactividad=SALIDA.id_subactividad
                            INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			    ON MOSACU.id_motivo_salida_cuenta=SALIDA.id_motivo_salida_cuenta
            			    INNER JOIN almin.tal_motivo_salida MOTSAL ON MOTSAL.id_motivo_salida= MOSACU.id_motivo_salida
                            WHERE (SALIDA.estado_salida = ''Aprobado'' OR (SALIDA.estado_salida=''Pendiente'' AND SALIDA.emergencia=''Si'')) AND ';
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;

    ELSIF pm_codigo_procedimiento  = 'AL_SALIPR_SEL' THEN
    --Listado de todos las salidas (SALIDAS RÁPIDAS PARA PROYECTOS)
        BEGIN
            g_consulta := 'SELECT
                           SALIDA.id_salida       , ''S - '' || SALIDA.correlativo_sal as correlativo_sal,
                           SALIDA.correlativo_vale,
                           SALIDA.descripcion     ,SALIDA.contabilizar                ,SALIDA.contabilizado,SALIDA.estado_salida,
                           SALIDA.estado_registro ,SALIDA.motivo_cancelacion          ,SALIDA.id_responsable_almacen,
                           RESALM.cargo as desc_responsable_almacen                   ,SALIDA.id_almacen_logico,
                           ALMLOG.nombre as desc_almacen_logico                       ,SALIDA.id_empleado,
                           (COALESCE(PERSON.nombre,'' '')||'' ''||COALESCE(PERSON.apellido_paterno,'' '')||'' ''|| COALESCE(PERSON.apellido_materno,'' '')) as desc_empleado,
                           SALIDA.id_firma_autorizada,
                           (COALESCE(PERSON2.nombre,'' '')||'' ''||COALESCE(PERSON2.apellido_paterno,'' '')||'' ''|| COALESCE(PERSON2.apellido_materno,'' '')) as desc_firma_autorizada,
                           SALIDA.id_contratista,
                           (SELECT CASE
                                    WHEN CONTRA.id_institucion IS NOT NULL THEN (SELECT INSTIT.nombre FROM param.tpm_institucion INSTIT WHERE INSTIT.id_institucion = CONTRA.id_institucion)
                                    WHEN CONTRA.id_persona IS NOT NULL THEN (SELECT COALESCE(PERSON.nombre,'' '')||''  ''||COALESCE(PERSON.apellido_paterno,'' '')||''  ''||COALESCE(PERSON.apellido_materno,'' '') FROM sss.tsg_persona PERSON WHERE PERSON.id_persona = CONTRA.id_persona)
                                  END) as desc_contratista,
                           SALIDA.id_tipo_material,
                           TIPMAT.nombre as desc_tipo_material                         ,SALIDA.id_institucion,
                           INSTIT.nombre as desc_institucion                           ,SALIDA.id_subactividad,SUBACT.descripcion as desc_subactividad,
                           SALIDA.id_motivo_salida_cuenta                              ,MOSACU.descripcion as desc_motivo_salida_cuenta,
                           (SELECT CUENTA.nro_cuenta FROM sci.tct_cuenta CUENTA WHERE CUENTA.id_cuenta = MOSACU.id_cuenta) as nro_cuenta,
                           MOTSAL.nombre as desc_motivo_salida                        ,ALMACE.nombre as desc_almacen,
                           FINANC.nombre_financiador,
                           REGION.nombre_regional                  ,PROGRA.nombre_programa                ,PROYEC.nombre_proyecto,
                           ACTIVI.nombre_actividad                 ,FINANC.id_financiador                 ,REGION.id_regional,
                           PROGRA.id_programa                      ,PROYEC.id_proyecto                    ,ACTIVI.id_actividad,
                           FINANC.codigo_financiador               ,REGION.codigo_regional                ,PROGRA.codigo_programa,
                           PROYEC.codigo_proyecto                  ,ACTIVI.codigo_actividad               ,SALIDA.emergencia,
                           SALIDA.observaciones                    ,SALIDA.tipo_pedido                    ,SALIDA.receptor,           SALIDA.receptor_ci,
                           SALIDA.solicitante                      ,SALIDA.solicitante_ci,
                           SALIDA.id_tramo_subactividad            ,SALIDA.id_tramo_unidad_constructiva   ,TRAMO.descripcion as desc_tramo,
                           UNICON.codigo as desc_unidad_cons       ,SALIDA.fecha_borrador                 ,SALIDA.num_contrato,
                           PARALM.gestion                          ,MOTSAL.id_motivo_salida               ,ALMACE.id_almacen,
                           SUPERV.id_supervisor,
                           COALESCE(PERSON3.apellido_paterno,'''') || '' '' || COALESCE(PERSON3.apellido_materno,'''') || '' '' || COALESCE(PERSON3.nombre,'''') as nombre_superv

                           FROM almin.tal_salida SALIDA
                           LEFT JOIN almin.tal_responsable_almacen RESALM
                           ON RESALM.id_responsable_almacen=SALIDA.id_responsable_almacen
                           INNER JOIN almin.tal_almacen_logico ALMLOG
                           ON ALMLOG.id_almacen_logico=SALIDA.id_almacen_logico
                           LEFT JOIN kard.tkp_empleado EMPLEA
                           ON EMPLEA.id_empleado=SALIDA.id_empleado
                           LEFT JOIN sss.tsg_persona PERSON
                           ON PERSON.id_persona=EMPLEA.id_persona
                           LEFT JOIN almin.tal_firma_autorizada FIRAUT
                           ON FIRAUT.id_firma_autorizada=SALIDA.id_firma_autorizada
                           LEFT JOIN kard.tkp_empleado_tpm_frppa EFRPPA
                           ON EFRPPA.id_empleado_frppa=FIRAUT.id_empleado_frppa
                           LEFT JOIN kard.tkp_empleado EMPLEA2
                           ON EMPLEA2.id_empleado=EFRPPA.id_empleado
                           
                           LEFT JOIN sss.tsg_persona PERSON2
                           ON PERSON2.id_persona=EMPLEA2.id_persona
                           
                           LEFT JOIN almin.tal_supervisor SUPERV
                           ON SUPERV.id_supervisor = SALIDA.id_supervisor
                           LEFT JOIN sss.tsg_persona PERSON3
                           ON PERSON3.id_persona = SUPERV.id_persona
                           
                           LEFT JOIN param.tpm_contratista CONTRA
                           ON CONTRA.id_contratista=SALIDA.id_contratista
                           INNER JOIN almin.tal_tipo_material TIPMAT
                           ON TIPMAT.id_tipo_material=SALIDA.id_tipo_material
                           LEFT JOIN param.tpm_institucion INSTIT
                           ON INSTIT.id_institucion=SALIDA.id_institucion
                           LEFT JOIN param.tpm_subactividad SUBACT
                           ON SUBACT.id_subactividad=SALIDA.id_subactividad
                           INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			   ON MOSACU.id_motivo_salida_cuenta=SALIDA.id_motivo_salida_cuenta
            			   INNER JOIN almin.tal_almacen_ep ALMAEP
            			   ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
            			   INNER JOIN almin.tal_almacen ALMACE
            			   ON ALMACE.id_almacen = ALMAEP.id_almacen
            			   INNER JOIN almin.tal_motivo_salida MOTSAL
            			   ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
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
                           LEFT JOIN almin.tal_tramo_subactividad TRASUB
                           ON TRASUB.id_tramo_subactividad = SALIDA.id_tramo_subactividad
                           LEFT JOIN almin.tal_tramo TRAMO
                           ON TRAMO.id_tramo = TRASUB.id_tramo
                           LEFT JOIN almin.tal_tramo_unidad_constructiva TRAUNI
                           ON TRAUNI.id_tramo_unidad_constructiva = SALIDA.id_tramo_unidad_constructiva
                           LEFT JOIN almin.tal_unidad_constructiva UNICON
                           ON UNICON.id_unidad_constructiva = TRAUNI.id_unidad_constructiva
                           INNER JOIN almin.tal_parametro_almacen PARALM
                           ON PARALM.id_parametro_almacen = SALIDA.id_parametro_almacen
                           WHERE SALIDA.estado_salida not like ''Finalizado'' AND ';
            g_consulta := g_consulta || pm_criterio_filtro;
          --  para que los usuarios  solo puedan ver los pedidos realizados por ellos
            IF NOT g_rol_adm  THEN
                g_consulta := g_consulta || ' SALIDA.id_usuario=' || pm_id_susario ||'  AND ';
            END IF;



            -- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;

            raise notice '%',g_consulta;
            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;

    -- PARA LA CONSULTA DE SELECCIÓN
    ELSIF pm_codigo_procedimiento  = 'AL_SALIPR_COUNT' THEN
    --Listado de todos las salidas (SALIDAS RÁPIDAS PARA PROYECTOS)
        BEGIN
        --Cuenta todos los registros
            g_consulta := 'SELECT
                           COUNT(SALIDA.id_salida) AS total
                           FROM almin.tal_salida SALIDA
                           LEFT JOIN almin.tal_responsable_almacen RESALM
                           ON RESALM.id_responsable_almacen=SALIDA.id_responsable_almacen
                           INNER JOIN almin.tal_almacen_logico ALMLOG
                           ON ALMLOG.id_almacen_logico=SALIDA.id_almacen_logico
                           LEFT JOIN kard.tkp_empleado EMPLEA
                           ON EMPLEA.id_empleado=SALIDA.id_empleado
                           LEFT JOIN sss.tsg_persona PERSON
                           ON PERSON.id_persona=EMPLEA.id_persona
                           LEFT JOIN almin.tal_firma_autorizada FIRAUT
                           ON FIRAUT.id_firma_autorizada=SALIDA.id_firma_autorizada
                           LEFT JOIN kard.tkp_empleado_tpm_frppa EFRPPA
                           ON EFRPPA.id_empleado_frppa=FIRAUT.id_empleado_frppa
                           LEFT JOIN kard.tkp_empleado EMPLEA2
                           ON EMPLEA2.id_empleado=EFRPPA.id_empleado
                           LEFT JOIN sss.tsg_persona PERSON2
                           ON PERSON2.id_persona=EMPLEA2.id_persona
                           LEFT JOIN param.tpm_contratista CONTRA
                           ON CONTRA.id_contratista=SALIDA.id_contratista
                           INNER JOIN almin.tal_tipo_material TIPMAT
                           ON TIPMAT.id_tipo_material=SALIDA.id_tipo_material
                           LEFT JOIN param.tpm_institucion INSTIT
                           ON INSTIT.id_institucion=SALIDA.id_institucion
                           LEFT JOIN param.tpm_subactividad SUBACT
                           ON SUBACT.id_subactividad=SALIDA.id_subactividad
                           INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			   ON MOSACU.id_motivo_salida_cuenta=SALIDA.id_motivo_salida_cuenta
            			   INNER JOIN almin.tal_almacen_ep ALMAEP
            			   ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
            			   INNER JOIN almin.tal_almacen ALMACE
            			   ON ALMACE.id_almacen = ALMAEP.id_almacen
            			   INNER JOIN almin.tal_motivo_salida MOTSAL
            			   ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
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
                           LEFT JOIN almin.tal_tramo_subactividad TRASUB
                           ON TRASUB.id_tramo_subactividad = SALIDA.id_tramo_subactividad
                           LEFT JOIN almin.tal_tramo TRAMO
                           ON TRAMO.id_tramo = TRASUB.id_tramo
                           LEFT JOIN almin.tal_tramo_unidad_constructiva TRAUNI
                           ON TRAUNI.id_tramo_unidad_constructiva = SALIDA.id_tramo_unidad_constructiva
                           LEFT JOIN almin.tal_unidad_constructiva UNICON
                           ON UNICON.id_unidad_constructiva = TRAUNI.id_unidad_constructiva
                           INNER JOIN almin.tal_parametro_almacen PARALM
                           ON PARALM.id_parametro_almacen = SALIDA.id_parametro_almacen
                           WHERE SALIDA.estado_salida not like ''Finalizado'' AND ';
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
 
    ELSIF pm_codigo_procedimiento  = 'AL_PMUCRP_SEL' THEN -- PMUCRP: Pedido Materiales Unidades Constructivas Reporte
        --Para reporte de Pedido de Materiales   de Unidades Constructivas
        BEGIN
            g_consulta := 'SELECT
						ALMACE.nombre as desc_almacen, SALIDA.receptor, to_char(SALIDA.fecha_borrador,''dd/mm/yyyy''), OSUCDE.cantidad,
						TIPOUC.nombre as desc_uc, TIPOUC1.nombre as desc_uc_padre,
                        OSUCDE.id_tipo_unidad_constructiva,
                        CASE COALESCE(SALIDA.id_institucion,0)
    					    WHEN 0 THEN CASE COALESCE(SALIDA.id_contratista,0)
                         	                WHEN 0 THEN (SELECT COALESCE(apellido_paterno,'' '')||'' ''||COALESCE(apellido_materno,'' '')||'' ''||COALESCE(nombre,'' '') FROM sss.tsg_persona WHERE id_persona = EMPLEA.id_persona)
                    						ELSE (SELECT COALESCE(nombre,'' '') FROM param.tpm_institucion WHERE id_institucion = CONTRA.id_institucion)
                						END
    						ELSE INSTIT.nombre
						END as solicitante,
                                                SALIDA.receptor_ci,
                                                COALESCE(PERSON.nombre,'''') || '' '' ||  COALESCE(PERSON.apellido_paterno,'''') || '' '' || COALESCE(PERSON.apellido_materno,'''') as supervisor,
                                                PERSON.doc_id as superv_doc_id,
                                                COALESCE(PERSON1.nombre,'''') || '' '' ||  COALESCE(PERSON1.apellido_paterno,'''') || '' '' || COALESCE(PERSON1.apellido_materno,'''') as almacenero,
                                                PERSON1.doc_id as almacenero_doc_id,
                                                ''S - '' || SALIDA.correlativo_sal as correlativo_sal,
                                                SALIDA.num_contrato,
                                                TRAMO.descripcion as tramo, SUBACT.descripcion as subactividad,
                                                UNICON.codigo as uc,

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

                        SALIDA.observaciones,
                        ALMLOG.nombre as almacen_log,
                        MOTSAL.nombre as motivo_sal,
                        PROY.codigo_proyecto

FROM almin.tal_orden_salida_uc_detalle OSUCDE
						INNER JOIN almin.tal_salida SALIDA
						ON SALIDA.id_salida = OSUCDE.id_salida
						INNER JOIN almin.tal_almacen_logico ALMLOG
						ON ALMLOG.id_almacen_logico = SALIDA.id_almacen_logico
						INNER JOIN almin.tal_almacen_ep ALMAEP
						ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
						INNER JOIN almin.tal_almacen ALMACE
						ON ALMACE.id_almacen = ALMAEP.id_almacen
						
						INNER JOIN param.tpm_fina_regi_prog_proy_acti EP
						ON EP.id_fina_regi_prog_proy_acti=ALMAEP.id_fina_regi_prog_proy_acti
						INNER JOIN param.tpm_programa_proyecto_actividad PPA
						ON PPA.id_prog_proy_acti=EP.id_prog_proy_acti
						INNER JOIN param.tpm_proyecto PROY
						ON PROY.id_proyecto=PPA.id_proyecto
						
						INNER JOIN almin.tal_motivo_salida_cuenta MSC
						ON SALIDA.id_motivo_salida_cuenta=MSC.id_motivo_salida_cuenta
						INNER JOIN almin.tal_motivo_salida MOTSAL
						ON MSC.id_motivo_salida=MOTSAL.id_motivo_salida
						
						INNER JOIN almin.tal_tipo_unidad_constructiva TIPOUC
						ON TIPOUC.id_tipo_unidad_constructiva = OSUCDE.id_tipo_unidad_constructiva
						LEFT JOIN almin.tal_composicion_tuc COMTUC
						ON COMTUC.id_tuc_hijo = OSUCDE.id_tipo_unidad_constructiva
						LEFT JOIN almin.tal_tipo_unidad_constructiva TIPOUC1
						ON TIPOUC1.id_tipo_unidad_constructiva = COMTUC.id_tipo_unidad_constructiva
                        LEFT JOIN param.tpm_contratista CONTRA
						ON CONTRA.id_contratista = SALIDA.id_contratista
						LEFT JOIN param.tpm_institucion INSTIT
						ON INSTIT.id_institucion = SALIDA.id_institucion
						LEFT JOIN kard.tkp_empleado EMPLEA
						ON EMPLEA.id_empleado = SALIDA.id_empleado
                                                LEFT JOIN almin.tal_supervisor SUPERV
                                                ON SUPERV.id_supervisor = SALIDA.id_supervisor
                                                LEFT JOIN sss.tsg_persona PERSON
                                                ON PERSON.id_persona = SUPERV.id_persona
                                                INNER JOIN almin.tal_responsable_almacen RESALM
                                                ON RESALM.id_responsable_almacen = SALIDA.id_responsable_almacen
                                                INNER JOIN kard.tkp_empleado EMPLEA1
                                                ON EMPLEA1.id_empleado = RESALM.id_empleado
                                                INNER JOIN sss.tsg_persona PERSON1
                                                ON PERSON1.id_persona = EMPLEA1.id_persona
                                                LEFT JOIN almin.tal_tramo_subactividad TRASUB
                                                ON TRASUB.id_tramo_subactividad = SALIDA.id_tramo_subactividad
                                                LEFT JOIN almin.tal_tramo TRAMO
                                                ON TRAMO.id_tramo = TRASUB.id_tramo
                                                LEFT JOIN param.tpm_subactividad SUBACT
                                                ON SUBACT.id_subactividad = TRASUB.id_subactividad
                                                LEFT JOIN almin.tal_tramo_unidad_constructiva TRAMUC
                                                ON TRAMUC.id_tramo_unidad_constructiva =                SALIDA.id_tramo_unidad_constructiva
                                                LEFT JOIN almin.tal_unidad_constructiva UNICON
                                                ON UNICON.id_unidad_constructiva = TRAMUC.id_unidad_constructiva

INNER JOIN almin.tal_responsable_almacen RESALM1
ON RESALM1.id_responsable_almacen = SALIDA.id_jefe_almacen
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
 /*
 Autor	    	RAC
 Fecha:			14/12/2016
 Descripcion	- Corregir fallo al listar salidas por transferencias
 
 */

  ELSIF pm_codigo_procedimiento  = 'AL_PMSIMP_SEL' THEN -- PMSIMP: Pedido Materiales Simplificado Reporte
        --Para reporte de Pedido de Materiales   Simplificado
        BEGIN
            g_consulta := 'SELECT
                           ALMACE.nombre as desc_almacen, 
                           SALIDA.receptor,
                           ALMLOG.nombre as almacen_log,
                           PROY.codigo_proyecto,
	                       MOTSAL.nombre as motivo_sal,
                           to_char(SALIDA.fecha_borrador,''dd/mm/yyyy''), 
                          CASE COALESCE(SALIDA.id_institucion,0)
                          WHEN 0 THEN CASE COALESCE(SALIDA.id_contratista,0)
                          WHEN 0 THEN (SELECT COALESCE(apellido_paterno,'' '')||'' ''||COALESCE(apellido_materno,'' '')||'' ''||COALESCE(nombre,'' '') FROM sss.tsg_persona WHERE id_persona = EMPLEA.id_persona)
                          ELSE (SELECT COALESCE(nombre,'' '') FROM param.tpm_institucion WHERE id_institucion = CONTRA.id_institucion)
                         END
                         ELSE INSTIT.nombre
                         END as solicitante,
                         SALIDA.receptor_ci,
                         COALESCE(PERSON.nombre,'''') || '' '' ||  COALESCE(PERSON.apellido_paterno,'''') || '' '' || COALESCE(PERSON.apellido_materno,'''') as supervisor,
                         PERSON.doc_id as superv_doc_id,               
                         COALESCE(PERSON1.nombre,'''') || '' '' ||  COALESCE(PERSON1.apellido_paterno,'''') || '' '' || COALESCE(PERSON1.apellido_materno,'''') as almacenero,
                         PERSON1.doc_id as almacenero_doc_id,
                         ''S - '' || SALIDA.correlativo_sal as correlativo_sal,
                         SALIDA.num_contrato,
                         TRAMO.descripcion as tramo, 
                         SUBACT.descripcion as subactividad,
     
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
     
     SALIDA.observaciones

FROM almin.tal_salida SALIDA
			                        
						INNER JOIN almin.tal_almacen_logico ALMLOG
						ON ALMLOG.id_almacen_logico = SALIDA.id_almacen_logico
						INNER JOIN almin.tal_almacen_ep ALMAEP
						ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
						INNER JOIN almin.tal_almacen ALMACE
						ON ALMACE.id_almacen = ALMAEP.id_almacen
						
					    INNER JOIN param.tpm_fina_regi_prog_proy_acti EP
		                ON ALMAEP.id_fina_regi_prog_proy_acti=EP.id_fina_regi_prog_proy_acti
		                INNER JOIN param.tpm_programa_proyecto_actividad PPA
		                ON EP.id_prog_proy_acti=PPA.id_prog_proy_acti
		                INNER JOIN param.tpm_proyecto PROY
		                ON PPA.id_proyecto=PROY.id_proyecto

		                INNER JOIN almin.tal_motivo_salida_cuenta MSC
		                ON SALIDA.id_motivo_salida_cuenta=MSC.id_motivo_salida_cuenta
		                INNER JOIN almin.tal_motivo_salida MOTSAL
		                ON MSC.id_motivo_salida=MOTSAL.id_motivo_salida
                        
                        LEFT JOIN param.tpm_contratista CONTRA
						ON CONTRA.id_contratista = SALIDA.id_contratista
						LEFT JOIN param.tpm_institucion INSTIT
						ON INSTIT.id_institucion = SALIDA.id_institucion
						LEFT JOIN kard.tkp_empleado EMPLEA
						ON EMPLEA.id_empleado = SALIDA.id_empleado
                        LEFT JOIN almin.tal_supervisor SUPERV
                        ON SUPERV.id_supervisor = SALIDA.id_supervisor
                        LEFT JOIN sss.tsg_persona PERSON
                        ON PERSON.id_persona = SUPERV.id_persona
                        INNER JOIN almin.tal_responsable_almacen RESALM
                        ON RESALM.id_responsable_almacen = SALIDA.id_responsable_almacen
                        INNER JOIN kard.tkp_empleado EMPLEA1
                        ON EMPLEA1.id_empleado = RESALM.id_empleado
                        INNER JOIN sss.tsg_persona PERSON1
                        ON PERSON1.id_persona = EMPLEA1.id_persona
                        LEFT JOIN almin.tal_tramo_subactividad TRASUB
                        ON TRASUB.id_tramo_subactividad = SALIDA.id_tramo_subactividad
                        LEFT JOIN almin.tal_tramo TRAMO
                        ON TRAMO.id_tramo = TRASUB.id_tramo
                        LEFT JOIN param.tpm_subactividad SUBACT
                        ON SUBACT.id_subactividad = TRASUB.id_subactividad
                        LEFT JOIN almin.tal_tramo_unidad_constructiva TRAMUC
                        ON TRAMUC.id_tramo_unidad_constructiva = SALIDA.id_tramo_unidad_constructiva
                        LEFT JOIN almin.tal_responsable_almacen RESALM1
                        ON RESALM1.id_responsable_almacen = SALIDA.id_jefe_almacen
						WHERE ';
                        
            g_consulta := g_consulta || pm_criterio_filtro;

            -- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;
            
            
            raise notice 'consulta %', g_consulta;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;     
    
    ELSIF pm_codigo_procedimiento  = 'AL_PMUCDR_SEL' THEN -- PMUCDR: Pedido Materiales UC Detalle Reporte
        --Detalle de pedido de materiales  de Unidades COnstructivas
        BEGIN
            g_consulta := 'SELECT
                           ITEM.nombre,
                           COMPON.cantidad as cant_unit_uc,
                           ITEM.peso_kg, 
                           UNMEDB.abreviatura as unidad_medida,
                           ITEM.calidad,
                           ITEM.descripcion,
                           (COMPON.cantidad * OSUCDE.cantidad) * ITEM.peso_kg as peso_total,  
                           COMPON.cantidad * OSUCDE.cantidad as cantidad_total,
   CASE SUPGRU.demasia
     WHEN ''si''
     THEN ROUND(COMPON.cantidad * OSUCDE.cantidad * (SELECT demasia_porc FROM almin.tal_parametro_almacen WHERE cierre=''no'' LIMIT 1)/100)
     ELSE
     0
     END as cant_demasia,
                                                
     CASE SUPGRU.demasia
     WHEN ''si''
     THEN (COMPON.cantidad * OSUCDE.cantidad) + ROUND(COMPON.cantidad * OSUCDE.cantidad * (SELECT demasia_porc FROM almin.tal_parametro_almacen WHERE cierre=''no'' LIMIT 1)/100)
     ELSE
     COMPON.cantidad * OSUCDE.cantidad
     END as cant_total_dem,

                     ALMACE.nombre as desc_almacen,
                     TIPOUC.nombre as desc_uc,
                     OSUCDE.cantidad as cantidad_uc,
                     ITEM.codigo, 
                     TIPOUC1.nombre as desc_uc_padre,
   CASE COALESCE(SALIDA.id_institucion,0)
    WHEN 0 THEN CASE COALESCE(SALIDA.id_contratista,0)
    WHEN 0 THEN (SELECT COALESCE(apellido_paterno,'' '')||'' ''||COALESCE(apellido_materno,'' '')||'' ''||COALESCE(nombre,'' '') FROM sss.tsg_persona WHERE id_persona = EMPLEA.id_persona)
     ELSE (SELECT COALESCE(nombre,'' '') FROM param.tpm_institucion WHERE id_institucion = CONTRA.id_institucion)
                						END
    						ELSE INSTIT.nombre
						END as solicitante,
			
  SUPGRU.nombre, ITEM.id_supergrupo,
  SUPGRU.demasia
                      
FROM almin.tal_orden_salida_uc_detalle OSUCDE
						INNER JOIN almin.tal_salida SALIDA
						ON SALIDA.id_salida = OSUCDE.id_salida
						INNER JOIN almin.tal_almacen_logico ALMLOG
						ON ALMLOG.id_almacen_logico = SALIDA.id_almacen_logico
						INNER JOIN almin.tal_almacen_ep ALMAEP
						ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
						INNER JOIN almin.tal_almacen ALMACE
						ON ALMACE.id_almacen = ALMAEP.id_almacen
						INNER JOIN almin.tal_componente COMPON
						ON COMPON.id_tipo_unidad_constructiva = OSUCDE.id_tipo_unidad_constructiva
						INNER JOIN almin.tal_tipo_unidad_constructiva TIPOUC
						ON TIPOUC.id_tipo_unidad_constructiva = COMPON.id_tipo_unidad_constructiva
						INNER JOIN almin.tal_item ITEM
						ON ITEM.id_item = COMPON.id_item
						LEFT JOIN almin.tal_composicion_tuc COMTUC
						ON COMTUC.id_tuc_hijo = OSUCDE.id_tipo_unidad_constructiva
						LEFT JOIN almin.tal_tipo_unidad_constructiva TIPOUC1
						ON TIPOUC1.id_tipo_unidad_constructiva = COMTUC.id_tipo_unidad_constructiva
                        LEFT JOIN param.tpm_contratista CONTRA
						ON CONTRA.id_contratista = SALIDA.id_contratista
						LEFT JOIN param.tpm_institucion INSTIT
						ON INSTIT.id_institucion = SALIDA.id_institucion
						LEFT JOIN kard.tkp_empleado EMPLEA
						ON EMPLEA.id_empleado = SALIDA.id_empleado
						INNER JOIN param.tpm_unidad_medida_base UNMEDB
						ON UNMEDB.id_unidad_medida_base = ITEM.id_unidad_medida_base
                        INNER JOIN almin.tal_supergrupo SUPGRU
                        ON SUPGRU.id_supergrupo = ITEM.id_supergrupo
						WHERE ';
                        
            g_consulta := g_consulta || pm_criterio_filtro;

            -- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;
            
            raise notice '--> %',g_consulta;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;   
     /*
     Autor:		Rensi Arteaga Copari
     Desc		Lista los materiales entregados para reporte de salidas de uc entregadas
     Fecha		30/12/2016
     
     */   
        
     ELSIF pm_codigo_procedimiento  = 'AL_PMUCDRENT_SEL' THEN -- PMUCDR: Pedido Materiales UC Detalle Reporte
        --Detalle de pedido de materiales  de Unidades COnstructivas
        BEGIN
            g_consulta := 'SELECT
                                i.nombre,
                                1::NUMERIC as cant_unit_uc,
                                i.peso_kg, 
                                umb.abreviatura as unidad_medida,
                                i.calidad,
                                i.descripcion,
                                sd.cant_consolidada * i.peso_kg as peso_total,  
                                sd.cant_consolidada as cantidad_total,
                                sd.cant_demasia as cant_demasia,  
                                sd.cant_entregada   as  cant_total_dem,
                                
                                 ALMACE.nombre as desc_almacen,
                                 '' ''::varchar as desc_uc,
                                 1::NUMERIC as cantidad_uc,
                                 i.codigo, 
                                 '' ''::varchar as desc_uc_padre,
                                 
                                 CASE COALESCE(sal.id_institucion,0)
                                  WHEN 0 THEN CASE COALESCE(sal.id_contratista,0)
                                  WHEN 0 THEN (SELECT COALESCE(apellido_paterno,'' '')||'' ''||COALESCE(apellido_materno,'' '')||'' ''||COALESCE(nombre,'' '') FROM sss.tsg_persona WHERE id_persona = EMPLEA.id_persona)
                                   ELSE (SELECT COALESCE(nombre,'' '') FROM param.tpm_institucion WHERE id_institucion = CONTRA.id_institucion)
                                                                      END
                                                          ELSE INSTIT.nombre
                                                      END as solicitante,
                                 
                                 
                                
                                 sg.nombre, 
                                 i.id_supergrupo,
                                 sg.demasia
                                

                              FROM almin.tal_salida_detalle sd
                              inner join almin.tal_item i on i.id_item = sd.id_item
                              INNER JOIN param.tpm_unidad_medida_base umb on umb.id_unidad_medida_base = i.id_unidad_medida_base
                              INNER JOIN almin.tal_supergrupo sg  ON sg.id_supergrupo = i.id_supergrupo
                              inner join almin.tal_salida sal ON  sal.id_salida = sd.id_salida
                              INNER JOIN almin.tal_almacen_logico ALMLOG ON ALMLOG.id_almacen_logico = sal.id_almacen_logico
                              INNER JOIN almin.tal_almacen_ep ALMAEP ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
                              INNER JOIN almin.tal_almacen ALMACE ON ALMACE.id_almacen = ALMAEP.id_almacen


                              LEFT JOIN kard.tkp_empleado EMPLEA  ON EMPLEA.id_empleado = sal.id_empleado
                              LEFT JOIN param.tpm_institucion INSTIT	ON INSTIT.id_institucion = sal.id_institucion
                              LEFT JOIN param.tpm_contratista CONTRA	ON CONTRA.id_contratista = sal.id_contratista
						WHERE ';
                        
            g_consulta := g_consulta || pm_criterio_filtro;

            -- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;
            
            raise notice '--> %',g_consulta;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;      
        
      
    ELSIF pm_codigo_procedimiento  = 'AL_PMSIMD_SEL' THEN -- PMSIMD: Pedido Materiales Simplificado detalle Reporte
        --Para reporte de Pedido de Materiales   Simplificado detalle
        BEGIN
            g_consulta := 'SELECT

							ITEM.nombre, 
							SALDET.cant_entregada,
							UNMEDB.abreviatura as unidad_medida,
							ITEM.calidad, 
							ITEM.descripcion, 
                            ITEM.descripcion_aux,
                            SALDET.cant_solicitada,
						
							ITEM.peso_kg * SALDET.cant_solicitada as peso_neto


						FROM almin.tal_salida_detalle SALDET
							INNER JOIN almin.tal_salida SALIDA
							ON SALIDA.id_salida = SALDET.id_salida
							INNER JOIN almin.tal_item ITEM
							ON ITEM.id_item=SALDET.id_item
							INNER JOIN almin.tal_almacen_logico ALMLOG
							ON ALMLOG.id_almacen_logico = SALIDA.id_almacen_logico
							INNER JOIN almin.tal_almacen_ep ALMAEP
							ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
							INNER JOIN almin.tal_almacen ALMACE
							ON ALMACE.id_almacen = ALMAEP.id_almacen
							INNER JOIN param.tpm_unidad_medida_base UNMEDB
							ON UNMEDB.id_unidad_medida_base = ITEM.id_unidad_medida_base
        					INNER JOIN almin.tal_supergrupo SUPGRU
        					ON SUPGRU.id_supergrupo = ITEM.id_supergrupo
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
        
      
        
    ELSIF pm_codigo_procedimiento  = 'AL_DIASAL_SEL' THEN -- DIArio SALida (de todos los almacenes)
        --Reporte Diario de salidas
        BEGIN
            g_consulta := 'SELECT
                           SALIDA.correlativo_sal, SUM(SALDET.costo) as  importe,
                           TRAMO.descripcion,
                           CASE COALESCE(SALIDA.id_institucion,0)
                               WHEN 0 THEN CASE COALESCE(SALIDA.id_contratista,0)
                                               WHEN 0 THEN (SELECT COALESCE(apellido_paterno,'''')||'' ''||COALESCE(apellido_materno,'''')||'' ''||COALESCE(nombre,'''') FROM sss.tsg_persona WHERE id_persona = EMPLEA.id_persona)
                                               ELSE (SELECT COALESCE(nombre,'''') FROM param.tpm_institucion WHERE id_institucion = CONTRA.id_institucion)
                                           END
                               ELSE INSTIT.nombre
                           END as solicitante,
                           (SELECT COALESCE(P.nombre,'''') || '' '' || COALESCE(P.apellido_paterno,'''') || '' '' || COALESCE(P.apellido_materno,'''')
                           FROM kard.tkp_empleado E
                           INNER JOIN sss.tsg_persona P
                           ON P.id_persona = E.id_persona
                           WHERE E.id_empleado = RESALM.id_empleado) as almacenero,
                           (SELECT COALESCE(P.nombre,'''') || '' '' || COALESCE(P.apellido_paterno,'''') || '' '' || COALESCE(P.apellido_materno,'''')
                           FROM kard.tkp_empleado E
                           INNER JOIN sss.tsg_persona P
                           ON P.id_persona = E.id_persona
                           WHERE E.id_empleado = RESALM1.id_empleado) as jefe_almacen,
                           SUPGRU.nombre as supergrupo,
                           TRAMO.descripcion as tramo,
                           ''Todos''::varchar as almacen
                           FROM almin.tal_salida_detalle SALDET
                           INNER JOIN almin.tal_salida SALIDA
                           ON SALIDA.id_salida = SALDET.id_salida
                           INNER JOIN almin.tal_item ITEM
                           ON ITEM.id_item = SALDET.id_item
                           LEFT JOIN almin.tal_tramo_subactividad TRASUB
                           ON TRASUB.id_tramo_subactividad = SALIDA.id_tramo_subactividad
                           LEFT JOIN almin.tal_tramo TRAMO
                           ON TRAMO.id_tramo = TRASUB.id_tramo
                           LEFT JOIN param.tpm_contratista CONTRA
                           ON CONTRA.id_contratista = SALIDA.id_contratista
                           LEFT JOIN param.tpm_institucion INSTIT
                           ON INSTIT.id_institucion = SALIDA.id_institucion
                           LEFT JOIN kard.tkp_empleado EMPLEA
                           ON EMPLEA.id_empleado = SALIDA.id_empleado
                           INNER JOIN almin.tal_responsable_almacen RESALM
                           ON RESALM.id_responsable_almacen = SALIDA.id_responsable_almacen
                           INNER JOIN almin.tal_responsable_almacen RESALM1
                           ON RESALM1.id_responsable_almacen = SALIDA.id_jefe_almacen
                           INNER JOIN almin.tal_supergrupo SUPGRU
                           ON SUPGRU.id_supergrupo = ITEM.id_supergrupo
						   WHERE ';

            g_consulta := g_consulta || pm_criterio_filtro;
            
            g_consulta = g_consulta || ' GROUP BY SALIDA.correlativo_sal,TRAMO.descripcion,SALIDA.id_institucion,
                                         SALIDA.id_contratista,EMPLEA.id_persona,CONTRA.id_institucion,
                                         INSTIT.nombre,RESALM.id_empleado,RESALM1.id_empleado, SUPGRU.nombre';

            -- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;
        
    ELSIF pm_codigo_procedimiento  = 'AL_DIASAL_ALM' THEN -- DIArio SALida ALMacen (por almacén)
        --Reporte Diario de salidas
        BEGIN
            g_consulta := 'SELECT
                           SALIDA.correlativo_sal, SUM(SALDET.costo) as  importe,
                           TRAMO.descripcion,
                           CASE COALESCE(SALIDA.id_institucion,0)
                               WHEN 0 THEN CASE COALESCE(SALIDA.id_contratista,0)
                                               WHEN 0 THEN (SELECT COALESCE(apellido_paterno,'''')||'' ''||COALESCE(apellido_materno,'''')||'' ''||COALESCE(nombre,'''') FROM sss.tsg_persona WHERE id_persona = EMPLEA.id_persona)
                                               ELSE (SELECT COALESCE(nombre,'''') FROM param.tpm_institucion WHERE id_institucion = CONTRA.id_institucion)
                                           END
                               ELSE INSTIT.nombre
                           END as solicitante,
                           (SELECT COALESCE(P.nombre,'''') || '' '' || COALESCE(P.apellido_paterno,'''') || '' '' || COALESCE(P.apellido_materno,'''')
                           FROM kard.tkp_empleado E
                           INNER JOIN sss.tsg_persona P
                           ON P.id_persona = E.id_persona
                           WHERE E.id_empleado = RESALM.id_empleado) as almacenero,
                           (SELECT COALESCE(P.nombre,'''') || '' '' || COALESCE(P.apellido_paterno,'''') || '' '' || COALESCE(P.apellido_materno,'''')
                           FROM kard.tkp_empleado E
                           INNER JOIN sss.tsg_persona P
                           ON P.id_persona = E.id_persona
                           WHERE E.id_empleado = RESALM1.id_empleado) as jefe_almacen,
                           SUPGRU.nombre as supergrupo,
                           TRAMO.descripcion as tramo,
                           ALMACE.nombre as almacen
                           FROM almin.tal_salida_detalle SALDET
                           INNER JOIN almin.tal_salida SALIDA
                           ON SALIDA.id_salida = SALDET.id_salida
                           INNER JOIN almin.tal_item ITEM
                           ON ITEM.id_item = SALDET.id_item
                           LEFT JOIN almin.tal_tramo_subactividad TRASUB
                           ON TRASUB.id_tramo_subactividad = SALIDA.id_tramo_subactividad
                           LEFT JOIN almin.tal_tramo TRAMO
                           ON TRAMO.id_tramo = TRASUB.id_tramo
                           INNER JOIN almin.tal_almacen_logico ALMLOG
                           ON ALMLOG.id_almacen_logico = SALIDA.id_almacen_logico
                           INNER JOIN almin.tal_almacen_ep ALMAEP
                           ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
                           INNER JOIN almin.tal_almacen ALMACE
                           ON ALMACE.id_almacen = ALMAEP.id_almacen
                           LEFT JOIN param.tpm_contratista CONTRA
                           ON CONTRA.id_contratista = SALIDA.id_contratista
                           LEFT JOIN param.tpm_institucion INSTIT
                           ON INSTIT.id_institucion = SALIDA.id_institucion
                           LEFT JOIN kard.tkp_empleado EMPLEA
                           ON EMPLEA.id_empleado = SALIDA.id_empleado
                           INNER JOIN almin.tal_responsable_almacen RESALM
                           ON RESALM.id_responsable_almacen = SALIDA.id_responsable_almacen
                           INNER JOIN almin.tal_responsable_almacen RESALM1
                           ON RESALM1.id_responsable_almacen = SALIDA.id_jefe_almacen
                           INNER JOIN almin.tal_supergrupo SUPGRU
                           ON SUPGRU.id_supergrupo = ITEM.id_supergrupo
						   WHERE ';

            g_consulta := g_consulta || pm_criterio_filtro;

            g_consulta = g_consulta || ' GROUP BY SALIDA.correlativo_sal,TRAMO.descripcion,SALIDA.id_institucion,
                                         SALIDA.id_contratista,EMPLEA.id_persona,CONTRA.id_institucion,
                                         INSTIT.nombre,RESALM.id_empleado,RESALM1.id_empleado, SUPGRU.nombre, ALMACE.id_almacen';

            -- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;
        
    ELSIF pm_codigo_procedimiento  = 'AL_PEDDET_SEL' THEN -- PEDido DETalle (material suelto)
        --Detalle de pedido de materiales  de Unidades COnstructivas
        BEGIN
            g_consulta := 'SELECT
                          ALMACE.nombre as desc_almacen,
                          ITEM.codigo, ITEM.nombre, ITEM.descripcion,
                          SALDET.cant_entregada,
                          CASE COALESCE(SALIDA.id_institucion,0)
                              WHEN 0 THEN CASE COALESCE(SALIDA.id_contratista,0)
                                              WHEN 0 THEN (SELECT COALESCE(apellido_paterno,'''')||'' ''||COALESCE(apellido_materno,'''')||'' ''||COALESCE(nombre,'''') FROM sss.tsg_persona WHERE id_persona = EMPLEA.id_persona)
                                              ELSE (SELECT COALESCE(nombre,'''') FROM param.tpm_institucion WHERE id_institucion = CONTRA.id_institucion)
                                          END
                              ELSE INSTIT.nombre
                           END as solicitante,
                           ITEM.calidad, ITEM.peso_kg, UNMEDB.abreviatura as unidad_medida,
                           SALDET.cant_entregada * ITEM.peso_kg as peso_total
                           FROM almin.tal_salida SALIDA
                           INNER JOIN almin.tal_salida_detalle SALDET
                           ON SALDET.id_salida = SALDET.id_salida
                           INNER JOIN almin.tal_almacen_logico ALMLOG
                           ON ALMLOG.id_almacen_logico = SALIDA.id_almacen_logico
                           INNER JOIN almin.tal_almacen_ep ALMAEP
                           ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
                           INNER JOIN almin.tal_almacen ALMACE
                           ON ALMACE.id_almacen = ALMAEP.id_almacen
                           INNER JOIN almin.tal_item ITEM
                           ON ITEM.id_item = SALDET.id_item
                           LEFT JOIN param.tpm_contratista CONTRA
                           ON CONTRA.id_contratista = SALIDA.id_contratista
                           LEFT JOIN param.tpm_institucion INSTIT
                           ON INSTIT.id_institucion = SALIDA.id_institucion
                           LEFT JOIN kard.tkp_empleado EMPLEA
                           ON EMPLEA.id_empleado = SALIDA.id_empleado
                           INNER JOIN param.tpm_unidad_medida_base UNMEDB
                           ON UNMEDB.id_unidad_medida_base = ITEM.id_unidad_medida_base
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
    ELSIF pm_codigo_procedimiento  = 'AL_PEDFIN_SEL' THEN
        BEGIN
            g_consulta := 'SELECT
                           SALIDA.id_salida       ,''S - '' || SALIDA.correlativo_sal as correlativo_sal,
                           SALIDA.correlativo_vale,
                           SALIDA.descripcion     ,SALIDA.contabilizar                ,SALIDA.contabilizado,SALIDA.estado_salida,
                           SALIDA.estado_registro ,SALIDA.motivo_cancelacion          ,SALIDA.id_responsable_almacen,
                           RESALM.cargo as desc_responsable_almacen                   ,SALIDA.id_almacen_logico,
                           ALMLOG.nombre as desc_almacen_logico                       ,SALIDA.id_empleado,
                           (COALESCE(PERSON.nombre,'' '')||'' ''||COALESCE(PERSON.apellido_paterno,'' '')||'' ''|| COALESCE(PERSON.apellido_materno,'' '')) as desc_empleado,
                           SALIDA.id_firma_autorizada,
                           (COALESCE(PERSON2.nombre,'' '')||'' ''||COALESCE(PERSON2.apellido_paterno,'' '')||'' ''|| COALESCE(PERSON2.apellido_materno,'' '')) as desc_firma_autorizada,
                           SALIDA.id_contratista,
                           (SELECT nombre FROM param.tpm_institucion where id_institucion = CONTRA.id_institucion) as desc_contratista,
                           SALIDA.id_tipo_material,
                           TIPMAT.nombre as desc_tipo_material                         ,SALIDA.id_institucion,
                           INSTIT.nombre as desc_institucion                           ,SALIDA.id_subactividad,SUBACT.descripcion as desc_subactividad,
                           SALIDA.id_motivo_salida_cuenta                              ,MOSACU.descripcion as desc_motivo_salida_cuenta,
                           (SELECT CUENTA.nro_cuenta FROM sci.tct_cuenta CUENTA WHERE CUENTA.id_cuenta = MOSACU.id_cuenta) as nro_cuenta,
                           MOTSAL.nombre as desc_motivo_salida                        ,ALMACE.nombre as desc_almacen,
                           FINANC.nombre_financiador,
                           REGION.nombre_regional                  ,PROGRA.nombre_programa                ,PROYEC.nombre_proyecto,
                           ACTIVI.nombre_actividad                 ,FINANC.id_financiador                 ,REGION.id_regional,
                           PROGRA.id_programa                      ,PROYEC.id_proyecto                    ,ACTIVI.id_actividad,
                           FINANC.codigo_financiador               ,REGION.codigo_regional                ,PROGRA.codigo_programa,
                           PROYEC.codigo_proyecto                  ,ACTIVI.codigo_actividad               ,SALIDA.emergencia,
                           SALIDA.observaciones                    ,SALIDA.tipo_pedido                    ,SALIDA.receptor,
                           SALIDA.id_tramo_subactividad            ,SALIDA.id_tramo_unidad_constructiva   ,TRAMO.descripcion as desc_tramo,
                           UNICON.codigo as desc_unidad_cons	   ,SALIDA.fecha_borrador,
                           SALIDA.id_supervisor					   ,SALIDA.receptor_ci					  ,SALIDA.solicitante,
                           SALIDA.solicitante_ci				   ,SALIDA.num_contrato,
                           COALESCE(PERSON3.apellido_paterno,'''') || '' '' || COALESCE(PERSON3.apellido_materno,'''') || '' '' || COALESCE(PERSON3.nombre,'''') as nombre_superv,
                           PARALM.gestion,
                           SALIDA.sw_faltante_tuc
                           FROM almin.tal_salida SALIDA
                           LEFT JOIN almin.tal_responsable_almacen RESALM
                           ON RESALM.id_responsable_almacen=SALIDA.id_responsable_almacen
                           INNER JOIN almin.tal_almacen_logico ALMLOG
                           ON ALMLOG.id_almacen_logico=SALIDA.id_almacen_logico
                           LEFT JOIN kard.tkp_empleado EMPLEA
                           ON EMPLEA.id_empleado=SALIDA.id_empleado
                           LEFT JOIN sss.tsg_persona PERSON
                           ON PERSON.id_persona=EMPLEA.id_persona
                           LEFT JOIN almin.tal_firma_autorizada FIRAUT
                           ON FIRAUT.id_firma_autorizada=SALIDA.id_firma_autorizada
                           LEFT JOIN kard.tkp_empleado_tpm_frppa EFRPPA
                           ON EFRPPA.id_empleado_frppa=FIRAUT.id_empleado_frppa
                           LEFT JOIN kard.tkp_empleado EMPLEA2
                           ON EMPLEA2.id_empleado=EFRPPA.id_empleado
                           LEFT JOIN sss.tsg_persona PERSON2
                           ON PERSON2.id_persona=EMPLEA2.id_persona
                           LEFT JOIN param.tpm_contratista CONTRA
                           ON CONTRA.id_contratista=SALIDA.id_contratista
                           INNER JOIN almin.tal_tipo_material TIPMAT
                           ON TIPMAT.id_tipo_material=SALIDA.id_tipo_material
                           LEFT JOIN param.tpm_institucion INSTIT
                           ON INSTIT.id_institucion=SALIDA.id_institucion
                           LEFT JOIN param.tpm_subactividad SUBACT
                           ON SUBACT.id_subactividad=SALIDA.id_subactividad
                           INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			   ON MOSACU.id_motivo_salida_cuenta=SALIDA.id_motivo_salida_cuenta
            			   INNER JOIN almin.tal_almacen_ep ALMAEP
            			   ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
            			   INNER JOIN almin.tal_almacen ALMACE
            			   ON ALMACE.id_almacen = ALMAEP.id_almacen
            			   INNER JOIN almin.tal_motivo_salida MOTSAL
            			   ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
            			   INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                           ON FRPPA.id_fina_regi_prog_proy_acti = MOSACU.id_fina_regi_prog_proy_acti
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
                           LEFT JOIN almin.tal_tramo_subactividad TRASUB
                           ON TRASUB.id_tramo_subactividad = SALIDA.id_tramo_subactividad
                           LEFT JOIN almin.tal_tramo TRAMO
                           ON TRAMO.id_tramo = TRASUB.id_tramo
                           LEFT JOIN almin.tal_tramo_unidad_constructiva TRAUNI
                           ON TRAUNI.id_tramo_unidad_constructiva = SALIDA.id_tramo_unidad_constructiva
                           LEFT JOIN almin.tal_unidad_constructiva UNICON
                           ON UNICON.id_unidad_constructiva = TRAUNI.id_unidad_constructiva
                           LEFT JOIN almin.tal_supervisor SUPERV
                           ON SUPERV.id_supervisor = SALIDA.id_supervisor
                           LEFT JOIN sss.tsg_persona PERSON3
                           ON PERSON3.id_persona = SUPERV.id_persona
                           INNER JOIN almin.tal_parametro_almacen PARALM
                           ON PARALM.id_parametro_almacen = SALIDA.id_parametro_almacen
                           LEFT JOIN param.tpm_institucion INSTIT1
                           ON INSTIT1.id_institucion=CONTRA.id_institucion
                           WHERE SALIDA.estado_salida = ''Finalizado'' AND ';
            g_consulta := g_consulta || pm_criterio_filtro;
          --  para que los usuarios  solo puedan ver los pedidos realizados por ellos
            IF NOT g_rol_adm  THEN
                g_consulta := g_consulta || ' SALIDA.id_usuario=' || pm_id_usuario ||'  AND ';
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
        
    ELSIF pm_codigo_procedimiento  = 'AL_PEDFIN_COUNT' THEN
        BEGIN
            g_consulta := 'SELECT
                           COUNT(SALIDA.id_salida) AS total
                           FROM almin.tal_salida SALIDA
                           LEFT JOIN almin.tal_responsable_almacen RESALM
                           ON RESALM.id_responsable_almacen=SALIDA.id_responsable_almacen
                           INNER JOIN almin.tal_almacen_logico ALMLOG
                           ON ALMLOG.id_almacen_logico=SALIDA.id_almacen_logico
                           LEFT JOIN kard.tkp_empleado EMPLEA
                           ON EMPLEA.id_empleado=SALIDA.id_empleado
                           LEFT JOIN sss.tsg_persona PERSON
                           ON PERSON.id_persona=EMPLEA.id_persona
                           LEFT JOIN almin.tal_firma_autorizada FIRAUT
                           ON FIRAUT.id_firma_autorizada=SALIDA.id_firma_autorizada
                           LEFT JOIN kard.tkp_empleado_tpm_frppa EFRPPA
                           ON EFRPPA.id_empleado_frppa=FIRAUT.id_empleado_frppa
                           LEFT JOIN kard.tkp_empleado EMPLEA2
                           ON EMPLEA2.id_empleado=EFRPPA.id_empleado
                           LEFT JOIN sss.tsg_persona PERSON2
                           ON PERSON2.id_persona=EMPLEA2.id_persona
                           LEFT JOIN param.tpm_contratista CONTRA
                           ON CONTRA.id_contratista=SALIDA.id_contratista
                           INNER JOIN almin.tal_tipo_material TIPMAT
                           ON TIPMAT.id_tipo_material=SALIDA.id_tipo_material
                           LEFT JOIN param.tpm_institucion INSTIT
                           ON INSTIT.id_institucion=SALIDA.id_institucion
                           LEFT JOIN param.tpm_subactividad SUBACT
                           ON SUBACT.id_subactividad=SALIDA.id_subactividad
                           INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            			   ON MOSACU.id_motivo_salida_cuenta=SALIDA.id_motivo_salida_cuenta
            			   INNER JOIN almin.tal_almacen_ep ALMAEP
            			   ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
            			   INNER JOIN almin.tal_almacen ALMACE
            			   ON ALMACE.id_almacen = ALMAEP.id_almacen
            			   INNER JOIN almin.tal_motivo_salida MOTSAL
            			   ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
            			   INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                           ON FRPPA.id_fina_regi_prog_proy_acti = MOSACU.id_fina_regi_prog_proy_acti
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
                           LEFT JOIN almin.tal_tramo_subactividad TRASUB
                           ON TRASUB.id_tramo_subactividad = SALIDA.id_tramo_subactividad
                           LEFT JOIN almin.tal_tramo TRAMO
                           ON TRAMO.id_tramo = TRASUB.id_tramo
                           LEFT JOIN almin.tal_tramo_unidad_constructiva TRAUNI
                           ON TRAUNI.id_tramo_unidad_constructiva = SALIDA.id_tramo_unidad_constructiva
                           LEFT JOIN almin.tal_unidad_constructiva UNICON
                           ON UNICON.id_unidad_constructiva = TRAUNI.id_unidad_constructiva
                           LEFT JOIN almin.tal_supervisor SUPERV
                           ON SUPERV.id_supervisor = SALIDA.id_supervisor
                           LEFT JOIN sss.tsg_persona PERSON3
                           ON PERSON3.id_persona = SUPERV.id_persona
                           INNER JOIN almin.tal_parametro_almacen PARALM
                           ON PARALM.id_parametro_almacen = SALIDA.id_parametro_almacen
                           LEFT JOIN param.tpm_institucion INSTIT1
                           ON INSTIT1.id_institucion=CONTRA.id_institucion
                           WHERE SALIDA.estado_salida = ''Finalizado'' AND ';
            g_consulta := g_consulta || pm_criterio_filtro;
          --  para que los usuarios  solo puedan ver los pedidos realizados por ellos
            IF NOT g_rol_adm  THEN
                g_consulta := g_consulta || ' SALIDA.id_usuario=' || pm_id_usuario ||'  AND ';
            END IF;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;
        
        
    ELSIF pm_codigo_procedimiento  = 'AL_FALPTUC_REP' THEN  --Reporte de faltante de materiales
        --Para reporte de Pedido de Materiales   de Unidades Constructivas
        BEGIN
           
            g_consulta := 'Select  TIPOUC1.descripcion as desc_padre,
                                   TIPOUC.descripcion as desc_uc,
                                   COALESCE(ITEM.nombre,''s/n'')::varchar as item,
                                   COALESCE(ITEM.descripcion,''s/n'')::varchar as desc_item,
                                   (PEDINT.cantidad_solicitada + PEDINT.demasia) as cantidad_solicitada,
                                   PEDINT.nuevo + PEDINT.usado as cant_disp,
                                   PEDINT.cantidad_solicitada - PEDINT.nuevo - PEDINT.usado as cant_faltante,
                                   ALMACE.nombre,
                                   SALIDA.fecha_reg,
                                   SALIDA.descripcion as desc_salida,
                                   CASE COALESCE(SALIDA.id_institucion, 0)
                                     WHEN 0 THEN CASE COALESCE(SALIDA.id_contratista, 0)
                                                   WHEN 0 THEN (
                                                                 SELECT COALESCE(apellido_paterno, '''') ||
                                                                   '' '' || COALESCE(apellido_materno, '''') ||
                                                                   COALESCE(nombre, '''')
                                                                 FROM sss.tsg_persona
                                                                 WHERE id_persona = EMPLEA.id_persona
                                   )
                                                   ELSE 
                                   (
                                     SELECT COALESCE(nombre, '''')
                                     FROM param.tpm_institucion
                                     WHERE id_institucion = CONTRA.id_institucion
                                   )
                                                 END
                                     ELSE INSTIT.nombre
                                   END as solicitante
                            From almin.tal_pedido_tuc_int PEDINT
                                 INNER JOIN almin.tal_tipo_unidad_constructiva TIPOUC ON
                                   TIPOUC.id_tipo_unidad_constructiva = PEDINT.id_tipo_unidad_constructiva
                                 INNER JOIN almin.tal_salida SALIDA ON SALIDA.id_salida = PEDINT.id_salida
                                 INNER JOIN almin.tal_item ITEM ON ITEM.id_item = PEDINT.id_item
                                 INNER JOIN almin.tal_almacen_logico ALMLOG ON ALMLOG.id_almacen_logico =
                                   SALIDA.id_almacen_logico
                                 INNER JOIN almin.tal_almacen_ep ALMAEP ON ALMAEP.id_almacen_ep =
                                   ALMLOG.id_almacen_ep
                                 INNER JOIN almin.tal_almacen ALMACE ON ALMACE.id_almacen =
                                   ALMAEP.id_almacen
                                 LEFT JOIN almin.tal_composicion_tuc COMTUC ON COMTUC.id_tuc_hijo =
                                   TIPOUC.id_tipo_unidad_constructiva
                                 LEFT JOIN almin.tal_tipo_unidad_constructiva TIPOUC1 ON
                                   TIPOUC1.id_tipo_unidad_constructiva = COMTUC.id_tipo_unidad_constructiva
                                 LEFT JOIN param.tpm_contratista CONTRA ON CONTRA.id_contratista =
                                   SALIDA.id_contratista
                                 LEFT JOIN param.tpm_institucion INSTIT ON INSTIT.id_institucion =
                                   SALIDA.id_institucion
                                 LEFT JOIN kard.tkp_empleado EMPLEA ON EMPLEA.id_empleado =
                                   SALIDA.id_empleado
              				 WHERE  ' ;
                        
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