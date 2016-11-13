--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_tal_tramo_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_tramo integer,
  al_codigo varchar,
  al_descripcion varchar,
  al_observaciones varchar,
  al_estado varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA Almacen
***************************************************************************
 SCRIPT:          alma.f_tal_tramo_iud
 DESCRIPCION:     Realiza modificaciones en la tabla alma.tal_tramo
 AUTOR:           UNKNOW
 FECHA:           05-12-2014
 COMENTARIOS:    
***************************************************************************/
--------------------------
-- CUERPO DE LA FUNCION --
--------------------------

-- PARAMETROS FIJOS
/*
pm_id_usuario                               integer (si)
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

-- PARÃ?ÂÃ?ÂMETROS VARIABLES
/*
cb_id_almacen_item
cb_id_sucursal
cb_id_usuario
cb_estado
*/

-- DECLARACIÃ??N DE VARIABLES PARTICULARES

--**** DECLARACION DE VARIABLES DE LA FUNCIÃ??N (LOCALES) ****---


DECLARE

    --PARAMETROS FIJOS

    g_id_subsistema               integer;     -- ID SUBSISTEMA
    g_id_lugar                    integer;     -- ID LUGAR
    g_numero_error                varchar;     -- ALMACENA EL NÃ??MERO DE ERROR
    g_mensaje_error               varchar;     -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento    boolean;     -- BANDERA PARA VERIFICAR LLAMADA DE LA FUNCIÃ??N
    g_descripcion_log_error       text;        -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento                  varchar; 
    g_reg_error                	  varchar; 
    g_respuesta                   varchar;     -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCIÃ??N
    g_nivel_error                 varchar;     -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                               --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                               --      ERROR LÃ??GICO (CRÃ?ÂTICO) = 2
                                               --      ERROR LÃ??GICO (INTERMEDIO) = 3
                                               --      ERROR LÃ??GICO (ADVERTENCIA) = 4
    
    g_nombre_funcion              varchar;     -- NOMBRE FÃ?ÂSICO DE LA FUNCIÃ??N
    g_separador                   varchar(10); -- SEPARADOR DE CADENAS
   
BEGIN
---*** INICIACIÃ??N DE VARIABLES 
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funcion
    g_nombre_funcion :='f_tal_tramo_iud';
    g_privilegio_procedimiento := FALSE;
    g_respuesta := FALSE;
   
    ---*** OBTENCIÃ??N DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENCIÃ??N DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT tsg_usuario_lugar.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar
    WHERE  tsg_usuario_lugar.id_usuario = pm_id_usuario;
    
    
     ---*** VALIDACIÃ??N DE LLAMADA POR USUARIO O FUNCIO?N
    IF pm_proc_almacenado IS NOT NULL THEN
        IF NOT EXISTS(SELECT 1 FROM pg_proc WHERE proname = pm_proc_almacenado) THEN
            g_descripcion_log_error := 'Procedimiento ejecutor inexistente';
            g_nivel_error := '2';
            g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
            
            --REGISTRA EL LOG
            g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                 pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                 pm_codigo_procedimiento   ,pm_proc_almacenado);
            --DEVUELVE MENSAJE DE ERROR
            RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
        ELSE
            g_privilegio_procedimiento := TRUE;
        END IF;
    END IF;


    ---*** VERIFICACIÃ??N DE PERMISOS DEL USUARIO
    IF NOT g_privilegio_procedimiento THEN
       g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;

---*** SI NO SE TIENE PERMISOS DE EJECUCIO?N SE RETORNA EL MENSAJE DE ERROR
    IF NOT g_privilegio_procedimiento THEN
        g_nivel_error := '3';
        g_descripcion_log_error := 'El usuario no tiene permisos de ejecucion del procedimiento';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                             pm_codigo_procedimiento   ,pm_proc_almacenado);
        
        --DEVUELVE MENSAJE DE ERROR
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
    END IF;
    
    
      --*** EJECUCIÃ??N DEL PROCEDIMIENTO ESPECIÂFICO
    IF pm_codigo_procedimiento = 'AL_TRAM_INS' THEN
    BEGIN
        --verificacion de duplicidad del codigo de fase
        IF EXISTS(SELECT 1 FROM alma.tal_tramo t WHERE t.codigo=al_codigo)
        THEN
        	 	g_descripcion_log_error := 'Insercion no realizada, el codigo del tramo ingresado' || al_codigo || 'ya fue registrado';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
        END IF;
    	
    
		INSERT INTO alma.tal_tramo (
            codigo, 
            descripcion,
        	observaciones,
            estado	
        ) VALUES (
            al_codigo,
           	al_descripcion,
			al_observaciones,
			al_estado
        );
            
            -- DESCRIPCIÃ??N DE Ã??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tal_tramo';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;   
        END;
        
  --procedimiento de modificacion      
	ELSIF pm_codigo_procedimiento = 'AL_TRAM_UPD' THEN
	BEGIN
            IF NOT EXISTS (SELECT 1 FROM alma.tal_tramo t WHERE t.id_tramo=al_id_tramo) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_tramo || 'en la tabla alma.tal_tramo';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta; 
			ELSE
            	IF EXISTS(SELECT 1 FROM alma.tal_tramo t WHERE t.codigo=al_codigo and t.id_tramo!=al_id_tramo)
                THEN
                	g_descripcion_log_error := 'Modificacion no realizada, el codigo de tramo ' || al_codigo || ' ya fue registrado anteriormente';
                	g_nivel_error := '4';
                	g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);	
                END IF;     
            END IF;

                UPDATE alma.tal_tramo SET 
                	usuario_reg = "current_user"(),
                	fecha_reg = now(),
                    codigo = al_codigo,
                	descripcion = al_descripcion,
                    observaciones = al_observaciones,
                    estado = al_estado
				WHERE alma.tal_tramo.id_tramo = al_id_tramo;
                
			
		-- DESCRIPCIÃ??N DE Ã??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa en alma.tal_tramo del registro '||  al_id_tramo;
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
        ELSIF pm_codigo_procedimiento = 'AL_FASE_DEL' THEN
        
    	BEGIN
        
            IF NOT EXISTS(SELECT 1 FROM  alma.tal_tramo t WHERE t.id_tramo=al_id_tramo) THEN
                              
                g_descripcion_log_error := 'Eliminacion no realizada: no existe el registro' || al_id_tramo || 'en la tabla alma.tal_tramo';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;
              
            DELETE FROM alma.tal_tramo 
			WHERE alma.tal_tramo.id_tramo = al_id_tramo;
                
 			
            -- DESCRIPCIÃ??N DE Ã??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_tramo||' en alma.tal_tramo';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;

    ELSE
        --PROCEDIMIENTO INEXISTENTE
        g_nivel_error := '2';
        g_descripcion_log_error := 'Procedimiento inexistente';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
        
        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario            ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                            pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                            pm_codigo_procedimiento   ,pm_proc_almacenado);
        --DEVUELVE MENSAJE DE ERROR
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
        
    END IF;

    ---*** REGISTRO EN EL LOG EL Ã??XITO DE LA EJECUIÃ??N DEL PROCEDIMIENTO
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);

    ---*** SE DEVUELVE LA RESPUESTA
    RETURN g_respuesta||g_separador||g_reg_evento;


EXCEPTION

    WHEN others THEN BEGIN

        --SE OBTIENE EL MENSAJE Y EL NÃ??MERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
        g_mensaje_error := SQLERRM ;
        g_numero_error := SQLSTATE;
    
        -- SE REGISTRA EL ERROR OCURRIDO
        g_reg_error:= sss.f_tsg_registro_evento (pm_id_usuario            ,g_id_subsistema          ,g_id_lugar         ,g_mensaje_error,
                                             pm_ip_origen             ,pm_mac_maquina           ,'error'            ,g_numero_error,
                                             pm_codigo_procedimiento  ,pm_proc_almacenado);
                                             
        --SE DEVUELVE EL MENSAJE DE ERROR
        g_nivel_error := '1';
        g_descripcion_log_error := g_numero_error || ' - ' || g_mensaje_error;
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_error;         
    END;
    
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;