QL ---------------

CREATE OR REPLACE FUNCTION alma.f_tal_item_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_item integer,
  al_id_clasificacion integer,
  al_id_unidad_medida integer,
  al_nombre varchar,
  al_descripcion varchar,
  al_codigo_fabrica varchar,
  al_bajo_responsabilidad varchar,
  al_estado varchar,
  al_metodo_valoracion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA Almacen ONLINE
***************************************************************************
 SCRIPT:          alma.f_tal_item_iud
 DESCRIPCIÃ?N:     Realiza modificaciones en la tabla alma.tal_item
 AUTOR:           Ruddy Lujan Bravo
 FECHA:           27-08-2013 17:10:00
 COMENTARIOS:    
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCIÃ?N:  
 AUTOR:           Ruddy Lujan Bravo
 FECHA:           27-08-2013 17:10:00

***************************************************************************/

--------------------------
-- CUERPO DE LA FUNCIÃ??N --
--------------------------

-- PARÃÃMETROS FIJOS
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

-- PARÃÃMETROS VARIABLES
/*
cb_id_almacen_item
cb_id_sucursal
cb_id_usuario
cb_estado
*/

-- DECLARACIÃ?N DE VARIABLES PARTICULARES

--**** DECLARACION DE VARIABLES DE LA FUNCIÃ?N (LOCALES) ****---


DECLARE

    --PARÃMETROS FIJOS

    g_id_subsistema               integer;     -- ID SUBSISTEMA
    g_id_lugar                    integer;     -- ID LUGAR
    g_numero_error                varchar;     -- ALMACENA EL NÃ?MERO DE ERROR
    g_mensaje_error               varchar;     -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento    boolean;     -- BANDERA PARA VERIFICAR LLAMADA DE LA FUNCIÃ?N
    g_descripcion_log_error       text;        -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento                  varchar; 
    g_reg_error                	  varchar; 
    g_respuesta                   varchar;     -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCIÃ?N
    g_nivel_error                 varchar;     -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                               --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                               --      ERROR LÃ?GICO (CRÃTICO) = 2
                                               --      ERROR LÃ?GICO (INTERMEDIO) = 3
                                               --      ERROR LÃ?GICO (ADVERTENCIA) = 4
    
    g_nombre_funcion              varchar;     -- NOMBRE FÃSICO DE LA FUNCIÃ?N
    g_separador                   varchar(10); -- SEPARADOR DE CADENAS
    g_id_item					integer;
    g_codigo_padre				varchar;
    g_num_clasificacion			integer;
BEGIN
---*** INICIACIÃ?N DE VARIABLES 
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funciÃ³n	
    g_nombre_funcion :='f_tal_item_iud';
    g_privilegio_procedimiento := FALSE;
    g_respuesta := FALSE;
   
    ---*** OBTENCIÃ?N DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENCIÃ?N DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT tsg_usuario_lugar.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar
    WHERE  tsg_usuario_lugar.id_usuario = pm_id_usuario;
    
    
     ---*** VALIDACIÃ?N DE LLAMADA POR USUARIO O FUNCIO?N
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


    ---*** VERIFICACIÃ?N DE PERMISOS DEL USUARIO
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
    
    
      --*** EJECUCIÃ?N DEL PROCEDIMIENTO ESPECIFICO
    IF pm_codigo_procedimiento = 'AL_ITEM_INS' THEN
    BEGIN
		select codigo_largo into g_codigo_padre
        from alma.tal_clasificacion where id_clasificacion = al_id_clasificacion;
        
        select max(num_por_clasificacion) into g_num_clasificacion
        from alma.tal_item where id_clasificacion = al_id_clasificacion;
        
        if(g_num_clasificacion is not null) then
        	g_num_clasificacion = g_num_clasificacion + 1;
        else
        	g_num_clasificacion = 1;
        end if;
        
		INSERT INTO alma.tal_item (
            id_clasificacion,
            id_unidad_medida, 
            codigo,
        	nombre,
            descripcion,
            codigo_fabrica,
            num_por_clasificacion,
            bajo_responsabilidad,
            estado,
            metodo_valoracion	
        ) VALUES (
            al_id_clasificacion,
            al_id_unidad_medida,
            g_codigo_padre || '.' || g_num_clasificacion,
			al_nombre,
			al_descripcion,
			al_codigo_fabrica,
            g_num_clasificacion,
            al_bajo_responsabilidad,
        	al_estado,
            al_metodo_valoracion
        );
            
            -- DESCRIPCIÃ?N DE Ã?XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tal_item';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;   
        END;
        
  --procedimiento de modificacion      
	ELSIF pm_codigo_procedimiento = 'AL_ITEM_UPD' THEN
	BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            select id_item
            into g_id_item
            from alma.tal_item alma
            where alma.id_item = al_id_item;
            
            IF (g_id_item is null) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_item || 'en la tabla alma.tal_item';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;

                UPDATE alma.tal_item SET 
                	usuario_reg = "current_user"(),
                	fecha_reg = now(),
                    id_clasificacion = al_id_clasificacion,
                    id_unidad_medida = al_id_unidad_medida,
                	nombre = al_nombre,
                	descripcion = al_descripcion,
                    codigo_fabrica = al_codigo_fabrica,
                    bajo_responsabilidad = al_bajo_responsabilidad,
                	estado = al_estado,
                    metodo_valoracion = al_metodo_valoracion
				WHERE alma.tal_item.id_item = al_id_item;
                
			
		-- DESCRIPCIÃ?N DE Ã?XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa en alma.tal_item del registro '||  al_id_item;
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
        ELSIF pm_codigo_procedimiento = 'AL_ITEM_DEL' THEN
        
    	BEGIN
            --VERIFICACIÃ?N DE EXISTENCIA DEL REGISTRO
            select id_item
            into g_id_item
            from alma.tal_item alma
            where alma.id_item = al_id_item;

            IF (g_id_item is null) THEN
                              
                g_descripcion_log_error := 'Eliminacion no realizada: no existe el registro' || al_id_item || 'en la tabla alma.tal_item';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;
              
            DELETE FROM alma.tal_item 
				WHERE alma.tal_item.id_item = al_id_item;
                
 			
            -- DESCRIPCIÃ?N DE Ã?XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'EliminaciÃ³n exitosa del registro '||al_id_item||' en alma.tal_item';
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

    ---*** REGISTRO EN EL LOG EL Ã?XITO DE LA EJECUIÃ?N DEL PROCEDIMIENTO
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);

    ---*** SE DEVUELVE LA RESPUESTA
    RETURN g_respuesta||g_separador||g_reg_evento;


EXCEPTION

    WHEN others THEN BEGIN

        --SE OBTIENE EL MENSAJE Y EL NÃ?MERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
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
