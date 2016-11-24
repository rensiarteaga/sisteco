--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_tal_ingreso_detalle_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_ingreso_detalle integer,
  al_cantidad numeric,
  al_costo numeric,
  al_precio_venta numeric,
  al_costo_unitario numeric,
  al_precio_venta_unitario numeric,
  al_fecha_reg date,
  al_id_ingreso integer,
  al_id_item integer,
  al_estado_item varchar,
  al_id_adjudicacion integer
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ALMACENES (ALMIN)
***************************************************************************
 SCRIPT: 		almin.f_tal_ingreso_detalle_iud
 DESCRIPCIÓN: 	Permite registrar en la tabla almin.tal_ingreso_detalle
 AUTOR: 		(generado automaticamente)
 FECHA:			2007-10-18 18:12:22
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
    g_costo_total                 numeric;     -- CONTIENE EL TOTAL DE LOS COSTOS UNITARIOS DEL DETALLE
    --PARA VALORACION POR IMPORTACION
    g_codigo_mot_ing			  varchar;
    g_tot_import				  numeric;
    g_tot_nacionaliz              numeric;
    g_id_moneda_import            integer;
    g_id_moneda_nacionaliz        integer;
    g_tot_import_conv			  numeric;
    g_tot_valoracion			  numeric;
    g_fecha_factura               date;
    g_peso_neto                   numeric;
    g_FD						  numeric;
    g_precio_item				  numeric;
    g_peso_item					  numeric;
    g_costo_unitario			  numeric;
    g_error_val				  	  boolean;
    v_registros					  record;
    g_aux_cotos_det				  numeric;
    g_correlativo_ing			  integer;

BEGIN


---*** INICIACIÓN DE VARIABLES
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion := 'almin.f_tal_ingreso_detalle_iud';
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
    --raise exception 'llega %', pm_codigo_procedimiento;

      --*** EJECUCIÓN DEL PROCEDIMIENTO ESPECÍFICO
    IF pm_codigo_procedimiento = 'AL_OISDET_INS' THEN

        BEGIN

            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso
            		      WHERE id_ingreso=al_id_ingreso) THEN
        	    g_descripcion_log_error := 'Inserción no realizada: Ingreso inexistente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
        	END IF;
        	
        	IF EXISTS(SELECT 1 FROM almin.tal_ingreso_detalle
            		  WHERE id_item=al_id_item
                      AND estado_item=al_estado_item
                      AND id_ingreso=al_id_ingreso
                      AND id_adjudicacion = al_id_adjudicacion) THEN
        	    g_descripcion_log_error := 'Inserción no realizada: El item ya fue registrado';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
        	END IF;

            INSERT INTO almin.tal_ingreso_detalle(
		    cantidad                 ,costo            ,precio_venta     ,costo_unitario,
		    precio_venta_unitario    ,fecha_reg        ,id_ingreso,
		    id_item					 ,estado_item      ,id_adjudicacion
		    ) VALUES (
		    al_cantidad              ,al_costo         ,al_precio_venta  ,al_costo_unitario,
		    al_precio_venta_unitario ,now()            ,al_id_ingreso,
		    al_id_item				 ,al_estado_item   ,al_id_adjudicacion
            );

            -- OBTIENE EL TOTAL DEL COSTO UNITARIO POR INGRESO
            SELECT SUM(costo)
            INTO g_costo_total
            FROM almin.tal_ingreso_detalle
            WHERE id_ingreso = al_id_ingreso;

            -- ACTUALIZA EL COSTO TOTAL DEL INGRESO
            UPDATE almin.tal_ingreso SET
            costo_total = g_costo_total
            WHERE id_ingreso = al_id_ingreso;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso en almin.tal_ingreso_detalle';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

  --procedimiento de modificacion

   ELSIF pm_codigo_procedimiento = 'AL_OISDET_UPD' THEN

        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso_detalle
                          WHERE almin.tal_ingreso_detalle.id_ingreso_detalle=al_id_ingreso_detalle) THEN

                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de almin.tal_ingreso_detalle no existente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            IF EXISTS(SELECT 1 FROM almin.tal_ingreso_detalle
               	      WHERE id_item=al_id_item
                      AND estado_item=al_estado_item
                      AND id_ingreso=al_id_ingreso
                      AND id_ingreso_detalle != al_id_ingreso_detalle) THEN
        	    g_descripcion_log_error := 'Inserción no realizada: El item ya fue registrado';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

        	END IF;

            UPDATE almin.tal_ingreso_detalle SET
		    cantidad              = al_cantidad,
--		    costo                 = al_costo,
		    costo                 = al_cantidad*al_costo_unitario,
		    precio_venta          = al_precio_venta,
		    costo_unitario        = al_costo_unitario,
		    precio_venta_unitario = al_precio_venta_unitario,
		    id_ingreso            = al_id_ingreso,
		    id_item               = al_id_item,
            estado_item 		  = al_estado_item
			WHERE id_ingreso_detalle= al_id_ingreso_detalle;
			
			 -- OBTIENE EL TOTAL DEL COSTO UNITARIO POR INGRESO
            SELECT SUM(costo_unitario)
            INTO g_costo_total
            FROM almin.tal_ingreso_detalle
            WHERE id_ingreso = al_id_ingreso;


            -- ACTUALIZA EL COSTO TOTAL DEL INGRESO
            UPDATE almin.tal_ingreso SET
            costo_total = g_costo_total
            WHERE id_ingreso = al_id_ingreso;
            
            --Añadido por ana
         /* SELECT costo_unitario * cantidad
            INTO g_costo_total
            FROM almin.tal_ingreso_detalle
            WHERE id_ingreso_detalle = al_id_ingreso_detalle;
*/
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificación exitosa en almin.tal_ingreso_detalle';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
    /*
		AUTOR:		RAC
        FECHA		19/12/2016
        DESCR		-  bloquear eliminacion en transferencias
    
    */     

    ELSIF pm_codigo_procedimiento = 'AL_INGDET_DEL' THEN

        BEGIN
            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso_detalle
                          WHERE almin.tal_ingreso_detalle.id_ingreso_detalle=al_id_ingreso_detalle) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: registro en almin.tal_ingreso_detalle inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;
            
             select 
             	i.id_ingreso,
             	i.tipo_costeo,
             	pal.estado,
                i.id_almacen_logico,
                i.id_parametro_almacen_logico,
                i.fecha_finalizado_cancelado,
                al.costeo_obligatorio,
                i.estado_ingreso
            into
             	v_registros
            from almin.tal_ingreso i
            inner join almin.tal_almacen_logico al on al.id_almacen_logico = i.id_almacen_logico
            inner join almin.tal_parametro_almacen_logico pal on pal.id_parametro_almacen_logico = i.id_parametro_almacen_logico
            inner join almin.tal_ingreso_detalle idt on id.id_ingreso = i.id_ingreso
            where idt.id_ingreso_detalle = al_id_ingreso_detalle;
            
            SELECT
            MOTING.codigo
            INTO g_codigo_mot_ing
            FROM almin.tal_ingreso INGRES
            INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            ON MOINCU.id_motivo_ingreso_cuenta = INGRES.id_motivo_ingreso_cuenta
            INNER JOIN almin.tal_motivo_ingreso MOTING
            ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            WHERE INGRES.id_ingreso = v_registros.id_ingreso;
            
            IF g_codigo_mot_ing = 'TAA' THEN              
               raise exception 'No puede eliminar  registro en transferencias';
            END IF;
            
            

         -- BORRADO DE DATO
            DELETE FROM almin.tal_ingreso_detalle WHERE almin.tal_ingreso_detalle.id_ingreso_detalle = al_id_ingreso_detalle;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminación exitosa del registro en almin.tal_ingreso_detalle';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
    /*
		AUTOR:		RAC
        FECHA		14/12/2016
        DESCR		-  permitir ingresos con valor cero en borrador
         			-  solo puede ingresar item en ignresos con el estado en borrador
                    -  en devolucion bloquear el registro de item que no tengan una salida previa en gestiones anteriores inlcuidas
                    -  no permitir inserciones en transferencias
    
    */    
 

    ELSIF pm_codigo_procedimiento = 'AL_INDEPR_INS' THEN --INgreso DEtalle PRoyecto

        BEGIN
          
            
            select 
             	i.id_ingreso,
             	i.tipo_costeo,
             	pal.estado,
                i.id_almacen_logico,
                i.id_parametro_almacen_logico,
                i.fecha_finalizado_cancelado,
                al.costeo_obligatorio,
                i.estado_ingreso
            into
             	v_registros
            from almin.tal_ingreso i
            inner join almin.tal_almacen_logico al on al.id_almacen_logico = i.id_almacen_logico
            inner join almin.tal_parametro_almacen_logico pal on pal.id_parametro_almacen_logico = i.id_parametro_almacen_logico
            where i.id_ingreso = al_id_ingreso; 

            IF v_registros is null  THEN
        	    g_descripcion_log_error := 'Inserción no realizada: Ingreso inexistente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
        	END IF;
            
            
            IF v_registros.estado_ingreso != 'Borrador' THEN
               raise exception 'Solo puede agregar Items en ingresos con el estado Borrador';
            END IF;
        	
        	IF EXISTS(SELECT 1 FROM almin.tal_ingreso_detalle
            		  WHERE id_item=al_id_item
                      AND estado_item=al_estado_item
                      AND id_ingreso=al_id_ingreso) THEN
        	    g_descripcion_log_error := 'Inserción no realizada: El item ya fue registrado';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
        	END IF;

            g_costo_unitario = 0;
            g_costo_total = 0;

          
            SELECT
            MOTING.codigo
            INTO g_codigo_mot_ing
            FROM almin.tal_ingreso INGRES
            INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            ON MOINCU.id_motivo_ingreso_cuenta = INGRES.id_motivo_ingreso_cuenta
            INNER JOIN almin.tal_motivo_ingreso MOTING
            ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            WHERE INGRES.id_ingreso = al_id_ingreso;

            raise notice 'Codigo importacion: %',g_codigo_mot_ing;  
            
            
                    
    
            
            IF g_codigo_mot_ing = 'DEV' THEN
            
             			 select 
                            COALESCE(sad.costo_unitario,0),
                            s.correlativo_sal
                         into
                            g_aux_cotos_det,
                            g_correlativo_ing
                         from almin.tal_salida_detalle sad
                         inner join almin.tal_salida s on s.id_salida = sad.id_salida
                         where sad.id_item = al_id_item
                         		AND s.id_almacen_logico = v_registros.id_almacen_logico
                                AND s.estado_salida = 'Finalizado'
                         ORDER BY sad.id_salida_detalle DESC
                         LIMIT 1 OFFSET 0;
                        
                        
                        
            			IF g_aux_cotos_det is null THEN
                            raise exception 'No existe una ultima salida finalizada para este  material, no puede ingresar por devolucion';
                        END IF;
            
            ELSEIF g_codigo_mot_ing = 'TAA' THEN              
               raise exception 'No puede insertar registro en transferencias';
            END IF;

            
            g_costo_unitario = al_costo_unitario;
            g_costo_total = al_costo;

            INSERT INTO almin.tal_ingreso_detalle(
		    cantidad                 ,costo            ,precio_venta     ,costo_unitario,
		    precio_venta_unitario    ,fecha_reg        ,id_ingreso,
		    id_item					 ,estado_item
              
		    ) VALUES (
		    al_cantidad              ,g_costo_total    ,al_precio_venta  ,g_costo_unitario,
		    al_precio_venta_unitario ,now()            ,al_id_ingreso,
		    al_id_item				 ,al_estado_item
            );

            -- OBTIENE EL TOTAL DEL COSTO UNITARIO POR INGRESO
            SELECT SUM(costo)
            INTO g_costo_total
            FROM almin.tal_ingreso_detalle
            WHERE id_ingreso = al_id_ingreso;

            -- ACTUALIZA EL COSTO TOTAL DEL INGRESO
            UPDATE almin.tal_ingreso SET
            costo_total = g_costo_total
            WHERE id_ingreso = al_id_ingreso;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso en almin.tal_ingreso_detalle';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
     /*
		AUTOR:		RAC
        FECHA		14/12/2016
        DESCR		-  permitir ingresos con valor cero en borrador
         			-  solo puede modificar  item en ignresos con el estado en borrador
                    -  en devlucion bloquear la edición de item que no tengan una salida previa en gestiones anteriores inlcuidas
    */

      ELSIF pm_codigo_procedimiento = 'AL_INDEPR_UPD' THEN

        BEGIN
        
             select 
             	i.id_ingreso,
             	i.tipo_costeo,
             	pal.estado,
                i.id_almacen_logico,
                i.id_parametro_almacen_logico,
                i.fecha_finalizado_cancelado,
                al.costeo_obligatorio,
                i.estado_ingreso
            into
             	v_registros
            from almin.tal_ingreso i
            inner join almin.tal_almacen_logico al on al.id_almacen_logico = i.id_almacen_logico
            inner join almin.tal_parametro_almacen_logico pal on pal.id_parametro_almacen_logico = i.id_parametro_almacen_logico
            where i.id_ingreso = al_id_ingreso; 
             
             
             IF v_registros.estado_ingreso != 'Borrador' THEN
               raise exception 'Solo puede modificar  Items en ingresos con el estado Borrador';
            END IF;
            
            
            
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso_detalle
                          WHERE almin.tal_ingreso_detalle.id_ingreso_detalle=al_id_ingreso_detalle) THEN

                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de almin.tal_ingreso_detalle no existente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            IF EXISTS(SELECT 1 FROM almin.tal_ingreso_detalle
               	      WHERE id_item=al_id_item
                      AND estado_item=al_estado_item
                      AND id_ingreso=al_id_ingreso
                      AND id_ingreso_detalle != al_id_ingreso_detalle) THEN
        	    g_descripcion_log_error := 'Inserción no realizada: El item ya fue registrado';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

        	END IF;

            g_costo_unitario = 0;
            g_costo_total = 0;

            --VALORACION: si es por IMPORTACION, al insertar el registro ya calcula su costo_unitario
            --Si no es IMPORTACION no valora
            SELECT
            MOTING.codigo
            INTO g_codigo_mot_ing
            FROM almin.tal_ingreso INGRES
            INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            ON MOINCU.id_motivo_ingreso_cuenta = INGRES.id_motivo_ingreso_cuenta
            INNER JOIN almin.tal_motivo_ingreso MOTING
            ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            WHERE INGRES.id_ingreso = al_id_ingreso;

            IF g_codigo_mot_ing = 'DEV' THEN  
                      
                 select 
                    COALESCE(sad.costo_unitario,0),
                    s.correlativo_sal
                 into
                    g_aux_cotos_det,
                    g_correlativo_ing
                 from almin.tal_salida_detalle sad
                 inner join almin.tal_salida s on s.id_salida = sad.id_salida
                 where sad.id_item = al_id_item
                        AND s.id_almacen_logico = v_registros.id_almacen_logico
                        AND s.estado_salida = 'Finalizado'
                 ORDER BY sad.id_salida_detalle DESC
                 LIMIT 1 OFFSET 0;
                 
                IF g_aux_cotos_det is null THEN
                    raise exception 'No existe una ultima salida finalizada para este  material, no puede ingresar por devolucion';
                END IF;
            
            ELSEIF g_codigo_mot_ing = 'TAA' THEN              
               raise exception 'No puede modificar registro en transferencias';
            END IF;

			g_costo_unitario = al_costo_unitario;
            g_costo_total = al_costo;

            UPDATE almin.tal_ingreso_detalle SET
		    cantidad              = al_cantidad,
		    costo                 = g_costo_total,
		    precio_venta          = al_precio_venta,
		    costo_unitario        = g_costo_unitario,
		    precio_venta_unitario = al_precio_venta_unitario,
		    id_ingreso            = al_id_ingreso,
		    id_item               = al_id_item,
                    estado_item           = al_estado_item

			WHERE id_ingreso_detalle= al_id_ingreso_detalle;
			
			 -- OBTIENE EL TOTAL DEL COSTO UNITARIO POR INGRESO
            SELECT SUM(costo_unitario)
            INTO g_costo_total
            FROM almin.tal_ingreso_detalle
            WHERE id_ingreso = al_id_ingreso;

            -- ACTUALIZA EL COSTO TOTAL DEL INGRESO
            UPDATE almin.tal_ingreso SET
            costo_total = g_costo_total
            WHERE id_ingreso = al_id_ingreso;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificación exitosa en almin.tal_ingreso_detalle';
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