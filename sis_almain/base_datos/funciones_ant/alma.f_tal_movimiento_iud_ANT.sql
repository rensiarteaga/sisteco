QL ---------------

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
 DESCRIPCIÃâN:     Realiza modificaciones en la tabla alma.tal_movimiento
 AUTOR:           Ruddy Lujan Bravo
 FECHA:           06-09-2013 17:10:00
 COMENTARIOS:    
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCIÃâN:  
 AUTOR:           Ruddy Lujan Bravo
 FECHA:           06-09-2013 17:10:00

***************************************************************************/

--------------------------
-- CUERPO DE LA FUNCIÃÆ?N -- 
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
cb_id_movimiento
cb_id_sucursal
cb_id_usuario
cb_estado
*/

-- DECLARACIÃâN DE VARIABLES PARTICULARES

--**** DECLARACION DE VARIABLES DE LA FUNCIÃâN (LOCALES) ****---


DECLARE

    --PARÃMETROS FIJOS

    g_id_subsistema               integer;     -- ID SUBSISTEMA
    g_id_lugar                    integer;     -- ID LUGAR
    g_numero_error                varchar;     -- ALMACENA EL NÃšMERO DE ERROR
    g_mensaje_error               varchar;     -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento    boolean;     -- BANDERA PARA VERIFICAR LLAMADA DE LA FUNCIÃâN
    g_descripcion_log_error       text;        -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento                  varchar; 
    g_reg_error                	  varchar; 
    g_respuesta                   varchar;     -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCIÃâN
    g_nivel_error                 varchar;     -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                               --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                               --      ERROR LÃâGICO (CRÃTICO) = 2
                                               --      ERROR LÃâGICO (INTERMEDIO) = 3
                                               --      ERROR LÃâGICO (ADVERTENCIA) = 4
    
    g_nombre_funcion              varchar;     -- NOMBRE FÃSICO DE LA FUNCIÃâN
    g_separador                   varchar(10); -- SEPARADOR DE CADENAS
    g_id_movimiento					integer;
    g_estado					varchar;

BEGIN
---*** INICIACIÃâN DE VARIABLES 
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funciÃ³n	
    g_nombre_funcion :='f_tal_movimiento_iud';
    g_privilegio_procedimiento := FALSE;
    g_respuesta := FALSE;
   
    ---*** OBTENCIÃâN DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENCIÃâN DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT tsg_usuario_lugar.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar
    WHERE  tsg_usuario_lugar.id_usuario = pm_id_usuario;
    
    
     ---*** VALIDACIÃâN DE LLAMADA POR USUARIO O FUNCIÃâN
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

    ---*** VERIFICACIÃâN DE PERMISOS DEL USUARIO
    IF NOT g_privilegio_procedimiento THEN
       g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;

---*** SI NO SE TIENE PERMISOS DE EJECUCIÃâN SE RETORNA EL MENSAJE DE ERROR
    IF NOT g_privilegio_procedimiento THEN
        g_nivel_error := '3';
        g_descripcion_log_error := 'El usuario no tiene permisos de ejecuciÃ³n del procedimiento';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                             pm_codigo_procedimiento   ,pm_proc_almacenado);
        
        --DEVUELVE MENSAJE DE ERROR
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
    END IF;
    
    
      --*** EJECUCIÃâN DEL PROCEDIMIENTO ESPECÃFICO
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
            
            -- DESCRIPCIÃâN DE ÃâXITO PARA GUARDAR EN EL LOG
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
                              
                g_descripcion_log_error := 'ModificaciÃ³n no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tal_movimiento';
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
                
			
		-- DESCRIPCIÃâN DE ÃâXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'ModificaciÃ³n exitosa en alma.tal_movimiento del registro '||  al_id_movimiento;
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
        ELSIF pm_codigo_procedimiento = 'AL_MOVI_DEL' THEN
        
    	BEGIN
            --VERIFICACIÃâN DE EXISTENCIA DEL REGISTRO
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
                
 			
            -- DESCRIPCIÃâN DE ÃâXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'EliminaciÃ³n exitosa del registro '||al_id_movimiento||' en alma.tal_movimiento';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
		
        ELSIF pm_codigo_procedimiento = 'AL_ALACTIVE_UPD' THEN
        
    	BEGIN
            --VERIFICACIÃâN DE EXISTENCIA DEL REGISTRO
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
                
 			
            -- DESCRIPCIÃâN DE ÃâXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'EliminaciÃ³n exitosa del registro '||al_id_movimiento||' en alma.tal_movimiento';
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

    ---*** REGISTRO EN EL LOG EL ÃâXITO DE LA EJECUIÃâN DEL PROCEDIMIENTO
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);

    ---*** SE DEVUELVE LA RESPUESTA
    RETURN g_respuesta||g_separador||g_reg_evento;

EXCEPTION

    WHEN others THEN BEGIN

        --SE OBTIENE EL MENSAJE Y EL NÃšMERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
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
