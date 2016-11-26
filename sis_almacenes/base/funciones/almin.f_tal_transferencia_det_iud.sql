--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_tal_transferencia_det_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_transferencia_det integer,
  al_cantidad numeric,
  al_estado_item varchar,
  al_costo numeric,
  al_costo_unitario numeric,
  al_precio_unitario numeric,
  al_fecha_reg date,
  al_id_item integer,
  al_id_transferencia integer,
  al_id_unidad_constructiva integer
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ALMACENES (ALMIN)
***************************************************************************
 SCRIPT: 		almin.f_tal_transferencia_det_iud
 DESCRIPCIÓN: 	Permite registrar en la tabla almin.tal_transferencia_det
 AUTOR: 		(generado automaticamente)
 FECHA:			2007-11-21 08:51:17
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
    g_costo_total                 numeric;
    g_costo_unitario              numeric;
    g_precio_unitario             numeric;
    g_id_almacen_logico           integer;
    v_tipo_transferencia		  varchar;	
    v_estado_transferencia		  varchar;
    

BEGIN


---*** INICIACIÓN DE VARIABLES
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion := 'almin.f_tal_transferencia_det_iud';
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
   /*
   Autor:		RAC
   Fecha:		10/01/2017
   Desc			-  validar que no pueda instar siel estado no es borrador
   				-	si es una devolucoin no puede agregar item
   
   */

      --*** EJECUCIÓN DEL PROCEDIMIENTO ESPECÍFICO
    IF pm_codigo_procedimiento = 'AL_TLODET_INS' THEN

        BEGIN
        
            -- SE OBTIENE EL ID DE ALMACÉN LÓGICO DE LA CABECERA
            SELECT
               t.id_almacen_logico,
               t.tipo_transferencia,
               t.estado_transferencia
               
            INTO 
                g_id_almacen_logico,
                v_tipo_transferencia,
                v_estado_transferencia
            FROM almin.tal_transferencia t 
            WHERE id_transferencia = al_id_transferencia;
            
            IF v_estado_transferencia != 'Borrador' THEN
               raise exception 'Solo puede insertar en estado borrador';
            END IF;
            
            IF v_tipo_transferencia = 'devolucion' THEN
               raise exception 'no puede editar devoluciones';
            END IF;
            
        
            -- SE OBTIENE EL COSTO UNITARIO
            SELECT
            costo_unitario
            INTO
            g_costo_unitario
            FROM almin.tal_kardex_logico
            WHERE id_almacen_logico = g_id_almacen_logico
            AND id_item = al_id_item
            AND estado_item = al_estado_item;
            
            -- SE CALCULA EL COSTO TOTAL
            g_costo_total = al_cantidad * g_costo_unitario;
            
            -- SE OBTIENE EL PRECIO UNITARIO
            SELECT
            COALESCE(precio_venta_almacen,0)
            INTO
            g_precio_unitario
            FROM almin.tal_item
            WHERE id_item = al_id_item;
        	
        	IF EXISTS(SELECT 1 FROM almin.tal_transferencia_det WHERE id_transferencia=al_id_transferencia AND id_item=al_id_item AND estado_item=al_estado_item)
        	   THEN
                g_descripcion_log_error := 'Inserción no realizada: Ese item ya fue registrado para transferencia';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;
        	
        	
            INSERT INTO almin.tal_transferencia_det(
		    cantidad                   ,estado_item      ,costo            ,costo_unitario,
		    precio_unitario            ,fecha_reg        ,id_item          ,id_transferencia,
		    id_unidad_constructiva
		    ) VALUES (
		    al_cantidad                ,al_estado_item   ,g_costo_total    ,g_costo_unitario,
		    g_precio_unitario          ,now()            ,al_id_item       ,al_id_transferencia,
		    al_id_unidad_constructiva
            );
            
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso en almin.tal_transferencia_det';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

  --procedimiento de modificacion

   ELSIF pm_codigo_procedimiento = 'AL_TLODET_UPD' THEN

        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia_det
                          WHERE almin.tal_transferencia_det.id_transferencia_det=al_id_transferencia_det) THEN

                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de almin.tal_transferencia_det no existente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;
            
            -- SE OBTIENE EL ID DE ALMACÉN LÓGICO DE LA CABECERA
           
            SELECT
               t.id_almacen_logico,
               t.tipo_transferencia,
               t.estado_transferencia
               
            INTO 
                g_id_almacen_logico,
                v_tipo_transferencia,
                v_estado_transferencia
            FROM almin.tal_transferencia t 
            WHERE id_transferencia = al_id_transferencia;
            
            IF v_estado_transferencia != 'Borrador' THEN
               raise exception 'Solo puede editar  en estado borrador';
            END IF;
            
            IF v_tipo_transferencia = 'devolucion' THEN
               raise exception 'no puede editar devoluciones';
            END IF;
            
            -- SE OBTIENE EL ID DE ALMACÉN LÓGICO DE LA CABECERA
            SELECT
            id_almacen_logico
            INTO g_id_almacen_logico
            FROM almin.tal_transferencia
            WHERE id_transferencia = al_id_transferencia;
            
            -- SE OBTIENE EL COSTO TOTAL Y EL UNITARIO
            SELECT
            costo_unitario
            INTO
            g_costo_unitario
            FROM almin.tal_kardex_logico
            WHERE id_almacen_logico = g_id_almacen_logico
            AND id_item = al_id_item
            AND estado_item = al_estado_item;
            
            -- SE CALCULA EL COSTO TOTAL
            g_costo_total = al_cantidad * g_costo_unitario;

            -- SE OBTIENE EL PRECIO UNITARIO
            SELECT
            precio_venta_almacen
            INTO
            g_precio_unitario
            FROM almin.tal_item
            WHERE id_item = al_id_item;

            UPDATE almin.tal_transferencia_det SET
		    cantidad               = al_cantidad,
		    estado_item            = al_estado_item,
		    costo                  = g_costo_total,
		    costo_unitario         = g_costo_unitario,
		    precio_unitario        = g_precio_unitario,
		    id_item                = al_id_item,
		    id_transferencia       = al_id_transferencia,
		    id_unidad_constructiva = al_id_unidad_constructiva
      		WHERE id_transferencia_det = al_id_transferencia_det;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificación exitosa en almin.tal_transferencia_det';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

        ELSIF pm_codigo_procedimiento = 'AL_TLODET_DEL' THEN

    BEGIN
            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia_det
                          WHERE almin.tal_transferencia_det.id_transferencia_det=al_id_transferencia_det) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: registro en almin.tal_transferencia_det inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;
            
            SELECT
               t.id_almacen_logico,
               t.tipo_transferencia,
               t.estado_transferencia
               
            INTO 
                g_id_almacen_logico,
                v_tipo_transferencia,
                v_estado_transferencia
            FROM almin.tal_transferencia t 
            inner join almin.tal_transferencia_det td  on td.id_transferencia = t.id_transferencia
            WHERE id_transferencia_det = al_id_transferencia_det;
            
            IF v_estado_transferencia != 'Borrador' THEN
               raise exception 'Solo puede eliminar  en estado borrador';
            END IF;
            
            IF v_tipo_transferencia = 'devolucion' THEN
               raise exception 'no puede eliminar devoluciones';
            END IF;

         -- BORRADO DE DATO
            DELETE FROM almin.tal_transferencia_det WHERE almin.tal_transferencia_det.id_transferencia_det = al_id_transferencia_det;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminación exitosa del registro en almin.tal_transferencia_det';
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