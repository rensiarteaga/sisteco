--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_tal_stock_item_sel (
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
 SCRIPT:          alma.f_tal_stock_item_sel
 DESCRIPCION:     Devuelve las consultas a la tabla tal_stock_item
 AUTOR:           UNKNOW
 FECHA:           30-05-2014
 COMENTARIOS:    

***************************************************************************/
--------------------------
-- CUERPO DE LA FUNCIÃ??N --
--------------------------

-- PARÃ?ÂMETROS FIJOS
-- PARÃMETROS FIJOS
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

-- DECLARACIÃ?N DE VARIABLES PARTICULARES


-- DECLARACIÃ?N DE VARIABLES DE LA FUNCIÃ?N (LOCALES)

DECLARE

    --PARÃMETROS FIJOS
    g_id_subsistema            integer; -- ID SUBSISTEMA
    g_id_lugar                 integer; -- ID LUGAR
    g_numero_error             varchar; -- ALMACENA EL NÃ?MERO DE ERROR
    g_mensaje_error            varchar; -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento boolean; -- BANDERA PARA VERIFICAR LLAMADA DE PROCEDIMIENTO
    g_descripcion_log_error    text;    -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento               boolean;
    g_reg_error                boolean;
    g_registros                record;  -- PARA ALMACENAR EL CONJUNTO DE DATOS RESULTADO DEL SELECT
    g_respuesta                varchar; -- VARIABLE QUE CONTENDRÃ LOS MENSAJES DE ERROR
    g_consulta                 text;    -- VARIABLE QUE CONTENDRÃ LA CONSULTA DINÃMICA PARA EL FILTRO
    g_nivel_error              varchar; -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                        --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                        --      ERROR LÃ?GICO (CRÃTICO) = 2
                                        --      ERROR LÃ?GICO (INTERMEDIO) = 3
                                        --      ERROR LÃ?GICO (ADVERTENCIA) = 4
    g_nombre_funcion           varchar; --NOMBRE FÃSICO DE LA FUNCIÃ?N
    g_separador                varchar(10); --Caracteres que servirÃ¡n para separar el mensaje, nivel y origen del error
    g_rol_adm		           boolean;	-- Identifica si el usuario tiene rol administrador

BEGIN

    ---*** INICIACIÃ?N DE VARIABLES
    g_privilegio_procedimiento := FALSE;
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funciÃ³n
    g_nombre_funcion := 'f_taf_deposito_sel';
    
    ---*** VERIFICACIÃ?N ROL ADMINISTRADOR
    IF EXISTS(SELECT 1 FROM sss.tsg_usuario_rol usrol WHERE usrol.id_usuario = pm_id_usuario AND usrol.id_rol=1) THEN
        g_rol_adm := true;
    END IF;
    
    ---*** OBTENCIÃ?N DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;

    ---*** OBTENCIÃ?N DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT sss.tsg_usuario_lugar.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar
    WHERE  sss.tsg_usuario_lugar.id_usuario = pm_id_usuario;


    ---*** VALIDACIÃ?N DE LLAMADA POR USUARIO O FUNCIÃ?N
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

    ---*** VERIFICACIÃ?N DE PERMISOS DEL USUARIO
    IF NOT g_privilegio_procedimiento THEN
       g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;

    ---*** SI NO SE TIENE PERMISOS DE EJECUCIÃ?N SE RETORNA EL MENSAJE DE ERROR
    IF NOT g_privilegio_procedimiento THEN
        g_nivel_error := '3';
        g_descripcion_log_error := 'El usuario no tiene permisos de ejecuciÃ³n del procedimiento';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                             pm_codigo_procedimiento   ,pm_proc_almacenado);
        --DEVUELVE MENSAJE DE ERROR
        RAISE EXCEPTION '%',g_descripcion_log_error;
    END IF; 

    ---***SELECCIÃ?N DE OPERACIÃ?N A REALIZAR
    IF pm_codigo_procedimiento  = 'AL_STOCKITEM_SEL' THEN
        BEGIN
            g_consulta := 'SELECT  stock.id_stock_item,
                                   stock.id_item,
                                   it.codigo || '' '' || it.nombre as desc_item,
                                   stock.id_almacen,
                                   alm.codigo || '' '' || alm.nombre as desc_almacen,
                                   stock.minimo,
                                   stock.maximo,
                                   stock.usuario_reg,
                                   COALESCE(to_char(stock.fecha_reg,''dd-mm-yyyy''),''0'') AS fecha_reg,
                                   med.id_unidad_medida_base,
                                   med.nombre
                                   
                            FROM alma.tal_stock_item stock
                                 INNER JOIN alma.tal_almacen alm on alm.id_almacen = stock.id_almacen and alm.estado = ''activo''
                                 INNER JOIN alma.tal_item it on it.id_item = stock.id_item and it.estado =''activo''
                                 INNER JOIN param.tpm_unidad_medida_base med on med.id_unidad_medida_base=it.id_unidad_medida and med.estado_registro=''activo''
                            WHERE  ';
            g_consulta := g_consulta || pm_criterio_filtro;
	-- SE AUMENTA EL ORDEN Y LOS PARÃMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;
            
            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;
                
            -- DESCRIPCIÃ?N DE Ã?XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;
        
        
    -- PARA LA CONSULTA DE SELECCIÃ?N     
    ELSIF pm_codigo_procedimiento  = 'AL_STOCKITEM_COUNT' THEN

        BEGIN
        --Cuenta todos los registros
            g_consulta := 	' SELECT 	count(stock.id_stock_item) as total
                              FROM alma.tal_stock_item stock
                                 INNER JOIN alma.tal_almacen alm on alm.id_almacen = stock.id_almacen and alm.estado = ''activo''
                                 INNER JOIN alma.tal_item it on it.id_item = stock.id_item and it.estado =''activo''
                                 INNER JOIN param.tpm_unidad_medida_base med on med.id_unidad_medida_base=it.id_unidad_medida and med.estado_registro=''activo''
                              WHERE   ';
							

            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÃ?N DE Ã?XITO PARA GUARDAR EN EL LOG
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


    ---*** REGISTRO EN EL LOG EL Ã?XITO DE LA EJECUCIÃ?N DEL PROCEDIMIENTO
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);


    ---*** SE DEVUELVE EL CONJUNTO DE DATOS
    RETURN;


EXCEPTION

    WHEN others THEN BEGIN
    
        --SE OBTIENE EL MENSAJE Y EL NÃ?MERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
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