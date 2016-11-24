--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_tal_ingreso_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_ingreso integer,
  al_correlativo_ord_ing integer,
  al_correlativo_ing integer,
  al_descripcion varchar,
  al_costo_total numeric,
  al_contabilizar varchar,
  al_contabilizado varchar,
  al_estado_ingreso varchar,
  al_estado_registro varchar,
  al_cod_inf_tec varchar,
  al_resumen_inf_tec varchar,
  al_fecha_borrador date,
  al_fecha_pendiente date,
  al_fecha_aprobado_rechazado date,
  al_fecha_ing_fisico date,
  al_fecha_ing_valorado date,
  al_fecha_finalizado_cancelado date,
  al_fecha_reg date,
  al_id_responsable_almacen integer,
  al_id_proveedor integer,
  al_id_contratista integer,
  al_id_empleado integer,
  al_id_almacen_logico integer,
  al_id_firma_autorizada integer,
  al_id_institucion integer,
  al_id_motivo_ingreso_cuenta integer,
  al_orden_compra varchar,
  al_observaciones varchar,
  al_num_factura varchar,
  al_fecha_factura date,
  al_responsable varchar,
  al_importacion numeric,
  al_flete numeric,
  al_seguro numeric,
  al_gastos_alm numeric,
  al_gastos_aduana numeric,
  al_iva numeric,
  al_rep_form numeric,
  al_peso_neto numeric,
  al_id_moneda_import integer,
  al_id_moneda_nacionaliz integer,
  al_dui varchar,
  al_monto_tot_factura numeric,
  al_id_cotizacion integer,
  al_tipo_costeo varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ALMACENES (ALMIN)
***************************************************************************
 SCRIPT: 		almin.f_tal_ingreso_iud
 DESCRIPCIÓN: 	Permite registrar en la tabla almin.tal_ingreso
 AUTOR:         (generado automaticamente)
 FECHA:            2007-10-18 20:48:41
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
    g_reg_error                      varchar;
    g_respuesta                   varchar;     -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCIÓN
    g_nivel_error                 varchar;     -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                               --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                               --      ERROR LÓGICO (CRÍTICO) = 2
                                               --      ERROR LÓGICO (INTERMEDIO) = 3
                                               --      ERROR LÓGICO (ADVERTENCIA) = 4

    g_nombre_funcion              varchar;     -- NOMBRE FÍSICO DE LA FUNCIÓN
    g_separador                   varchar(10); -- SEPARADOR DE CADENAS
    g_correlativo_ord_ing         integer;     -- VARIABLE PARA OBTENER EL CORRELATIVO DE ORDEN DE INGRESO
    g_correlativo_ing             integer;     -- VARIABLE PARA OBTENER EL CORRELATIVO DE INGRESO
    g_resp_act_correl             varchar;
    g_id_almacen_logico           integer;
    g_cursor_ing_det              CURSOR (ID integer) FOR SELECT
                                                            *
                                                            FROM almin.tal_ingreso_detalle
                                                            WHERE id_ingreso = ID;
    g_registros                   almin.tal_ingreso_detalle%ROWTYPE; --Variable para recorrer el cursor
    g_cant_tot                    numeric;
    g_cant                        numeric;
    g_nuevo_costo_unit            numeric;
    g_nuevo_costo_tot             numeric;
    g_costo_unit                  numeric;
    g_id_kardex_logico            integer;
    g_id_firma_autorizada         integer;
    g_contabilizar                varchar;
    g_estado_item                  varchar;
    g_nro_ing_no_finalizados      bigint;
    g_id_almacen                  integer;
    g_id_transferencia            integer;
    g_id_usuario_firma            integer;
    g_id_usuario_almacen          integer;
    g_id_tarea_pendiente          integer;
    g_bandera                     integer;
    g_id_responsable_almacen      integer;
    g_id_parametro_almacen        integer;
    g_sw                          integer;
    g_id_usuario                  integer;
    g_rol_adm                     boolean;
    g_id_jefe_almacen                integer;
    g_correl                      varchar;
    g_act                          varchar;
    g_id_ingreso                  integer;
    --VALORACION
    g_id_moneda_principal          integer;
    g_tot_import                  numeric;
    g_tot_nacionaliz              numeric;
    g_id_moneda_import              integer;
    g_id_moneda_nacionaliz          integer;
    g_tot_import_conv              numeric;
    g_fecha_factura                  date;
    g_tot_valoracion              numeric;
    g_peso_neto                      numeric;
    g_FD                          numeric;
    g_precio_item                 numeric;
    g_tot_factura                  numeric;
    g_tot_cantidad                  numeric;
    g_codigo_motivo_ingreso          varchar;
    g_cursor                      CURSOR(ID integer) FOR
                                  SELECT
                                     INGDET.id_ingreso_detalle,INGDET.id_item, INGDET.cantidad, ITEM.peso_kg, ITEM.costo_estimado,ITEM.codigo
                                  FROM almin.tal_ingreso_detalle INGDET
                                  INNER JOIN almin.tal_item ITEM
                                  ON ITEM.id_item = INGDET.id_item
                                  WHERE INGDET.id_ingreso = ID;
    g_registro                    record;
    g_costo_total_item            numeric;
    
    g_desc_almacen                varchar;
    g_ep                          text;
    g_gestion					  varchar;
    v_desc_item					  varchar;
    g_id_parametro_almacen_logico	integer;
    v_finalizacion_tmp				date;
    g_costeo_obligatorio			varchar;
    v_registros_ingreso				record;
    g_costo_estimado_neto			numeric;
    g_aux_cotos_det					numeric;

BEGIN

    ---*** INICIACIÓN DE VARIABLES
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion := 'almin.f_tal_ingreso_iud';
    g_privilegio_procedimiento := FALSE;
    g_respuesta := FALSE;
    g_rol_adm := false;



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

    --VERIFICA SI EL ROL DEL USUARIO ES DE ADMINISTRADOR
    IF EXISTS (SELECT 1
               FROM sss.tsg_usuario_rol USUROL
               WHERE id_usuario = pm_id_usuario
               AND id_rol = 1) THEN
        g_rol_adm = true;
    END IF;
    
    --SE OBTIENEN DATOS DEL ALMACÉN Y DE LA EP PARA DESPLEGAR EN ERRORES
    SELECT
    ALMACE.nombre
    INTO g_desc_almacen
    FROM almin.tal_almacen_logico ALMLOG
    INNER JOIN almin.tal_almacen_ep ALMAEP
    ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
    INNER JOIN almin.tal_almacen ALMACE
    ON ALMACE.id_almacen = ALMAEP.id_almacen
    WHERE ALMLOG.id_almacen_logico = al_id_almacen_logico;
    
    SELECT 
    ESTPRO.nombre_financiador ||' - '|| ESTPRO.nombre_regional ||' - '|| ESTPRO.nombre_programa ||' - '|| ESTPRO.nombre_proyecto ||' - '|| ESTPRO.nombre_actividad
    INTO g_ep
    FROM almin.tal_almacen_logico ALMLOG
    INNER JOIN almin.tal_almacen_ep ALMAEP
    ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
    INNER JOIN param.vpm_estructura_programatica ESTPRO
    ON ESTPRO.id_fina_regi_prog_proy_acti = ALMAEP.id_fina_regi_prog_proy_acti
    WHERE ALMLOG.id_almacen_logico = al_id_almacen_logico;



    --*** EJECUCIÓN DEL PROCEDIMIENTO ESPECÍFICO
    IF pm_codigo_procedimiento = 'AL_OINSOL_INS' THEN
        --Para insertar una solicitud de orden de ingreso
        BEGIN
        
        	--raise exception 'id_almacen_logico: %',al_id_almacen_logico;

            --VERIFICA SI EL ALMACÉN ESTÁ BLOQUEADO O CERRADO
            IF almin.f_al_verificar_almacen_cerrado('logico',al_id_almacen_logico) THEN
                g_nivel_error := '3';
                g_descripcion_log_error := 'Orden de ingreso no almacenado: El Almacén se encuentra Bloqueado o Cerrado.';
                SELECT s_mensaje,s_resp_evento
                INTO g_respuesta,g_reg_evento
                FROM almin.f_manejo_errores(pm_id_usuario,g_id_subsistema,g_id_lugar,g_descripcion_log_error,pm_ip_origen,pm_mac_maquina,'error',NULL,pm_codigo_procedimiento,pm_proc_almacenado,g_nombre_funcion,g_nivel_error);
                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
            END IF;
            
            

            --VERIFICA SI EXISTE FIRMA AUTORIZADA
            g_id_firma_autorizada = almin.f_al_obtener_firma_autorizada(al_id_almacen_logico,al_id_motivo_ingreso_cuenta,'ingreso');

            IF (g_id_firma_autorizada = -1 or g_id_firma_autorizada is null) THEN
                g_nivel_error := '3';
                g_descripcion_log_error := '\nOrden de ingreso no almacenada: Firma autorizada no registrada \n para el Almacén:' ||g_desc_almacen ||' y \nEst. Prog.: '||g_ep;
                SELECT s_mensaje,s_resp_evento
                INTO g_respuesta,g_reg_evento
                FROM almin.f_manejo_errores(pm_id_usuario,g_id_subsistema,g_id_lugar,g_descripcion_log_error,pm_ip_origen,pm_mac_maquina,'error',NULL,pm_codigo_procedimiento,pm_proc_almacenado,g_nombre_funcion,g_nivel_error);
                --DEVUELVE MENSAJE DE ERROR
                raise notice '__id_almacen_logico%',al_id_almacen_logico;
                raise notice '__id_motivo_ingreso_cuenta%',al_id_motivo_ingreso_cuenta;
                
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
            END IF;

            -- VERIFICA SI DEBE CONTABILIZARSE
            g_contabilizar=almin.f_al_contabilizar_alm(al_id_almacen_logico);


            -- OBTIENE LA GESTIÓN VIGENTE
            g_id_parametro_almacen = almin.f_al_obtener_gestion_vigente();



            IF g_id_parametro_almacen = -1 THEN
                g_nivel_error := '3';
                g_descripcion_log_error := 'Orden de ingreso no almacenado: No existe una Gestión vigente';
                SELECT s_mensaje,s_resp_evento
                INTO g_respuesta,g_reg_evento
                FROM almin.f_manejo_errores(pm_id_usuario,g_id_subsistema,g_id_lugar,g_descripcion_log_error,pm_ip_origen,pm_mac_maquina,'error',NULL,pm_codigo_procedimiento,pm_proc_almacenado,g_nombre_funcion,g_nivel_error);
                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
            END IF;



            -- OBTIENE EL ALMACENERO Y EL JEFE DE ALMACÉN
            SELECT
            s_id_almacenero,s_id_jefe_almacen
            INTO g_id_responsable_almacen,g_id_jefe_almacen
            FROM almin.f_al_responsables_alm(al_id_almacen_logico);

            -- OBTIENE EL SIGUIENTE ID DE LA SECUENCIA DE INGRESOS
            SELECT NEXTVAL('almin.tal_ingreso_id_ingreso_seq') INTO g_id_ingreso;

            -- INSERTA LA ORDEN DE INGRESO
            INSERT INTO almin.tal_ingreso(
            id_ingreso               ,descripcion,
            costo_total              ,contabilizar           ,estado_ingreso              ,estado_registro,
            fecha_borrador           ,id_responsable_almacen,
            id_proveedor             ,id_contratista         ,id_empleado                 ,id_almacen_logico,    
            id_firma_autorizada      ,id_institucion         ,id_motivo_ingreso_cuenta    ,fecha_pendiente,
            fecha_aprobado_rechazado ,fecha_ing_fisico       ,fecha_ing_valorado          ,fecha_finalizado_cancelado,
            orden_compra             ,observaciones          ,id_usuario                  ,id_parametro_almacen,
            id_cotizacion
            ) VALUES (
            g_id_ingreso             ,al_descripcion,
            al_costo_total           ,g_contabilizar         ,'Borrador'                  ,'activo',
            now()                    ,g_id_responsable_almacen,
            al_id_proveedor          ,al_id_contratista      ,al_id_empleado              ,al_id_almacen_logico,
            g_id_firma_autorizada    ,al_id_institucion      ,al_id_motivo_ingreso_cuenta ,NULL,
            NULL                     ,NULL                   ,NULL                        ,NULL,
            al_orden_compra          ,al_observaciones       ,pm_id_usuario               ,g_id_parametro_almacen,
            al_id_cotizacion
            );

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso de la Solicitud de Orden de Ingreso';
            g_respuesta := 't'||g_separador||g_descripcion_log_error||g_separador||g_id_ingreso;

        END;
    /*
      Autor:    RAC
      fecha:    07/12/2016
      Desc:	    - recalcular  la gestion al editar ingresos
                - agrega al_tipo_costeo en la edicion 
    
    */
    ELSIF pm_codigo_procedimiento = 'AL_OINSOL_UPD' THEN
        -- Para modificar la solicitud de orden de ingreso que aún esté en borrador
        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso
                          WHERE almin.tal_ingreso.id_ingreso=al_id_ingreso) THEN

                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de almin.tal_ingreso no existente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI EL ESTADO DE LA ORDEN DE INGRESO ES BORRADOR
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso
                          WHERE almin.tal_ingreso.id_ingreso=al_id_ingreso
                          AND estado_ingreso='Borrador') THEN

                g_descripcion_log_error := 'Modificación no realizada: La orden de ingreso no está en estado Borrador';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --SE VERIFICA SI EL ALMACÉN ESTÁ BLOQUEADO O CERRADO
            IF almin.f_al_verificar_almacen_cerrado('logico',al_id_almacen_logico) THEN

                g_nivel_error := '3';
                g_descripcion_log_error := 'Orden de ingreso no almacenada: El Almacén se encuentra Bloqueado o Cerrado.';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;

            END IF;

            -- SE OBTIENE LA FIRMA AUTORIZADA CORRESPONDIENTE
            SELECT
            FIRAUT.id_firma_autorizada
            INTO g_id_firma_autorizada
            FROM almin.tal_firma_autorizada FIRAUT
            INNER JOIN almin.tal_almacen_logico ALMLOG
            ON ALMLOG.id_almacen_ep = FIRAUT.id_almacen_ep
            INNER JOIN almin.tal_motivo_ingreso MOTING
            ON MOTING.id_motivo_ingreso = FIRAUT.id_motivo_ingreso
            INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            ON MOINCU.id_motivo_ingreso = MOTING.id_motivo_ingreso
            WHERE ALMLOG.id_almacen_logico = al_id_almacen_logico
            AND MOINCU.id_motivo_ingreso_cuenta = al_id_motivo_ingreso_cuenta
            AND FIRAUT.estado_reg = 'activo'
            ORDER BY FIRAUT.prioridad ASC, FIRAUT.id_firma_autorizada ASC
            LIMIT 1;

            --VERIFICA SI EXISTE FIRMA AUTORIZADA
            IF g_id_firma_autorizada IS NULL THEN

                g_nivel_error := '3';
                g_descripcion_log_error := 'Orden de ingreso no modificada: Firma autorizada no registrada para la Actividad definida';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
            END IF;

            -- VERIFICA SI DEBE CONTABILIZARSE
            SELECT
            TIPALM.contabilizar
            INTO g_contabilizar
            FROM almin.tal_almacen_logico ALMLOG
            INNER JOIN almin.tal_tipo_almacen TIPALM
            ON TIPALM.id_tipo_almacen = ALMLOG.id_tipo_almacen
            WHERE ALMLOG.id_almacen_logico = al_id_almacen_logico;

            --Obtiene la moneda principal (cambiar)
            g_id_moneda_nacionaliz=1;
            
             -- OBTIENE LA GESTIÓN VIGENTE RAC
            SELECT 
               l.id_parametro_almacen,
               l.id_parametro_almacen_logico
            INTO 
               g_id_parametro_almacen,
               g_id_parametro_almacen_logico
            FROM almin.tal_parametro_almacen_logico l
            WHERE     estado  = 'abierto'
                  and  l.id_almacen_logico = al_id_almacen_logico;
                  
             IF g_id_parametro_almacen_logico is null THEN
                raise exception 'no se encontro gestión para el almacen lógico';
             END IF;     

            UPDATE almin.tal_ingreso SET
              descripcion                 = al_descripcion,
              costo_total                 = al_costo_total,
              id_proveedor                = al_id_proveedor,
              id_contratista              = al_id_contratista,
              id_empleado                 = al_id_empleado,
              id_almacen_logico           = al_id_almacen_logico,
              id_firma_autorizada         = g_id_firma_autorizada,
              id_institucion              = al_id_institucion,
              id_motivo_ingreso_cuenta    = al_id_motivo_ingreso_cuenta,
              contabilizar                = g_contabilizar,
              orden_compra                = al_orden_compra,
              observaciones               = al_observaciones,
              num_factura                    = al_num_factura,
              fecha_factura                = al_fecha_factura,
              responsable                    = al_responsable,
              fecha_finalizado_cancelado  = al_fecha_finalizado_cancelado,
              importacion                    = al_importacion,
              flete                        = al_flete,
              seguro                        = al_seguro,
              gastos_alm                    = al_gastos_alm,
              gastos_aduana                = al_gastos_aduana,
              iva                            = al_iva,
              rep_form                    = al_rep_form,
              peso_neto                    = al_peso_neto,
              dui                            = al_dui,
              monto_tot_factura            = al_monto_tot_factura,
              id_moneda_import            = al_id_moneda_import,
              id_moneda_nacionaliz        = g_id_moneda_nacionaliz,
              id_parametro_almacen =  g_id_parametro_almacen,
              id_parametro_almacen_logico = g_id_parametro_almacen_logico,
              tipo_costeo	=	COALESCE(al_tipo_costeo,'peso')
            WHERE id_ingreso = al_id_ingreso;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificación exitosa en almin.tal_ingreso';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

    ELSIF pm_codigo_procedimiento = 'AL_OINSOL_FIN' THEN
        -- Para terminar la solicitud y dejar Pendiente de aprobación
        BEGIN

            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso
                          WHERE id_ingreso=al_id_ingreso) THEN

                g_descripcion_log_error := 'Finalización Orden de Ingreso no realizada: no existe el registro la Solicitud de Orden de Ingreso';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI EL ESTADO DE LA ORDEN DE INGRESO ES BORRADOR
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso
                          WHERE id_ingreso=al_id_ingreso
                          AND estado_ingreso='Borrador') THEN

                g_descripcion_log_error := 'Finalización Orden de Ingreso no realizada: La Orden de Ingreso no está en estado Borrador';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI TIENE EL DETALLE DE ITEMS LLENADO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso_detalle
                      WHERE id_ingreso = al_id_ingreso) THEN

                g_descripcion_log_error := 'Finalización no realizada: La orden de ingreso no tiene ningún material registrado';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --SE VERIFICA SI EL ALMACÉN ESTÁ BLOQUEADO O CERRADO
            SELECT
            id_almacen_logico
            INTO
            g_id_almacen_logico
            FROM almin.tal_ingreso
            WHERE id_ingreso = al_id_ingreso;

            IF almin.f_al_verificar_almacen_cerrado('logico',g_id_almacen_logico) THEN

                g_nivel_error := '3';
                g_descripcion_log_error := 'Finalización no realizada: El Almacén se encuentra Bloqueado o Cerrado.';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;

            END IF;

            --******tareas pendientes*****--
            UPDATE almin.tal_ingreso SET
            estado_ingreso = 'Pendiente',
            fecha_pendiente = now()
            WHERE id_ingreso= al_id_ingreso;

            SELECT USUARI.id_usuario INTO g_id_usuario_firma
            FROM sss.tsg_usuario USUARI
            INNER JOIN kard.tkp_empleado EMPLEA ON USUARI.id_persona=EMPLEA.id_persona
            INNER JOIN kard.tkp_empleado_tpm_frppa EFRPPA ON EMPLEA.id_empleado = EFRPPA.id_empleado
            INNER JOIN almin.tal_firma_autorizada FIRAUT ON FIRAUT.id_empleado_frppa =EFRPPA.id_empleado_frppa
            INNER JOIN almin.tal_ingreso INGRES ON INGRES.id_firma_autorizada = FIRAUT.id_firma_autorizada
            WHERE INGRES.id_ingreso= al_id_ingreso;

            -- SI NO ENCUENTRA EL USUARIO UTILIZA EL PARÁMETRO DE USUARIO
            IF g_id_usuario_firma IS NULL THEN
                g_id_usuario_firma = pm_id_usuario;
            END IF;

            IF (g_id_usuario_firma>0 OR g_rol_adm) THEN

                  SELECT NEXTVAL('sss.tsg_tarea_pendiente_id_tarea_pendiente_seq') INTO g_id_tarea_pendiente;
                  --codigo_procedimiento de metaproceso
               INSERT INTO sss.tsg_tarea_pendiente (id_tarea_pendiente,id_usuario_asignado, id_subsistema, tarea, descripcion, codigo_procedimiento, estado,fecha_reg)
               VALUES(g_id_tarea_pendiente,g_id_usuario_firma, g_id_subsistema, 'Aprobar Ingreso','Aprobar Ingreso','AL_APORIN','Pendiente',now());
            
               INSERT INTO sss.tsg_tarea_pendiente_asignador(nombre_tabla, id_registro, estado, id_tarea_pendiente)
               VALUES ('almin.tal_ingreso', al_id_ingreso, 'Pendiente', g_id_tarea_pendiente);
          ELSE
            
               g_descripcion_log_error := 'Finalización no realizada: El usuario no tiene permisos para completar esta operación';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
           END IF;
            
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Finalización Orden de Ingreso realizada satisfactoriamente';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

    ELSIF pm_codigo_procedimiento = 'AL_OINAPR_APR' THEN
        -- Para Aprobar Solicitud Orden de Ingreso
        BEGIN

            g_bandera:=0;
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso
                          WHERE almin.tal_ingreso.id_ingreso=al_id_ingreso) THEN

                g_descripcion_log_error := 'Aprobación no realizada: no existe el registro la Solicitud de Orden de Ingreso';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI EL ESTADO DE LA ORDEN DE INGRESO ES PENDIENTE
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso
                          WHERE almin.tal_ingreso.id_ingreso=al_id_ingreso
                          AND estado_ingreso='Pendiente') THEN

                g_descripcion_log_error := 'Aprobación no realizada: La Orden de Ingreso no está en estado Borrador';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --SE VERIFICA SI EL ALMACÉN ESTÁ BLOQUEADO O CERRADO
            SELECT
            id_almacen_logico
            INTO
            g_id_almacen_logico
            FROM almin.tal_ingreso
            WHERE id_ingreso = al_id_ingreso;

            IF almin.f_al_verificar_almacen_cerrado('logico',g_id_almacen_logico) THEN

                g_nivel_error := '3';
                g_descripcion_log_error := 'Orden de ingreso no aprobada: El Almacén se encuentra Bloqueado o Cerrado.';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;

            END IF;

           --ACTUALIZAR TAREA PENDIENTE(CONCLUIDA)

            SELECT USUARI.id_usuario
            INTO g_id_usuario_firma
            FROM sss.tsg_usuario USUARI
            INNER JOIN kard.tkp_empleado EMPLEA
            ON USUARI.id_persona=EMPLEA.id_persona
            INNER JOIN kard.tkp_empleado_tpm_frppa EFRPPA
            ON EMPLEA.id_empleado = EFRPPA.id_empleado
            INNER JOIN almin.tal_firma_autorizada FIRAUT
            ON FIRAUT.id_empleado_frppa =EFRPPA.id_empleado_frppa
            INNER JOIN almin.tal_ingreso INGRES
            ON INGRES.id_firma_autorizada = FIRAUT.id_firma_autorizada
            WHERE INGRES.id_ingreso= al_id_ingreso;

            --bandera=1 si el usuario es administrador del Sistema, donde rol=1
            SELECT 1 INTO g_bandera
            FROM sss.tsg_usuario USUARI
            INNER JOIN sss.tsg_usuario_rol USUROL
            ON USUARI.id_usuario=USUROL.id_usuario
            WHERE USUARI.id_usuario=pm_id_usuario
            AND USUROL.id_rol=1;

            IF(g_id_usuario_firma>0 OR g_bandera=1) THEN
                SELECT TARPEN.id_tarea_pendiente INTO g_id_tarea_pendiente
                FROM sss.tsg_tarea_pendiente TARPEN
                INNER JOIN sss.tsg_tarea_pendiente_asignador TAPEAS ON TARPEN.id_tarea_pendiente= TAPEAS.id_tarea_pendiente
                WHERE TARPEN.id_subsistema = g_id_subsistema AND
                TAPEAS.id_registro=al_id_ingreso AND TAPEAS.nombre_tabla = 'almin.tal_ingreso' AND TARPEN.estado= TAPEAS.estado AND TARPEN.estado='Pendiente'
                AND ((g_id_usuario_firma=pm_id_usuario) OR (g_bandera=1));

                IF(g_id_tarea_pendiente>0) THEN
                    SELECT TAPEAS.id_tarea_pendiente INTO g_id_tarea_pendiente
                    FROM sss.tsg_tarea_pendiente_asignador TAPEAS
                    INNER JOIN sss.tsg_tarea_pendiente TARPEN
                    ON TARPEN.id_tarea_pendiente= TAPEAS.id_tarea_pendiente
                    AND TAPEAS.id_registro=al_id_ingreso
                    AND TAPEAS.estado LIKE 'Pendiente'
                    AND TAPEAS.nombre_tabla LIKE 'almin.tal_ingreso'
                    AND TARPEN.id_usuario_asignado=g_id_usuario_firma
                    AND TARPEN.id_subsistema=g_id_subsistema
                    AND TARPEN.estado = 'Pendiente';

                    UPDATE sss.tsg_tarea_pendiente
                    SET estado='Concluida',
                    fecha_concluido_anulado=now()
                    WHERE id_tarea_pendiente=g_id_tarea_pendiente;

                    UPDATE sss.tsg_tarea_pendiente_asignador SET
                    estado='Concluida'
                    WHERE id_registro=al_id_ingreso
                    AND id_tarea_pendiente= g_id_tarea_pendiente
                    AND nombre_tabla = 'almin.tal_ingreso';

                  END IF;
            ELSE
                g_descripcion_log_error := 'Finalización no realizada: Usuario no autorizado para aprobación';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;

            --OBTIENE EL CORRELATIVO DEL INGRESO
            g_correlativo_ord_ing := almin.f_al_obtener_correlativo('ORDING',to_char(COALESCE(al_fecha_reg,now()),'mm'),g_id_almacen_logico);
            

            IF g_correlativo_ord_ing < 0 THEN

                g_nivel_error := '3';
                g_descripcion_log_error := 'Error al obtener correlativo de la orden de ingreso';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
            END IF;

            --APUEBA LA ORDEN DE INGRESO
            UPDATE almin.tal_ingreso SET
            estado_ingreso           = 'Aprobado',
            correlativo_ord_ing      = g_correlativo_ord_ing,
            observaciones            = al_observaciones,
            fecha_aprobado_rechazado = now()
            WHERE almin.tal_ingreso.id_ingreso= al_id_ingreso;
            
            --ACTUALIZAR EL CORRELATIVO
            g_resp_act_correl := almin.f_al_actualizar_correlativo('ORDING',to_char(COALESCE(al_fecha_reg,now()),'mm'),g_id_almacen_logico);

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Aprobación realizada satisfactoriamente';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

    ELSIF pm_codigo_procedimiento = 'AL_OINAPR_REC' THEN
        -- Para Rechazar Solicitud Orden de Ingreso
        BEGIN
        g_bandera:=0;
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso
                          WHERE almin.tal_ingreso.id_ingreso=al_id_ingreso) THEN

                g_descripcion_log_error := 'Rechazo no realizado: no existe el registro la Solicitud de Orden de Ingreso';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI EL ESTADO DE LA ORDEN DE INGRESO ES PENDIENTE
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso
                          WHERE almin.tal_ingreso.id_ingreso=al_id_ingreso
                          AND estado_ingreso='Pendiente') THEN

                g_descripcion_log_error := 'Rechazo no realizado: La Orden de Ingreso no está en estado lista para Aprobación';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --SE VERIFICA SI EL ALMACÉN ESTÁ BLOQUEADO O CERRADO
            SELECT
            id_almacen_logico
            INTO
            g_id_almacen_logico
            FROM almin.tal_ingreso
            WHERE id_ingreso = al_id_ingreso;

            IF almin.f_al_verificar_almacen_cerrado('logico',g_id_almacen_logico) THEN

                g_nivel_error := '3';
                g_descripcion_log_error := 'Orden de ingreso no almacenada: El Almacén se encuentra Bloqueado o Cerrado.';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;

            END IF;

            UPDATE almin.tal_ingreso SET
            estado_ingreso           = 'Rechazado',
            observaciones            = al_observaciones,
            fecha_aprobado_rechazado = now()
            WHERE almin.tal_ingreso.id_ingreso= al_id_ingreso;
            
            
            
            SELECT USUARI.id_usuario INTO g_id_usuario_firma
            FROM sss.tsg_usuario USUARI
            INNER JOIN kard.tkp_empleado EMPLEA ON USUARI.id_persona=EMPLEA.id_persona
            INNER JOIN kard.tkp_empleado_tpm_frppa EFRPPA ON EMPLEA.id_empleado = EFRPPA.id_empleado
            INNER JOIN almin.tal_firma_autorizada FIRAUT ON FIRAUT.id_empleado_frppa =EFRPPA.id_empleado_frppa
            INNER JOIN almin.tal_ingreso INGRES ON INGRES.id_firma_autorizada = FIRAUT.id_firma_autorizada
            WHERE INGRES.id_ingreso= al_id_ingreso;
            
            
            SELECT 1 INTO g_bandera FROM sss.tsg_usuario USUARI INNER JOIN sss.tsg_usuario_rol USUROL
            ON USUARI.id_usuario=USUROL.id_usuario
            WHERE USUARI.id_usuario=pm_id_usuario AND USUROL.id_rol=1;

            IF (g_id_usuario_firma>0) THEN
                   SELECT TARPEN.id_tarea_pendiente INTO g_id_tarea_pendiente
                  FROM sss.tsg_tarea_pendiente TARPEN
                  INNER JOIN sss.tsg_tarea_pendiente_asignador TAPEAS ON TARPEN.id_tarea_pendiente= TAPEAS.id_tarea_pendiente
                  WHERE TARPEN.id_subsistema = g_id_subsistema AND
                  TAPEAS.id_registro=al_id_ingreso AND TAPEAS.nombre_tabla = 'almin.tal_ingreso' AND TARPEN.estado= TAPEAS.estado AND TARPEN.estado='Pendiente'
                  AND ((g_id_usuario_firma=pm_id_usuario) OR (g_bandera=1));

                  IF(g_id_tarea_pendiente>0) THEN
                     UPDATE sss.tsg_tarea_pendiente
                     SET estado='Concluida',
                     fecha_concluido_anulado=now()
                     WHERE id_tarea_pendiente=g_id_tarea_pendiente;

                     UPDATE sss.tsg_tarea_pendiente_asignador set estado='Concluida'
                     where id_registro=al_id_ingreso AND id_tarea_pendiente= g_id_tarea_pendiente AND nombre_tabla = 'almin.tal_ingreso';
                  END IF;
             END IF;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Rechazo realizado satisfactoriamente';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
    ELSIF pm_codigo_procedimiento = 'AL_OINAPR_COR' THEN
        -- Para Solicitar corrección de Orden de Ingreso, lleva la orden de ingreso a Estado Borrador
        BEGIN
             g_bandera:=0;
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso
                          WHERE almin.tal_ingreso.id_ingreso=al_id_ingreso) THEN

                g_descripcion_log_error := 'Solicitud de corrección no realizado: no existe el registro la Solicitud de Orden de Ingreso';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI EL ESTADO DE LA ORDEN DE INGRESO ES BORRADOR
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso
                          WHERE almin.tal_ingreso.id_ingreso=al_id_ingreso
                          AND estado_ingreso='Pendiente') THEN

                g_descripcion_log_error := 'Solicitud de corrección no realizado: La Orden de Ingreso no está en estado lista para Aprobación';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --SE VERIFICA SI EL ALMACÉN ESTÁ BLOQUEADO O CERRADO
            SELECT
            id_almacen_logico
            INTO
            g_id_almacen_logico
            FROM almin.tal_ingreso
            WHERE id_ingreso = al_id_ingreso;

            IF almin.f_al_verificar_almacen_cerrado('logico',g_id_almacen_logico) THEN

                g_nivel_error := '3';
                g_descripcion_log_error := 'Orden de ingreso no almacenada: El Almacén se encuentra Bloqueado o Cerrado.';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;

            END IF;

            UPDATE almin.tal_ingreso SET
            estado_ingreso   = 'Borrador',
            observaciones    = al_observaciones
            WHERE almin.tal_ingreso.id_ingreso= al_id_ingreso;

           SELECT USUARI.id_usuario INTO g_id_usuario_firma
            FROM sss.tsg_usuario USUARI
            INNER JOIN kard.tkp_empleado EMPLEA ON USUARI.id_persona=EMPLEA.id_persona
            INNER JOIN kard.tkp_empleado_tpm_frppa EFRPPA ON EMPLEA.id_empleado = EFRPPA.id_empleado
            INNER JOIN almin.tal_firma_autorizada FIRAUT ON FIRAUT.id_empleado_frppa =EFRPPA.id_empleado_frppa
            INNER JOIN almin.tal_ingreso INGRES ON INGRES.id_firma_autorizada = FIRAUT.id_firma_autorizada
            WHERE INGRES.id_ingreso= al_id_ingreso;

            SELECT 1 INTO g_bandera FROM sss.tsg_usuario USUARI INNER JOIN sss.tsg_usuario_rol USUROL
            ON USUARI.id_usuario=USUROL.id_usuario
            WHERE USUARI.id_usuario=pm_id_usuario AND USUROL.id_rol=1;

            IF (g_id_usuario_firma>0) THEN
                   SELECT TARPEN.id_tarea_pendiente INTO g_id_tarea_pendiente
                  FROM sss.tsg_tarea_pendiente TARPEN
                  INNER JOIN sss.tsg_tarea_pendiente_asignador TAPEAS ON TARPEN.id_tarea_pendiente= TAPEAS.id_tarea_pendiente
                  WHERE TARPEN.id_subsistema = g_id_subsistema AND
                  TAPEAS.id_registro=al_id_ingreso AND TAPEAS.nombre_tabla = 'almin.tal_ingreso' AND TARPEN.estado= TAPEAS.estado AND TARPEN.estado='Pendiente'
                  AND ((g_id_usuario_firma=pm_id_usuario) OR (g_bandera=1));

                  IF(g_id_tarea_pendiente>0) THEN
                     UPDATE sss.tsg_tarea_pendiente
                     SET estado='Concluida',
                     fecha_concluido_anulado=now()
                     WHERE id_tarea_pendiente=g_id_tarea_pendiente;

                     UPDATE sss.tsg_tarea_pendiente_asignador set estado='Concluida'
                     where id_registro=al_id_ingreso AND id_tarea_pendiente= g_id_tarea_pendiente AND nombre_tabla = 'almin.tal_ingreso';
                  END IF;
             END IF;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Solicitud de Corrección de la Orden de Ingreso realizada satisfactoriamente';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
    ELSIF pm_codigo_procedimiento = 'AL_INGPEN_CON' THEN
        -- Para Confirmar ingreso físico, cambia el estado del ingreso a físico
        BEGIN

            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso
                          WHERE id_ingreso = al_id_ingreso) THEN

                g_descripcion_log_error := 'Confirmación no realizada: no existe el registro del Ingreso';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI EL ESTADO DE LA ORDEN DE INGRESO ES APROBADO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso
                          WHERE id_ingreso = al_id_ingreso
                          AND estado_ingreso = 'Aprobado') THEN

                g_descripcion_log_error := 'Confirmación no realizada: Ingreso no Aprobado';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --SE OBTIENE EL ALMACÉN LOGICO
            SELECT id_almacen_logico
            INTO g_id_almacen_logico
            FROM almin.tal_ingreso
            WHERE id_ingreso = al_id_ingreso;

            --SE OBTIENE EL ID DE RESPONSABLE DE ALMACÉN
            SELECT
            RESALM.id_responsable_almacen
            INTO g_id_responsable_almacen
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

            --SE VERIFICA SI EL ALMACÉN ESTÁ BLOQUEADO O CERRADO
            SELECT id_almacen_logico
            INTO g_id_almacen_logico
            FROM almin.tal_ingreso
            WHERE id_ingreso = al_id_ingreso;

            IF almin.f_al_verificar_almacen_cerrado('logico',g_id_almacen_logico) THEN

                g_nivel_error := '3';
                g_descripcion_log_error := 'Confirmación no realizada: El Almacén se encuentra Bloqueado o Cerrado.';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;

            END IF;

            --OBTIENE EL CORRELATIVO DEL INGRESO
            g_correlativo_ing := almin.f_al_obtener_correlativo('INGRES',to_char(COALESCE(al_fecha_reg,now()),'mm'),g_id_almacen_logico);

            IF g_correlativo_ing < 0 THEN

                g_nivel_error := '3';
                g_descripcion_log_error := 'Confirmación no realizada: Error al obtener correlativo del ingreso';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
            END IF;



            -- VERIFICA SI ES UNA DEVOLUCIÓN DE PRÉSTAMO
            /*SELECT
            id_transferencia
            INTO g_id_transferencia
            FROM almin.tal_transferencia
            WHERE id_ingreso_prestamo = al_id_ingreso
            AND prestamo = 'si' ;

            IF g_id_transferencia IS NOT NULL THEN

                --ACTUALIZA EL ESTADO DE LA TRANSFERENCIA COMO FINALIZADO
                UPDATE almin.tal_transferencia SET
                estado_transferencia     = 'Finalizado',
                fecha_finalizado_anulado = now()
                WHERE id_transferencia = g_id_transferencia;
            END IF;*/

            --VERIFICA SI VIENE DE UNA TRANSFERENCIA
            SELECT id_transferencia
            INTO g_id_transferencia
            FROM almin.tal_transferencia
            WHERE id_ingreso = al_id_ingreso
            OR id_ingreso_prestamo = al_id_ingreso;

            IF g_id_transferencia IS NOT NULL THEN
                --VERIFICA SI ES UN PRÉSTAMO
                IF EXISTS(SELECT 1
                          FROM almin.tal_transferencia
                          WHERE id_transferencia = g_id_transferencia
                          AND prestamo = 'si') THEN

                    IF EXISTS(SELECT 1 FROM almin.tal_transferencia
                              WHERE id_transferencia = g_id_transferencia
                              AND estado_transferencia='Ingreso_prestamo') THEN
                        UPDATE almin.tal_transferencia SET
                        estado_transferencia     = 'Finalizado',
                        fecha_finalizado_anulado = now()
                        WHERE id_transferencia = g_id_transferencia;
                    ELSE
                        --ACTUALIZA EL ESTADO DE LA TRANSFERENCIA COMO PENDIENTE DE PRESTAMO
                        UPDATE almin.tal_transferencia SET
                        estado_transferencia     = 'Salida_prestamo',
                        fecha_finalizado_anulado = now()
                        WHERE id_transferencia = g_id_transferencia;
                    END IF;

                ELSE --Es transferencia sin préstamo
                    --ACTUALIZA EL ESTADO DE LA TRANSFERENCIA COMO FINALIZADO
                    UPDATE almin.tal_transferencia SET
                    estado_transferencia     = 'Finalizado',
                    fecha_finalizado_anulado = now()
                    WHERE id_transferencia = g_id_transferencia;
                END IF;
            END IF;

            IF EXISTS (SELECT 1 FROM almin.tal_ingreso
                       WHERE id_almacen_logico IN (SELECT id_almacen_logico
                                                   FROM almin.tal_almacen_logico ALMLOG
                                                   INNER JOIN almin.tal_tipo_almacen TIPALM
                                                   ON TIPALM.id_tipo_almacen = ALMLOG.id_tipo_almacen
                                                   AND TIPALM.contabilizar='no')
                       AND id_ingreso=al_id_ingreso) THEN --VERIFICA SI ES DE UN ALMACÉN DEPÓSITO, ES DECIR, NO CONTABILIZABLE
                --Debe pasar a estado valorado directamente y crear la alerta correspondiente para su finalización
                UPDATE almin.tal_ingreso SET
                estado_ingreso         = 'Valorado',
                correlativo_ing        = g_correlativo_ing,
                id_responsable_almacen = g_id_responsable_almacen,
                observaciones          = al_observaciones,
                fecha_ing_fisico       = now()
                WHERE id_ingreso = al_id_ingreso;
            
                --CREACIÓN DE TAREA: Obtener id_usuario del jefe de almacen que es el que ejecuta la finalización del ingreso
        
                SELECT USUARI.id_usuario
                INTO g_id_usuario
                FROM sss.tsg_usuario USUARI
                INNER JOIN kard.tkp_empleado EMPLEA
                ON USUARI.id_persona=EMPLEA.id_persona
                INNER JOIN almin.tal_responsable_almacen RESALM
                ON RESALM.id_empleado= EMPLEA.id_empleado
                INNER JOIN almin.tal_ingreso INGRESO
                ON INGRESO.id_responsable_almacen = RESALM.id_responsable_almacen
                WHERE INGRESO.id_ingreso= al_id_ingreso;

                -- SI NO ENCUENTRA EL USUARIO UTILIZA EL PARÁMETRO DE USUARIO
                IF g_id_usuario IS NULL THEN
                    g_id_usuario = pm_id_usuario;
                END IF;

                IF (g_id_usuario>0 OR g_rol_adm) THEN

                     SELECT NEXTVAL('sss.tsg_tarea_pendiente_id_tarea_pendiente_seq') INTO g_id_tarea_pendiente;

                    INSERT INTO sss.tsg_tarea_pendiente(
                    id_tarea_pendiente   ,id_usuario_asignado           ,id_subsistema   ,tarea,
                    descripcion,
                    codigo_procedimiento,
                    estado               ,fecha_reg
                    ) VALUES(
                    g_id_tarea_pendiente ,g_id_usuario,g_id_subsistema ,'Finalizar Ingreso',
                    'Realizar la finalización de Ingreso de Material',
                    'AL_INGRES_FIN',
                    'Pendiente'          ,now()
                    );

                    INSERT INTO sss.tsg_tarea_pendiente_asignador(
                    nombre_tabla  ,id_registro   ,estado      ,id_tarea_pendiente
                    ) VALUES(
                    'almin.tal_ingreso' ,al_id_ingreso ,'Pendiente' ,g_id_tarea_pendiente
                    );
                ELSE
                    g_descripcion_log_error := 'Confirmación no realizada: usuario no autorizado';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error,
                                                            pm_codigo_procedimiento);
--                    raise exception '%',g_separador;
                    RETURN 'f'||g_separador||g_respuesta;
                    --RAISE EXCEPTION 'Confirmación no realizada: usuario no autorizado';
                END IF;

            ELSE --Sigue el curso normal, pasa a estado Fisico
                UPDATE almin.tal_ingreso SET
                estado_ingreso         = 'Físico',
                correlativo_ing        = g_correlativo_ing,
--              id_responsable_almacen = g_id_responsable_almacen,
                observaciones          = al_observaciones,
                fecha_ing_fisico       = now()
                WHERE id_ingreso = al_id_ingreso;
            END IF;

            -- ACTUALIZA EL NRO DE INGRESOS PENDIENTES DE FINALIZACIÓN
            -- obtiene el total de nro de ingresos no finalizados
            SELECT
            COUNT(id_ingreso)
            INTO g_nro_ing_no_finalizados
            FROM almin.tal_ingreso
            WHERE estado_ingreso in ('Físico','Valorado');

            -- obtiene el id_almacen (almacén físico)
            SELECT
            ALMAEP.id_almacen
            INTO g_id_almacen
            FROM almin.tal_ingreso INGRES
            INNER JOIN almin.tal_almacen_logico ALMLOG
            ON ALMLOG.id_almacen_logico = INGRES.id_almacen_logico
            INNER JOIN almin.tal_almacen_ep ALMAEP
            ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
            WHERE INGRES.id_ingreso = al_id_ingreso;

            -- actualiza el nro de ingresos no finalizados
            UPDATE almin.tal_almacen SET
            nro_ing_no_finalizados = g_nro_ing_no_finalizados
            WHERE id_almacen = g_id_almacen;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Confirmación realizada satisfactoriamente';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

    ELSIF pm_codigo_procedimiento = 'AL_INGVAL_FIN' THEN
        -- Para Confirmar la valoracion del ingreso; cambia estado ingreso a Valorado
        BEGIN

            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso
                          WHERE almin.tal_ingreso.id_ingreso=al_id_ingreso) THEN

                g_descripcion_log_error := 'Finalización de Ingreso Valorado no realizado: no existe el registro del Ingreso';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI EL ESTADO DE LA ORDEN DE INGRESO ES FISICO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso
                          WHERE almin.tal_ingreso.id_ingreso=al_id_ingreso
                          AND estado_ingreso='Físico') THEN

                g_descripcion_log_error := 'Finalización de Ingreso Valorado no realizado: Ingreso físico no realizado';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --SE VERIFICA SI EL ALMACÉN ESTÁ BLOQUEADO O CERRADO
            SELECT
            id_almacen_logico
            INTO
            g_id_almacen_logico
            FROM almin.tal_ingreso
            WHERE id_ingreso = al_id_ingreso;


            IF almin.f_al_verificar_almacen_cerrado('logico',g_id_almacen_logico) THEN

                g_nivel_error := '3';
                g_descripcion_log_error := 'Orden de ingreso no almacenada: El Almacén se encuentra Bloqueado o Cerrado.';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;

            END IF;

            --obtener id_usuario del jefe de almacen
            SELECT USUARI.id_usuario INTO g_id_usuario_almacen
            FROM sss.tsg_usuario USUARI
            INNER JOIN kard.tkp_empleado EMPLEA ON USUARI.id_persona=EMPLEA.id_persona
            INNER JOIN almin.tal_responsable_almacen RESALM ON RESALM.id_empleado= EMPLEA.id_empleado
            INNER JOIN almin.tal_ingreso INGRESO ON INGRESO.id_responsable_almacen = RESALM.id_responsable_almacen
            WHERE INGRESO.id_ingreso= al_id_ingreso;

            -- SI NO ENCUENTRA EL USUARIO UTILIZA EL PARÁMETRO DE USUARIO
            IF g_id_usuario_almacen IS NULL THEN
                g_id_usuario_almacen = pm_id_usuario;
            END IF;

            IF (g_id_usuario_almacen>0 OR g_rol_adm) THEN
                  UPDATE almin.tal_ingreso SET
                  estado_ingreso       = 'Valorado',
                  observaciones        = al_observaciones,
                  fecha_ing_valorado   = now()
                  WHERE id_ingreso= al_id_ingreso;
            

                   SELECT NEXTVAL('sss.tsg_tarea_pendiente_id_tarea_pendiente_seq') INTO g_id_tarea_pendiente;

                  INSERT INTO sss.tsg_tarea_pendiente (id_tarea_pendiente, id_usuario_asignado, id_subsistema, tarea, descripcion,enlace,estado,fecha_reg)
                  VALUES (g_id_tarea_pendiente, g_id_usuario_almacen, g_id_subsistema, 'Finalizar Ingreso','Realizar la finalización de Ingreso de Material','../../../sis_almacenes/vista/ingreso_fin/ingreso_fin.php','Pendiente',now());

                  INSERT INTO sss.tsg_tarea_pendiente_asignador(nombre_tabla, id_registro, estado, id_tarea_pendiente)
                  VALUES ('almin.tal_ingreso', al_id_ingreso, 'Pendiente', g_id_tarea_pendiente);
            ELSE
                  g_descripcion_log_error := 'Finalización no realizada: No existe un responsable de almacen asignado';
                  g_nivel_error := '4';
                  g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                  RETURN 'f'||g_separador||g_respuesta;
            END IF;


            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Confirmación realizada satisfactoriamente';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

    ELSIF pm_codigo_procedimiento = 'AL_INGFIN_FIN' THEN
        -- Para Terminar el ingreso ; cambia el estado ingreso a Finalizado
        BEGIN
        g_bandera:=0;
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso
                          WHERE almin.tal_ingreso.id_ingreso=al_id_ingreso) THEN

                g_descripcion_log_error := 'Finalización de Ingreso no realizado: no existe el registro del Ingreso';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI EL ESTADO DE LA ORDEN DE INGRESO ES VALORADO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso
                          WHERE almin.tal_ingreso.id_ingreso=al_id_ingreso
                          AND estado_ingreso='Valorado') THEN

                g_descripcion_log_error := 'Finalización de Ingreso  no realizado: Ingreso valorado no realizado';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --SE VERIFICA SI EL ALMACÉN ESTÁ BLOQUEADO O CERRADO
            SELECT
            id_almacen_logico
            INTO
            g_id_almacen_logico
            FROM almin.tal_ingreso
            WHERE id_ingreso = al_id_ingreso;

            IF almin.f_al_verificar_almacen_cerrado('logico',g_id_almacen_logico) THEN

                g_nivel_error := '3';
                g_descripcion_log_error := 'Orden de ingreso no almacenada: El Almacén se encuentra Bloqueado o Cerrado.';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
            END IF;

            --ACTUALIZACION DE TAREA PENDIENTE
                --obtener id_usuario del jefe de almacen
            SELECT USUARI.id_usuario INTO g_id_usuario_almacen
            FROM sss.tsg_usuario USUARI
            INNER JOIN kard.tkp_empleado EMPLEA ON USUARI.id_persona=EMPLEA.id_persona
            INNER JOIN almin.tal_responsable_almacen RESALM ON RESALM.id_empleado= EMPLEA.id_empleado
            INNER JOIN almin.tal_ingreso INGRES ON INGRES.id_responsable_almacen = RESALM.id_responsable_almacen
            WHERE INGRES.id_ingreso= al_id_ingreso ;
         --bandera=1 si el usuario es administrador del Sistema, donde rol=1

         -- SI NO ENCUENTRA EL USUARIO UTILIZA EL PARÁMETRO DE USUARIO
            IF g_id_usuario_almacen IS NULL THEN
                g_id_usuario_almacen = pm_id_usuario;
            END IF;

            IF(g_id_usuario_almacen>0 OR g_rol_adm) THEN

                SELECT 1 INTO g_bandera FROM sss.tsg_usuario USUARI INNER JOIN sss.tsg_usuario_rol USUROL
                ON USUARI.id_usuario=USUROL.id_usuario
                WHERE USUARI.id_usuario=pm_id_usuario AND USUROL.id_rol=1;
            
                SELECT TARPEN.id_tarea_pendiente INTO g_id_tarea_pendiente
                FROM sss.tsg_tarea_pendiente TARPEN
                INNER JOIN sss.tsg_tarea_pendiente_asignador TAPEAS ON TARPEN.id_tarea_pendiente= TAPEAS.id_tarea_pendiente
                WHERE TARPEN.id_usuario_asignado = g_id_usuario_almacen AND TARPEN.id_subsistema = g_id_subsistema AND
                TAPEAS.id_registro=al_id_ingreso AND TAPEAS.nombre_tabla = 'almin.tal_ingreso' AND TARPEN.estado= TAPEAS.estado AND TARPEN.estado='Pendiente'
                AND ((g_id_usuario_almacen=pm_id_usuario) OR (g_bandera=1));

                --VERIFICA SI EXISTE LA TAREA PENDIENTE
                IF g_id_tarea_pendiente IS NULL THEN
                    g_sw = 1;
                ELSE
                    g_sw = 0;
                END IF;
            
                IF (g_id_tarea_pendiente>0 OR g_sw = 1) THEN

                     UPDATE almin.tal_ingreso SET
                     estado_ingreso               = 'Finalizado',
                     observaciones                = al_observaciones,
                     fecha_finalizado_cancelado   = now()
                     WHERE id_ingreso= al_id_ingreso;

                    --***ACTUALIZACIÓN DEL KARDEX LÓGICO
                    -- Se obtiene el almacén lógico
                    SELECT id_almacen_logico
                    INTO g_id_almacen_logico
                    FROM almin.tal_ingreso
                    WHERE id_ingreso = al_id_ingreso;
            
                    OPEN g_cursor_ing_det(al_id_ingreso);
                          
                         
            
                          -- OBTIENE LA GESTIÓN VIGENTE
                          SELECT id_parametro_almacen
                          INTO g_id_parametro_almacen
                          FROM almin.tal_parametro_almacen
                          WHERE cierre = 'no';

                          IF g_id_parametro_almacen IS NULL THEN
                          g_nivel_error := '3';
                          g_descripcion_log_error := 'Finalización de Ingreso no realizado: No existe una Gestión vigente.';
                          g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                          --REGISTRA EL LOG
                          g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                            --DEVUELVE MENSAJE DE ERROR
                            RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
                  END IF;

                  LOOP
                      FETCH g_cursor_ing_det INTO g_registros;
                      EXIT WHEN NOT FOUND;

                         IF EXISTS(SELECT 1
                              FROM almin.tal_kardex_logico
                              WHERE id_item = g_registros.id_item
                              AND estado_item = g_registros.estado_item
                              AND id_almacen_logico = g_id_almacen_logico
                              AND id_parametro_almacen = g_id_parametro_almacen) THEN
            
                               -- Se actualiza las cantidades
                               SELECT cantidad, costo_unitario, id_kardex_logico
                               INTO g_cant, g_costo_unit, g_id_kardex_logico
                               FROM almin.tal_kardex_logico
                               WHERE id_item = g_registros.id_item
                               AND estado_item = g_registros.estado_item
                               AND id_almacen_logico = g_id_almacen_logico
                               AND id_parametro_almacen = g_id_parametro_almacen;

                               g_cant_tot := g_cant + g_registros.cantidad;
                               g_nuevo_costo_unit := (g_costo_unit + g_registros.costo_unitario) / 2;
                               g_nuevo_costo_tot := g_cant_tot * g_nuevo_costo_unit;

                               UPDATE almin.tal_kardex_logico SET
                               cantidad = g_cant_tot,
                               costo_unitario = COALESCE(g_nuevo_costo_unit,0),
                               costo_total = COALESCE(g_nuevo_costo_tot,0)
                               WHERE id_kardex_logico = g_id_kardex_logico;
            
                          ELSE --se hace un insert
                               INSERT INTO almin.tal_kardex_logico(
                               estado_item              ,stock_minimo         ,cantidad             ,costo_unitario,
                               costo_total               ,reservado            ,id_item,
                               id_almacen_logico        ,id_parametro_almacen
                               )VALUES(
                               g_registros.estado_item         ,10                     ,g_registros.cantidad ,COALESCE(g_registros.costo_unitario,0),
                               COALESCE(g_registros.costo,0)   ,0                      ,g_registros.id_item,
                               g_id_almacen_logico             ,g_id_parametro_almacen
                               );
            
                          END IF;--1

                END LOOP;

                CLOSE g_cursor_ing_det;

                UPDATE sss.tsg_tarea_pendiente
                     SET estado='Concluida',
                     fecha_concluido_anulado=now()
                     WHERE id_tarea_pendiente=g_id_tarea_pendiente;

                     UPDATE sss.tsg_tarea_pendiente_asignador set estado='Concluida'
                     where id_registro=al_id_ingreso AND id_tarea_pendiente= g_id_tarea_pendiente AND nombre_tabla = 'almin.tal_ingreso';

                  ELSE
                   g_descripcion_log_error := 'Finalización no realizada: El usuario no tiene permisos para completar la operación';
                   g_nivel_error := '4';
                   g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                   RETURN 'f'||g_separador||g_respuesta;
               END IF;
           ELSE
                   g_descripcion_log_error := 'Finalización no realizada: El usuario no tiene permisos para completar la operación';
                   g_nivel_error := '4';
                   g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                   RETURN 'f'||g_separador||g_respuesta;
           END IF;
            
            --
                
            --***CONTABILIZACIÓN DEL INGRESO SI ES EL CASO
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Confirmación realizada satisfactoriamente';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

    ELSIF pm_codigo_procedimiento = 'AL_INGRES_DEL' THEN

        BEGIN
            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso
                          WHERE almin.tal_ingreso.id_ingreso=al_id_ingreso) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: registro en almin.tal_ingreso inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --SE VERIFICA SI EL ALMACÉN ESTÁ BLOQUEADO O CERRADO
            SELECT
            id_almacen_logico
            INTO
            g_id_almacen_logico
            FROM almin.tal_ingreso
            WHERE id_ingreso = al_id_ingreso;

            IF almin.f_al_verificar_almacen_cerrado('logico',g_id_almacen_logico) THEN

                g_nivel_error := '3';
                g_descripcion_log_error := 'Orden de ingreso no almacenada: El Almacén se encuentra Bloqueado o Cerrado.';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;

            END IF;

         -- BORRADO DE DATO
         IF EXISTS (SELECT 1 FROM almin.tal_ingreso_detalle INGDET WHERE INGDET.id_ingreso=al_id_ingreso )
            THEN
               DELETE FROM almin.tal_ingreso_detalle where id_ingreso=al_id_ingreso;
               DELETE FROM almin.tal_ingreso WHERE id_ingreso=al_id_ingreso;
         ELSE
            DELETE FROM almin.tal_ingreso WHERE id_ingreso = al_id_ingreso;
         END IF;
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminación exitosa del registro en almin.tal_ingreso';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;

    ELSIF pm_codigo_procedimiento = 'AL_INGRES_ANU' THEN
        -- Para anular un ingreso
        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso
                          WHERE almin.tal_ingreso.id_ingreso=al_id_ingreso) THEN

                g_descripcion_log_error := 'Anulación de Ingreso no realizada: no existe el registro del Ingreso';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;


            /*SELECT USUARI.id_usuario INTO g_id_usuario_almacen
            FROM sss.tsg_usuario USUARI
            INNER JOIN kard.tkp_empleado EMPLEA ON USUARI.id_persona=EMPLEA.id_persona
            INNER JOIN almin.tal_responsable_almacen RESALM ON RESALM.id_empleado= EMPLEA.id_empleado
            INNER JOIN almin.tal_ingreso INGRES ON INGRES.id_responsable_almacen = RESALM.id_responsable_almacen
            WHERE INGRES.id_ingreso= al_id_ingreso ;


            SELECT USUARI.id_usuario INTO g_id_usuario_firma
            FROM sss.tsg_usuario USUARI
            INNER JOIN kard.tkp_empleado EMPLEA ON USUARI.id_persona=EMPLEA.id_persona
            INNER JOIN kard.tkp_empleado_tpm_frppa EFRPPA ON EMPLEA.id_empleado = EFRPPA.id_empleado
            INNER JOIN almin.tal_firma_autorizada FIRAUT ON FIRAUT.id_empleado_frppa =EFRPPA.id_empleado_frppa
            INNER JOIN almin.tal_ingreso INGRES ON INGRES.id_firma_autorizada = FIRAUT.id_firma_autorizada
            WHERE INGRES.id_ingreso= al_id_ingreso;

            SELECT 1 INTO g_bandera FROM sss.tsg_usuario USUARI INNER JOIN sss.tsg_usuario_rol USUROL
            ON USUARI.id_usuario=USUROL.id_usuario
            WHERE USUARI.id_usuario=pm_id_usuario AND USUROL.id_rol=1;

            IF EXISTS( SELECT 1 FROM almin.tal_transferencia WHERE id_ingreso=al_id_ingreso OR id_ingreso_prestamo=al_id_ingreso) THEN
                   g_descripcion_log_error := 'Finalización no realizada: No es posible anular ingreso proveniente de una transferencia ';
                   g_nivel_error := '4';
                   g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                   RETURN 'f'||g_separador||g_respuesta;
            ELSE
                 IF (g_id_usuario_firma>0) THEN
                        SELECT TARPEN.id_tarea_pendiente INTO g_id_tarea_pendiente
                       FROM sss.tsg_tarea_pendiente TARPEN
                       INNER JOIN sss.tsg_tarea_pendiente_asignador TAPEAS ON TARPEN.id_tarea_pendiente= TAPEAS.id_tarea_pendiente
                       WHERE TARPEN.id_subsistema = g_id_subsistema AND
                       TAPEAS.id_registro=al_id_ingreso AND TAPEAS.nombre_tabla = 'almin.tal_ingreso' AND TARPEN.estado= TAPEAS.estado AND TARPEN.estado='Pendiente'
                       AND ((g_id_usuario_firma=pm_id_usuario) OR (g_bandera=1));

                           IF(g_id_tarea_pendiente>0) THEN
                                  UPDATE sss.tsg_tarea_pendiente
                                  SET estado='Concluida',
                                  fecha_concluido_anulado=now()
                                  WHERE id_tarea_pendiente=g_id_tarea_pendiente;

                                  UPDATE sss.tsg_tarea_pendiente_asignador set estado='Concluida'
                                  where id_registro=al_id_ingreso AND id_tarea_pendiente= g_id_tarea_pendiente AND nombre_tabla = 'almin.tal_ingreso';
                            END IF;
                  END IF;

                  IF(g_id_usuario_almacen>0) THEN
                  --bandera=1 si el usuario es administrador del Sistema, donde rol=1
                        SELECT 1 INTO g_bandera FROM sss.tsg_usuario USUARI INNER JOIN sss.tsg_usuario_rol USUROL
                        ON USUARI.id_usuario=USUROL.id_usuario
                        WHERE USUARI.id_usuario=pm_id_usuario AND USUROL.id_rol=1;

                        SELECT TARPEN.id_tarea_pendiente INTO g_id_tarea_pendiente
                        FROM sss.tsg_tarea_pendiente TARPEN
                        INNER JOIN sss.tsg_tarea_pendiente_asignador TAPEAS ON TARPEN.id_tarea_pendiente= TAPEAS.id_tarea_pendiente
                        WHERE TARPEN.id_usuario_asignado = g_id_usuario_almacen AND TARPEN.id_subsistema = g_id_subsistema AND
                        TAPEAS.id_registro=al_id_ingreso AND TAPEAS.nombre_tabla = 'almin.tal_ingreso' AND TARPEN.estado= TAPEAS.estado AND TARPEN.estado='Pendiente'
                        AND ((g_id_usuario_almacen=pm_id_usuario) OR (g_bandera=1));
            
                        IF (g_id_tarea_pendiente>0) THEN
                             UPDATE sss.tsg_tarea_pendiente
                             SET estado='Concluida',
                             fecha_concluido_anulado=now()
                             WHERE id_tarea_pendiente=g_id_tarea_pendiente;

                             UPDATE sss.tsg_tarea_pendiente_asignador set estado='Concluida'
                             where id_registro=al_id_ingreso AND id_tarea_pendiente= g_id_tarea_pendiente AND nombre_tabla = 'almin.tal_ingreso';
                        END IF;
                   END IF;*/

                  UPDATE almin.tal_ingreso SET
                  estado_ingreso             = 'Anulado',
                  fecha_finalizado_cancelado = now(),
                  observaciones              = al_observaciones
                  WHERE almin.tal_ingreso.id_ingreso= al_id_ingreso;
            

                   -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
                   g_descripcion_log_error := 'Anulación de ingreso realizado';
                   g_respuesta := 't'||g_separador||g_descripcion_log_error;
            --END IF;

        END;
    /************************************
     codigo: 	AL_INFIPR_FIN
     fecha: 	30/11/2016
     autor: 	RAC
     desc:		-  no permite los ignresos no valorados
     			-  calculo de ingreso segun promedio ponderado
                -  realizar ingreso en la gestion abierta
                -  permitr fianlizar ingresos en funcion si la lalve del almacen logico lo permite
     **************************************/

    ELSIF pm_codigo_procedimiento = 'AL_INFIPR_FIN' THEN --INFIPR: INgreso FInalización PRoyectos
        -- Para Terminar el ingreso de Proyectos; cambia el estado ingreso a Finalizado
        BEGIN
            g_bandera:=0;
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS( SELECT 1 FROM almin.tal_ingreso
                           WHERE id_ingreso=al_id_ingreso) THEN

                g_descripcion_log_error := 'Finalización de Ingreso no realizado: no existe el registro del Ingreso';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI EL ESTADO DE LA ORDEN DE INGRESO ES VALORADO
            IF EXISTS(SELECT 1 FROM almin.tal_ingreso
                          WHERE almin.tal_ingreso.id_ingreso=al_id_ingreso
                          AND estado_ingreso='Finalizado') THEN

                g_descripcion_log_error := 'Finalización de Ingreso no realizado: El ingreso ya está finalizado';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

             --VERIFICA SI TIENE ITEMS REGISTRADOS
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso_detalle
                          WHERE id_ingreso=al_id_ingreso) THEN

                g_descripcion_log_error := 'Finalización de Ingreso no realizado: No existe ningún Material registrado';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            -- OBTIENE LA GESTIÓN VIGENTE RAC
            
            SELECT
            	i.id_almacen_logico,
                i.id_parametro_almacen,
                i.id_parametro_almacen_logico,
                al.costeo_obligatorio
            INTO
            	g_id_almacen_logico,
                g_id_parametro_almacen  ,
                g_id_parametro_almacen_logico,
                g_costeo_obligatorio         
            FROM almin.tal_ingreso i
            inner join almin.tal_almacen_logico al on al.id_almacen_logico = i.id_almacen_logico
            WHERE id_ingreso = al_id_ingreso;
            --SE VERIFICA SI EL ALMACÉN ESTÁ BLOQUEADO O CERRADO
            IF exists(SELECT 1
                      FROM almin.tal_parametro_almacen_logico l
                      WHERE  l.id_parametro_almacen_logico = g_id_parametro_almacen_logico 
                             and estado = 'cerrado') THEN                             
                      raise exception 'No puede finalizar esta gestion esta cerrada';       
        	END IF;
                            
                  
                  
             IF g_id_parametro_almacen_logico is null THEN
                raise exception 'no se encontro gestión para el almacen lógico';
             END IF;
            
             --  validar que la fecha de inalizacion este dentro de la gestion 
            select 
               pa.gestion
              into
               g_gestion
            from almin.tal_parametro_almacen pa 
            where pa.id_parametro_almacen =  g_id_parametro_almacen;
                    
             v_finalizacion_tmp = now();
            IF v_finalizacion_tmp < ('01/01/'||g_gestion::varchar)::date   THEN
               v_finalizacion_tmp = ('01/01/'||g_gestion::varchar)::date;
            END IF;
            
             IF  v_finalizacion_tmp > ('12/31/'||g_gestion::varchar)::date THEN
               v_finalizacion_tmp =  ('12/31/'||g_gestion::varchar)::date;
            END IF;
            
             

            IF almin.f_al_verificar_almacen_cerrado('logico',g_id_almacen_logico) THEN

                g_nivel_error := '3';
                g_descripcion_log_error := 'Finalización de Ingreso no realizado: El Almacén se encuentra Bloqueado o Cerrado.';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
            END IF;
            
            --VERIFICA SI VIENE DE UNA TRANSFERENCIA
            SELECT id_transferencia
            INTO g_id_transferencia
            FROM almin.tal_transferencia
            WHERE id_ingreso = al_id_ingreso
            OR id_ingreso_prestamo = al_id_ingreso;

            IF g_id_transferencia IS NOT NULL THEN
                    --  ACTUALIZA EL ESTADO DE LA TRANSFERENCIA COMO FINALIZADO
                    UPDATE almin.tal_transferencia SET
                    estado_transferencia     = 'Finalizado',
                    fecha_finalizado_anulado = v_finalizacion_tmp
                    WHERE id_transferencia = g_id_transferencia;
                
            END IF;


            -- SI NO ENCUENTRA EL USUARIO UTILIZA EL PARÁMETRO DE USUARIO
            IF g_id_usuario_almacen IS NULL THEN
                g_id_usuario_almacen = pm_id_usuario;
            END IF;

            IF(g_id_usuario_almacen>0 OR g_rol_adm) THEN
                --bandera=1 si el usuario es administrador del Sistema, donde rol=1
                SELECT 1 INTO g_bandera
                FROM sss.tsg_usuario USUARI
                INNER JOIN sss.tsg_usuario_rol USUROL
                ON USUARI.id_usuario=USUROL.id_usuario
                WHERE USUARI.id_usuario=pm_id_usuario
                AND USUROL.id_rol=1;

             

                --VERIFICA SI EXISTE LA TAREA PENDIENTE
                IF g_id_tarea_pendiente IS NULL THEN
                    g_sw = 1;
                ELSE
                    g_sw = 0;
                END IF;

                --raise exception 'g_al_id_ingreso: %',g_id_tarea_pendiente;
            
                IF (g_id_tarea_pendiente>0 OR g_sw = 1) THEN

                       -- Obtiene el correlativo del Ingreso
                    g_correl = almin.f_al_obtener_correlativo('INGRES',to_char(COALESCE(al_fecha_reg,now()),'mm'),g_id_almacen_logico);
                    IF g_correl = -1 THEN
                        g_nivel_error := '3';
                        g_descripcion_log_error := 'Ingreso no registrado: No se pudo obtener el correlativo';
                        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                        --REGISTRA EL LOG
                        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                                 pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                                 pm_codigo_procedimiento   ,pm_proc_almacenado);

                        --DEVUELVE MENSAJE DE ERROR
                        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
                       END IF;

                    UPDATE almin.tal_ingreso SET
                      estado_ingreso               = 'Finalizado',
                      --observaciones                = al_observaciones,
                      fecha_finalizado_cancelado   =  v_finalizacion_tmp,
                      correlativo_ing                 = g_correl,
                      fecha_finalizado_exacta = now()
                    WHERE id_ingreso = al_id_ingreso;

                   

                    IF g_id_parametro_almacen IS NULL THEN
                        g_nivel_error := '3';
                        g_descripcion_log_error := 'Finalización de Ingreso no realizado: No existe una Gestión vigente.';
                        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                        --REGISTRA EL LOG
                        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                             pm_codigo_procedimiento   ,pm_proc_almacenado);

                        --DEVUELVE MENSAJE DE ERROR
                        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
                    END IF;
                    
                    
                   
                    
                    
                      OPEN g_cursor_ing_det(al_id_ingreso);
                    

                    LOOP
                        FETCH g_cursor_ing_det INTO g_registros;
                        EXIT WHEN NOT FOUND;
                        
                        --  28/11/2016 verificar que cada item tenga el costeo definido antes de finalizar
                        --  VERIFICAR que se tenga los costos antes de finalizar
                        -- si la llave de costeo esta activada
                        
                        IF g_costeo_obligatorio = 'si' THEN
                            select  
                               (i.codigo||'-'|| i.nombre)::varchar
                            into
                                v_desc_item
                            from almin.tal_item i
                            where i.id_item = g_registros.id_item;
                            -- no peuden ingresar item con costo cero ..??
                            IF g_registros.costo_unitario is null or g_registros.costo_unitario = 0 THEN
                                 raise exception 'El costo unitario no puede ser cero para el item %, %',  g_registros.id_item, v_desc_item;  
                            END IF;
                        
                        END IF;

                        IF EXISTS(SELECT 1
                                  FROM almin.tal_kardex_logico
                                  WHERE id_item = g_registros.id_item
                                  AND estado_item = g_registros.estado_item
                                  AND id_almacen_logico = g_id_almacen_logico
                                  AND id_parametro_almacen = g_id_parametro_almacen) THEN
            
                            -- Se actualiza las cantidades
                            SELECT cantidad, costo_unitario, id_kardex_logico
                            INTO g_cant, g_costo_unit, g_id_kardex_logico
                            FROM almin.tal_kardex_logico k
                            WHERE id_item = g_registros.id_item
                            AND estado_item = g_registros.estado_item
                            AND id_almacen_logico = g_id_almacen_logico
                            AND id_parametro_almacen = g_id_parametro_almacen;

                            
                            --RAC 28/11/2016 ,cambiar el calculo para que se haga por promedio poderado y no por promedio simple
                            
                            g_cant_tot := g_cant + g_registros.cantidad; 
                            g_nuevo_costo_tot := (g_cant * g_costo_unit) + (g_registros.cantidad * g_registros.costo_unitario);
                            g_nuevo_costo_unit :=   g_nuevo_costo_tot /g_cant_tot;
                           
                           --esto es promediosimple no sirve para almacenes
                           -- g_nuevo_costo_unit := (g_costo_unit + g_registros.costo_unitario) / 2;
                           

                            UPDATE almin.tal_kardex_logico SET
                              cantidad = g_cant_tot,
                              costo_unitario = COALESCE(g_nuevo_costo_unit,0),
                              costo_total = COALESCE(g_nuevo_costo_tot,0)
                            WHERE id_kardex_logico = g_id_kardex_logico;
            
                         ELSE --se hace un insert
                         
                            --cuando el item es el primero del almacen el costo se repite

                             INSERT INTO almin.tal_kardex_logico(
                             estado_item             ,stock_minimo           ,cantidad             ,costo_unitario,
                             costo_total             ,reservado              ,id_item,
                             id_almacen_logico       ,id_parametro_almacen
                             ) VALUES(
                             g_registros.estado_item ,10                     ,g_registros.cantidad ,COALESCE(g_registros.costo_unitario,0),
                             g_registros.costo          ,0                   ,g_registros.id_item,
                             g_id_almacen_logico     ,g_id_parametro_almacen
                             );
            
                         END IF;

                     END LOOP;

                     CLOSE g_cursor_ing_det;

                     --ACTUALIZAR EL CORRELATIVO
                     g_resp_act_correl := almin.f_al_actualizar_correlativo('INGRES',to_char(COALESCE(al_fecha_reg,now()),'mm'),g_id_almacen_logico);

                ELSE
                    g_descripcion_log_error := 'Finalización no realizada: El usuario no tiene permisos para completar la operación XX';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                END IF;
            ELSE
                   g_descripcion_log_error := 'Finalización no realizada: El usuario no tiene permisos para completar la operación YY';
                   g_nivel_error := '4';
                   g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                   RETURN 'f'||g_separador||g_respuesta;
            END IF;

            --***CONTABILIZACIÓN DEL INGRESO SI ES EL CASO
            
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Finalización realizada con éxito';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
    /*
    Autor:		RAC
    Fecha:		03/12/2016
    Desc:		- Se agrega el parametro id_parametro_almacen_logico para permitir lso cierres y aperturas de gestion de manera individual
    			- agrega tipo costeo
    
    */

    ELSIF pm_codigo_procedimiento = 'AL_OIPROY_INS' THEN
        --Para insertar una solicitud de orden de ingreso para Proyectos
        BEGIN

            --SE VERIFICA SI EL ALMACÉN ESTÁ BLOQUEADO O CERRADO
            IF almin.f_al_verificar_almacen_cerrado('logico',al_id_almacen_logico) THEN

                g_nivel_error := '3';
                g_descripcion_log_error := 'Orden de ingreso no almacenada: El Almacén se encuentra Bloqueado o Cerrado.';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;

            END IF;

            -- SE OBTIENE LA FIRMA AUTORIZADA CORRESPONDIENTE
            SELECT
            FIRAUT.id_firma_autorizada
            INTO g_id_firma_autorizada
            FROM almin.tal_firma_autorizada FIRAUT
            INNER JOIN almin.tal_almacen_logico ALMLOG
            ON ALMLOG.id_almacen_ep = FIRAUT.id_almacen_ep
            INNER JOIN almin.tal_motivo_ingreso MOTING
            ON MOTING.id_motivo_ingreso = FIRAUT.id_motivo_ingreso
            INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
            ON MOINCU.id_motivo_ingreso = MOTING.id_motivo_ingreso
            WHERE ALMLOG.id_almacen_logico = al_id_almacen_logico
            AND MOINCU.id_motivo_ingreso_cuenta = al_id_motivo_ingreso_cuenta
            AND FIRAUT.estado_reg = 'activo'
            ORDER BY FIRAUT.prioridad ASC
            LIMIT 1;

            --VERIFICA SI EXISTE FIRMA AUTORIZADA
            IF g_id_firma_autorizada IS NULL THEN

                g_nivel_error := '3';
                g_descripcion_log_error := 'Orden de ingreso no almacenada: Firma autorizada no registrada para la Actividad definida';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
            END IF;

            -- VERIFICA SI DEBE CONTABILIZARSE
            SELECT
            TIPALM.contabilizar
            INTO g_contabilizar
            FROM almin.tal_almacen_logico ALMLOG
            INNER JOIN almin.tal_tipo_almacen TIPALM
            ON TIPALM.id_tipo_almacen = ALMLOG.id_tipo_almacen
            WHERE ALMLOG.id_almacen_logico = al_id_almacen_logico;

           
            
            -- OBTIENE LA GESTIÓN VIGENTE RAC
            SELECT 
               l.id_parametro_almacen,
               l.id_parametro_almacen_logico
            INTO 
               g_id_parametro_almacen,
               g_id_parametro_almacen_logico
            FROM almin.tal_parametro_almacen_logico l
            WHERE     estado  = 'abierto'
                  and  l.id_almacen_logico = al_id_almacen_logico;
            
            
            
            

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

            -- Obtiene el Almacenero
            SELECT
            RESALM.id_responsable_almacen
            INTO g_id_responsable_almacen
            FROM almin.tal_almacen_logico ALMLOG
            INNER JOIN almin.tal_almacen_ep ALMAEP
            ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
            INNER JOIN almin.tal_responsable_almacen RESALM
            ON RESALM.id_almacen = ALMAEP.id_almacen
            WHERE ALMLOG.id_almacen_logico = al_id_almacen_logico
            AND RESALM.cargo = 'Almacenero'
            AND RESALM.estado = 'activo'
            LIMIT 1;

            IF g_id_responsable_almacen IS NULL THEN
                IF g_id_responsable_almacen IS NULL THEN
                    g_nivel_error := '3';
                    g_descripcion_log_error := 'Ingreso no registrado: Falta definir los responsables del Almacén';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                    --REGISTRA EL LOG
                    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                             pm_codigo_procedimiento   ,pm_proc_almacenado);

                    --DEVUELVE MENSAJE DE ERROR
                    RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
                END IF;
            END IF;

            -- Obtiene el Jefe de almacén
            SELECT
            RESALM.id_responsable_almacen
            INTO g_id_jefe_almacen
            FROM almin.tal_almacen_logico ALMLOG
            INNER JOIN almin.tal_almacen_ep ALMAEP
            ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
            INNER JOIN almin.tal_responsable_almacen RESALM
            ON RESALM.id_almacen = ALMAEP.id_almacen
            WHERE ALMLOG.id_almacen_logico = al_id_almacen_logico
            AND RESALM.cargo = 'Jefe de Almacen'
            AND RESALM.estado = 'activo'
            LIMIT 1;

            IF g_id_jefe_almacen IS NULL THEN
                g_nivel_error := '3';
                g_descripcion_log_error := 'Ingreso no registrado: No existe Jefe de Almacen registrado';
                 g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                    --REGISTRA EL LOG
                    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                             pm_codigo_procedimiento   ,pm_proc_almacenado);

                    --DEVUELVE MENSAJE DE ERROR
                    RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
                END IF;

           


            --OBTIENE LA MONEDA PRINCIPAL (CAMBIAR CON FUNCION)
            g_id_moneda_principal = 1;

            -- INSERTA LA ORDEN DE INGRESO
            INSERT INTO almin.tal_ingreso(
                descripcion,
                costo_total              ,contabilizar           ,estado_ingreso              ,estado_registro,
                fecha_borrador           ,id_responsable_almacen,
                id_proveedor             ,id_contratista         ,id_empleado                 ,id_almacen_logico,    
                id_firma_autorizada      ,id_institucion         ,id_motivo_ingreso_cuenta    ,fecha_pendiente,
                fecha_aprobado_rechazado ,fecha_ing_fisico       ,fecha_ing_valorado          ,fecha_finalizado_cancelado,
                orden_compra             ,observaciones          ,id_usuario                  ,id_parametro_almacen,
                num_factura              ,fecha_factura          ,responsable                 ,id_jefe_almacen,
                importacion              ,flete                  ,seguro                      ,gastos_alm,
                gastos_aduana            ,iva                    ,rep_form                    ,peso_neto,
                id_moneda_import         ,id_moneda_nacionaliz   ,dui                         ,monto_tot_factura,
                circuito,				  id_parametro_almacen_logico							,tipo_costeo
            ) VALUES (
                al_descripcion,
                al_costo_total           ,g_contabilizar         ,'Borrador'                  ,'activo',
                now()                    ,g_id_responsable_almacen,
                al_id_proveedor          ,al_id_contratista      ,al_id_empleado              ,al_id_almacen_logico,
                g_id_firma_autorizada    ,al_id_institucion      ,al_id_motivo_ingreso_cuenta ,NULL,
                NULL                     ,NULL                   ,NULL                        ,al_fecha_finalizado_cancelado,
                al_orden_compra          ,al_observaciones       ,pm_id_usuario               ,g_id_parametro_almacen,
                al_num_factura           ,al_fecha_factura       ,al_responsable              ,g_id_jefe_almacen,
                al_importacion           ,al_flete               ,al_seguro                   ,al_gastos_alm,
                al_gastos_aduana         ,al_iva                 ,al_rep_form                 ,al_peso_neto,
                al_id_moneda_import      ,g_id_moneda_principal  ,al_dui                      ,al_monto_tot_factura,
                'Simplificado',			  g_id_parametro_almacen_logico							,COALESCE(al_tipo_costeo,'peso')
            );

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso del Ingreso';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
  /*
   Autor:	RAC
   Fecha	15/12/2016
   Descripcion	- Aumentar  el criterio de costo estimado para  prorratear el costo de importaion
   				- Costeo por peso y coste estiamdo en ingresos  normales
                - Ingresos por devolucion copiar el costo de ingreso de las ultimas salidas
   
  */
    ELSEIF pm_codigo_procedimiento = 'AL_VALORA_INS' THEN --VALoracion de Ingresos
        --Para la Valoracion de los items del Ingreso
        BEGIN

            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso
                          WHERE id_ingreso = al_id_ingreso) THEN

                g_descripcion_log_error := 'Valoracion no realizada: Ingreso inexistente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso_detalle
                          WHERE id_ingreso = al_id_ingreso) THEN

                g_descripcion_log_error := 'Valoracion no realizada: No existen items registrados para el ingreso';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --obtiene datos del ingreso
            
            
            select 
             	i.id_ingreso,
             	i.tipo_costeo,
             	pal.estado,
                i.id_almacen_logico
            into
             	v_registros_ingreso
            from almin.tal_ingreso i
            inner join almin.tal_parametro_almacen_logico pal on pal.id_parametro_almacen_logico = i.id_parametro_almacen_logico
            where i.id_ingreso = al_id_ingreso;  
            
            --OBTIENE EL CODIGO DEL MOTIVO DE INGRESO PARA DETERMINAR EL TIPO DE VALORACION
            SELECT
              MOTING.codigo
              
            INTO 
              g_codigo_motivo_ingreso
            FROM almin.tal_ingreso INGRES
            INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU   ON MOINCU.id_motivo_ingreso_cuenta = INGRES.id_motivo_ingreso_cuenta
            INNER JOIN almin.tal_motivo_ingreso MOTING  ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
            WHERE INGRES.id_ingreso = al_id_ingreso;
            
            --validar que la gestion no este cerrada
            IF v_registros_ingreso.estado ='cerrado' then
               raise exception 'La gestion ya se encuentra cerrada no puede cambiar los valores del costeo por obvias razones,  aun que insista';
            end if;
            
            
            IF g_codigo_motivo_ingreso = 'IMP' THEN
            
            
            
            
                --VALORACION POR IMPORTACION
                --OBTIENE EL TOTAL DE IMPORTACION Y EL TOTAL DE NACIONALIZACION
                SELECT
                  COALESCE(INGRES.importacion,0)+COALESCE(INGRES.flete,0)+COALESCE(INGRES.seguro,0) as tot_import,
                  COALESCE(INGRES.gastos_alm,0)+COALESCE(INGRES.gastos_aduana,0)+COALESCE(INGRES.iva,0)+COALESCE(INGRES.rep_form,0) as tot_nac,
                  INGRES.id_moneda_import, INGRES.id_moneda_nacionaliz, INGRES.fecha_factura, INGRES.peso_neto
                INTO g_tot_import, g_tot_nacionaliz, g_id_moneda_import, g_id_moneda_nacionaliz,
                  g_fecha_factura ,g_peso_neto
                FROM almin.tal_ingreso INGRES
                LEFT JOIN param.tpm_tipo_cambio TIPCAM
                ON TIPCAM.id_moneda = INGRES.id_moneda_import
                AND TIPCAM.fecha = INGRES.fecha_factura
                WHERE INGRES.id_ingreso = al_id_ingreso;
                
                --OBTIENE EL PESO SUMANDO LOS PESOS DE LOS ITEMS (RCM: 23/03/2009)
                SELECT 
                   COALESCE(SUM(COALESCE(ITEM.peso_kg,0) * COALESCE(INGDET.cantidad,0)),0),
                   COALESCE(SUM(COALESCE(ITEM.costo_estimado,0) * COALESCE(INGDET.cantidad,0)),0)
                INTO 
                    g_peso_neto,
                    g_costo_estimado_neto
                FROM almin.tal_ingreso INGRES
                INNER JOIN almin.tal_ingreso_detalle INGDET
                ON INGDET.id_ingreso = INGRES.id_ingreso
                INNER JOIN almin.tal_item ITEM
                ON ITEM.id_item = INGDET.id_item
                WHERE INGRES.id_ingreso =  al_id_ingreso;
                
                IF v_registros_ingreso.tipo_costeo = 'peso' THEN

                    IF g_peso_neto IS NULL OR g_peso_neto = 0 THEN
                        g_descripcion_log_error := 'Valoracion no realizada: El Peso Neto es cero o no fue registrado';
                        g_nivel_error := '4';
                        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                        RETURN 'f'||g_separador||g_respuesta;
                    END IF;
                ELSE
                
                   IF g_costo_estimado_neto IS NULL OR g_costo_estimado_neto = 0 THEN
                        g_descripcion_log_error := 'Valoracion no realizada: El Costo Estimadto Neto es cero o no fue registrado';
                        g_nivel_error := '4';
                        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                        RETURN 'f'||g_separador||g_respuesta;
                    END IF;
                
                END IF;

                raise notice 'tot_import: %', g_tot_import;
                raise notice 'tot_nacionaliz: %', g_tot_nacionaliz;
                raise notice 'peso neto: %', g_peso_neto;
                raise notice 'fecha factura: %', g_fecha_factura;


                --CONVIERTE EL TOTAL IMPORTACION A LA MONEDA DE LA NACIONALIZACION
                g_tot_import_conv := param.f_pm_conversion_monedas(g_fecha_factura,g_tot_import,g_id_moneda_import,g_id_moneda_nacionaliz,'O'::varchar);
                raise notice 'tot_import_conv: %', g_tot_import_conv;

                IF g_tot_import_conv = 0 OR g_tot_import_conv IS NULL THEN
                    g_descripcion_log_error := 'Valoracion no realizada: Tipo de cambio no registrado para el '||to_char(g_fecha_factura,'dd/mm/yyyy');
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                END IF;

                --SUMA EL TOTAL DE LA IMPORTACION MAS EL TOTAL DE LA NACIONALIZACION
                g_tot_valoracion = COALESCE(g_tot_nacionaliz,0) + COALESCE(g_tot_import_conv,0);
                raise notice 'tot_valoracion: %', g_tot_valoracion;

                --OBTIENE EL FACTOR DE VALORACION (FD)
                IF v_registros_ingreso.tipo_costeo = 'peso' THEN
                	g_FD = g_tot_valoracion / g_peso_neto;
                ELSE
	                g_FD = g_tot_valoracion / g_costo_estimado_neto;	
                END IF;
 				
                raise notice 'FD: %', g_FD;

                IF g_FD IS NULL AND g_FD > 0 THEN
                    g_descripcion_log_error := 'Valoracion no realizada: El Factor de Valoracion es cero o nulo';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                END IF;

                --RECORRE EL DETALLE DEL INGRESO Y VALORA CADA ITEM
                OPEN g_cursor(al_id_ingreso);

                LOOP
                    FETCH g_cursor INTO g_registro;
                    EXIT WHEN NOT FOUND;

                    IF NOT g_registro.cantidad IS NULL AND g_registro.cantidad > 0 THEN
                        --CALCULA EL PRECIO UNITARIO DEL ITEM
                        IF v_registros_ingreso.tipo_costeo = 'peso' THEN
                          g_precio_item = COALESCE((g_FD * g_registro.peso_kg * g_registro.cantidad) / g_registro.cantidad,0);
                          
                        ELSE
                           g_precio_item = COALESCE((g_FD * g_registro.costo_estimado * g_registro.cantidad) / g_registro.cantidad,0);	
                        END IF;
                        
                        IF g_precio_item is null or g_precio_item = 0 then
                          raise exception 'El costo estimado del item (%) dio cero, revise su  peso y  costo estimado en clasificación',g_registro.codigo;
                        end if;
                        
                       

                        --ACTUALZA EL PRECIO UNITARIO EN LA BD
                        UPDATE almin.tal_ingreso_detalle SET
                           costo_unitario = g_precio_item,
                           costo = g_precio_item * g_registro.cantidad
                        WHERE id_ingreso_detalle = g_registro.id_ingreso_detalle;  
                        
                    END IF;

                END LOOP;
                CLOSE g_cursor;

            
            --------------------------------------------------------------
            -- Valoracion de ingresos por devolucion
            -- obtiene los costos de los items a aprtir de las salidas
            ------------------------------------------------------------------
            ELSEIF g_codigo_motivo_ingreso = 'DEV' THEN
            
                
                
                --RECORRE EL DETALLE DEL INGRESO Y VALORA CADA ITEM
                OPEN g_cursor(al_id_ingreso);

                LOOP
                    FETCH g_cursor INTO g_registro;
                    EXIT WHEN NOT FOUND;

                    IF NOT g_registro.cantidad IS NULL AND g_registro.cantidad > 0 THEN
                        
                         -- obtener el ulitmo costo de laultima salida del mismo matearial
                        g_aux_cotos_det = NULL;
                         
                         select 
                            COALESCE(sad.costo_unitario,0),
                            s.correlativo_sal
                         into
                            g_aux_cotos_det,
                            g_correlativo_ing
                         from almin.tal_salida_detalle sad
                         inner join almin.tal_salida s on s.id_salida = sad.id_salida
                         where sad.id_item = g_registro.id_item
                         		AND s.id_almacen_logico = v_registros_ingreso
                          ORDER BY sad.id_salida_detalle DESC
                          LIMIT 1 OFFSET 0;
                        
                        IF g_aux_cotos_det = 0 THEN
                            raise exception 'La salida % del item % no fue valorada, primero  costee los ingresos y salidas previos', g_correlativo_ing, g_registro.codigo;
                        END IF;
                        
                         IF g_aux_cotos_det is null THEN
                            raise exception 'No existe una ultima salida para el material %, no puede ingresar por devolucion',  g_registro.codigo;
                        END IF;
                       

                        --ACTUALZA EL PRECIO UNITARIO EN LA BD
                        UPDATE almin.tal_ingreso_detalle SET
                           costo_unitario = g_precio_item,
                           costo = g_precio_item * g_registro.cantidad
                        WHERE id_ingreso_detalle = g_registro.id_ingreso_detalle;  
                        
                    END IF;

                END LOOP;
                CLOSE g_cursor;
            
            
            ELSE
                
                --VALORACION GENERAL
                --OBTIENE EL TOTAL DE LA FACTURA
                
                SELECT
                	INGRES.monto_tot_factura
                INTO 	
                	g_tot_factura
                FROM almin.tal_ingreso INGRES
                WHERE INGRES.id_ingreso = al_id_ingreso;

                 --OBTIENE LA CANTIDAD TOTAL DE LOS ITEMS A INGRESAR
                SELECT
                	SUM(INGDET.cantidad),
             		SUM(INGDET.costo_unitario)
                INTO 
                	g_tot_cantidad,
                    g_aux_cotos_det
                FROM almin.tal_ingreso_detalle INGDET
                WHERE INGDET.id_ingreso = al_id_ingreso;
                
                -- solo permite el costeo cuando no lo  tiene
                IF g_aux_cotos_det = 0 THEN
                   raise exception 'Este metodo de costeo solo puede realizarce cuando no registro costos unitarios';
                END IF;
               
              -- obtiene el criterio de prorrateo
              -- OBTIENE EL PESO SUMANDO LOS PESOS DE LOS ITEMS (RCM: 23/03/2009)
                SELECT 
                   COALESCE(SUM(COALESCE(ITEM.peso_kg,0) * COALESCE(INGDET.cantidad,0)),0),
                   COALESCE(SUM(COALESCE(ITEM.costo_estimado,0) * COALESCE(INGDET.cantidad,0)),0)
                INTO 
                    g_peso_neto,
                    g_costo_estimado_neto
                FROM almin.tal_ingreso INGRES
                INNER JOIN almin.tal_ingreso_detalle INGDET
                ON INGDET.id_ingreso = INGRES.id_ingreso
                INNER JOIN almin.tal_item ITEM
                ON ITEM.id_item = INGDET.id_item
                WHERE INGRES.id_ingreso =  al_id_ingreso;
                
                IF v_registros_ingreso.tipo_costeo = 'peso' THEN
                    IF g_peso_neto IS NULL OR g_peso_neto = 0 THEN
                        raise exception 'Valoracion no realizada: El Peso Neto es cero o no fue registrado';                        
                    END IF;
                    g_FD = g_tot_factura / g_peso_neto;
                ELSE                
                    IF g_costo_estimado_neto IS NULL OR g_costo_estimado_neto = 0 THEN
                        raise exception  'Valoracion no realizada: El Costo Estimado Neto es cero o no fue registrado';                    
                    END IF;
                     g_FD = g_tot_factura / g_costo_estimado_neto;                
                END IF;
                
                

                --RECORRE EL DETALLE DEL INGRESO Y VALORA CADA ITEM
                OPEN g_cursor(al_id_ingreso);

                LOOP
                    FETCH g_cursor INTO g_registro;
                    EXIT WHEN NOT FOUND;
                    
                    IF v_registros_ingreso.tipo_costeo = 'peso' THEN
                    	g_precio_item = COALESCE((g_FD * g_registro.peso_kg * g_registro.cantidad) / g_registro.cantidad,0);                          
                    ELSE
                    	g_precio_item = COALESCE((g_FD * g_registro.costo_estimado * g_registro.cantidad) / g_registro.cantidad,0);	
                    END IF;
                    
                    IF g_precio_item is null or g_precio_item = 0 then
                          raise exception 'El costo estimado del item (%) dio cero, revise su  peso y  costo estimado en clasificación',g_registro.codigo;
                     end if;

                    IF NOT g_registro.cantidad IS NULL AND g_registro.cantidad > 0 THEN
                        --ACTUALIZA EL PRECIO UNITARIO EN LA BD
                        UPDATE almin.tal_ingreso_detalle SET
                        costo_unitario = g_precio_item,
                        costo = g_precio_item * g_registro.cantidad
                        WHERE id_ingreso_detalle = g_registro.id_ingreso_detalle;

                    END IF;

                END LOOP;
                CLOSE g_cursor;
            END IF;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Valoracion exitosa de los items del ingreso: ' ||al_id_ingreso;
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

    ELSIF pm_codigo_procedimiento = 'AL_INGADQ_ANU' THEN
        -- Para anular un ingresos que vienen de Adquisiciones
        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_ingreso
                          WHERE id_cotizacion=al_id_cotizacion) THEN

                g_descripcion_log_error := 'Anulación de Ingresos no realizada: No existe ningun Ingreso relacionado con la Cotizacion';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;
            
            

            --ANULA LOS INGRESOS
            UPDATE almin.tal_ingreso SET
            estado_ingreso             = 'Anulado',
            fecha_finalizado_cancelado = now(),
            observaciones              = al_observaciones
            WHERE id_cotizacion = al_id_cotizacion;
            g_descripcion_log_error := 'anulacion exitosa de los items del ingreso: ' ||al_id_cotizacion;
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