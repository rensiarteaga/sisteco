--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_tal_transferencia_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_transferencia integer,
  al_prestamo varchar,
  al_estado_transferencia varchar,
  al_motivo varchar,
  al_descripcion varchar,
  al_observaciones varchar,
  al_fecha_pendiente_sal date,
  al_fecha_pendiente_ing date,
  al_fecha_finalizado_anulado date,
  al_id_empleado integer,
  al_id_firma_autorizada_transf integer,
  al_id_almacen_logico integer,
  al_id_almacen_logico_destino integer,
  al_id_motivo_ingreso_cuenta integer,
  al_fecha_borrador date,
  al_fecha_pendiente date,
  al_fecha_rechazado date,
  al_id_ingreso integer,
  al_id_salida integer,
  al_id_tipo_material integer,
  al_id_motivo_salida_cuenta integer,
  al_id_ingreso_prestamo integer,
  al_id_salida_prestamo integer,
  al_tipo_transferencia varchar,
  al_importe_abierto varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ALMACENES (ALMIN)
***************************************************************************
 SCRIPT: 		almin.f_tal_transferencia_iud
 DESCRIPCIÓN: 	Permite registrar en la tabla almin.tal_transferencia
 AUTOR: 		(generado automaticamente)
 FECHA:			2007-11-21 08:58:38
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
                                                        



select a.id_almacen_logico from almin.tal_almacen_logico a
inner join almin.tal_tipo_almacen b
on b.id_tipo_almacen = a.id_tipo_almacen
and b.nombre='Baja'
inner join almin.tal_almacen_ep e
on e.id_almacen_ep = a.id_almacen_ep
inner join almin.tal_almacen al
on al.id_almacen = e.id_almacen
where e.id_fina_regi_prog_proy_acti = 1
and e.id_almacen = 1
                                                        
                                                        
                                                        

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
    g_id_salida                   integer;
    g_id_firma_autorizada         integer;
    g_contabilizar                varchar;
    g_registro                    almin.tal_transferencia%ROWTYPE;
    g_id_firma_autorizada_transf  integer;
    g_prestamo                    varchar;
    g_id_motivo_salida_cuenta     integer;
    g_id_usuario_firma            integer;
    g_id_tarea_pendiente          integer;
    g_id_usuario_almacen          integer;
    g_bandera                     integer;
    g_id_responsable_almacen      integer;
    g_id_almacen_logico           integer; 
    g_id_almacen_logico_destino   integer;
    g_id_motivo_ingreso_cuenta    integer;   
    g_id_ingreso				  integer;
    g_id_parametro_almacen        integer;
    g_id_parametro_almacen_logico		integer;
    v_nombre_al_destino					varchar;
    v_registros							record;
    v_registros_det						record;
    v_id_transferencia_dev				integer;

BEGIN


     ---*** INICIACIÓN DE VARIABLES
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion := 'almin.f_tal_transferencia_iud';
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

    --raise exception 'llega..';

    --*** EJECUCIÓN DEL PROCEDIMIENTO ESPECÍFICO
    /*
    Autor:   		RAC
    Fecha:	 		09/01/2017
    Descripcion:	registro de nuevos campos, tipo_transferencia, importe_abierto
    
    */
    
    --raise exception 'llega';  
    
    IF pm_codigo_procedimiento = 'AL_TRABOR_INS' THEN  --TRABOR: Transferencia Borrador

        BEGIN
        
            -- OBTENER LA FIRMA AUTORIZADA
           -- raise exception '%,%',al_id_motivo_ingreso_cuenta,al_id_motivo_salida_cuenta;

            IF NOT EXISTS(SELECT 1 FROM almin.tal_firma_autorizada_transf FIAUTR
                          inner join almin.tal_motivo_ingreso_cuenta MOINCU ON FIAUTR.id_motivo_ingreso_cuenta= MOINCU.id_motivo_ingreso_cuenta
                          INNER JOIN almin.tal_motivo_ingreso MOTING on MOTING.id_motivo_ingreso= MOINCU.id_motivo_ingreso
                          INNER JOIN almin.tal_motivo_salida_cuenta MOSACU on MOSACU.id_motivo_salida_cuenta= FIAUTR.id_motivo_salida_cuenta
                          INNER JOIN almin.tal_motivo_salida MOTSAL on MOTSAL.id_motivo_salida= MOSACU.id_motivo_salida
                          WHERE FIAUTR.id_motivo_ingreso_cuenta = al_id_motivo_ingreso_cuenta
                          AND FIAUTR.id_motivo_salida_cuenta = al_id_motivo_salida_cuenta
                          AND MOTING.estado_registro='activo'
                          AND MOTSAL.estado_registro ='activo') THEN
                g_descripcion_log_error := 'Insercion no realizada: firma autorizada para transferencia no registrada';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;

            SELECT
            FIAUTR.id_firma_autorizada_transf
            INTO
            g_id_firma_autorizada_transf
            FROM
            almin.tal_firma_autorizada_transf FIAUTR
            /*inner join almin.tal_motivo_ingreso_cuenta MOINCU ON FIAUTR.id_motivo_ingreso_cuenta= MOINCU.id_motivo_ingreso_cuenta
            INNER JOIN almin.tal_motivo_ingreso MOTING on MOTING.id_motivo_ingreso= MOINCU.id_motivo_ingreso AND MOTING.estado_registro='no'
            INNER JOIN almin.tal_motivo_salida_cuenta MOSACU on MOSACU.id_motivo_salida_cuenta= FIAUTR.id_motivo_salida_cuenta
            INNER JOIN almin.tal_motivo_salida MOTSAL on MOTSAL.id_motivo_salida= MOSACU.id_motivo_salida AND MOTSAL.estado_registro='activo'
           */ WHERE FIAUTR.id_motivo_ingreso_cuenta = al_id_motivo_ingreso_cuenta
            AND FIAUTR.id_motivo_salida_cuenta = al_id_motivo_salida_cuenta AND FIAUTR.estado_registro='activo';
            
            
            ---10-02-2008 revisar porque no inserta con los joins comentados
           
            INSERT INTO almin.tal_transferencia(
		    prestamo                    ,estado_transferencia          ,motivo                  ,descripcion,
		    observaciones               ,fecha_pendiente_sal           ,fecha_pendiente_ing     ,fecha_finalizado_anulado,
		    id_empleado                 ,id_firma_autorizada_transf    ,id_almacen_logico       ,id_almacen_logico_destino,
		    id_motivo_ingreso_cuenta    ,fecha_borrador                ,fecha_pendiente         ,fecha_rechazado,
		    id_ingreso                  ,id_salida                     ,id_tipo_material        ,id_motivo_salida_cuenta,
            tipo_transferencia			,importe_abierto
		    ) VALUES (
		    'no'                 ,'Borrador'                    ,al_motivo               ,al_descripcion,
		    al_observaciones            ,NULL                          ,NULL                    ,NULL,
		    al_id_empleado              ,g_id_firma_autorizada_transf  ,al_id_almacen_logico    ,al_id_almacen_logico_destino,
		    al_id_motivo_ingreso_cuenta ,now()                         ,NULL                    ,NULL,
		    NULL                        ,NULL                          ,al_id_tipo_material     ,al_id_motivo_salida_cuenta,
            al_tipo_transferencia		,al_importe_abierto
            );
            
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso de la transferencia';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

  --procedimiento de modificacion
  
  /*
   AUTOR:  		RAC
   Fecha:		10/01/2017
   Desc			- bloquear la edición de transferencias del tipo devolucion
  
  */

   ELSIF pm_codigo_procedimiento = 'AL_TRABOR_UPD' THEN --TRABOR: Transferencia Borrador

        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia
                          WHERE almin.tal_transferencia.id_transferencia=al_id_transferencia) THEN

                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de almin.tal_transferencia no existente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;
            
             --VERIFICA SI ESTÁ EN ESTADO BORRADOR
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia
                          WHERE id_transferencia=al_id_transferencia
                          AND estado_transferencia='Borrador') THEN

                g_descripcion_log_error := 'Modificación no realizada: la transferencia no está en estado Borrador';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;
            
            -- OBTENER LA FIRMA AUTORIZADA
            SELECT
            id_firma_autorizada_transf
            INTO
            g_id_firma_autorizada_transf
            FROM
            almin.tal_firma_autorizada_transf
            WHERE id_motivo_ingreso_cuenta = al_id_motivo_ingreso_cuenta
            AND id_motivo_salida_cuenta = al_id_motivo_salida_cuenta and estado_registro='activo';
            
            
            select
              t.id_transferencia,
              t.tipo_transferencia
             into
              v_registros
            from almin.tal_transferencia t
            where id_transferencia = al_id_transferencia;
            
            IF v_registros.tipo_transferencia = 'devolucion' THEN
                raise exception 'No puede editar transferencias del tipo devolucion';
            END IF;

            UPDATE almin.tal_transferencia SET		   
                motivo                     = al_motivo,
                descripcion                = al_descripcion,
                observaciones              = al_observaciones,
                id_empleado                = al_id_empleado,
                id_firma_autorizada_transf = g_id_firma_autorizada_transf,
                id_almacen_logico          = al_id_almacen_logico,
                id_almacen_logico_destino  = al_id_almacen_logico_destino,
                id_motivo_ingreso_cuenta   = al_id_motivo_ingreso_cuenta,
                id_tipo_material           = al_id_tipo_material,
                id_motivo_salida_cuenta    = al_id_motivo_salida_cuenta,
                tipo_transferencia 		   = al_tipo_transferencia	,
                importe_abierto 		   = al_importe_abierto
			WHERE id_transferencia = al_id_transferencia;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificación exitosa de la transferencia';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
               
        --procedimiento de modificacion

   ELSIF pm_codigo_procedimiento = 'AL_BAJPEN_INS' THEN --TRABOR: Pendientes

        BEGIN
                      
            SELECT al.id_almacen_logico INTO  g_id_almacen_logico_destino  FROM almin.tal_almacen_logico al
			INNER JOIN almin.tal_tipo_almacen tipalm
			ON tipalm.id_tipo_almacen = al.id_tipo_almacen
			AND tipalm.nombre='Baja'
			INNER JOIN almin.tal_almacen_ep ep
			ON ep.id_almacen_ep = al.id_almacen_ep
			INNER JOIN almin.tal_almacen alm
			ON alm.id_almacen = ep.id_almacen;
			
            SELECT mcu.id_motivo_salida_cuenta INTO g_id_motivo_salida_cuenta FROM almin.tal_motivo_salida_cuenta mcu
			INNER JOIN param.tpm_fina_regi_prog_proy_acti ep 
			ON ep.id_fina_regi_prog_proy_acti = mcu.id_fina_regi_prog_proy_acti
			INNER join almin.tal_motivo_salida ing
			ON ing.id_motivo_salida = mcu.id_motivo_salida
			AND ing.tipo='Baja'
            LIMIT 1;
           
            -- OBTENER LA FIRMA AUTORIZADA
            SELECT
            id_firma_autorizada_transf
            INTO
            g_id_firma_autorizada_transf
            FROM
            almin.tal_firma_autorizada_transf
            WHERE id_motivo_ingreso_cuenta = al_id_motivo_ingreso_cuenta
            AND id_motivo_salida_cuenta = g_id_motivo_salida_cuenta;

            IF g_id_firma_autorizada_transf IS NULL THEN
                g_descripcion_log_error := 'Registro de Baja no realizado: No existe Funcionario que autorice la Baja';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;
            
			
            INSERT INTO almin.tal_transferencia(
		    prestamo                    ,estado_transferencia          ,motivo                  ,descripcion,
		    observaciones               ,fecha_pendiente_sal           ,fecha_pendiente_ing     ,fecha_finalizado_anulado,
		    id_empleado                 ,id_firma_autorizada_transf    ,id_almacen_logico       ,id_almacen_logico_destino,
		    id_motivo_ingreso_cuenta    ,fecha_borrador                ,fecha_pendiente         ,fecha_rechazado,
		    id_ingreso                  ,id_salida                     ,id_tipo_material        ,id_motivo_salida_cuenta
		    ) VALUES (
		    'no'                		,'Borrador'                    ,al_motivo               ,al_descripcion,
		    al_observaciones            ,NULL                          ,NULL                    ,NULL,
		    al_id_empleado              ,g_id_firma_autorizada_transf  ,al_id_almacen_logico    ,g_id_almacen_logico_destino,
		    al_id_motivo_ingreso_cuenta ,now()                         ,NULL                    ,NULL,
		    NULL                        ,NULL                          ,al_id_tipo_material     ,g_id_motivo_salida_cuenta
            );
            
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso de la transferencia';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
                      
        ELSIF pm_codigo_procedimiento = 'AL_BAJPEN_FIN' THEN  --BAJPEN: Baja de  Borrador a Pendiente Fin
    -- Finaliza la Transferencia Solicitud; cambia el estado a 'Pendiente'
        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia
                          WHERE id_transferencia=al_id_transferencia) THEN

                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de almin.tal_transferencia no existente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;
            
            --VERIFICA SI ESTÁ EN ESTADO BORRADOR
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia
                          WHERE id_transferencia=al_id_transferencia
                          AND estado_transferencia='Borrador') THEN

                g_descripcion_log_error := 'Finalización no realizada: la transferencia no está en estado Borrador';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;
            
            --VERIFICA SI TIENE EL MATERIAL DETALLADO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia_det
                          WHERE id_transferencia=al_id_transferencia) THEN

                g_descripcion_log_error := 'Finalización no realizada: no existe ningún material detallado para la transferencia';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --obtener autorizador para aprobar bajas (firma autorizada)
            
            SELECT USUARI.id_usuario into g_id_usuario_firma
                    FROM sss.tsg_usuario USUARI
                    INNER JOIN kard.tkp_empleado EMPLEA ON USUARI.id_persona=EMPLEA.id_persona
                    INNER JOIN almin.tal_firma_autorizada_transf FIAUTR ON FIAUTR.id_empleado = EMPLEA.id_empleado
                    INNER JOIN almin.tal_transferencia TRANSF ON TRANSF.id_firma_autorizada_transf = FIAUTR.id_firma_autorizada_transf
                    WHERE TRANSF.id_transferencia= al_id_transferencia;

			SELECT NEXTVAL('sss.tsg_tarea_pendiente_id_tarea_pendiente_seq') INTO g_id_tarea_pendiente;
		
			INSERT INTO sss.tsg_tarea_pendiente(id_tarea_pendiente, id_usuario, id_subsistema,tarea,descripcion, codigo_procedimiento, estado,fecha_reg)
			VALUES (g_id_tarea_pendiente, g_id_usuario_firma,g_id_subsistema,'Aprobar Baja de Material','Baja de material pendiente de aprobación','AL_APRTRA','Pendiente',now());
		
			INSERT INTO sss.tsg_tarea_pendiente_asignador (nombre_tabla, id_registro, estado,id_tarea_pendiente)
			VALUES('almin.tal_transferencia', al_id_transferencia,'Pendiente',g_id_tarea_pendiente);
			
			UPDATE almin.tal_transferencia SET
		    estado_transferencia       = 'Pendiente',
		    fecha_pendiente            = now()
			WHERE id_transferencia = al_id_transferencia;
			

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Transferencia lista para aprobación';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
    /*
    Autor:			RAC
    Fecha:			10/01/2016
    Descripcion		-  Al eliminar transferencias del tipo de volucion resetear en el pretamos el ID
    */    
        
    ELSIF pm_codigo_procedimiento = 'AL_TRABOR_DEL' THEN --TRABOR: Transferencia Borrador

        BEGIN
            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia
                          WHERE almin.tal_transferencia.id_transferencia = al_id_transferencia) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: registro en almin.tal_transferencia inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;
            
             --VERIFICA SI ESTÁ EN ESTADO BORRADOR
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia
                          WHERE id_transferencia=al_id_transferencia
                          AND estado_transferencia='Borrador') THEN

                g_descripcion_log_error := 'Eliminación no realizada: la transferencia no está en estado Borrador';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;
            
            --si un devolucion este update reseteal en el pretamo para que puedan crear otra devolucion
           
             select
               t.id_transferencia,
               t.tipo_transferencia
              into
               v_registros
            from almin.tal_transferencia t
            where t.id_transferencia = al_id_transferencia;
            
            IF v_registros.tipo_transferencia = 'devolucion'  THEN
                 update almin.tal_transferencia  set
                     id_transferencia_dev = NULL
                 where id_transferencia_dev = al_id_transferencia;
            END IF;
            
            

            -- BORRADO DE REGISTRO
            IF EXISTS(SELECT 1 from almin.tal_transferencia_det WHERE id_transferencia=al_id_transferencia) THEN
               DELETE FROM almin.tal_transferencia_det WHERE id_transferencia=al_id_transferencia;
               DELETE FROM almin.tal_transferencia WHERE id_transferencia = al_id_transferencia;
            ELSE
               DELETE FROM almin.tal_transferencia WHERE id_transferencia = al_id_transferencia;
            END IF;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminación exitosa del registro en almin.tal_transferencia';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
        /*
        Autor: 			RAC
        Fecha: 			14/12/2016
        Descripcion		- Se llama al mandar para aprobar la transferencias
        
        */

    ELSIF pm_codigo_procedimiento = 'AL_TRABOR_FIN' THEN  --TRABOR: Transferencia Borrador Fin
    -- Finaliza la Transferencia Solicitud; cambia el estado a 'Pendiente'
        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia
                          WHERE id_transferencia=al_id_transferencia) THEN

                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de almin.tal_transferencia no existente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;
            
            --VERIFICA SI ESTÁ EN ESTADO BORRADOR
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia
                          WHERE id_transferencia=al_id_transferencia
                          AND estado_transferencia='Borrador') THEN

                g_descripcion_log_error := 'Finalización no realizada: la transferencia no está en estado Borrador';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;
            
            --VERIFICA SI TIENE EL MATERIAL DETALLADO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia_det
                          WHERE id_transferencia=al_id_transferencia) THEN

                g_descripcion_log_error := 'Finalización no realizada: no existe ningún material detallado para la transferencia';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            UPDATE almin.tal_transferencia SET
		    estado_transferencia       = 'Pendiente',
		    fecha_pendiente            = now()
			WHERE id_transferencia = al_id_transferencia;	
			--alerta para aprobar transferencia, la cual irá para el autorizador que esté asignado (firaut para transferencias)

           SELECT USUARI.id_usuario into g_id_usuario_firma
                    FROM sss.tsg_usuario USUARI
                    INNER JOIN kard.tkp_empleado EMPLEA ON USUARI.id_persona=EMPLEA.id_persona
                    INNER JOIN almin.tal_firma_autorizada_transf FIAUTR ON FIAUTR.id_empleado = EMPLEA.id_empleado
                    INNER JOIN almin.tal_transferencia TRANSF ON TRANSF.id_firma_autorizada_transf = FIAUTR.id_firma_autorizada_transf
                    WHERE TRANSF.id_transferencia= al_id_transferencia;


		    SELECT NEXTVAL('sss.tsg_tarea_pendiente_id_tarea_pendiente_seq') INTO g_id_tarea_pendiente;
		
			INSERT INTO sss.tsg_tarea_pendiente(id_tarea_pendiente, id_usuario, id_subsistema,tarea,descripcion, codigo_procedimiento, estado,fecha_reg)
			VALUES (g_id_tarea_pendiente, g_id_usuario_firma,g_id_subsistema,'Aprobar transferencia de Material','Transferencia de material pendiente de aprobación','AL_APRTRA','Pendiente',now());
		
			INSERT INTO sss.tsg_tarea_pendiente_asignador (nombre_tabla, id_registro, estado,id_tarea_pendiente)
			VALUES('almin.tal_transferencia', al_id_transferencia,'Pendiente',g_id_tarea_pendiente);

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Transferencia lista para aprobación';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
     /*
     Autor: 			RAC
     Fecha: 			14/12/2016
     Descripcion: 		- 	Aprueba transferencia, transcribe salida inical en almacen de origen
      					-  Considerar la gestion abierta segun parametro almacen logico
                        -  mejora la descripcion de  la salida
     */   
        
    ELSIF pm_codigo_procedimiento = 'AL_TRAPEN_APR' THEN  --TRAPEN: Transferencia Pendiente aprobación
    -- Aprobación de transferencias
        BEGIN
        raise notice '%','entra';
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia
                          WHERE id_transferencia=al_id_transferencia) THEN

                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de almin.tal_transferencia no existente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;
            
            --VERIFICA SI ESTÁ EN ESTADO PENDIENTE
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia
                          WHERE id_transferencia=al_id_transferencia
                          AND estado_transferencia='Pendiente') THEN

                g_descripcion_log_error := 'Aprobación no realizada: la transferencia no está en estado Pendiente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

			--OBTIENE LOS DATOS DE LA TRANSFERENCIA
			SELECT
			  *
			INTO 
               g_registro
			FROM almin.tal_transferencia t 
			WHERE id_transferencia = al_id_transferencia;
            
            SELECT
			  al.nombre 
			INTO 
               v_nombre_al_destino
			FROM almin.tal_almacen_logico al 
			WHERE al.id_almacen_logico = g_registro.id_almacen_logico_destino;
            
          
            
            --v_nombre_al_destino = g_registro.nombre_al_destino;
			
			--VERIFICA SI SE CONTABILIZA O NO (SI ES PRÉSTAMO DE HECHO NO SE CONTABILIZA)
			IF g_registro.prestamo = 'si' THEN
			    g_contabilizar = 'no';
            ELSE
                SELECT
                TIPALM.contabilizar
                INTO g_contabilizar
                FROM almin.tal_almacen_logico ALMLOG
                INNER JOIN almin.tal_tipo_almacen TIPALM
                ON TIPALM.id_tipo_almacen = ALMLOG.id_tipo_almacen
                WHERE ALMLOG.id_almacen_logico = g_registro.id_almacen_logico;
			END IF;
            
            
            
             -- OBTIENE LA GESTIÓN VIGENTE
            SELECT 
                pl.id_parametro_almacen,
                pl.id_parametro_almacen_logico
            INTO 
                g_id_parametro_almacen,
                g_id_parametro_almacen_logico
            FROM almin.tal_parametro_almacen_logico pl
            WHERE      pl.estado = 'abierto'
                  and pl.id_almacen_logico = g_registro.id_almacen_logico;
			
						
			

            IF g_id_parametro_almacen IS NULL THEN

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
			
			--CONCLUIR ALERTA DE APROBACION DE TRANSFERENCIA EN VISTA TRANSFERENCIA
		           -- obtener id del encargado de autorizar transferencia
					SELECT USUARI.id_usuario
                    INTO g_id_usuario_firma
                    FROM sss.tsg_usuario USUARI
                    INNER JOIN kard.tkp_empleado EMPLEA ON USUARI.id_persona=EMPLEA.id_persona
                    INNER JOIN almin.tal_firma_autorizada_transf FIAUTR ON FIAUTR.id_empleado = EMPLEA.id_empleado
                    INNER JOIN almin.tal_transferencia TRANSF ON TRANSF.id_firma_autorizada_transf = FIAUTR.id_firma_autorizada_transf
                    WHERE TRANSF.id_transferencia= al_id_transferencia;

			         --bandera=1 si el usuario es administrador del Sistema, donde rol=1
                     SELECT 1
                     INTO g_bandera
                     FROM sss.tsg_usuario USUARI
                     INNER JOIN sss.tsg_usuario_rol USUROL
                     ON USUARI.id_usuario=USUROL.id_usuario
                     WHERE USUARI.id_usuario=pm_id_usuario
                     AND USUROL.id_rol=1;


                     IF(g_id_usuario_firma>0) THEN
                         SELECT TARPEN.id_tarea_pendiente INTO g_id_tarea_pendiente
                         FROM sss.tsg_tarea_pendiente TARPEN
                         INNER JOIN sss.tsg_tarea_pendiente_asignador TAPEAS ON TARPEN.id_tarea_pendiente= TAPEAS.id_tarea_pendiente
                         WHERE TARPEN.id_usuario = g_id_usuario_firma AND TARPEN.id_subsistema = g_id_subsistema AND
                         TAPEAS.id_registro=al_id_transferencia AND TAPEAS.nombre_tabla = 'almin.tal_transferencia' AND TARPEN.estado= TAPEAS.estado AND TARPEN.estado='Pendiente'
                         AND ((g_id_usuario_firma=pm_id_usuario) OR (g_bandera=1));
                         raise notice 'despues dddd%',g_id_tarea_pendiente;
                            IF(g_id_tarea_pendiente>0) THEN
                           --cambiar el estado del registro de transferencia a estado pendiente de salida
                           
                                      -- HACER UPDATE TRANSFERENCIA PARA RELACIONAR EL ID SALIDA
                                      UPDATE almin.tal_transferencia SET
		                              estado_transferencia       = 'Pendiente_salida',
		                              fecha_pendiente_sal        = now(),
		                              id_salida                  = g_id_salida
			                          WHERE id_transferencia = al_id_transferencia;
			                          
                                      -- concluir alerta de aprobacion de transferencia
                                       UPDATE sss.tsg_tarea_pendiente
                                       SET estado='Concluida',
                                       fecha_concluido_anulado=now()
                                       WHERE id_tarea_pendiente=g_id_tarea_pendiente;

                                       UPDATE sss.tsg_tarea_pendiente_asignador set estado='Concluida'
                                       where id_registro=al_id_transferencia AND id_tarea_pendiente= g_id_tarea_pendiente AND nombre_tabla = 'almin.tal_transferencia';

			                          -- creamos la salida
                                      -- SE OBTIENE LA FIRMA AUTORIZADA de salida por transferencia CORRESPONDIENTE AL ALMACEN LOGICO ORIGEN
                                          SELECT
                                          FIRAUT.id_firma_autorizada
                                          INTO g_id_firma_autorizada
                                          FROM almin.tal_firma_autorizada FIRAUT
                                          INNER JOIN almin.tal_almacen_logico ALMLOG
                                          ON ALMLOG.id_almacen_ep = FIRAUT.id_almacen_ep
                                          INNER JOIN almin.tal_motivo_salida MOTSAL
                                          ON MOTSAL.id_motivo_salida = FIRAUT.id_motivo_salida
                                          INNER JOIN almin.tal_motivo_salida_cuenta MSALCU
                                          ON MSALCU.id_motivo_salida = MOTSAL.id_motivo_salida
                                          WHERE ALMLOG.id_almacen_logico = g_registro.id_almacen_logico
                                          AND MSALCU.id_motivo_salida_cuenta = g_registro.id_motivo_salida_cuenta
                                          AND FIRAUT.estado_reg='activo'
                                          ORDER BY FIRAUT.prioridad ASC, FIRAUT.id_firma_autorizada ASC
                                          LIMIT 1;

                                          --OBTENCION RESPONSABLE ALMACEN ORIGEN
                                          SELECT id_almacen_logico INTO  g_id_almacen_logico  FROM almin.tal_transferencia
                                          where id_transferencia=al_id_transferencia;

                                          SELECT
                                          RESALM.id_responsable_almacen
                                          INTO g_id_usuario_firma
                                          FROM almin.tal_almacen_logico ALMLOG
                                          INNER JOIN almin.tal_almacen_ep ALMAEP
                                          ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
                                          INNER JOIN almin.tal_almacen ALMACE
                                          ON ALMACE.id_almacen = ALMAEP.id_almacen
                                          INNER JOIN almin.tal_responsable_almacen RESALM
                                          ON RESALM.id_almacen = ALMACE.id_almacen
                                          AND RESALM.estado = 'activo'
                                          INNER JOIN kard.tkp_empleado EMPLEA
                                          ON EMPLEA.id_empleado = RESALM.id_empleado
                                          INNER JOIN sss.tsg_persona PERSON
                                          ON PERSON.id_persona = EMPLEA.id_persona
                                          INNER JOIN sss.tsg_usuario USUARI
                                          ON USUARI.id_persona = PERSON.id_persona
                                          WHERE ALMLOG.id_almacen_logico = g_id_almacen_logico;

                                          -- fin obtencion del responsable del almacen origen

                                          


			                              --OBTIENE EL ÚLTIMO VALOR DE LA SECUENCIA PARA INSERTAR LA SALIDA
			                              SELECT NEXTVAL('almin.tal_salida_id_salida_seq') INTO g_id_salida;
		
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
                                                 g_id_salida                    ,g_registro.motivo||' (Tranferencia tipo '|| g_registro.tipo_transferencia ||',  al almacen '||v_nombre_al_destino||' Nro '  ,g_contabilizar,
                                                 'Aprobado'                     ,'activo'                   ,NULL                    ,g_id_usuario_firma,
                                                 g_registro.id_almacen_logico   ,g_registro.id_empleado     ,g_id_firma_autorizada   ,NULL,
                                                 g_registro.id_tipo_material    ,NULL                       ,NULL                    ,now(),
                                                 now()                          ,now()                      ,NULL                    ,NULL,
                                                 NULL                           ,NULL                       ,0                       ,g_registro.id_motivo_salida_cuenta,
                                                 pm_id_usuario                  ,'No'                       ,0                       ,g_id_parametro_almacen,
                                                 g_id_parametro_almacen_logico
                                          );

                                          -- CREACIÓN DEL DETALLE
                                          INSERT INTO almin.tal_salida_detalle(
                                                 costo             ,costo_unitario  ,precio_unitario  ,cant_solicitada,
                                                 fecha_solicitada  ,id_item         ,id_salida        ,estado_item,
                                                 cant_entregada)
                                          SELECT
                                                 costo             ,costo_unitario  ,precio_unitario  ,cantidad,
                                                 now()             ,id_item         ,g_id_salida      ,estado_item,
                                                 cantidad
                                          FROM almin.tal_transferencia_det
                                          WHERE id_transferencia = al_id_transferencia;

                           
                                          
                                          UPDATE almin.tal_transferencia SET
                                          id_salida = g_id_salida
                                          WHERE id_transferencia=al_id_transferencia;
                                         
			     
                         ELSE
                            g_descripcion_log_error := 'Tarea Pendiente no finalizada: No le corresponde aprobar transferencias';
                            g_nivel_error := '4';
                            g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                            RETURN 'f'||g_separador||g_respuesta;
                         END IF;
                     ELSE
                            g_descripcion_log_error := 'Finalización no realizada: La firma de Autorización no pertenece a un usuario valido para esa operacion';
                            g_nivel_error := '4';
                            g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                            RETURN 'f'||g_separador||g_respuesta;
                     END IF;
			
			-- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Transferencia aprobada';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
     /*
     Autor:			RAC
     Fecha			10/01/2016
     DESC			-  al rechar si una devolucion resetea el ID en el prestamo
     
     */   
        
    ELSIF pm_codigo_procedimiento = 'AL_TRAPEN_REC' THEN --TRAPEN: Transferencia Pendiente
    -- Rechazar transferencia
        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO  
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia
                          WHERE id_transferencia=al_id_transferencia) THEN

                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de almin.tal_transferencia no existente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI ESTÁ EN ESTADO PENDIENTE
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia
                          WHERE id_transferencia=al_id_transferencia
                          AND estado_transferencia='Pendiente') THEN

                g_descripcion_log_error := 'Aprobación no realizada: la transferencia no está en estado Pendiente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;
            
            select
               t.id_transferencia,
               t.tipo_transferencia
              into
               v_registros
            from almin.tal_transferencia t
            where t.id_transferencia = al_id_transferencia;
            
            IF v_registros.tipo_transferencia = 'devolucion'  THEN
                 update almin.tal_transferencia  set
                     id_transferencia_dev = NULL
                 where id_transferencia_dev = al_id_transferencia;
            END IF;

            UPDATE almin.tal_transferencia SET
            estado_transferencia       = 'Rechazado',
		    fecha_rechazado            = now()
			WHERE id_transferencia = al_id_transferencia;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Transferencia rechazada';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
    /*ELSIF pm_codigo_procedimiento = 'AL_TRAAPR_SAL' THEN --TRAAPR: Transferencia Aprobada
    -- Cuando se realiza la salida del material a transferir. Cambia el estado de 'Pendiente_salida' a 'Pendiente_ingreso'
        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia
                          WHERE id_transferencia=al_id_transferencia) THEN

                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de almin.tal_transferencia no existente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI ESTÁ EN ESTADO PENDIENTE
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia_det
                          WHERE id_transferencia=al_id_transferencia
                          AND estado_transferencia='Pendiente_salida') THEN

                g_descripcion_log_error := 'Aprobación no realizada: la transferencia no está en estado Pendiente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;
            
            UPDATE almin.tal_transferencia SET
		    estado_transferencia       = 'Pendiente_ingreso',
		    fecha_pendiente_ing        = now()
			WHERE id_transferencia = al_id_transferencia;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Salida de material a transferir realizada';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;*/
        
    /*ELSIF pm_codigo_procedimiento = 'AL_PREREC_FIN' THEN --PREREC: Préstamo Recepción Finalizar
    -- Recepción del préstamo; cambia el estado a Finalizado
        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia
                          WHERE id_transferencia=al_id_transferencia) THEN

                g_descripcion_log_error := 'Finalización no realizada: no existe el registro de la transferencia';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI ESTÁ EN ESTADO PENDIENTE PRESTAMO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia
                          WHERE id_transferencia=al_id_transferencia
                          AND estado_transferencia='Pendiente_prestamo') THEN

                g_descripcion_log_error := 'Finalización no realizada: la transferencia no está en estado Pendiente Préstamo';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            UPDATE almin.tal_transferencia SET
		    estado_transferencia       = 'Pendiente_ingreso',
		    fecha_pendiente_ing        = now()
			WHERE id_transferencia = al_id_transferencia;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Salida de material a transferir realizada';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;*/

    ELSIF pm_codigo_procedimiento = 'AL_PREDEV_FIN' THEN --PREDEV: Préstamo Devolución
        -- Devolución de Préstamo; cambia el estado a Ingreso_prestamo
        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia
                          WHERE id_transferencia=al_id_transferencia) THEN

                g_descripcion_log_error := 'Finalización no realizada: no existe el registro de la transferencia';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI ESTÁ EN ESTADO PENDIENTE PRESTAMO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia
                          WHERE id_transferencia=al_id_transferencia
                          AND estado_transferencia='Salida_prestamo') THEN

                g_descripcion_log_error := 'Finalización no realizada: la transferencia no está en estado Salida Préstamo';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;
            
            --OBTIENE LOS DATOS DE LA TRANSFERENCIA
			SELECT
			*
			INTO g_registro
			FROM almin.tal_transferencia
			WHERE id_transferencia = al_id_transferencia;
			
			--VERIFICAR SI SE CONTABILIZA O NO
            g_contabilizar ='no';
            
            --obtencion de id_parametro_almacen
            SELECT id_parametro_almacen
            INTO g_id_parametro_almacen
            FROM almin.tal_parametro_almacen
            WHERE cierre = 'no';
            -- SE OBTIENE LA EP DE LA TRANSFERENCIA
            SELECT
            MOSACU.id_fina_regi_prog_proy_acti
            INTO g_id_fina_regi_prog_proy_acti
            FROM almin.tal_transferencia TRANSF
            INNER JOIN almin.tal_motivo_salida_cuenta MOSACU
            ON MOSACU.id_motivo_salida_cuenta = TRANSF.id_motivo_salida_cuenta
            WHERE id_transferencia = al_id_transferencia;

            -- SE OBTIENE EL MOTIVO DE SALIDA POR PRÉSTAMO
            SELECT
            id_motivo_salida_cuenta
            INTO g_id_motivo_salida_cuenta
            FROM almin.tal_motivo_salida_cuenta MOSACU
            INNER JOIN almin.tal_motivo_salida MOTSAL
            ON MOTSAL.id_motivo_salida = MOSACU.id_motivo_salida
            WHERE MOTSAL.codigo = 'PRE'
            AND MOSACU.id_fina_regi_prog_proy_acti = g_id_fina_regi_prog_proy_acti
            ORDER BY MOSACU.id_motivo_salida_cuenta
            LIMIT 1;
		
			-- SE OBTIENE LA FIRMA AUTORIZADA CORRESPONDIENTE
            SELECT
            FIRAUT.id_firma_autorizada
            INTO g_id_firma_autorizada
            FROM almin.tal_firma_autorizada FIRAUT
            INNER JOIN almin.tal_almacen_logico ALMLOG
            ON ALMLOG.id_almacen_ep = FIRAUT.id_almacen_ep
            INNER JOIN almin.tal_motivo_salida MOTSAL
            ON MOTSAL.id_motivo_salida = FIRAUT.id_motivo_salida
            INNER JOIN almin.tal_motivo_salida_cuenta MSALCU
            ON MSALCU.id_motivo_salida = MOTSAL.id_motivo_salida
            WHERE ALMLOG.id_almacen_logico = g_registro.id_almacen_logico
            AND MSALCU.id_motivo_salida_cuenta = g_registro.id_motivo_salida_cuenta
            AND FIRAUT.estado_reg='activo'
            ORDER BY FIRAUT.prioridad ASC, FIRAUT.id_firma_autorizada ASC
            LIMIT 1;

            SELECT
            RESALM.id_responsable_almacen
            INTO g_id_usuario_firma
            FROM almin.tal_almacen_logico ALMLOG
            INNER JOIN almin.tal_almacen_ep ALMAEP
            ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
            INNER JOIN almin.tal_almacen ALMACE
            ON ALMACE.id_almacen = ALMAEP.id_almacen
            INNER JOIN almin.tal_responsable_almacen RESALM
            ON RESALM.id_almacen = ALMACE.id_almacen
            AND RESALM.estado = 'activo'
            INNER JOIN kard.tkp_empleado EMPLEA
            ON EMPLEA.id_empleado = RESALM.id_empleado
            INNER JOIN sss.tsg_persona PERSON
            ON PERSON.id_persona = EMPLEA.id_persona
            INNER JOIN sss.tsg_usuario USUARI
            ON USUARI.id_persona = PERSON.id_persona
            WHERE ALMLOG.id_almacen_logico = g_registro.id_almacen_logico;


			--OBTIENE EL ÚLTIMO VALOR DE LA SECUENCIA PARA INSERTAR LA SALIDA
			SELECT NEXTVAL('almin.tal_salida_id_salida_seq') INTO g_id_salida;
			
			--CREACIÓN DE LA SALIDA
			INSERT INTO almin.tal_salida(
            id_salida                      ,descripcion                ,contabilizar,
            estado_salida                  ,estado_registro            ,motivo_cancelacion      ,id_responsable_almacen,
            id_almacen_logico              ,id_empleado                ,id_firma_autorizada     ,id_contratista,
            id_tipo_material               ,id_institucion             ,id_subactividad         ,fecha_borrador,
            fecha_pendiente                ,fecha_aprobado_rechazado   ,fecha_entregado         ,fecha_provisional,
            fecha_consolidado              ,fecha_finalizado_cancelado ,correlativo_sal         ,id_motivo_salida_cuenta,
            id_usuario                     ,emergencia                 ,correlativo_vale        ,id_parametro_almacen
            ) VALUES (
            g_id_salida                    ,g_registro.motivo          ,g_contabilizar,
            'Aprobado'                     ,'activo'                   ,NULL                    ,g_id_usuario_firma,
            g_registro.id_almacen_logico_destino   ,g_registro.id_empleado     ,g_id_firma_autorizada   ,NULL,
            g_registro.id_tipo_material    ,NULL                       ,NULL                    ,now(),
            now()                          ,now()                      ,NULL                    ,NULL,
            NULL                           ,NULL                       ,0                       ,g_id_motivo_salida_cuenta,
            pm_id_usuario                  ,'No'                       ,0                       ,g_id_parametro_almacen
            );

            -- CREACIÓN DEL DETALLE
            INSERT INTO almin.tal_salida_detalle(
            costo             ,costo_unitario  ,precio_unitario  ,cant_solicitada,
            fecha_solicitada  ,id_item         ,id_salida        ,estado_item,
            cant_entregada)
            SELECT
            costo             ,costo_unitario  ,precio_unitario  ,cantidad,
            now()             ,id_item         ,g_id_salida      ,estado_item,
            cantidad
            FROM almin.tal_transferencia_det
            WHERE id_transferencia = al_id_transferencia;

            UPDATE almin.tal_transferencia SET
		    estado_transferencia       = 'Ingreso_prestamo',
		    id_salida_prestamo         = g_id_salida,
		    fecha_salida_prestamo      = now()
			WHERE id_transferencia = al_id_transferencia;
			
			
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Salida de material a transferir realizada';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
    ELSIF pm_codigo_procedimiento = 'AL_BAJPEN_APR' THEN  --BAJPEN: Baja Pendiente aprobación
    -- Aprobación de transferencias
        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia
                          WHERE id_transferencia=al_id_transferencia) THEN

                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de almin.tal_transferencia no existente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI ESTÁ EN ESTADO PENDIENTE
            IF NOT EXISTS(SELECT 1 FROM almin.tal_transferencia
                          WHERE id_transferencia=al_id_transferencia
                          AND estado_transferencia='Pendiente') THEN

                g_descripcion_log_error := 'Aprobación no realizada: la transferencia no está en estado Pendiente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

			--OBTIENE LOS DATOS DE LA TRANSFERENCIA
			SELECT
			*
			INTO g_registro
			FROM almin.tal_transferencia
			WHERE id_transferencia = al_id_transferencia;
			
			--VERIFICA SI SE CONTABILIZA O NO (SI ES PRÉSTAMO DE HECHO NO SE CONTABILIZA)
			IF g_registro.prestamo = 'si' THEN
			    g_contabilizar = 'no';
            ELSE
                SELECT
                TIPALM.contabilizar
                INTO g_contabilizar
                FROM almin.tal_almacen_logico ALMLOG
                INNER JOIN almin.tal_tipo_almacen TIPALM
                ON TIPALM.id_tipo_almacen = ALMLOG.id_tipo_almacen
                WHERE ALMLOG.id_almacen_logico = g_registro.id_almacen_logico;
			END IF;
			
			-- SE OBTIENE LA FIRMA AUTORIZADA CORRESPONDIENTE
            SELECT
            FIRAUT.id_firma_autorizada
            INTO g_id_firma_autorizada
            FROM almin.tal_firma_autorizada FIRAUT
            INNER JOIN almin.tal_almacen_logico ALMLOG
            ON ALMLOG.id_almacen_ep = FIRAUT.id_almacen_ep
            INNER JOIN almin.tal_motivo_salida MOTSAL
            ON MOTSAL.id_motivo_salida = FIRAUT.id_motivo_salida
            INNER JOIN almin.tal_motivo_salida_cuenta MSALCU
            ON MSALCU.id_motivo_salida = MOTSAL.id_motivo_salida
            WHERE ALMLOG.id_almacen_logico = g_registro.id_almacen_logico
            AND MSALCU.id_motivo_salida_cuenta = g_registro.id_motivo_salida_cuenta
            AND FIRAUT.estado_reg='activo'
            ORDER BY FIRAUT.prioridad ASC, FIRAUT.id_firma_autorizada ASC
            LIMIT 1;

            --obtencion del responsable de almacen

            SELECT id_almacen_logico INTO g_id_almacen_logico FROM almin.tal_transferencia
            WHERE id_transferencia=al_id_transferencia;
       
            SELECT
            RESALM.id_responsable_almacen
            INTO g_id_usuario_firma
            FROM almin.tal_almacen_logico ALMLOG
            INNER JOIN almin.tal_almacen_ep ALMAEP
            ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
            INNER JOIN almin.tal_almacen ALMACE
            ON ALMACE.id_almacen = ALMAEP.id_almacen
            INNER JOIN almin.tal_responsable_almacen RESALM
            ON RESALM.id_almacen = ALMACE.id_almacen
            AND RESALM.estado = 'activo'
            INNER JOIN kard.tkp_empleado EMPLEA
            ON EMPLEA.id_empleado = RESALM.id_empleado
            INNER JOIN sss.tsg_persona PERSON
            ON PERSON.id_persona = EMPLEA.id_persona
            INNER JOIN sss.tsg_usuario USUARI
            ON USUARI.id_persona = PERSON.id_persona
            WHERE ALMLOG.id_almacen_logico = g_id_almacen_logico
            AND USUARI.id_usuario = pm_id_usuario;

            raise notice 'almlog** %',g_id_almacen_logico;
            --obtencion del id_parametro_almacen
            SELECT id_parametro_almacen
            INTO g_id_parametro_almacen
            FROM almin.tal_parametro_almacen
            WHERE cierre = 'no';
                                 
			--OBTIENE EL ÚLTIMO VALOR DE LA SECUENCIA PARA INSERTAR LA SALIDA
			SELECT NEXTVAL('almin.tal_salida_id_salida_seq') INTO g_id_salida;
			
			--CREACIÓN DE LA SALIDA
			INSERT INTO almin.tal_salida(
            id_salida                      ,descripcion                ,contabilizar,
            estado_salida                  ,estado_registro            ,motivo_cancelacion      ,id_responsable_almacen,
            id_almacen_logico              ,id_empleado                ,id_firma_autorizada     ,id_contratista,
            id_tipo_material               ,id_institucion             ,id_subactividad         ,fecha_borrador,
            fecha_pendiente                ,fecha_aprobado_rechazado   ,fecha_entregado         ,fecha_provisional,
            fecha_consolidado              ,fecha_finalizado_cancelado ,correlativo_sal         ,id_motivo_salida_cuenta,
            id_usuario                     ,emergencia                 ,correlativo_vale        ,id_parametro_almacen
            ) VALUES (
            g_id_salida                    ,g_registro.motivo          ,g_contabilizar,
            'Aprobado'                     ,'activo'                   ,NULL                    ,NULL,
            g_registro.id_almacen_logico   ,g_registro.id_empleado     ,g_id_firma_autorizada   ,NULL,
            g_registro.id_tipo_material    ,NULL                       ,NULL                    ,now(),
            now()                          ,now()                      ,NULL                    ,NULL,
            NULL                           ,NULL                       ,0                       ,g_registro.id_motivo_salida_cuenta,
            pm_id_usuario                  ,'No'                       ,0                       ,g_id_parametro_almacen
            );

            -- CREACIÓN DEL DETALLE
            INSERT INTO almin.tal_salida_detalle(
            costo             ,costo_unitario  ,precio_unitario  ,cant_solicitada,
            fecha_solicitada  ,id_item         ,id_salida        ,estado_item,
            cant_entregada)                                       
            SELECT
            costo             ,costo_unitario  ,precio_unitario  ,cantidad,
            now()             ,id_item         ,g_id_salida      ,estado_item,
            cantidad
            FROM almin.tal_transferencia_det
            WHERE id_transferencia = al_id_transferencia;
                             
            --crear tarea para salida pendiente en salida por bajas
                             
                             
            --CREACION DEL INGRESO
                                  
               -- SE OBTIENE LA FIRMA AUTORIZADA CORRESPONDIENTE
            SELECT
            FIRAUT.id_firma_autorizada
            INTO g_id_firma_autorizada
            FROM almin.tal_firma_autorizada FIRAUT
            INNER JOIN almin.tal_almacen_logico ALMLOG
            ON ALMLOG.id_almacen_ep = FIRAUT.id_almacen_ep
            INNER JOIN almin.tal_motivo_ingreso MOTING
            ON MOTING.id_motivo_ingreso = FIRAUT.id_motivo_ingreso
            INNER JOIN almin.tal_motivo_ingreso_cuenta MINGCU
            ON MINGCU.id_motivo_ingreso = MOTING.id_motivo_ingreso
            WHERE ALMLOG.id_almacen_logico = g_registro.id_almacen_logico
            AND MINGCU.id_motivo_ingreso_cuenta = g_registro.id_motivo_ingreso_cuenta
            AND FIRAUT.estado_reg='activo'
            ORDER BY FIRAUT.prioridad ASC, FIRAUT.id_firma_autorizada ASC
            LIMIT 1;
                         
            SELECT id_almacen_logico_destino INTO g_id_almacen_logico_destino FROM almin.tal_transferencia
            WHERE id_transferencia=al_id_transferencia;  
            
            --OBTIENE EL ÚLTIMO VALOR DE LA SECUENCIA PARA INSERTAR EL INGRESO
			SELECT NEXTVAL('almin.tal_ingreso_id_ingreso_seq') INTO g_id_ingreso;
            
            --CREACIÓN DE LA INGRESO
			INSERT INTO almin.tal_ingreso(   
            id_ingreso 					,correlativo_ord_ing			,correlativo_ing		,descripcion
            ,costo_total				,contabilizar	 		  		,contabilizado  		,estado_ingreso
            ,estado_registro			,cod_inf_tec		   			,resumen_inf_tec		,fecha_borrador
            ,fecha_pendiente			,fecha_aprobado_rechazado		,fecha_ing_fisico		,fecha_ing_valorado
            ,fecha_finalizado_cancelado	,fecha_reg						,id_responsable_almacen	,id_proveedor
            ,id_contratista				,id_empleado					,id_almacen_logico		,id_firma_autorizada
            ,id_institucion				,id_motivo_ingreso_cuenta		,orden_compra			,observaciones
            ,id_usuario					                        ,id_parametro_almacen
            
            ) VALUES (
            g_id_ingreso				,0								,0						,'Baja'
            ,NULL						,'no'						   	,'no'		  			,'Pendiente'
            ,'activo'					,NULL		   					,NULL					,now()
            ,NULL						,NULL							,NULL					,NULL
            ,NULL						,now()							,NULL					,NULL
            ,NULL						,g_registro.id_empleado			,g_id_almacen_logico	,g_id_firma_autorizada
            ,NULL						,NULL							,NULL					,NULL
            ,pm_id_usuario			                          ,g_id_parametro_almacen
            );       
            
            --CREACION DEL INGRESO DETALLE   
            INSERT INTO almin.tal_ingreso_detalle (
            								cantidad					,costo					,precio_venta
            ,costo_unitario					,precio_venta_unitario		,fecha_reg				,id_ingreso
            ,id_item						,estado_item
            ) 
            SELECT  
            								cantidad					,costo					,NUll
            ,costo_unitario		            ,precio_unitario			,now()					,g_id_ingreso	
            ,id_item			            ,estado_item
            FROM almin.tal_transferencia_det
            WHERE id_transferencia = al_id_transferencia;
            
            
            
            
            -- HACER UPDATE TRANSFERENCIA PARA RELACIONAR EL ID SALIDA
            UPDATE almin.tal_transferencia SET
		    estado_transferencia       = 'Pendiente_salida',
		    fecha_pendiente_sal        = now(),
		    id_salida                  = g_id_salida,
            id_ingreso				   = g_id_ingreso
			WHERE id_transferencia = al_id_transferencia;
			
			-- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Baja aprobada';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
    /*
    Autor:   		RAC
    Fecha:	 		09/01/2017
    Descripcion:	- paara prestamso pendiente genera una devolucion invirtiendo los almacenes origen y destino
    
    */
    ELSEIF pm_codigo_procedimiento = 'AL_VOLCARTRAN_INS' THEN  --TRABOR: Transferencia Borrador

        BEGIN
           
           --recupera datos de la transferencias original
           select 
              tr.id_transferencia_dev, 
              tr.tipo_transferencia,
              tr.importe_abierto,
              tr.estado_transferencia,
              tr.observaciones,
              tr.id_empleado,
              tr.id_almacen_logico,
              tr.id_almacen_logico_destino,
              tr.id_motivo_ingreso_cuenta,
              tr.id_motivo_salida_cuenta,
              id_firma_autorizada_transf,
              tr.descripcion,
              tr.id_tipo_material
           into
             v_registros
           from almin.tal_transferencia tr 
           where tr.id_transferencia = al_id_transferencia;
           
           IF v_registros.tipo_transferencia !='prestamo' THEN
              raise exception 'solo puede hacer devoluciones en transferencias del tipo prestamo';
           END IF;
           
           --validaciones
           IF v_registros.estado_transferencia != 'Finalizado' THEN
              raise exception 'Solo puede devolver  transferencias finalizadas';
           END IF;
           
           IF v_registros.id_transferencia_dev is not null THEN
              raise exception 'esta transferencia ya tiene una devolucion : ID %', v_registros.id_transferencia_dev ;
           END IF;
           
           SELECT NEXTVAL('almin.tal_transferencia_id_transferencia_seq') INTO v_id_transferencia_dev;
     
           
           INSERT INTO almin.tal_transferencia(
              prestamo                    ,estado_transferencia          ,motivo                  ,descripcion,
              observaciones               ,fecha_pendiente_sal           ,fecha_pendiente_ing     ,fecha_finalizado_anulado,
              id_empleado                 ,id_firma_autorizada_transf    ,id_almacen_logico       ,id_almacen_logico_destino,
              id_motivo_ingreso_cuenta    ,fecha_borrador                ,fecha_pendiente         ,fecha_rechazado,
              id_ingreso                  ,id_salida                     ,id_tipo_material        ,id_motivo_salida_cuenta,
              tipo_transferencia			,importe_abierto			 ,id_transferencia
		    ) VALUES (
              'no'                				 ,'Borrador'                    			  ,'devolucion del prestamo id:'||al_id_transferencia::varchar               ,v_registros.descripcion,
              v_registros.observaciones            ,NULL                          			  ,NULL                    													,NULL,
              v_registros.id_empleado              ,v_registros.id_firma_autorizada_transf  	  ,v_registros.id_almacen_logico_destino    								,v_registros.id_almacen_logico,
              v_registros.id_motivo_ingreso_cuenta ,now()                        				 ,NULL                   										 			,NULL,
              NULL                        		 ,NULL                         				 ,v_registros.id_tipo_material     											,v_registros.id_motivo_salida_cuenta,
              'devolucion'						 ,v_registros.importe_abierto				,v_id_transferencia_dev
            );
            
            --insertar el detalle de transferencia
            
            FOR v_registros_det in (
                                      select 
                                        td.id_item,
                                        td.id_transferencia_det,
                                        td.cantidad,
                                        td.costo,
                                        td.costo_unitario,
                                        td.estado_item,
                                        td.precio_unitario
                                      from almin.tal_transferencia_det td 
                                      where td.id_transferencia = al_id_transferencia) LOOP
                               
                               
                               INSERT INTO 
                                            almin.tal_transferencia_det
                                          (
                                          
                                            cantidad,
                                            estado_item,
                                            costo,
                                            costo_unitario,
                                            precio_unitario,
                                            fecha_reg,
                                            id_item,
                                            id_transferencia
                                          )
                                          VALUES (
                                           
                                            v_registros_det.cantidad,
                                            v_registros_det.estado_item,
                                            v_registros_det.costo,
                                            v_registros_det.costo_unitario,
                                            v_registros_det.precio_unitario,
                                            now(),
                                            v_registros_det.id_item,
                                            v_id_transferencia_dev
                                          );       
                                      
            END LOOP;
            
            --actulizar transferencia original
            update almin.tal_transferencia set
              id_transferencia_dev = v_id_transferencia_dev
            where id_transferencia = al_id_transferencia;
            
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso de la transferencia';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
   /*
    Autor:   		RAC
    Fecha:	 		09/01/2017
    Descripcion:	convierte una transferencai de prestamos en definitiva
    
    */
    ELSEIF pm_codigo_procedimiento = 'AL_VOLCARTRAN_INS' THEN  --TRABOR: Transferencia Borrador

        BEGIN
           
           --recupera datos de la transferencias original
           select 
              tr.id_transferencia_dev, 
              tr.tipo_transferencia,
              tr.importe_abierto,
              tr.estado_transferencia,
              tr.observaciones,
              tr.id_empleado,
              tr.id_almacen_logico,
              tr.id_almacen_logico_destino,
              tr.id_motivo_ingreso_cuenta,
              tr.id_motivo_salida_cuenta,
              id_firma_autorizada_transf
           into
             v_registros
           from almin.tal_transferencia tr 
           where tr.id_transferencia = al_id_transferencia;
           
            IF v_registros.tipo_transferencia !='prestamo' THEN
              raise exception 'no es un prestamos';
           END IF;
           
           --validaciones
           IF v_registros.estado_transferencia != 'Finalizado' THEN
              raise exception 'Solo puede transformar  transferencias finalizadas';
           END IF;
           
           IF v_registros.id_transferencia_dev is not null THEN
              raise exception 'esta transferencia ya tiene una devolucion : ID %', v_registros.id_transferencia_dev ;
           END IF;
           
           
            
            --actulizar transferencia original
            update almin.tal_transferencia set
              tipo_transferencia = 'definitiva'
            where id_transferencia = al_id_transferencia;
            
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso de la transferencia';
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