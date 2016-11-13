--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_tal_movimiento_proyecto_det_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_proyecto_mov_det integer,
  al_id_movimiento_proyecto integer,
  al_id_item integer,
  al_cantidad numeric,
  al_unidad_medida varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA Almacen ONLINE
***************************************************************************
 SCRIPT:          	alma.f_tal_movimiento_proyecto_det_iud
 DESCRIPCIÃ???N:     Realiza modificaciones en la tabla alma.tal_detalle_unidad_constructiva
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
    nombre_tabla					varchar;			
	g_registros_proyit				record;
    g_id_item						integer;
    g_unidad_medida					varchar(50);
BEGIN
---*** INICIACIÃ???N DE VARIABLES 
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funcion
    g_nombre_funcion :='f_tal_movimiento_proyecto_det_iud';
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
    IF pm_codigo_procedimiento = 'AL_DETPROYMOV_INS' THEN
    BEGIN
        --verificacion de duplicidad del item
        	if EXISTS (	select 1 from alma.tal_movimiento_proyecto_det det 
            			where det.id_item=al_id_item and det.id_movimiento_proyecto=al_id_movimiento_proyecto)
            then
            	raise exception '%','Error: el item seleccionado ('||al_id_item||') ya fue registrado.';
            end if;
        
        
		INSERT INTO alma.tal_movimiento_proyecto_det(
			id_item,  
            id_movimiento_proyecto,
            cantidad,
        	unidad_medida
            
        ) 
        VALUES (
            al_id_item,
            al_id_movimiento_proyecto,
			al_cantidad,
			al_unidad_medida    	
        );
            
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tal_movimiento_proyecte_det';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;   
        END;
    ELSIF pm_codigo_procedimiento = 'AL_DETPROYMOV_INS2' THEN
    BEGIN
    	
    	if al_id_movimiento_proyecto is not NULL
        then
                  INSERT INTO alma.tal_movimiento_proyecto_det(
                  id_item,  
                  id_movimiento_proyecto,
                  cantidad,
                  unidad_medida
                  
              ) 
              VALUES (
                  al_id_item,
                  al_id_movimiento_proyecto,
                  al_cantidad,
                  al_unidad_medida    	
              );
        	--DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'insercion existosa en alma.tal_movimiento_proyecto_det';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        else
        	raise exception '%','Error id_movimiento_proyecto no puede ser nulo  ';
        end if;
    END;   
    ELSIF pm_codigo_procedimiento = 'AL_ITPROY_INS' THEN
    BEGIN
    	raise notice '%',al_unidad_medida;
    	DELETE FROM alma.tmp_items_proyecto;
        nombre_tabla:='alma.tmp_items_proyecto';
       
        EXECUTE ('COPY '||nombre_tabla||' FROM '''||al_unidad_medida||''' DELIMITER '';'';'); 
      
    	FOR g_registros_proyit IN (select * from alma.tmp_items_proyecto)
        LOOP
        	IF (EXISTS(SELECT 1 FROM  alma.tal_item it  WHERE it.codigo=g_registros_proyit.cod_item))  AND (g_registros_proyit.cantidad > 0)
            THEN
            	SELECT it.id_item,um.nombre INTO g_id_item,g_unidad_medida 
                FROM alma.tal_item it 
                INNER JOIN param.tpm_unidad_medida_base um on um.id_unidad_medida_base=it.id_unidad_medida and um.estado_registro='activo'
                WHERE it.codigo=g_registros_proyit.cod_item;
                
                INSERT INTO alma.tal_movimiento_proyecto_det
                (id_item,		id_movimiento_proyecto,		cantidad,		unidad_medida)
                VALUES
                (g_id_item		,al_id_movimiento_proyecto,		g_registros_proyit.cantidad,		g_unidad_medida);
                
            ELSE
            	IF g_registros_proyit.cantidad < 0
                THEN
                	g_descripcion_log_error := 'El item : ' || g_registros_proyit.cod_item ||' , tiene cantidades negativas, favor verifique el archivo. ';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                END IF;
                    g_descripcion_log_error := 'Verifique que el item con codigo ' || g_registros_proyit.cod_item ||' este registrado en el sistema';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
            END IF;
        	
        END LOOP;
       
        -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
        g_descripcion_log_error := 'Registro exitoso del archivo: ' ||al_id_movimiento_proyecto;
        g_respuesta := 't'||g_separador||g_descripcion_log_error;
        
    END;   
  --procedimiento de modificacion      
	ELSIF pm_codigo_procedimiento = 'AL_DETPROYMOV_UPD' THEN
	BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
      
            
            IF NOT EXISTS (select 1 from alma.tal_movimiento_proyecto_det det where det.id_proyecto_mov_det=al_id_proyecto_mov_det) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_proyecto_mov_det || 'en la tabla alma.tal_movimiento_proyecto_det';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;
                     
                UPDATE alma.tal_movimiento_proyecto_det SET 
                	usuario_reg = "current_user"() ,
                	fecha_reg = now(),
                    id_item = al_id_item,
                    cantidad = al_cantidad,
                    unidad_medida = al_unidad_medida
				WHERE alma.tal_movimiento_proyecto_det.id_proyecto_mov_det = al_id_proyecto_mov_det;
                
			--control de duplicidad del item en una unidad constructiva
            select count(det.id_proyecto_mov_det) into g_cant
            from alma.tal_movimiento_proyecto_det det
            where det.id_item=al_id_item AND det.id_movimiento_proyecto=al_id_movimiento_proyecto;
            
            if g_cant > 1 then
            		raise exception '%','ERROR: El item seleccionado, no puede ser registrado mas de una vez.';
            end if;
            
			--DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa en alma.tal_movimiento_proyecto_det del registro '||  al_id_proyecto_mov_det;
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
        ELSIF pm_codigo_procedimiento = 'AL_DETPROYMOV_DEL' THEN
        
    	BEGIN
            --VERIFICACIÃ???N DE EXISTENCIA DEL REGISTRO
            
            IF NOT EXISTS(select 1 from alma.tal_movimiento_proyecto_det det where det.id_proyecto_mov_det=al_id_proyecto_mov_det) THEN
                              
                g_descripcion_log_error := 'Eliminacion no realizada: no existe el registro' || al_id_proyecto_mov_det || 'en la tabla alma.tal_movimiento_proyecto_det';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;
            
            DELETE FROM alma.tal_movimiento_proyecto_det  
			WHERE alma.tal_movimiento_proyecto_det.id_proyecto_mov_det = al_id_proyecto_mov_det;
                
 			
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_proyecto_mov_det||' en alma.tal_movimiento_proyecto_det';
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
	--control de unicidad y manejo del error en alma.tal_almacen.codigo
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