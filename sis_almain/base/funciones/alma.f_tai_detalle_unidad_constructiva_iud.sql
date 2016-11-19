--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_tai_detalle_unidad_constructiva_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_detalle_unidad_constructiva integer,
  al_id_unidad_constructiva integer,
  al_id_item integer,
  al_cantidad numeric,
  al_descripcion varchar,
  al_orden integer
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA Almacen ONLINE
***************************************************************************
 SCRIPT:          	alma.f_tai_detalle_unidad_constructiva_iud
 DESCRIPCIÃ???N:     Realiza modificaciones en la tabla alma.tai_detalle_unidad_constructiva
 AUTOR:           	UNKNOW
 FECHA:           	14-08-2014
 COMENTARIOS:    
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCIÃ???N:  
 AUTOR:          
 FECHA:           

***************************************************************************/

--------------------------
-- CUERPO DE LA FUNCIÃ????N --
--------------------------

-- PARÃ??Ã?ÂÃ??Ã?ÂMETROS FIJOS
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

-- PARÃ??Ã?ÂÃ??Ã?ÂMETROS VARIABLES
/*
cb_id_almacen
cb_id_sucursal
cb_id_usuario
cb_estado
*/

-- DECLARACIÃ???N DE VARIABLES PARTICULARES

--**** DECLARACION DE VARIABLES DE LA FUNCIÃ???N (LOCALES) ****---


DECLARE

    --PARAMETROS FIJOS

    g_id_subsistema               integer;     -- ID SUBSISTEMA
    g_id_lugar                    integer;     -- ID LUGAR
    g_numero_error                varchar;     -- ALMACENA EL NÃ???MERO DE ERROR
    g_mensaje_error               varchar;     -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento    boolean;     -- BANDERA PARA VERIFICAR LLAMADA DE LA FUNCIÃ???N
    g_descripcion_log_error       text;        -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento                  varchar; 
    g_reg_error                	  varchar; 
    g_respuesta                   varchar;     -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCIÃ???N
    g_nivel_error                 varchar;     -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                               --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                               --      ERROR LÃ???GICO (CRÃ??Ã?ÂTICO) = 2
                                               --      ERROR LÃ???GICO (INTERMEDIO) = 3
                                               --      ERROR LÃ???GICO (ADVERTENCIA) = 4
    
    g_nombre_funcion              varchar;     -- NOMBRE FÃ??Ã?ÂSICO DE LA FUNCIÃ???N
    g_separador                   varchar(10); -- SEPARADOR DE CADENAS
    g_estado						varchar;
    g_cant							integer;
    nro_linea						integer;
    nro_linea_act					integer;
    id_uc							integer;

BEGIN
---*** INICIACIÃ???N DE VARIABLES 
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funcion
    g_nombre_funcion :='f_tai_detalle_unidad_constructiva_iud';
    g_privilegio_procedimiento := FALSE;
    g_respuesta := FALSE;
   
    ---*** OBTENCIÃ???N DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENCIÃ???N DEL ID DEL LUGAR ASIGNADO AL USUARIO
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


    ---*** VERIFICACIÃ???N DE PERMISOS DEL USUARIO
    IF NOT g_privilegio_procedimiento THEN
       g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;

---*** SI NO SE TIENE PERMISOS DE EJECUCIÃ???N SE RETORNA EL MENSAJE DE ERROR
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
    
    
      --*** EJECUCION DEL PROCEDIMIENTO ESPECIFICADO
    IF pm_codigo_procedimiento = 'AL_DETUNICONS_INS' THEN
    BEGIN
    	--control para que el detalle de un unidad constructiva sea registrado solamente en el ultimo nodo
        if EXISTS (select 1 from alma.tai_unidad_constructiva uc where uc.id_unidad_constructiva_fk = al_id_unidad_constructiva)
        then
        	raise exception '%','Error: El registro solo es permitido en las ramas de la estructura y no en los nodos.'||chr(10)||'Verifique que el nodo este en su ultimo nivel al desplegarse.';
        else
        --verificacion de duplicidad del item
        	if EXISTS (select 1 from alma.tai_detalle_unidad_constructiva det where det.id_item=al_id_item and det.id_unidad_constructiva=al_id_unidad_constructiva)then
            	raise exception '%','Error: el item seleccionado ('||al_id_item||') ya fue registrado en el nodo.';
            end if;
        end if;
        
        IF EXISTS(select 1 from alma.tai_detalle_unidad_constructiva where alma.tai_detalle_unidad_constructiva.id_unidad_constructiva = al_id_unidad_constructiva)
        THEN
        	IF NOT EXISTS(select 1 from alma.tai_detalle_unidad_constructiva where alma.tai_detalle_unidad_constructiva.id_unidad_constructiva = al_id_unidad_constructiva 
            AND alma.tai_detalle_unidad_constructiva.orden = al_orden AND al_orden > 0)
            THEN
            	 	g_descripcion_log_error := 'Inserción no realizada: no existe la Linea Nro. '||al_orden;
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta; 
            END IF;
            nro_linea := al_orden;
        ELSE
        	nro_linea:= 0;
        END IF;
        
        UPDATE alma.tai_detalle_unidad_constructiva
        SET orden = orden + 1
        WHERE id_unidad_constructiva=al_id_unidad_constructiva AND orden >= al_orden + 1;
        
		INSERT INTO alma.tai_detalle_unidad_constructiva(
            id_unidad_constructiva,
			id_item,  
            cantidad,
        	descripcion,
            estado_registro
            ,orden 	
        ) 
        VALUES (
            al_id_unidad_constructiva,
            al_id_item,
			al_cantidad,
			al_descripcion,
			'activo'
            ,nro_linea + 1    	
        );
            
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tai_detalle_unidad_constructiva';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;   
        END;
        
    ELSIF pm_codigo_procedimiento = 'AL_DETUNICONS_INSITEM'
    THEN
      BEGIN
            --añadir control para seleccionar el orden maximo, de acuerdo a una unidad constructiva      
      		IF EXISTS(	select 1 
            			from alma.tai_detalle_unidad_constructiva 
                        where id_unidad_constructiva = al_id_unidad_constructiva 
            		)
            THEN
            	/*update alma.tai_detalle_unidad_constructiva
                set cantidad = cantidad + al_cantidad
                where id_unidad_constructiva = al_id_unidad_constructiva AND id_item = al_id_item;*/
                
                SELECT max(orden) INTO nro_linea
            	FROM alma.tai_detalle_unidad_constructiva
            	WHERE  id_unidad_constructiva = al_id_unidad_constructiva;
                
                INSERT INTO alma.tai_detalle_unidad_constructiva(
                	id_unidad_constructiva
                    ,id_item
                    ,cantidad
                    ,descripcion
                    ,estado_registro
                    ,orden)
                VALUES(
                	al_id_unidad_constructiva
                    ,al_id_item
                    ,al_cantidad
                    ,''
                    ,'activo'
                    ,nro_linea + 1
                );
            ELSE
            	nro_linea:=1;
                
            	INSERT INTO alma.tai_detalle_unidad_constructiva(
                	id_unidad_constructiva
                    ,id_item
                    ,cantidad
                    ,descripcion
                    ,estado_registro
                    ,orden)
                VALUES(
                	al_id_unidad_constructiva
                    ,al_id_item
                    ,al_cantidad
                    ,''
                    ,'activo'
                    ,nro_linea
                );
            
            END IF;
            
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tai_detalle_unidad_constructiva';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;   
      END;
      
  --procedimiento de modificacion      
	ELSIF pm_codigo_procedimiento = 'AL_DETUNICONS_UPD' THEN
	BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO            
            IF NOT EXISTS (select 1 from alma.tai_detalle_unidad_constructiva det where det.id_unidad_constructiva=al_id_unidad_constructiva) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_detalle_unidad_constructiva || 'en la tabla alma.tai_detalle_unidad_constructiva';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;
            --INICIO CONDICION DE ORDENAMIENTO SEGUN EL CAMPO ORDEN DE TAL_DETALLE_UNIDAD_CONSTRUCTIVA
            IF NOT EXISTS(select 1 from alma.tai_detalle_unidad_constructiva where alma.tai_detalle_unidad_constructiva.id_unidad_constructiva = al_id_unidad_constructiva 
            AND alma.tai_detalle_unidad_constructiva.orden = al_orden AND al_orden > 0)
            THEN
            	 	g_descripcion_log_error := 'Actualizacion no realizada: no existe la Linea Nro. '||al_orden;
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta; 
            END IF;	
            
            SELECT det.orden INTO nro_linea
            FROM alma.tai_detalle_unidad_constructiva det
            WHERE det.id_detalle_unidad_constructiva=al_id_detalle_unidad_constructiva;
            
            nro_linea_act := al_orden;
            
    		IF al_orden < nro_linea
            THEN
            		--actualizacion nros_linea >= nro_linea_actual (fila enviada a actualizar)
            		UPDATE alma.tai_detalle_unidad_constructiva SET
                    orden = orden - 1
                    WHERE alma.tai_detalle_unidad_constructiva.id_unidad_constructiva=al_id_unidad_constructiva
                    	  AND  orden >= nro_linea;
                    --actualizacion nros_linea > nro_linea_actual
                    UPDATE alma.tai_detalle_unidad_constructiva SET
                    orden = orden + 1
                    WHERE alma.tai_detalle_unidad_constructiva.id_unidad_constructiva = al_id_unidad_constructiva
                    		AND orden > al_orden AND id_detalle_unidad_constructiva <> al_id_detalle_unidad_constructiva;
                            
                    nro_linea_act := al_orden + 1;
            END IF;
            
            IF al_orden > nro_linea
            THEN
            		UPDATE alma.tai_detalle_unidad_constructiva SET
                    orden = orden - 1
                    WHERE alma.tai_detalle_unidad_constructiva.id_unidad_constructiva=al_id_unidad_constructiva
                          AND orden > nro_linea;
                    
                    UPDATE alma.tai_detalle_unidad_constructiva SET
                    orden = orden + 1
                    WHERE alma.tai_detalle_unidad_constructiva.id_unidad_constructiva=al_id_unidad_constructiva
                    	  AND orden>=al_orden;
            END IF;
            
            --fin condicionordenamiento   
            
                UPDATE alma.tai_detalle_unidad_constructiva SET 
                	usuario_reg = "current_user"() ,
                	fecha_reg = now(),
                    id_unidad_constructiva=al_id_unidad_constructiva,
                    id_item = al_id_item,
                    cantidad = al_cantidad,
                    descripcion = al_descripcion
                    ,orden = nro_linea_act
				WHERE alma.tai_detalle_unidad_constructiva.id_detalle_unidad_constructiva = al_id_detalle_unidad_constructiva;
                
			--control de duplicidad del item en una unidad constructiva
            select count(detuc.id_detalle_unidad_constructiva) into g_cant
            from alma.tai_detalle_unidad_constructiva detuc
            where detuc.id_item=al_id_item AND detuc.id_unidad_constructiva=al_id_unidad_constructiva;
            
            if g_cant > 1 then
            		raise exception '%','ERROR: El item seleccionado ya fue registrado en la unidad constructiva.';
            end if;
            
			--DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa en alma.tai_almacen del registro '||  al_id_detalle_unidad_constructiva;
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
        ELSIF pm_codigo_procedimiento = 'AL_DETUNICONS_DEL' THEN
        
    	BEGIN
            --VERIFICACIÃ???N DE EXISTENCIA DEL REGISTRO
            
            IF NOT EXISTS(select 1 from alma.tai_detalle_unidad_constructiva det where det.id_detalle_unidad_constructiva=al_id_detalle_unidad_constructiva) THEN
                              
                g_descripcion_log_error := 'Eliminacion no realizada: no existe el registro' || al_id_unidad_constructiva || 'en la tabla alma.tai_detalle_unidad_constructiva';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;
            
            SELECT det.orden,det.id_unidad_constructiva INTO nro_linea,id_uc
            FROM alma.tai_detalle_unidad_constructiva det
            WHERE det.id_detalle_unidad_constructiva = al_id_detalle_unidad_constructiva;
            
            DELETE FROM alma.tai_detalle_unidad_constructiva  
			WHERE alma.tai_detalle_unidad_constructiva.id_detalle_unidad_constructiva = al_id_detalle_unidad_constructiva;
            
            UPDATE alma.tai_detalle_unidad_constructiva SET
            orden = orden -1
            WHERE alma.tai_detalle_unidad_constructiva.id_unidad_constructiva = id_uc AND orden >= nro_linea;               
 			
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_detalle_unidad_constructiva||' en alma.tai_detalle_unidad_constructiva';
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

    ---*** REGISTRO EN EL LOG EL Ã???XITO DE LA EJECUIÃ???N DEL PROCEDIMIENTO
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);

    ---*** SE DEVUELVE LA RESPUESTA
    RETURN g_respuesta||g_separador||g_reg_evento;


EXCEPTION
	--control de unicidad y manejo del error en alma.tai_almacen.codigo
    WHEN unique_violation
    THEN
    BEGIN
    			g_descripcion_log_error := 'Modificacion no realizada: el codigo de almacen  '||al_codigo ||'  ya existe.';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
    END;
    WHEN others THEN BEGIN

        --SE OBTIENE EL MENSAJE Y EL NÃ???MERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
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