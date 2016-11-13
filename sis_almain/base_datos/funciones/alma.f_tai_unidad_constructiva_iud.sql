--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_tai_unidad_constructiva_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_unidad_constructiva integer,
  al_id_unidad_constructiva_fk integer,
  al_codigo varchar,
  al_nombre varchar,
  al_descripcion varchar,
  al_observaciones varchar,
  al_estado varchar,
  al_orden integer,
  al_cod_tramo varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 AUTOR:           UNKNOW
 FECHA:           11-08-2014	
 DESCRIPCI√?N:     Realiza modificaciones en la tabla alma.f_tai_unidad_constructiva
***************************************************************************/

-- PARAÅMETROS FIJOS
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

DECLARE

    --PARA¬ÅMETROS FIJOS
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
    g_nombre_funcion              	varchar;
    g_separador                   	varchar(10); -- SEPARADOR DE CADENAS

    --VARIABLES PROPIAS
   
    g_id_uc							integer;
    
    g_nro_linea						integer;
    g_nro_linea_act					integer;
    g_orden 						integer;

BEGIN
	--- INICIACI√??N DE VARIABLES
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funci√?¬≥n
    g_nombre_funcion :='f_tai_unidad_constructiva_iud';
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


     ---*** VALIDACI√??N DE LLAMADA POR USUARIO O FUNCI√??N
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

---*** SI NO SE TIENE PERMISOS DE EJECUCI√??N SE RETORNA EL MENSAJE DE ERROR
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


    --*** EJECUCIO?N DEL PROCEDIMIENTO ESPECI¬çFICO
	IF pm_codigo_procedimiento = 'AL_UNICONST_INS' THEN
    BEGIN
    	/*g_codigo_largo = al_codigo;
        
        select codigo_largo into g_codigo_padre
        from alma.tai_clasificacion 
        where id_clasificacion = al_id_clasificacion_fk;
    	
    	if (g_codigo_padre is not null) then
        	g_codigo_largo = g_codigo_padre || '.' ||g_codigo_largo;
        end if;
        
        --control aÒadido, para que en un nodo donde se registraron  items, no puedan registrarse otras ramas.
        if EXISTS(	select 1 
        			from alma.tai_item it 
                    inner join alma.tai_clasificacion clas on clas.id_clasificacion=it.id_clasificacion	
                    where it.id_clasificacion = al_id_clasificacion_fk
                    )
        then
        	--el id de la clasificacion ya fue registrado en la tabla de registro de items -> la rama ya tiene items -> se lanza el error
            g_descripcion_log_error := 'Insercion no realizada: la rama utilizada tiene items asociados';
            g_nivel_error := '1';
            g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
            RETURN 'f'||g_separador||g_respuesta;	
        end if;
        */
        --control para evitar la insercion en un nodo que ya tiene detalle
        /*if EXISTS(	select 1 
        			from alma.tai_unidad_constructiva uc 
                    inner join alma.tai_detalle_unidad_constructiva det on uc.id_unidad_constructiva=det.id_unidad_constructiva
                    where det.id_unidad_constructiva=al_id)*/
         --verificacion del codigo de tramo (unico), en la unidad constructiva
        IF EXISTS(SELECT 1 FROM alma.tai_unidad_constructiva uc WHERE uc.cod_tramo=al_cod_tramo)
        THEN
         	g_descripcion_log_error := 'Insercion fallida el codgio de tramo '||upper(al_cod_tramo)||' ya fue registrado anteriormente.';
            g_nivel_error := '1';
            g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
            RETURN 'f'||g_separador||g_respuesta;
        END IF;            
                    
        --inicio control del orden de los hijos del nodo de un arbol
        IF(al_id_unidad_constructiva_fk IS NULL)
        THEN
        	INSERT INTO alma.tai_unidad_constructiva (
            id_unidad_constructiva_fk,
            codigo,
            nombre,
            descripcion,
            observaciones
            --,estado
            ,cod_tramo
           
        ) VALUES (
			al_id_unidad_constructiva_fk,
            al_codigo,
            al_nombre,
            al_descripcion,
            al_observaciones
--            ,al_estado
            ,al_cod_tramo
		);
        ELSE
        
         IF EXISTS(SELECT 1 FROM alma.tai_unidad_constructiva c WHERE c.id_unidad_constructiva_fk = al_id_unidad_constructiva_fk)
            THEN
            	IF NOT EXISTS(SELECT 1 FROM alma.tai_unidad_constructiva cl WHERE cl.id_unidad_constructiva_fk = al_id_unidad_constructiva_fk
                				AND cl.orden = al_orden AND cl.orden > 0)
                THEN
                	g_descripcion_log_error := 'InserciÛn no realizada: no existe la Linea Nro. '||al_orden;
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta; 
                END IF;
            	g_nro_linea = al_orden;
            ELSE
            	g_nro_linea = 0;
            END IF;
        
       		UPDATE alma.tai_unidad_constructiva
        	SET orden = orden + 1
        	WHERE id_unidad_constructiva_fk = al_id_unidad_constructiva_fk AND orden >= al_orden + 1;

            INSERT INTO alma.tai_unidad_constructiva (
                id_unidad_constructiva_fk,
                codigo,
                nombre,
                descripcion,
                observaciones
                --,estado
                ,orden
                ,cod_tramo
            ) VALUES (
                al_id_unidad_constructiva_fk,
                al_codigo,
                al_nombre,
                al_descripcion,
                al_observaciones
                --,al_estado
                ,g_nro_linea + 1
                ,al_cod_tramo
            );
       END IF;	
        -- DESCRIPCI√??N DE √??XITO PARA GUARDAR EN EL LOG
        g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tai_unidad_constructiva';
        g_respuesta := 't'||g_separador||g_descripcion_log_error;
 	END;

	ELSIF pm_codigo_procedimiento = 'AL_UNICONST_UPD' THEN
    BEGIN
    	
        IF NOT EXISTS(SELECT 1 FROM alma.tai_unidad_constructiva uni WHERE uni.id_unidad_constructiva = al_id_unidad_constructiva) THEN
        	g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_unidad_constructiva || 'en la tabla alma.tai_unidad_constructiva';
            g_nivel_error := '4';
            g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
            RETURN 'f'||g_separador||g_respuesta;
        END IF;
        
         IF EXISTS(SELECT 1 FROM alma.tai_unidad_constructiva uc WHERE uc.cod_tramo=al_cod_tramo AND uc.id_unidad_constructiva != al_id_unidad_constructiva)
        THEN
         	g_descripcion_log_error := 'Modificacion fallida el codigo de tramo '||upper(al_cod_tramo)||' ya fue registrado en otra Unidad Constructiva.';
            g_nivel_error := '1';
            g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
            RETURN 'f'||g_separador||g_respuesta;
        END IF;
        
       IF(al_id_unidad_constructiva_fk IS NOT NULL)
        THEN        
            IF NOT EXISTS(	SELECT 1 FROM alma.tai_unidad_constructiva cl WHERE cl.id_unidad_constructiva_fk = al_id_unidad_constructiva_fk
                                    AND cl.orden = al_orden AND cl.orden > 0	)
            THEN
            
                g_descripcion_log_error := 'Actualizacion no realizada: no existe la Linea Nro. '||al_orden;
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta; 
            END IF;
        END IF;

        SELECT c.orden INTO g_nro_linea
        FROM alma.tai_unidad_constructiva c
        WHERE c.id_unidad_constructiva = al_id_unidad_constructiva;
            
        g_nro_linea_act := al_orden;
        
        IF al_orden < g_nro_linea
        THEN
        	--actualizacion nros_linea <= nro_linea_actual (fila enviada a actualizar)
        	UPDATE alma.tai_unidad_constructiva SET orden = orden - 1
            WHERE alma.tai_unidad_constructiva.id_unidad_constructiva_fk = al_id_unidad_constructiva_fk AND  orden >= g_nro_linea;
            --actualizacion nros_linea > nro_linea_actual
            UPDATE alma.tai_unidad_constructiva SET
            orden = orden + 1
            WHERE alma.tai_unidad_constructiva.id_unidad_constructiva_fk = al_id_unidad_constructiva_fk AND orden > al_orden AND id_unidad_constructiva <> al_id_unidad_constructiva;
                
            g_nro_linea_act := al_orden + 1;
        END IF;
        
        IF al_orden > g_nro_linea
        THEN
        	UPDATE alma.tai_unidad_constructiva SET orden = orden - 1
            WHERE alma.tai_unidad_constructiva.id_unidad_constructiva_fk = al_id_unidad_constructiva_fk AND orden > g_nro_linea;
                    
            UPDATE alma.tai_unidad_constructiva SET orden = orden + 1
            WHERE alma.tai_unidad_constructiva.id_unidad_constructiva_fk = al_id_unidad_constructiva_fk AND orden >= al_orden;
        END IF;
        
         
		UPDATE alma.tai_unidad_constructiva SET
            usuario_reg = "current_user"(),
            fecha_reg = now(),
            id_unidad_constructiva_fk = al_id_unidad_constructiva_fk,
           	codigo = al_codigo,
            nombre = al_nombre,
            descripcion = al_descripcion,
            observaciones = al_observaciones,
           -- estado = al_estado,
            orden = g_nro_linea_act,
            cod_tramo = al_cod_tramo
		WHERE id_unidad_constructiva = al_id_unidad_constructiva;
		
		-- DESCRIPCI√??N DE √??XITO PARA GUARDAR EN EL LOG
        g_descripcion_log_error := 'Modificacion exitosa en alma.tai_unidad_constructiva del registro '||al_id_unidad_constructiva;
        g_respuesta := 't'||g_separador||g_descripcion_log_error;

	END;
    ELSIF pm_codigo_procedimiento = 'AL_UNICONST_DEL' THEN
	BEGIN
            
            IF NOT EXISTS (select 1 from alma.tai_unidad_constructiva uni where uni.id_unidad_constructiva = al_id_unidad_constructiva) THEN
                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminacion no realizada: registro '|| al_id_unidad_constructiva || ' en alma.tai_unidad_constructiva inexistente';
                g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;
            
            --control de eliminacion del nodo de clasificacion
           /* if EXISTS(select 1 from alma.tai_clasificacion clas where clas.id_clasificacion_fk=al_id_clasificacion)
            then
            	g_nivel_error := '1';
                g_descripcion_log_error := 'Eliminacion no realizada: La clasificacion tiene asociado otros niveles';
                g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            end if;
            if EXISTS(	select 1 from alma.tai_clasificacion clas 
            			inner join alma.tai_item it on it.id_clasificacion=clas.id_clasificacion
                        where it.id_clasificacion=al_id_clasificacion	)
            then
            	g_nivel_error := '1';
                g_descripcion_log_error := 'Eliminacion no realizada: La clasificacion tiene items asociados.';
                g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            end if;
            */
            
            SELECT c.orden,c.id_unidad_constructiva_fk INTO g_nro_linea,g_id_uc
            FROM alma.tai_unidad_constructiva c
            WHERE c.id_unidad_constructiva = al_id_unidad_constructiva;
            
            DELETE FROM alma.tai_unidad_constructiva
            WHERE id_unidad_constructiva = al_id_unidad_constructiva;
            
            UPDATE alma.tai_unidad_constructiva SET orden = orden - 1
            WHERE alma.tai_unidad_constructiva.id_unidad_constructiva_fk = g_id_uc AND orden >= g_nro_linea;  
            
            -- DESCRIPCI√??N DE √??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminaci√≥n exitosa del registro '||al_id_unidad_constructiva||' alma.tai_unidad_constructiva';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
    END;
	ELSE
        --PROCEDIMIENTO INEXISTENTE
        g_nivel_error := '2';
        g_descripcion_log_error := 'Procedimiento inexistente';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(
        pm_id_usuario, 
        		g_id_subsistema, 
                g_id_lugar, 
                g_descripcion_log_error,
                pm_ip_origen,
                pm_mac_maquina,
                'error',
                NULL,
                pm_codigo_procedimiento,
                pm_proc_almacenado
        );
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