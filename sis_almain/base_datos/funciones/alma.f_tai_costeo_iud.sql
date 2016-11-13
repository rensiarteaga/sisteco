--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_tai_costeo_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_costeo integer,
  al_fecha_ingreso date,
  al_fecha_salida date,
  al_estado varchar,
  al_descripcion varchar,
  al_id_almacen integer,
  al_id_mov_proyecto integer,
  al_tipo_costeo varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA Almacen
 COMENTARIOS:    
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCION:  
 AUTOR:          
 FECHA:          

***************************************************************************/

--------------------------
-- CUERPO DE LA FUNCI√????N --
--------------------------

-- PAR√??√?¬Å√??√?¬ÅMETROS FIJOS
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

-- PAR√??√?¬Å√??√?¬ÅMETROS VARIABLES
/*
cb_id_almacen
cb_id_sucursal
cb_id_usuario
cb_estado
*/

-- DECLARACI√???N DE VARIABLES PARTICULARES

--**** DECLARACION DE VARIABLES DE LA FUNCI√???N (LOCALES) ****---


DECLARE

    --PARAMETROS FIJOS

    g_id_subsistema               integer;     -- ID SUBSISTEMA
    g_id_lugar                    integer;     -- ID LUGAR
    g_numero_error                varchar;     -- ALMACENA EL N√???MERO DE ERROR
    g_mensaje_error               varchar;     -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento    boolean;     -- BANDERA PARA VERIFICAR LLAMADA DE LA FUNCI√???N
    g_descripcion_log_error       text;        -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento                  varchar; 
    g_reg_error                	  varchar; 
    g_respuesta                   varchar;     -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCI√???N
    g_nivel_error                 varchar;     -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                               --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                               --      ERROR L√???GICO (CR√??√?¬çTICO) = 2
                                               --      ERROR L√???GICO (INTERMEDIO) = 3
                                               --      ERROR L√???GICO (ADVERTENCIA) = 4
    
    g_nombre_funcion              varchar;     -- NOMBRE F√??√?¬çSICO DE LA FUNCI√???N
    g_separador                   varchar(10); -- SEPARADOR DE CADENAS
    g_id_almacen					integer;
    g_estado					varchar;
    g_cant							integer;
    
    g_resultado					varchar;
    g_id_proyecto				integer;
  

BEGIN
---*** INICIACI√???N DE VARIABLES 
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funcion
    g_nombre_funcion :='f_tai_almacen_iud';
    g_privilegio_procedimiento := FALSE;
    g_respuesta := FALSE;
   
    ---*** OBTENCI√???N DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENCI√???N DEL ID DEL LUGAR ASIGNADO AL USUARIO
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


    ---*** VERIFICACI√???N DE PERMISOS DEL USUARIO
    IF NOT g_privilegio_procedimiento THEN
       g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;

---*** SI NO SE TIENE PERMISOS DE EJECUCI√???N SE RETORNA EL MENSAJE DE ERROR
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
    IF pm_codigo_procedimiento = 'AL_COSTEO_INS' THEN
    BEGIN
    	if EXISTS(select 1 from alma.tai_costeo c where c.id_almacen=al_id_almacen AND c.id_movimiento_proyecto = al_id_mov_proyecto)
        then
         		g_descripcion_log_error := 'Insercion no realizada: el proyecto seleccionado' || al_id_mov_proyecto || ' ya fue registrado anteriormente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
        end if;
        
        IF EXISTS (SELECT 1 FROM alma.tai_costeo cos WHERE cos.id_movimiento_proyecto = al_id_mov_proyecto )
        THEN
        		g_descripcion_log_error := 'Insercion no realizada: Solo puede registrarse un costeo por proyecto';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
        END IF;
        
        --control de verificacion del costeo que se registra
        /*
        1.- si al_tipo_costeo = 'peso'
          1.1.- verificar que todos los items relacionados a al_id_mov_proyecto tengan registrado un peso
        2.- si al_tipo_costeo = 'precio_unitario'
          2.1.- verificar que todos los items relacionados a al_id_mov_proyecto tengan registrado un precio unitario
        */
        IF al_tipo_costeo = 'peso' THEN
        
            IF EXISTS(		select 1
                            from alma.tai_movimiento_proyecto_det b 
                            where  b.id_movimiento_proyecto =al_id_mov_proyecto and b.id_item IN (select i.id_item from alma.tai_item i where i.peso is null)	) 
            THEN
                    g_descripcion_log_error := 'Insercion no realizada: existen items ('||(	select count(b.id_movimiento_proyecto) from alma.tai_movimiento_proyecto_det b 
                    																		where  b.id_movimiento_proyecto =al_id_mov_proyecto
                                                                                             and b.id_item IN (select i.id_item from alma.tai_item i where i.peso is null) )||') sin un peso definido en el movimiento de ingreso seleccionado, previo costeo del registro';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
            END IF;
        ELSE
        	--CONTROL DE ITEMS DEL COSTEO POR PRECIO UNITARIO 
            IF EXISTS (		select 1
							from alma.tai_movimiento_proyecto_det a
							where a.id_movimiento_proyecto=al_id_mov_proyecto AND a.costo_unitario IS NULL
                            )
            THEN 
            	 g_descripcion_log_error := 'Insercion no realizada: existen items ('||(select count(a.id_proyecto_mov_det) from alma.tai_movimiento_proyecto_det a where a.id_movimiento_proyecto = al_id_mov_proyecto and a.costo_unitario is null)||') sin un precio unitario definido en el movimiento de ingreso seleccionado, previo costeo del registro';
                 g_nivel_error := '4';
                 g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                 RETURN 'f'||g_separador||g_respuesta;	
            END IF;
        END IF;
        
		INSERT INTO alma.tai_costeo(
            fecha_ingreso,
			fecha_salida,  
            estado,
        	descripcion,
        
            id_movimiento_proyecto,
            tipo_costeo
        ) 
        VALUES (
            al_fecha_ingreso,
            al_fecha_salida,
			'borrador',
			al_descripcion,
			
            al_id_mov_proyecto,
            al_tipo_costeo  	
        );
            
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tai_costeo';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;   
        END;
        		
        ELSIF pm_codigo_procedimiento = 'AL_COSTEO_UPD' THEN
        
    	BEGIN
            --VERIFICACI√???N DE EXISTENCIA DEL REGISTRO
            
            
            IF NOT EXISTS(select 1 from alma.tai_costeo c where c.id_costeo=al_id_costeo) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_costeo || 'en la tabla alma.tai_costeo';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;
            
            --control de duplicidad de un proyecto
            if EXISTS (SELECT 1 FROM alma.tai_costeo c WHERE c.id_almacen = al_id_almacen AND c.id_movimiento_proyecto=al_id_mov_proyecto AND c.id_costeo != al_id_costeo)
            then
            	g_descripcion_log_error := 'Modificacion no realizada: El proyecto seleccionado' || al_id_mov_proyecto || ' no puede ser registrado mas de una vez';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            end if;
            
             --control de verificacion del costeo que se registra
            /*
            1.- si al_tipo_costeo = 'peso'
              1.1.- verificar que todos los items relacionados a al_id_mov_proyecto tengan registrado un peso
            2.- si al_tipo_costeo = 'precio_unitario'
              2.1.- verificar que todos los items relacionados a al_id_mov_proyecto tengan registrado un precio unitario
            */
            IF al_tipo_costeo = 'peso' THEN
            
                IF EXISTS(		select 1
                                from alma.tai_movimiento_proyecto_det b 
                                where  b.id_movimiento_proyecto =al_id_mov_proyecto and b.id_item IN (select i.id_item from alma.tai_item i where i.peso is null)	) 
                THEN
                        g_descripcion_log_error := 'ActualizaciÛn fallida: existen items ('||(	select count(b.id_movimiento_proyecto) from alma.tai_movimiento_proyecto_det b 
                                                                                                where  b.id_movimiento_proyecto =al_id_mov_proyecto
                                                                                                 and b.id_item IN (select i.id_item from alma.tai_item i where i.peso is null) )||') sin un peso definido en el movimiento de ingreso seleccionado, previo costeo del registro';
                        g_nivel_error := '4';
                        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                        RETURN 'f'||g_separador||g_respuesta;
                END IF;
            ELSE
                --CONTROL DE ITEMS DEL COSTEO POR PRECIO UNITARIO 
                IF EXISTS (		select 1
                                from alma.tai_movimiento_proyecto_det a
                                where a.id_movimiento_proyecto=al_id_mov_proyecto AND a.costo_unitario IS NULL
                                )
                THEN 
                     g_descripcion_log_error := 'ActualizaciÛn fallida: existen items ('||(select count(a.id_proyecto_mov_det) from alma.tai_movimiento_proyecto_det a where a.id_movimiento_proyecto = al_id_mov_proyecto and a.costo_unitario is null)||') sin un precio unitario definido en el movimiento de ingreso seleccionado, previo costeo del registro';
                     g_nivel_error := '4';
                     g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                     RETURN 'f'||g_separador||g_respuesta;	
                END IF;
            END IF;
            
            
            UPDATE alma.tai_costeo SET 
            fecha_ingreso = al_fecha_ingreso,
            fecha_salida = al_fecha_salida,
            descripcion = al_descripcion,
            id_movimiento_proyecto = al_id_mov_proyecto,
    		fecha_reg = now(),
            usuario_reg = "current_user"(),
            tipo_costeo = al_tipo_costeo
			WHERE alma.tai_costeo.id_costeo=al_id_costeo;
                
 			
            -- DESCRIPCI√???N DE √???XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'modificacion exitosa del registro '||al_id_costeo||' en alma.tai_costeo';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
        --aÒadido 12-05-2015
        ELSIF pm_codigo_procedimiento = 'AL_COSTEO_IUD' THEN
        BEGIN
        	IF NOT EXISTS(SELECT 1 FROM alma.tai_costeo c WHERE c.id_costeo = al_id_costeo)
            THEN
            		g_descripcion_log_error := 'Costeo no realizado: el registro seleccionado ' || al_id_costeo || ' no existe en la tabla alma.tai_costeo';
                	g_nivel_error := '4';
                	g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                	RETURN 'f'||g_separador||g_respuesta;
            END IF;
			
            IF NOT EXISTS(SELECT 1 FROM alma.tai_costeo_detalle det WHERE det.id_costeo=al_id_costeo)
            THEN
            		g_descripcion_log_error := 'Costeo no realizado: el registro seleccionado ' || al_id_costeo || ' debe tener un detalle de costos resgitrado mÌnimamente.';
                	g_nivel_error := '4';
                	g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                	RETURN 'f'||g_separador||g_respuesta;
            END IF;
        
        	
        	IF EXISTS (SELECT 1 FROM alma.tai_costeo cos WHERE cos.id_costeo = al_id_costeo AND cos.tipo_costeo IS NULL)
            THEN
            		g_descripcion_log_error := 'Costeo no realizado: el registro seleccionado ' || al_id_costeo || ' no tiene un tipo de costeo definido.';
                	g_nivel_error := '4';
                	g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                	RETURN 'f'||g_separador||g_respuesta;
            END IF;
                        
            IF al_tipo_costeo = 'peso'
            THEN
            	
            	 select alma.f_ai_costeo_movimiento_ingresos(al_id_costeo,'COSTEO_PESO') INTO g_resultado;
            	
            ELSIF al_tipo_costeo = 'precio_unitario' THEN
            
            	 select alma.f_ai_costeo_movimiento_ingresos(al_id_costeo,'COSTEO_PRECIO') INTO g_resultado;
            
            END IF;
            
    		UPDATE alma.tai_costeo
            SET estado = 'costeado'
            WHERE alma.tai_costeo.id_costeo = al_id_costeo;
            
            --proyecto relacionado con el coste se cambia a estado finalizado, luego de  costear
            select cos.id_movimiento_proyecto into g_id_proyecto
            from alma.tai_costeo cos
            where cos.id_costeo = al_id_costeo;
            
            UPDATE alma.tai_movimiento_proyecto
            SET estado = 'finalizado'
            WHERE id_movimiento_proyecto = g_id_proyecto;
            
            
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'El costeo del registro seleccionado culmino con Èxito';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
            
        END;
        --fin aÒadido 12-05-2015
        
        ELSIF pm_codigo_procedimiento = 'AL_COSTEO_DEL' THEN
        
    	BEGIN
            --VERIFICACI√???N DE EXISTENCIA DEL REGISTRO
            
            
            IF NOT EXISTS(select 1 from alma.tai_costeo c where c.id_costeo=al_id_costeo) THEN
                              
                g_descripcion_log_error := 'Eliminacion no realizada: no existe el registro' || al_id_costeo || 'en la tabla alma.tai_costeo';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;
            
            --control de duplicidad de un proyecto
            if EXISTS (SELECT 1 FROM alma.tai_costeo_detalle d WHERE d.id_costeo=al_id_costeo)
            then
            	g_descripcion_log_error := 'Eliminacion no realizada: el registro seleccionado ' || al_id_costeo || ' , elimine el detalle de los costos relacionados al registro';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            end if;
            
            
            
            DELETE FROM alma.tai_costeo 
            WHERE alma.tai_costeo.id_costeo = al_id_costeo;
                 			
            -- DESCRIPCI√???N DE √???XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'eliminacion exitosa del registro '||al_id_costeo||' en alma.tai_costeo';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
      ELSIF pm_codigo_procedimiento = 'AL_COSTEO_CORREG' THEN
      BEGIN
      		if not EXISTS(select 1 from alma.tai_costeo cos where cos.id_costeo = al_id_costeo)
            then
            	g_descripcion_log_error := 'Correccion fallida : el registro seleccionado ' || al_id_costeo || ' no existe.';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            end if;
      		
            --obtencion de datos del costeo
            SELECT cos.id_movimiento_proyecto INTO g_id_proyecto
            FROM alma.tai_costeo cos
            WHERE cos.id_costeo=al_id_costeo;
            
            if(lower(al_estado) = 'costeado')then 
            	UPDATE alma.tai_costeo
            	SET estado = 'borrador'
            	WHERE alma.tai_costeo.id_costeo = al_id_costeo;
                
                UPDATE alma.tai_movimiento_proyecto_det
                SET calculo_costeado = NULL
                WHERE alma.tai_movimiento_proyecto_det.id_movimiento_proyecto = g_id_proyecto;         		
            
            end if;
            
      		
      		
      		 -- DESCRIPCI√???N DE √???XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'modificacion exitosa del registro '||al_id_costeo||' en alma.tai_costeo';
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

    ---*** REGISTRO EN EL LOG EL √???XITO DE LA EJECUI√???N DEL PROCEDIMIENTO
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

        --SE OBTIENE EL MENSAJE Y EL N√???MERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
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