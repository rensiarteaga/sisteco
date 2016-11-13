--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_tai_solicitud_salida_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_solicitud_salida integer,
  al_id_almacen integer,
  al_id_unidad_organizacional integer,
  al_id_empleado integer,
  al_id_aprobador integer,
  al_fecha_solicitud timestamp,
  al_descripcion varchar,
  al_codigo varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA Almacen
***************************************************************************
 SCRIPT:          alma.f_tai_solicitud_salida
 DESCRIPCIÃ??????N:     Realiza modificaciones en la tabla alma.tai_solicitud_salida
 AUTOR:           Ariel Ayaviri Omonte
 FECHA:           11-09-2013 09:30:00
 COMENTARIOS:    
***************************************************************************
*/

DECLARE

    --PARAÃ????Ã???Ã??Ã?ÂMETROS FIJOS

    g_id_subsistema               integer;     -- ID SUBSISTEMA
    g_id_lugar                    integer;     -- ID LUGAR
    g_numero_error                varchar;     -- ALMACENA EL NÃ??????MERO DE ERROR
    g_mensaje_error               varchar;     -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento    boolean;     -- BANDERA PARA VERIFICAR LLAMADA DE LA FUNCIÃ??????N
    g_descripcion_log_error       text;        -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento                  varchar; 
    g_reg_error                	  varchar; 
    g_respuesta                   varchar;     -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCIÃ??????N
    g_nivel_error                 varchar;     -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                               --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                               --      ERROR LÃ??????GICO (CRÃ?????Ã????Ã???Ã??Ã?ÂTICO) = 2
                                               --      ERROR LÃ??????GICO (INTERMEDIO) = 3
                                               --      ERROR LÃ??????GICO (ADVERTENCIA) = 4
    
    g_nombre_funcion              varchar;     -- NOMBRE FÃ?????Ã????Ã???Ã??Ã?ÂSICO DE LA FUNCIÃ??????N
    g_separador                   varchar(10); -- SEPARADOR DE CADENAS
    g_id_solicitud_salida			integer;
    g_estado						varchar;
    g_solicitud_salida				record;
    g_detalle_solicitud				record;
    g_saldo_movimiento				record;
    g_det_error						record;
    g_res							varchar;
    g_saldo_total					numeric;
    g_id_movimiento					integer;
    g_cant_solicitud				integer;
    g_cod_solicitud					text;
    
    g_cargo							varchar;
    g_cargo_aprob					varchar;
    fecha_ultima					date;
    rec								record;
BEGIN

---*** INICIACION DE VARIABLES 
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funciÃ?????Ã????Ã???Ã??Ã?Â³n	
    g_nombre_funcion :='f_tai_solicitud_salida_iud';
    g_privilegio_procedimiento := FALSE;
    g_respuesta := FALSE;
   
    ---*** OBTENCIÃ??????N DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENCIÃ??????N DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT tsg_usuario_lugar.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar
    WHERE  tsg_usuario_lugar.id_usuario = pm_id_usuario;
    
    
     ---*** VALIDACIÃ??????N DE LLAMADA POR USUARIO O FUNCIÃ??????N
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


    ---*** VERIFICACIÃ??????N DE PERMISOS DEL USUARIO
    IF NOT g_privilegio_procedimiento THEN
       g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;

---*** SI NO SE TIENE PERMISOS DE EJECUCIÃ??????N SE RETORNA EL MENSAJE DE ERROR
    IF NOT g_privilegio_procedimiento THEN
        g_nivel_error := '3';
        g_descripcion_log_error := 'El usuario no tiene permisos de ejecuciÃ?????Ã????Ã???Ã??Ã?Â³n del procedimiento';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                             pm_codigo_procedimiento   ,pm_proc_almacenado);
        
        --DEVUELVE MENSAJE DE ERROR
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
    END IF;
    
    IF(al_id_empleado IS NOT NULL AND al_id_aprobador IS NOT NULL) THEN
    
    
       SELECT c.nombre_cargo INTO g_cargo
       FROM kard.tkp_empleado a
       INNER JOIN kard.tkp_contrato b on b.id_empleado=a.id_empleado and b.estado_reg='activo'
       INNER JOIN kard.tkp_cargo c on c.id_cargo=b.id_cargo and c.estado_reg='activo'
       WHERE a.id_empleado = al_id_empleado;
       
       SELECT b.nombre_cargo INTO g_cargo_aprob
       FROM param.tpm_config_aprobador a
       INNER JOIN kard.tkp_unidad_organizacional b on b.id_unidad_organizacional=a.id_uo AND a.estado='activo' AND b.estado_reg='activo'
       WHERE a.id_config_aprobador = 	al_id_aprobador;
    END IF;
    
      --*** EJECUCIÃ??????N DEL PROCEDIMIENTO ESPECÃ?????Ã????Ã???Ã??Ã?ÂFICO
    IF pm_codigo_procedimiento = 'AL_SOLSAL_INS' THEN
    BEGIN
	
    	                              
     SELECT c.nombre_cargo INTO g_cargo
     FROM kard.tkp_empleado a
     INNER JOIN kard.tkp_contrato b on b.id_empleado=a.id_empleado and b.estado_reg='activo'
     INNER JOIN kard.tkp_cargo c on c.id_cargo=b.id_cargo and c.estado_reg='activo'
     WHERE a.id_empleado = al_id_empleado;
     
     SELECT b.nombre_cargo INTO g_cargo_aprob
     FROM param.tpm_config_aprobador a
     INNER JOIN kard.tkp_unidad_organizacional b on b.id_unidad_organizacional=a.id_uo AND a.estado='activo' AND b.estado_reg='activo'
     WHERE a.id_config_aprobador = 	al_id_aprobador;
    
		INSERT INTO alma.tai_solicitud_salida(
		    --usuario_reg,
            --fecha_reg,
            id_almacen,
            id_unidad_organizacional, 
            id_empleado,
        	cargo_empleado,
            id_aprobador,
            cargo_aprobador,
            fecha_solicitud,
            descripcion,
            estado
        ) 
        VALUES (
            --pm_id_usuario,
            --now(),
            al_id_almacen,
            al_id_unidad_organizacional,
            al_id_empleado,
			g_cargo,
			al_id_aprobador,
			g_cargo_aprob,
            CAST((al_fecha_solicitud)::date||' '||to_char(CURRENT_TIMESTAMP,'HH24:MI:SS') as timestamp),
            al_descripcion,
            'borrador'
        );
            
            -- DESCRIPCIÃ??????N DE Ã??????XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tai_solicitud_salida';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;   
        END;
        
        
  --INSERT alma._tal_solicitud_salida especial p/ el registro de solicitudes de los movimientos con tipo_saldo = 'pendiente_entrega'
  
  ELSIF pm_codigo_procedimiento = 'AL_SOLSAL_INS2' THEN
  BEGIN
		SELECT nextval('alma.tai_solicitud_salida_id_solicitud_salida_seq') INTO g_id_solicitud_salida;
  		-- falta modificar el cargo de prueba del empleado y del aprobador 
  		INSERT INTO alma.tai_solicitud_salida(
        	id_solicitud_salida,
            id_almacen,
            id_unidad_organizacional, 
            id_empleado,
        	cargo_empleado,
            id_aprobador,
            cargo_aprobador,
            fecha_solicitud,
            descripcion,
            estado,
            codigo
        ) 
        VALUES (
        	g_id_solicitud_salida,
            al_id_almacen,
            al_id_unidad_organizacional,
            al_id_empleado,
			g_cargo,
			al_id_aprobador,
			g_cargo_aprob,
             CAST((al_fecha_solicitud)::date||' '||to_char(CURRENT_TIMESTAMP,'HH24:MI:SS') as timestamp),
            al_descripcion,
            'pendiente_entrega',
            al_codigo
        );
            
            -- DESCRIPCIÃ??????N DE Ã??????XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tai_solicitud_salida';
  END;
        
  --procedimiento de modificacion      
	ELSIF pm_codigo_procedimiento = 'AL_SOLSAL_UPD' THEN
	BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            select id_solicitud_salida
            into g_id_solicitud_salida
            from alma.tai_solicitud_salida
            where alma.tai_solicitud_salida.id_solicitud_salida = al_id_solicitud_salida;
            
            IF (g_id_solicitud_salida is null) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_solicitud_salida || 'en la tabla alma.tai_solicitud_salida';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;

                UPDATE alma.tai_solicitud_salida SET 
                	usuario_reg = "current_user"() ,
                	fecha_reg = now(),
                    id_almacen = al_id_almacen,
                    id_unidad_organizacional = al_id_unidad_organizacional,
                	id_empleado = al_id_empleado,
                	cargo_empleado = g_cargo,
                	id_aprobador = al_id_aprobador,
                    cargo_aprobador = g_cargo_aprob,
                    fecha_solicitud =  CAST((al_fecha_solicitud)::date||' '||to_char(CURRENT_TIMESTAMP,'HH24:MI:SS') as timestamp),
                    descripcion = al_descripcion
                WHERE alma.tai_solicitud_salida.id_solicitud_salida = al_id_solicitud_salida;
			
		-- DESCRIPCIÃ??????N DE Ã??????XITO PARA GUARDAR EN EL LOG
        
            g_descripcion_log_error := 'Modificacion exitosa en alma.tai_solicitud_salida del registro '||  al_id_solicitud_salida;
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
    ELSIF pm_codigo_procedimiento = 'AL_SOLSAL_DEL' THEN
        
    	BEGIN
            --VERIFICACIÃ??????N DE EXISTENCIA DEL REGISTRO
            select id_solicitud_salida
            into g_id_solicitud_salida
            from alma.tai_solicitud_salida
            where alma.tai_solicitud_salida.id_solicitud_salida = al_id_solicitud_salida;

            IF (g_id_solicitud_salida is null) THEN
                              
                g_descripcion_log_error := 'Eliminacion no realizada: no existe el registro' || al_id_solicitud_salida || 'en la tabla alma.tai_solicitud_salida';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;
              
            DELETE FROM alma.tai_solicitud_salida 
				WHERE alma.tai_solicitud_salida.id_solicitud_salida = al_id_solicitud_salida;
                
 			
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_solicitud_salida||' en alma.tai_solicitud_salida';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
    ELSIF pm_codigo_procedimiento = 'AL_ALACTIVE_UPD' THEN
        
    	BEGIN
            --VERIFICACIÃ???N DE EXISTENCIA DEL REGISTRO
            select id_solicitud_salida, estado
            into g_id_solicitud_salida, g_estado
            from alma.tai_solicitud_salida alma
            where alma.id_solicitud_salida = al_id_solicitud_salida;
            
            IF (g_id_solicitud_salida is null) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_solicitud_salida || 'en la tabla alma.tai_solicitud_salida';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;
            
            if (g_estado = 'borrador') then
            	g_estado = 'pendiente_aprobacion';
            elseif g_estado = 'pediente_aprobacion' then
            	g_estado = 'borrador';
            end if;
            
             UPDATE alma.tai_solicitud_salida SET 
                	estado = g_estado
				WHERE alma.tai_solicitud_salida.id_solicitud_salida = al_id_solicitud_salida;
                
 			
            -- DESCRIPCIÃ???N DE Ã???XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_solicitud_salida||' en alma.tai_solicitud_salida';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
    ELSIF pm_codigo_procedimiento = 'AL_ALACTIV_UPD' THEN
        
    	BEGIN
            --VERIFICACIÃ???N DE EXISTENCIA DEL REGISTRO
            select id_solicitud_salida, estado
            into g_id_solicitud_salida, g_estado
            from alma.tai_solicitud_salida alma
            where alma.id_solicitud_salida = al_id_solicitud_salida;
            
            IF (g_id_solicitud_salida is null) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_solicitud_salida || 'en la tabla alma.tai_solicitud_salida';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;
            
            if (g_estado = 'pendiente_aprobacion') then
            	g_estado = 'pendiente_entrega';
            elseif g_estado = 'pediente_entrega' then
            	g_estado = 'pendiente_aprobacion';
            end if;
            
             UPDATE alma.tai_solicitud_salida SET 
                	estado = g_estado
				WHERE alma.tai_solicitud_salida.id_solicitud_salida = al_id_solicitud_salida;
                
 			
            -- DESCRIPCIÃ???N DE Ã???XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_solicitud_salida||' en alma.tai_solicitud_salida';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
    ELSIF pm_codigo_procedimiento = 'AL_ALACTIV1_UPD' THEN
    	BEGIN
            --VERIFICACIÃ???N DE EXISTENCIA DEL REGISTRO
            select id_solicitud_salida, estado
            into g_id_solicitud_salida, g_estado
            from alma.tai_solicitud_salida alma
            where alma.id_solicitud_salida = al_id_solicitud_salida;
            
            IF (g_id_solicitud_salida is null) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_solicitud_salida || 'en la tabla alma.tai_solicitud_salida';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;
            
            if (g_estado = 'pendiente_aprobacion') then
            	g_estado = 'borrador';
            elseif g_estado = 'borrador' then
            	g_estado = 'pendiente_aprobacion';
            end if;
            
            UPDATE alma.tai_solicitud_salida SET 
                	estado = g_estado
			WHERE alma.tai_solicitud_salida.id_solicitud_salida = al_id_solicitud_salida;
            
 			
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_solicitud_salida||' en alma.tai_solicitud_salida';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
	ELSIF pm_codigo_procedimiento = 'AL_PROCSOL_UPD' THEN
    	BEGIN
        	
            --VERIFICACION DE EXISTENCIA DEL REGISTRO
            select id_solicitud_salida, estado
            into g_id_solicitud_salida, g_estado
            from alma.tai_solicitud_salida alma
            where alma.id_solicitud_salida = al_id_solicitud_salida;
            
            IF (g_id_solicitud_salida is null) THEN
                
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_solicitud_salida || 'en la tabla alma.tai_solicitud_salida';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                
            END IF;
            
            if (g_estado = 'pendiente_entrega') then
            	g_estado = 'proceso_entrega';
            else
            	g_descripcion_log_error := 'Modificacion no realizada: el registro ' || al_id_solicitud_salida || ' no puede pasar a estado proceso_entrega';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
            end if;
            
            for g_solicitud_salida in select
                    sol.id_solicitud_salida,
                    sol.descripcion,
                    sol.id_almacen
                from alma.tai_solicitud_salida sol where sol.id_solicitud_salida = al_id_solicitud_salida
            LOOP
            	INSERT INTO alma.tai_movimiento(
                    id_usuario_reg,
                    fecha_reg,
                    id_tipo_movimiento,
                    id_almacen,
                    fecha_movimiento,
                    descripcion,
                    observaciones,
                    estado,
                    id_solicitud_salida
                ) 
                VALUES (
                    pm_id_usuario,
                    now(),
                    1,
                    g_solicitud_salida.id_almacen,
                    current_date,
                    g_solicitud_salida.descripcion,
                    'Movimiento generado a partir de una Solicitud de Salida de Materiales',
                    'borrador',
                    g_solicitud_salida.id_solicitud_salida
                );
                
                select max(id_movimiento) into g_id_movimiento from alma.tai_movimiento;
                
                -- falta obtener el id_movimiento recientemente insertado.
            	FOR g_detalle_solicitud in select * from alma.tai_detalle_solicitud detsol where detsol.id_solicitud_salida = al_id_solicitud_salida
                LOOP
                	INSERT INTO alma.tai_detalle_movimiento (
                          id_usuario_reg,
                          fecha_reg,
                          id_movimiento,
                          id_item,
                          cantidad,
                          cantidad_solicitada
                          )
                    VALUES (
                          pm_id_usuario, 
                          now(), 
                          g_id_movimiento, 
                          g_detalle_solicitud.id_item, 
                          g_detalle_solicitud.cantidad,
                          g_detalle_solicitud.cantidad
                    );
                END LOOP;
            END LOOP;
                
            
            
            UPDATE alma.tai_solicitud_salida SET 
                estado = g_estado
            WHERE alma.tai_solicitud_salida.id_solicitud_salida = al_id_solicitud_salida;
            
            
            
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_solicitud_salida||' en alma.tai_solicitud_salida';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
          --NUEVO PROCEDIMIENTOS DE SOLICITUDES REGISTRADOS EN FECHA 16062014
        
         --Envio solicitudes para su aprobacion (estado=borrador -> estado=pendiente_aprobacion)
    ELSIF pm_codigo_procedimiento = 'AL_SOLBORFIN_UPD' THEN
        BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO
           IF NOT EXISTS(select 1 from alma.tai_solicitud_salida where alma.tai_solicitud_salida.id_solicitud_salida=al_id_solicitud_salida) 
            THEN       
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_solicitud_salida || 'en la tabla alma.tai_solicitud_salida';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            ELSE
                  --se verifica de que el movimiento finalizado tenga por lo menos un detalle asociado
                  select count(sal.id_solicitud_salida) into g_cant_solicitud
                  from alma.tai_solicitud_salida sal
                  inner join alma.tai_detalle_solicitud det on det.id_solicitud_salida = sal.id_solicitud_salida
                  where sal.id_solicitud_salida=al_id_solicitud_salida;
                  IF (g_cant_solicitud < 1)
                  THEN
                  	g_descripcion_log_error := 'La solicitud seleccionada (' || al_id_solicitud_salida || ') no tiene ningun item asociado';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                  END IF;
            END IF;  
            
            --control de fecha de la solicitud       
            SELECT sol.fecha_solicitud,sol.id_almacen  INTO rec
            FROM alma.tai_solicitud_salida sol 
            WHERE sol.id_solicitud_salida =al_id_solicitud_salida;
            
            SELECT	max(s.fecha_solicitud) INTO fecha_ultima
            FROM alma.tai_solicitud_salida s
            WHERE s.estado = 'entregado' AND s.id_almacen like(rec.id_almacen);
            
            IF(rec.fecha_solicitud < fecha_ultima) THEN  
           
            		g_descripcion_log_error := 'Verifique la fecha de la solicitud, la ultima solicitud del almacen fue aprobada en fecha: '||fecha_ultima||' (las solicitudes nuevas deben ser posteriores a la ultima solicitud aprobada)';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
    		
            END IF;
            
            	
            --no se requiere ningun tipo de control, pues cuando se corrige un movmiento no importa
            UPDATE alma.tai_solicitud_salida
            SET estado = 'pendiente_aprobacion'
            WHERE id_solicitud_salida = al_id_solicitud_salida;
 			     
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa del registro '||al_id_solicitud_salida||' en alma.tai_solicitud_salida';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
            
        END;
     ELSIF pm_codigo_procedimiento = 'AL_SOLPENREV_UPD' THEN
        BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO
           IF NOT EXISTS(select 1 from alma.tai_solicitud_salida where alma.tai_solicitud_salida.id_solicitud_salida=al_id_solicitud_salida) 
            THEN       
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tai_solicitud_salida';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            ELSE
                  --se verifica de que el movimiento finalizado tenga por lo menos un detalle asociado
                  select count(sal.id_solicitud_salida) into g_cant_solicitud
                  from alma.tai_solicitud_salida sal
                  inner join alma.tai_detalle_solicitud det on det.id_solicitud_salida = sal.id_solicitud_salida
                  where sal.id_solicitud_salida=al_id_solicitud_salida;
                  IF (g_cant_solicitud < 1)
                  THEN
                  	g_descripcion_log_error := 'La solicitud seleccionada (' || al_id_solicitud_salida || ') no tiene ningun item asociado';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                  END IF;
            END IF;
                  	
            --no se requiere ningun tipo de control, pues cuando se corrige un movmiento no importa
            UPDATE alma.tai_solicitud_salida
            SET estado = 'borrador'
            WHERE id_solicitud_salida = al_id_solicitud_salida;
 			     
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa del registro '||al_id_solicitud_salida||' en alma.tai_solicitud_salida';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
            
        END;
        
    ELSIF pm_codigo_procedimiento = 'AL_SOLPENFIN_UPD' THEN
        BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO
           IF NOT EXISTS(select 1 from alma.tai_solicitud_salida where alma.tai_solicitud_salida.id_solicitud_salida=al_id_solicitud_salida) 
            THEN       
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tai_solicitud_salida';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            ELSE
                  --se verifica de que la solicitud finalizada tenga por lo menos un detalle asociado
                  select count(sal.id_solicitud_salida) into g_cant_solicitud
                  from alma.tai_solicitud_salida sal
                  inner join alma.tai_detalle_solicitud det on det.id_solicitud_salida = sal.id_solicitud_salida
                  where sal.id_solicitud_salida=al_id_solicitud_salida;
                  IF (g_cant_solicitud < 1)
                  THEN
                  	g_descripcion_log_error := 'La solicitud seleccionada (' || al_id_solicitud_salida || ') no tiene ningun item asociado';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                  END IF;
            END IF;    
            
            
            --control de fecha de la solicitud       
            /*SELECT sol.fecha_solicitud,sol.id_almacen  INTO rec
            FROM alma.tai_solicitud_salida sol 
            WHERE sol.id_solicitud_salida =al_id_solicitud_salida;
            
            SELECT	max(s.fecha_solicitud) INTO fecha_ultima
            FROM alma.tai_solicitud_salida s
            WHERE s.estado = 'entregado' AND s.id_almacen like(rec.id_almacen);
            
            IF(rec.fecha_solicitud < fecha_ultima) THEN  
           
            		g_descripcion_log_error := 'Verifique la fecha de la solicitud, la ultima solicitud del almacen fue aprobada en fecha: '||fecha_ultima||' (las solicitudes nuevas deben ser posteriores a la ultima solicitud aprobada)';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
    		
            END IF;*/
              	
            --control de los saldos de la solicitud con respecto a los movimientos por almacen e item
            FOR g_solicitud_salida IN EXECUTE  ('
            										select sol.id_almacen,det.id_item,det.cantidad,det.fecha_reg
                                                    from alma.tai_solicitud_salida sol
                                                    inner join alma.tai_detalle_solicitud det on det.id_solicitud_salida=sol.id_solicitud_salida
                                                    where sol.id_solicitud_salida like ('||al_id_solicitud_salida||')
            									')
            LOOP
            		g_detalle_solicitud	= (alma.f_ai_calculo_saldo(NULL,al_id_solicitud_salida,g_solicitud_salida.id_almacen,g_solicitud_salida.id_item,'SOLIC'));
                    g_saldo_movimiento = (alma.f_ai_calculo_saldo(NULL,NULL,g_solicitud_salida.id_almacen,g_solicitud_salida.id_item,'MOVIM'));
                    g_saldo_total = g_saldo_movimiento.al_saldo_item - g_detalle_solicitud.al_saldo_item;
                    
                    if (	g_solicitud_salida.cantidad  >  g_saldo_total	)
                    then
                    	select it.id_item,it.nombre into g_det_error	
                        from alma.tai_solicitud_salida  sol
                        inner join alma.tai_detalle_solicitud det on det.id_solicitud_salida=sol.id_solicitud_salida
                        left join alma.tai_item it on it.id_item=det.id_item and it.estado='activo'
                        where sol.id_solicitud_salida = al_id_solicitud_salida and it.id_item=g_solicitud_salida.id_item;
                        
                        g_descripcion_log_error := 'ERROR: Verifique la cantidad de salida de la solicitud : 	'||al_id_solicitud_salida||chr(10)||
                        							'Item : 	'||g_det_error.id_item||' - '||g_det_error.nombre||chr(10)||
                        							'Cantidad Solicitada :	'||g_solicitud_salida.cantidad||chr(10)||
                                                    'Saldo Item (Solicitudes) :	'||g_detalle_solicitud.al_saldo_item||chr(10)||
                                                    'Saldo Item (Movimientos) :	'||g_saldo_movimiento.al_saldo_item||chr(10)||
                                                    'Saldo Item Almacenes :	'||g_saldo_total;
                        g_nivel_error := '4';
                        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                        RETURN 'f'||g_separador||g_respuesta;
                        
                    end if;
                    
            END LOOP;
            
            --generacion del codigo de la solicitud de salida
            g_cod_solicitud = (alma.f_ai_generar_cod_solicitud(al_id_solicitud_salida));
           
           	UPDATE alma.tai_solicitud_salida
            SET estado = 'pendiente_entrega',
            	codigo = g_cod_solicitud
            WHERE id_solicitud_salida = al_id_solicitud_salida;
 			
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa del registro '||al_id_solicitud_salida||' en alma.tai_solicitud_salida';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
            
        END;
    ELSIF pm_codigo_procedimiento = 'AL_SOLPROC_UPD' THEN
        BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO
           IF NOT EXISTS(select 1 from alma.tai_solicitud_salida where alma.tai_solicitud_salida.id_solicitud_salida=al_id_solicitud_salida) 
            THEN       
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tai_solicitud_salida';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            ELSE
                  --se verifica de que la solicitud finalizada tenga por lo menos un detalle asociado
                  select count(sal.id_solicitud_salida) into g_cant_solicitud
                  from alma.tai_solicitud_salida sal
                  inner join alma.tai_detalle_solicitud det on det.id_solicitud_salida = sal.id_solicitud_salida
                  where sal.id_solicitud_salida=al_id_solicitud_salida;
                  IF (g_cant_solicitud < 1)
                  THEN
                  	g_descripcion_log_error := 'La solicitud seleccionada (' || al_id_solicitud_salida || ') no tiene ningun item asociado';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                  END IF;
            END IF;      	
            /*llamada funcion que genera el movimiento de salida*/
            select "alma"."f_ai_procesar_solicitud"(pm_id_usuario,pm_ip_origen,al_id_solicitud_salida,'PROCSOL') into g_res;
            
           	UPDATE alma.tai_solicitud_salida
            SET estado = 'proceso_entrega'
            WHERE id_solicitud_salida = al_id_solicitud_salida;
 			
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa del registro '||al_id_solicitud_salida||' en alma.tai_solicitud_salida';
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

        --SE OBTIENE EL MENSAJE Y EL NÃ??????MERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
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