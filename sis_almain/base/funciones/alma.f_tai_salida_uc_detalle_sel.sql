--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_tai_salida_uc_detalle_sel (
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
 SISTEMA ENDESIS - SISTEMA ALMACENES (ALMA)
***************************************************************************
 SCRIPT: 		 alma.f_tai_salida_uc_detalle
 DESCRIPCION: 	 Devuelve las consultas a la tabla alma.tai_fase
 AUTOR: 		 UNKNOW
 FECHA:			 26-12-2014
***************************************************************************/

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
    g_respuesta                varchar; -- VARIABLE QUE CONTENDR√?¬Å LOS MENSAJES DE ERROR
    g_consulta                 text;    -- VARIABLE QUE CONTENDR√?¬Å LA CONSULTA DIN√?¬ÅMICA PARA EL FILTRO
    g_nivel_error              varchar; -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                        --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                        --      ERROR L√??GICO (CR√?¬çTICO) = 2
                                        --      ERROR L√??GICO (INTERMEDIO) = 3
                                        --      ERROR L√??GICO (ADVERTENCIA) = 4
    g_nombre_funcion           varchar; --NOMBRE F√?¬çSICO DE LA FUNCI√??N
    g_separador                varchar(10); --Caracteres que serviran para separar el mensaje, nivel y origen del error
   
	
BEGIN

    ---*** INICIACI√??N DE VARIABLES
    g_privilegio_procedimiento := FALSE;
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funci√?¬≥n
    g_nombre_funcion := 'f_tai_salida_uc_detalle';


    ---*** OBTENCI√??N DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENCION DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT sss.tsg_usuario_lugar.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar
    WHERE  sss.tsg_usuario_lugar.id_usuario = pm_id_usuario;


    ---*** VALIDACI√??N DE LLAMADA POR USUARIO O FUNCI√??N
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


    ---*** VERIFICACI√??N DE PERMISOS DEL USUARIO
    IF NOT g_privilegio_procedimiento THEN
       g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;


    ---*** SI NO SE TIENE PERMISOS DE EJECUCI√??N SE RETORNA EL MENSAJE DE ERROR
    IF NOT g_privilegio_procedimiento THEN
        g_nivel_error := '3';
        g_descripcion_log_error := 'El usuario no tiene permisos de ejecucion del procedimiento';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                             pm_codigo_procedimiento   ,pm_proc_almacenado);
        --DEVUELVE MENSAJE DE ERROR
        RAISE EXCEPTION '%',g_descripcion_log_error;
    END IF;


    -- Seleccion de operacion a realizar
    IF pm_codigo_procedimiento  = 'AL_SALUCDET_SEL' THEN
        BEGIN
            g_consulta := '	  SELECT  sucd.id_salida_uc_detalle,sucd.id_salida_uc,sucd.cantidad
                                      ,sucd.id_unidad_constructiva,uc.codigo||'' - ''||uc.nombre as desc_uc
                                      ,COALESCE(to_char(sucd.fecha_reg,''dd-mm-yyyy''),''0'') AS fecha_reg
                                      ,sucd.usuario_reg
                              FROM alma.tai_salida_uc_detalle sucd
                              INNER JOIN alma.tai_salida_uc suc on suc.id_salida_uc = sucd.id_salida_uc 
                              INNER JOIN alma.tai_unidad_constructiva uc on uc.id_unidad_constructiva = sucd.id_unidad_constructiva AND uc.estado=''activo''
                              WHERE  ';
                            
            g_consulta := g_consulta || pm_criterio_filtro;

            -- SE AUMENTA EL ORDEN Y LOS PARAMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol || ' ' ||pm_sortdir;
            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;
            
            FOR g_registros in EXECUTE(g_consulta) LOOP            
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;

    ELSIF pm_codigo_procedimiento  = 'AL_SALUCDET_COUNT' THEN

        BEGIN
        --Cuenta todos los registros de tasa_categoria sin condiciones
            g_consulta := '	SELECT COUNT(sucd.id_salida_uc_detalle) as total
            				FROM alma.tai_salida_uc_detalle sucd
                            INNER JOIN alma.tai_salida_uc suc on suc.id_salida_uc = sucd.id_salida_uc 
                            INNER JOIN alma.tai_unidad_constructiva uc on uc.id_unidad_constructiva = sucd.id_unidad_constructiva AND uc.estado=''activo''
                            WHERE  ';  
                            
            g_consulta := g_consulta || pm_criterio_filtro;
            
            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCI√??N DE √??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;
    ELSIF pm_codigo_procedimiento = 'AL_SALUCDETITEM_COUNT'
    THEN
    	BEGIN
        	g_consulta := 'SELECT count(sal_it.id_salida_uc_detalle_item)AS total
                            FROM alma.tai_salida_uc_detalle_item sal_it
                            INNER JOIN alma.tai_salida_uc_detalle sal_det on sal_det.id_salida_uc_detalle=sal_it.id_salida_uc_detalle
                            INNER JOIN alma.tai_item it on it.id_item=sal_it.id_item and it.estado=''activo''
                            WHERE  ';
            g_consulta := g_consulta || pm_criterio_filtro;
            
            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCI√??N DE √??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;
     ELSIF pm_codigo_procedimiento = 'AL_SALUCDETITEM_SEL'
     THEN
    	BEGIN
        	g_consulta := 'SELECT 	sal_it.usuario_reg,COALESCE(to_char(sal_it.fecha_reg,''dd-mm-yyyy''),''0'') AS fecha_reg,
                                   sal_it.id_salida_uc_detalle_item,sal_it.id_salida_uc_detalle
                                   ,sal_it.cantidad_salida_uc as cant_sal_uc_detalle,sal_it.cantidad_uc as cant_item_uc
                                   ,sal_it.demasia_almacen,sal_it.cantidad_calculada
                                   ,sal_it.id_item,it.codigo||'' - ''||it.nombre as desc_item,
                                   sal_det.id_unidad_constructiva
                            FROM alma.tai_salida_uc_detalle_item sal_it
                            INNER JOIN alma.tai_salida_uc_detalle sal_det on sal_det.id_salida_uc_detalle=sal_it.id_salida_uc_detalle
                            INNER JOIN alma.tai_item it on it.id_item=sal_it.id_item and it.estado=''activo''
                            WHERE   ';
                            
             g_consulta := g_consulta || pm_criterio_filtro;

            -- SE AUMENTA EL ORDEN Y LOS PARAMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol || ' ' ||pm_sortdir;
            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;
            
            FOR g_registros in EXECUTE(g_consulta) LOOP            
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
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


    ---*** REGISTRO EN EL LOG EL √??XITO DE LA EJECUI√??N DEL PROCEDIMIENTO
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);


    ---*** SE DEVUELVE EL CONJUNTO DE DATOS
    RETURN;


EXCEPTION

    WHEN others THEN BEGIN

        --SE OBTIENE EL MENSAJE Y EL N√??MERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
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