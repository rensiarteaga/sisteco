
	CREATE OR REPLACE FUNCTION "public"."f_tal_almacen_iud" (
		pm_id_usuario integer,
		pm_ip_origen varchar,
		pm_mac_maquina macaddr,
		pm_codigo_procedimiento varchar,
		pm_proc_almacenado varchar,
		al_id_almacen  int4,
		al_codigo  varchar,
		al_nombre  varchar,
		al_descripcion  varchar,
		al_direccion  varchar,
		al_via_fil_max  int4,
		al_via_col_max  int4,
		al_bloqueado  varchar,
		al_bloquear  varchar,
		al_cerrado  varchar,
		al_nro_prest_pendientes  int4,
		al_nro_ing_no_finalizados  int4,
		al_nro_sal_no_finalizadas  int4,
		al_observaciones  varchar,
		al_fecha_ultimo_inventario  date,
		al_fecha_reg  date,
		al_id_regional  int4
)
		RETURNS varchar AS
$body$



/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ALMACENES (ALMIN)
***************************************************************************
 SCRIPT: 		f_tal_almacen_iud
 DESCRIPCIÓN: 	Permite registrar en la tabla tal_almacen
 AUTOR: 		(generado automaticamente)
 FECHA:			2007-10-11 16:16:53
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
    IF pm_codigo_procedimiento = 'AL_ALMACE_INS' THEN

        BEGIN
        	
            INSERT INTO tal_almacen(
		codigo,
		nombre,
		descripcion,
		direccion,
		via_fil_max,
		via_col_max,
		bloqueado,
		bloquear,
		cerrado,
		nro_prest_pendientes,
		nro_ing_no_finalizados,
		nro_sal_no_finalizadas,
		observaciones,
		fecha_ultimo_inventario,
		fecha_reg,
		id_regional
		        ) VALUES (
		 al_codigo,
		 al_nombre,
		 al_descripcion,
		 al_direccion,
		 al_via_fil_max,
		 al_via_col_max,
		 al_bloqueado,
		 al_bloquear,
		 al_cerrado,
		 al_nro_prest_pendientes,
		 al_nro_ing_no_finalizados,
		 al_nro_sal_no_finalizadas,
		 al_observaciones,
		 al_fecha_ultimo_inventario,
		 now(),
		al_id_regional

            );   
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso en tal_almacen';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
   
        END;
        
  --procedimiento de modificacion      
        
   ELSIF pm_codigo_procedimiento = 'AL_ALMACE_UPD' THEN

        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM tal_almacen
                          WHERE tal_almacen.id_almacen=al_id_almacen) THEN
                              
                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de tal_almacenno existente';
                g_nivel_error := '4';
                g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;

            UPDATE tal_almacen SET 
		codigo=al_codigo,
		nombre=al_nombre,
		descripcion=al_descripcion,
		direccion=al_direccion,
		via_fil_max=al_via_fil_max,
		via_col_max=al_via_col_max,
		bloqueado=al_bloqueado,
		bloquear=al_bloquear,
		cerrado=al_cerrado,
		nro_prest_pendientes=al_nro_prest_pendientes,
		nro_ing_no_finalizados=al_nro_ing_no_finalizados,
		nro_sal_no_finalizadas=al_nro_sal_no_finalizadas,
		observaciones=al_observaciones,
		fecha_ultimo_inventario=al_fecha_ultimo_inventario,
		fecha_reg=al_fecha_reg,
		id_regional=al_id_regional

				WHERE tal_almacen.id_almacen= al_id_almacen;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificación exitosa en tal_almacen';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
        ELSIF pm_codigo_procedimiento = 'AL_ALMACE_DEL' THEN
        
    BEGIN
            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM tal_almacen
                          WHERE tal_almacen.id_almacen=al_id_almacen) THEN
                              
                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: registro en tal_almacen inexistente';
                g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;

 			-- VERIFICACIÓN DE EXISTENCIA DE HIJOS
         --   IF EXISTS(SELECT 1 FROM tal_almacen
         --            INNER JOIN tal_id1 ON tal_almacen.id_subgrupo = tal_id1.id_subgrupo
         --            WHERE tal_almacen.id_almacen = al_id_almacen) THEN
         --            
         --       g_nivel_error := '4';
         --       g_descripcion_log_error := 'Eliminación no realizada: El registro en tal_almacen tiene regitros asociados en XXX';
         --       g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
         --      RETURN 'f'||g_separador||g_respuesta;
                
         --   END IF;   
         
         -- BORRADO DE DATO
            DELETE FROM tal_almacen WHERE tal_almacen.id_almacen = al_id_almacen;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminación exitosa del registro en tal_almacen';
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