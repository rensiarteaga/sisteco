--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_tal_pedido_tuc_int_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_pedido_tuc_int integer,
  al_id_salida integer
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ALMACENES (ALMIN)
***************************************************************************
 SCRIPT: 		almin.f_tal_pedido_tuc_int_iud
 DESCRIPCIÓN:   Diversasoperacion en parametro almacen logico 
 AUTOR: 		RAC
 FECHA:			06/12/2016
 COMENTARIOS:	
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:			

***************************************************************************/
--------------------------
-- CUERPO DE LA FUNCIÓN --
--------------------------

-- PARÁMETROS FIJOS
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

-- DECLARACIÓN DE VARIABLES PARTICULARES

--**** DECLARACION DE VARIABLES DE LA FUNCIÓN (LOCALES) ****---


DECLARE

    --PARÁMETROS FIJOS

    g_id_subsistema               integer;     -- ID SUBSISTEMA
    g_id_lugar                    integer;     -- ID LUGAR
    g_numero_error                varchar;     -- ALMACENA EL NÚMERO DE ERROR
    g_mensaje_error               varchar;     -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento    boolean;     -- BANDERA PARA VERIFICAR LLAMADA DE LA FUNCIÓN
    g_descripcion_log_error       text;        -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento                  varchar;
    g_reg_error                	  varchar;
    g_respuesta                   varchar;     -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCIÓN
    g_nivel_error                 varchar;     -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                               --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                               --      ERROR LÓGICO (CRÍTICO) = 2
                                               --      ERROR LÓGICO (INTERMEDIO) = 3
                                               --      ERROR LÓGICO (ADVERTENCIA) = 4

    g_nombre_funcion              	varchar;     -- NOMBRE FÍSICO DE LA FUNCIÓN
    g_separador                   	varchar(10); -- SEPARADOR DE CADENAS
    g_id_fina_regi_prog_proy_acti 	integer;     -- VARIABLE DE LA ESTRUCTURA PROGRAMÁTICA
    g_id_max_parametro         		integer; --id maximo de la tabla parametro almacen
    g_id_parametro_anterior    		integer;--id de la ultima gestion que cerro
    v_id_almacen_logico				integer;
    v_respuesta						varchar;
    v_estado						varchar;
    va_respuesta					varchar[];
    v_registros						record;
    v_sw 							varchar;
    
    v_id_parametro_almacen       				integer;
    v_id_parametro_almacen_logico       		integer;
    v_id_salida									integer;
    v_registros_det								record;
   
 
BEGIN  


---*** INICIACIÓN DE VARIABLES
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion := 'almin.f_tal_pedido_tuc_int_iud';
    g_privilegio_procedimiento := FALSE;
    g_respuesta := FALSE;

    ---*** OBTENCIÓN DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENCIÓN DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT sss.tsg_usuario_lugar.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar
    WHERE  sss.tsg_usuario_lugar.id_usuario = pm_id_usuario;


     ---*** VALIDACIÓN DE LLAMADA POR USUARIO O FUNCIÓN
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


    ---*** VERIFICACIÓN DE PERMISOS DEL USUARIO
    IF NOT g_privilegio_procedimiento THEN
       g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;

---*** SI NO SE TIENE PERMISOS DE EJECUCIÓN SE RETORNA EL MENSAJE DE ERROR
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


      --*** EJECUCIÓN DEL PROCEDIMIENTO ESPECÍFICO
    IF pm_codigo_procedimiento = 'AL_AUTPEDITUC_IUD' THEN

    BEGIN
            
            select 
               pti.sw_entregado,
               pti.sw_autorizado,
               sal.estado_salida,
               pti.cantidad_solicitada,
               pti.nuevo,
               pti.usado,
               pti.demasia 
             into  
               v_registros
            from almin.tal_pedido_tuc_int pti
            inner join almin.tal_salida sal on sal.id_salida = pti.id_salida
            where pti.id_pedido_tuc_int = al_id_pedido_tuc_int;  
            
            
            IF v_registros.estado_salida != 'Borrador' THEN
              raise exception 'solo puede cambiar la autorizacion en salida en borrador';            
            END IF;
            
            IF  v_registros.usado +  v_registros.nuevo >= v_registros.cantidad_solicitada + v_registros.demasia   THEN
                 raise exception 'Tiene la cantidad de item suficientes para realizar la entrega';
            END IF;
            
            IF v_registros.sw_autorizado = 'no'  THEN
               v_sw  = 'si';  
            ELSE
               v_sw  = 'no';            
            END IF;
            
            update almin.tal_pedido_tuc_int set
              sw_autorizado = v_sw
             where id_pedido_tuc_int = al_id_pedido_tuc_int;  
             
            -- raise exception 'falla % --  % 000000000000000', v_sw, al_id_pedido_tuc_int;
    
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Autorizacion exitosa';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
    ELSEIF pm_codigo_procedimiento = 'AL_REVLOG_IUD' THEN

    BEGIN
            
             select 
             		al.id_almacen_logico,
                    al.estado
               into
                    v_id_almacen_logico,
                    v_estado
             from almin.tal_parametro_almacen_logico al
             where al.id_parametro_almacen_logico = al_id_parametro_almacen_logico;
             
            IF  v_estado = 'cerrado'  THEN
              raise exception 'la gestion seleccionada se encuentra cerrada';             
            END IF; 
             
            IF  v_id_almacen_logico is null THEN
               raise exception 'Error, no se encontro el almacen logico';
            END IF;
         
            -- cerrar la gestion delalmacen logico  va_respuesta
            va_respuesta = almin.f_adm_al_valoracion_gestion(al_id_parametro_almacen_logico);
            
             ---*** VALIDACIÓN DE LLAMADA POR USUARIO O FUNCIÓN
            IF va_respuesta[1] = 'fallo' THEN
              
                    g_descripcion_log_error := va_respuesta[2];
                    g_nivel_error := '2';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                    --REGISTRA EL LOG
                    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                         pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                         pm_codigo_procedimiento   ,pm_proc_almacenado);
                    --DEVUELVE MENSAJE DE ERROR
                    RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
               
            END IF;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'valoracion de gestion';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
   /*
   Autor:	 Rensi Arteaga Copari
   Desc:	 permite eliminar piezas que no se entregaran en ningun momento
   Fecha:	 24/01/2017
   */    
        
    ELSEIF pm_codigo_procedimiento = 'AL_PEDTUCINT_DEL' THEN

    BEGIN  
    
       --validar que la salida este en borrador
       
       select
          sal.id_salida,
          sal.estado_salida,
          pti.id_item
        into
          v_registros
       from almin.tal_pedido_tuc_int pti
       inner join almin.tal_salida sal on sal.id_salida = pti.id_salida
       where pti.id_pedido_tuc_int = al_id_pedido_tuc_int;
       
       IF v_registros.estado_salida != 'Borrador' THEN
          raise exception 'Solo puede eliminar piezas en epdidos en borrador';
       END IF;
       
       delete from  almin.tal_pedido_tuc_int 
       where id_pedido_tuc_int = al_id_pedido_tuc_int;
       
       -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
      g_descripcion_log_error := 'Eliminación exitosa del registro';
      g_respuesta := 't'||g_separador||g_descripcion_log_error;
     
    
    END;    

     
        
   /*
   Autor:	 Rensi Arteaga Copari
   Desc:	 genera una salida con todos los materiales pendientes que no se pudieron entregar
   Fecha:	 30/12/2016
   */    
        
    ELSEIF pm_codigo_procedimiento = 'AL_GENSALIPEN_IUD' THEN

    BEGIN
          
           
           --obtenmos los datos de la salida
           select
                *
             into
                v_registros
           from almin.tal_salida s
           where s.id_salida = al_id_salida;
           

           -- si la salida no tiene pendiente lanzamos un error
           IF v_registros.sw_faltante_tuc in ('no','entre') THEN
              raise exception 'Esta salida  no tiene pendientes';
           END IF;

           ----------------------------------------------------------------------
           --generamos la nueva salida con los mismo datos en estado borrador
           ----------------------------------------------------------------------
           
           -- OBTIENE LA GESTIÓN VIGENTE
            SELECT 
                pl.id_parametro_almacen,
                pl.id_parametro_almacen_logico
            INTO 
                v_id_parametro_almacen,
                v_id_parametro_almacen_logico
            FROM almin.tal_parametro_almacen_logico pl
            WHERE      pl.estado = 'abierto'
                  and pl.id_almacen_logico = v_registros.id_almacen_logico;
                  
                  
           IF v_id_parametro_almacen IS NULL THEN
                g_nivel_error := '3';
                g_descripcion_log_error := 'Orden de ingreso no almacenada: No existe una Gestión vigente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
            END IF;
            
            
            --OBTIENE EL ÚLTIMO VALOR DE LA SECUENCIA PARA INSERTAR LA SALIDA
			 SELECT NEXTVAL('almin.tal_salida_id_salida_seq') INTO v_id_salida;
             
           
		
            --CREACIÓN DE LA SALIDA
            INSERT INTO almin.tal_salida(
                   id_salida                      ,descripcion                ,contabilizar,
                   estado_salida                  ,estado_registro            ,motivo_cancelacion      ,id_responsable_almacen,
                   id_almacen_logico              ,id_empleado                ,id_firma_autorizada     ,id_contratista,
                   id_tipo_material               ,id_institucion             ,id_subactividad         ,fecha_borrador,
                   fecha_pendiente                ,fecha_aprobado_rechazado   ,fecha_entregado         ,fecha_provisional,
                   fecha_consolidado              ,fecha_finalizado_cancelado ,correlativo_sal         ,id_motivo_salida_cuenta,
                   id_usuario                     ,emergencia                 ,correlativo_vale        ,id_parametro_almacen,
                   id_parametro_almacen_logico
            ) VALUES (
                   v_id_salida                    ,v_registros.descripcion          ,v_registros.contabilizar,
                   'Borrador'                     ,'activo'                   ,NULL                    				,v_registros.id_responsable_almacen,
                   v_registros.id_almacen_logico   ,v_registros.id_empleado     ,v_registros.id_firma_autorizada    ,v_registros.id_contratista,
                   v_registros.id_tipo_material    ,NULL                       ,NULL                    			,now(),
                   now()                          ,now()                      ,NULL                   				,NULL,
                   NULL                           ,NULL                       ,0                       				,v_registros.id_motivo_salida_cuenta,
                   pm_id_usuario                  ,'No'                       ,0                       				,v_id_parametro_almacen,
                   v_id_parametro_almacen_logico
            );       
           
           
           -------------------------------------------------------------------------------------------         
           --listamos todas lo item con autorizaciones no entregadas  para la salida selecionada
           ---------------------------------------------------------------------------------------------
           FOR v_registros_det in (
           								select
                                            pti.id_item,
                                            pti.cantidad_solicitada,
                                            pti.demasia,
                                            pti.id_salida,
                                            pti.id_pedido_tuc_int,
                                            pti.nuevo,
                                            pti.sw_autorizado
                                        from almin.tal_pedido_tuc_int pti
                                        where      pti.id_salida = al_id_salida
                                              and  pti.sw_autorizado = 'si'
                                              and  pti.sw_entregado = 'no'
           								)LOOP
           							
                                    -- insertamos los detalle faltante a la nueva salida
                                    INSERT INTO  almin.tal_salida_detalle
                                                  ( costo,
                                                    costo_unitario,
                                                    precio_unitario,
                                                    cant_solicitada,
                                                    fecha_solicitada,
                                                    fecha_reg,
                                                    id_item,
                                                    id_salida,                                                   
                                                    cant_demasia,
                                                    cant_entregada,
                                                    estado_item,
                                                    cant_consolidada
                                                  )
                                                  VALUES (
                                                    0,
                                                    0,
                                                    0,
                                                    v_registros_det.cantidad_solicitada,
                                                    now(),
                                                    now(),
                                                    v_registros_det.id_item,
                                                    v_id_salida,
                                                    v_registros_det.demasia,
                                                    COALESCE(v_registros_det.cantidad_solicitada,0) + COALESCE(v_registros_det.demasia,0),
                                                    'Nuevo',
                                                    0
                                                  );
                                                  
                --actulizamos el pedido tuc int, haciendo referencia a la nueva salida complementaria
                 update almin.tal_pedido_tuc_int set
                   id_salida_complementaria = v_id_salida
                 where id_pedido_tuc_int = v_registros_det.id_pedido_tuc_int;
           
           END LOOP;
           
           --actulizamos la salida origina para que quede sin pendientes
             update almin.tal_salida set
                sw_faltante_tuc = 'entre'
             where id_salida = al_id_salida;
             

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'SE creo la salida satisfactoriamente';
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

    ---*** REGISTRO EN EL LOG EL ÉXITO DE LA EJECUIÓN DEL PROCEDIMIENTO
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);

    ---*** SE DEVUELVE LA RESPUESTA
    RETURN g_respuesta||g_separador||g_reg_evento;


EXCEPTION

    WHEN others THEN BEGIN

        --SE OBTIENE EL MENSAJE Y EL NÚMERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
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