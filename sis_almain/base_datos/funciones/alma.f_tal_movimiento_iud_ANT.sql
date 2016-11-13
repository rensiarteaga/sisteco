--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma."f_tal_movimiento_iud_ANT" (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_movimiento integer,
  al_id_tipo_movimiento integer,
  al_id_almacen integer,
  al_codigo varchar,
  al_fecha_movimiento timestamp,
  al_descripcion varchar,
  al_observaciones varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA Almacen ONLINE
***************************************************************************
 SCRIPT:          alma.f_tal_movimiento_iud
 DESCRIPCIÃ?â??N:     Realiza modificaciones en la tabla alma.tal_movimiento
 AUTOR:           Ruddy Lujan Bravo
 FECHA:           06-09-2013 17:10:00
 COMENTARIOS:    
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCIÃ?â??N:  
 AUTOR:           Ruddy Lujan Bravo
 FECHA:           06-09-2013 17:10:00

***************************************************************************/

--------------------------
-- CUERPO DE LA FUNCIÃ?Æ??N -- 
--------------------------

-- PARÃ?ÂÃ?ÂMETROS FIJOS
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
cb_id_movimiento
cb_id_sucursal
cb_id_usuario
cb_estado
*/

-- DECLARACIÃ?â??N DE VARIABLES PARTICULARES

--**** DECLARACION DE VARIABLES DE LA FUNCIÃ?â??N (LOCALES) ****---


DECLARE

    --PARÃ?ÂMETROS FIJOS

    g_id_subsistema               integer;     -- ID SUBSISTEMA
    g_id_lugar                    integer;     -- ID LUGAR
    g_numero_error                varchar;     -- ALMACENA EL NÃ?Å¡MERO DE ERROR
    g_mensaje_error               varchar;     -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento    boolean;     -- BANDERA PARA VERIFICAR LLAMADA DE LA FUNCIÃ?â??N
    g_descripcion_log_error       text;        -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento                  varchar; 
    g_reg_error                	  varchar; 
    g_respuesta                   varchar;     -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCIÃ?â??N
    g_nivel_error                 varchar;     -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                               --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                               --      ERROR LÃ?â??GICO (CRÃ?ÂTICO) = 2
                                               --      ERROR LÃ?â??GICO (INTERMEDIO) = 3
                                               --      ERROR LÃ?â??GICO (ADVERTENCIA) = 4
    
    g_nombre_funcion              varchar;     -- NOMBRE FÃ?ÂSICO DE LA FUNCIÃ?â??N
    g_separador                   varchar(10); -- SEPARADOR DE CADENAS
    g_id_movimiento					integer;
    g_estado					varchar;

BEGIN
---*** INICIACIÃ?â??N DE VARIABLES 
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funciÃ?Â³n	
    g_nombre_funcion :='f_tal_movimiento_iud';
    g_privilegio_procedimiento := FALSE;
    g_respuesta := FALSE;
   
    ---*** OBTENCIÃ?â??N DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENCIÃ?â??N DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT tsg_usuario_lugar.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar
    WHERE  tsg_usuario_lugar.id_usuario = pm_id_usuario;
    
    
     ---*** VALIDACIÃ?â??N DE LLAMADA POR USUARIO O FUNCIÃ?â??N
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

    ---*** VERIFICACIÃ?â??N DE PERMISOS DEL USUARIO
    IF NOT g_privilegio_procedimiento THEN
       g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;

---*** SI NO SE TIENE PERMISOS DE EJECUCIÃ?â??N SE RETORNA EL MENSAJE DE ERROR
    IF NOT g_privilegio_procedimiento THEN
        g_nivel_error := '3';
        g_descripcion_log_error := 'El usuario no tiene permisos de ejecuciÃ?Â³n del procedimiento';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                             pm_codigo_procedimiento   ,pm_proc_almacenado);
        
        --DEVUELVE MENSAJE DE ERROR
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
    END IF;
    
    
      --*** EJECUCIÃ?â??N DEL PROCEDIMIENTO ESPECÃ?ÂFICO
    IF pm_codigo_procedimiento = 'AL_MOVI_INS' THEN
    BEGIN
		
		INSERT INTO alma.tal_movimiento(
		    id_usuario_reg,
            fecha_reg,
            id_tipo_movimiento,
			id_almacen,
            codigo,
            fecha_movimiento,
        	descripcion,
            observaciones,
            estado
        ) 
        VALUES (
            pm_id_usuario,
            now(),
            al_id_tipo_movimiento,
            al_id_almacen,
			al_codigo,
			al_fecha_movimiento,
        	al_descripcion,
            al_observaciones,
            'borrador'     	
        );
            
            -- DESCRIPCIÃ?â??N DE Ã?â?°XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tal_movimiento';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;   
        END;
        
  --procedimiento de modificacion      
	ELSIF pm_codigo_procedimiento = 'AL_MOVI_UPD' THEN
	BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            select id_movimiento
            into g_id_movimiento
            from alma.tal_movimiento alma
            where alma.id_movimiento = al_id_movimiento;
            
            IF (g_id_movimiento is null) THEN
                              
                g_descripcion_log_error := 'ModificaciÃ?Â³n no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tal_movimiento';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;

                UPDATE alma.tal_movimiento SET 
                	id_usuario_mod = pm_id_usuario,
                	fecha_mod = now(),
                    id_tipo_movimiento = al_id_tipo_movimiento,
                    id_almacen = al_id_almacen,
                	codigo = al_codigo,
                	fecha_movimiento = al_fecha_movimiento,
                    descripcion = al_descripcion,
                    observaciones = al_observaciones
				WHERE alma.tal_movimiento.id_movimiento = al_id_movimiento;
                
			
		-- DESCRIPCIÃ?â??N DE Ã?â?°XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'ModificaciÃ?Â³n exitosa en alma.tal_movimiento del registro '||  al_id_movimiento;
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
        ELSIF pm_codigo_procedimiento = 'AL_MOVI_DEL' THEN
        
    	BEGIN
            --VERIFICACIÃ?â??N DE EXISTENCIA DEL REGISTRO
            select id_movimiento
            into g_id_movimiento
            from alma.tal_movimiento alma
            where alma.id_movimiento = al_id_movimiento;
            
            IF (g_id_movimiento is null) THEN
                              
                g_descripcion_log_error := 'Eliminacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tal_movimiento';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;
              
            DELETE FROM alma.tal_movimiento 
				WHERE alma.tal_movimiento.id_movimiento = al_id_movimiento;
                
 			
            -- DESCRIPCIÃ?â??N DE Ã?â?°XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'EliminaciÃ?Â³n exitosa del registro '||al_id_movimiento||' en alma.tal_movimiento';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
		
        ELSIF pm_codigo_procedimiento = 'AL_ALACTIVE_UPD' THEN
        
    	BEGIN
            --VERIFICACIÃ?â??N DE EXISTENCIA DEL REGISTRO
            select id_movimiento, estado
            into g_id_movimiento, g_estado
            from alma.tal_movimiento alma
            where alma.id_movimiento = al_id_movimiento;
            
            IF (g_id_movimiento is null) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tal_movimiento';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;
            
            if (g_estado = 'borrador') then
            	g_estado = 'finalizado';
            elseif g_estado = 'finalizado' then
            	g_estado = 'borrador';
            end if;
            
             UPDATE alma.tal_movimiento SET 
                	estado = g_estado
				WHERE alma.tal_movimiento.id_movimiento = al_id_movimiento;
                
 			
            -- DESCRIPCIÃ?â??N DE Ã?â?°XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'EliminaciÃ?Â³n exitosa del registro '||al_id_movimiento||' en alma.tal_movimiento';
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

    ---*** REGISTRO EN EL LOG EL Ã?â?°XITO DE LA EJECUIÃ?â??N DEL PROCEDIMIENTO
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);

    ---*** SE DEVUELVE LA RESPUESTA
    RETURN g_respuesta||g_separador||g_reg_evento;

EXCEPTION

    WHEN others THEN BEGIN

        --SE OBTIENE EL MENSAJE Y EL NÃ?Å¡MERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
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