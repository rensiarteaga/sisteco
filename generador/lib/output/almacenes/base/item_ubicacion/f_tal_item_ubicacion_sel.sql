
	CREATE OR REPLACE FUNCTION "public"."f_tal_item_ubicacion_sel" (
			pm_id_usuario integer,
			pm_ip_origen varchar,
			pm_mac_maquina macaddr,
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
			RETURNS SETOF "pg_catalog"."record" AS
			
			$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE FACTURACION (FACTUR)
***************************************************************************
 SCRIPT: 		f_tal_item_ubicacion
 DESCRIPCIÓN: 	Devuelve las consultas a la tabla tal_item_ubicacion
 AUTOR: 		(Generado Automaticamente)
 FECHA:			2007-10-11 16:18:23
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

-- DECLARACION DE VARIABLES PARTICULARES


-- DECLARACION DE VARIAbLES DE LA FUNCION (LOCALES)

DECLARE

    --PARAMETROS FIJOS
    g_id_subsistema            integer; -- ID SUBSISTEMA
    g_id_lugar                 integer; -- ID LUGAR
    g_numero_error             varchar; -- ALMACENA EL NUMERO DE ERROR
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

BEGIN

    ---*** INICIACIÓN DE VARIABLES
    g_privilegio_procedimiento := FALSE;
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion := 'f_tal_item_ubicacion_sel';
    
    

    ---*** OBTENCIÓN DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM tsg_metaproceso
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENCION DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT tsg_usuario_lugar.id_lugar
    INTO   g_id_lugar
    FROM   tsg_usuario_lugar
    WHERE  tsg_usuario_lugar.id_usuario = pm_id_usuario;


    ---*** VALIDACIÓN DE LLAMADA POR USUARIO O FUNCIÓN
    IF pm_proc_almacenado IS NOT NULL THEN
        IF NOT EXISTS(SELECT 1 FROM pg_proc WHERE proname = pm_proc_almacenado) THEN
            g_descripcion_log_error := 'Procedimiento ejecutor inexistente';
            g_nivel_error := '2';
            g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
            
            --REGISTRA EL LOG
            g_reg_evento:= f_tsg_registro_evento(pm_id_usuario            ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
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
       g_privilegio_procedimiento := f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;


    ---*** SI NO SE TIENE PERMISOS DE EJECUCIÓN SE RETORNA EL MENSAJE DE ERROR
    IF NOT g_privilegio_procedimiento THEN
        g_nivel_error := '3';
        g_descripcion_log_error := 'El usuario no tiene permisos de ejecución del procedimiento';
        g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                             pm_codigo_procedimiento   ,pm_proc_almacenado);
        --DEVUELVE MENSAJE DE ERROR
        RAISE EXCEPTION '%',g_descripcion_log_error;
    END IF; 

    
      -- Seleccion de operacion a realizar
    IF pm_codigo_procedimiento  = 'AL_ITEUBI_SEL' THEN
        BEGIN
            g_consulta := 'SELECT 
							ITEUBI.id_item_ubicacion,
							ITEUBI.nivel,
							ITEUBI.descripcion,
							ITEUBI.observaciones,
							ITEUBI.fecha_reg,
							ITEUBI.id_item,
							ITEM.codigo as desc_item,
							ITEUBI.id_estante,
							ESTANT.codigo as desc_estante

						  FROM tal_item_ubicacion ITEUBI
						  
	  		 INNER JOIN tal_item ITEM
             ON ITEM.id_item=ITEUBI.id_item

	  		 INNER JOIN tal_estante ESTANT
             ON ESTANT.id_estante=ITEUBI.id_estante

						  WHERE ';
            g_consulta := g_consulta || pm_criterio_filtro;
            
            
/*            -- SE AUMENTA LAS RESTRICCIONES DE LA ESTRUCTURA PROGRAMÁTICA
            g_consulta := g_consulta ||'id_fina_regi_prog_proy_acti IN '|| '';
            g_consulta := g_consulta ||' '|| '(SELECT DISTINCT
                                             USRFRPPA.id_fina_regi_prog_proy_acti
                                             FROM tsg_usuario_asignacion USRAS
                                             INNER JOIN tsg_usuario__pm_frppa USRFRPPA
                                             ON USRFRPPA.id_asignacion_estructura = USRAS.id_asignacion_estructura
                                             INNER JOIN tpm_fina_regi_prog_proy_acti FRPPA
                                             ON FRPPA.id_fina_regi_prog_proy_acti = USRFRPPA.id_fina_regi_prog_proy_acti';
            g_consulta := g_consulta ||' '|| 'AND FRPPA.id_financiador LIKE '''|| pm_id_financiador ||'''';
            g_consulta := g_consulta ||' '|| 'AND FRPPA.id_regional LIKE '''|| pm_id_regional ||'''';
            g_consulta := g_consulta ||' '|| 'INNER JOIN tpm_programa_proyecto_actividad PPA';
            g_consulta := g_consulta ||' '|| 'ON PPA.id_prog_proy_acti = FRPPA.id_prog_proy_acti';
            g_consulta := g_consulta ||' '|| 'AND PPA.id_programa LIKE '''|| pm_id_programa ||'''';
            g_consulta := g_consulta ||' '|| 'AND PPA.id_proyecto LIKE '''|| pm_id_proyecto ||'''';
            g_consulta := g_consulta ||' '|| 'AND PPA.id_actividad LIKE '''|| pm_id_actividad ||'''';
            g_consulta := g_consulta ||' '|| 'WHERE USRAS.id_usuario = ' || pm_id_usuario ||')';*/
            
            -- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;
            
            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;
                
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;
        
        
    -- PARA LA CONSULTA DE SELECCION     
    ELSIF pm_codigo_procedimiento  = 'AL_ITEUBI_COUNT' THEN

        BEGIN
        --Cuenta todos los registros
            g_consulta := 'SELECT
                          COUNT(ITEUBI.id_item_ubicacion) AS total
                          FROM tal_item_ubicacion ITEUBI
						  
	  		 INNER JOIN tal_item ITEM
             ON ITEM.id_item=ITEUBI.id_item

	  		 INNER JOIN tal_estante ESTANT
             ON ESTANT.id_estante=ITEUBI.id_estante

                          WHERE ';
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
        g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= f_tsg_registro_evento(pm_id_usuario            ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                            pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                            pm_codigo_procedimiento   ,pm_proc_almacenado);
        --DEVUELVE MENSAJE DE ERROR
        RAISE EXCEPTION '%', g_respuesta;
    END IF;


    ---*** REGISTRO EN EL LOG EL ÉXITO DE LA EJECUIÓN DEL PROCEDIMIENTO
    g_reg_evento:= f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);


    ---*** SE DEVUELVE EL CONJUNTO DE DATOS
    RETURN;


EXCEPTION

    WHEN others THEN BEGIN
    
        --SE OBTIENE EL MENSAJE Y EL NÚMERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
        g_mensaje_error:=SQLERRM;
        g_numero_error:=SQLSTATE;
        g_reg_error:= f_tsg_registro_evento (pm_id_usuario            ,g_id_subsistema          ,g_id_lugar         ,g_mensaje_error,
                                             pm_ip_origen             ,pm_mac_maquina           ,'error'            ,g_numero_error,
                                             pm_codigo_procedimiento  ,pm_proc_almacenado);

        --SE DEVUELVE EL MENSAJE DE ERROR
        g_nivel_error := '1';
        g_descripcion_log_error := g_numero_error || ' - ' || g_mensaje_error;
        g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        RAISE EXCEPTION '%', 'f' || g_separador || g_respuesta;

    END;

END;
$body$
LANGUAGE 'plpgsql' VOLATILE CALLED ON NULL INPUT SECURITY INVOKER;