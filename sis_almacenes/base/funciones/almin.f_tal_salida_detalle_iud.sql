--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_tal_salida_detalle_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_salida_detalle integer,
  al_costo numeric,
  al_costo_unitario numeric,
  al_precio_unitario numeric,
  al_cant_solicitada numeric,
  al_cant_entregada numeric,
  al_cant_consolidada numeric,
  al_fecha_solicitada date,
  al_fecha_entregada date,
  al_fecha_consolidada date,
  al_fecha_reg date,
  al_id_item integer,
  al_id_salida integer,
  al_id_unidad_constructiva integer,
  al_estado_item varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ALMACENES (ALMIN)
***************************************************************************
 SCRIPT: 		almin.f_tal_salida_detalle_iud
 DESCRIPCIÓN: 	Permite registrar en la tabla almin.tal_salida_detalle
 AUTOR: 		(generado automaticamente)
 FECHA:			2007-10-25 09:38:06
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

    g_nombre_funcion              varchar;     -- NOMBRE FÍSICO DE LA FUNCIÓN
    g_separador                   varchar(10); -- SEPARADOR DE CADENAS
    g_id_fina_regi_prog_proy_acti integer;     -- VARIABLE DE LA ESTRUCTURA PROGRAMÁTICA
    g_costo_unitario              numeric;
    g_emergencia                  varchar;
    g_cant_consolidada            numeric;
    g_id_almacen_logico           integer;
    g_cant                        numeric;
    g_id_kardex_logico            integer;
    g_cant_tot                    numeric;
    g_costo_unit                  numeric;
    g_estado_item                 varchar;

BEGIN


---*** INICIACIÓN DE VARIABLES
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion := 'almin.f_tal_salida_detalle_iud';
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

   SELECT emergencia INTO g_emergencia FROM almin.tal_salida where id_salida=al_id_salida;
            IF(g_emergencia='Si') THEN
               g_cant_consolidada= al_cant_solicitada;
               ELSE
               g_cant_consolidada=0;
            END IF;
      --*** EJECUCIÓN DEL PROCEDIMIENTO ESPECÍFICO
    IF pm_codigo_procedimiento = 'AL_SALDET_INS' THEN

        BEGIN
           --TODO RAC --estos costos me aprce ue estan mal hechos  26/11/2016 lo voy a ignorar el costo de salida se calculara al finalizar la misma
            --VERIFICA SI EL MATERIAL ESTÁ REGISTRADO EN KARDEX
            IF NOT EXISTS(SELECT 1 FROM almin.tal_kardex_logico KARLOG
                          INNER JOIN almin.tal_parametro_almacen PARALM
                          ON PARALM.id_parametro_almacen=KARLOG.id_parametro_almacen AND PARALM.cierre='no'
                          WHERE KARLOG.id_item = al_id_item
                          AND KARLOG.estado_item = al_estado_item) THEN
                          
                g_descripcion_log_error := 'Inserción no realizada: El material no está registrado en el Kardex';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                          
            ELSE
                --SE OBTIENE EL PRECIO Y EL COSTO UNITARIO DEL ITEM
                SELECT
                KARLOG.costo_unitario
                INTO g_costo_unitario
                FROM almin.tal_kardex_logico KARLOG
                INNER JOIN almin.tal_parametro_almacen PARALM ON PARALM.id_parametro_almacen=KARLOG.id_parametro_almacen AND PARALM.cierre='no'
                WHERE KARLOG.id_item = al_id_item
                AND KARLOG.estado_item = al_estado_item;
                
            END IF;
            
            --VERIFICA SI EL MATERIAL NO FUE SOLICITADO YA EN EL PEDIDO
            IF EXISTS(SELECT 1 FROM almin.tal_salida_detalle
                      WHERE id_salida = al_id_salida
                      AND id_item = al_id_item
                      AND estado_item = al_estado_item) THEN
                      
                g_descripcion_log_error := 'Inserción no realizada: El material ya fue solicitado en el Pedido.';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                      
            END IF;

         
        	
            INSERT INTO almin.tal_salida_detalle(
		    costo_unitario       ,precio_unitario           ,cant_solicitada     ,cant_entregada,
		    cant_consolidada     ,fecha_solicitada,
		    fecha_entregada      ,fecha_consolidada         ,fecha_reg           ,id_item,
		    id_salida            ,id_unidad_constructiva    ,estado_item
		    ) VALUES (
		    g_costo_unitario     ,0                         ,al_cant_solicitada  ,al_cant_solicitada,
		    g_cant_consolidada   ,now(),
		    NULL                 ,NULL                      ,now()               ,al_id_item,
		    al_id_salida         ,al_id_unidad_constructiva ,al_estado_item
            );
            
            
            
            
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso del Pedido de Material';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
    ELSIF pm_codigo_procedimiento = 'AL_PEDDET_UPD' THEN

        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida_detalle
                          WHERE almin.tal_salida_detalle.id_salida_detalle=al_id_salida_detalle) THEN

                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de mateiral solicitado';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;
            
            --VERIFICA SI EL MATERIAL ESTÁ REGISTRADO EN KARDEX
            IF NOT EXISTS(SELECT 1 FROM almin.tal_kardex_logico KARLOG
                          INNER JOIN almin.tal_parametro_almacen PARALM
                          ON PARALM.id_parametro_almacen= KARLOG.id_parametro_almacen AND PARALM.cierre='no'
                          WHERE KARLOG.id_item = al_id_item
                          AND KARLOG.estado_item = al_estado_item) THEN

                g_descripcion_log_error := 'Inserción no realizada: El material no está registrado en el Kardex';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            ELSE
                --SE OBTIENE EL PRECIO Y EL COSTO UNITARIO DEL ITEM
                SELECT
                KARLOG.costo_unitario
                INTO g_costo_unitario
                FROM almin.tal_kardex_logico KARLOG
                INNER JOIN almin.tal_parametro_almacen PARALM ON PARALM.id_parametro_almacen= KARLOG.id_parametro_almacen AND PARALM.cierre='no'
                WHERE KARLOG.id_item = al_id_item
                AND KARLOG.estado_item = al_estado_item;

            END IF;

            UPDATE almin.tal_salida_detalle SET
		    costo_unitario         = g_costo_unitario,
		    precio_unitario        = 0,
		    cant_solicitada        = al_cant_solicitada,
		    cant_entregada         = al_cant_solicitada,
		    id_item                = al_id_item,
		    id_unidad_constructiva = al_id_unidad_constructiva,
            estado_item            = al_estado_item
			WHERE almin.tal_salida_detalle.id_salida_detalle= al_id_salida_detalle;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificación exitosa en almin.tal_salida_detalle';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

  --procedimiento de modificacion

   ELSIF pm_codigo_procedimiento = 'AL_SALDET_UPD' THEN

        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida_detalle
                          WHERE almin.tal_salida_detalle.id_salida_detalle=al_id_salida_detalle) THEN

                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de almin.tal_salida_detalle no existente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            UPDATE almin.tal_salida_detalle SET
		    costo                  = al_costo,
		    costo_unitario         = al_costo_unitario,
		    precio_unitario        = al_precio_unitario,
		    cant_solicitada        = al_cant_solicitada,
		    cant_entregada         = al_cant_entregada,
		    cant_consolidada       = al_cant_consolidada,
		    fecha_solicitada       = al_fecha_solicitada,
		    fecha_entregada        = al_fecha_entregada,
		    fecha_consolidada      = al_fecha_consolidada,
		    fecha_reg              = al_fecha_reg,
		    id_item                = al_id_item,
		    id_salida              = al_id_salida,
		    id_unidad_constructiva = al_id_unidad_constructiva,
            estado_item            = al_estado_item
			WHERE almin.tal_salida_detalle.id_salida_detalle= al_id_salida_detalle;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificación exitosa en almin.tal_salida_detalle';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
    ELSIF pm_codigo_procedimiento = 'AL_SDEPEN_UPD' THEN

        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida_detalle
                          WHERE almin.tal_salida_detalle.id_salida_detalle=al_id_salida_detalle) THEN

                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de almin.tal_salida_detalle no existente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            UPDATE almin.tal_salida_detalle SET
  		      cant_solicitada=al_cant_solicitada,
		      cant_entregada=al_cant_entregada,
		      cant_consolidada=al_cant_entregada,
		      fecha_entregada=now(),
		      fecha_consolidada = now()
		    WHERE almin.tal_salida_detalle.id_salida_detalle= al_id_salida_detalle;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificación exitosa en almin.tal_salida_detalle';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
         ELSIF pm_codigo_procedimiento = 'AL_SDECON_UPD' THEN

        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida_detalle
                          WHERE almin.tal_salida_detalle.id_salida_detalle=al_id_salida_detalle) THEN

                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de almin.tal_salida_detalle no existente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;


            UPDATE almin.tal_salida_detalle SET
  		      cant_solicitada=al_cant_solicitada,
		      cant_entregada=al_cant_entregada,
		      cant_consolidada=al_cant_consolidada,
		      fecha_consolidada=now()
		    WHERE almin.tal_salida_detalle.id_salida_detalle= al_id_salida_detalle;



	        SELECT id_almacen_logico
			INTO g_id_almacen_logico
			FROM almin.tal_salida
			WHERE id_salida = al_id_salida;
			
		           IF EXISTS(SELECT 1
                          FROM almin.tal_kardex_logico KARLOG
                          INNER JOIN almin.tal_parametro_almacen PARALM ON PARALM.id_parametro_almacen=KARLOG.id_parametro_almacen AND PARALM.cierre='no'
                          WHERE id_item = al_id_item
                          AND id_almacen_logico = g_id_almacen_logico) THEN
			
                    -- Se actualiza las cantidades
                    
                    SELECT estado_item into g_estado_item
                    from almin.tal_salida_detalle
                    where id_salida_detalle=al_id_salida_detalle AND id_salida= al_id_salida;

                    SELECT cantidad, id_kardex_logico, costo_unitario
                    INTO g_cant, g_id_kardex_logico, g_costo_unit
                    FROM almin.tal_kardex_logico KARLOG
                    INNER JOIN almin.tal_parametro_almacen PARALM ON PARALM.id_parametro_almacen = KARLOG.id_parametro_almacen AND PARALM.cierre='no'
                    WHERE KARLOG.id_item = al_id_item
                    AND KARLOG.id_almacen_logico = g_id_almacen_logico
                    AND KARLOG.estado_item=g_estado_item;
                    
                    g_cant_tot := g_cant + (al_cant_entregada-al_cant_consolidada);

			        UPDATE almin.tal_kardex_logico SET
			        cantidad = g_cant_tot,
			        costo_total= g_costo_unit * g_cant_tot
			       WHERE id_kardex_logico = g_id_kardex_logico
                   AND id_item=al_id_item
                   AND estado_item=g_estado_item;
			
                ELSE --se hace un insert
			
                g_nivel_error := '4';
                g_descripcion_log_error := 'Solicitud de Devolución no realizada: registro en almin.tal_salida_detalel inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
			
			    END IF;


            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificación exitosa en almin.tal_salida_detalle';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
  ELSIF pm_codigo_procedimiento = 'AL_SALDET_DEL' THEN

    BEGIN
            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida_detalle
                          WHERE almin.tal_salida_detalle.id_salida_detalle=al_id_salida_detalle) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: registro en almin.tal_salida_detalle inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

         -- BORRADO DE DATO
            DELETE FROM almin.tal_salida_detalle WHERE almin.tal_salida_detalle.id_salida_detalle = al_id_salida_detalle;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminación exitosa del registro en almin.tal_salida_detalle';
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