--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_tai_tipo_movimiento_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_tipo_movimiento integer,
  al_id_documento integer,
  al_tipo varchar,
  al_requiere_aprobacion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 AUTOR:           Ariel Ayaviri Omonte
				Ruddy Luj√??√?¬°n Bravo
 FECHA:           2013-07-26
 DESCRIPCI√????N:     Realiza modificaciones en la tabla alma.f_tai_tipo_movimiento
***************************************************************************/

-- PARA¬ÅMETROS FIJOS
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
    g_numero_error                varchar;     -- ALMACENA EL N√?????MERO DE ERROR
    g_mensaje_error               varchar;     -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento    boolean;     -- BANDERA PARA VERIFICAR LLAMADA DE LA FUNCI√?????N
    g_descripcion_log_error       text;        -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento                  varchar;
    g_reg_error                	  varchar;
    g_respuesta                   varchar;     -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCI√?????N
    g_nivel_error                 varchar;     -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                               --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                               --      ERROR L√?????GICO (CR√????√???√??√?¬çTICO) = 2
                                               --      ERROR L√?????GICO (INTERMEDIO) = 3
                                               --      ERROR L√?????GICO (ADVERTENCIA) = 4
    g_nombre_funcion              	varchar;
    g_separador                   	varchar(10); -- SEPARADOR DE CADENAS
    g_id_fina_regi_prog_proy_acti 	integer;     -- VARIABLE DE LA ESTRUCTURA PROGRAM√????√???√??√?¬ÅTICA

    --VARIABLES
   	g_nro_reclamo				  	integer;
    g_id_param					  	integer;
    g_codigo_sucursal_padre			varchar;
    g_codigo_largo					varchar;
    g_id_padre_arb					varchar;
    g_id_sucursal_padre				integer;
    g_id_enti_fin					integer;
    g_auxiliar						varchar;
    g_registros						record;
    g_id_tipo_movimiento			integer;
    g_cant_tipo_movimiento			integer; --cantidad de id_documentos para el id_tipo_movimiento

BEGIN
	--- INICIACION DE VARIABLES
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funci√????√???√??√?¬≥n
    g_nombre_funcion :='f_tai_tipo_movimiento_iud';
    g_privilegio_procedimiento := FALSE;
    g_respuesta := FALSE;

    ---*** OBTENCION DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENCION DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT tsg_usuario_lugar.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar
    WHERE  tsg_usuario_lugar.id_usuario = pm_id_usuario;


     ---*** VALIDACI√?????N DE LLAMADA POR USUARIO O FUNCI√?????N
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


    ---*** VERIFICACI√?????N DE PERMISOS DEL USUARIO
    IF NOT g_privilegio_procedimiento THEN
       g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;

---*** SI NO SE TIENE PERMISOS DE EJECUCI√?????N SE RETORNA EL MENSAJE DE ERROR
    IF NOT g_privilegio_procedimiento THEN
        g_nivel_error := '3';
        g_descripcion_log_error := 'El usuario no tiene permisos de ejecuci√????√???√??√?¬≥n del procedimiento';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                             pm_codigo_procedimiento   ,pm_proc_almacenado);

        --DEVUELVE MENSAJE DE ERROR
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
    END IF;


    --*** EJECUCIONN DEL PROCEDIMIENTO ESPECI¬çFICO
	IF pm_codigo_procedimiento = 'AL_TIPMOV_INS' THEN
    BEGIN
        --se verifica que para tipo_movimiento solo exista un id_documento
       /* SELECT count(tm.id_documento) INTO g_cant_tipo_movimiento
        FROM alma.tai_tipo_movimiento tm
        WHERE tm.id_documento=al_id_documento;	
    	
        if exists(select 1 from alma.tai_tipo_movimiento where alma.tai_tipo_movimiento.id_documento=al_id_documento)
        then 
        	  --detalle del ultimo id_documento duplicado para el ultimo id_tipo_movimiento registrado
            SELECT tm.id_tipo_movimiento,tm.tipo,tm.fecha_reg,doc.codigo||' - '||doc.descripcion as desc_documento INTO g_registros
            FROM alma.tai_tipo_movimiento tm
            INNER JOIN param.tpm_documento doc on (tm.id_documento=doc.id_documento and doc.estado='activo')
            WHERE tm.id_documento=al_id_documento
            ORDER BY tm.id_tipo_movimiento DESC
            LIMIT 1;	
        
        	g_descripcion_log_error := 'El Documento: ' ||g_registros.desc_documento||' fue registrado anteriormente.'||chr(10)||
            							'Fecha: '||g_registros.fecha_reg||chr(10)||
                                        'Id_tipo_movimiento: '||g_registros.id_tipo_movimiento||chr(10)||
                                        'Tipo Movimiento: '||g_registros.tipo;
            g_nivel_error := '1';
            g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
            RETURN 'f'||g_separador||g_respuesta;
        end if;
    
    	--verificacion tipo_movimiento = 'solicitud' unico
        if (al_tipo = 'solicitud')
        then
              if EXISTS(	select 1 from alma.tai_tipo_movimiento tm where tm.tipo = al_tipo	  )
              then
                     --detalle del ultimo tipo de movimiento con solicitud de materal registrado
                     SELECT tm.id_tipo_movimiento,tm.tipo,tm.fecha_reg,tm.usuario_reg INTO g_registros
                     FROM alma.tai_tipo_movimiento tm
                     WHERE tm.tipo = al_tipo;
              
              
                      g_descripcion_log_error := 'La solicitud de Material, ya fue registrado anteriormente'||chr(10)||
                                              'Fecha Registro: '||g_registros.fecha_reg||chr(10)||
                                              'Usuario Registro: '||g_registros.usuario_reg||chr(10)||
                                              'Tipo Movimiento: '||g_registros.tipo;
                      g_nivel_error := '1';
                      g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                      RETURN 'f'||g_separador||g_respuesta;
              end if;
        elsif (al_tipo = 'transpaso_ingreso') then
        	if EXISTS(	select 1 from alma.tai_tipo_movimiento tm where tm.tipo = al_tipo	)
            then
             		 --detalle del ultimo tipo de movimiento con transpaso ingreso registrado
                     SELECT tm.id_tipo_movimiento,tm.tipo,tm.fecha_reg,tm.usuario_reg INTO g_registros
                     FROM alma.tai_tipo_movimiento tm
                     WHERE tm.tipo = al_tipo;
                     
                      g_descripcion_log_error := 'El transpaso de ingreso, ya fue registrado anteriormente'||chr(10)||
                                              'Fecha Registro: '||g_registros.fecha_reg||chr(10)||
                                              'Usuario Registro: '||g_registros.usuario_reg||chr(10)||
                                              'Tipo Movimiento: '||g_registros.tipo;
                      g_nivel_error := '1';
                      g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                      RETURN 'f'||g_separador||g_respuesta;
            end if;
        
        elsif (al_tipo = 'transpaso_salida') then
        	if EXISTS(	select 1 from alma.tai_tipo_movimiento tm where tm.tipo = al_tipo	)
            then
             		 --detalle del ultimo tipo de movimiento con transpaso salida registrado
                     SELECT tm.id_tipo_movimiento,tm.tipo,tm.fecha_reg,tm.usuario_reg INTO g_registros
                     FROM alma.tai_tipo_movimiento tm
                     WHERE tm.tipo = al_tipo;
                     
                      g_descripcion_log_error := 'El transpaso de salida, ya fue registrado anteriormente'||chr(10)||
                                              'Fecha Registro: '||g_registros.fecha_reg||chr(10)||
                                              'Usuario Registro: '||g_registros.usuario_reg||chr(10)||
                                              'Tipo Movimiento: '||g_registros.tipo;
                      g_nivel_error := '1';
                      g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                      RETURN 'f'||g_separador||g_respuesta;
            end if;
        elsif (al_tipo = 'devolucion') then
        	if EXISTS(	select 1 from alma.tai_tipo_movimiento tm where tm.id_documento = al_id_documento	)
            then
             		 --detalle del ultimo tipo de movimiento devolucion registrado
                     SELECT tm.id_tipo_movimiento,tm.tipo,tm.fecha_reg,tm.usuario_reg INTO g_registros
                     FROM alma.tai_tipo_movimiento tm
                     WHERE tm.tipo = al_tipo;
                     
                      g_descripcion_log_error := 'La devolucion, con el documento '|| ||' fue registrado anteriormente'||chr(10)||
                                              'Fecha Registro: '||g_registros.fecha_reg||chr(10)||
                                              'Usuario Registro: '||g_registros.usuario_reg||chr(10)||
                                              'Tipo Movimiento: '||g_registros.tipo;
                      g_nivel_error := '1';
                      g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                      RETURN 'f'||g_separador||g_respuesta;
            end if;
        	
        end if;*/
        
        if EXISTS(select 1 from alma.tai_tipo_movimiento m where m.id_documento=al_id_documento) then
        	 
             SELECT tm.id_tipo_movimiento,tm.tipo,tm.fecha_reg,tm.usuario_reg,doc.descripcion INTO g_registros
             FROM alma.tai_tipo_movimiento tm
             INNER JOIN param.tpm_documento doc on doc.id_documento=tm.id_documento AND doc.estado='activo'
             WHERE tm.id_documento=al_id_documento;
             
              g_descripcion_log_error := 'El documento seleccionado '||g_registros.descripcion||' , para el movimiento de "'||upper(g_registros.tipo)||'" fue registrado anteriormente.'||chr(10)||
                                         'Fecha Registro: '||g_registros.fecha_reg||chr(10)||
                                         'Usuario Registro: '||g_registros.usuario_reg||chr(10)||
                                         'Tipo Movimiento: '||g_registros.tipo;
              g_nivel_error := '1';
              g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
              RETURN 'f'||g_separador||g_respuesta;
             
        end if;
        
		INSERT INTO alma.tai_tipo_movimiento (
            id_documento,
            tipo,
            requiere_aprobacion
        ) VALUES (
			al_id_documento,
            al_tipo,
            al_requiere_aprobacion
		);
       	
        -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
        g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tai_tipo_movimiento';
        g_respuesta := 't'||g_separador||g_descripcion_log_error;
 	END;

	ELSIF pm_codigo_procedimiento = 'AL_TIPMOV_UPD' THEN
    BEGIN
    	select id_tipo_movimiento into g_id_tipo_movimiento
        from alma.tai_tipo_movimiento where id_tipo_movimiento = al_id_tipo_movimiento;
        
        IF g_id_tipo_movimiento is null THEN
        	g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_tipo_movimiento || 'en la tabla alma.tai_tipo_movimiento';
            g_nivel_error := '4';
            g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
            RETURN 'f'||g_separador||g_respuesta;
        END IF;
        --verificacion de uso del tipo de movimiento
        --1) se verifica si el id_tipo_movimiento existe en la tabla movimiento
        -- 	1.1) como el id_tipo_moviento esta siendo usado, entonces lanza error
    	if EXISTS(select 1 from alma.tai_movimiento mov where mov.id_tipo_movimiento=al_id_tipo_movimiento)
        then
        			  --detalle del tipo movimiento existente en un movimiento
                       SELECT mov.id_movimiento,mov.codigo,mov.descripcion,tm.id_tipo_movimiento,tm.tipo INTO g_registros
                       FROM alma.tai_tipo_movimiento tm
                       INNER JOIN alma.tai_movimiento mov on mov.id_tipo_movimiento=tm.id_tipo_movimiento
                       WHERE tm.id_tipo_movimiento=al_id_tipo_movimiento
                       ORDER BY mov.id_movimiento DESC
                       LIMIT 1;
                      
                      g_descripcion_log_error := 'Modificacion no realizada, el tipo de movimiento :'||g_registros.id_tipo_movimiento||' - '||g_registros.tipo||', esta registrado en uno o mas movimientos';--||chr(10)||
                                             -- 'Detalle Ultimo Movimiento :'||g_registros.id_movimiento||' - '||g_registros.codigo||' - '||g_registros.descripcion;
                      g_nivel_error := '1';
                      g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                      RETURN 'f'||g_separador||g_respuesta;
        end if;
        
		UPDATE alma.tai_tipo_movimiento SET
            usuario_reg = "current_user"(),
            fecha_reg = now(),
            id_documento = al_id_documento,
           	tipo = al_tipo,
            requiere_aprobacion = al_requiere_aprobacion
		WHERE alma.tai_tipo_movimiento.id_tipo_movimiento = al_id_tipo_movimiento;
        
		-- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
        g_descripcion_log_error := 'Modificacion exitosa en alma.tai_tipo_movimiento del registro '||  al_id_tipo_movimiento   ;
        g_respuesta := 't'||g_separador||g_descripcion_log_error;
	END;
    
    ELSIF pm_codigo_procedimiento = 'AL_TIPMOV_DEL' THEN
	BEGIN
            select id_tipo_movimiento into g_id_tipo_movimiento
            from alma.tai_tipo_movimiento where id_tipo_movimiento = al_id_tipo_movimiento;
            
            IF g_id_tipo_movimiento is null THEN
                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminacion no realizada: registro '|| al_id_tipo_movimiento || ' en alma.tai_tipo_movimiento inexistente';
                g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;
            
            --verificacion de uso del tipo de movimiento
            --1) se verifica si el id_tipo_movimiento existe en la tabla movimiento
            -- 	1.1) como el id_tipo_moviento esta siendo usado, entonces lanza error
            if EXISTS(select 1 from alma.tai_movimiento mov where mov.id_tipo_movimiento=al_id_tipo_movimiento)
            then
                          --detalle del tipo movimiento existente en un movimiento
                           SELECT mov.id_movimiento,mov.codigo,mov.descripcion,tm.id_tipo_movimiento,tm.tipo INTO g_registros
                           FROM alma.tai_tipo_movimiento tm
                           INNER JOIN alma.tai_movimiento mov on mov.id_tipo_movimiento=tm.id_tipo_movimiento
                           WHERE tm.id_tipo_movimiento=al_id_tipo_movimiento
                           ORDER BY mov.id_movimiento DESC
                           LIMIT 1;
                          
                          g_descripcion_log_error := 'Eliminacion no realizada, el tipo de movimiento :'||g_registros.id_tipo_movimiento||' - '||g_registros.tipo||', esta registrado en uno o mas movimientos';--||chr(10)||
                                             -- 'Detalle Ultimo Movimiento :'||g_registros.id_movimiento||' - '||g_registros.codigo||' - '||g_registros.descripcion;
                          g_nivel_error := '1';
                          g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                          RETURN 'f'||g_separador||g_respuesta;
            end if;
            
            DELETE FROM alma.tai_tipo_movimiento
            WHERE id_tipo_movimiento = al_id_tipo_movimiento;
            
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_tipo_movimiento||' alma.tai_tipo_movimiento';
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

    ---*** REGISTRO EN EL LOG EL √?????XITO DE LA EJECUI√?????N DEL PROCEDIMIENTO
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);

    ---*** SE DEVUELVE LA RESPUESTA
    RETURN g_respuesta||g_separador||g_reg_evento;

EXCEPTION
	--control de unicidad y manejo del error en la tabla alma.tai_tipo_movimiento.id_documento
    WHEN unique_violation
    then
    begin
    	--detalle del ultimo id_documento duplicado para el ultimo id_tipo_movimiento registrado
        	SELECT tm.id_tipo_movimiento,tm.tipo,tm.fecha_reg,doc.codigo||' - '||doc.descripcion as desc_documento INTO g_registros
            FROM alma.tai_tipo_movimiento tm
            INNER JOIN param.tpm_documento doc on (tm.id_documento=doc.id_documento and doc.estado='activo')
            WHERE tm.id_documento=al_id_documento
            ORDER BY tm.id_tipo_movimiento DESC
            LIMIT 1;
        	g_descripcion_log_error := 'El Documento: ' ||g_registros.desc_documento||' fue registrado anteriormente.'||chr(10)||
            							'Fecha: '||g_registros.fecha_reg||chr(10)||
                                        'Id_tipo_movimiento: '||g_registros.id_tipo_movimiento||chr(10)||
                                        'Tipo Movimiento: '||g_registros.tipo;
            g_nivel_error := '1';
            g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
            RETURN 'f'||g_separador||g_respuesta;
    end;
	
    WHEN others THEN BEGIN
        --SE OBTIENE EL MENSAJE Y EL N√?????MERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
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