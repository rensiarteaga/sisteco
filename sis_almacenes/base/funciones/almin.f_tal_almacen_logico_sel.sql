--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_tal_almacen_logico_sel (
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
 SCRIPT: 		almin.f_tal_almacen_logico
 DESCRIPCIÓN: 	Devuelve las consultas a la tabla almin.tal_almacen_logico
 AUTOR: 		(Generado Automaticamente)
 FECHA:			2007-10-25 18:52:58
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
    g_rol_adm                   boolean;    -- Identifica si el usuario tiene rol administrador

BEGIN

    ---*** INICIACIÓN DE VARIABLES
    g_privilegio_procedimiento := FALSE;
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion := 'almin.f_tal_almacen_logico_sel';
    
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
    IF pm_codigo_procedimiento  = 'AL_ALMLOG_SEL' THEN
        BEGIN
            g_consulta := 'SELECT 
                            ALMLOG.id_almacen_logico,
                            ALMLOG.codigo,
                            ALMLOG.bloqueado,
                            ALMLOG.nombre,
                            ALMLOG.descripcion,
                            ALMLOG.fecha_reg,
                            ALMLOG.obsevaciones,
                            ALMLOG.id_almacen_ep,
                            ALMAEP.descripcion as desc_almacen_ep,
                            ALMLOG.id_tipo_almacen,
                            TIPALM.nombre as desc_tipo_almacen,
                            ALMLOG.cerrado,
                            ALMLOG.id_unidad_organizacional,
                            UNIORG.nombre_unidad as desc_unidad_organizacional,
                            ALMLOG.costeo_obligatorio
                            
                            FROM almin.tal_almacen_logico ALMLOG
                              INNER JOIN almin.tal_almacen_ep ALMAEP
                            ON ALMAEP.id_almacen_ep=ALMLOG.id_almacen_ep
                            INNER JOIN almin.tal_tipo_almacen TIPALM
                            ON TIPALM.id_tipo_almacen=ALMLOG.id_tipo_almacen
                            LEFT JOIN kard.tkp_unidad_organizacional UNIORG
                            ON UNIORG.id_unidad_organizacional = ALMLOG.id_unidad_organizacional
                            
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
        
     ELSIF pm_codigo_procedimiento  = 'AL_ALMLOG_SELFISEP' THEN
     
        BEGIN
         --CONSULTA PARA DEVOLVER LOS ALMACENES LÓGICOS A PARTIR DE UN ALMACÉN FÍSICO Y EN FUNCION DE LA EP
        
            g_consulta := 'SELECT
                           ALMLOG.id_almacen_logico,
                           ALMLOG.codigo,
                           ALMLOG.bloqueado,
                           ALMLOG.nombre,
                           ALMLOG.descripcion,
                           ALMLOG.fecha_reg,
                           ALMLOG.obsevaciones,
                           ALMLOG.id_almacen_ep,
                           ALMACE.nombre as desc_almacen,
                           ALMLOG.id_tipo_almacen,
                           TIPALM.nombre as desc_tipo_almacen,
                           ALMLOG.cerrado,
                           ALMLOG.id_unidad_organizacional,
                           UNIORG.nombre_unidad as desc_unidad_organizacional
                           FROM almin.tal_almacen_logico ALMLOG
                           INNER JOIN almin.tal_almacen_ep ALMAEP
                           ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
                           INNER JOIN almin.tal_almacen ALMACE
                           ON ALMACE.id_almacen = ALMAEP.id_almacen
                           INNER JOIN almin.tal_tipo_almacen TIPALM
                           ON TIPALM.id_tipo_almacen=ALMLOG.id_tipo_almacen
                           LEFT JOIN kard.tkp_unidad_organizacional UNIORG
                           ON UNIORG.id_unidad_organizacional = ALMLOG.id_unidad_organizacional
                           WHERE ';
            
            -- SE AUMENTA EL CRITERIO DEL FILTRO
            g_consulta := g_consulta || pm_criterio_filtro;
            
            IF NOT g_rol_adm THEN
            
                -- SI EL USUARIO NO TIENE ROL ADMINISTRADOR SE AUMENTA LA RESTRICCIÓN DE LA ESTRUCTURA PROGRAMÁTICA
                g_consulta := g_consulta || ' AND ALMAEP.id_fina_regi_prog_proy_acti IN
                                                        (SELECT DISTINCT
                                                         ASIGFRPPA.id_fina_regi_prog_proy_acti
                                                         FROM sss.tsg_usuario_asignacion USRAS
                                                         INNER JOIN sss.tsg_asignacion_estructura_tpm_frppa ASIGFRPPA
                                                         ON ASIGFRPPA.id_asignacion_estructura = USRAS.id_asignacion_estructura
                                                         INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                                                         ON FRPPA.id_fina_regi_prog_proy_acti = ASIGFRPPA.id_fina_regi_prog_proy_acti';
                g_consulta := g_consulta ||' AND FRPPA.id_financiador LIKE '''|| pm_id_financiador ||'''';
                g_consulta := g_consulta ||' AND FRPPA.id_regional LIKE '''|| pm_id_regional ||'''';
                g_consulta := g_consulta ||' INNER JOIN param.tpm_programa_proyecto_actividad PPA';
                g_consulta := g_consulta ||' ON PPA.id_prog_proy_acti = FRPPA.id_prog_proy_acti';
                g_consulta := g_consulta ||' AND PPA.id_programa LIKE '''|| pm_id_programa ||'''';
                g_consulta := g_consulta ||' AND PPA.id_proyecto LIKE '''|| pm_id_proyecto ||'''';
                g_consulta := g_consulta ||' AND PPA.id_actividad LIKE '''|| pm_id_actividad ||'''';
                g_consulta := g_consulta ||' WHERE USRAS.id_usuario = ' || pm_id_usuario ||')'; --CIERRA EL PARÉNTESIS DE LA SUBCONSULTA DE ESTRUCTURAS RELACIONADAS AL USUARIO
                
            ELSE
            
                -- ES ADMINISTRADOR, SE INCLUYE LA EP SOLO PARA FILTRAR
                g_consulta := g_consulta || ' AND ALMAEP.id_fina_regi_prog_proy_acti IN
                                                       (SELECT
                                                        FRPPA.id_fina_regi_prog_proy_acti
                                                        FROM param.tpm_fina_regi_prog_proy_acti FRPPA
                                                        INNER JOIN param.tpm_programa_proyecto_actividad PPA
                                                        ON PPA.id_prog_proy_acti = FRPPA.id_prog_proy_acti';
                g_consulta := g_consulta ||' WHERE FRPPA.id_financiador LIKE '''|| pm_id_financiador ||'''';
                g_consulta := g_consulta ||' AND FRPPA.id_regional LIKE '''|| pm_id_regional ||'''';
                g_consulta := g_consulta ||' AND PPA.id_programa LIKE '''|| pm_id_programa ||'''';
                g_consulta := g_consulta ||' AND PPA.id_proyecto LIKE '''|| pm_id_proyecto ||'''';
                g_consulta := g_consulta ||' AND PPA.id_actividad LIKE '''|| pm_id_actividad ||'''';
                g_consulta := g_consulta ||')';
            
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
    ELSIF pm_codigo_procedimiento  = 'AL_ALMLOG_COUNT' THEN

        BEGIN
        --Cuenta todos los registros
            g_consulta :=     'SELECT
                              COUNT(ALMLOG.id_almacen_logico) AS total
                              FROM almin.tal_almacen_logico ALMLOG
                              INNER JOIN almin.tal_almacen_ep ALMAEP
                            ON ALMAEP.id_almacen_ep=ALMLOG.id_almacen_ep
                            INNER JOIN almin.tal_tipo_almacen TIPALM
                            ON TIPALM.id_tipo_almacen=ALMLOG.id_tipo_almacen
                            LEFT JOIN kard.tkp_unidad_organizacional UNIORG
                            ON UNIORG.id_unidad_organizacional = ALMLOG.id_unidad_organizacional
                            WHERE ';
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;
        
    ELSIF pm_codigo_procedimiento  = 'AL_ALMLOG_COUNTFISEP' THEN

        BEGIN
         --CONSULTA PARA CONTAR LOS ALMACENES LÓGICOS A PARTIR DE UN ALMACÉN FÍSICO Y EN FUNCION DE LA EP
        
            g_consulta := 'SELECT
                           COUNT(ALMLOG.id_almacen_logico) as total
                           FROM almin.tal_almacen_logico ALMLOG
                           INNER JOIN almin.tal_almacen_ep ALMAEP
                           ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
                           INNER JOIN almin.tal_almacen ALMACE
                           ON ALMACE.id_almacen = ALMAEP.id_almacen
                           INNER JOIN almin.tal_tipo_almacen TIPALM
                           ON TIPALM.id_tipo_almacen=ALMLOG.id_tipo_almacen
                           LEFT JOIN kard.tkp_unidad_organizacional UNIORG
                           ON UNIORG.id_unidad_organizacional = ALMLOG.id_unidad_organizacional
                           WHERE ';
            
            -- SE AUMENTA EL CRITERIO DEL FILTRO
            g_consulta := g_consulta || pm_criterio_filtro;
            
            IF NOT g_rol_adm THEN
            
                -- SI EL USUARIO NO TIENE ROL ADMINISTRADOR SE AUMENTA LA RESTRICCIÓN DE LA ESTRUCTURA PROGRAMÁTICA
                g_consulta := g_consulta || ' AND ALMAEP.id_fina_regi_prog_proy_acti IN
                                                        (SELECT DISTINCT
                                                         ASIGFRPPA.id_fina_regi_prog_proy_acti
                                                         FROM sss.tsg_usuario_asignacion USRAS
                                                         INNER JOIN sss.tsg_asignacion_estructura_tpm_frppa ASIGFRPPA
                                                         ON ASIGFRPPA.id_asignacion_estructura = USRAS.id_asignacion_estructura
                                                         INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                                                         ON FRPPA.id_fina_regi_prog_proy_acti = ASIGFRPPA.id_fina_regi_prog_proy_acti';
                g_consulta := g_consulta ||' AND FRPPA.id_financiador LIKE '''|| pm_id_financiador ||'''';
                g_consulta := g_consulta ||' AND FRPPA.id_regional LIKE '''|| pm_id_regional ||'''';
                g_consulta := g_consulta ||' INNER JOIN param.tpm_programa_proyecto_actividad PPA';
                g_consulta := g_consulta ||' ON PPA.id_prog_proy_acti = FRPPA.id_prog_proy_acti';
                g_consulta := g_consulta ||' AND PPA.id_programa LIKE '''|| pm_id_programa ||'''';
                g_consulta := g_consulta ||' AND PPA.id_proyecto LIKE '''|| pm_id_proyecto ||'''';
                g_consulta := g_consulta ||' AND PPA.id_actividad LIKE '''|| pm_id_actividad ||'''';
                g_consulta := g_consulta ||' WHERE USRAS.id_usuario = ' || pm_id_usuario ||')'; --CIERRA EL PARÉNTESIS DE LA SUBCONSULTA DE ESTRUCTURAS RELACIONADAS AL USUARIO
                
            ELSE
            
                -- ES ADMINISTRADOR, SE INCLUYE LA EP SOLO PARA FILTRAR
                g_consulta := g_consulta || ' AND ALMAEP.id_fina_regi_prog_proy_acti IN
                                                       (SELECT
                                                        FRPPA.id_fina_regi_prog_proy_acti
                                                        FROM param.tpm_fina_regi_prog_proy_acti FRPPA
                                                        INNER JOIN param.tpm_programa_proyecto_actividad PPA
                                                        ON PPA.id_prog_proy_acti = FRPPA.id_prog_proy_acti';
                g_consulta := g_consulta ||' WHERE FRPPA.id_financiador LIKE '''|| pm_id_financiador ||'''';
                g_consulta := g_consulta ||' AND FRPPA.id_regional LIKE '''|| pm_id_regional ||'''';
                g_consulta := g_consulta ||' AND PPA.id_programa LIKE '''|| pm_id_programa ||'''';
                g_consulta := g_consulta ||' AND PPA.id_proyecto LIKE '''|| pm_id_proyecto ||'''';
                g_consulta := g_consulta ||' AND PPA.id_actividad LIKE '''|| pm_id_actividad ||'''';
                g_consulta := g_consulta ||')';
            
            END IF;
                        
            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
            
        END;
      
   ELSIF pm_codigo_procedimiento  = 'AL_ALMLOG_SELFISEPM' THEN

        BEGIN
         --CONSULTA PARA DEVOLVER LOS ALMACENES LÓGICOS A PARTIR DE UN ALMACÉN FÍSICO Y EN FUNCION DE LA EP

            g_consulta := 'SELECT
                           ALMLOG.id_almacen_logico,
                           ALMLOG.codigo,
                           ALMLOG.bloqueado,
                           ALMLOG.nombre,
                           ALMLOG.descripcion,
                           ALMLOG.fecha_reg,
                           ALMLOG.obsevaciones,
                           ALMLOG.id_almacen_ep,
                           ALMACE.nombre as desc_almacen,
                           ALMLOG.id_tipo_almacen,
                           TIPALM.nombre as desc_tipo_almacen,
                           ALMLOG.cerrado,
                           ALMLOG.id_unidad_organizacional,
                           UNIORG.nombre_unidad as desc_unidad_organizacional
                           FROM almin.tal_almacen_logico ALMLOG
                           INNER JOIN almin.tal_almacen_ep ALMAEP
                           ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
                           INNER JOIN almin.tal_almacen ALMACE
                           ON ALMACE.id_almacen = ALMAEP.id_almacen
                           INNER JOIN almin.tal_tipo_almacen TIPALM
                           ON TIPALM.id_tipo_almacen=ALMLOG.id_tipo_almacen
                           LEFT JOIN kard.tkp_unidad_organizacional UNIORG
                           ON UNIORG.id_unidad_organizacional = ALMLOG.id_unidad_organizacional
                           --INNER JOIN almin.tal_almacen_sector ALMSEC ON ALMSEC.id_almacen= ALMACE.id_almacen
                           --INNER JOIN almin.tal_estante ESTANT ON ESTANT.id_almacen_sector= ALMSEC.id_almacen_sector
                           WHERE ';

            -- SE AUMENTA EL CRITERIO DEL FILTRO
            g_consulta := g_consulta || pm_criterio_filtro;

            IF NOT g_rol_adm THEN

                -- SI EL USUARIO NO TIENE ROL ADMINISTRADOR SE AUMENTA LA RESTRICCIÓN DE LA ESTRUCTURA PROGRAMÁTICA
                g_consulta := g_consulta || ' AND ALMAEP.id_fina_regi_prog_proy_acti IN
                                                        (SELECT DISTINCT
                                                         ASIGFRPPA.id_fina_regi_prog_proy_acti
                                                         FROM sss.tsg_usuario_asignacion USRAS
                                                         INNER JOIN sss.tsg_asignacion_estructura_tpm_frppa ASIGFRPPA
                                                         ON ASIGFRPPA.id_asignacion_estructura = USRAS.id_asignacion_estructura
                                                         INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                                                         ON FRPPA.id_fina_regi_prog_proy_acti = ASIGFRPPA.id_fina_regi_prog_proy_acti';
                g_consulta := g_consulta ||' AND FRPPA.id_financiador LIKE '''|| pm_id_financiador ||'''';
                g_consulta := g_consulta ||' AND FRPPA.id_regional LIKE '''|| pm_id_regional ||'''';
                g_consulta := g_consulta ||' INNER JOIN param.tpm_programa_proyecto_actividad PPA';
                g_consulta := g_consulta ||' ON PPA.id_prog_proy_acti = FRPPA.id_prog_proy_acti';
                g_consulta := g_consulta ||' AND PPA.id_programa LIKE '''|| pm_id_programa ||'''';
                g_consulta := g_consulta ||' AND PPA.id_proyecto LIKE '''|| pm_id_proyecto ||'''';
                g_consulta := g_consulta ||' AND PPA.id_actividad LIKE '''|| pm_id_actividad ||'''';
            --    g_consulta := g_consulta ||' WHERE USRAS.id_usuario = ' || pm_id_usuario ||')'; --CIERRA EL PARÉNTESIS DE LA SUBCONSULTA DE ESTRUCTURAS RELACIONADAS AL USUARIO

            ELSE

                -- ES ADMINISTRADOR, SE INCLUYE LA EP SOLO PARA FILTRAR
                g_consulta := g_consulta || ' AND ALMAEP.id_fina_regi_prog_proy_acti IN
                                                       (SELECT
                                                        FRPPA.id_fina_regi_prog_proy_acti
                                                        FROM param.tpm_fina_regi_prog_proy_acti FRPPA
                                                        INNER JOIN param.tpm_programa_proyecto_actividad PPA
                                                        ON PPA.id_prog_proy_acti = FRPPA.id_prog_proy_acti';
                g_consulta := g_consulta ||' WHERE FRPPA.id_financiador LIKE '''|| pm_id_financiador ||'''';
                g_consulta := g_consulta ||' AND FRPPA.id_regional LIKE '''|| pm_id_regional ||'''';
                g_consulta := g_consulta ||' AND PPA.id_programa LIKE '''|| pm_id_programa ||'''';
                g_consulta := g_consulta ||' AND PPA.id_proyecto LIKE '''|| pm_id_proyecto ||'''';
                g_consulta := g_consulta ||' AND PPA.id_actividad LIKE '''|| pm_id_actividad ||'''';
                g_consulta := g_consulta ||')';

            END IF;

            -- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;

            raise notice '>>> %',g_consulta;
            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';

        END;
        
     ELSIF pm_codigo_procedimiento  = 'AL_ALMLOG_COUNTFISEPM' THEN

        BEGIN
         --CONSULTA PARA CONTAR LOS ALMACENES LÓGICOS A PARTIR DE UN ALMACÉN FÍSICO Y EN FUNCION DE LA EP

            g_consulta := 'SELECT
                           COUNT(ALMLOG.id_almacen_logico) as total
                           FROM almin.tal_almacen_logico ALMLOG
                           INNER JOIN almin.tal_almacen_ep ALMAEP
                           ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
                           INNER JOIN almin.tal_almacen ALMACE
                           ON ALMACE.id_almacen = ALMAEP.id_almacen
                           INNER JOIN almin.tal_tipo_almacen TIPALM
                           ON TIPALM.id_tipo_almacen=ALMLOG.id_tipo_almacen
                           LEFT JOIN kard.tkp_unidad_organizacional UNIORG
                           ON UNIORG.id_unidad_organizacional = ALMLOG.id_unidad_organizacional
                              --INNER JOIN almin.tal_almacen_sector ALMSEC ON ALMSEC.id_almacen= ALMACE.id_almacen
                           --INNER JOIN almin.tal_estante ESTANT ON ESTANT.id_almacen_sector= ALMSEC.id_almacen_sector
                           WHERE ';

            -- SE AUMENTA EL CRITERIO DEL FILTRO
            g_consulta := g_consulta || pm_criterio_filtro;

            IF NOT g_rol_adm THEN

                -- SI EL USUARIO NO TIENE ROL ADMINISTRADOR SE AUMENTA LA RESTRICCIÓN DE LA ESTRUCTURA PROGRAMÁTICA
                g_consulta := g_consulta || ' AND ALMAEP.id_fina_regi_prog_proy_acti IN
                                                        (SELECT DISTINCT
                                                         ASIGFRPPA.id_fina_regi_prog_proy_acti
                                                         FROM sss.tsg_usuario_asignacion USRAS
                                                         INNER JOIN sss.tsg_asignacion_estructura_tpm_frppa ASIGFRPPA
                                                         ON ASIGFRPPA.id_asignacion_estructura = USRAS.id_asignacion_estructura
                                                         INNER JOIN param.tpm_fina_regi_prog_proy_acti FRPPA
                                                         ON FRPPA.id_fina_regi_prog_proy_acti = ASIGFRPPA.id_fina_regi_prog_proy_acti';
                g_consulta := g_consulta ||' AND FRPPA.id_financiador LIKE '''|| pm_id_financiador ||'''';
                g_consulta := g_consulta ||' AND FRPPA.id_regional LIKE '''|| pm_id_regional ||'''';
                g_consulta := g_consulta ||' INNER JOIN param.tpm_programa_proyecto_actividad PPA';
                g_consulta := g_consulta ||' ON PPA.id_prog_proy_acti = FRPPA.id_prog_proy_acti';
                g_consulta := g_consulta ||' AND PPA.id_programa LIKE '''|| pm_id_programa ||'''';
                g_consulta := g_consulta ||' AND PPA.id_proyecto LIKE '''|| pm_id_proyecto ||'''';
                g_consulta := g_consulta ||' AND PPA.id_actividad LIKE '''|| pm_id_actividad ||'''';
                g_consulta := g_consulta ||' WHERE USRAS.id_usuario = ' || pm_id_usuario ||')'; --CIERRA EL PARÉNTESIS DE LA SUBCONSULTA DE ESTRUCTURAS RELACIONADAS AL USUARIO

            ELSE

                -- ES ADMINISTRADOR, SE INCLUYE LA EP SOLO PARA FILTRAR
                g_consulta := g_consulta || ' AND ALMAEP.id_fina_regi_prog_proy_acti IN
                                                       (SELECT
                                                        FRPPA.id_fina_regi_prog_proy_acti
                                                        FROM param.tpm_fina_regi_prog_proy_acti FRPPA
                                                        INNER JOIN param.tpm_programa_proyecto_actividad PPA
                                                        ON PPA.id_prog_proy_acti = FRPPA.id_prog_proy_acti';
                g_consulta := g_consulta ||' WHERE FRPPA.id_financiador LIKE '''|| pm_id_financiador ||'''';
                g_consulta := g_consulta ||' AND FRPPA.id_regional LIKE '''|| pm_id_regional ||'''';
                g_consulta := g_consulta ||' AND PPA.id_programa LIKE '''|| pm_id_programa ||'''';
                g_consulta := g_consulta ||' AND PPA.id_proyecto LIKE '''|| pm_id_proyecto ||'''';
                g_consulta := g_consulta ||' AND PPA.id_actividad LIKE '''|| pm_id_actividad ||'''';
                g_consulta := g_consulta ||')';

            END IF;

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