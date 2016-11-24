--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_tal_item_sel (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  pm_cant varchar,
  pm_puntero integer,
  pm_sortcol varchar,
  pm_sortdir varchar,
  pm_criterio_filtro varchar,
  pm_id_financiador varchar,
  pm_id_regional varchar,
  pm_id_programa varchar,
  pm_id_proyecto varchar,
  pm_id_actividad varchar
)
RETURNS SETOF record AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE GESTION DE ALMACENES
***************************************************************************
 SCRIPT: 		almin.f_tal_item_sel
 DESCRIPCIÓN: 	Devuelve las consultas a la tabla almin.tal_item
 AUTOR: 		Rodrigo Chumacero Moscoso
 FECHA:			28-09-2007
 COMENTARIOS:	
***************************************************************************
 HISTORIA DE MODIFICACIONES: 


 DESCRIPCIÓN:   Tipo de dato para    pm_cant
 AUTOR:  Rensi Arteaga Copari
 FECHA:  07 -01- 08
 
 DESCRIPCIÓN:   Consulta para filtro de items   AL_ITEFIL_SEL
 AUTOR:  Rensi Arteaga Copari
 FECHA:  24 -03- 08

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

-- DECLARACION DE VARIABLES PARTICULARES


-- DECLARACION DE VARIABLES DE LA FUNCION (LOCALES)

DECLARE

    --PARAMETROS FIJOS
    g_id_subsistema            integer; -- ID SUBSISTEMA
    g_id_lugar                 integer; -- ID LUGAR
    g_numero_error             varchar; -- ALMACENA EL NUMERO DE ERROR
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
    g_nombre_funcion           varchar; -- NOMBRE FÍSICO DE LA FUNCIÓN
    g_separador                varchar(10); -- Caracteres que servirán para separar el mensaje, nivel y origen del error

BEGIN

    ---*** INICIACIÓN DE VARIABLES
    g_privilegio_procedimiento := FALSE;
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion := 'almin.f_tal_item_sel';


    ---*** OBTENCIÓN DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENCION DEL ID DEL LUGAR ASIGNADO AL USUARIO
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
            g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario            ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                pm_codigo_procedimiento   ,pm_proc_almacenado);
            --DEVUELVE MENSAJE DE ERROR
            RAISE EXCEPTION '%', g_respuesta;
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


    -- Seleccion de operacion a realizar
    IF pm_codigo_procedimiento  = 'AL_ITEM_SEL' THEN
        BEGIN
            g_consulta := 'SELECT distinct
                           ite.id_item                 ,ite.codigo                ,ite.descripcion           ,ite.precio_venta_almacen,
                           ite.costo_estimado          ,ite.stock_min             ,ite.observaciones           ,ite.nivel_convertido      ,ite.estado_registro,
                           ite.fecha_reg               ,ite.id_unidad_medida_base ,ite.id_id3                ,ite.id_id2,
                           ite.id_id1                  ,ite.id_subgrupo           ,ite.id_grupo              ,ite.id_supergrupo,
                           ite.nombre                  ,id3.nombre as nombre_id3  ,id2.nombre as nombre_id2  ,id1.nombre as nombre_id1,
                           sub.nombre as nombre_subg   ,g.nombre as nombre_grupo  ,supgru.nombre as nombre_supg,umb.nombre as nombre_unid_base,
                           ite.peso_kg                 ,ite.mat_bajo_responsabilidad, ite.calidad, ite.descripcion_aux,
                           ite.registro
                           FROM almin.tal_item ite
                           INNER JOIN almin.tal_id3 id3
                           ON id3.id_id3 = ite.id_id3
                           INNER JOIN almin.tal_id2 id2
                           ON id2.id_id2 = ite.id_id2
                           INNER JOIN almin.tal_id1 id1
                           ON id1.id_id1 = ite.id_id1
                           INNER JOIN almin.tal_subgrupo sub
                           ON sub.id_subgrupo = ite.id_subgrupo
                           INNER JOIN almin.tal_grupo g
                           ON g.id_grupo = ite.id_grupo
                           INNER JOIN almin.tal_supergrupo supgru
                           ON supgru.id_supergrupo = ite.id_supergrupo
                           LEFT JOIN param.tpm_unidad_medida_base umb
                           ON umb.id_unidad_medida_base = ite.id_unidad_medida_base
                           WHERE ';
                           
/*                           inner join almin.tal_kardex_logico karlog on karlog.id_item=ite.id_item
                           inner join almin.tal_parametro_almacen paralm on paralm.id_parametro_almacen=karlog.id_parametro_almacen and paralm.cierre=''no''*/
                           
            g_consulta := g_consulta || pm_criterio_filtro;

            -- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;
            raise notice '%',g_consulta;
            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;
                
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END; 
        
         ELSIF pm_codigo_procedimiento  = 'AL_ITEFIL_SEL' THEN
        -- LISTA LOS ITEMS CON EXISTENCIAS
        BEGIN
                                                 
          g_consulta:=' SELECT   
                           id_item,
                           codigo,
                           descripcion,
                           observaciones,
                           id_id3,
                           id_id2,
                           id_id1,
                           id_subgrupo,
                           id_grupo,
                           id_supergrupo,
                           nombre,
                           nombre_id3,
                           nombre_id2,
                           nombre_id1,
                           nombre_subg,
                           nombre_grupo,
                           nombre_supg,
                           descripcion_id3,
                           descripcion_id2,
                           descripcion_id1,
                           descripcion_subg,
                           descripcion_grupo,
                           descripcion_supg

                           FROM almin.val_item
                           WHERE  lower(codigo) LIKE lower(''%'||pm_criterio_filtro||'%'') OR 
                                  lower(nombre) LIKE lower(''%'||pm_criterio_filtro||'%'') OR
                                  lower(descripcion) LIKE lower(''%'||pm_criterio_filtro||'%'') OR
                                  lower(observaciones) LIKE lower(''%'||pm_criterio_filtro||'%'') OR
                                  lower(nombre_id3) LIKE lower(''%'||pm_criterio_filtro||'%'') OR
                                  lower(descripcion_id3) LIKE lower(''%'||pm_criterio_filtro||'%'') OR
                                  lower(nombre_id2) LIKE lower(''%'||pm_criterio_filtro||'%'') OR
                                  lower(descripcion_id2) LIKE lower(''%'||pm_criterio_filtro||'%'') OR
                                  lower(nombre_id1) LIKE lower(''%'||pm_criterio_filtro||'%'') OR
                                  lower(descripcion_id1) LIKE lower(''%'||pm_criterio_filtro||'%'') OR
                                  lower(nombre_subg) LIKE lower(''%'||pm_criterio_filtro||'%'') OR
                                  lower(descripcion_subg) LIKE lower(''%'||pm_criterio_filtro||'%'') OR
                                  lower(nombre_grupo) LIKE lower(''%'||pm_criterio_filtro||'%'') OR
                                  lower(descripcion_grupo) LIKE lower(''%'||pm_criterio_filtro||'%'') OR
                                  lower(nombre_supg) LIKE lower(''%'||pm_criterio_filtro||'%'') OR
                                  lower(descripcion_supg) LIKE lower(''%'||pm_criterio_filtro||'%'')';


            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada sobre almin.val_item';
        END; 
        
     /*
     Autor:  	RAC
     Descripc 	-  Considerar el parametros almacen logico para determinar existencias
     Fecha:		14/12/2016
     */   
        
    ELSIF pm_codigo_procedimiento  = 'AL_ITEKAR_SEL' THEN
        -- LISTA LOS ITEMS CON EXISTENCIAS
        BEGIN
            g_consulta := 'SELECT   
                           id_item,
                           codigo,
                           descripcion,
                           precio_venta_almacen,
                           costo_estimado,
                           stock_min,
                           observaciones,
                           nivel_convertido,
                           estado_registro,
                           fecha_reg,
                           id_unidad_medida_base,
                           id_id3,
                           id_id2,
                           id_id1,
                           id_subgrupo,
                           id_grupo,
                           id_supergrupo,
                           nombre,
                           nombre_id3  ,
                           nombre_id2  ,
                           nombre_id1,
                           nombre_subg   ,
                           nombre_grupo  ,
                           nombre_supg,
                           nombre_unid_base,
                           total,
                           Nuevo,
                           Usado
                           FROM almin.val_kardex_logico
                           WHERE ';
            g_consulta := g_consulta || pm_criterio_filtro;
           
            -- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END; 
        
     ELSIF pm_codigo_procedimiento  = 'AL_ITESAL_SEL' THEN
        -- LISTA LOS ITEMS CON EXISTENCIAS
        BEGIN
            g_consulta := 'SELECT   
                           id_item             ,codigo          ,descripcion             ,precio_venta_almacen,
                           costo_estimado      ,stock_min       ,observaciones           ,nivel_convertido,
                           estado_registro     ,fecha_reg       ,id_unidad_medida_base   ,id_id3,
                           id_id2              ,id_id1          ,id_subgrupo             ,id_grupo,
                           id_supergrupo       ,nombre          ,nombre_id3              ,nombre_id2,
                           nombre_id1          ,nombre_subg     ,nombre_grupo            ,nombre_supg,
                           nombre_unid_base    ,mat_bajo_responsabilidad
                           FROM almin.val_item
                           WHERE ';
            g_consulta := g_consulta || pm_criterio_filtro;
           
            -- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;
        
    ELSIF pm_codigo_procedimiento  = 'AL_ITEM_COUNT' THEN

        BEGIN
        --Cuenta todos los registros de cambio alumbrado publico sin condiciones
           /* g_consulta := '
            
                           SELECT 
                           COUNT(it.id_item) AS total
                           FROM  (
                           
                                 SELECT distinct
                                 ite.id_item
                                 FROM almin.tal_item ite
                                 INNER JOIN almin.tal_id3 id3
                                 ON id3.id_id3 = ite.id_id3
                                 INNER JOIN almin.tal_id2 id2
                                 ON id2.id_id2 = ite.id_id2
                                 INNER JOIN almin.tal_id1 id1
                                 ON id1.id_id1 = ite.id_id1
                                 INNER JOIN almin.tal_subgrupo sub
                                 ON sub.id_subgrupo = ite.id_subgrupo
                                 INNER JOIN almin.tal_grupo g
                                 ON g.id_grupo = ite.id_grupo
                                 INNER JOIN almin.tal_supergrupo supgru
                                 ON supgru.id_supergrupo = ite.id_supergrupo
                                 LEFT JOIN param.tpm_unidad_medida_base umb
                                 ON umb.id_unidad_medida_base = ite.id_unidad_medida_base
                                 inner join almin.tal_kardex_logico karlog on karlog.id_item=ite.id_item
                                 inner join almin.tal_parametro_almacen paralm on paralm.id_parametro_almacen=karlog.id_parametro_almacen and paralm.cierre=''no''
                                 WHERE ';
                                             g_consulta := g_consulta || pm_criterio_filtro ||' ) as it';*/
                                 
                        g_consulta := 'SELECT
                           COUNT(ite.id_item) AS total
                           FROM almin.tal_item ite
                           INNER JOIN almin.tal_id3 id3
                           ON id3.id_id3 = ite.id_id3
                           INNER JOIN almin.tal_id2 id2
                           ON id2.id_id2 = ite.id_id2
                           INNER JOIN almin.tal_id1 id1
                           ON id1.id_id1 = ite.id_id1
                           INNER JOIN almin.tal_subgrupo sub
                           ON sub.id_subgrupo = ite.id_subgrupo
                           INNER JOIN almin.tal_grupo g
                           ON g.id_grupo = ite.id_grupo
                           INNER JOIN almin.tal_supergrupo supgru
                           ON supgru.id_supergrupo = ite.id_supergrupo
                           LEFT JOIN param.tpm_unidad_medida_base umb
                           ON umb.id_unidad_medida_base = ite.id_unidad_medida_base
                           WHERE ';
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;
        
    ELSIF pm_codigo_procedimiento  = 'AL_ITEKAR_COUNT' THEN
        -- LISTA LOS ITEMS CON EXISTENCIAS
        BEGIN
             g_consulta := 'SELECT COUNT(codigo)
                           FROM almin.val_kardex_logico
                           WHERE ';
                           
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;  
        ELSIF pm_codigo_procedimiento  = 'AL_ITESAL_COUNT' THEN
       -- LISTA LOS ITEMS CON EXISTENCIAS
        BEGIN
             g_consulta := 'SELECT COUNT(codigo)
                           FROM almin.val_item
                           WHERE ';
                           
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;
     ----------- -------------------------------------------------------------------------------------
 ELSEIF pm_codigo_procedimiento  = 'AL_ITEAL_SEL' THEN
        BEGIN
            g_consulta := 'SELECT
                            distinct (ite.id_item),
                           ite.codigo    ,
                           ite.nombre  ,
                           ite.descripcion ,
                           ite.precio_venta_almacen,
                           ite.costo_estimado ,
                           ite.stock_min  ,
                           ite.observaciones ,
                           ite.nivel_convertido ,
                           ite.estado_registro,
                           ite.fecha_reg ,  
                           ite.id_unidad_medida_base ,
                           ite.id_id3 ,
                           ite.id_id2,
                           ite.id_id1  ,
                           ite.id_subgrupo ,
                           ite.id_grupo,
                           ite.id_supergrupo,
                           umb.nombre as nombre_unid_base,
                           id3.nombre as nombre_id3  ,
                           id2.nombre as nombre_id2  ,
                           id1.nombre as nombre_id1,
                           sub.nombre as nombre_subg   , 
                           g.nombre as nombre_grupo  ,
                           supgru.nombre as nombre_supg
                             FROM almin.tal_item  ite
                             INNER JOIN param.tpm_unidad_medida_base umb ON  ite.id_unidad_medida_base=umb.id_unidad_medida_base
                             INNER JOIN almin.tal_id3 id3 ON ite.id_id3 = id3.id_id3 
                             INNER JOIN almin.tal_id2 id2 ON ite.id_id2 = id2.id_id2
                             INNER JOIN almin.tal_id1 id1 ON ite.id_id1 = id1.id_id1
                             INNER JOIN almin.tal_subgrupo sub ON ite.id_subgrupo = sub.id_subgrupo
                             INNER JOIN almin.tal_grupo g ON ite.id_grupo = g.id_grupo
                             INNER JOIN almin.tal_supergrupo supgru ON ite.id_supergrupo = supgru.id_supergrupo 
                           
                             inner join almin.tal_kardex_logico KARLOG ON (KARLOG.id_item = ite.id_item)
                             inner join almin.tal_parametro_almacen PARALM ON (PARALM.id_parametro_almacen=KARLOG.id_parametro_almacen AND PARALM.cierre=''no'')
                             inner join almin.tal_almacen_logico ALMLOG ON (ALMLOG.id_almacen_logico = KARLOG.id_almacen_logico )
                             inner join almin.tal_almacen_ep ALMCEP ON (ALMLOG.id_almacen_ep= ALMCEP.id_almacen_ep)
                             inner join almin.tal_almacen ALMACE ON (ALMACE.id_almacen = ALMCEP.id_almacen)
                             WHERE ';
            g_consulta := g_consulta || pm_criterio_filtro;

            -- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;
            
            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;
                
            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;
        
    ELSIF pm_codigo_procedimiento  = 'AL_ITEAL_COUNT' THEN

        BEGIN
       
            g_consulta := 'SELECT
                             count(distinct ite.id_item) AS total
                             FROM almin.tal_item  ite
                             INNER JOIN param.tpm_unidad_medida_base umb ON  ite.id_unidad_medida_base=umb.id_unidad_medida_base
                             INNER JOIN almin.tal_id3 id3 ON ite.id_id3 = id3.id_id3 
                             INNER JOIN almin.tal_id2 id2 ON ite.id_id2 = id2.id_id2
                             INNER JOIN almin.tal_id1 id1 ON ite.id_id1 = id1.id_id1
                             INNER JOIN almin.tal_subgrupo sub ON ite.id_subgrupo = sub.id_subgrupo
                             INNER JOIN almin.tal_grupo g ON ite.id_grupo = g.id_grupo
                             INNER JOIN almin.tal_supergrupo supgru ON ite.id_supergrupo = supgru.id_supergrupo
                           
                             inner join almin.tal_kardex_logico KARLOG ON (KARLOG.id_item = ite.id_item)
                             inner join almin.tal_parametro_almacen PARALM ON (PARALM.id_parametro_almacen=KARLOG.id_parametro_almacen AND PARALM.cierre=''no'')
                             inner join almin.tal_almacen_logico ALMLOG ON (ALMLOG.id_almacen_logico = KARLOG.id_almacen_logico )
                             inner join almin.tal_almacen_ep ALMCEP ON (ALMLOG.id_almacen_ep= ALMCEP.id_almacen_ep)
                             inner join almin.tal_almacen ALMACE ON (ALMACE.id_almacen = ALMCEP.id_almacen)
                           WHERE ';
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;
         
ELSIF pm_codigo_procedimiento  = 'AL_ITLIST_SEL' THEN
    --Para Reporte de Listado de Items (ARV: san borja 09/12/2008)
        BEGIN
            g_consulta := 'SELECT 
                               DISTINCT SUPGRU.id_supergrupo,
                               SUPGRU.codigo as codigo_super,
                               SUPGRU.nombre as nombre_super, 
                               SUPGRU.descripcion as desc_super,                                     
                               GRUPP.id_grupo,                               
                               GRUPP.codigo as codigo_grupo, 
                               GRUPP.nombre as nombre_grupo, 
                               GRUPP.descripcion as desc_grupo,

                               SUBGRU.id_subgrupo, 
                               SUBGRU.codigo as codigo_subgrupo, 
                               SUBGRU.nombre as nombre_subgrupo, 
                               SUBGRU.descripcion as desc_subgrupo, 

                               IID1.id_id1,
                               IID1.codigo as codigo_id1, 
                               IID1.nombre as nombre_id1, 
                       	       IID1.descripcion as desc_id1,

                               IID2.id_id2, 
       			       IID2.codigo as codigo_id2, 
       			       IID2.nombre as nombre_id2, 
                               IID2.descripcion as desc_id2,

                               IID3.id_id3,
                               IID3.codigo as codigo_id3, 
                               IID3.nombre as nombre_id3, 
                               IID3.descripcion as desc_id3,

                               ITEM.codigo as codigo_item,
                               ITEM.nombre as nombre_item, 
                               ITEM.descripcion as desc_item
                              
                          From almin.tal_item ITEM  
                               LEFT JOIN almin.tal_id3 IID3 ON (ITEM.id_id3=IID3.id_id3) 
                               LEFT JOIN almin.tal_id2 IID2 ON (IID3.id_id2=IID2.id_id2) 
                               INNER JOIN almin.tal_id1 IID1 ON (IID2.id_id1=IID1.id_id1) 
                               INNER JOIN almin.tal_subgrupo SUBGRU ON (SUBGRU.id_subgrupo=IID1.id_subgrupo) 
                               INNER JOIN almin.tal_grupo GRUPP ON (GRUPP.id_grupo=SUBGRU.id_grupo) 
                               INNER JOIN almin.tal_supergrupo SUPGRU   ON(SUPGRU.id_supergrupo=GRUPP.id_supergrupo)

                            
						    WHERE ';
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de Listado de Items';
        END;



         ----------------------------------------------------------------------------------------   
     
    
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


    ---*** REGISTRO EN EL LOG EL ÉXITO DE LA EJECUIÓN DEL PROCEDIMIENTO
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