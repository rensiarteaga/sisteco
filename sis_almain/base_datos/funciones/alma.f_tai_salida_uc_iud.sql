--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_tai_salida_uc_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_salida_uc integer,
  al_id_almacen integer,
  al_origen_salida varchar,
  al_id_contratista integer,
  al_id_proveedor integer,
  al_id_empleado integer,
  al_id_institucion integer,
  al_nro_contrato varchar,
  al_fecha_salida timestamp,
  al_concepto_salida varchar,
  al_observaciones varchar,
  al_id_fase integer,
  al_id_tramo integer,
  al_id_unidad_constructiva integer,
  al_supervisor varchar,
  al_ci_supervisor varchar,
  al_receptor varchar,
  al_ci_receptor varchar,
  al_solicitante varchar,
  al_ci_solicitante varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA Almacen ONLINE
***************************************************************************
 SCRIPT:          alma.f_tai_salida_uc_iud
 DESCRIPCIÃ??N:     Realiza modificaciones en la tabla alma.tai_fase
 AUTOR:           UNKNOWS
 FECHA:           27-08-2013 17:10:00
 COMENTARIOS:    
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCIÃ??N:  
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

-- PARÃ?ÂÃ?ÂMETROS VARIABLES
/*
cb_id_almacen_item
cb_id_sucursal
cb_id_usuario
cb_estado
*/

-- DECLARACIÃ??N DE VARIABLES PARTICULARES

--**** DECLARACION DE VARIABLES DE LA FUNCIÃ??N (LOCALES) ****---


DECLARE

    --PARÃ?ÂMETROS FIJOS

    g_id_subsistema               integer;     -- ID SUBSISTEMA
    g_id_lugar                    integer;     -- ID LUGAR
    g_numero_error                varchar;     -- ALMACENA EL NÃ??MERO DE ERROR
    g_mensaje_error               varchar;     -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento    boolean;     -- BANDERA PARA VERIFICAR LLAMADA DE LA FUNCIÃ??N
    g_descripcion_log_error       text;        -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento                  varchar; 
    g_reg_error                	  varchar; 
    g_respuesta                   varchar;     -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCIÃ??N
    g_nivel_error                 varchar;     -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                               --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                               --      ERROR LÃ??GICO (CRÃ?ÂTICO) = 2
                                               --      ERROR LÃ??GICO (INTERMEDIO) = 3
                                               --      ERROR LÃ??GICO (ADVERTENCIA) = 4
    
    g_nombre_funcion              varchar;     -- NOMBRE FÃ?ÂSICO DE LA FUNCIÃ??N
    g_separador                   varchar(10); -- SEPARADOR DE CADENAS
    
    g_code						  varchar;
   
BEGIN
---*** INICIACIÃ??N DE VARIABLES 
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funciÃ?Â³n	
    g_nombre_funcion :='f_tai_salida_uc_iud';
    g_privilegio_procedimiento := FALSE;
    g_respuesta := FALSE;
   
    ---*** OBTENCIÃ??N DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENCIÃ??N DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT tsg_usuario_lugar.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar
    WHERE  tsg_usuario_lugar.id_usuario = pm_id_usuario;
    
    
     ---*** VALIDACIÃ??N DE LLAMADA POR USUARIO O FUNCIO?N
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


    ---*** VERIFICACIÃ??N DE PERMISOS DEL USUARIO
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
    
    
      --*** EJECUCIÃ??N DEL PROCEDIMIENTO ESPECIÂFICO
    IF pm_codigo_procedimiento = 'AL_SALUC_INS' THEN
    BEGIN    	
    
		INSERT INTO alma.tai_salida_uc (
            id_almacen,
            origen_salida, 
            id_contratista,
        	id_proveedor,
            id_empleado,
            id_institucion,
            nro_contrato,
            fecha_salida,
            concepto_salida,
            observaciones,
            id_fase,
            id_tramo,
            id_unidad_constructiva,
            supervisor,
            ci_supervisor,
            receptor,
            ci_receptor,
            solicitante,
            ci_solicitante,
            estado	
        ) VALUES (
            al_id_almacen,
            al_origen_salida,
           	al_id_contratista,
			al_id_proveedor,
			al_id_empleado,
			al_id_institucion,
            al_nro_contrato,
            al_fecha_salida,
            al_concepto_salida,
            al_observaciones,
            al_id_fase,
            al_id_tramo,
            al_id_unidad_constructiva,
            al_supervisor,
            al_ci_supervisor,
            al_receptor,
            al_ci_receptor,
            al_solicitante,
            al_ci_solicitante,
            'borrador'
        );
            
            -- DESCRIPCIÃ??N DE Ã??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tai_salida_uc';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;   
        END;
        
  --procedimiento de modificacion      
	ELSIF pm_codigo_procedimiento = 'AL_SALUC_UPD' THEN
	BEGIN
            IF NOT EXISTS (SELECT 1 FROM alma.tai_salida_uc f WHERE f.id_salida_uc=al_id_salida_uc) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_salida_uc || 'en la tabla alma.tai_salida_uc';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;      
            END IF;

                UPDATE alma.tai_salida_uc SET 
                	id_almacen = al_id_almacen							,	origen_salida = al_origen_salida	,	id_contratista=al_id_contratista	,	id_proveedor=al_id_proveedor
                   ,id_empleado = al_id_empleado						,	id_institucion = al_id_institucion	,	nro_contrato = al_nro_contrato		,	fecha_salida = al_fecha_salida
                   ,concepto_salida = al_concepto_salida				,	observaciones = al_observaciones	,	id_fase = al_id_fase				,	id_tramo = al_id_tramo
                   ,id_unidad_constructiva = al_id_unidad_constructiva	,	supervisor = al_supervisor 			,	ci_supervisor = al_ci_supervisor 	,	receptor = al_receptor
                   ,ci_receptor = al_ci_receptor						,	solicitante =al_solicitante 		,	ci_solicitante = al_ci_solicitante	,	
                    usuario_reg = "current_user"()						,	fecha_reg = now()
                    
				WHERE alma.tai_salida_uc.id_salida_uc = al_id_salida_uc;
			
		-- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa en alma.tai_salida_uc del registro '||  al_id_salida_uc;
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
        ELSIF pm_codigo_procedimiento = 'AL_SALUC_DEL' THEN
        
    	BEGIN
        
            IF NOT EXISTS(SELECT 1 FROM  alma.tai_salida_uc f WHERE f.id_salida_uc=al_id_salida_uc) THEN
                              
                g_descripcion_log_error := 'Eliminacion no realizada: no existe el registro ' || al_id_salida_uc || ' en la tabla alma.tai_salida_uc';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;
            
 
        	IF EXISTS(SELECT 1 FROM alma.tai_salida_uc_detalle s WHERE s.id_salida_uc = al_id_salida_uc)
            THEN
            	g_descripcion_log_error := 'Eliminacion no realizada, el elmento seleccionado ' || al_id_salida_uc || ' tiene dependientes en el detalle';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;
              
            DELETE FROM alma.tai_salida_uc 
			WHERE alma.tai_salida_uc.id_salida_uc = al_id_salida_uc;
                
 			
            -- DESCRIPCIÃ??N DE Ã??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_salida_uc||' en alma.tai_salida_uc';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
        ELSIF pm_codigo_procedimiento = 'AL_FIN_SALUC' THEN
        BEGIN
        		if not EXISTS(select 1 from alma.tai_salida_uc s where s.id_salida_uc=al_id_salida_uc)
                then
                	g_descripcion_log_error := 'Finalizacion errónea, el elemento seleccionado ' || al_id_salida_uc || ' no existe';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                end if;
                
                if not EXISTS(	select 1 from alma.tai_salida_uc a 
                				inner join alma.tai_salida_uc_detalle b  on b.id_salida_uc=a.id_salida_uc
                                inner join alma.tai_salida_uc_detalle_item c on c.id_salida_uc_detalle=b.id_salida_uc_detalle
                                where a.id_salida_uc = al_id_salida_uc
                                )
                then
                	g_descripcion_log_error := 'Finalizacion errónea, el elemento seleccionado ' || al_id_salida_uc || ' no tiene items asociados';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                end if;
                
                --verificacion de existencia de los items SOLICITADOS EN ALMACEN para la unidad constructiva
                
                
                
                --verificacion de existencia de codigo para el movimiento proyecto 
                
                select s.estado into g_code from alma.tai_salida_uc s where s.id_salida_uc=al_id_salida_uc;
                
                IF g_code IS NULL
                THEN
                		 --generacion del codigo de salida del movimiento
                                
                        /* update alma.tai_salida_uc
                        set codigo = 
                        where alma.tai_salida_uc.id_salida_uc=al_id_salida_uc;*/
                END IF;
                
                --actualizacion del estado del movimiento borrador->finalizado
               /* update alma.tai_salida_uc
                set estado = 'finalizado'
                where alma.tai_salida_uc.id_salida_uc=al_id_salida_uc;*/
                
                -- DESCRIPCIÃ??N DE Ã??XITO PARA GUARDAR EN EL LOG
            	g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_salida_uc||' en alma.tai_salida_uc';
            	g_respuesta := 't'||g_separador||g_descripcion_log_error;
                
        END;
        
        ELSIF pm_codigo_procedimiento = 'AL_CORREG_SALUC' THEN
        BEGIN
        		if not EXISTS(select 1 from alma.tai_salida_uc s where s.id_salida_uc=al_id_salida_uc)
                then
                	g_descripcion_log_error := 'correccion fallida, el elementos seleccionado ' || al_id_salida_uc || ' no existe';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                end if;
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

    ---*** REGISTRO EN EL LOG EL Ã??XITO DE LA EJECUIÃ??N DEL PROCEDIMIENTO
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);

    ---*** SE DEVUELVE LA RESPUESTA
    RETURN g_respuesta||g_separador||g_reg_evento;


EXCEPTION

    WHEN others THEN BEGIN

        --SE OBTIENE EL MENSAJE Y EL NÃ??MERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
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