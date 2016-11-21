--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_tal_kardex_item_sel (
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
  al_id_fina_regi_prog_proy_acti integer,
  al_id_almacen_logico integer,
  al_id_almacen integer,
  al_id_item integer,
  al_fecha_desde date,
  al_fecha_hasta date
)
RETURNS SETOF record AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ALMACENES
***************************************************************************
 SCRIPT: 		almin.tal_ingreso y almin.tal_ingreso_detalle
 DESCRIPCIÓN: 	Devuelve el kardex físico
 AUTOR: 		Ana Maria VQ
 FECHA:			2009-01-20 10:57:05
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
    g_ana                      text;    -- VARIABLE QUE CONTENDRÁ LA CONSULTA DINÁMICA PARA EL FILTRO
    g_consulta_antes           text;    -- VARIABLE QUE CONTENDRÁ LA CONSULTA DINÁMICA PARA EL FILTRO
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



BEGIN

    ---*** INICIACIÓN DE VARIABLES
    g_privilegio_procedimiento := FALSE;
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion :='f_tal_kardex_item_sel';
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
    
     IF pm_codigo_procedimiento  = 'AL_REKAFI_SEL' THEN
        BEGIN
                 
                 CREATE TEMP TABLE tt_tal_ingresos (fecha    date,codigo    varchar,descripcion varchar(200),cantidad_ing numeric,cantidad_sal numeric,costo_unitario numeric,costo_debe numeric,costo_haber numeric,tipo_ing_sal varchar,fecha_finalizado_exacta timestamp) ON COMMIT DROP;
    			 
                 CREATE TEMP TABLE tt_tal_salidas ( fecha    date,codigo    varchar,descripcion varchar(200),cantidad_ing numeric,cantidad_sal numeric,costo_unitario numeric,costo_debe numeric,costo_haber numeric,tipo_ing_sal varchar,fecha_finalizado_exacta timestamp) ON COMMIT DROP;
                
                 CREATE TEMP TABLE tt_tal_kard_item (fecha date,codigo varchar,descripcion varchar(200),cantidad_ing numeric(18,2), cantidad_sal numeric(18,2),saldo numeric(18,2),costo_unitario numeric(18,6), costo_debe numeric(18,6),costo_haber numeric(18,6), saldo_costo numeric(18,6),fecha_finalizado_exacta timestamp) ON COMMIT DROP;
                
                 INSERT INTO  tt_tal_ingresos 
                    SELECT 
                         INGRES.fecha_finalizado_cancelado as fecha,
                         'I-'||coalesce(INGRES.correlativo_ing,'S/C') as codigo,
                        almin.f_al_obtener_nombre_ipec(INGRDE.id_ingreso_detalle,'INGRESO'),
                        INGRDE.cantidad,
                        0,
                        COALESCE(INGRDE.costo_unitario,0),
                        COALESCE(INGRDE.costo,0),
                        0,
                        'I',
                        INGRES.fecha_finalizado_exacta 
                   FROM almin.tal_ingreso INGRES
                      INNER JOIN almin.tal_ingreso_detalle INGRDE ON (INGRES.id_ingreso=INGRDE.id_ingreso)
                      INNER JOIN almin.tal_almacen_logico ALMLOG ON (ALMLOG.id_almacen_logico = INGRES.id_almacen_logico)
                      INNER JOIN almin.tal_almacen_ep ALMEP ON (ALMEP.id_almacen_ep = ALMLOG.id_almacen_ep)
                      INNER JOIN almin.tal_almacen ALMACE ON (ALMACE.id_almacen = ALMEP.id_almacen)
                   WHERE     INGRES.estado_ingreso='Finalizado' 
                         AND INGRES.id_parametro_almacen=al_id_parametro_almacen
                         AND INGRDE.id_item=al_id_item
                         AND ALMEP.id_fina_regi_prog_proy_acti = al_id_fina_regi_prog_proy_acti
                         AND ALMLOG.id_almacen_logico=al_id_almacen_logico 
                         AND ALMACE.id_almacen=al_id_almacen 
                         AND INGRES.fecha_finalizado_cancelado >=al_fecha_desde::date 
                         AND INGRES.fecha_finalizado_cancelado <= al_fecha_hasta::date;
                  
                  
                  INSERT INTO  tt_tal_salidas 
                      SELECT SALIDA.fecha_finalizado_cancelado as fecha,
                             'S-'||coalesce(SALIDA.correlativo_sal,'s/c')as codigo,
                             almin.f_al_obtener_nombre_ipec(SALDET.id_salida_detalle,'SALIDA'),
                             0,
                             (COALESCE(SALDET.cant_entregada,0)+COALESCE(SALDET.cant_demasia,0)) as cantidad ,
                             COALESCE(SALDET.costo_unitario,0),
                             0,
                             COALESCE(SALDET.costo,0),
                             'S',
                             SALIDA.fecha_finalizado_exacta 
                       FROM almin.tal_salida SALIDA
                         INNER JOIN almin.tal_salida_detalle SALDET ON (SALIDA.id_salida=SALDET.id_salida)
                         INNER JOIN almin.tal_almacen_logico ALMLOG ON (ALMLOG.id_almacen_logico = SALIDA.id_almacen_logico)
                         INNER JOIN almin.tal_almacen_ep ALMEP ON (ALMEP.id_almacen_ep = ALMLOG.id_almacen_ep)
                         INNER JOIN almin.tal_almacen ALMACE ON (ALMACE.id_almacen = ALMEP.id_almacen)
                      WHERE      SALIDA.estado_salida='Finalizado' 
                            AND  SALIDA.id_parametro_almacen=al_id_parametro_almacen
                            AND  SALDET.id_item=al_id_item
                            AND  ALMEP.id_fina_regi_prog_proy_acti = al_id_fina_regi_prog_proy_acti 
                            AND ALMLOG.id_almacen_logico=al_id_almacen_logico 
                            AND ALMACE.id_almacen=al_id_almacen 
                            AND  SALIDA.fecha_finalizado_cancelado >= al_fecha_desde::date 
                            AND  SALIDA.fecha_finalizado_cancelado<=al_fecha_hasta::date;
                
    
             -- este que sea para cada auxiliar o sea por auxiliar mas
             -- reporte para obtener el detalle del kardex físico
     

             -- g_saldo_antes:=0;
                Select s_cantidad_saldo into g_saldo_antes from almin.f_al_obtener_saldo_item(pm_id_usuario,pm_id_financiador,pm_id_regional,
                                     pm_id_programa,pm_id_proyecto,pm_id_actividad,al_id_item,
                                     al_id_parametro_almacen,al_id_almacen::varchar,al_id_almacen_logico::varchar,
                                     al_fecha_desde); 
                                     
--               raise exception '%', g_saldo_antes;
                Select s_cantidad_saldo into g_saldo_costo_antes from almin.f_al_obtener_saldo_costo_item(pm_id_usuario,pm_id_financiador,pm_id_regional,
                                     pm_id_programa,pm_id_proyecto,pm_id_actividad,al_id_item,
                                     al_id_parametro_almacen,al_id_almacen::varchar,al_id_almacen_logico::varchar,
                                     al_fecha_desde);  
                                                                          
               


               INSERT INTO tt_tal_kard_item(descripcion,saldo,saldo_costo) VALUES('SALDO ANTERIOR',g_saldo_antes,g_saldo_costo_antes);
               g_saldo:=g_saldo_antes;
               g_saldo_costo:=g_saldo_costo_antes;
               
               FOR v_kard_fisico IN (( SELECT  TTING.fecha,
               								  TTING.codigo,
                                              COALESCE(TTING.descripcion,'''') as descripcion,
                                              COALESCE(TTING.cantidad_ing,0) as cantidad_ing,
                                              COALESCE(TTING.cantidad_sal,0) as cantidad_sal,
                                              COALESCE(TTING.costo_unitario,0) as costo_unitario,
                                              COALESCE(TTING.costo_debe,0) as costo_debe,
                                              COALESCE(TTING.costo_haber,0) as costo_haber,
                                              TTING.tipo_ing_sal,
                                              TTING.fecha_finalizado_exacta
                                        FROM tt_tal_ingresos TTING)
                                      UNION
                                     
                                     ( SELECT TTSAL.fecha,TTSAL.codigo,
                                              COALESCE(TTSAL.descripcion,'''') as descripcion,
                                              COALESCE(TTSAL.cantidad_ing,0) as cantidad_ing,
                                              COALESCE(TTSAL.cantidad_sal,0) as cantidad_sal,
                                              COALESCE(TTSAL.costo_unitario,0) as costo_unitario,
                                              COALESCE(TTSAL.costo_debe,0) as costo_debe,
                                              COALESCE(TTSAL.costo_haber,0) as costo_haber,
                                              TTSAL.tipo_ing_sal,
                                              TTSAL.fecha_finalizado_exacta
                                         FROM tt_tal_salidas TTSAL)
                                      order by fecha,fecha_finalizado_exacta) LOOP
                            
                      g_costo_unitario:=v_kard_fisico.costo_unitario;    
                            
                     IF (v_kard_fisico.tipo_ing_sal='I') THEN
                         
                         g_saldo:=COALESCE(g_saldo+v_kard_fisico.cantidad_ing,0);
                         g_saldo_costo:=COALESCE(g_saldo_costo+v_kard_fisico.costo_debe,0);
                        
                         g_haber:=COALESCE(v_kard_fisico.costo_haber,0);
                     
                     ELSE
                          IF g_saldo IS NULL OR g_saldo = 0 THEN
                              g_costo_unitario:=0;
                          ELSE
                             
                          END IF;
                         
                         g_haber:=COALESCE(g_costo_unitario*v_kard_fisico.cantidad_sal,0);
                         g_saldo:=COALESCE(g_saldo-v_kard_fisico.cantidad_sal,0);
                         g_saldo_costo:=COALESCE(g_saldo_costo-g_haber,0);
                     
                     END IF;

              --aqui colocare a una tabla temporal
           
              raise notice 'fecha: %   codigo: %  descrip: %',v_kard_fisico.fecha,v_kard_fisico.codigo,v_kard_fisico.descripcion; 
              raise notice 'ingresos: %   salidas: %  saldo: %',v_kard_fisico.cantidad_ing,v_kard_fisico.cantidad_sal,g_saldo;
              raise notice 'costo_unit: %   debe: %   haber: %   costo:%',g_costo_unitario,v_kard_fisico.costo_debe,g_haber,g_saldo_costo;
             
               EXECUTE(' INSERT INTO tt_tal_kard_item VALUES('''||v_kard_fisico.fecha||''','''||v_kard_fisico.codigo||''','''||v_kard_fisico.descripcion||''','||v_kard_fisico.cantidad_ing||','||v_kard_fisico.cantidad_sal||',
                                         '||g_saldo||','||g_costo_unitario||','||v_kard_fisico.costo_debe||','||g_haber||','||g_saldo_costo||');');

                --raise notice 'codigo: %   saldo antes: %',v_kard_fisico.codigo,g_saldo_antes;
                END LOOP;
                
                 g_consulta1:='SELECT to_char(fecha,''dd/mm/YYYY'') ,
                                      codigo ,
                                      descripcion ,
                                      cantidad_ing ,
                                      cantidad_sal,
                                      saldo,
                                      costo_unitario ,
                                      costo_debe ,
                                      costo_haber ,
                                      saldo_costo
                                FROM tt_tal_kard_item ';
            FOR g_registros in EXECUTE (g_consulta1) LOOP
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