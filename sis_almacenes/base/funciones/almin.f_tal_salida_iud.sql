--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_tal_salida_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_salida integer,
  al_correlativo_sal varchar,
  al_correlativo_vale varchar,
  al_descripcion varchar,
  al_contabilizar varchar,
  al_contabilizado varchar,
  al_estado_salida varchar,
  al_estado_registro varchar,
  al_motivo_cancelacion varchar,
  al_id_responsable_almacen integer,
  al_id_almacen_logico integer,
  al_id_empleado integer,
  al_id_firma_autorizada integer,
  al_id_contratista integer,
  al_id_tipo_material integer,
  al_id_institucion integer,
  al_id_subactividad integer,
  al_id_motivo_salida_cuenta integer,
  al_emergencia varchar,
  al_observaciones varchar,
  al_tipo_pedido varchar,
  al_receptor varchar,
  al_id_tramo_subactividad integer,
  al_id_tramo_unidad_constructiva integer,
  al_fecha_borrador date,
  al_id_supervisor integer,
  al_receptor_ci varchar,
  al_solicitante varchar,
  al_solicitante_ci varchar,
  al_num_contrato varchar
)
RETURNS varchar AS
$body$
/************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ALMACENES (ALMIN)
***************************************************************************
 SCRIPT:         almin.f_tal_salida_iud
 DESCRIPCIÓN:     Permite registrar en la tabla almin.tal_salida
 AUTOR:         (generado automaticamente)
 FECHA:            2007-10-25 15:07:58
 COMENTARIOS:
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCION: Modificacion en obtencion de firma autorizada: motivo_salida_cuenta y estado_reg
 AUTOR:    Fernando Prudencio Cardona
 FECHA:    29-10-2007

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
    g_reg_error                   varchar;
    g_respuesta                   varchar;     -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCIÓN
    g_nivel_error                 varchar;     -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                               --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                               --      ERROR LÓGICO (CRÍTICO) = 2
                                               --      ERROR LÓGICO (INTERMEDIO) = 3
                                               --      ERROR LÓGICO (ADVERTENCIA) = 4

    g_nombre_funcion              varchar;     -- NOMBRE FÍSICO DE LA FUNCIÓN
    g_separador                   varchar(10); -- SEPARADOR DE CADENAS
    g_id_fina_regi_prog_proy_acti integer;     -- VARIABLE DE LA ESTRUCTURA PROGRAMÁTICA
    g_id_almacen_logico           integer;
    g_cursor_sal_det              CURSOR (ID integer) FOR
                                  SELECT * FROM almin.tal_salida_detalle WHERE id_salida = ID;
    g_registros                   almin.tal_salida_detalle%ROWTYPE; --Variable para recorrer el cursor
    g_cant_tot                    numeric;
    g_cant                        numeric;
    g_id_kardex_logico            integer;
    g_correlativo_ped             integer;
    g_id_firma_autorizada         integer;
    g_contabilizar                varchar;
    g_resp_act_correl             varchar;
    g_rol_adm                      boolean;    -- Identifica si el usuario tiene rol administrador
    g_ep_usuario_correcta         boolean;--para verificar si la el usuario tiene un ep valida para la insercion de pedidos
    g_emergencia                  varchar;
    g_observaciones               varchar;
    g_reservado                   numeric;
    g_costo_unitario              numeric;
    g_cant_consolidada            numeric;
    g_estado_salida               varchar;
    g_id_transferencia            integer;
    g_id_ingreso                  integer;
    g_registro                    almin.tal_transferencia%ROWTYPE;
    g_costo_total                 numeric;
    g_transf                      boolean;
    g_prestamo                    boolean;
    g_id_motivo_ingreso_cuenta    integer;
    g_id_usuario_firma            integer;
    g_id_tarea_pendiente          integer;
    g_id_usuario_almacen          integer;
    g_bandera                     integer;
    g_id_responsable_almacen      integer;
    g_id_almacen_logico_destino   integer;
    g_id_parametro_almacen        integer;
    g_cursor_pedido_tuc           CURSOR (ID integer) FOR
                                  SELECT
                                  SUM(PEDINT.cantidad_solicitada) as cantidad_total_solicitada,
                                  PEDINT.id_item,
                                  PEDINT.id_salida,
                                  PEDINT.id_orden_salida_uc_detalle,
                                  SALIDA.id_almacen_logico
                                  FROM almin.tal_pedido_tuc_int PEDINT
                                  INNER JOIN almin.tal_salida SALIDA
                                  ON SALIDA.id_salida = PEDINT.id_salida
                                  WHERE PEDINT.id_salida = ID
                                  GROUP BY PEDINT.id_item,PEDINT.id_salida,
                                  PEDINT.id_orden_salida_uc_detalle,
                                  SALIDA.id_almacen_logico;
                                  
    g_cursor_pedido_tuc_pr        CURSOR (ID integer) FOR
                                  SELECT
                                  SUM(PEDINT.cantidad_solicitada) as cantidad_total_solicitada,
                                  SUM(PEDINT.demasia) as cant_demasia,
                                  PEDINT.id_item,
                                  PEDINT.id_salida,
                                  SALIDA.id_almacen_logico
                                  FROM almin.tal_pedido_tuc_int PEDINT
                                  INNER JOIN almin.tal_salida SALIDA
                                  ON SALIDA.id_salida = PEDINT.id_salida
                                  WHERE PEDINT.id_salida = ID
                                  GROUP BY PEDINT.id_item,PEDINT.id_salida,
                                  SALIDA.id_almacen_logico;

    g_reg_pedido_tuc              record; --Variable para recorrer el cursor de pedido_tuc
    g_cursor_pedido_tuc_int       CURSOR (p_id_salida INTEGER,p_id_item INTEGER) FOR
                                  SELECT
                                  *
                                  FROM almin.tal_pedido_tuc_int
                                  WHERE id_salida = p_id_salida
                                  AND id_item = p_id_item;
    g_total                       numeric;--Para verificación pedido TUC
    g_nuevo                       numeric;--Para verificación pedido TUC
    g_usado                       numeric;--Para verificación pedido TUC
    g_tipo_entrega                varchar;--Para obtener el tipo de entrega
    g_tipo_pedido                 varchar;        
    g_sw                          integer;
    g_costo_unit                  numeric;  
    g_nuevo_costo_tot              numeric;
    g_fecha_borrador              date;
    g_datos                       record;
    g_id_jefe_almacen                integer;
    g_correl                      varchar;
    g_nuevo_costo_unit            numeric;
    g_fecha_trans				 DATE;
    g_gestion_tran				 varchar;
    g_costo_total_kardex		numeric;
    v_total_cant_solicitada		numeric;
    v_desc_item					varchar;

BEGIN

    ---*** INICIACIÓN DE VARIABLES
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion := 'almin.f_tal_salida_iud';
    g_privilegio_procedimiento := FALSE;
    g_respuesta := FALSE;
    g_rol_adm := FALSE;
    g_transf := FALSE;
    g_prestamo := FALSE;

    ---*** VERIFICACIÓN ROL ADMINISTRADOR
    IF EXISTS(SELECT 1 FROM sss.tsg_usuario_rol usrol WHERE usrol.id_usuario = pm_id_usuario AND usrol.id_rol=1) THEN
        g_rol_adm := true;

    END IF;

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

    IF(al_emergencia IS NULL) THEN
        IF (al_id_salida IS NOT NULL) THEN
            SELECT emergencia INTO g_emergencia from almin.tal_salida where id_salida=al_id_salida;
        ELSE
            g_emergencia:='No';
        END IF;
    ELSE
        g_emergencia:= al_emergencia;
    END IF;

    IF(al_observaciones IS NULL) THEN
        g_observaciones:='';
    ELSE
        g_observaciones:= al_observaciones;
    END IF;

    -- OBTIENE LA GESTIÓN VIGENTE
    SELECT id_parametro_almacen
    INTO g_id_parametro_almacen
    FROM almin.tal_parametro_almacen
    WHERE cierre = 'no';

    IF g_id_parametro_almacen IS NULL THEN

        g_nivel_error := '3';
        g_descripcion_log_error := 'No existe una Gestión vigente';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                             pm_codigo_procedimiento   ,pm_proc_almacenado);
        --DEVUELVE MENSAJE DE ERROR
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
    END IF;

      --*** EJECUCIÓN DEL PROCEDIMIENTO ESPECÍFICO
    IF pm_codigo_procedimiento = 'AL_PEDIDO_INS' THEN

        BEGIN
            -- SI EL USUARIO ES ADMINISTRADOS VERIFICA SI EL EP QUE QUIERE INSERTAR ES VALIDA
            IF g_rol_adm AND al_id_empleado!= NULL THEN
                IF NOT EXISTS(SELECT 1 FROM kard.tkp_empleado EMP
                              INNER JOIN kard.tkp_empleado_tpm_frppa EMP_EP
                              ON EMP.id_empleado=EMP_EP.id_empleado
                              INNER JOIN almin.tal_almacen_ep ALM_EP
                              ON ALM_EP.id_fina_regi_prog_proy_acti = EMP_EP.id_fina_regi_prog_proy_acti
                              INNER JOIN almin.tal_almacen_logico ALM_LG
                              ON ALM_LG.id_almacen_ep = ALM_EP.id_almacen_ep
                              WHERE ALM_LG.id_almacen_logico=al_id_almacen_logico
                              AND EMP.id_empleado = al_id_empleado) THEN

                     g_nivel_error := '3';
                     g_descripcion_log_error := 'La estructura Programática del Usuario no corresponde con el Almacén Lógico';
                     g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                     --REGISTRA EL LOG
                     g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                          pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                          pm_codigo_procedimiento   ,pm_proc_almacenado);

                    --DEVUELVE MENSAJE DE ERROR
                    RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;

               END IF;
            END IF;


            --OBTENER EL CORRELATIVO SIGUIENTE
            g_correlativo_ped := 0;--almin.f_al_obtener_correlativo('PEDIDO');

            /*IF g_correlativo_ped < 0 THEN

                g_nivel_error := '3';
                g_descripcion_log_error := 'Error al obtener correlativo';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
            END IF; */

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
           WHERE ALMLOG.id_almacen_logico = al_id_almacen_logico AND MSALCU.id_motivo_salida_cuenta = al_id_motivo_salida_cuenta AND FIRAUT.estado_reg='activo'
           ORDER BY FIRAUT.prioridad ASC, FIRAUT.id_firma_autorizada ASC
           LIMIT 1;

            --VERIFICA SI EXISTE FIRMA AUTORIZADA
            IF g_id_firma_autorizada IS NULL THEN

                g_nivel_error := '3';
                g_descripcion_log_error := 'Pedido no almacenado: firma autorizada no registrada';
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

            -- OBTIENE LA GESTIÓN VIGENTE
            SELECT id_parametro_almacen
            INTO g_id_parametro_almacen
            FROM almin.tal_parametro_almacen
            WHERE cierre = 'no';

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
            AND RESALM.estado='activo'
            LIMIT 1;
            
            IF g_id_responsable_almacen IS NULL THEN
                g_nivel_error := '3';
                g_descripcion_log_error := 'Salida no registrada: Debe definirse el Almacenero';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                         pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                         pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
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
            AND RESALM.cargo='Jefe de Almacen'
            AND RESALM.estado='activo'
            LIMIT 1;
                
            IF g_id_jefe_almacen IS NULL THEN
                g_nivel_error := '3';
                g_descripcion_log_error := 'Salida no registrada: No existe Jefe de Almacen registrado';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                             pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
            END IF;  
            
            INSERT INTO almin.tal_salida(
            correlativo_vale               ,descripcion                ,contabilizar,
            estado_salida                  ,estado_registro            ,motivo_cancelacion             ,id_responsable_almacen,
            id_almacen_logico              ,id_empleado                ,id_firma_autorizada            ,id_contratista,
            id_tipo_material               ,id_institucion             ,id_subactividad                ,fecha_borrador,
            fecha_pendiente                ,fecha_aprobado_rechazado   ,fecha_entregado                ,fecha_provisional,
            fecha_consolidado              ,fecha_finalizado_cancelado ,correlativo_sal                ,id_motivo_salida_cuenta,
            id_usuario                     ,emergencia                 ,id_parametro_almacen           ,tipo_pedido,
            receptor                       ,id_tramo_subactividad      ,id_tramo_unidad_constructiva   ,observaciones,
            id_supervisor                   ,receptor_ci                   ,solicitante                       ,solicitante_ci,
            num_contrato                   ,id_jefe_almacen
            ) VALUES (
            g_correlativo_ped              ,al_descripcion             ,g_contabilizar,
            'Borrador'                     ,'activo'                   ,NULL                            ,g_id_responsable_almacen,
            al_id_almacen_logico           ,al_id_empleado             ,g_id_firma_autorizada           ,al_id_contratista,
            al_id_tipo_material            ,al_id_institucion          ,al_id_subactividad              ,COALESCE(al_fecha_borrador,now()),
            NULL                           ,NULL                       ,NULL                            ,NULL,
            NULL                           ,NULL                       ,0                               ,al_id_motivo_salida_cuenta,
            pm_id_usuario                  ,g_emergencia               ,g_id_parametro_almacen          ,al_tipo_pedido,
            al_receptor                    ,al_id_tramo_subactividad   ,al_id_tramo_unidad_constructiva    ,al_observaciones,
            al_id_supervisor               ,al_receptor_ci               ,al_solicitante                    ,al_solicitante_ci,
            al_num_contrato                 ,g_id_jefe_almacen
            );

            --ACTUALIZAR EL CORRELATIVO
            --g_resp_act_correl := almin.f_al_actualizar_correlativo('PEDIDO');

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso del Pedido de Material';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

  --procedimiento de modificacion

   ELSIF pm_codigo_procedimiento = 'AL_PEDIDO_UPD' THEN

        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida
                          WHERE almin.tal_salida.id_salida=al_id_salida) THEN

                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de almin.tal_salida no existente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;


           -- SI EL USUARIO ES ADMINISTRADOS VERIFICA SI EL EP QUE QUIERE INSERTAR ES VALIDA
            IF g_rol_adm AND al_id_empleado!= NULL THEN
                IF NOT EXISTS(SELECT 1  FROM kard.tkp_empleado EMP INNER JOIN kard.tkp_empleado_tpm_frppa EMP_EP ON EMP.id_empleado=EMP_EP.id_empleado INNER JOIN almin.tal_almacen_ep ALM_EP ON ALM_EP.id_fina_regi_prog_proy_acti =EMP_EP.id_fina_regi_prog_proy_acti INNER JOIN almin.tal_almacen_logico ALM_LG ON ALM_LG.id_almacen_ep = ALM_EP.id_almacen_ep  WHERE ALM_LG.id_almacen_logico=al_id_almacen_logico and EMP.id_empleado = al_id_empleado) THEN


                     g_nivel_error := '3';
                     g_descripcion_log_error := 'La estructura Programática del Usuario no corresponde con el Almacén Lógico';
                     g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                     --REGISTRA EL LOG
                     g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                          pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                          pm_codigo_procedimiento   ,pm_proc_almacenado);

                                                     --DEVUELVE MENSAJE DE ERROR
                                                     RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;

               END IF;
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
           WHERE ALMLOG.id_almacen_logico = al_id_almacen_logico AND MSALCU.id_motivo_salida_cuenta = al_id_motivo_salida_cuenta AND FIRAUT.estado_reg='activo'
           ORDER BY FIRAUT.prioridad ASC, FIRAUT.id_firma_autorizada ASC
           LIMIT 1;

            --VERIFICA SI EXISTE FIRMA AUTORIZADA
            IF g_id_firma_autorizada IS NULL THEN
                g_nivel_error := '3';
                g_descripcion_log_error := 'Pedido no almacenado: firma autorizada no registrada';
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

            UPDATE almin.tal_salida SET
            descripcion                  = al_descripcion,
            contabilizar                 = g_contabilizar,
            --id_responsable_almacen     =al_id_responsable_almacen,
            id_almacen_logico            = al_id_almacen_logico,
            id_empleado                  = al_id_empleado,
            id_firma_autorizada          = g_id_firma_autorizada,
            id_contratista               = al_id_contratista,
            id_tipo_material             = al_id_tipo_material,
            id_institucion               = al_id_institucion,
            id_subactividad              = al_id_subactividad,
            id_motivo_salida_cuenta      = al_id_motivo_salida_cuenta,
            emergencia                   = g_emergencia,
            receptor                     = al_receptor,
            id_tramo_subactividad        = al_id_tramo_subactividad,
            id_tramo_unidad_constructiva = al_id_tramo_unidad_constructiva ,
            observaciones                 = al_observaciones,
            fecha_borrador                 = COALESCE(al_fecha_borrador,fecha_borrador),
            id_supervisor                 = al_id_supervisor,
            receptor_ci                  = al_receptor_ci,
            solicitante                  = al_solicitante,
            solicitante_ci               = al_solicitante_ci,
            num_contrato                 = al_num_contrato
            WHERE id_salida = al_id_salida;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificación exitosa en almin.tal_salida';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

   ELSIF pm_codigo_procedimiento = 'AL_SALIDA_DEL' THEN

    BEGIN
            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida
                          WHERE almin.tal_salida.id_salida=al_id_salida) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Eliminación no realizada: registro en almin.tal_salida inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

             -- VERIFICACIÓN DE EXISTENCIA DE HIJOS
             SELECT estado_salida INTO g_estado_salida from almin.tal_salida where id_salida=al_id_salida;

            IF EXISTS(SELECT 1 FROM almin.tal_salida_detalle WHERE id_salida = al_id_salida) THEN

                  IF(g_estado_salida ='Borrador') THEN
                      DELETE FROM almin.tal_salida_detalle WHERE id_salida= al_id_salida;
                      DELETE FROM almin.tal_salida WHERE almin.tal_salida.id_salida = al_id_salida;
                  ELSE
                      g_nivel_error := '4';
                      g_descripcion_log_error := 'Eliminación no realizada: El registro en almin.tal_salida';
                      g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                      RETURN 'f'||g_separador||g_respuesta;
                  END IF;
           ELSE
                      DELETE FROM almin.tal_salida WHERE almin.tal_salida.id_salida = al_id_salida;

           END IF;


            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminación exitosa del registro en almin.tal_salida';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;

    ELSIF pm_codigo_procedimiento = 'AL_PEDIDO_FIN' THEN

        BEGIN

            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida
                          WHERE almin.tal_salida.id_salida=al_id_salida) THEN

                g_descripcion_log_error := 'Finalización de Pedido no realizado: no existe el registro del Pedido';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI EL ESTADO DE LA ORDEN DE INGRESO ES BORRADOR
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida
                          WHERE almin.tal_salida.id_salida=al_id_salida
                          AND estado_salida='Borrador') THEN

                g_descripcion_log_error := 'Finalización de Pedido no realizado: El Pedido no está en estado Borrador';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI TIENE EL DETALLE DE ITEMS LLENADO
            IF EXISTS(SELECT 1 FROM almin.tal_salida where id_salida=al_id_salida and tipo_pedido='Item') THEN
                IF NOT EXISTS (SELECT 1 FROM almin.tal_salida_detalle where id_salida=al_id_salida) THEN
                   g_descripcion_log_error := 'Finalización no realizada: El Pedido no tiene ningún material registrado';
                   g_nivel_error := '4';
                   g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                   RETURN 'f'||g_separador||g_respuesta;
                END IF;
            ELSIF EXISTS (SELECT 1 FROM almin.tal_salida where id_salida=al_id_salida and tipo_pedido='Tipo Unidad Constructiva') THEN
               IF NOT EXISTS(SELECT 1 FROM almin.tal_orden_salida_uc_detalle ORDUCD
                             INNER JOIN almin.tal_salida SALIDA
                             ON SALIDA.id_salida = ORDUCD.id_salida
                             WHERE ORDUCD.id_salida = al_id_salida
                             AND SALIDA.tipo_entrega = 'Verificado') THEN
                   g_descripcion_log_error := 'Finalización no realizada: El Pedido no tiene ningún material registrado para TUC o no está Verificado';
                   g_nivel_error := '4';
                   g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                   RETURN 'f'||g_separador||g_respuesta;
               END IF;
            END IF;

            UPDATE almin.tal_salida SET
            estado_salida = 'Pendiente',
            fecha_pendiente = now()
            WHERE almin.tal_salida.id_salida= al_id_salida;


            SELECT id_almacen_logico
            INTO g_id_almacen_logico
            FROM almin.tal_salida
            WHERE id_salida = al_id_salida;

            -- OBTIENE LA GESTIÓN VIGENTE
            SELECT id_parametro_almacen
            INTO g_id_parametro_almacen
            FROM almin.tal_parametro_almacen
            WHERE cierre = 'no';

            IF g_id_parametro_almacen IS NULL THEN
                g_nivel_error := '3';
                g_descripcion_log_error := 'Finalización de Pedido no realizado: No existe una Gestión vigente.';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
            END IF;

            --ABRE EL CURSOR Y LO RECORRE si la salida corresponde a tipo_pedido='Item'

            IF EXISTS (SELECT 1 FROM almin.tal_salida where id_salida=al_id_salida and tipo_pedido='Item') THEN
                OPEN g_cursor_sal_det(al_id_salida);
            
                LOOP
                    FETCH g_cursor_sal_det INTO g_registros;
                    EXIT WHEN NOT FOUND;
    
                    IF EXISTS(SELECT 1
                          FROM almin.tal_kardex_logico
                          WHERE id_item = g_registros.id_item
                          AND id_almacen_logico = g_id_almacen_logico
                          AND estado_item= g_registros.estado_item
                          AND id_parametro_almacen = g_id_parametro_almacen) THEN
            
                          -- Se actualiza las cantidades en kardex lógico
                          SELECT reservado, id_kardex_logico
                          INTO g_cant, g_id_kardex_logico
                          FROM almin.tal_kardex_logico
                          WHERE id_item = g_registros.id_item
                          AND id_almacen_logico = g_id_almacen_logico
                          AND estado_item = g_registros.estado_item
                          AND id_parametro_almacen = g_id_parametro_almacen;


                          UPDATE almin.tal_kardex_logico SET
                          reservado = g_cant + g_registros.cant_solicitada
                          WHERE id_kardex_logico = g_id_kardex_logico;
                     ELSE
                          g_nivel_error := '4';
                          g_descripcion_log_error := 'Finalización de Pedido no realizado: material no registrado';
                          g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                          RETURN 'f'||g_separador||g_respuesta;
                      END IF;
                 END LOOP;

                 CLOSE g_cursor_sal_det;
               END IF;
            --generar alerta para aprobacion de salida

            SELECT USUARI.id_usuario INTO g_id_usuario_firma
            FROM sss.tsg_usuario USUARI
            INNER JOIN kard.tkp_empleado EMPLEA ON USUARI.id_persona=EMPLEA.id_persona
            INNER JOIN kard.tkp_empleado_tpm_frppa EFRPPA ON EMPLEA.id_empleado = EFRPPA.id_empleado
            INNER JOIN almin.tal_firma_autorizada FIRAUT ON FIRAUT.id_empleado_frppa =EFRPPA.id_empleado_frppa
            INNER JOIN almin.tal_salida SALIDA ON SALIDA.id_firma_autorizada = FIRAUT.id_firma_autorizada
            WHERE SALIDA.id_salida= al_id_salida;

            IF (g_id_usuario_firma>0) THEN

                SELECT NEXTVAL('sss.tsg_tarea_pendiente_id_tarea_pendiente_seq') INTO g_id_tarea_pendiente;
                INSERT INTO sss.tsg_tarea_pendiente (id_tarea_pendiente, id_usuario_asignado, id_subsistema, tarea, descripcion,codigo_procedimiento,estado,fecha_reg)
                VALUES(g_id_tarea_pendiente, g_id_usuario_firma, g_id_subsistema, 'Aprobar Salida','Aprobación de pedido de material','SALIDAGENERAL','Pendiente',now());

                INSERT INTO sss.tsg_tarea_pendiente_asignador (nombre_tabla,id_registro,estado,id_tarea_pendiente)
                VALUES('almin.tal_salida',al_id_salida,'Pendiente',g_id_tarea_pendiente);
            ELSE
            
                g_descripcion_log_error := 'Finalización no realizada: El usuario no tiene permisos para completar esta operación';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Finalización Pedido realizado satisfactoriamente';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;

     ELSIF pm_codigo_procedimiento = 'AL_SALPEN_UPD' THEN

        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida
                          WHERE id_salida=al_id_salida) THEN

                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de almin.tal_salida no existente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --*********** CÓDIGO RCM 05-12-2007

            -- VACÍA EL ESTADO SALIDA EN UNA VARIABLE LOCAL
            g_estado_salida := al_estado_salida;

            -- VERIFICA SI LA SALIDA ES DE UNA TRANSFERENCIA, Y SI ES DEVOLUCIÓN DE UN PRÉSTAMO; LUEGO SE OBTIENE EL ID
            -- DE LA TRANSFERENCIA
            IF EXISTS(SELECT 1
                      FROM almin.tal_transferencia
                      WHERE id_salida = al_id_salida
                      OR id_salida_prestamo = al_id_salida) THEN

                g_transf:=TRUE;
                g_estado_salida := 'Entregado';

                IF EXISTS(SELECT 1
                          FROM almin.tal_transferencia
                          WHERE id_salida_prestamo = al_id_salida) THEN
                    g_prestamo:=TRUE;
                END IF;


                IF NOT g_prestamo THEN

                    SELECT id_transferencia
                    INTO g_id_transferencia
                    FROM almin.tal_transferencia
                    WHERE id_salida = al_id_salida;
                ELSE

                    SELECT id_transferencia
                    INTO g_id_transferencia
                    FROM almin.tal_transferencia
                    WHERE id_salida_prestamo = al_id_salida;
                END IF;
            END IF;
            --*********** FIN RCM 05-12-2007

            -- SE OBTIENE El ALMACÉN LOGICO
            SELECT
            id_almacen_logico
            INTO g_id_almacen_logico
            FROM almin.tal_salida
            WHERE id_salida = al_id_salida;

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
            WHERE ALMLOG.id_almacen_logico = g_id_almacen_logico;
--            AND USUARI.id_usuario = pm_id_usuario;

            IF g_estado_salida='Entregado' THEN
            --*******modificamos la salida a entregado y su detalle

                    --VERIFICA SI LA SALIDA ES POR TRANSFERENCIA
                       IF g_transf THEN -- debe generarse un ingreso
                             SELECT id_parametro_almacen
                             INTO g_id_parametro_almacen
                             FROM almin.tal_parametro_almacen
                             WHERE cierre = 'no';
                             -- CREA EL INGRESO Y CAMBIA EL ESTADO A LA TRANSFERENCIA
                             --OBTIENE LOS DATOS DE LA TRANSFERENCIA
                             SELECT
                             *
                             INTO g_registro
                             FROM almin.tal_transferencia
                             WHERE id_transferencia = g_id_transferencia;
            
                            --OBTIENE EL COSTO TOTAL DEL DETALLE DE LA TRANSFERENCIA
                             SELECT
                             SUM(costo)
                             INTO g_costo_total
                             FROM almin.tal_transferencia_det
                             WHERE id_transferencia = g_id_transferencia;
            
                             -- VERIFICA SI DEBE CONTABILIZARSE (SI ES PRÉSTAMO DE HECHO NO SE CONTABILIZA)
                             IF  g_registro.prestamo = 'si' THEN
                                 g_contabilizar = 'no';
                             ELSE
                                 SELECT
                                 TIPALM.contabilizar
                                 INTO g_contabilizar
                                 FROM almin.tal_almacen_logico ALMLOG
                                 INNER JOIN almin.tal_tipo_almacen TIPALM
                                 ON TIPALM.id_tipo_almacen = ALMLOG.id_tipo_almacen
                                 WHERE ALMLOG.id_almacen_logico = g_registro.id_almacen_logico_destino;
                             END IF;

                             -- SE OBTIENE LA FIRMA AUTORIZADA CORRESPONDIENTE para el ingreso por transferencia
                             SELECT
                             FIRAUT.id_firma_autorizada
                             INTO g_id_firma_autorizada
                             FROM almin.tal_firma_autorizada FIRAUT
                             INNER JOIN almin.tal_almacen_logico ALMLOG
                             ON ALMLOG.id_almacen_ep = FIRAUT.id_almacen_ep
                             INNER JOIN almin.tal_motivo_ingreso MOTING
                             ON MOTING.id_motivo_ingreso = FIRAUT.id_motivo_ingreso AND MOTING.estado_registro='activo'
                             INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
                             ON MOINCU.id_motivo_ingreso = MOTING.id_motivo_ingreso
                             WHERE ALMLOG.id_almacen_logico = g_registro.id_almacen_logico
                             AND MOINCU.id_motivo_ingreso_cuenta = g_registro.id_motivo_ingreso_cuenta
                             AND FIRAUT.estado_reg = 'activo'
                             ORDER BY FIRAUT.prioridad ASC, FIRAUT.id_firma_autorizada ASC
                             LIMIT 1;

                                         IF (g_id_firma_autorizada>0) THEN  -- es posible registrar el ingreso
                                             --mandamos a terminar salida
                                             UPDATE almin.tal_salida SET
                                             estado_salida          = g_estado_salida,
                                             estado_registro        = al_estado_registro,
                                           --  id_responsable_almacen = g_id_responsable_almacen,
                                             fecha_entregado        = now(),
                                             fecha_consolidado      = now()
                                             WHERE almin.tal_salida.id_salida= al_id_salida;

                                             OPEN g_cursor_sal_det(al_id_salida);
                                                 LOOP
                                                     FETCH g_cursor_sal_det INTO g_registros;
                                                     EXIT WHEN NOT FOUND;


                                                     UPDATE almin.tal_salida_detalle set
                                                     cant_consolidada = g_registros.cant_entregada,
                                                     fecha_entregada = now(),
                                                     fecha_consolidada = now()
                                                     WHERE id_salida_detalle = g_registros.id_salida_detalle
                                                     AND id_salida = al_id_salida
                                                     AND id_item = g_registros.id_item
                                                     AND estado_item = g_registros.estado_item;

                                                 END LOOP;
                                             CLOSE g_cursor_sal_det;



                                              --creamos la tarea pendiente para finalizar salida de material, que lo realizará el jefe de almacen
                                              SELECT USUARI.id_usuario INTO g_id_usuario_almacen
                                              FROM sss.tsg_usuario USUARI
                                              INNER JOIN kard.tkp_empleado EMPLEA ON USUARI.id_persona=EMPLEA.id_persona
                                              INNER JOIN almin.tal_responsable_almacen RESALM ON RESALM.id_empleado= EMPLEA.id_empleado AND RESALM.estado = 'activo'
                                              INNER JOIN almin.tal_salida SALIDA ON SALIDA.id_responsable_almacen = RESALM.id_responsable_almacen
                                              WHERE SALIDA.id_salida= al_id_salida;  --si vino de una transferencia ==> el usuario es del almacen origen

                                                  IF (g_id_usuario_almacen>0) THEN
                                                       SELECT NEXTVAL('sss.tsg_tarea_pendiente_id_tarea_pendiente_seq') INTO g_id_tarea_pendiente;

                                                      INSERT INTO sss.tsg_tarea_pendiente (id_tarea_pendiente, id_usuario_asignado, id_subsistema, tarea, descripcion,codigo_procedimiento,estado,fecha_reg)
                                                      VALUES (g_id_tarea_pendiente, g_id_usuario_almacen, g_id_subsistema, 'Finalizar Salida','Realizar la finalización de Pedido de Material','AL_SALFIN','Pendiente',now());

                                                       INSERT INTO sss.tsg_tarea_pendiente_asignador(nombre_tabla, id_registro, estado, id_tarea_pendiente)
                                                      VALUES ('almin.tal_salida', al_id_salida, 'Pendiente', g_id_tarea_pendiente);
                                                  ELSE
                                                      g_descripcion_log_error := 'Finalización no realizada: El usuario no pertenece a un usuario valido ';
                                                      g_nivel_error := '4';
                                                      g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                                                      RETURN 'f'||g_separador||g_respuesta;
                                                  END IF;

                                                 -- SE OBTIENE LA EP DE LA TRANSFERENCIA
                                                 SELECT
                                                 MOINCU.id_fina_regi_prog_proy_acti
                                                 INTO g_id_fina_regi_prog_proy_acti
                                                 FROM almin.tal_transferencia TRANSF
                                                 INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
                                                 ON MOINCU.id_motivo_ingreso_cuenta = TRANSF.id_motivo_ingreso_cuenta
                                                 WHERE id_transferencia = g_id_transferencia;

                                                 -- SE OBTIENE EL MOTIVO DE INGRESO POR PRÉSTAMO, para el caso en el q la transf sea prestamo
                                                 IF NOT g_prestamo THEN
                                                     SELECT
                                                     id_motivo_ingreso_cuenta
                                                     INTO g_id_motivo_ingreso_cuenta
                                                     FROM almin.tal_motivo_ingreso_cuenta MOINCU
                                                     INNER JOIN almin.tal_motivo_ingreso MOTING
                                                     ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
                                                     WHERE MOTING.codigo = 'PRE' AND MOTING.estado_registro='activo'
                                                     AND MOINCU.id_fina_regi_prog_proy_acti = g_id_fina_regi_prog_proy_acti
                                                     ORDER BY MOINCU.id_motivo_ingreso_cuenta
                                                     LIMIT 1;
                                                 ELSE
                                                     SELECT
                                                     id_motivo_ingreso_cuenta
                                                     INTO g_id_motivo_ingreso_cuenta
                                                     FROM almin.tal_motivo_ingreso_cuenta MOINCU
                                                     INNER JOIN almin.tal_motivo_ingreso MOTING
                                                     ON MOTING.id_motivo_ingreso = MOINCU.id_motivo_ingreso
                                                     WHERE MOTING.estado_registro='activo'
                                                     AND MOINCU.id_fina_regi_prog_proy_acti = g_id_fina_regi_prog_proy_acti
                                                     ORDER BY MOINCU.id_motivo_ingreso_cuenta
                                                     LIMIT 1;
                                                 END IF;


                                                 --OBTIENE EL ÚLTIMO VALOR DE LA SECUENCIA PARA INSERTAR EL INGRESO
                                                    SELECT NEXTVAL('almin.tal_ingreso_id_ingreso_seq') INTO g_id_ingreso;
            
                                                --CREACIÓN DE INGRESO
                                                     INSERT INTO almin.tal_ingreso(id_ingreso,
                                                     descripcion,
                                                     costo_total               ,contabilizar               ,estado_ingreso                         ,estado_registro,
                                                     fecha_borrador            ,fecha_pendiente            ,fecha_aprobado_rechazado               ,id_responsable_almacen,
                                                     id_proveedor              ,id_contratista             ,id_empleado                            ,id_almacen_logico,    
                                                     id_firma_autorizada       ,id_institucion             ,id_motivo_ingreso_cuenta,
                                                     fecha_ing_fisico          ,fecha_ing_valorado         ,fecha_finalizado_cancelado,
                                                     orden_compra              ,observaciones              ,id_usuario                             ,id_parametro_almacen
                                                     ) VALUES ( g_id_ingreso,
                                                     g_registro.descripcion,
                                                     g_costo_total             ,g_contabilizar             ,'Aprobado'                             ,'activo',
                                                     now()                     ,now()                      ,now()                                  ,g_id_responsable_almacen,
                                                     NULL                      ,NULL                       ,g_registro.id_empleado                 ,g_registro.id_almacen_logico_destino,
                                                     g_id_firma_autorizada     ,NULL                       ,g_id_motivo_ingreso_cuenta,
                                                     NULL                      ,NULL                       ,NULL,
                                                     NULL                      ,g_registro.observaciones   ,pm_id_usuario                          ,g_id_parametro_almacen
                                                     );

                                                -- CREACIÓN DEL DETALLE
                                                       INSERT INTO almin.tal_ingreso_detalle(
                                                       costo             ,costo_unitario  ,precio_venta  ,cantidad,
                                                       id_item           ,id_ingreso      ,estado_item)
                                                       SELECT
                                                       costo             ,costo_unitario  ,precio_unitario  ,cantidad,
                                                       id_item           ,g_id_ingreso    ,estado_item
                                                       FROM almin.tal_transferencia_det
                                                       WHERE id_transferencia = g_id_transferencia;

                                                -- HACER UPDATE TRANSFERENCIA PARA RELACIONAR EL ID INGRESO
                                                      IF NOT g_prestamo THEN --solo transferencia
                                                      --TODO: VERIFICAR CASO PRÉSTAMOS
                                                         UPDATE almin.tal_transferencia SET
                                                                estado_transferencia = 'Pendiente_ingreso',
                                                                id_ingreso           = g_id_ingreso,
                                                                fecha_pendiente_ing  = now()
                                                                WHERE id_transferencia = g_id_transferencia;
                                                      ELSE -- es prestamo
                                                            UPDATE almin.tal_transferencia SET
                                                            estado_transferencia   = 'Ingreso_prestamo',
                                                            id_ingreso_prestamo    = g_id_ingreso,
                                                            fecha_ingreso_prestamo = now()
                                                            WHERE id_transferencia = g_id_transferencia;
                                                      END IF;-- SI NO ES PRESTAMO
                                                       g_descripcion_log_error := 'Modificación exitosa en almin.tal_salida';
                                                       g_respuesta := 't'||g_separador||g_descripcion_log_error;

                                 ELSE
                                     g_nivel_error := '3';
                                     g_descripcion_log_error := 'Modificación no realizada: No existe una firma autorizada para ingresos por transferencia';
                                     g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                                    --no exsiste responsable de autorizar ingresos por transferen
                                 END IF;


                               --*********** CÓDIGO RCM 05-12-2007
--             END IF; -- no es transferencia
               ELSE


                      UPDATE almin.tal_salida SET
                      estado_salida          = g_estado_salida,
                      estado_registro        = al_estado_registro,
                     -- id_responsable_almacen = g_id_responsable_almacen,
                      fecha_entregado        = now(),
                      fecha_consolidado      = now()
                      WHERE almin.tal_salida.id_salida= al_id_salida;

                      OPEN g_cursor_sal_det(al_id_salida);
            
                        LOOP
                          FETCH g_cursor_sal_det INTO g_registros;
                          EXIT WHEN NOT FOUND;


                          UPDATE almin.tal_salida_detalle set
                          cant_consolidada= g_registros.cant_entregada,
                          fecha_entregada = now(),
                          fecha_consolidada= now()
                          where id_salida_detalle=g_registros.id_salida_detalle and id_salida=al_id_salida and id_item=g_registros.id_item AND estado_item=g_registros.estado_item;
                       END LOOP;
                     CLOSE g_cursor_sal_det;

                    --creamos la tarea pendiente para finalizar salida de material, que lo realizará el jefe de almacen
                      SELECT USUARI.id_usuario INTO g_id_usuario_almacen
                      FROM sss.tsg_usuario USUARI
                      INNER JOIN kard.tkp_empleado EMPLEA ON USUARI.id_persona=EMPLEA.id_persona
                      INNER JOIN almin.tal_responsable_almacen RESALM ON RESALM.id_empleado= EMPLEA.id_empleado AND RESALM.estado = 'activo'
                      INNER JOIN almin.tal_salida SALIDA ON SALIDA.id_responsable_almacen = RESALM.id_responsable_almacen
                      WHERE SALIDA.id_salida= al_id_salida;  --si vino de una transferencia ==> el usuario es del almacen origen

                            IF (g_id_usuario_almacen>0) THEN
                                SELECT NEXTVAL('sss.tsg_tarea_pendiente_id_tarea_pendiente_seq') INTO g_id_tarea_pendiente;

                               INSERT INTO sss.tsg_tarea_pendiente (id_tarea_pendiente, id_usuario_asignado, id_subsistema, tarea, descripcion,codigo_procedimiento,estado,fecha_reg)
                               VALUES (g_id_tarea_pendiente, g_id_usuario_almacen, g_id_subsistema, 'Finalizar Salida','Realizar la finalización de Pedido de Material','AL_SALFIN','Pendiente',now());

                                INSERT INTO sss.tsg_tarea_pendiente_asignador(nombre_tabla, id_registro, estado, id_tarea_pendiente)
                               VALUES ('almin.tal_salida', al_id_salida, 'Pendiente', g_id_tarea_pendiente);
                            ELSE
                                g_descripcion_log_error := 'Finalización no realizada: El usuario no pertenece a un usuario valido ';
                                g_nivel_error := '4';
                                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                                RETURN 'f'||g_separador||g_respuesta;
                            END IF;
                     --*********** FIN RCM 05-12-2007

                     -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
                     g_descripcion_log_error := 'Modificación exitosa en almin.tal_salida';
                     g_respuesta := 't'||g_separador||g_descripcion_log_error;
          END IF;
     ELSE-- PASA A SER CONSOLIDADA LA SALIDA
                UPDATE almin.tal_salida SET
                estado_salida          = g_estado_salida,
               -- id_responsable_almacen = g_id_responsable_almacen,
                estado_registro        = al_estado_registro,
                fecha_provisional      = now()
                WHERE almin.tal_salida.id_salida= al_id_salida;

                -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
                   g_descripcion_log_error := 'Modificación exitosa en almin.tal_salida';
                   g_respuesta := 't'||g_separador||g_descripcion_log_error;
     END IF;

            -- Se obtiene el almacén lógico
            SELECT id_almacen_logico
            INTO g_id_almacen_logico
            FROM almin.tal_salida
            WHERE id_salida = al_id_salida;
            
            OPEN g_cursor_sal_det(al_id_salida);
            
            -- OBTIENE LA GESTIÓN VIGENTE
            SELECT id_parametro_almacen
            INTO g_id_parametro_almacen
            FROM almin.tal_parametro_almacen
            WHERE cierre = 'no';

            IF g_id_parametro_almacen IS NULL THEN
                g_nivel_error := '3';
                g_descripcion_log_error := 'Modificación no realizada: No existe una Gestión vigente.';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
            END IF;
            
            LOOP
                FETCH g_cursor_sal_det INTO g_registros;
                EXIT WHEN NOT FOUND;
    --raise exception 'id_almacen_logico: %     id_parametro_almacen: %     id_item: %',g_id_almacen_logico,g_id_parametro_almacen,g_registros.id_item;
                IF EXISTS(SELECT 1
                          FROM almin.tal_kardex_logico
                          WHERE id_item = g_registros.id_item
                          AND id_almacen_logico = g_id_almacen_logico
                          AND id_parametro_almacen = g_id_parametro_almacen) THEN
        
                    -- Se actualiza las cantidades
                    SELECT cantidad, id_kardex_logico, reservado, costo_unitario
                    INTO g_cant, g_id_kardex_logico, g_reservado, g_costo_unitario
                    FROM almin.tal_kardex_logico
                    WHERE id_item = g_registros.id_item
                    AND id_almacen_logico = g_id_almacen_logico
                    AND estado_item= g_registros.estado_item
                    AND id_parametro_almacen = g_id_parametro_almacen;

                    g_cant_tot := g_cant - g_registros.cant_entregada;

                    UPDATE almin.tal_kardex_logico SET
                    cantidad = g_cant_tot,
                    costo_total= g_costo_unitario * g_cant_tot,
                    reservado = g_reservado - g_registros.cant_solicitada
                    WHERE id_kardex_logico = g_id_kardex_logico;
            
                 ELSE --se hace un insert
            
                    g_nivel_error := '4';
                    g_descripcion_log_error := 'Modificación no realizada: material inexistente';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
            
                END IF;

            END LOOP;

            CLOSE g_cursor_sal_det;

        END;
    ELSIF pm_codigo_procedimiento = 'AL_SALIDA_APR' THEN

        BEGIN

            g_bandera:=0;
            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida
                          WHERE id_salida = al_id_salida) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Aprobación no realizada: registro de salida inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --VERIFICA SI EL ESTADO DE LA ORDEN DE INGRESO ES BORRADOR
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida
                          WHERE id_salida = al_id_salida
                          AND estado_salida = 'Pendiente' OR (estado_salida = 'Provisional' AND emergencia = 'Si')) THEN

                g_descripcion_log_error := 'Aprobación no realizada: La Orden de Salida no está en estado Pendiente o Provisional';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            --Concluir alerta de aprobación de salida

            SELECT USUARI.id_usuario INTO g_id_usuario_firma
            FROM sss.tsg_usuario USUARI
            INNER JOIN kard.tkp_empleado EMPLEA ON USUARI.id_persona=EMPLEA.id_persona
            INNER JOIN kard.tkp_empleado_tpm_frppa EFRPPA ON EMPLEA.id_empleado = EFRPPA.id_empleado
            INNER JOIN almin.tal_firma_autorizada FIRAUT ON FIRAUT.id_empleado_frppa =EFRPPA.id_empleado_frppa
            INNER JOIN almin.tal_salida SALIDA ON SALIDA.id_firma_autorizada = FIRAUT.id_firma_autorizada
            WHERE SALIDA.id_salida= al_id_salida ;

            --bandera=1 si el usuario es administrador del Sistema, donde rol=1
            SELECT 1 INTO g_bandera FROM sss.tsg_usuario USUARI INNER JOIN sss.tsg_usuario_rol USUROL
            ON USUARI.id_usuario=USUROL.id_usuario
            WHERE USUARI.id_usuario=pm_id_usuario AND USUROL.id_rol=1;

            IF(g_id_usuario_firma>0) THEN
                  SELECT TARPEN.id_tarea_pendiente INTO g_id_tarea_pendiente
                  FROM sss.tsg_tarea_pendiente TARPEN
                  INNER JOIN sss.tsg_tarea_pendiente_asignador TAPEAS ON TARPEN.id_tarea_pendiente= TAPEAS.id_tarea_pendiente
                  WHERE TARPEN.id_usuario_asignado = g_id_usuario_firma AND TARPEN.id_subsistema = g_id_subsistema AND
                  TAPEAS.id_registro=al_id_salida AND TAPEAS.nombre_tabla = 'almin.tal_salida' AND TARPEN.estado= TAPEAS.estado AND TARPEN.estado='Pendiente'
                  AND ((g_id_usuario_firma=pm_id_usuario) OR (g_bandera=1));

                  IF(g_id_tarea_pendiente>0) THEN

                     SELECT TARPEN.id_tarea_pendiente INTO g_id_tarea_pendiente
                     FROM sss.tsg_tarea_pendiente_asignador TAPEAS
                     INNER JOIN sss.tsg_tarea_pendiente TARPEN ON TARPEN.id_tarea_pendiente= TAPEAS.id_tarea_pendiente
                     WHERE TAPEAS.id_registro=al_id_salida AND TAPEAS.estado like 'Pendiente' AND TAPEAS.nombre_tabla like 'almin.tal_salida' AND
                     TARPEN.id_usuario_asignado=g_id_usuario_firma AND TARPEN.id_subsistema=g_id_subsistema AND  TARPEN.estado= TAPEAS.estado AND TARPEN.estado = 'Pendiente';

                     IF(g_emergencia ='Si')THEN
                           UPDATE almin.tal_salida SET
                           observaciones            = g_observaciones,
                           fecha_aprobado_rechazado = now()
                           WHERE id_salida = al_id_salida;
                     ELSE
                         --VERIFICA EL TIPO DE PEDIDO PARA REALIZAR LA APROBACIÓN
                         SELECT tipo_pedido
                         INTO g_tipo_pedido
                         FROM almin.tal_salida
                         WHERE id_salida = al_id_salida;

                         IF g_tipo_pedido = 'Item' THEN

                             UPDATE almin.tal_salida SET
                             estado_salida            = 'Aprobado',
                             observaciones            = g_observaciones,
                             fecha_aprobado_rechazado = now()
                             WHERE id_salida = al_id_salida;
            
                         ELSIF g_tipo_pedido = 'Tipo Unidad Constructiva' THEN

                            --VERIFICA SI EL TIPO DE SALIDA SERÁ PARCIAL O TOTAL
                            SELECT tipo_entrega
                            INTO g_tipo_entrega
                            FROM almin.tal_salida
                            WHERE id_salida = al_id_salida;

                            --Verifica si ya se verificaron las existencias
                            IF g_tipo_entrega IS NULL OR g_tipo_entrega = 'Verificado' THEN

                                g_descripcion_log_error := 'Aprobación no realizada: Debe verificarse las existencias antes de aprobar el Pedido de Unidad Constructiva';
                                g_nivel_error := '4';
                                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                                RETURN 'f'||g_separador||g_respuesta;

                            END IF;

                            IF g_tipo_entrega = 'Parcial' THEN

                                --Verifica si existe al menos un item con existencias y reservados
                                IF NOT EXISTS(SELECT
                                              SUM(nuevo), SUM(usado)
                                              FROM almin.tal_pedido_tuc_int
                                              WHERE id_salida = al_id_salida
                                              HAVING (SUM(nuevo) > 0 OR SUM(usado) > 0)) THEN

                                    g_descripcion_log_error := 'Aprobación no realizada: No existe ninguna reserva de items del pedido de Unidad Constructiva';
                                    g_nivel_error := '4';
                                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                                    RETURN 'f'||g_separador||g_respuesta;

                                END IF;

                                --Explota los items del pedido tuc en la tabla almin.tal_salida_detalle
                                INSERT INTO almin.tal_salida_detalle(
                                id_salida                           ,id_item                                  ,cant_solicitada,
                                estado_item                         ,fecha_solicitada                         ,costo,
                                costo_unitario                      ,precio_unitario                          ,cant_entregada)
                                SELECT
                                PEDINT.id_salida                    ,PEDINT.id_item                           ,SUM(PEDINT.nuevo) as cantidad,
                                'Nuevo'::varchar(20) as estado_item ,now()                                    ,KARLOG.costo_unitario * SUM(PEDINT.nuevo) as costo,
                                KARLOG.costo_unitario               ,KARLOG.costo_unitario as precio_unitario ,0
                                FROM almin.tal_pedido_tuc_int PEDINT
                                INNER JOIN almin.tal_salida SALIDA
                                ON SALIDA.id_salida = PEDINT.id_salida
                                INNER JOIN almin.tal_kardex_logico KARLOG
                                ON KARLOG.id_item = PEDINT.id_item
                                AND KARLOG.id_almacen_logico = SALIDA.id_almacen_logico
                                AND KARLOG.estado_item = 'Nuevo'
                                AND KARLOG.id_parametro_almacen = g_id_parametro_almacen
                                WHERE PEDINT.id_salida = al_id_salida
                                GROUP BY PEDINT.id_salida, PEDINT.id_item,KARLOG.costo_unitario
                                HAVING SUM(PEDINT.nuevo) > 0
                                UNION
                                SELECT
                                PEDINT.id_salida                     ,PEDINT.id_item                           ,SUM(PEDINT.usado) as cantidad,
                                'Usado'::varchar(20) as estado_item  ,now()                                    ,KARLOG.costo_unitario * SUM(PEDINT.nuevo) as costo,
                                KARLOG.costo_unitario                ,KARLOG.costo_unitario as precio_unitario ,0
                                FROM almin.tal_pedido_tuc_int PEDINT
                                INNER JOIN almin.tal_salida SALIDA
                                ON SALIDA.id_salida = PEDINT.id_salida
                                INNER JOIN almin.tal_kardex_logico KARLOG
                                ON KARLOG.id_item = PEDINT.id_item
                                AND KARLOG.id_almacen_logico = SALIDA.id_almacen_logico
                                AND KARLOG.estado_item = 'Usado'
                                AND KARLOG.id_parametro_almacen = g_id_parametro_almacen
                                WHERE PEDINT.id_salida = al_id_salida
                                GROUP BY PEDINT.id_salida, PEDINT.id_item,KARLOG.costo_unitario
                                HAVING SUM(PEDINT.usado) > 0;

                                --Se aprueba el Pedido
                                UPDATE almin.tal_salida SET
                                estado_salida            = 'Aprobado',
                                observaciones            = g_observaciones,
                                fecha_aprobado_rechazado = now()
                                WHERE id_salida = al_id_salida;

                            ELSE
                                --TOTAL, se verifica si existe la totalidad de items reservados; si no abastece, se libera los items reservados
                                IF EXISTS(SELECT 1 FROM almin.tal_pedido_tuc_int
                                          WHERE id_salida = al_id_salida
                                          AND cantidad_solicitada > nuevo + usado) THEN

                                    --Las existencias no alcanzan para todos los materiales; se libera el material reservado
                                    UPDATE almin.tal_kardex_logico SET
                                    reservado = reservado - ITEMS.cantidad
                                    FROM
                                    (SELECT
                                    PEDINT.id_item ,SUM(PEDINT.nuevo) as cantidad,
                                    'Nuevo'::varchar(20) as estado_item,
                                    SALIDA.id_almacen_logico
                                    FROM almin.tal_pedido_tuc_int PEDINT
                                    INNER JOIN almin.tal_salida SALIDA
                                    ON SALIDA.id_salida = PEDINT.id_salida
                                    WHERE PEDINT.id_salida = al_id_salida
                                    GROUP BY PEDINT.id_salida, PEDINT.id_item, SALIDA.id_almacen_logico
                                    HAVING SUM(PEDINT.nuevo) > 0
                                    UNION
                                    SELECT
                                    PEDINT.id_item,SUM(PEDINT.usado) as cantidad,
                                    'Usado'::varchar(20) as estado_item,
                                    SALIDA.id_almacen_logico
                                    FROM almin.tal_pedido_tuc_int PEDINT
                                    INNER JOIN almin.tal_salida SALIDA
                                    ON SALIDA.id_salida = PEDINT.id_salida
                                    WHERE PEDINT.id_salida = al_id_salida
                                    GROUP BY PEDINT.id_salida, PEDINT.id_item, SALIDA.id_almacen_logico
                                    HAVING SUM(PEDINT.usado) > 0) as ITEMS
                                    WHERE almin.tal_kardex_logico.id_item = ITEMS.id_item
                                    AND almin.tal_kardex_logico.id_almacen_logico = ITEMS.id_almacen_logico
                                    AND almin.tal_kardex_logico.id_parametro_almacen = g_id_parametro_almacen
                                    AND almin.tal_kardex_logico.estado_item = ITEMS.estado_item;

                                ELSE
                                    --Existencias suficientes; explota los items del pedido tuc en la tabla almin.tal_salida_detalle
                                    INSERT INTO almin.tal_salida_detalle(
                                    id_salida                           ,id_item                                  ,cant_solicitada,
                                    estado_item                         ,fecha_solicitada                         ,costo,
                                    costo_unitario                      ,precio_unitario                          ,cant_entregada)
                                    SELECT
                                    PEDINT.id_salida                    ,PEDINT.id_item                           ,SUM(PEDINT.nuevo) as cantidad,
                                    'Nuevo'::varchar(20) as estado_item ,now()                                    ,KARLOG.costo_unitario * SUM(PEDINT.nuevo) as costo,
                                    KARLOG.costo_unitario               ,KARLOG.costo_unitario as precio_unitario ,0
                                    FROM almin.tal_pedido_tuc_int PEDINT
                                    INNER JOIN almin.tal_salida SALIDA
                                    ON SALIDA.id_salida = PEDINT.id_salida
                                    INNER JOIN almin.tal_kardex_logico KARLOG
                                    ON KARLOG.id_item = PEDINT.id_item
                                    AND KARLOG.id_almacen_logico = SALIDA.id_almacen_logico
                                    AND KARLOG.estado_item = 'Nuevo'
                                    AND KARLOG.id_parametro_almacen = g_id_parametro_almacen
                                    WHERE PEDINT.id_salida = al_id_salida
                                    GROUP BY PEDINT.id_salida, PEDINT.id_item,KARLOG.costo_unitario
                                    HAVING SUM(PEDINT.nuevo) > 0
                                    UNION
                                    SELECT
                                    PEDINT.id_salida                     ,PEDINT.id_item                           ,SUM(PEDINT.usado) as cantidad,
                                    'Usado'::varchar(20) as estado_item  ,now()                                    ,KARLOG.costo_unitario * SUM(PEDINT.nuevo) as costo,
                                    KARLOG.costo_unitario                ,KARLOG.costo_unitario as precio_unitario ,0
                                    FROM almin.tal_pedido_tuc_int PEDINT
                                    INNER JOIN almin.tal_salida SALIDA
                                    ON SALIDA.id_salida = PEDINT.id_salida
                                    INNER JOIN almin.tal_kardex_logico KARLOG
                                    ON KARLOG.id_item = PEDINT.id_item
                                    AND KARLOG.id_almacen_logico = SALIDA.id_almacen_logico
                                    AND KARLOG.estado_item = 'Usado'
                                    AND KARLOG.id_parametro_almacen = g_id_parametro_almacen
                                    WHERE PEDINT.id_salida = al_id_salida
                                    GROUP BY PEDINT.id_salida, PEDINT.id_item,KARLOG.costo_unitario
                                    HAVING SUM(PEDINT.usado) > 0;

                                    --Se aprueba el Pedido
                                    UPDATE almin.tal_salida SET
                                    estado_salida            = 'Aprobado',
                                    observaciones            = g_observaciones,
                                    fecha_aprobado_rechazado = now()
                                    WHERE id_salida = al_id_salida;

                                END IF;

                            END IF;

                         END IF;

                     END IF;

                     UPDATE sss.tsg_tarea_pendiente
                     SET estado='Concluida',
                     fecha_concluido_anulado=now()
                     WHERE id_tarea_pendiente=g_id_tarea_pendiente;

                     UPDATE sss.tsg_tarea_pendiente_asignador SET
                     estado='Concluida'
                     WHERE id_registro = al_id_salida
                     AND id_tarea_pendiente = g_id_tarea_pendiente
                     AND nombre_tabla = 'almin.tal_salida';

                ELSE

                    g_descripcion_log_error := 'Aprobación no realizada: El usuario no tiene privilegios para aprobar el pedido.';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
                END IF;

            ELSE
                g_descripcion_log_error := 'Aprobación no realizada: La firma de Autorización no pertenece a un usuario válido';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;

              -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
              g_descripcion_log_error := 'Aprobación realizada satisfactoriamente';
              g_respuesta := 't'||g_separador||g_descripcion_log_error;
          END;

      ELSIF pm_codigo_procedimiento = 'AL_SALIDA_REC' THEN

          BEGIN
              --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
              IF NOT EXISTS(SELECT 1 FROM almin.tal_salida
                            WHERE almin.tal_salida.id_salida=al_id_salida) THEN

                  g_nivel_error := '4';
                  g_descripcion_log_error := 'Rechazo no realizado: registro en almin.tal_salida inexistente';
                  g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                  RETURN 'f'||g_separador||g_respuesta;

              END IF;

            --VERIFICA SI EL ESTADO DE LA ORDEN DE INGRESO ES BORRADOR
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida
                          WHERE almin.tal_salida.id_salida=al_id_salida
                          AND estado_salida='Pendiente') THEN

                g_descripcion_log_error := 'Rechazo no realizado: La Orden de Salida no está en estado Pendiente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            SELECT USUARI.id_usuario INTO g_id_usuario_firma
            FROM sss.tsg_usuario USUARI
            INNER JOIN kard.tkp_empleado EMPLEA ON USUARI.id_persona=EMPLEA.id_persona
            INNER JOIN kard.tkp_empleado_tpm_frppa EFRPPA ON EMPLEA.id_empleado = EFRPPA.id_empleado
            INNER JOIN almin.tal_firma_autorizada FIRAUT ON FIRAUT.id_empleado_frppa =EFRPPA.id_empleado_frppa
            INNER JOIN almin.tal_salida SALIDA ON SALIDA.id_firma_autorizada = FIRAUT.id_firma_autorizada
            WHERE SALIDA.id_salida= al_id_salida ;

            --bandera=1 si el usuario es administrador del Sistema, donde rol=1
               SELECT 1 INTO g_bandera FROM sss.tsg_usuario USUARI INNER JOIN sss.tsg_usuario_rol USUROL
               ON USUARI.id_usuario=USUROL.id_usuario
               WHERE USUARI.id_usuario=pm_id_usuario AND USUROL.id_rol=1;

                 IF(g_id_usuario_firma>0) THEN
                       SELECT TARPEN.id_tarea_pendiente INTO g_id_tarea_pendiente
                       FROM sss.tsg_tarea_pendiente TARPEN
                       INNER JOIN sss.tsg_tarea_pendiente_asignador TAPEAS ON TARPEN.id_tarea_pendiente= TAPEAS.id_tarea_pendiente
                       WHERE TARPEN.id_usuario_asignado = g_id_usuario_firma AND TARPEN.id_subsistema = g_id_subsistema AND
                       TAPEAS.id_registro=al_id_salida AND TAPEAS.nombre_tabla = 'almin.tal_salida' AND TARPEN.estado= TAPEAS.estado AND TARPEN.estado='Pendiente'
                       AND ((g_id_usuario_firma=pm_id_usuario) OR (g_bandera=1));

                       IF(g_id_tarea_pendiente>0) THEN
                          SELECT TARPEN.id_tarea_pendiente INTO g_id_tarea_pendiente
                          FROM sss.tsg_tarea_pendiente_asignador TAPEAS
                          INNER JOIN sss.tsg_tarea_pendiente TARPEN ON TARPEN.id_tarea_pendiente= TAPEAS.id_tarea_pendiente
                          WHERE TAPEAS.id_registro=al_id_salida AND TAPEAS.estado like 'Pendiente' AND TAPEAS.nombre_tabla like 'almin.tal_salida' AND
                          TARPEN.id_usuario_asignado=g_id_usuario_firma AND TARPEN.id_subsistema=g_id_subsistema AND  TARPEN.estado= TAPEAS.estado AND TARPEN.estado = 'Pendiente';

                          UPDATE almin.tal_salida SET
                          estado_salida = 'Rechazado',
                          observaciones = g_observaciones,
                          fecha_aprobado_rechazado = now()
                          WHERE almin.tal_salida.id_salida= al_id_salida;

                             --anular reservas en kardex logico
                          SELECT id_almacen_logico
                          INTO g_id_almacen_logico
                          FROM almin.tal_salida
                          WHERE id_salida = al_id_salida;

                          OPEN g_cursor_sal_det(al_id_salida);
                             -- OBTIENE LA GESTIÓN VIGENTE
                             SELECT id_parametro_almacen
                             INTO g_id_parametro_almacen
                             FROM almin.tal_parametro_almacen
                             WHERE cierre = 'no';

                             IF g_id_parametro_almacen IS NULL THEN
                                g_nivel_error := '3';
                                g_descripcion_log_error := 'Rechazo no realizado: No existe una Gestión vigente.';
                                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                                --REGISTRA EL LOG
                                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                                --DEVUELVE MENSAJE DE ERROR
                                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
                             END IF;
    
                             LOOP
                               FETCH g_cursor_sal_det INTO g_registros;
                               EXIT WHEN NOT FOUND;
    
                               IF EXISTS(SELECT 1
                                    FROM almin.tal_kardex_logico
                                    WHERE id_item = g_registros.id_item
                                    AND id_almacen_logico = g_id_almacen_logico
                                    AND estado_item= g_registros.estado_item
                                    AND id_parametro_almacen = g_id_parametro_almacen) THEN
            
                                    -- Se actualiza las cantidades
                                    SELECT reservado, id_kardex_logico
                                    INTO g_cant, g_id_kardex_logico
                                    FROM almin.tal_kardex_logico
                                    WHERE id_item = g_registros.id_item
                                    AND id_almacen_logico = g_id_almacen_logico
                                    AND estado_item= g_registros.estado_item
                                    AND id_parametro_almacen = g_id_parametro_almacen;

                                    UPDATE almin.tal_kardex_logico SET
                                    reservado = g_cant - g_registros.cant_solicitada
                                    WHERE id_kardex_logico = g_id_kardex_logico;
            
                               ELSE --se hace un insert
                                    g_nivel_error := '4';
                                    g_descripcion_log_error := 'Solicitud de Rechazo no realizada: registro en almin.tal_salida inexistente';
                                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                                    RETURN 'f'||g_separador||g_respuesta;
                               END IF;

                        END LOOP;

                   CLOSE g_cursor_sal_det;

                     UPDATE sss.tsg_tarea_pendiente
                     SET estado='Concluida',
                     fecha_concluido_anulado=now()
                     WHERE id_tarea_pendiente=g_id_tarea_pendiente;

                     UPDATE sss.tsg_tarea_pendiente_asignador set estado='Concluida'
                     where id_registro=al_id_salida AND id_tarea_pendiente= g_id_tarea_pendiente AND nombre_tabla = 'almin.tal_salida';


                   -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
                   g_descripcion_log_error := 'Rechazo realizado satisfactoriamente';
                   g_respuesta := 't'||g_separador||g_descripcion_log_error;
            ELSE

                g_descripcion_log_error := 'Tarea Pendiente no finalizada: No le corresponde rechazar esta solicitud';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;
       ELSE
           g_descripcion_log_error := 'Finalización no realizada: La firma de Autorización no pertenece a un usuario valido';
           g_nivel_error := '4';
           g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
           RETURN 'f'||g_separador||g_respuesta;
       END IF;


 END;
 ELSIF pm_codigo_procedimiento = 'AL_SALIDA_COR' THEN

    BEGIN
            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida
                          WHERE almin.tal_salida.id_salida=al_id_salida) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Solicitud de Correccion no realizada: registro en almin.tal_salida inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;
          --VERIFICA SI EL ESTADO DE LA ORDEN DE INGRESO ES BORRADOR
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida
                          WHERE almin.tal_salida.id_salida=al_id_salida
                          AND estado_salida='Pendiente') THEN

                g_descripcion_log_error := 'Solicitud de Correccion no realizada: La Orden de Salida no está en estado Pendiente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

            SELECT USUARI.id_usuario INTO g_id_usuario_firma
                   FROM sss.tsg_usuario USUARI
                   INNER JOIN kard.tkp_empleado EMPLEA ON USUARI.id_persona=EMPLEA.id_persona
                   INNER JOIN kard.tkp_empleado_tpm_frppa EFRPPA ON EMPLEA.id_empleado = EFRPPA.id_empleado
                   INNER JOIN almin.tal_firma_autorizada FIRAUT ON FIRAUT.id_empleado_frppa =EFRPPA.id_empleado_frppa
                   INNER JOIN almin.tal_salida SALIDA ON SALIDA.id_firma_autorizada = FIRAUT.id_firma_autorizada
                   WHERE SALIDA.id_salida= al_id_salida ;

                   --bandera=1 si el usuario es administrador del Sistema, donde rol=1
                   SELECT 1 INTO g_bandera FROM sss.tsg_usuario USUARI INNER JOIN sss.tsg_usuario_rol USUROL
                   ON USUARI.id_usuario=USUROL.id_usuario
                   WHERE USUARI.id_usuario=pm_id_usuario AND USUROL.id_rol=1;

                   IF(g_id_usuario_firma>0) THEN
                       SELECT TARPEN.id_tarea_pendiente INTO g_id_tarea_pendiente
                       FROM sss.tsg_tarea_pendiente TARPEN
                       INNER JOIN sss.tsg_tarea_pendiente_asignador TAPEAS ON TARPEN.id_tarea_pendiente= TAPEAS.id_tarea_pendiente
                       WHERE TARPEN.id_usuario_asignado = g_id_usuario_firma AND TARPEN.id_subsistema = g_id_subsistema AND
                       TAPEAS.id_registro=al_id_salida AND TAPEAS.nombre_tabla = 'almin.tal_salida' AND TARPEN.estado= TAPEAS.estado AND TARPEN.estado='Pendiente'
                       AND ((g_id_usuario_firma=pm_id_usuario) OR (g_bandera=1));

                       IF(g_id_tarea_pendiente>0) THEN
                          SELECT TARPEN.id_tarea_pendiente INTO g_id_tarea_pendiente
                          FROM sss.tsg_tarea_pendiente_asignador TAPEAS
                          INNER JOIN sss.tsg_tarea_pendiente TARPEN ON TARPEN.id_tarea_pendiente= TAPEAS.id_tarea_pendiente
                          WHERE TAPEAS.id_registro=al_id_salida AND TAPEAS.estado like 'Pendiente' AND TAPEAS.nombre_tabla like 'almin.tal_salida' AND
                          TARPEN.id_usuario_asignado=g_id_usuario_firma AND TARPEN.id_subsistema=g_id_subsistema AND  TARPEN.estado= TAPEAS.estado AND TARPEN.estado = 'Pendiente';

                          UPDATE almin.tal_salida SET
                          estado_salida           = 'Borrador',
                          observaciones = al_observaciones,
                          fecha_aprobado_rechazado = now()
                          WHERE almin.tal_salida.id_salida= al_id_salida;

                          UPDATE sss.tsg_tarea_pendiente
                          SET estado='Concluida',
                          fecha_concluido_anulado=now()
                          WHERE id_tarea_pendiente=g_id_tarea_pendiente;

                          UPDATE sss.tsg_tarea_pendiente_asignador set estado='Concluida'
                          where id_registro=al_id_salida AND id_tarea_pendiente= g_id_tarea_pendiente AND nombre_tabla = 'almin.tal_salida';

                          -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
                          g_descripcion_log_error := 'Rechazo realizado satisfactoriamente';
                          g_respuesta := 't'||g_separador||g_descripcion_log_error;
                       ELSE
                           g_descripcion_log_error := 'Tarea Pendiente no finalizada: No le corresponde enviar a corregir esta solicitud';
                           g_nivel_error := '4';
                           g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                           RETURN 'f'||g_separador||g_respuesta;
                       END IF;
                 ELSE
                     g_descripcion_log_error := 'Finalización no realizada: La firma de Autorización no pertenece a un usuario valido';
                     g_nivel_error := '4';
                     g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                     RETURN 'f'||g_separador||g_respuesta;
                 END IF;
   END;
   ELSIF pm_codigo_procedimiento = 'AL_SALIDA_FIN' THEN
     BEGIN
            g_bandera:=0;
            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida
                          WHERE almin.tal_salida.id_salida=al_id_salida) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Solicitud de Finalizacion no realizada: registro en almin.tal_salida inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

          --VERIFICA SI EL ESTADO DE LA ORDEN DE INGRESO ES BORRADOR
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida
                          WHERE almin.tal_salida.id_salida=al_id_salida
                          AND estado_salida='Entregado') THEN

                g_descripcion_log_error := 'Solicitud de Finalizacion no realizada: La Orden de Salida no está en estado Entregado';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

         --concluir alerta de finalizacion de salida de material, excepto si se trata de una salida producto de una baja, porque no se crearon alertas


            --no viene de una baja ==> se debió crear una alerta para finalizar salida de material
            SELECT USUARI.id_usuario INTO g_id_usuario_almacen
            FROM sss.tsg_usuario USUARI
            INNER JOIN kard.tkp_empleado EMPLEA ON USUARI.id_persona=EMPLEA.id_persona
            INNER JOIN almin.tal_responsable_almacen RESALM ON RESALM.id_empleado= EMPLEA.id_empleado AND RESALM.estado = 'activo'
            INNER JOIN almin.tal_salida SALIDA ON SALIDA.id_responsable_almacen = RESALM.id_responsable_almacen
            WHERE SALIDA.id_salida= al_id_salida ;

            IF(g_id_usuario_almacen>0) THEN
            --bandera=1 si el usuario es administrador del Sistema, donde rol=1
               SELECT 1 INTO g_bandera FROM sss.tsg_usuario USUARI INNER JOIN sss.tsg_usuario_rol USUROL
               ON USUARI.id_usuario=USUROL.id_usuario
               WHERE USUARI.id_usuario=pm_id_usuario AND USUROL.id_rol=1;


                  SELECT TARPEN.id_tarea_pendiente INTO g_id_tarea_pendiente
                  FROM sss.tsg_tarea_pendiente TARPEN
                  INNER JOIN sss.tsg_tarea_pendiente_asignador TAPEAS ON TARPEN.id_tarea_pendiente= TAPEAS.id_tarea_pendiente
                  WHERE TARPEN.id_subsistema = g_id_subsistema AND
                  TAPEAS.id_registro=al_id_salida AND TAPEAS.nombre_tabla = 'almin.tal_salida' AND TARPEN.estado= TAPEAS.estado AND TARPEN.estado='Pendiente'
                  AND ((g_id_usuario_almacen=pm_id_usuario) OR (g_bandera=1));
        
                  IF (g_id_tarea_pendiente>0) THEN

                       IF NOT EXISTS (SELECT DISTINCT 1 FROM almin.tal_salida WHERE id_motivo_salida_cuenta  IN (SELECT id_motivo_salida_cuenta FROM almin.tal_motivo_salida_cuenta MOSACU INNER JOIN almin.tal_motivo_salida MOTSAL ON MOTSAL.id_motivo_salida= MOSACU.id_motivo_salida AND MOTSAL.nombre like 'Baja') AND id_salida= al_id_salida) THEN
                            UPDATE almin.tal_salida SET
                             estado_salida           = 'Finalizado',
                            fecha_finalizado_cancelado = now()
                            WHERE almin.tal_salida.id_salida= al_id_salida;

                            OPEN g_cursor_sal_det(al_id_salida);
                                   LOOP
                                    FETCH g_cursor_sal_det INTO g_registros;
                                    EXIT WHEN NOT FOUND;
    
                                    UPDATE almin.tal_salida_detalle SET costo= g_registros.costo_unitario * g_registros.cant_consolidada
                                    WHERE id_salida_detalle= g_registros.id_salida_detalle AND id_item=g_registros.id_item AND id_salida= g_registros.id_salida AND  id_salida=al_id_salida AND estado_item=g_registros.estado_item;
                                 END LOOP;
                            CLOSE g_cursor_sal_det;
                        ELSE
                            --vino de una baja
                            UPDATE almin.tal_salida SET
                            estado_salida           = 'Finalizado',
                            fecha_finalizado_cancelado = now()
                            WHERE almin.tal_salida.id_salida= al_id_salida;
                        END IF;

                        UPDATE sss.tsg_tarea_pendiente
                        SET estado='Concluida',
                        fecha_concluido_anulado=now()
                        WHERE id_tarea_pendiente=g_id_tarea_pendiente;

                        UPDATE sss.tsg_tarea_pendiente_asignador set estado='Concluida'
                        where id_registro=al_id_salida AND id_tarea_pendiente= g_id_tarea_pendiente AND nombre_tabla = 'almin.tal_salida';

                        -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
                        g_descripcion_log_error := 'finalizacion realizada satisfactoriamente';
                        g_respuesta := 't'||g_separador||g_descripcion_log_error;
                ELSE
                      g_descripcion_log_error := 'Finalización no realizada: Se quiere finalizar una tarea que no fue creada o no le corresponde efectuar esta solicitud';
                      g_nivel_error := '4';
                      g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                      RETURN 'f'||g_separador||g_respuesta;
                END IF;
           ELSE
               g_descripcion_log_error := 'Finalización no realizada: No le corresponde finalizar esta solicitud ';
               g_nivel_error := '4';
               g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
               RETURN 'f'||g_separador||g_respuesta;
           END IF;
    END;
  ELSIF pm_codigo_procedimiento = 'AL_SALIDA_CON' THEN

    BEGIN
            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida
                          WHERE almin.tal_salida.id_salida=al_id_salida) THEN

                g_nivel_error := '4';
                g_descripcion_log_error := 'Solicitud de Consolidacion no realizada: registro en almin.tal_salida inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;

          --VERIFICA SI EL ESTADO DE LA ORDEN DE INGRESO ES PROVISIONAL
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida
                          WHERE almin.tal_salida.id_salida=al_id_salida
                          AND estado_salida='Provisional') THEN

                g_descripcion_log_error := 'Solicitud de Consolidacion no realizada: La Orden de Salida no está en estado Provisional';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;
            --VERIFICA SI EL DATO DE CANT CAONSOLIDADA ES DISTINTO DE 0
            IF EXISTS (SELECT 1 FROM almin.tal_salida_detalle
                          WHERE almin.tal_salida_detalle.id_salida=al_id_salida
                          AND cant_consolidada=0) THEN

                g_descripcion_log_error := 'Solicitud de Consolidacion no realizada: Antes debe Consolidar todas las Cantidades en su Detalle';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;


            UPDATE almin.tal_salida SET
                  estado_salida = 'Entregado',
                  fecha_entregado = now(),
                  fecha_consolidado= now()
                  WHERE almin.tal_salida.id_salida= al_id_salida;
        
                  OPEN g_cursor_sal_det(al_id_salida);
                        LOOP
                          FETCH g_cursor_sal_det INTO g_registros;
                          EXIT WHEN NOT FOUND;
        
                          UPDATE almin.tal_salida_detalle set
                          fecha_entregada = now(),
                          fecha_consolidada= now()
                          where id_salida_detalle=g_registros.id_salida_detalle and id_salida=al_id_salida and id_item=g_registros.id_item AND estado_item=g_registros.estado_item;
                      END LOOP;
                  CLOSE g_cursor_sal_det;

         --alerta para finalizar salida de material
            SELECT USUARI.id_usuario INTO g_id_usuario_almacen
            FROM sss.tsg_usuario USUARI
            INNER JOIN kard.tkp_empleado EMPLEA ON USUARI.id_persona=EMPLEA.id_persona
            INNER JOIN almin.tal_responsable_almacen RESALM ON RESALM.id_empleado= EMPLEA.id_empleado AND RESALM.estado = 'activo'
            INNER JOIN almin.tal_salida SALIDA ON SALIDA.id_responsable_almacen = RESALM.id_responsable_almacen
            WHERE SALIDA.id_salida= al_id_salida;

            IF (g_id_usuario_almacen>0) THEN


                   SELECT NEXTVAL('sss.tsg_tarea_pendiente_id_tarea_pendiente_seq') INTO g_id_tarea_pendiente;

                   INSERT INTO sss.tsg_tarea_pendiente (id_tarea_pendiente, id_usuario_asignado, id_subsistema, tarea, descripcion,codigo_procedimiento,estado,fecha_reg)
                   VALUES (g_id_tarea_pendiente, g_id_usuario_almacen, g_id_subsistema, 'Finalizar Salida','Realizar la finalización de Pedido de Material','AL_SALFIN','Pendiente',now());

                    INSERT INTO sss.tsg_tarea_pendiente_asignador(nombre_tabla, id_registro, estado, id_tarea_pendiente)
                   VALUES ('almin.tal_salida', al_id_salida, 'Pendiente', g_id_tarea_pendiente);
           ELSE
                    g_descripcion_log_error := 'Finalización no realizada: El almacenero no pertenece a un usuario valido';
                    g_nivel_error := '4';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                    RETURN 'f'||g_separador||g_respuesta;
           END IF;

       -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Rechazo realizado satisfactoriamente';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;

    --ELSIF pm_codigo_procedimiento = 'AL_SALIDA_VER' THEN
     --Verifica si hay las existencias suficientes; de ser así reserva el material
                             /*OPEN g_cursor_pedido_tuc(al_id_salida);
            
                             LOOP
                                 FETCH g_cursor_sal_det INTO g_reg_pedido_tuc;
                                 EXIT WHEN NOT FOUND;

                                 SELECT
                                 SUM(KARLOG.cantidad),
                                 (SELECT cantidad
                                  FROM almin.tal_kardex_logico
                                  WHERE id_almacen_logico = g_reg_pedido_tuc.id_almacen_logico
                                  AND id_item = g_reg_pedido_tuc.id_item
                                  AND id_parametro_almacen = g_id_parametro_almacen
                                  AND estado_item = 'Nuevo') as nuevo,
                                 (SELECT cantidad
                                  FROM almin.tal_kardex_logico
                                  WHERE id_almacen_logico = g_reg_pedido_tuc.id_almacen_logico
                                  AND id_item = g_reg_pedido_tuc.id_item
                                  AND id_parametro_almacen = g_id_parametro_almacen
                                  AND estado_item = 'Usado') as usado
                                 INTO g_total, g_nuevo, g_usado
                                 FROM almin.tal_kardex_logico KARLOG
                                 WHERE KARLOG.id_almacen_logico = g_reg_pedido_tuc.id_almacen_logico
                                 AND KARLOG.id_item = g_reg_pedido_tuc.id_item
                                 AND KARLOG.id_parametro_almacen = g_id_parametro_almacen;

                                 --Reparte las cantidades
                                 OPEN g_cursor();
                                 LOOP
                                     FETCH g_cursor INTO g_reg;
                                     EXIT WHEN NOT FOUND;

                                     IF g_nuevo > 0 AND g_usado > 0 THEN
                                         IF g_nuevo >= g_reg.cantidad_solicitada THEN
                                             --Actualiza las cantidades
                                             UPDATE almin.tal_pedido_tuc_int SET
                                             nuevo = cantidad_solicitada,
                                             usado = 0
                                             WHERE id_pedido_tuc_int = g_reg.id_pedido_tuc_int;
                                             --Resta la cantidad asignada en g_nuevo
                                             g_nuevo = g_nuevo - g_reg.cantidad_solicitada;
                                         ELSE
                                             IF g_usado >= g_reg.cantidad_solicitada - g_nuevo THEN
                                                 --Actualiza las cantidades
                                                 UPDATE almin.tal_pedido_tuc_int SET
                                                 nuevo = g_nuevo,
                                                 usado = g_reg.cantidad_solicitada - g_nuevo
                                                 WHERE id_pedido_tuc_int = g_reg.id_pedido_tuc_int;
                                                 --Resta la cantidad asignada en g_usado
                                                 g_usado = g_usado - g_reg.cantidad_solicitada - g_nuevo;
                                             ELSE
                                                 --Actualiza las cantidades
                                                 UPDATE almin.tal_pedido_tuc_int SET
                                                 nuevo = g_nuevo,
                                                 usado = g_usado
                                                 WHERE id_pedido_tuc_int = g_reg.id_pedido_tuc_int;
                                                 --Resta la cantidad asignada en g_nuevo
                                                 g_usado = 0;
                                             END IF;
                                             --Actualiza g_nuevo
                                             g_nuevo = 0;
                                         END IF;
                                     ELSE
                                         --No hay existencias, se hace update a las cantidades a cero
                                         --Actualiza las cantidades
                                         UPDATE almin.tal_pedido_tuc_int SET
                                         nuevo = 0,
                                         usado = 0
                                         WHERE id_pedido_tuc_int = g_reg.id_pedido_tuc_int;

                                     END IF;

                                 END LOOP;

                                 CLOSE g_cursor;

                                 IF g_total >= g_reg_pedido_tuc.cantidad_solicitada THEN
                                     --Reserva la cantidad de Items requeridos
                                     UPDATE almin.tal_kardex_logico SET
                                     WHERE id_almacen_logico =
                                     AND id_item =
                                     AND id_parametro_almacen
                                     AND estado_item =
                                 ELSE
                                     --No reserva nada
                                 END IF;

                             END LOOP;

                             CLOSE g_cursor_pedido_tuc;*/
                             
    /************************************
     codigo: 	AL_SAPROY_FIN
     fecha: 	30/11/2016
     autor: 	RAC
     desc:		- no permite los saiadas sin existencias
     			- calculo de salida segun promedio ponderado
                - TODO   realizar salida  en la gestion abierta
     **************************************/

    ELSIF pm_codigo_procedimiento = 'AL_SAPROY_FIN' THEN --Finalizar Salida Proyectos
   
    	BEGIN
            g_bandera:=0; 
            
           
            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida
                          WHERE id_salida=al_id_salida) THEN
                g_nivel_error := '4';
                g_descripcion_log_error := 'Finalización no realizada: Pedido inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;

          	--VERIFICA SI EL ESTADO DE LA ORDEN DE INGRESO ES BORRADOR
            IF EXISTS(SELECT 1 FROM almin.tal_salida
                          WHERE id_salida=al_id_salida
                          AND estado_salida='Finalizado') THEN
                g_descripcion_log_error := 'Finalización no realizada: El Pedido no está en Borrador';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;

        	--SE OBTIENE EL ALMACEN LOGICO
            SELECT id_almacen_logico
            INTO g_id_almacen_logico
            FROM almin.tal_salida
            WHERE id_salida = al_id_salida;
                  
            -- Obtiene el correlativo de la SALIDA
            g_correl = almin.f_al_obtener_correlativo('SALIDA',to_char(COALESCE(al_fecha_borrador,now()),'mm'),g_id_almacen_logico);
            IF g_correl = -1 THEN
                g_nivel_error := '3';
                g_descripcion_log_error := 'Salida no registrada: No se pudo obtener el correlativo';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                         pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                         pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
            END IF;
            
            
            
            -- VERIFICA SI LA SALIDA ES DE UNA TRANSFERENCIA SE OBTIENE EL ID
            -- DE LA TRANSFERENCIA
            IF EXISTS(SELECT 1
                      FROM almin.tal_transferencia
                      WHERE id_salida = al_id_salida) THEN

                  g_transf:=TRUE;
                

                 SELECT 
                    t.id_transferencia,
                    t.fecha_borrador,
                    t.id_motivo_ingreso_cuenta
                 INTO 
                    g_id_transferencia,
                    g_fecha_trans,
                    g_id_motivo_ingreso_cuenta
                 FROM almin.tal_transferencia t
                 WHERE id_salida = al_id_salida;
                 
                 g_gestion_tran=  date_part('year', g_fecha_trans::Date)::varchar;
                 
            END IF;
            --*********** FIN RAC 26/11/2016
            
           
			
            IF NOT EXISTS (SELECT DISTINCT 1 FROM almin.tal_salida
                           WHERE id_motivo_salida_cuenta IN (SELECT id_motivo_salida_cuenta
                                                             FROM almin.tal_motivo_salida_cuenta MOSACU
                                                             INNER JOIN almin.tal_motivo_salida MOTSAL
                                                             ON MOTSAL.id_motivo_salida= MOSACU.id_motivo_salida
                                                             AND MOTSAL.nombre LIKE 'Baja')
                			AND id_salida = al_id_salida) THEN

                UPDATE almin.tal_salida SET
                  estado_salida              = 'Finalizado',
                  fecha_finalizado_cancelado = now(),    --TODO , RAC  sise hace en una fecah de  a siguiente gestion forzar al 31 de diciembre
                  correlativo_sal            = g_correl,
                  fecha_finalizado_exacta = now()
                WHERE id_salida= al_id_salida;   
                            
                --SE OBTIENE EL ALMACEN LOGICO
                SELECT id_almacen_logico
                INTO g_id_almacen_logico
                FROM almin.tal_salida
                WHERE id_salida = al_id_salida;
                
             

                OPEN g_cursor_sal_det(al_id_salida);
                LOOP
                    FETCH g_cursor_sal_det INTO g_registros;
                    EXIT WHEN NOT FOUND;
                    
                    --RAC 26/11/2016
                    SELECT 
                       cantidad, costo_unitario, id_kardex_logico, k.costo_total
                    into
                        g_cant, g_costo_unit, g_id_kardex_logico, g_costo_total_kardex
                    FROM almin.tal_kardex_logico k 
                    WHERE id_item = g_registros.id_item
                    AND estado_item = g_registros.estado_item
                    AND id_almacen_logico = g_id_almacen_logico
                    AND id_parametro_almacen = g_id_parametro_almacen;
                    
                    
                    IF g_id_kardex_logico is null THEN
                      raise exception 'no se encontro kardex logico para el item %',g_registros.id_item;  
                    END IF;
                    
                    If ROUND(coalesce(g_registros.cant_entregada,0),2) > g_cant THEN
                       select  
                           (i.codigo||'-'|| i.nombre)::varchar
                       into
                        	v_desc_item
                       from almin.tal_item i
                       where i.id_item = g_registros.id_item;
                      raise EXCEPTION  'La cantidad en existencia del item (id: %, %) no es suficiente para realizar la salida, solo tenemos % y usted requiere %',g_registros.id_item,v_desc_item,g_cant,ROUND(coalesce(g_registros.cant_entregada,0),2); 
                    END IF;
                    
                    
                    UPDATE almin.tal_salida_detalle  SET
                    cant_consolidada = ROUND(coalesce(g_registros.cant_entregada,0),2),
                    costo_unitario = g_costo_unit,
                    costo = g_costo_unit * g_registros.cant_entregada
                    WHERE id_salida_detalle= g_registros.id_salida_detalle
                    AND id_item = g_registros.id_item
                    AND id_salida= g_registros.id_salida
                    AND id_salida=al_id_salida
                    AND estado_item=g_registros.estado_item;
                    
                   
                    
                    g_cant_tot := g_cant - ROUND(coalesce(g_registros.cant_entregada,0),2); 
                    g_nuevo_costo_tot = g_costo_total_kardex - (g_costo_unit * g_registros.cant_entregada);
                    g_nuevo_costo_unit =   ROUND(coalesce(g_nuevo_costo_tot / g_cant_tot,0),2);       
                                              
                  
                    UPDATE almin.tal_kardex_logico SET
                        cantidad = ROUND(g_cant_tot,2),
                        costo_unitario = ROUND(COALESCE(g_nuevo_costo_unit,0),2),
                        costo_total = ROUND(COALESCE(g_nuevo_costo_tot,0),2)
                    WHERE id_kardex_logico = g_id_kardex_logico;
                    
                    ----------------------------------------------------
                    --  Si es transferencia ajustamos los costos ..
                    -------------------------------------------------------
                    IF g_transf THEN
                       
                         UPDATE  almin.tal_transferencia_det set
                           costo_unitario = g_costo_unit,
                           costo = g_costo_unit*cantidad
                         WHERE id_transferencia = g_id_transferencia 
                                and id_item = g_registros.estado_item;  
                    
                    END IF;                                               
                    -- FIN RAC
                                        
                END LOOP;
           
                CLOSE g_cursor_sal_det;
                
              
                
           ------------------------------------------------
           --  VERIFICA SI LA SALIDA ES POR TRANSFERENCIA
           ------------------------------------------------
                
            IF g_transf THEN -- debe generarse un ingreso
                             
                                    -- CREA EL INGRESO Y CAMBIA EL ESTADO A LA TRANSFERENCIA
                                     --OBTIENE LOS DATOS DE LA TRANSFERENCIA
                                     SELECT
                                     *
                                     INTO g_registro
                                     FROM almin.tal_transferencia
                                     WHERE id_transferencia = g_id_transferencia;
                    
                                    --OBTIENE EL COSTO TOTAL DEL DETALLE DE LA TRANSFERENCIA
                                     SELECT
                                     SUM(costo)
                                     INTO g_costo_total
                                     FROM almin.tal_transferencia_det
                                     WHERE id_transferencia = g_id_transferencia;
                                     
                                     --SE VERIFICA SI EL ALMACÉN ESTÁ BLOQUEADO O CERRADO
                                    IF almin.f_al_verificar_almacen_cerrado('logico',g_registro.id_almacen_logico_destino) THEN

                                        g_nivel_error := '3';
                                        g_descripcion_log_error := 'Orden de ingreso no almacenada: El Almacén Destino se encuentra Bloqueado o Cerrado.';
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
                                     WHERE ALMLOG.id_almacen_logico = g_registro.id_almacen_logico_destino;
                                     

                                     -- SE OBTIENE LA FIRMA AUTORIZADA CORRESPONDIENTE para el ingreso por transferencia
                                     SELECT
                                     FIRAUT.id_firma_autorizada
                                     INTO g_id_firma_autorizada
                                     FROM almin.tal_firma_autorizada FIRAUT
                                     INNER JOIN almin.tal_almacen_logico ALMLOG
                                     ON ALMLOG.id_almacen_ep = FIRAUT.id_almacen_ep
                                     INNER JOIN almin.tal_motivo_ingreso MOTING
                                     ON MOTING.id_motivo_ingreso = FIRAUT.id_motivo_ingreso AND MOTING.estado_registro='activo'
                                     INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
                                     ON MOINCU.id_motivo_ingreso = MOTING.id_motivo_ingreso
                                     WHERE ALMLOG.id_almacen_logico = g_registro.id_almacen_logico
                                     AND MOINCU.id_motivo_ingreso_cuenta = g_registro.id_motivo_ingreso_cuenta
                                     AND FIRAUT.estado_reg = 'activo'
                                     ORDER BY FIRAUT.prioridad ASC, FIRAUT.id_firma_autorizada ASC
                                     LIMIT 1;
                                     
                                     -- OBTIENE LA GESTIÓN VIGENTE
                                     --TODO  agregar validacion de cierre por departamento logico
                                     -- en transferencias validar que ambos almacenes stesn abiertos ......
                                    
                                    SELECT id_parametro_almacen
                                    INTO g_id_parametro_almacen
                                    FROM almin.tal_parametro_almacen
                                    WHERE cierre = 'no';
                                    
                                    IF  g_id_parametro_almacen is null THEN
                                       raise exception 'no se encontro parametros gestion para abierto para el almacesn ';
                                    END IF;

                                     IF (g_id_firma_autorizada>0) THEN  -- es posible registrar el ingreso
                                     
                                        
                                             -- SE OBTIENE LA EP DE LA TRANSFERENCIA
                                             SELECT
                                             MOINCU.id_fina_regi_prog_proy_acti
                                             INTO g_id_fina_regi_prog_proy_acti
                                             FROM almin.tal_transferencia TRANSF
                                             INNER JOIN almin.tal_motivo_ingreso_cuenta MOINCU
                                             ON MOINCU.id_motivo_ingreso_cuenta = TRANSF.id_motivo_ingreso_cuenta
                                             WHERE id_transferencia = g_id_transferencia;

                                            


                                             --OBTIENE EL ÚLTIMO VALOR DE LA SECUENCIA PARA INSERTAR EL INGRESO
                                                SELECT NEXTVAL('almin.tal_ingreso_id_ingreso_seq') INTO g_id_ingreso;
            
                                            --CREACIÓN DE INGRESO
                                                 INSERT INTO almin.tal_ingreso(id_ingreso,
                                                 descripcion,
                                                 costo_total               ,contabilizar               ,estado_ingreso                         ,estado_registro,
                                                 fecha_borrador            ,fecha_pendiente            ,fecha_aprobado_rechazado               ,id_responsable_almacen,
                                                 id_proveedor              ,id_contratista             ,id_empleado                            ,id_almacen_logico,    
                                                 id_firma_autorizada       ,id_institucion             ,id_motivo_ingreso_cuenta,
                                                 fecha_ing_fisico          ,fecha_ing_valorado         ,fecha_finalizado_cancelado,
                                                 orden_compra              ,observaciones              ,id_usuario                             ,id_parametro_almacen,
                                                 circuito
                                                 ) VALUES ( g_id_ingreso,
                                                 g_registro.descripcion,
                                                 g_costo_total             ,g_contabilizar             ,'Aprobado'                             ,'activo',
                                                 now()                     ,now()                      ,now()                                  ,g_id_responsable_almacen,
                                                 NULL                      ,NULL                       ,g_registro.id_empleado                 ,g_registro.id_almacen_logico_destino,
                                                 g_id_firma_autorizada     ,NULL                       ,g_id_motivo_ingreso_cuenta,
                                                 NULL                      ,NULL                       ,NULL,
                                                 NULL                      ,g_registro.observaciones   ,pm_id_usuario                          ,g_id_parametro_almacen,
                                                 'Simplificado'
                                                 );

                                            -- CREACIÓN DEL DETALLE
                                                   INSERT INTO almin.tal_ingreso_detalle(
                                                   costo             ,costo_unitario  ,precio_venta  ,cantidad,
                                                   id_item           ,id_ingreso      ,estado_item)
                                                   SELECT
                                                   costo             ,costo_unitario  ,precio_unitario  ,cantidad,
                                                   id_item           ,g_id_ingreso    ,estado_item
                                                   FROM almin.tal_transferencia_det
                                                   WHERE id_transferencia = g_id_transferencia;

                                            -- HACER UPDATE TRANSFERENCIA PARA RELACIONAR EL ID INGRESO
                                                  IF NOT g_prestamo THEN --solo transferencia
                                                  --TODO: VERIFICAR CASO PRÉSTAMOS
                                                     UPDATE almin.tal_transferencia SET
                                                            estado_transferencia = 'Pendiente_ingreso',
                                                            id_ingreso           = g_id_ingreso,
                                                            fecha_pendiente_ing  = now()
                                                            WHERE id_transferencia = g_id_transferencia;
                                                  ELSE -- es prestamo
                                                        UPDATE almin.tal_transferencia SET
                                                        estado_transferencia   = 'Ingreso_prestamo',
                                                        id_ingreso_prestamo    = g_id_ingreso,
                                                        fecha_ingreso_prestamo = now()
                                                        WHERE id_transferencia = g_id_transferencia;
                                                  END IF;-- SI NO ES PRESTAMO
                                                   g_descripcion_log_error := 'Modificación exitosa en almin.tal_salida';
                                                   g_respuesta := 't'||g_separador||g_descripcion_log_error;

                             ELSE
                                 g_nivel_error := '3';
                                 g_descripcion_log_error := 'Modificación no realizada: No existe una firma autorizada para ingresos por transferencia';
                                 g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                                --no exsiste responsable de autorizar ingresos por transferen
                             END IF;


            --*********** CÓDIGO RCM 05-12-2007
            END IF; -- no es transferencia
                
                
                --ACTUALIZAR EL CORRELATIVO
                 g_resp_act_correl := almin.f_al_actualizar_correlativo('SALIDA',to_char(COALESCE(al_fecha_borrador,now()),'mm'),g_id_almacen_logico);
            ELSE
            	--vino de una baja
                UPDATE almin.tal_salida SET
                estado_salida           = 'Finalizado',
                fecha_finalizado_cancelado = now()
            	WHERE almin.tal_salida.id_salida= al_id_salida;
        
        	END IF;

       		-- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
        	g_descripcion_log_error := 'finalizacion realizada satisfactoriamente';
        	g_respuesta := 't'||g_separador||g_descripcion_log_error;

    	END;
     /************************************
     codigo: 	AL_SAPRUC_FIN
     fecha: 	30/11/2016
     autor: 	RAC
     desc:		- no permite salida sin existencias
     			- calculo de salida segun promedio ponderado
                - TODO   realizar la salida  en la gestion abierta
     **************************************/
    ELSIF pm_codigo_procedimiento = 'AL_SAPRUC_FIN' THEN --Finalizar Salida Proyectos Unidades Constructivas
        BEGIN
          
        --RCM : Para terminar salidas de gestion 2008  (22/01/2009)
        
                
            g_bandera:=0;
            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida
                          WHERE id_salida=al_id_salida) THEN
                g_nivel_error := '4';
                g_descripcion_log_error := 'Finalización no realizada: Pedido inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;

          	--VERIFICA SI EL ESTADO DE LA ORDEN DE INGRESO ES BORRADOR
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida
                          WHERE id_salida=al_id_salida
                          AND estado_salida='Borrador') THEN
                g_descripcion_log_error := 'Finalización no realizada: El Pedido no está en Borrador';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;
            
            --VERIFICA QUE YA SE HAYA HECHO LA VERIFICACION DE LA UNIDAD CONSTRUCTIVA
            IF NOT EXISTS(SELECT 1 FROM almin.tal_pedido_tuc_int
                          WHERE id_salida=al_id_salida) THEN
                g_descripcion_log_error := 'Finalización no realizada: Debe realizar la verificacion de existencias previamente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;
            
             --VERIFICA QUE YA SE HAYA HECHO LA VERIFICACION DE LA UNIDAD CONSTRUCTIVA
            IF EXISTS(SELECT 1 FROM almin.tal_pedido_tuc_int
                      WHERE id_salida = al_id_salida
                      AND cantidad_solicitada + demasia > nuevo + usado ) THEN
                g_descripcion_log_error := 'Finalización no realizada: La salida no puede ser finalizada porque hay materiales faltantes.\n Vea el Reporte de Faltantes.';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;

         	--SE OBTIENE EL ALMACEN LOGICO
            SELECT id_almacen_logico
            INTO g_id_almacen_logico
            FROM almin.tal_salida
            WHERE id_salida = al_id_salida;
            
            --VERIFICA SI VIENE O NO DE UN PROCESO DE BAJA      
            IF NOT EXISTS (SELECT DISTINCT 1 FROM almin.tal_salida
                           WHERE id_salida = al_id_salida
                           AND id_motivo_salida_cuenta IN (SELECT id_motivo_salida_cuenta
                                                           FROM almin.tal_motivo_salida_cuenta MOSACU
                                                           INNER JOIN almin.tal_motivo_salida MOTSAL
                                                           ON MOTSAL.id_motivo_salida= MOSACU.id_motivo_salida
                                                           AND MOTSAL.nombre LIKE 'Baja')) THEN
                                       
				--06/12/2011: Obtiene la fecha borrador
                SELECT fecha_borrador
                INTO g_fecha_borrador
                FROM almin.tal_salida
                WHERE id_salida = al_id_salida;
                
            	-- Obtiene el correlativo de la SALIDA
                g_correl = almin.f_al_obtener_correlativo('SALIDA',to_char(COALESCE(g_fecha_borrador,now()),'mm'),g_id_almacen_logico);
                
                IF g_correl = -1 THEN
                    g_nivel_error := '3';
                    g_descripcion_log_error := 'Salida no registrada: No se pudo obtener el correlativo';
                    g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                    --REGISTRA EL LOG
                    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                             pm_codigo_procedimiento   ,pm_proc_almacenado);

                    --DEVUELVE MENSAJE DE ERROR
                    RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
                END IF;
				
                --FINALIZA LA SALIDA
                UPDATE almin.tal_salida  SET
                  estado_salida              = 'Finalizado',
                  fecha_finalizado_cancelado = now(),
                  fecha_finalizado_exacta = now(),
                  correlativo_sal            = g_correl
                WHERE id_salida= al_id_salida;

                --INSERTA TODO EL MATERIAL A tal_salida_detalle
                SELECT fecha_borrador INTO g_fecha_borrador
                FROM almin.tal_salida
                WHERE id_salida = al_id_salida;
                              
                OPEN g_cursor_pedido_tuc_pr(al_id_salida);
                LOOP
                    FETCH g_cursor_pedido_tuc_pr INTO g_datos;
                    EXIT WHEN NOT FOUND;
                                
                    INSERT INTO almin.tal_salida_detalle(
                    cant_solicitada                       ,cant_entregada                    ,cant_consolidada,
                    fecha_solicitada                      ,id_item                           ,id_salida,
                    estado_item                           ,cant_demasia
                    ) VALUES (
                    g_datos.cantidad_total_solicitada     ,g_datos.cantidad_total_solicitada ,g_datos.cantidad_total_solicitada,
                    g_fecha_borrador                      ,g_datos.id_item                   ,g_datos.id_salida,
                    'Nuevo'                               ,g_datos.cant_demasia
                    );
                                
                END LOOP;
                CLOSE g_cursor_pedido_tuc_pr;

                --RECORRE EL DETALLE DE LA SALIDA
                OPEN g_cursor_sal_det(al_id_salida);
                LOOP
                    FETCH g_cursor_sal_det INTO g_registros;
                    EXIT WHEN NOT FOUND;
                    
                    --RAC 26/11/2016
                    SELECT 
                       cantidad, costo_unitario, id_kardex_logico, k.costo_total
                    into
                        g_cant, g_costo_unit, g_id_kardex_logico, g_costo_total_kardex
                    FROM almin.tal_kardex_logico k 
                    WHERE id_item = g_registros.id_item
                    AND estado_item = g_registros.estado_item
                    AND id_almacen_logico = g_id_almacen_logico
                    AND id_parametro_almacen = g_id_parametro_almacen;
                    
                    v_total_cant_solicitada =  COALESCE(g_registros.cant_consolidada,0)+COALESCE(g_registros.cant_demasia,0);
                    
                    If ROUND(coalesce(v_total_cant_solicitada,0),2) > g_cant THEN
                       select  
                           (i.codigo||'-'|| i.nombre)::varchar
                       into
                        	v_desc_item
                       from almin.tal_item i
                       where i.id_item = g_registros.id_item;
                      
                      raise EXCEPTION  'La cantidad en existencia del item (id:% , %) no es suficiente para realizar la salida, solo tenemos % y usted requiere %',g_registros.id_item,v_desc_item,g_cant,ROUND(coalesce(g_registros.cant_entregada,0),2); 
                    END IF;
                    
                    
                    
                    UPDATE almin.tal_salida_detalle  SET
                      costo_unitario = g_costo_unit,
                      costo = g_costo_unit * v_total_cant_solicitada
                    WHERE id_salida_detalle= g_registros.id_salida_detalle
                    AND id_item = g_registros.id_item
                    AND id_salida= g_registros.id_salida
                    AND id_salida=al_id_salida
                    AND estado_item=g_registros.estado_item;
                    
                    g_cant_tot := g_cant - ROUND(coalesce(v_total_cant_solicitada,0),2); 
                    g_nuevo_costo_tot = g_costo_total_kardex - (g_costo_unit * v_total_cant_solicitada);
                    g_nuevo_costo_unit =   ROUND(coalesce(g_nuevo_costo_tot / g_cant_tot,0),2);  
                    
                    UPDATE almin.tal_kardex_logico SET
                        cantidad = ROUND(g_cant_tot,2),
                        costo_unitario = ROUND(COALESCE(g_nuevo_costo_unit,0),2),
                        costo_total = ROUND(COALESCE(g_nuevo_costo_tot,0),2)
                    WHERE id_kardex_logico = g_id_kardex_logico;
                    
                    -- FIN RAC
                  


				END LOOP;
                CLOSE g_cursor_sal_det;
                            
                --ACTUALIZAR EL CORRELATIVO
                g_resp_act_correl := almin.f_al_actualizar_correlativo('SALIDA',to_char(COALESCE(g_fecha_borrador,now()),'mm'),g_id_almacen_logico);
            ELSE
                --VIENE DE UNA BAJA
                UPDATE almin.tal_salida SET
                estado_salida           = 'Finalizado',
                fecha_finalizado_cancelado = now()
                WHERE almin.tal_salida.id_salida= al_id_salida;
            END IF;

			--DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Finalizacion realizada satisfactoriamente';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
           
           	--RAISE EXCEPTION 'Finaliza la Salida';
    	END;
    
    --RCM 19-12-2011: modificación de salidas finalizadas pedido por Jorge Rodriguez porque siempre se equivocaba
    ELSIF pm_codigo_procedimiento = 'AL_MOSAFI_INS' THEN 
        BEGIN

            --VERIFICACIÓN DE EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida
                          WHERE id_salida=al_id_salida) THEN
                g_nivel_error := '4';
                g_descripcion_log_error := 'Salida inexistente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
            END IF;
            
            UPDATE almin.tal_salida SET
            descripcion = al_descripcion,
            observaciones = al_observaciones,
            num_contrato = al_num_contrato
            WHERE id_salida = al_id_salida;
            
            --DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificación realizada en la salida finalizada: ' || al_id_salida || ' por el usuario: '|| pm_id_usuario;
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