--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_tal_salida_reporte_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_salida integer,
  al_descripcion varchar,
  al_id_almacen_logico integer
)
RETURNS varchar AS
$body$
/************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ALMACENES (ALMIN)
***************************************************************************
 SCRIPT:         almin.f_tal_salida_reporte_iud
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
    v_sw_faltante				  boolean;
    v_tipo_trans				  varchar;
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
                                      SUM(PEDINT.nuevo) as cant_nuevo,
                                      PEDINT.id_item,
                                      PEDINT.id_salida,
                                      SALIDA.id_almacen_logico,
                                      pedint.sw_autorizado
                                      
                                  FROM almin.tal_pedido_tuc_int PEDINT
                                  INNER JOIN almin.tal_salida SALIDA
                                  ON SALIDA.id_salida = PEDINT.id_salida
                                  WHERE PEDINT.id_salida = ID
                                  GROUP BY PEDINT.id_item,PEDINT.id_salida,
                                  SALIDA.id_almacen_logico,pedint.sw_autorizado;

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
    g_id_parametro_almacen_logico			integer;
    g_id_parametro_almacen_salida			integer;
    g_id_parametro_almacen_logico_salida	integer;
    v_finalizacion_tmp						date;
    g_gestion								integer;
    v_registros				record;
    v_sw_tiene_salida_detalle				boolean;
    g_correlativo_sal		varchar;
	g_nombre_al				varchar;

BEGIN

    ---*** INICIACIÓN DE VARIABLES
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion := 'almin.f_tal_salida_reporte_iud';
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
    
   -- raise exception 'llega';

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

    
    
    IF pm_codigo_procedimiento = 'AL_SALIDAREP_DEL' THEN

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
        
   --procedimiento de modificacion
  /*
  Autor: RAC
  Fecha: 07/12/2016
  Desc:   modificar registro de salida del tipo reporte
  */
   ELSIF pm_codigo_procedimiento = 'AL_PEDIDOREP_UPD' THEN

        BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida
                          WHERE almin.tal_salida.id_salida=al_id_salida) THEN

                g_descripcion_log_error := 'Modificación no realizada: no existe el registro de almin.tal_salida no existente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;

            END IF;


            
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

            UPDATE almin.tal_salida SET
              descripcion                  = al_descripcion,           
              id_almacen_logico            = al_id_almacen_logico,            
              id_parametro_almacen =  g_id_parametro_almacen,
              id_parametro_almacen_logico = g_id_parametro_almacen_logico
            WHERE id_salida = al_id_salida;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificación exitosa en almin.tal_salida';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
      ELSEIF pm_codigo_procedimiento = 'AL_PEDIDOREP_INS' THEN

        BEGIN
        
      
           
            -- OBTIENE LA GESTIÓN VIGENTE
            SELECT 
                pl.id_parametro_almacen,
                pl.id_parametro_almacen_logico
            INTO 
                g_id_parametro_almacen,
                g_id_parametro_almacen_logico
            FROM almin.tal_parametro_almacen_logico pl
            WHERE      pl.estado = 'abierto'
                  and pl.id_almacen_logico = al_id_almacen_logico;

            IF g_id_parametro_almacen IS NULL THEN
                g_nivel_error := '3';
                g_descripcion_log_error := 'Reporte no almacenado No existe una Gestión vigente';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

                --REGISTRA EL LOG
                g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                     pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                     pm_codigo_procedimiento   ,pm_proc_almacenado);

                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
            END IF;

           
            
            INSERT INTO almin.tal_salida( 
            							descripcion,
                                        correlativo_sal,
                                        correlativo_vale,
                                        estado_salida, 
                                        estado_registro,  
                                        id_almacen_logico, 
                                        fecha_borrador, 
                                        id_usuario,
                                        id_parametro_almacen, 
                                        id_parametro_almacen_logico,
                                        tipo_reg)
                                  VALUES ( 
                                  		al_descripcion, 
                                        'rep',
                                        '',
                                    	'Borrador', 
                                        'activo', 
                                    	al_id_almacen_logico, 
                                        now(),
                                        pm_id_usuario, 
                                        g_id_parametro_almacen,                                    
                                        g_id_parametro_almacen_logico,
                                        'reporte');


            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso del Pedido de Material';
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