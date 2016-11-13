QL ---------------

CREATE OR REPLACE FUNCTION alma.f_tal_clasificacion_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_clasificacion integer,
  al_id_clasificacion_fk integer,
  al_codigo varchar,
  al_nombre varchar,
  al_estado varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 AUTOR:           Ariel Ayaviri Omonte
 FECHA:           2013-07-26
 DESCRIPCIÃN:     Realiza modificaciones en la tabla alma.f_tal_tipo_movimiento
***************************************************************************/

-- PARAMETROS FIJOS
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

    --PARAMETROS FIJOS
    g_id_subsistema               integer;     -- ID SUBSISTEMA
    g_id_lugar                    integer;     -- ID LUGAR
    g_numero_error                varchar;     -- ALMACENA EL NÃ?MERO DE ERROR
    g_mensaje_error               varchar;     -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento    boolean;     -- BANDERA PARA VERIFICAR LLAMADA DE LA FUNCIÃ?N
    g_descripcion_log_error       text;        -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento                  varchar;
    g_reg_error                	  varchar;
    g_respuesta                   varchar;     -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCIÃ?N
    g_nivel_error                 varchar;     -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                               --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                               --      ERROR LÃ?GICO (CRÃTICO) = 2
                                               --      ERROR LÃ?GICO (INTERMEDIO) = 3
                                               --      ERROR LÃ?GICO (ADVERTENCIA) = 4
    g_nombre_funcion              	varchar;
    g_separador                   	varchar(10); -- SEPARADOR DE CADENAS

    --VARIABLES PROPIAS
    g_codigo_padre					varchar;
    g_codigo_largo					varchar;
    g_id_clasificacion				integer;

BEGIN
	--- INICIACIÃ?N DE VARIABLES
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funciÃ³n
    g_nombre_funcion :='f_tal_clasificacion_iud';
    g_privilegio_procedimiento := FALSE;
    g_respuesta := FALSE;

    ---*** OBTENCIÃ?N DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENCIÃ?N DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT tsg_usuario_lugar.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar
    WHERE  tsg_usuario_lugar.id_usuario = pm_id_usuario;


     ---*** VALIDACIÃ?N DE LLAMADA POR USUARIO O FUNCIÃ?N
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


    ---*** VERIFICACIÃ?N DE PERMISOS DEL USUARIO
    IF NOT g_privilegio_procedimiento THEN
       g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;

---*** SI NO SE TIENE PERMISOS DE EJECUCIÃ?N SE RETORNA EL MENSAJE DE ERROR
    IF NOT g_privilegio_procedimiento THEN
        g_nivel_error := '3';
        g_descripcion_log_error := 'El usuario no tiene permisos de ejecución del procedimiento';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                             pm_codigo_procedimiento   ,pm_proc_almacenado);

        --DEVUELVE MENSAJE DE ERROR
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
    END IF;


    --*** EJECUCIO?N DEL PROCEDIMIENTO ESPECIFICO
	IF pm_codigo_procedimiento = 'AL_CLASIF_INS' THEN
    BEGIN
    	g_codigo_largo = al_codigo;
        
        select codigo_largo into g_codigo_padre
        from alma.tal_clasificacion 
        where id_clasificacion = al_id_clasificacion_fk;
    	
    	if (g_codigo_padre is not null) then
        	g_codigo_largo = g_codigo_padre || '.' ||g_codigo_largo;
        end if;
        
        --control añdo, para que en un nodo donde se registraron  items, no puedan registrarse otras ramas.
        if EXISTS(	select 1 
        			from alma.tal_item it 
                    inner join alma.tal_clasificacion clas on clas.id_clasificacion=it.id_clasificacion	
                    where it.id_clasificacion = al_id_clasificacion_fk
                    )
        then
        	--el id de la clasificacion ya fue registrado en la tabla de registro de items -> la rama ya tiene items -> se lanza el error
            g_descripcion_log_error := 'Insercion no realizada: la rama utilizada tiene items asociados';
            g_nivel_error := '1';
            g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
            RETURN 'f'||g_separador||g_respuesta;	
        end if;
        
		INSERT INTO alma.tal_clasificacion (
            --id_usuario_reg,
          --  fecha_reg,
            id_clasificacion_fk,
            codigo,
            codigo_largo,
            nombre,
            estado
        ) VALUES (
           	--pm_id_usuario,
           	--now(),
			al_id_clasificacion_fk,
            al_codigo,
            g_codigo_largo,
            al_nombre,
            al_estado
		);
       	
        -- DESCRIPCIÃ?N DE Ã?XITO PARA GUARDAR EN EL LOG
        g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tal_clasificacion';
        g_respuesta := 't'||g_separador||g_descripcion_log_error;
 	END;

	ELSIF pm_codigo_procedimiento = 'AL_CLASIF_UPD' THEN
    BEGIN
    	select id_clasificacion into g_id_clasificacion
        from alma.tal_clasificacion where id_clasificacion = al_id_clasificacion;
        
        IF g_id_clasificacion is null THEN
        	g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_clasificacion || 'en la tabla alma.tal_clasificacion';
            g_nivel_error := '4';
            g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
            RETURN 'f'||g_separador||g_respuesta;
        END IF;
        
        g_codigo_largo = al_codigo;
        
        select codigo_largo into g_codigo_padre
        from alma.tal_clasificacion 
        where id_clasificacion = al_id_clasificacion_fk;
    	
    	if (g_codigo_padre is not null) then
        	g_codigo_largo = g_codigo_padre || '.' ||g_codigo_largo;
        end if;
        
		UPDATE alma.tal_clasificacion SET
            --id_usuario_mod = pm_id_usuario,
           -- fecha_mod = now(),
            usuario_reg = "current_user"(),
            fecha_reg = now(),
            id_clasificacion_fk = al_id_clasificacion_fk,
           	codigo = al_codigo,
            codigo_largo = g_codigo_largo,
            nombre = al_nombre,
            estado = al_estado
		WHERE alma.tal_clasificacion.id_clasificacion = al_id_clasificacion;
		
		-- DESCRIPCIÃ?N DE Ã?XITO PARA GUARDAR EN EL LOG
        g_descripcion_log_error := 'Modificacion exitosa en alma.tal_clasificacion del registro '||  al_id_clasificacion   ;
        g_respuesta := 't'||g_separador||g_descripcion_log_error;

	END;
    ELSIF pm_codigo_procedimiento = 'AL_CLASIF_DEL' THEN
	BEGIN
            select id_clasificacion into g_id_clasificacion
            from alma.tal_clasificacion where id_clasificacion = al_id_clasificacion;
            
            IF g_id_clasificacion is null THEN
                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: registro '|| al_id_clasificacion || ' en alma.tal_clasificacion inexistente';
                g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;
            
            --control de eliminacion del nodo de clasificacion
            if EXISTS(select 1 from alma.tal_clasificacion clas where clas.id_clasificacion_fk=al_id_clasificacion)
            then
            	g_nivel_error := '1';
                g_descripcion_log_error := 'Eliminacion no realizada: La clasificacion tiene asociado otros niveles';
                g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            end if;
            if EXISTS(	select 1 from alma.tal_clasificacion clas 
            			inner join alma.tal_item it on it.id_clasificacion=clas.id_clasificacion
                        where it.id_clasificacion=al_id_clasificacion	)
            then
            	g_nivel_error := '1';
                g_descripcion_log_error := 'Eliminacion no realizada: La clasificacion tiene items asociados.';
                g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            end if;
            
            
            DELETE FROM alma.tal_clasificacion
            WHERE id_clasificacion = al_id_clasificacion;
            
            -- DESCRIPCIÃ?N DE Ã?XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminación exitosa del registro '||al_id_clasificacion||' alma.tal_clasificacion';
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

    ---*** REGISTRO EN EL LOG EL Ã?XITO DE LA EJECUIÃ?N DEL PROCEDIMIENTO
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);

    ---*** SE DEVUELVE LA RESPUESTA
    RETURN g_respuesta||g_separador||g_reg_evento;

EXCEPTION

    WHEN others THEN BEGIN
        --SE OBTIENE EL MENSAJE Y EL NÃ?MERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
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
