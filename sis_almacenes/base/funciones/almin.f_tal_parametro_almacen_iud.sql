--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_tal_parametro_almacen_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_parametro_almacen integer,
  al_dias_reserva integer,
  al_cierre varchar,
  al_gestion varchar,
  al_bloqueado varchar,
  al_actualizar varchar,
  al_observaciones varchar,
  al_id_cuenta integer,
  al_demasia_porc numeric
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ALMACENES (ALMIN)
***************************************************************************
 SCRIPT: 		almin.f_tal_parametro_almacen_iud
 DESCRIPCIÓN: 	Permite registrar en la tabla almin.tal_parametro_almacen
 AUTOR: 		(generado automaticamente)
 FECHA:			2007-10-18 15:38:45
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
    g_id_max_parametro         integer; --id maximo de la tabla parametro almacen
    g_id_parametro_anterior    integer;--id de la ultima gestion que cerro
    g_cursor			       CURSOR (ID integer) FOR SELECT
                                  						  *
                                  						  FROM almin.tal_kardex_logico
                                  						  WHERE id_parametro_almacen = ID;
    g_registro					almin.tal_kardex_logico%ROWTYPE;
 
BEGIN  


---*** INICIACIÓN DE VARIABLES
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion := 'almin.f_tal_parametro_almacen_iud';
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
    IF pm_codigo_procedimiento = 'AL_PARALM_INS' THEN

        BEGIN
        	IF EXISTS(SELECT 1 FROM almin.tal_parametro_almacen WHERE gestion= al_gestion) THEN
                g_descripcion_log_error := 'Inserción no realizada: La gestión ya fue registrada ';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;       	

            END IF;
            
            --RAC 06/12/2016,  se  comenta para permitir gestiones abiertas en paralelo
            /*
            IF EXISTS(SELECT 1 FROM almin.tal_parametro_almacen WHERE cierre= 'no') THEN
                g_descripcion_log_error := 'Gestión no Creada: Todas las gestiones deben estar cerradas para crear una nueva ';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;       	

            END IF;*/
            
            
        	 g_id_parametro_anterior:=almges.id_parametro_almacen from almin.tal_almacen_gestion almges where almges.fecha_cierre >= ALL(select fecha_cierre from almin.tal_almacen_gestion) LIMIT 1;
             SELECT NEXTVAL('almin.tal_parametro_almacen_id_parametro_almacen_seq') INTO g_id_max_parametro;

            INSERT INTO almin.tal_parametro_almacen(
		    id_parametro_almacen ,dias_reserva     ,cierre            ,gestion,
            bloqueado            ,actualizar       ,observaciones     ,id_cuenta,
            demasia_porc
		    ) VALUES (
		    g_id_max_parametro   ,al_dias_reserva  ,al_cierre         ,al_gestion,
            al_bloqueado         ,al_actualizar    ,al_observaciones  ,al_id_cuenta,
            al_demasia_porc
            );
			-- GENERA LOS CORRELATIVOS PARA LOS 12 MESES PARA CADA CORRELATIVO
            -- Orden de Ingreso 
            
            /*INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('ORDING','OI',NULL,1,2,1,g_id_max_parametro,'01');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('ORDING','OI',NULL,1,2,1,g_id_max_parametro,'02');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('ORDING','OI',NULL,1,2,1,g_id_max_parametro,'03');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('ORDING','OI',NULL,1,2,1,g_id_max_parametro,'04');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('ORDING','OI',NULL,1,2,1,g_id_max_parametro,'05');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('ORDING','OI',NULL,1,2,1,g_id_max_parametro,'06');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('ORDING','OI',NULL,1,2,1,g_id_max_parametro,'07');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('ORDING','OI',NULL,1,2,1,g_id_max_parametro,'08');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('ORDING','OI',NULL,1,2,1,g_id_max_parametro,'09');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('ORDING','OI',NULL,1,2,1,g_id_max_parametro,'10');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('ORDING','OI',NULL,1,2,1,g_id_max_parametro,'11');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('ORDING','OI',NULL,1,2,1,g_id_max_parametro,'12');
            
            -- Ingreso
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('INGRES','I',NULL,1,2,1,g_id_max_parametro,'01');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('INGRES','I',NULL,1,2,1,g_id_max_parametro,'02');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('INGRES','I',NULL,1,2,1,g_id_max_parametro,'03');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('INGRES','I',NULL,1,2,1,g_id_max_parametro,'04');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('INGRES','I',NULL,1,2,1,g_id_max_parametro,'05');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('INGRES','I',NULL,1,2,1,g_id_max_parametro,'06');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('INGRES','I',NULL,1,2,1,g_id_max_parametro,'07');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('INGRES','I',NULL,1,2,1,g_id_max_parametro,'08');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('INGRES','I',NULL,1,2,1,g_id_max_parametro,'09');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('INGRES','I',NULL,1,2,1,g_id_max_parametro,'10');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('INGRES','I',NULL,1,2,1,g_id_max_parametro,'11');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('INGRES','I',NULL,1,2,1,g_id_max_parametro,'12');
            
            -- Pedido
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('PEDIDO','P',NULL,1,2,1,g_id_max_parametro,'01');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('PEDIDO','P',NULL,1,2,1,g_id_max_parametro,'02');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('PEDIDO','P',NULL,1,2,1,g_id_max_parametro,'03');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('PEDIDO','P',NULL,1,2,1,g_id_max_parametro,'04');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('PEDIDO','P',NULL,1,2,1,g_id_max_parametro,'05');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('PEDIDO','P',NULL,1,2,1,g_id_max_parametro,'06');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('PEDIDO','P',NULL,1,2,1,g_id_max_parametro,'07');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('PEDIDO','P',NULL,1,2,1,g_id_max_parametro,'08');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('PEDIDO','P',NULL,1,2,1,g_id_max_parametro,'09');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('PEDIDO','P',NULL,1,2,1,g_id_max_parametro,'10');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('PEDIDO','P',NULL,1,2,1,g_id_max_parametro,'11');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('PEDIDO','P',NULL,1,2,1,g_id_max_parametro,'12');
            
            -- Salidas
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('SALIDA','S',NULL,1,2,1,g_id_max_parametro,'01');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('SALIDA','S',NULL,1,2,1,g_id_max_parametro,'02');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('SALIDA','S',NULL,1,2,1,g_id_max_parametro,'03');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('SALIDA','S',NULL,1,2,1,g_id_max_parametro,'04');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('SALIDA','S',NULL,1,2,1,g_id_max_parametro,'05');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('SALIDA','S',NULL,1,2,1,g_id_max_parametro,'06');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('SALIDA','S',NULL,1,2,1,g_id_max_parametro,'07');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('SALIDA','S',NULL,1,2,1,g_id_max_parametro,'08');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('SALIDA','S',NULL,1,2,1,g_id_max_parametro,'09');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('SALIDA','S',NULL,1,2,1,g_id_max_parametro,'10');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('SALIDA','S',NULL,1,2,1,g_id_max_parametro,'11');
            INSERT INTO almin.tal_correlativo(codigo,prefijo,sufijo,valor_actual,valor_siguiente,incremento,id_parametro_almacen,mes) VALUES ('SALIDA','S',NULL,1,2,1,g_id_max_parametro,'12');
            
          
            OPEN g_cursor(g_id_parametro_anterior);
             LOOP

                FETCH g_cursor INTO g_registro;
                EXIT WHEN NOT FOUND;
                insert into almin.tal_kardex_logico (estado_item,stock_minimo,cantidad,costo_unitario,
                                               costo_total,fecha_reg,id_item,id_almacen_logico,
                                               reservado,id_parametro_almacen)
                                               values(g_registro.estado_item,g_registro.stock_minimo,g_registro.cantidad,
                                               g_registro.costo_unitario,g_registro.costo_total,now(),
                                               g_registro.id_item,g_registro.id_almacen_logico,g_registro.reservado,
                                               g_id_max_parametro);
              END LOOP;
            CLOSE g_cursor;*/
            
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso en almin.tal_parametro_almacen';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

  --procedimiento de modificacion

   ELSIF pm_codigo_procedimiento = 'AL_PARALM_UPD' THEN

        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_parametro_almacen
                          WHERE almin.tal_parametro_almacen.id_parametro_almacen=al_id_parametro_almacen) THEN

                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de almin.tal_parametro_almacen no existente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            IF EXISTS(SELECT 1 FROM almin.tal_parametro_almacen WHERE gestion= al_gestion AND id_parametro_almacen!=al_id_parametro_almacen) THEN
                g_descripcion_log_error := 'Modificación no realizada: la gestión ya fue registrada ';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;       	
            END IF;
            
            UPDATE almin.tal_parametro_almacen SET
		    dias_reserva  = al_dias_reserva,
		    cierre        = al_cierre,
		    gestion       = al_gestion,
		    bloqueado     = al_bloqueado,
		    actualizar    = al_actualizar,
		    observaciones = al_observaciones,
		    id_cuenta     = al_id_cuenta,
            demasia_porc  = al_demasia_porc
			WHERE id_parametro_almacen = al_id_parametro_almacen;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificación exitosa en almin.tal_parametro_almacen';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

        ELSIF pm_codigo_procedimiento = 'AL_PARALM_DEL' THEN

    BEGIN
            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_parametro_almacen
                          WHERE almin.tal_parametro_almacen.id_parametro_almacen=al_id_parametro_almacen) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: registro en almin.tal_parametro_almacen inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

 			-- VERIFICACIÓN DE EXISTENCIA DE HIJOS
            IF EXISTS(SELECT 1 FROM almin.tal_parametro_almacen PARALM
                      INNER JOIN almin.tal_correlativo CORREL
                      ON CORREL.id_parametro_almacen = PARALM.id_parametro_almacen
                      WHERE PARALM.id_parametro_almacen = al_id_parametro_almacen) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: El Parámetro de Almacén tiene Correlativos asociados';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
               RETURN 'f'||g_separador||g_respuesta;

            END IF;

         -- BORRADO DE DATO
            DELETE FROM almin.tal_parametro_almacen WHERE almin.tal_parametro_almacen.id_parametro_almacen = al_id_parametro_almacen;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminación exitosa del registro en almin.tal_parametro_almacen';
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