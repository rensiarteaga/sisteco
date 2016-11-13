
	CREATE OR REPLACE FUNCTION "public"."f_tsg_metaproceso_iud" (
		pm_id_usuario integer,
		pm_ip_origen varchar,
		pm_mac_maquina macaddr,
		pm_codigo_procedimiento varchar,
		pm_proc_almacenado varchar,
		sg_id_metaproceso  int4,
		sg_id_subsistema  int4,
		sg_fk_id_metaproceso  int4,
		sg_nivel  int4,
		sg_nombre  text,
		sg_codigo_procedimiento  varchar,
		sg_nombre_achivo  varchar,
		sg_ruta_archivo  text,
		sg_fecha_registro  date,
		sg_hora_registro  time,
		sg_fecha_ultima_modificacion  timestamp,
		sg_hora_ultima_modificacion  time,
		sg_descripcion  text,
		sg_visible  varchar,
		sg_habilitar_log  varchar,
		sg_orden_logico  int4,
		sg_icono  varchar,
		sg_nombre_tabla  varchar,
		sg_prefijo  varchar,
		sg_codigo_base  varchar,
		sg_tipo_vista  varchar,
		sg_con_ep  varchar,
		sg_con_interfaz  varchar,
		sg_num_datos_hijo  int4
)
		RETURNS varchar AS
$body$



/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ALMACENES (ALMIN)
***************************************************************************
 SCRIPT: 		f_tsg_metaproceso_iud
 DESCRIPCIÓN: 	Permite registrar en la tabla tsg_metaproceso
 AUTOR: 		(generado automaticamente)
 FECHA:			2007-10-10 10:41:44
 COMENTARIOS:	
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:			

***************************************************************************/
--------------------------
-- CUERPO DE LA FUNCIÓN --
--------------------------

-- PARÁMETROS FIJOS
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

-- DECLARACIÓN DE VARIABLES PARTICULARES

--**** DECLARACION DE VARIABLES DE LA FUNCIÓN (LOCALES) ****---


DECLARE

    --PARÁMETROS FIJOS

    g_id_subsistema            integer; -- ID SUBSISTEMA
    g_id_lugar                 integer; -- ID LUGAR
    g_numero_error             varchar; -- ALMACENA EL NÚMERO DE ERROR
    g_mensaje_error            varchar; -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento boolean; -- BANDERA PARA VERIFICAR LLAMADA DE LA FUNCIÓN
    g_descripcion_log_error    text;    -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento               varchar; --boolean;
    g_reg_error                varchar; --boolean;
    g_respuesta                varchar; -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCIÓN
    g_nivel_error              varchar; -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                        --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                        --      ERROR LÓGICO (CRÍTICO) = 2
                                        --      ERROR LÓGICO (INTERMEDIO) = 3
                                        --      ERROR LÓGICO (ADVERTENCIA) = 4
    
    g_nombre_funcion           varchar; --NOMBRE FÍSICO DE LA FUNCIÓN
    g_separador                varchar(10); --Caracteres que servirán para separar el mensaje, nivel y origen del error
    
BEGIN


---*** INICIACIÓN DE VARIABLES 
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion := 'f_tal_sub_grupo_iud';
    g_privilegio_procedimiento := FALSE;
    g_respuesta := FALSE;
   
    ---*** OBTENCIÓN DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM tsg_metaproceso
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENCIÓN DEL ID DEL LUGAR ASIGNADO AL USUARIO
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
            g_reg_evento:= f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                 pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                 pm_codigo_procedimiento   ,pm_proc_almacenado);
            --DEVUELVE MENSAJE DE ERROR
            RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
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
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
    END IF;
    
    
      --*** EJECUCIÓN DEL PROCEDIMIENTO ESPECÍFICO
    IF pm_codigo_procedimiento = 'SG_METPRO_INS' THEN

        BEGIN
        	
            INSERT INTO tsg_metaproceso(
		id_subsistema,
		fk_id_metaproceso,
		nivel,
		nombre,
		codigo_procedimiento,
		nombre_achivo,
		ruta_archivo,
		fecha_registro,
		hora_registro,
		fecha_ultima_modificacion,
		hora_ultima_modificacion,
		descripcion,
		visible,
		habilitar_log,
		orden_logico,
		icono,
		nombre_tabla,
		prefijo,
		codigo_base,
		tipo_vista,
		con_ep,
		con_interfaz,
		num_datos_hijo
		        ) VALUES (
		 sg_id_subsistema,
		 sg_fk_id_metaproceso,
		 sg_nivel,
		 sg_nombre,
		 sg_codigo_procedimiento,
		 sg_nombre_achivo,
		 sg_ruta_archivo,
		 sg_fecha_registro,
		 sg_hora_registro,
		 sg_fecha_ultima_modificacion,
		 sg_hora_ultima_modificacion,
		 sg_descripcion,
		 sg_visible,
		 sg_habilitar_log,
		 sg_orden_logico,
		 sg_icono,
		 sg_nombre_tabla,
		 sg_prefijo,
		 sg_codigo_base,
		 sg_tipo_vista,
		 sg_con_ep,
		 sg_con_interfaz,
		sg_num_datos_hijo

            );   
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso en tsg_metaproceso';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
   
        END;
        
  --procedimiento de modificacion      
        
   ELSIF pm_codigo_procedimiento = 'SG_METPRO_UPD' THEN

        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM tsg_metaproceso
                          WHERE tsg_metaproceso.id_metaproceso=sg_id_metaproceso) THEN
                              
                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de tsg_metaprocesono existente';
                g_nivel_error := '4';
                g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;

            UPDATE tsg_metaproceso SET 
		id_subsistema=sg_id_subsistema,
		fk_id_metaproceso=sg_fk_id_metaproceso,
		nivel=sg_nivel,
		nombre=sg_nombre,
		codigo_procedimiento=sg_codigo_procedimiento,
		nombre_achivo=sg_nombre_achivo,
		ruta_archivo=sg_ruta_archivo,
		fecha_registro=sg_fecha_registro,
		hora_registro=sg_hora_registro,
		fecha_ultima_modificacion=sg_fecha_ultima_modificacion,
		hora_ultima_modificacion=sg_hora_ultima_modificacion,
		descripcion=sg_descripcion,
		visible=sg_visible,
		habilitar_log=sg_habilitar_log,
		orden_logico=sg_orden_logico,
		icono=sg_icono,
		nombre_tabla=sg_nombre_tabla,
		prefijo=sg_prefijo,
		codigo_base=sg_codigo_base,
		tipo_vista=sg_tipo_vista,
		con_ep=sg_con_ep,
		con_interfaz=sg_con_interfaz,
		num_datos_hijo=sg_num_datos_hijo

				WHERE tsg_metaproceso.id_metaproceso= sg_id_metaproceso;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificación exitosa en tsg_metaproceso';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
        ELSIF pm_codigo_procedimiento = 'SG_METPRO_DEL' THEN
        
    BEGIN
            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM tsg_metaproceso
                          WHERE tsg_metaproceso.id_metaproceso=sg_id_metaproceso) THEN
                              
                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: registro en tsg_metaproceso inexistente';
                g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;

 			-- VERIFICACIÓN DE EXISTENCIA DE HIJOS
         --   IF EXISTS(SELECT 1 FROM tsg_metaproceso
         --            INNER JOIN tal_id1 ON tsg_metaproceso.id_subgrupo = tal_id1.id_subgrupo
         --            WHERE tsg_metaproceso.id_metaproceso = sg_id_metaproceso) THEN
         --            
         --       g_nivel_error := '4';
         --       g_descripcion_log_error := 'Eliminación no realizada: El registro en tsg_metaproceso tiene regitros asociados en XXX';
         --       g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
         --      RETURN 'f'||g_separador||g_respuesta;
                
         --   END IF;   
         
         -- BORRADO DE DATO
            DELETE FROM tsg_metaproceso WHERE tsg_metaproceso.id_metaproceso = sg_id_metaproceso;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminación exitosa del registro en tsg_metaproceso';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;

    ELSE
        --PROCEDIMIENTO INEXISTENTE
        g_nivel_error := '2';
        g_descripcion_log_error := 'Procedimiento inexistente';
        g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
        
        --REGISTRA EL LOG
        g_reg_evento:= f_tsg_registro_evento(pm_id_usuario            ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                            pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                            pm_codigo_procedimiento   ,pm_proc_almacenado);
        --DEVUELVE MENSAJE DE ERROR
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
        
    END IF;

    ---*** REGISTRO EN EL LOG EL ÉXITO DE LA EJECUIÓN DEL PROCEDIMIENTO
    g_reg_evento:= f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);

    ---*** SE DEVUELVE LA RESPUESTA
    RETURN g_respuesta||g_separador||g_reg_evento;


EXCEPTION

    WHEN others THEN BEGIN

        --SE OBTIENE EL MENSAJE Y EL NÚMERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
        g_mensaje_error := SQLERRM ;
        g_numero_error := SQLSTATE;
    
        -- SE REGISTRA EL ERROR OCURRIDO
        g_reg_error:= f_tsg_registro_evento (pm_id_usuario            ,g_id_subsistema          ,g_id_lugar         ,g_mensaje_error,
                                             pm_ip_origen             ,pm_mac_maquina           ,'error'            ,g_numero_error,
                                             pm_codigo_procedimiento  ,pm_proc_almacenado);
                                             
        --SE DEVUELVE EL MENSAJE DE ERROR
        g_nivel_error := '1';
        g_descripcion_log_error := g_numero_error || ' - ' || g_mensaje_error;
        g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_error;         
    END;
    
END;
$body$
LANGUAGE 'plpgsql' VOLATILE CALLED ON NULL INPUT SECURITY INVOKER;