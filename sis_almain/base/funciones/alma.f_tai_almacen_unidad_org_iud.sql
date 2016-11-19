--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_tai_almacen_unidad_org_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_almacen_uo integer,
  al_id_almacen integer,
  al_id_uo integer,
  al_fecha_desde date,
  al_fecha_hasta date
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA Almacen 
***************************************************************************
 SCRIPT:          alma.f_tai_almacen_unidad_org_iud
 DESCRIPCI√??N:     Realiza modificaciones en la tabla alma.tai_almacen_unidad_org
 AUTOR:           UNKNOWS
 FECHA:          
 COMENTARIOS:    
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCI√??N:  
 AUTOR:           UNKNOW
 FECHA:           02-12-2014

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

-- PAR√?¬Å√?¬ÅMETROS VARIABLES
/*
cb_id_almacen_item
cb_id_sucursal
cb_id_usuario
cb_estado
*/

-- DECLARACI√??N DE VARIABLES PARTICULARES

--**** DECLARACION DE VARIABLES DE LA FUNCI√??N (LOCALES) ****---


DECLARE

    --PAR√?¬ÅMETROS FIJOS

    g_id_subsistema               integer;     -- ID SUBSISTEMA
    g_id_lugar                    integer;     -- ID LUGAR
    g_numero_error                varchar;     -- ALMACENA EL N√??MERO DE ERROR
    g_mensaje_error               varchar;     -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento    boolean;     -- BANDERA PARA VERIFICAR LLAMADA DE LA FUNCI√??N
    g_descripcion_log_error       text;        -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento                  varchar; 
    g_reg_error                	  varchar; 
    g_respuesta                   varchar;     -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCI√??N
    g_nivel_error                 varchar;     -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                               --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                               --      ERROR L√??GICO (CR√?¬çTICO) = 2
                                               --      ERROR L√??GICO (INTERMEDIO) = 3
                                               --      ERROR L√??GICO (ADVERTENCIA) = 4
    
    g_nombre_funcion              varchar;     -- NOMBRE F√?¬çSICO DE LA FUNCI√??N
    g_separador                   varchar(10); -- SEPARADOR DE CADENAS
   
BEGIN
---*** INICIACI√??N DE VARIABLES 
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funci√?¬≥n	
    g_nombre_funcion :='f_tai_almacen_unidad_org_iud';
    g_privilegio_procedimiento := FALSE;
    g_respuesta := FALSE;
   
    ---*** OBTENCI√??N DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENCI√??N DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT tsg_usuario_lugar.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar
    WHERE  tsg_usuario_lugar.id_usuario = pm_id_usuario;
    
    
     ---*** VALIDACI√??N DE LLAMADA POR USUARIO O FUNCIO?N
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


    ---*** VERIFICACI√??N DE PERMISOS DEL USUARIO
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
    
    
      --*** EJECUCI√??N DEL PROCEDIMIENTO ESPECI¬çFICO
    IF pm_codigo_procedimiento = 'AL_ALMUO_INS' THEN
    BEGIN
        --verificacion de duplicidad del codigo de fase
        IF EXISTS(SELECT 1 FROM alma.tai_almacen_unidad_org a where a.id_almacen = al_id_almacen and a.id_unidad_organizacional = al_id_uo and a.estado = 'activo')
        THEN
        	 	g_descripcion_log_error := 'Insercion no realizada, La unidad Organizacional ya fue registrada en el almacen';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
        END IF;
    	
    
		INSERT INTO alma.tai_almacen_unidad_org (
            id_almacen,
            id_unidad_organizacional, 
            fecha_desde,
        	fecha_hasta	
        ) VALUES (
            al_id_almacen,
            al_id_uo,
           	al_fecha_desde,
			al_fecha_hasta
        );
            
            -- DESCRIPCI√??N DE √??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tai_almacen_unidad_org';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;   
        END;
        
  --procedimiento de modificacion      
	ELSIF pm_codigo_procedimiento = 'AL_ALMUO_UPD' THEN
	BEGIN
    		IF NOT EXISTS (select 1 from alma.tai_almacen_unidad_org a where a.id_almacen_unidad_org = al_id_almacen_uo)
            THEN
            	g_descripcion_log_error := 'Modificacion no realizada: el registro' || al_id_almacen_uo || ' no fue encontrado en la tabla alma.tai_fase';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;   
            END IF;		
    
            IF EXISTS (SELECT 1 FROM alma.tai_almacen_unidad_org a where a.id_almacen = al_id_almacen AND a.id_unidad_organizacional = al_id_uo AND a.estado='activo' AND a.id_almacen_unidad_org != al_id_almacen_uo) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada: La unidad Organizacional ya fue registrada en el almacen';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;      
            END IF;

                UPDATE alma.tai_almacen_unidad_org SET 
                	usuario_reg = "current_user"(),
                	fecha_reg = now(),
                    id_almacen = al_id_almacen,
                    id_unidad_organizacional = al_id_uo,
                    fecha_desde = al_fecha_desde,
                    fecha_hasta = al_fecha_hasta

				WHERE alma.tai_almacen_unidad_org.id_almacen_unidad_org = al_id_almacen_uo;
                
			
		-- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa en alma.tai_fase del registro '||  al_id_almacen_uo;
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
        ELSIF pm_codigo_procedimiento = 'AL_ALMUO_DEL' THEN
        
    	BEGIN
        
            IF NOT EXISTS(SELECT 1 FROM  alma.tai_almacen_unidad_org f WHERE f.id_almacen_unidad_org = al_id_almacen_uo) THEN
                              
                g_descripcion_log_error := 'Eliminacion no realizada: no existe el registro ' || al_id_almacen_uo || ' en la tabla alma.tai_almacen_unidad_org';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;
            
 
        	/*IF EXISTS(SELECT 1 FROM alma.tai_almacen_unidad_org ft WHERE ft.id_fase=al_id_fase)
            THEN
            	g_descripcion_log_error := 'Eliminacion no realizada, la fase seleccionada ' || al_id_fase || ' tiene elementos dependientes en el detalle';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;*/
              
            UPDATE alma.tai_almacen_unidad_org
            SET estado = 'inactivo',
            fecha_reg = now(),
            usuario_reg = "current_user"()
            WHERE alma.tai_almacen_unidad_org.id_almacen_unidad_org = al_id_almacen_uo;
                
 			
            -- DESCRIPCI√??N DE √??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_almacen_uo||' en alma.tai_almacen_unidad_org';
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

    ---*** REGISTRO EN EL LOG EL √??XITO DE LA EJECUI√??N DEL PROCEDIMIENTO
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);

    ---*** SE DEVUELVE LA RESPUESTA
    RETURN g_respuesta||g_separador||g_reg_evento;


EXCEPTION

    WHEN others THEN BEGIN

        --SE OBTIENE EL MENSAJE Y EL N√??MERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
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