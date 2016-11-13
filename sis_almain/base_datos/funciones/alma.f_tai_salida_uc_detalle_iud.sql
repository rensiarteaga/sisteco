--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_tai_salida_uc_detalle_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_salida_uc_detalle integer,
  al_id_salida_uc integer,
  al_id_unidad_constructiva integer,
  al_cantidad numeric
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA Almacen ONLINE
***************************************************************************
 SCRIPT:          alma.f_tai_salida_uc_detalle_iud
 DESCRIPCI√??N:     Realiza modificaciones en la tabla alma.tai_fase
 AUTOR:           UNKNOW
 FECHA:           27-08-2013 17:10:00
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
    
    g_demasia_almacen				numeric;
    g_registros						record;	
    g_consulta                 		text; 
    g_id_salida_uc_det				integer; 
    g_cantidad						numeric;
    g_total_item_uc					numeric;							
   
BEGIN
---*** INICIACI√??N DE VARIABLES 
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funci√?¬≥n	
    g_nombre_funcion :='f_tai_salida_uc_detalle_iud';
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
    IF pm_codigo_procedimiento = 'AL_SALUCDET_INS' THEN
    BEGIN 	
                    
       	IF NOT EXISTS ( 	SELECT 1 
        				FROM alma.tai_detalle_unidad_constructiva b
                        WHERE b.id_unidad_constructiva like(al_id_unidad_constructiva) AND b.estado_registro='activo'
                        )
        THEN
        		g_descripcion_log_error := 'Insercion no realizada, verifique que la unidad constructiva seleccionada tenga el detalle de items correspondiente en el ultimo nodo del arbol';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta; 
        END IF;
        
        
		INSERT INTO alma.tai_salida_uc_detalle (
            id_salida_uc,id_unidad_constructiva,cantidad	
        ) VALUES (
        	al_id_salida_uc,al_id_unidad_constructiva,al_cantidad);
       
    	   
        select alm.demasia INTO g_demasia_almacen
        from alma.tai_salida_uc suc
        inner join alma.tai_almacen alm on alm.id_almacen=suc.id_almacen and alm.estado='activo'
        where suc.id_salida_uc = al_id_salida_uc;
        
        select max(alma.tai_salida_uc_detalle.id_salida_uc_detalle) into g_id_salida_uc_det
        from alma.tai_salida_uc_detalle;
        
        g_consulta:=' SELECT detuc.id_item,detuc.cantidad as cant_item_uc
                      FROM alma.tai_salida_uc_detalle sucd
                      INNER JOIN alma.tai_detalle_unidad_constructiva detuc ON detuc.id_unidad_constructiva=sucd.id_unidad_constructiva 
                      			 AND detuc.estado_registro=''activo''
                      WHERE sucd.id_unidad_constructiva like('||al_id_unidad_constructiva||')';
      
     
       IF(g_demasia_almacen IS NOT NULL )--incluye el porcentaje de  demasia del almacen a todos los items de la UC
        THEN
        	FOR g_registros IN EXECUTE (g_consulta)
            LOOP

            	g_total_item_uc:=g_registros.cant_item_uc*al_cantidad;
            	g_cantidad:=  g_total_item_uc + (	(g_demasia_almacen * g_total_item_uc)/100 );
            
            	INSERT INTO alma.tai_salida_uc_detalle_item(id_salida_uc_detalle,id_item,cantidad_salida_uc,cantidad_uc,demasia_almacen,cantidad_calculada)
                VALUES(g_id_salida_uc_det,g_registros.id_item,al_cantidad,g_registros.cant_item_uc,g_demasia_almacen,g_cantidad);
            END LOOP;
        ELSE
        	FOR g_registros IN EXECUTE (g_consulta) --descarta el % de demasia y se insertar el producto de la cantidad del item en la UC*al_cantidad cantidad de salida  de la UC
            LOOP
                        
            	g_total_item_uc:=g_registros.cant_item_uc*al_cantidad;
              
            	INSERT INTO alma.tai_salida_uc_detalle_item(id_salida_uc_detalle,id_item,cantidad_salida_uc,cantidad_uc,demasia_almacen,cantidad_calculada)
                VALUES(g_id_salida_uc_det,g_registros.id_item,al_cantidad,g_registros.cant_item_uc,g_demasia_almacen,g_total_item_uc);
                
            END LOOP;
        END IF;
        
        
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tai_salida_uc_detalle';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;   
        END;
        
  --procedimiento de modificacion      
	ELSIF pm_codigo_procedimiento = 'AL_SALUCDET_UPD' THEN
	BEGIN
            IF NOT EXISTS (SELECT 1 FROM alma.tai_salida_uc_detalle f WHERE f.id_salida_uc_detalle=al_id_salida_uc_detalle) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_salida_uc_detalle || 'en la tabla alma.tai_salida_uc_detalle';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;      
            END IF;
			
            IF NOT EXISTS ( SELECT 1 FROM alma.tai_salida_uc_detalle a 
        				INNER JOIN alma.tai_detalle_unidad_constructiva b ON a.id_unidad_constructiva=b.id_unidad_constructiva AND b.estado_registro='activo'
                        WHERE b.id_unidad_constructiva like(al_id_unidad_constructiva)
                        )
        	THEN
        		g_descripcion_log_error := 'Modificacion no realizada, verifique que la unidad constructiva seleccionada tenga el detalle de items correspondiente en el ultimo nodo del arbol';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta; 
        	END IF;
            
            --actualizacion de las cantidades y % de demasia en la tabla alma_tal_salida_uc_detalle_item
            --seleccion de items de acuerdo a la unidad constructiva actualizada
            g_consulta:=' SELECT detuc.id_item,detuc.cantidad as cant_item_uc
                          FROM alma.tai_salida_uc_detalle sucd
                          INNER JOIN alma.tai_detalle_unidad_constructiva detuc ON detuc.id_unidad_constructiva=sucd.id_unidad_constructiva 
                                     AND detuc.estado_registro=''activo''
                          WHERE sucd.id_unidad_constructiva like('||al_id_unidad_constructiva||')';
                          
            --seleccion del % de demasia de acuerdo al almacen relacionado
            select alm.demasia INTO g_demasia_almacen
            from alma.tai_salida_uc suc
            inner join alma.tai_almacen alm on alm.id_almacen=suc.id_almacen and alm.estado='activo'
            where suc.id_salida_uc = al_id_salida_uc;
			
            --id_salida_uc_detalle ya se lo envia con ese mismo nombre
            --inicio operacion de actualizacion de catidades item por item
            --falta actualizacion de los items en alma.tai_salida_uc_detalle_item por id_salida_uc_detalle e id_item
            IF g_demasia_almacen IS NOT NULL
            THEN
                --DELETE FROM alma.tai_salida_uc_detalle_item WHERE alma.tai_salida_uc_detalle_item.id_salida_uc_detalle = al_id_salida_uc_detalle;
            	FOR g_registros IN EXECUTE (g_consulta)
                LOOP
                	g_total_item_uc:=g_registros.cant_item_uc*al_cantidad;
            		g_cantidad:=  g_total_item_uc + (	(g_demasia_almacen * g_total_item_uc)/100	);
                    
                    UPDATE alma.tai_salida_uc_detalle_item
                    SET id_salida_uc_detalle = al_id_salida_uc_detalle,
                    	id_item = g_registros.id_item,
                        cantidad_salida_uc = al_cantidad,
                        cantidad_uc = g_registros.cant_item_uc,
                        demasia_almacen = g_demasia_almacen,
                        cantidad_calculada = g_cantidad,
                        usuario_reg = "current_user"(),
                		fecha_reg = now()
                    WHERE id_salida_uc_detalle = al_id_salida_uc_detalle AND id_item = g_registros.id_item;
                END LOOP;
            ELSE
            	FOR g_registros IN EXECUTE (g_consulta)
                LOOP
                	g_total_item_uc:=g_registros.cant_item_uc*al_cantidad;
                    
                    UPDATE alma.tai_salida_uc_detalle_item
                    SET id_salida_uc_detalle = al_id_salida_uc_detalle,
                    	id_item = g_registros.id_item,
                        cantidad_salida_uc = al_cantidad,
                        cantidad_uc = g_registros.cant_item_uc,
                        demasia_almacen = g_demasia_almacen,
                        cantidad_calculada = g_total_item_uc,
                        usuario_reg = "current_user"(),
                		fecha_reg = now()
                    WHERE id_salida_uc_detalle = al_id_salida_uc_detalle ;
                END LOOP;
            END IF;
            
            
            --update de la tabla alma.tai_salida_uc_detalle
             UPDATE alma.tai_salida_uc_detalle SET 
                	usuario_reg = "current_user"(),
                	fecha_reg = now(),
                    id_salida_uc = al_id_salida_uc,
                	id_unidad_constructiva = al_id_unidad_constructiva,
                    cantidad = al_cantidad
				WHERE alma.tai_salida_uc_detalle.id_salida_uc_detalle = al_id_salida_uc_detalle;
                
			
		-- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa en alma.tai_salida_uc_detalle del registro '||  al_id_salida_uc_detalle;
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
        ELSIF pm_codigo_procedimiento = 'AL_SALUCDET_DEL' THEN
        
    	BEGIN
        
            IF NOT EXISTS(SELECT 1 FROM  alma.tai_salida_uc_detalle f WHERE f.id_salida_uc_detalle=al_id_salida_uc_detalle) THEN
                              
                g_descripcion_log_error := 'Eliminacion no realizada: no existe el registro ' || al_id_salida_uc_detalle || ' en la tabla alma.tai_salida_uc_detalle';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;
			
            IF EXISTS(select 1 from alma.tai_salida_uc_detalle_item b where b.id_salida_uc_detalle= al_id_salida_uc_detalle)
            THEN
            		DELETE FROM alma.tai_salida_uc_detalle_item WHERE id_salida_uc_detalle =al_id_salida_uc_detalle;
                    
                    DELETE FROM alma.tai_salida_uc_detalle 
                  	WHERE alma.tai_salida_uc_detalle.id_salida_uc_detalle = al_id_salida_uc_detalle;
            ELSE  
                  DELETE FROM alma.tai_salida_uc_detalle 
                  WHERE alma.tai_salida_uc_detalle.id_salida_uc_detalle = al_id_salida_uc_detalle;
            END IF;
                
 			
            -- DESCRIPCI√??N DE √??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_salida_uc_detalle||' en alma.tai_salida_uc_detalle';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
        ELSIF pm_codigo_procedimiento = 'AL_SALUCDETITEM_UPD' THEN
         BEGIN
         	--en al_id_salida_uc_detalle se envia el id de la tabla alma.tai_salida_uc_detalle_item
         	--en al_cantidad se envia el % demasia de la tabla alma.tai_salida_uc_detalle_item
            
         	if NOT EXISTS( SELECT 1 FROM alma.tai_salida_uc_detalle_item a where a.id_salida_uc_detalle_item = al_id_salida_uc_detalle )
            then
            	g_descripcion_log_error := 'Modificacion no realizada: el registro seleccionado '||al_id_salida_uc_detalle||' no existe';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            end if;
            
			select a.cantidad_salida_uc,a.cantidad_uc into g_registros 
            from alma.tai_salida_uc_detalle_item a 
            where a.id_salida_uc_detalle_item = al_id_salida_uc_detalle;
        
        	g_total_item_uc:=g_registros.cantidad_salida_uc*g_registros.cantidad_uc;
            g_cantidad:=  g_total_item_uc + (	(al_cantidad * g_total_item_uc)/100	);
        	
        
            UPDATE alma.tai_salida_uc_detalle_item
            SET demasia_almacen = al_cantidad,
            	cantidad_calculada = g_cantidad,
                usuario_reg = "current_user"(),
                fecha_reg = now()
                
            WHERE alma.tai_salida_uc_detalle_item.id_salida_uc_detalle_item = al_id_salida_uc_detalle;
              
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Actualizacion exitosa del registro '||al_id_salida_uc_detalle||' en alma.tai_salida_uc_detalle_item';
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