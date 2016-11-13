--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_tal_movimiento_proyecto_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_movimiento_proyecto integer,
  al_id_almacen integer,
  al_id_tipo_movimiento integer,
  al_fecha_ingreso timestamp,
  al_origen_ingreso varchar,
  al_id_contratista integer,
  al_id_proveedor integer,
  al_id_empleado integer,
  al_id_institucion integer,
  al_concepto_ingreso varchar,
  al_observaciones varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA Almacen 
***************************************************************************
 SCRIPT:          alma.f_tal_movimiento_proyecto_iud
 DESCRIPCION:     Realiza modificaciones en la tabla alma.tal_movimiento_proyecto
 AUTOR:           UNKNOW
 FECHA:           23-10-2014
 COMENTARIOS:    
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCION:  
 AUTOR:           
 FECHA:          

***************************************************************************/

--------------------------
-- CUERPO DE LA FUNCION --
--------------------------

-- PARÂMETROS FIJOS
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

-- PARAÃ?ÂMETROS VARIABLES
/*
cb_id_movimiento
cb_id_sucursal
cb_id_usuario
cb_estado
*/

-- DECLARACION DE VARIABLES PARTICULARES

--**** DECLARACION DE VARIABLES DE LA FUNCION (LOCALES) ****---


DECLARE

    --PARAMETROS FIJOS

    g_id_subsistema               integer;     -- ID SUBSISTEMA
    g_id_lugar                    integer;     -- ID LUGAR
    g_numero_error                varchar;     -- ALMACENA EL NÃ????MERO DE ERROR
    g_mensaje_error               varchar;     -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento    boolean;     -- BANDERA PARA VERIFICAR LLAMADA DE LA FUNCIÃ????N
    g_descripcion_log_error       text;        -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento                  varchar; 
    g_reg_error                	  varchar; 
    g_respuesta                   varchar;     -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCIÃ????N
    g_nivel_error                 varchar;     -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                               --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                               --      ERROR LÃ????GICO (CRÃ???Ã??Ã?ÂTICO) = 2
                                               --      ERROR LÃ????GICO (INTERMEDIO) = 3
                                               --      ERROR LÃ????GICO (ADVERTENCIA) = 4
    
    g_nombre_funcion              	varchar;     -- NOMBRE FÃ???Ã??Ã?ÂSICO DE LA FUNCIÃ????N
    g_separador                   	varchar(10); -- SEPARADOR DE CADENAS
    g_id_movimiento					integer;
    g_estado						varchar;
	
BEGIN
---*** INICIACION DE VARIABLES 
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funcion	
    g_nombre_funcion :='f_tal_movimiento_iud';
    g_privilegio_procedimiento := FALSE;
    g_respuesta := FALSE;
   
    ---*** OBTENCION DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENC?ION DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT tsg_usuario_lugar.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar
    WHERE  tsg_usuario_lugar.id_usuario = pm_id_usuario;
    
    
     ---*** VALIDACION DE LLAMADA POR USUARIO O FUNCION
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

    ---*** VERIFICACIÃ????N DE PERMISOS DEL USUARIO
    IF NOT g_privilegio_procedimiento THEN
       g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;

---*** SI NO SE TIENE PERMISOS DE EJECUCION SE RETORNA EL MENSAJE DE ERROR
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
    
    
      --*** EJECUCION DEL PROCEDIMIENTO ESPECIFICO
    IF pm_codigo_procedimiento = 'AL_MOVPROY_INS' THEN
    	BEGIN
        
    		INSERT INTO alma.tal_movimiento_proyecto
            (id_almacen,		id_tipo_movimiento,		fecha_ingreso,		origen_ingreso
            ,id_contratista		,id_proveedor			,id_empleado		,id_institucion
            ,concepto_ingreso	,observaciones			,estado	)
            VALUES
            (al_id_almacen		,al_id_tipo_movimiento	,al_fecha_ingreso	,al_origen_ingreso 
            ,al_id_contratista	,al_id_proveedor		,al_id_empleado		,al_id_institucion
            ,al_concepto_ingreso	,al_observaciones	,'borrador'
            );
            
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tal_movimiento_proyecto';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;   
    	END;
        
  --procedimiento de modificacion      
	ELSIF pm_codigo_procedimiento = 'AL_MOVPROY_UPD' THEN
	BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
      
            
            IF NOT EXISTS (select 1 from alma.tal_movimiento_proyecto  where alma.tal_movimiento_proyecto.id_movimiento_proyecto=al_id_movimiento_proyecto) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_movimiento_proyecto || 'en la tabla alma.tal_movimiento_proyecto';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;               
            END IF;
                     
    
                UPDATE alma.tal_movimiento_proyecto SET 
                	usuario_reg = "current_user"() ,
                	fecha_reg = now(),
                    id_tipo_movimiento=al_id_tipo_movimiento,
                    fecha_ingreso = al_fecha_ingreso,
                    origen_ingreso = al_origen_ingreso,
                    id_contratista =al_id_contratista,
                    id_proveedor = al_id_proveedor,
                    id_empleado = al_id_empleado,
                    id_institucion = al_id_institucion,
                    concepto_ingreso = al_concepto_ingreso,
                    observaciones = al_observaciones                    
				WHERE alma.tal_movimiento_proyecto.id_movimiento_proyecto = al_id_movimiento_proyecto;
                        
			--DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa en alma.tal_movimiento_proyecto del registro '||  al_id_movimiento_proyecto;
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;  
     ELSIF pm_codigo_procedimiento = 'AL_MOVPROY_DEL' THEN
        
    	BEGIN
            --VERIFICACIÃ???N DE EXISTENCIA DEL REGISTRO
            
            IF NOT EXISTS(select 1 from alma.tal_movimiento_proyecto where alma.tal_movimiento_proyecto.id_movimiento_proyecto=al_id_movimiento_proyecto) THEN
                              
                g_descripcion_log_error := 'Eliminacion no realizada: no existe el registro' || al_id_movimiento_proyecto || 'en la tabla alma.tal_movimiento_proyecto';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;
            
            DELETE FROM alma.tal_movimiento_proyecto  
			WHERE alma.tal_movimiento_proyecto.id_movimiento_proyecto = al_id_movimiento_proyecto;
                
 			
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_movimiento_proyecto||' en alma.tal_movimiento_proyecto';
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

    ---*** REGISTRO EN EL LOG EL EXITO DE LA EJECUCION DEL PROCEDIMIENTO
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);

    ---*** SE DEVUELVE LA RESPUESTA
    RETURN g_respuesta||g_separador||g_reg_evento;

EXCEPTION

    WHEN others THEN BEGIN

        --SE OBTIENE EL MENSAJE Y EL NUMERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
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