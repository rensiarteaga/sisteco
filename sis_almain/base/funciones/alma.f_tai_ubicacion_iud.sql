--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_tai_ubicacion_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_ubicacion integer,
  al_id_ubicacion_fk integer,
  al_id_almacen integer,
  al_codigo varchar,
  al_nombre varchar,
  al_estado varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA Almacen
***************************************************************************
 SCRIPT:          alma.f_tai_ubicacion_iud
 DESCRIPCI√?N:     Realiza modificaciones en la tabla alma.tai_ubicacion
 AUTOR:           Ruddy Lujan Bravo
 FECHA:           08-08-2013 17:10:00
 COMENTARIOS:    
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCI√?N:  
 AUTOR:           Ruddy Lujan Bravo
 FECHA:            08-08-2013 17:10:00

***************************************************************************/

--------------------------
-- CUERPO DE LA FUNCI√??N --
--------------------------

-- PAR√Å¬ÅMETROS FIJOS
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

-- PAR√Å¬ÅMETROS VARIABLES
/*
cb_id_almacen
cb_id_sucursal
cb_id_usuario
cb_estado
*/

-- DECLARACI√?N DE VARIABLES PARTICULARES

--**** DECLARACION DE VARIABLES DE LA FUNCI√?N (LOCALES) ****---


DECLARE

    --PAR√ÅMETROS FIJOS

    g_id_subsistema               integer;     -- ID SUBSISTEMA
    g_id_lugar                    integer;     -- ID LUGAR
    g_numero_error                varchar;     -- ALMACENA EL N√MERO DE ERROR
    g_mensaje_error               varchar;     -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento    boolean;     -- BANDERA PARA VERIFICAR LLAMADA DE LA FUNCI√?N
    g_descripcion_log_error       text;        -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento                  varchar; 
    g_reg_error                	  varchar; 
    g_respuesta                   varchar;     -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCI√?N
    g_nivel_error                 varchar;     -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                               --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                               --      ERROR L√?GICO (CR√çTICO) = 2
                                               --      ERROR L√?GICO (INTERMEDIO) = 3
                                               --      ERROR L√?GICO (ADVERTENCIA) = 4
    
    g_nombre_funcion              varchar;     -- NOMBRE F√çSICO DE LA FUNCI√?N
    g_separador                   varchar(10); -- SEPARADOR DE CADENAS
    g_id_fina_regi_prog_proy_acti integer;     -- VARIABLE DE LA ESTRUCTURA PROGRAM√ÅTICA

    g_id_almacen					integer;
    g_registros						record;
    g_id_rol						integer;
    g_id_ubicacion			       integer;
    g_tipo_ubicacion				varchar;
    
BEGIN
---*** INICIACI√?N DE VARIABLES 
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funci√≥n	
    g_nombre_funcion :='f_tai_ubicacion_iud';
    g_privilegio_procedimiento := FALSE;
    g_respuesta := FALSE;
   
    ---*** OBTENCI√?N DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENCI√?N DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT tsg_usuario_lugar.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar
    WHERE  tsg_usuario_lugar.id_usuario = pm_id_usuario;
    
    
     ---*** VALIDACI√?N DE LLAMADA POR USUARIO O FUNCI√?N
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


    ---*** VERIFICACI√?N DE PERMISOS DEL USUARIO
    IF NOT g_privilegio_procedimiento THEN
       g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;

---*** SI NO SE TIENE PERMISOS DE EJECUCI√?N SE RETORNA EL MENSAJE DE ERROR
    IF NOT g_privilegio_procedimiento THEN
        g_nivel_error := '3';
        g_descripcion_log_error := 'El usuario no tiene permisos de ejecuci√≥n del procedimiento';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                             pm_codigo_procedimiento   ,pm_proc_almacenado);
        
        --DEVUELVE MENSAJE DE ERROR
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
    END IF;
    
    
      --*** EJECUCI√?N DEL PROCEDIMIENTO ESPEC√çFICO
    IF pm_codigo_procedimiento = 'AL_ALUB_INS' THEN
    BEGIN
		IF EXISTS(SELECT 1 FROM alma.tai_ubicacion u WHERE u.codigo=al_codigo AND u.id_almacen=al_id_almacen)
        THEN
        	 	g_descripcion_log_error := 'Insercion no realizada, el codigo de ubicacion ingresado ' || al_codigo || ' ,fue registrado anteriormente.';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
        END IF;
                
         if(al_id_ubicacion_fk IS NULL ) then
        	g_tipo_ubicacion = 'raiz';
         else
        	g_tipo_ubicacion = 'nodo';
         end if;
		INSERT INTO alma.tai_ubicacion(
            id_ubicacion_fk,
			id_almacen,  
            codigo,
        	nombre,
            estado,
            tipo_ubicacion
        ) 
        VALUES (
            al_id_ubicacion_fk,
            al_id_almacen,
			al_codigo,
			al_nombre,
        	al_estado,
            g_tipo_ubicacion      	
        );
        
        
        if EXISTS(select 1 from alma.tai_ubicacion u where u.id_ubicacion = al_id_ubicacion_fk)	
        then
            g_tipo_ubicacion = 'rama';
        end if;
       
    	update alma.tai_ubicacion 
        set tipo_ubicacion=g_tipo_ubicacion 
        where id_ubicacion = al_id_ubicacion_fk AND id_ubicacion_fk  IS NOT NULL;
        
        
          -- DESCRIPCI√?N DE √?XITO PARA GUARDAR EN EL LOG
          g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tai_ubicacion';
          g_respuesta := 't'||g_separador||g_descripcion_log_error;   
        END;
        
  --procedimiento de modificacion      
	ELSIF pm_codigo_procedimiento = 'AL_ALUB_UPD' THEN
	BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            select id_ubicacion
            into g_id_ubicacion
            from alma.tai_ubicacion alma
            where alma.id_ubicacion = al_id_ubicacion;
            
            IF (g_id_ubicacion is null) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_ubicacion || 'en la tabla alma.tai_ubicacion';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;
            IF EXISTS(select 1 from alma.tai_ubicacion u where u.codigo=al_codigo and u.id_ubicacion != al_id_ubicacion and u.id_almacen=al_id_almacen)
            THEN
            	 	g_descripcion_log_error := 'Modificacion no realizada, el codigo ingresado ' || al_codigo || ' fue registrado con anterioridad en el almacen';
                	g_nivel_error := '4';
                	g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
               	 	RETURN 'f'||g_separador||g_respuesta;
            END IF;

			if(al_id_ubicacion_fk IS NULL)then
            	
            	g_tipo_ubicacion = 'raiz';
            else
            	if  NOT EXISTS (select 1 from alma.tai_ubicacion u where u.id_ubicacion_fk = al_id_ubicacion and u.estado='activo') then
                	g_tipo_ubicacion = 'nodo';
                else
                	g_tipo_ubicacion = 'rama';
                end if;
        	end if;
            
                UPDATE alma.tai_ubicacion SET 
                	usuario_reg = "current_user"(),
                	fecha_reg = now(),
                    id_ubicacion_fk = al_id_ubicacion_fk,
                    id_almacen = al_id_almacen,
                	codigo = al_codigo,
                	nombre = al_nombre,
                	estado = al_estado,
                    tipo_ubicacion = g_tipo_ubicacion
				WHERE alma.tai_ubicacion.id_ubicacion = al_id_ubicacion;
                
			
		-- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa en alma.tai_ubicacion del registro '||  al_id_ubicacion;
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
        ELSIF pm_codigo_procedimiento = 'AL_ALUB_DEL' THEN
        
    	BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO

            
            IF NOT EXISTS(select 1 from alma.tai_ubicacion u where u.id_ubicacion=al_id_ubicacion) THEN
                              
                g_descripcion_log_error := 'Eliminacion no realizada: no existe el registro' || al_id_ubicacion || 'en la tabla alma.tai_ubicacion';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            ELSE
            	IF EXISTS(select 1 from alma.tai_ubicacion u where u.id_ubicacion_fk=al_id_ubicacion) 
                THEN
                	g_descripcion_log_error := 'Eliminacion no realizada, el elemento seleccionado ' || al_id_ubicacion || ' tiene nodos dependientes';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                END IF;
            END IF;
              
            DELETE FROM alma.tai_ubicacion 
				WHERE alma.tai_ubicacion.id_ubicacion = al_id_ubicacion;
                
 			
            -- DESCRIPCI√?N DE √?XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_ubicacion||' en alma.tai_ubicacion';
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

    ---*** REGISTRO EN EL LOG EL √?XITO DE LA EJECUI√?N DEL PROCEDIMIENTO
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);

    ---*** SE DEVUELVE LA RESPUESTA
    RETURN g_respuesta||g_separador||g_reg_evento;


EXCEPTION

    WHEN others THEN BEGIN

        --SE OBTIENE EL MENSAJE Y EL NMERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
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