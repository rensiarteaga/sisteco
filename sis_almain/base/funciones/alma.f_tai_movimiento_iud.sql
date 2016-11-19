--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_tai_movimiento_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_movimiento integer,
  al_id_tipo_movimiento integer,
  al_id_almacen integer,
  al_id_solicitud_salida integer,
  al_codigo varchar,
  al_fecha_movimiento timestamp,
  al_descripcion varchar,
  al_observaciones varchar,
  al_id_almacen_dest integer,
  al_id_mov_origen integer,
  al_nro_compra varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA Almacen ONLINE
***************************************************************************
 SCRIPT:          alma.f_tai_movimiento_iud
 DESCRIPCION:     Realiza modificaciones en la tabla alma.tai_movimiento
 AUTOR:           Ruddy Lujan Bravo
 FECHA:           06-09-2013 17:10:00
 COMENTARIOS:    
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCION:  
 AUTOR:           Ruddy Lujan Bravo
 FECHA:           06-09-2013 17:10:00

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
	g_requiere_aprobacion			varchar;
    g_det_movimiento				record;
    g_cant_detalle_movimiento		integer;
    g_saldo_movimientos		    	record;
    g_saldo_reservados				record;
    g_det_item						record;
    g_res							varchar;
    g_id_sol_salida					integer;  
    g_cod_movimento					text;
    
    g_valorizacion					varchar;
    g_fecha							boolean;	--CONTROLA LAS FECHAS DE FINALIZACION DE LOS MOVIMIENTOS
    g_fecha_movimento				date;
    
    g_control_ubicacion				boolean;
    g_tipo_movimiento				record;
    g_control_stock					boolean;
    
BEGIN
---*** INICIACION DE VARIABLES 
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funcion	
    g_nombre_funcion :='f_tai_movimiento_iud';
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
    
    
     if(al_id_almacen IS NOT NULL) 
    THEN
    
      if EXISTS(select 1 from alma.tai_almacen a where a.estado = 'inactivo' and a.id_almacen =al_id_almacen) then
          g_descripcion_log_error := 'Verifique el estado del almacen : No se pueden realizar movimientos sobre almacenes inactivos';
          g_nivel_error := '4';
          g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
          RETURN 'f'||g_separador||g_respuesta;
      end if;
    ELSE
    	if EXISTS(	SELECT 1 
        			FROM alma.tai_movimiento mov 
        			INNER JOIN alma.tai_almacen alm on alm.id_almacen = mov.id_almacen AND alm.estado = 'inactivo'
                    WHERE mov.id_movimiento = al_id_movimiento)
    	then
        
        	raise exception 'No se pueden realizar operaciones sobre almacenes inactivos.';
        
        end if;
    END IF;
    
      --*** EJECUCION DEL PROCEDIMIENTO ESPECIFICO
    IF pm_codigo_procedimiento = 'AL_MOVI_INS' THEN
    BEGIN
    	--si tipo_movimiento='ingreso' -> fecha_movimiento=now() sino fecha_movimiento=al_fecha_movimiento
		if al_fecha_movimiento is null
        then
        	g_fecha_movimento := now()::TIMESTAMP;
        else
        	g_fecha_movimento := al_fecha_movimiento;
        end if;
        --control de transpaso en un mismo almacen
        if al_id_almacen = al_id_almacen_dest
        then
        		g_descripcion_log_error := 'Insercion no realizada: El transpaso entre un mismo almacen no esta permitido!!!';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
        end if;
        
        --control añadido para que no se registren movimientos con fecha anterior a la fecha del ultimo movimiento finalizado en el almacen
        
        if EXISTS(select 1 from alma.tai_movimiento a where a.id_almacen=al_id_almacen AND a.estado='finalizado') then
        	select max(m.fecha_finalizacion) as fecha_ult_movimiento  into g_det_movimiento
            from alma.tai_movimiento m
            where m.id_almacen=al_id_almacen and m.estado='finalizado';
            
            if al_fecha_movimiento < g_det_movimiento.fecha_ult_movimiento then
            
            	g_descripcion_log_error := 'Insercion no realizada: la fecha ingresada ('||al_fecha_movimiento||') no puede ser anterior a la fecha del último movimiento finalizado del almacen ('||g_det_movimiento.fecha_ult_movimiento||')';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                
            end if;
            
        end if;
        
        
		INSERT INTO alma.tai_movimiento(
            id_tipo_movimiento,
			id_almacen,
            id_solicitud_salida,
            codigo,
            fecha_movimiento,
        	descripcion,
            observaciones,
            estado
            ,id_almacen_trans
            ,id_movimiento_fk
              ,nro_compra
            
        ) 
        VALUES (
            al_id_tipo_movimiento,
            al_id_almacen,
            al_id_solicitud_salida,
			al_codigo,
        	g_fecha_movimento,
        	al_descripcion,
            al_observaciones,
            'borrador'
            ,al_id_almacen_dest
            ,al_id_mov_origen
             ,al_nro_compra     
            	
        );
            
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tai_movimiento';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;   
        END;
        
  --procedimiento de modificacion      
	ELSIF pm_codigo_procedimiento = 'AL_MOVI_UPD' THEN
	BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            select id_movimiento
            into g_id_movimiento
            from alma.tai_movimiento alma
            where alma.id_movimiento = al_id_movimiento;
            
            IF (g_id_movimiento is null) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tai_movimiento';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;
            
            if al_id_almacen = al_id_almacen_dest
        	then
        		g_descripcion_log_error := 'Modificacion no realizada: El transpaso entre un mismo almacen no esta permitido!!!';
            	g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
        	end if;

                UPDATE alma.tai_movimiento SET 
                	usuario_reg = "current_user"() ,
                	fecha_reg = now(),
                    id_tipo_movimiento = al_id_tipo_movimiento,
                    id_almacen = al_id_almacen,
                    id_solicitud_salida = al_id_solicitud_salida,
                	codigo = al_codigo,
                	fecha_movimiento = al_fecha_movimiento,
                    descripcion = al_descripcion,
                    observaciones = al_observaciones
                    ,id_almacen_trans = al_id_almacen_dest
                    ,id_movimiento_fk = al_id_mov_origen
                     ,nro_compra = al_nro_compra
                    
                    
				WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
                
			
		-- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa en alma.tai_movimiento del registro '||  al_id_movimiento;
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
        ELSIF pm_codigo_procedimiento = 'AL_MOVI_DEL' THEN
        
    	BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO
            select id_movimiento
            into g_id_movimiento
            from alma.tai_movimiento alma
            where alma.id_movimiento = al_id_movimiento;
            
            IF (g_id_movimiento is null) THEN
                              
                g_descripcion_log_error := 'Eliminacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tai_movimiento';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;
             
            -- VERIFICACIÓN DE EXISTENCIA DE HIJOS
            IF EXISTS(SELECT 1 FROM alma.tai_movimiento
                     INNER JOIN alma.tai_detalle_movimiento ON alma.tai_detalle_movimiento.id_movimiento=alma.tai_movimiento.id_movimiento
                     WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento) THEN
                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: El movimiento tiene Conceptos asociados en el Detalle';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF; 
            
            DELETE FROM alma.tai_movimiento 
				WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
                
 			
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_movimiento||' en alma.tai_movimiento';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
		
        ELSIF pm_codigo_procedimiento = 'AL_ALACTIVE_UPD' THEN
        
    	BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO
            select id_movimiento, estado
            into g_id_movimiento, g_estado
            from alma.tai_movimiento alma
            where alma.id_movimiento = al_id_movimiento;
            
            IF (g_id_movimiento is null) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tai_movimiento';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;
            
            if (g_estado = 'borrador') then
            	g_estado = 'finalizado';
            elseif g_estado = 'finalizado' then
            	g_estado = 'borrador';
            end if;
            
             UPDATE alma.tai_movimiento SET 
                	estado = g_estado
				WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
                
 			
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_movimiento||' en alma.tai_movimiento';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
         ELSIF pm_codigo_procedimiento = 'AL_ALACTIV_UPD' THEN
        
    	BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO
            select id_movimiento, estado
            into g_id_movimiento, g_estado
            from alma.tai_movimiento alma
            where alma.id_movimiento = al_id_movimiento;
            
            IF (g_id_movimiento is null) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tai_movimiento';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;
            
            if (g_estado = 'proceso_aprobacion') then
            	g_estado = 'finalizado';
            elseif g_estado = 'finalizado' then
            	g_estado = 'proceso_aprobacion';
            end if;
            
             UPDATE alma.tai_movimiento SET 
                	estado = g_estado
				WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
                
 			
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_movimiento||' en alma.tai_movimiento';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
         ELSIF pm_codigo_procedimiento = 'AL_ALACTIV1_UPD' THEN
        
    	BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO
            select id_movimiento, estado
            into g_id_movimiento, g_estado
            from alma.tai_movimiento alma
            where alma.id_movimiento = al_id_movimiento;
            
            IF (g_id_movimiento is null) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tai_movimiento';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;
            
            if (g_estado = 'proceso_aprobacion') then
            	g_estado = 'borrador';
            elseif g_estado = 'borrador' then
            	g_estado = 'proceso_aprobacion';
            end if;
            
             UPDATE alma.tai_movimiento SET 
                	estado = g_estado
				WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
                
 			
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_movimiento||' en alma.tai_movimiento';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
        ELSIF pm_codigo_procedimiento = 'AL_ALACTIVE2_UPD' THEN
        
    	BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO
            select mov.id_movimiento, tip.requiere_aprobacion
            into g_id_movimiento, g_requiere_aprobacion
            from alma.tai_movimiento mov
            INNER JOIN alma.tai_tipo_movimiento  tip ON tip.id_tipo_movimiento = mov.id_tipo_movimiento
            where mov.id_movimiento = al_id_movimiento;
            
            IF (g_id_movimiento is null) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tai_movimiento';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;
            
            if (g_requiere_aprobacion = 'no') then
            	g_estado = 'finalizado';
            elseif g_requiere_aprobacion = 'si' then
            	g_estado = 'proceso_aprobacion';
            end if;
            
             UPDATE alma.tai_movimiento SET 
                	estado = g_estado
				WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
                
 			
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_movimiento||' en alma.tai_movimiento';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
        --Inicio de los procedimientos para la administracion de los flujos de los movimientos
        ELSIF pm_codigo_procedimiento = 'AL_MOVINGNO_UPD' THEN
        BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(select 1 from alma.tai_movimiento where alma.tai_movimiento.id_movimiento=al_id_movimiento) 
            THEN       
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tai_movimiento';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            ELSE
                  --se verifica de que el movimiento finalizado tenga por lo menos un detalle  item asociado
                  select count(det.id_detalle_movimiento) into g_cant_detalle_movimiento
                  from alma.tai_movimiento mov
                  inner join alma.tai_detalle_movimiento det on det.id_movimiento = mov.id_movimiento
                  where mov.id_movimiento=al_id_movimiento;
                  IF (g_cant_detalle_movimiento < 1)
                  THEN
                  	g_descripcion_log_error := 'El movimiento seleccionado (' || al_id_movimiento || ') no tiene ningun item asociado';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                  END IF;
                  
            END IF;
        

            --llamada a la funcion que controla las fecha de finalizacion de los movimientos
            select alma.f_control_fecha_finalizacion(al_id_movimiento) into g_fecha;
            /*
            *  g_fecha ='f'->paso todos los controles de fecha
            *  otro valor no existiria, pues ingresaria a la excepcion
            */
            
            if ( g_fecha = 'f')
            then
            	 
                select tm.tipo,tm.requiere_aprobacion,mov.codigo into g_det_movimiento
                from alma.tai_movimiento mov
                inner join alma.tai_tipo_movimiento tm on tm.id_tipo_movimiento = mov.id_tipo_movimiento
                where mov.id_movimiento = al_id_movimiento;
              
                    if g_det_movimiento.codigo is NULL
                    then 
                        --generacion del codigo del movmiento
                        --g_cod_movimento = alma.f_ai_generar_cod_movimiento(al_id_movimiento);
                        
                        if(g_det_movimiento.tipo = 'ingreso' AND g_det_movimiento.requiere_aprobacion = 'no')
                        then
                            UPDATE alma.tai_movimiento SET 
                            estado = 'valorado',--'finalizado',
                          --  codigo = g_cod_movimento,
                            fecha_finalizacion = now()
                            WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
                        end if;
                    else
                              if(g_det_movimiento.tipo = 'ingreso' AND g_det_movimiento.requiere_aprobacion = 'no')
                              then
                                  UPDATE alma.tai_movimiento SET 
                                  estado = 'valorado'
                                  ,fecha_finalizacion = now()
                                  WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
                              end if;
                    end if;
            	 
            end if;
          	
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa del registro '||al_id_movimiento||' en alma.tai_movimiento';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
        --Revertir un movimento de ingreso o salida que requiere aprobacion
        ELSIF ( pm_codigo_procedimiento = 'AL_MOVREV_UPD')
        THEN
        BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(select 1 from alma.tai_movimiento where alma.tai_movimiento.id_movimiento=al_id_movimiento) 
            THEN       
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tai_movimiento';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;
            select tm.tipo,tm.requiere_aprobacion into g_det_movimiento
            from alma.tai_movimiento mov
            inner join alma.tai_tipo_movimiento tm on tm.id_tipo_movimiento = mov.id_tipo_movimiento
            where mov.id_movimiento = al_id_movimiento;
           	
            --no se requiere ningun tipo de control, pues cuando se corrige un movmiento no importa
                	UPDATE alma.tai_movimiento SET 
                	estado = 'borrador'
					WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
               
 			
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa del registro '||al_id_movimiento||' en alma.tai_movimiento';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        -- Cambio de estado un movimiento de ingreso o salida que requiere aprobacion de boorador a pendiente_aprobacion
        ELSIF ( pm_codigo_procedimiento = 'AL_MOVAPRO_UPD')
        THEN
        BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(select 1 from alma.tai_movimiento where alma.tai_movimiento.id_movimiento=al_id_movimiento) 
            THEN       
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tai_movimiento';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            ELSE
                  --se verifica de que el movimiento finalizado tenga por lo menos un detalle  item asociado
                  select count(det.id_detalle_movimiento) into g_cant_detalle_movimiento
                  from alma.tai_movimiento mov
                  inner join alma.tai_detalle_movimiento det on det.id_movimiento = mov.id_movimiento
                  where mov.id_movimiento=al_id_movimiento;
                  IF (g_cant_detalle_movimiento < 1)
                  THEN
                  	g_descripcion_log_error := 'El movimiento seleccionado (' || al_id_movimiento || ') no tiene ningun item asociado';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                  END IF;

            END IF;
                       	
            --control costos
            if EXISTS (select 1 from alma.tai_movimiento mov 
            		    inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
            			inner join alma.tai_detalle_movimiento det on det.id_movimiento=mov.id_movimiento
                        where det.id_movimiento=al_id_movimiento and det.costo_total <= 0 and (tip.tipo='transpaso_ingreso' OR tip.tipo='transpaso_salida')
                        )
            then
            		g_descripcion_log_error :=  'Los costos totales del transpaso no pueden ser 0 '||chr(10)||'Verifique los costos totales de los items asociados al movimiento :'||al_id_movimiento;
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
            end if;
            
            --control de fechas 
            if (select alma.f_control_fecha_finalizacion(al_id_movimiento) = 't')
            then
            		select max(mov.fecha_movimiento) into g_fecha_movimento from alma.tai_movimiento mov where mov.estado = 'finalizado';
            		raise exception 'Verifique la fecha de finalizacion del ultimo movimiento del almacen. No se pueden finalizar movimientos anteriores al : %',g_fecha_movimento;
            end if;
            
            --control stock
            if(select alma.f_control_stock_item(al_id_movimiento) = 'f')then
            	g_descripcion_log_error := 'Verifique el stock de items permitidos en el almacen.';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            end if;
            
            
                	UPDATE alma.tai_movimiento SET 
                	estado = 'pendiente_aprobacion'
					WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
               
 			
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa del registro '||al_id_movimiento||' en alma.tai_movimiento';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        --Movimiento ingreso con aprobacion
        ELSIF ( pm_codigo_procedimiento = 'AL_MOVFINING_UPD')
        THEN
        BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(select 1 from alma.tai_movimiento where alma.tai_movimiento.id_movimiento=al_id_movimiento) 
            THEN       
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tai_movimiento';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            ELSE
                  --se verifica de que el movimiento finalizado tenga por lo menos un detalle  item asociado
                  select count(det.id_detalle_movimiento) into g_cant_detalle_movimiento
                  from alma.tai_movimiento mov
                  inner join alma.tai_detalle_movimiento det on det.id_movimiento = mov.id_movimiento
                  where mov.id_movimiento=al_id_movimiento;
                  IF (g_cant_detalle_movimiento < 1)
                  THEN
                  	g_descripcion_log_error := 'El movimiento seleccionado (' || al_id_movimiento || ') no tiene ningun item asociado';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                  END IF;

            END IF;
            
             --llamada a la funcion que controla las fecha de finalizacion de los movimientos
            select alma.f_control_fecha_finalizacion(al_id_movimiento) into g_fecha;
            /*
            *  g_fecha ='f'->paso todos los controles de fecha
            *  otro valor no existiria, pues ingresaria a la excepcion
            */
            if ( g_fecha = 'f') THEN
                  select tm.tipo,tm.requiere_aprobacion,mov.codigo into g_det_movimiento
                  from alma.tai_movimiento mov
                  inner join alma.tai_tipo_movimiento tm on tm.id_tipo_movimiento = mov.id_tipo_movimiento
                  where mov.id_movimiento = al_id_movimiento;
            
                  if g_det_movimiento.codigo is NULL
                  then 
                      --generacion del codigo del movmiento
                      --g_cod_movimento = alma.f_ai_generar_cod_movimiento(al_id_movimiento);
                      
                      UPDATE alma.tai_movimiento SET 
                      estado = 'valorado',--'finalizado',
                     -- codigo = g_cod_movimento,
                      fecha_finalizacion = now()
                      WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
                  else
                  
                      UPDATE alma.tai_movimiento SET 
                      estado = 'valorado',
                      fecha_finalizacion = now()
                      WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
                      
                  end if;
            END if;
 			
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa del registro '||al_id_movimiento||' en alma.tai_movimiento';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        --Movimiento salida con aprobacion
        ELSIF ( pm_codigo_procedimiento = 'AL_MOVFINSAL_UPD')
        THEN
        BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(select 1 from alma.tai_movimiento where alma.tai_movimiento.id_movimiento=al_id_movimiento) 
            THEN       
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tai_movimiento';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            ELSE
                  --se verifica de que el movimiento finalizado tenga por lo menos un detalle  item asociado
                  select count(det.id_detalle_movimiento) into g_cant_detalle_movimiento
                  from alma.tai_movimiento mov
                  inner join alma.tai_detalle_movimiento det on det.id_movimiento = mov.id_movimiento
                  where mov.id_movimiento=al_id_movimiento;
                  IF (g_cant_detalle_movimiento < 1)
                  THEN
                  	g_descripcion_log_error := 'El movimiento seleccionado (' || al_id_movimiento || ') no tiene ningun item asociado';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                  END IF;
            END IF;
            
             --llamada a la funcion que controla las fecha de finalizacion de los movimientos
            select alma.f_control_fecha_finalizacion(al_id_movimiento) into g_fecha;
            /*
            *  g_fecha ='f'->paso todos los controles de fecha
            *  otro valor no existiria, pues ingresaria a la excepcion
            */
            if ( g_fecha = 'f') THEN
            
                    /*
                        1. Obtener datos del movimiento a ser finalizado(id_almacen,id_item,tipo_movimiento,cantidad)
                        1.1 FOR (cada item del movimiento a finalizar)
                                 llamar a la funcion que calcula el saldo de ese item segun el almacen(id_almacen)
                    */
                        FOR g_det_movimiento in execute('  	select mov.id_almacen,det.id_item,sum (det.cantidad) as cantidad,tip.tipo
                                                                from alma.tai_movimiento mov
                                                                inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                                                                inner join alma.tai_detalle_movimiento det on det.id_movimiento=mov.id_movimiento
                                                                where mov.id_movimiento= '||al_id_movimiento||'
                                                                group by det.id_item,mov.id_almacen,tip.tipo
                                                                order by det.id_item ASC	
                                                        ')
                        LOOP
                        --g_saldo := alma.f_ai_calcular_saldo_movimento(al_id_movimiento,g_det_movimiento.id_almacen,g_det_movimiento.id_item);
                        g_saldo_movimientos	= alma.f_ai_calculo_saldo(NULL,NULL,g_det_movimiento.id_almacen,g_det_movimiento.id_item,'MOVIM');
                        g_saldo_reservados = alma.f_ai_calculo_saldo(NULL,NULL,g_det_movimiento.id_almacen,g_det_movimiento.id_item,'SOLIC');
                            
                           --comparacion saldo del item en un almacen con la cantidad del item en el movimiento de salida
                            if (g_det_movimiento.cantidad > (g_saldo_movimientos.al_saldo_item - g_saldo_reservados.al_saldo_item))
                            then
                                select it.nombre into g_det_item
                                from alma.tai_item it
                                where it.id_item=g_det_movimiento.id_item;
                                
                                g_descripcion_log_error := 'ERROR: Verifique la cantidad de salida del movimiento: '||al_id_movimiento||chr(10)||
                                                            'Cantidad Salida:'||g_det_movimiento.cantidad||chr(10)||
                                                            'Saldo Total Item : '||g_saldo_movimientos.al_saldo_item - g_saldo_reservados.al_saldo_item||chr(10)||
                                                            'Saldo Item (movimientos):'||g_saldo_movimientos.al_saldo_item||' ('||g_det_movimiento.id_item||' - '||g_det_item.nombre||' )'||chr(10)||
                                                            'Saldo Item (reservas) :'||g_saldo_reservados.al_saldo_item||' ('||g_det_movimiento.id_item||' - '||g_det_item.nombre||' )';
                                g_nivel_error := '4';
                                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                                RETURN 'f'||g_separador||g_respuesta;
                            end if;
                        END LOOP;
                        select tm.tipo,tm.requiere_aprobacion,mov.codigo into g_det_movimiento
                        from alma.tai_movimiento mov
                        inner join alma.tai_tipo_movimiento tm on tm.id_tipo_movimiento = mov.id_tipo_movimiento
                        where mov.id_movimiento = al_id_movimiento;
                  
                        if g_det_movimiento.codigo is NULL
                        then 
                            --generacion del codigo del movmiento
                            g_cod_movimento = alma.f_ai_generar_cod_movimiento(al_id_movimiento);
                            
                            --valorizacion de la salida
                            g_valorizacion:= alma.f_ai_valorizar_movimiento(al_id_movimiento);
                            
                            UPDATE alma.tai_movimiento
                            SET estado ='finalizado',
                            codigo = g_cod_movimento,
                            fecha_finalizacion = now()
                            WHERE id_movimiento=al_id_movimiento;
                            
                        else
                        	--valorizacion de la salida
                            g_valorizacion:= alma.f_ai_valorizar_movimiento(al_id_movimiento);	
                        
                            UPDATE alma.tai_movimiento
                            SET estado ='finalizado',
                            fecha_finalizacion = now()
                            WHERE id_movimiento=al_id_movimiento;
                        
                        end if;
            END if;
        
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa  '||al_id_movimiento||' en alma.tai_movimiento';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
        
        -- Movimiento salida sin aprobacion
        ELSIF ( pm_codigo_procedimiento = 'AL_MOVSALNO_UPD')
        THEN
        BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(select 1 from alma.tai_movimiento where alma.tai_movimiento.id_movimiento=al_id_movimiento) 
            THEN       
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tai_movimiento';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            ELSE
                  --se verifica de que el movimiento finalizado tenga por lo menos un detalle  item asociado
                  select count(det.id_detalle_movimiento) into g_cant_detalle_movimiento
                  from alma.tai_movimiento mov
                  inner join alma.tai_detalle_movimiento det on det.id_movimiento = mov.id_movimiento
                  where mov.id_movimiento=al_id_movimiento;
                  IF (g_cant_detalle_movimiento < 1)
                  THEN
                  	g_descripcion_log_error := 'El movimiento seleccionado (' || al_id_movimiento || ') no tiene ningun item asociado';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                  END IF;
            END IF;
            
           	--llamada a la funcion que controla las fecha de finalizacion de los movimientos
            select alma.f_control_fecha_finalizacion(al_id_movimiento) into g_fecha;
            /*
            *  g_fecha ='f'->paso todos los controles de fecha
            *  otro valor no existiria, pues ingresaria a la excepcion
            */
            if ( g_fecha = 'f') THEN
                /*
                    1. Obtener datos del movimiento a ser finalizado(id_almacen,id_item,tipo_movimiento,cantidad)
                    1.1 FOR (cada item del movimiento a finalizar)
                             llamar a la funcion que calcula el saldo de ese item segun el almacen(id_almacen)
                */
                    FOR g_det_movimiento in execute('  	select mov.id_almacen,det.id_item,sum (det.cantidad) as cantidad,tip.tipo
                                                            from alma.tai_movimiento mov
                                                            inner join alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                                                            inner join alma.tai_detalle_movimiento det on det.id_movimiento=mov.id_movimiento
                                                            where mov.id_movimiento= '||al_id_movimiento||'
                                                            group by det.id_item,mov.id_almacen,tip.tipo
                                                            order by det.id_item ASC	
                                                    ')
                    LOOP
                    --g_saldo = alma.f_ai_calcular_saldo_movimento(al_id_movimiento,g_det_movimiento.id_almacen,g_det_movimiento.id_item);
                    g_saldo_movimientos	= alma.f_ai_calculo_saldo(NULL,NULL,g_det_movimiento.id_almacen,g_det_movimiento.id_item,'MOVIM');   
                       --comparacion saldo del item en un almacen con la cantidad del item en el movimiento de salida
                        if (g_det_movimiento.cantidad > g_saldo_movimientos.al_saldo_item)
                        then
                            select it.nombre into g_det_item
                            from alma.tai_item it
                            where it.id_item=g_det_movimiento.id_item;
                            
                            g_descripcion_log_error := 'ERROR: Verifique la cantidad de salida del movimiento: '||al_id_movimiento||chr(10)||
                                                        'Cantidad Salida:'||g_det_movimiento.cantidad||chr(10)||
                                                        'Saldo Item :'||g_saldo_movimientos.al_saldo_item||' ('||g_det_movimiento.id_item||' - '||g_det_item.nombre||' )';
                            g_nivel_error := '4';
                            g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                            RETURN 'f'||g_separador||g_respuesta;
                        end if;
                    END LOOP;
                    
                    select tm.tipo,tm.requiere_aprobacion,mov.codigo into g_det_movimiento
                    from alma.tai_movimiento mov
                    inner join alma.tai_tipo_movimiento tm on tm.id_tipo_movimiento = mov.id_tipo_movimiento
                    where mov.id_movimiento = al_id_movimiento;
              
                    if g_det_movimiento.codigo is NULL
                    then 
                        --generacion del codigo del movmiento
                        g_cod_movimento = alma.f_ai_generar_cod_movimiento(al_id_movimiento);
                        
                         --valorizacion de la salida
                         g_valorizacion:= alma.f_ai_valorizar_movimiento(al_id_movimiento);
                 
                        --Se cambia el estado del movimiento de salida sin aprobacion a valorado
                        UPDATE alma.tai_movimiento
                        SET estado='finalizado',
                        codigo = g_cod_movimento,
                        fecha_finalizacion = now()
                        WHERE id_movimiento=al_id_movimiento;
                    else
                    
                    	--valorizacion de la salida
                         g_valorizacion:= alma.f_ai_valorizar_movimiento(al_id_movimiento);
                         
                        --Se cambia el estado del movimiento de salida sin aprobacion a valorado
                        UPDATE alma.tai_movimiento
                        SET estado='finalizado'
                        ,fecha_finalizacion = now()
                        WHERE id_movimiento=al_id_movimiento;
                    end if;
                    
                END if;
        
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa  '||al_id_movimiento||' en alma.tai_movimiento';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
        --finalizacion de  movimiento con id_solicitud_salida != null
        ELSIF ( pm_codigo_procedimiento = 'AL_FINSOLIC_UPD')THEN
        BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(select 1 from alma.tai_movimiento where alma.tai_movimiento.id_movimiento=al_id_movimiento) 
            THEN       
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tai_movimiento';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            ELSE
                  --se verifica de que el movimiento finalizado tenga por lo menos un detalle  item asociado
                  select count(det.id_detalle_movimiento) into g_cant_detalle_movimiento
                  from alma.tai_movimiento mov
                  inner join alma.tai_detalle_movimiento det on det.id_movimiento = mov.id_movimiento
                  where mov.id_movimiento=al_id_movimiento;
                  IF (g_cant_detalle_movimiento < 1)
                  THEN
                  	g_descripcion_log_error := 'El movimiento seleccionado (' || al_id_movimiento || ') no tiene ningun item asociado';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                  END IF;
            END IF;
           
            --llamada a la funcion que controla las fechas de finalizacion de los movimientos
            select alma.f_control_fecha_finalizacion(al_id_movimiento) into g_fecha;
            /*
            *  g_fecha ='f'->paso todos los controles de fecha
            *  otro valor no existiria, pues ingresaria a la excepcion
            */
            if ( g_fecha = 'f') THEN
           --       raise exception 'llega';
            	--se verifica que el movimiento a finalizar tenga en detalle_movimiento 1 item con tipo_saldo='por_entregar'
            
                  if EXISTS(	select 1 
                              from alma.tai_movimiento mov inner join alma.tai_detalle_movimiento det on det.id_movimiento=mov.id_movimiento 
                              where mov.id_movimiento=al_id_movimiento and det.tipo_saldo='por_entregar' )
                  then
                      --llamada a la funcion que registra una nueva solicitud con estado='pendiente de entrega'
                      --llamada a la funcion que registra el detalle de la la solicitud a finalizar
                      select alma.f_ai_procesar_solicitud(pm_id_usuario,pm_ip_origen,al_id_movimiento,'FINSOL') into g_res;
                      
                       -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
                      g_descripcion_log_error := 'Registro exitoso en alma.tai_solicitud_salida ' || al_id_solicitud_salida;
                      g_respuesta := 't'||g_separador||g_descripcion_log_error;
                      
                  end if;
                  
                   --llamada a la funcion para valorizar la solicitud de salida
              	   g_valorizacion:= alma.f_ai_valorizar_movimiento(al_id_movimiento);
                  
                  --finaliza el movimiento
                  UPDATE alma.tai_movimiento SET 
                  estado = 'finalizado',
                 -- codigo = g_cod_movimento,
                   fecha_finalizacion = now()
                  WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;
                 
                  --finaliza la solicitud
                  select mov.id_solicitud_salida into g_id_sol_salida
                  from alma.tai_movimiento  mov
                  where mov.id_movimiento=al_id_movimiento;
                  
                  UPDATE alma.tai_solicitud_salida SET
                  estado = 'entregado'
                  WHERE alma.tai_solicitud_salida.id_solicitud_salida = g_id_sol_salida;
                  
           END if;
                     
            
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa del registro '||al_id_movimiento||' en alma.tai_movimiento';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        --valorizacion de los movimientos
        ELSIF ( pm_codigo_procedimiento = 'AL_VALOR_UPD')
        THEN
        BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(select 1 from alma.tai_movimiento where alma.tai_movimiento.id_movimiento=al_id_movimiento) 
            THEN       
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tai_movimiento';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            ELSE
                  --se verifica de que el movimiento finalizado tenga por lo menos un detalle  item asociado
                  select count(det.id_detalle_movimiento) into g_cant_detalle_movimiento
                  from alma.tai_movimiento mov
                  inner join alma.tai_detalle_movimiento det on det.id_movimiento = mov.id_movimiento
                  where mov.id_movimiento=al_id_movimiento;
                  IF (g_cant_detalle_movimiento < 1)
                  THEN
                  	g_descripcion_log_error := 'El movimiento seleccionado (' || al_id_movimiento || ') no tiene ningun item asociado';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                  END IF;

            END IF;

            --llamada a la funcion para valorizar un movimiento
              g_valorizacion:= alma.f_ai_valorizar_movimiento(al_id_movimiento);
                            
              select tm.tipo,tm.requiere_aprobacion,mov.codigo into g_det_movimiento
              from alma.tai_movimiento mov
              inner join alma.tai_tipo_movimiento tm on tm.id_tipo_movimiento = mov.id_tipo_movimiento
              where mov.id_movimiento = al_id_movimiento;
              
              
              if g_det_movimiento.codigo is NULL
              then 
              	--generacion del codigo del movmiento
                g_cod_movimento = alma.f_ai_generar_cod_movimiento(al_id_movimiento);
                
                --finaliza el movimiento
                UPDATE alma.tai_movimiento SET 
                estado = 'finalizado',
                codigo = g_cod_movimento,
                fecha_finalizacion = now()
                WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;	
             
              else
              
              	UPDATE alma.tai_movimiento SET 
                estado = 'finalizado',
                fecha_finalizacion = now()
                WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;	
                    
              end if;
              
                          
              --solicitud de salida
              select mov.id_solicitud_salida into g_id_sol_salida
              from alma.tai_movimiento  mov
              where mov.id_movimiento=al_id_movimiento;
              
              if g_id_sol_salida is NOT NULL
              then
                    UPDATE alma.tai_solicitud_salida SET
                    estado = 'entregado'
                    WHERE alma.tai_solicitud_salida.id_solicitud_salida = g_id_sol_salida;             
              end if;
 			
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa del registro '||al_id_movimiento||' en alma.tai_movimiento';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        --correcion de los movimientos en estado='valorizado' -> estado='borrador'
        ELSIF pm_codigo_procedimiento = 'AL_CORREGMOV_UPD'
        THEN
        BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(select 1 from alma.tai_movimiento where alma.tai_movimiento.id_movimiento=al_id_movimiento) 
            THEN       
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tai_movimiento';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            ELSE
                  --se verifica de que el movimiento finalizado tenga por lo menos un detalle  item asociado
                  select count(det.id_detalle_movimiento) into g_cant_detalle_movimiento
                  from alma.tai_movimiento mov
                  inner join alma.tai_detalle_movimiento det on det.id_movimiento = mov.id_movimiento
                  where mov.id_movimiento=al_id_movimiento;
                  IF (g_cant_detalle_movimiento < 1)
                  THEN
                  	g_descripcion_log_error := 'El movimiento seleccionado (' || al_id_movimiento || ') no tiene ningun item asociado';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                  END IF;

            END IF;
                          
              --cambio de estado del movimiento corregido
              UPDATE alma.tai_movimiento SET 
              estado = 'borrador',
              fecha_finalizacion = null
              WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;	
   			
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa del registro '||al_id_movimiento||' en alma.tai_movimiento';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        --cambio de estado de un transpaso de items de borrador a pendiente_aprobacion
    ELSIF pm_codigo_procedimiento = 'AL_TRANSMOV_UPD'
        THEN
        BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(select 1 from alma.tai_movimiento where alma.tai_movimiento.id_movimiento=al_id_movimiento) 
            THEN       
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tai_movimiento';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            ELSE
                  --se verifica de que el movimiento finalizado tenga por lo menos un detalle  item asociado
                  select count(det.id_detalle_movimiento) into g_cant_detalle_movimiento
                  from alma.tai_movimiento mov
                  inner join alma.tai_detalle_movimiento det on det.id_movimiento = mov.id_movimiento
                  where mov.id_movimiento=al_id_movimiento;
                  IF (g_cant_detalle_movimiento < 1)
                  THEN
                  	g_descripcion_log_error := 'El movimiento seleccionado (' || al_id_movimiento || ') no tiene ningun item asociado';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                  END IF;

            END IF;
                          
              --finaliza el movimiento
              UPDATE alma.tai_movimiento SET 
              estado = 'pendiente_aprobacion'
              WHERE alma.tai_movimiento.id_movimiento = al_id_movimiento;	
                          
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa del registro '||al_id_movimiento||' en alma.tai_movimiento';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
    --transpaso de items de un almacen origen a un almacen destino
     ELSIF pm_codigo_procedimiento = 'AL_TRANSMOVFIN_UPD'
        THEN
        BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(select 1 from alma.tai_movimiento where alma.tai_movimiento.id_movimiento=al_id_movimiento) 
            THEN       
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_movimiento || 'en la tabla alma.tai_movimiento';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            ELSE
                  --se verifica de que el movimiento finalizado tenga por lo menos un detalle  item asociado
                  select count(det.id_detalle_movimiento) into g_cant_detalle_movimiento
                  from alma.tai_movimiento mov
                  inner join alma.tai_detalle_movimiento det on det.id_movimiento = mov.id_movimiento
                  where mov.id_movimiento=al_id_movimiento;
                  IF (g_cant_detalle_movimiento < 1)
                  THEN
                  	g_descripcion_log_error := 'El movimiento seleccionado (' || al_id_movimiento || ') no tiene ningun item asociado';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                  END IF;

            END IF;
                          
            --llamada a la funcion que procesa un transpaso de items
            select alma.f_ai_procesar_transpaso(al_id_movimiento,pm_id_usuario,pm_ip_origen) into g_res;  
             
            if g_res != 't' then
            	raise exception 'Error al procesar la transferencia de materiales.';
            end if;
            
            
            --cambio de estado del movimiento
            UPDATE alma.tai_movimiento
            SET estado='finalizado'
            	,fecha_finalizacion = now()
            WHERE id_movimiento=al_id_movimiento;
            
                      
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa del registro '||al_id_movimiento||' en alma.tai_movimiento';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
    ELSIF pm_codigo_procedimiento = 'AL_FLUJO_MOVS' THEN
    BEGIN
    		SELECT alma.f_ai_flujo_movimientos(al_id_movimiento,'INICIAR') INTO g_res;
            
            if g_res = 'f' then
            		RAISE EXCEPTION '%','Error al procesar el movimiento de '||(select upper(b.tipo) from alma.tai_movimiento a 
                    																inner join alma.tai_tipo_movimiento b on a.id_tipo_movimiento=b.id_tipo_movimiento
                                                                                    where a.id_movimiento = al_id_movimiento);
            end if;
            
    		g_descripcion_log_error := 'Consulta ejecutada exitosamente del movimiento '||al_id_movimiento||' en alma.tai_movimiento';
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