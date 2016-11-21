--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_tal_valoracion_sel (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  pm_cant integer,
  pm_puntero integer,
  pm_sortcol varchar,
  pm_sortdir varchar,
  pm_criterio_filtro varchar,
  pm_id_financiador varchar,
  pm_id_regional varchar,
  pm_id_programa varchar,
  pm_id_proyecto varchar,
  pm_id_actividad varchar,
  al_id_parametro_almacen integer,
  al_id_fina_regi_prog_proy_acti varchar,
  al_id_almacen_logico varchar,
  al_fecha date
)
RETURNS SETOF record AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ALMACENES
***************************************************************************
 SCRIPT: 		almin.tal_valoracion_sel
 DESCRIPCIÓN: 	Devuelve el Reporte de la Valoración a una fecha
 AUTOR: 		RCM
 FECHA:			27/03/2009
 COMENTARIOS:	
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCIÓN:
 AUTOR:
 FECHA:

***************************************************************************/
--------------------------
-- CUERPO DE LA FUNCIÓN --
--------------------------

-- PARÁMETROS FIJOS
/*
pm_id_usuario                               integer (si))
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


-- DECLARACIÓN DE VARIABLES DE LA FUNCIÓN (LOCALES)

DECLARE

    --PARÁMETROS FIJOS
    g_id_subsistema            integer; -- ID SUBSISTEMA
    g_id_lugar                 integer; -- ID LUGAR
    g_numero_error             varchar; -- ALMACENA EL NÚMERO DE ERROR
    g_mensaje_error            varchar; -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento boolean; -- BANDERA PARA VERIFICAR LLAMADA DE PROCEDIMIENTO
    g_descripcion_log_error    text;    -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento               boolean;
    g_reg_error                boolean;
    g_registros                record;  -- PARA ALMACENAR EL CONJUNTO DE DATOS RESULTADO DEL SELECT
    g_respuesta                varchar; -- VARIABLE QUE CONTENDRÁ LOS MENSAJES DE ERROR
    g_consulta                 text;    -- VARIABLE QUE CONTENDRÁ LA CONSULTA DINÁMICA PARA EL FILTRO
    g_nivel_error              varchar; -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                        --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                        --      ERROR LÓGICO (CRÍTICO) = 2
                                        --      ERROR LÓGICO (INTERMEDIO) = 3
                                        --      ERROR LÓGICO (ADVERTENCIA) = 4
    g_nombre_funcion           varchar; --NOMBRE FÍSICO DE LA FUNCIÓN
    g_separador                varchar(10); --Caracteres que servirán para separar el mensaje, nivel y origen del error
    g_rol_adm                   boolean;    -- Identifica si el usuario tiene rol administrador
    g_saldo                    numeric;
    g_saldo_antes              numeric;
    g_costo_unitario           numeric;
    g_haber                    numeric;
    g_saldo_costo              numeric;
    g_saldo_costo_antes        numeric;
    v_kard_fisico              record;
    v_transaccion_antes        record;
    v_ana                      record;
    g_consulta1                text;
    g_id_item                  integer;
    g_saldo_fis                numeric;
    g_saldo_eco                numeric;
    
    g_registros_1              record;
    g_val_sal                  numeric;
    g_almacen                  varchar;
    g_almacen_log              varchar;  
    g_gestion                  varchar;
    g_fecha                    varchar;
    g_id                       integer;
    g_primera_iteracion        boolean;

BEGIN

    ---*** INICIACIÓN DE VARIABLES
    g_privilegio_procedimiento := FALSE;
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion :='f_tal_valoracion_sel';
    g_rol_adm:= false;
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
    SELECT ul.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar ul
    WHERE  ul.id_usuario = pm_id_usuario;


    ---*** VALIDACIÓN DE LLAMADA POR USUARIO O FUNCIÓN
    IF pm_proc_almacenado IS NOT NULL THEN
        IF NOT EXISTS(SELECT 1 FROM pg_proc WHERE proname = pm_proc_almacenado) THEN
            g_descripcion_log_error := 'Procedimiento ejecutor inexistente';
            g_nivel_error := '2';
            g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

            --REGISTRA EL LOG
            g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario            ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                pm_codigo_procedimiento   ,pm_proc_almacenado);
            --DEVUELVE MENSAJE DE ERROR
         RAISE EXCEPTION '%',g_respuesta;
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
        RAISE EXCEPTION '%',g_descripcion_log_error;
    END IF;      
    
                  
    IF pm_codigo_procedimiento  = 'AL_VALSAL_SEL' THEN
        BEGIN
        
            --1)CREACIÓN DE LAS TABLAS TEMPORALES
            CREATE TEMP TABLE tal_ing_sal_tmp (id          serial,
                                                         id_item     integer,
                                                         fecha       date,
                                                         ingresos    numeric,
                                                         salidas     numeric,
                                                         costo       numeric,
                                                         saldo_fis   numeric,
                                                         saldo_eco   numeric,
                                                         final       varchar,
                                                         almacen     varchar,
                                                         almacen_log varchar,
                                                         fecha_rep   varchar,
                                                         gestion     varchar,
                                                         nombre_item varchar,
                                                         desc_item   varchar,
                                                         un_med_bas  varchar,
                                                         fecha_finalizado_exacta timestamp,
                                                         costo_salida numeric,
                                                         costo_ingreso numeric) ON COMMIT DROP;
                                                    
           CREATE TEMP TABLE tal_valoracion_tmp (id_item     integer,
                                                 saldo_fis   numeric,
                                                 costo_unit  numeric,
                                                 importe     numeric) ON COMMIT DROP;
                                                            
            --2)SE CARGAN LOS INGRESOS Y SALIDAS EN TABLA TEMPORAL
            --Obtiene el almacén  y el almacén ep
            SELECT
              ALMACE.nombre, ALMLOG.nombre
              INTO g_almacen, g_almacen_log
              FROM almin.tal_almacen_logico ALMLOG
              INNER JOIN almin.tal_almacen_ep ALMAEP
              ON ALMAEP.id_almacen_ep = ALMLOG.id_almacen_ep
              INNER JOIN almin.tal_almacen ALMACE
              ON ALMACE.id_almacen = ALMAEP.id_almacen
            WHERE ALMLOG.id_almacen_logico = al_id_almacen_logico; 
            
            --Obtiene la descripción de la gestión
            SELECT  gestion
            INTO g_gestion
            FROM almin.tal_parametro_almacen
            WHERE id_parametro_almacen = al_id_parametro_almacen;
            
            --Formato a la fecha
            g_fecha = to_char(al_fecha,'dd/mm/yyyy');

           
                     
              INSERT INTO tal_ing_sal_tmp(id_item,fecha,ingresos,salidas,costo,nombre_item,desc_item,
              				un_med_bas,almacen,almacen_log,gestion,fecha_rep,fecha_finalizado_exacta,costo_ingreso, costo_salida)
                     SELECT
                        id_item, fecha, ingresos,salidas,costo,nombre_item,desc_item,un_med_bas,
                         g_almacen,g_almacen_log,g_gestion,g_fecha,fecha_finalizado_exacta, costo_ingreso, costo_salida
                     FROM (
                     SELECT
                        INGDET.id_item,
                        INGRES.fecha_finalizado_cancelado as fecha,
                        COALESCE(INGDET.cantidad,0) as ingresos,
                        0 as salidas,
                        COALESCE(INGDET.costo,0) as costo,
                        ITEM.nombre as nombre_item,
                        ITEM.descripcion as desc_item,
                        UNMEBA.abreviatura as un_med_bas,
                        INGRES.fecha_finalizado_exacta,
                        COALESCE(INGDET.costo,0) as  costo_ingreso, 
                        0 as costo_salida
                     FROM almin.tal_ingreso_detalle INGDET
                     INNER JOIN almin.tal_ingreso INGRES ON INGRES.id_ingreso = INGDET.id_ingreso
                     INNER JOIN almin.tal_item ITEM ON ITEM.id_item = INGDET.id_item
                     INNER JOIN param.tpm_unidad_medida_base UNMEBA ON UNMEBA.id_unidad_medida_base = ITEM.id_unidad_medida_base
                     WHERE INGRES.id_parametro_almacen = al_id_parametro_almacen 
                     AND INGRES.estado_ingreso = 'Finalizado'
                     AND INGRES.id_almacen_logico = al_id_almacen_logico 
                     AND INGRES.fecha_finalizado_cancelado <=  al_fecha  ) VAL;     
                     
               
               INSERT INTO tal_ing_sal_tmp(id_item,fecha,ingresos,salidas,costo,nombre_item,desc_item,un_med_bas,almacen,
               								almacen_log,gestion,fecha_rep,fecha_finalizado_exacta,costo_ingreso, costo_salida)
                     SELECT
                     id_item, fecha, ingresos,salidas,costo,nombre_item,desc_item,un_med_bas,
                     g_almacen,g_almacen_log,g_gestion,g_fecha,fecha_finalizado_exacta,costo_ingreso, costo_salida
                     FROM (                                                         
                     SELECT
                     SALDET.id_item,
                     SALIDA.fecha_finalizado_cancelado as fecha,
                     0 as ingresos,
                     COALESCE(SALDET.cant_consolidada,0)+COALESCE(SALDET.cant_demasia,0) as salidas,
                     0 as costo,
                     ITEM.nombre as nombre_item,
                     ITEM.descripcion as desc_item,
                     UNMEBA.abreviatura as un_med_bas,
                     SALIDA.fecha_finalizado_exacta,
                     0 as  costo_ingreso, 
                     COALESCE(saldet.costo ,0) as costo_salida
                     FROM almin.tal_salida_detalle SALDET
                     INNER JOIN almin.tal_salida SALIDA ON SALIDA.id_salida = SALDET.id_salida
                     INNER JOIN almin.tal_item ITEM ON ITEM.id_item = SALDET.id_item
                     INNER JOIN param.tpm_unidad_medida_base UNMEBA ON UNMEBA.id_unidad_medida_base = ITEM.id_unidad_medida_base
                     WHERE SALIDA.id_parametro_almacen = al_id_parametro_almacen
                     AND SALIDA.estado_salida = 'Finalizado'
                     AND SALIDA.id_almacen_logico = al_id_almacen_logico 
                     AND SALIDA.fecha_finalizado_cancelado <= al_fecha::date
                     ) VAL; 
                     
                
            
            
           FOR g_registros in (
                               SELECT
                                  INGSAL.id_item       ,
                                  SUM(INGSAL.ingresos) as ingresos,
                                  SUM(INGSAL.salidas) as salidas,
                                  sum(costo_ingreso) as costo_ingreso,
                                  sum(costo_salida) as costo_salida,
                                
                                  INGSAL.almacen ,
                                  INGSAL.almacen_log ,
                                  INGSAL.fecha_rep  ,
                                  INGSAL.gestion,
                                  INGSAL.nombre_item   ,
                                  INGSAL.desc_item   ,
                                  INGSAL.un_med_bas                               
                                FROM tal_ing_sal_tmp INGSAL
                                INNER JOIN almin.tal_item ITEM ON ITEM.id_item = INGSAL.id_item
                                group by INGSAL.id_item       ,
                                       
                                        INGSAL.almacen ,
                                        INGSAL.almacen_log ,
                                        INGSAL.fecha_rep  ,
                                        INGSAL.gestion,
                                        INGSAL.nombre_item   ,
                                        INGSAL.desc_item   ,
                                        INGSAL.un_med_bas ,
                                        item.id_supergrupo
                                ORDER BY ITEM.id_supergrupo,nombre_item,id_item) LOOP
               
           
            RETURN NEXT g_registros;
           END LOOP;
           RETURN;
           
        
        raise exception 'PASA...';
            g_id=0;
            g_id_item=0;
            g_saldo_fis=0;
            g_saldo_eco=0;
            g_val_sal=0;
            g_costo_unitario=0;
            g_primera_iteracion=true;
            
            --3)SE RECORREN LOS INGRESOS Y SALIDAS Y SE CALCULA EL SALDO FISICO
           
           
            FOR g_registros IN EXECUTE(SELECT * FROM tal_ing_sal_tmp ORDER BY id_item,fecha) LOOP
                
                IF g_id_item <> g_registros.id_item THEN
                    
                    IF NOT g_primera_iteracion  THEN
                        --Actualiza el registro anterior como final
                        UPDATE tal_ing_sal_tmp SET final = 'si' WHERE id = g_id;
                    END IF;
                    
                    g_id_item=g_registros.id_item;
                    g_id = g_registros.id;
                    g_saldo_fis=0;
                    g_saldo_eco=0;
                    g_val_sal=0;
                    g_costo_unitario=0;
                END IF;
                
                IF g_registros.salidas > 0 THEN
                    IF g_saldo_fis <> 0 THEN
                        g_costo_unitario = g_saldo_eco / g_saldo_fis;
                        g_val_sal = g_costo_unitario * g_registros.salidas;
                    END IF;
                    --Actualización del Saldo Económico cuando es Salida
                    g_saldo_eco = g_saldo_eco - g_val_sal;
                ELSE
                    --Actualización del Saldo Económico cuando es Ingreso
                    g_saldo_eco = g_saldo_eco + g_registros.costo;
                END IF;
                
                --Actualización del Saldo Físico
                g_saldo_fis = g_saldo_fis + g_registros.ingresos - g_registros.salidas;
                    
                --Actualización de tabla
                IF g_registros.salidas > 0 THEN
                    --Salidas
                    EXECUTE('UPDATE tal_ing_sal_tmp SET 
                             saldo_fis = '||g_saldo_fis ||',
                             costo = ' || g_val_sal ||',
                             saldo_eco = ' ||g_saldo_eco ||'
                             WHERE id = '||g_registros.id);
                ELSE
                    --Ingresos
                    EXECUTE('UPDATE tal_ing_sal_tmp SET 
                             saldo_fis = '||g_saldo_fis ||',
                             saldo_eco = ' ||g_saldo_eco ||'
                             WHERE id = '||g_registros.id);
                END IF;
            
            END LOOP;
            
            g_consulta = 'SELECT
                         INGSAL.id      ,INGSAL.id_item     ,INGSAL.fecha    ,INGSAL.ingresos,
                         INGSAL.salidas ,INGSAL.costo       ,INGSAL.final    ,INGSAL.almacen,
                         INGSAL.almacen_log                 ,INGSAL.gestion  ,INGSAL.fecha_rep,
                         ITEM.nombre as item,ITEM.descripcion as desc_item,UNMEBA.abreviatura as desc_medida,
                         INGSAL.saldo_fis,
                         CASE COALESCE(INGSAL.saldo_fis,0)
                             WHEN 0 THEN 0
                             ELSE INGSAL.saldo_eco / INGSAL.saldo_fis
                         END as costo_unit,
                         INGSAL.saldo_eco   
                         FROM tal_ing_sal_tmp INGSAL
                         INNER JOIN almin.tal_item ITEM ON ITEM.id_item = INGSAL.id_item
                         INNER JOIN param.tpm_unidad_medida_base UNMEBA ON UNMEBA.id_unidad_medida_base = ITEM.id_unidad_medida_base
                         WHERE final = ''si''';
                         
            g_consulta = 'SELECT
                         INGSAL.id      ,INGSAL.id_item     ,INGSAL.fecha    ,INGSAL.ingresos,
                         INGSAL.salidas ,INGSAL.costo       ,INGSAL.final    ,INGSAL.almacen,
                         INGSAL.almacen_log                 ,INGSAL.gestion  ,INGSAL.fecha_rep,
                         INGSAL.nombre_item,INGSAL.desc_item,INGSAL.un_med_bas,
                         INGSAL.saldo_fis,
                         CASE COALESCE(INGSAL.saldo_fis,0)
                             WHEN 0 THEN 0
                             ELSE INGSAL.saldo_eco / INGSAL.saldo_fis
                         END as costo_unit,
                         INGSAL.saldo_eco   
                         FROM tal_ing_sal_tmp INGSAL
                         WHERE final = ''si''';
            
            FOR g_registros in EXECUTE (g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;
            
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;
 ELSE
        --Procedimiento inexistente
        g_nivel_error := '2';
        g_descripcion_log_error := 'Procedimiento inexistente';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario            ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                            pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                            pm_codigo_procedimiento   ,pm_proc_almacenado);
        --DEVUELVE MENSAJE DE ERROR
        RAISE EXCEPTION '%', g_respuesta;
    END IF;


    ---*** REGISTRO EN EL LOG EL ÉXITO DE LA EJECUCIÓN DEL PROCEDIMIENTO
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);


    ---*** SE DEVUELVE EL CONJUNTO DE DATOS
    RETURN;


EXCEPTION

    WHEN others THEN BEGIN

        --SE OBTIENE EL MENSAJE Y EL NÚMERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
        g_mensaje_error:=SQLERRM;
        g_numero_error:=SQLSTATE;
        g_reg_error:= sss.f_tsg_registro_evento (pm_id_usuario            ,g_id_subsistema          ,g_id_lugar         ,g_mensaje_error,
                                             pm_ip_origen             ,pm_mac_maquina           ,'error'            ,g_numero_error,
                                             pm_codigo_procedimiento  ,pm_proc_almacenado);

        --SE DEVUELVE EL MENSAJE DE ERROR
        g_nivel_error := '1';
        g_descripcion_log_error := g_numero_error || ' - ' || g_mensaje_error;
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        RAISE EXCEPTION '%', 'f' || g_separador || g_respuesta;

    END;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;