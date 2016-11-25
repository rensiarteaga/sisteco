--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_tal_orden_salida_uc_detalle_ext (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_orden_salida_uc_detalle integer,
  al_descripcion varchar,
  al_observaciones varchar,
  al_fecha_reg date,
  al_id_tipo_unidad_constructiva integer,
  al_id_salida integer,
  al_id_unidad_constructiva integer,
  al_cantidad numeric,
  al_id_item integer,
  al_repeticion varchar,
  al_id_almacen_logico integer
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ALMACENES (ALMIN)
***************************************************************************
 SCRIPT: 		almin.f_tal_orden_salida_uc_detalle_ext
 DESCRIPCIÓN: 	Maneja las operaiones con pedidos de tipos de unidades cosntructivas (verificacion de existencias)
 AUTOR:         Rensi Arteaga Copari
 FECHA:         28-01-2008
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
      v_registros			    record;
    g_id_subsistema            integer; -- ID SUBSISTEMA
    g_id_lugar                 integer; -- ID LUGAR
    g_numero_error             varchar; -- ALMACENA EL NÚMERO DE ERROR
    g_mensaje_error            varchar; -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento boolean; -- BANDERA PARA VERIFICAR LLAMADA DE LA FUNCIÓN
    g_descripcion_log_error    text;    -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento               varchar; --boolean;
    g_reg_error                varchar; --boolean;
    g_respuesta                varchar; -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCIÓN
    g_nivel_error              varchar; -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                        --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                        --      ERROR LÓGICO (CRÍTICO) = 2
                                        --      ERROR LÓGICO (INTERMEDIO) = 3
                                        --      ERROR LÓGICO (ADVERTENCIA) = 4
    
    g_nombre_funcion           varchar; --NOMBRE FÍSICO DE LA FUNCIÓN
    g_separador                varchar(10); --Caracteres que servirán para separar el mensaje, nivel y origen del error
  --  g_id_supergrupo            integer; --Variable para obtener el id_super_grupo en base al id_grupo
    g_cod_grupo                varchar;
    g_cod_subgrupo             varchar; 
    g_cod_duplicado            varchar;
    g_id_orden_salida_uc_detalle  integer;  
    g_sw              varchar;
 
    
    --Cursor lista el contendi del kardex_logico contejado con almin.tal_pedido_tuc_tmp
    g_cursor_tmp        CURSOR (p_id_parametro_almacen bigint,p_id_salida integer,p_id_almacen_logico integer) FOR 
                               SELECT PTUC.id_salida,
                                       PTUC.id_item,
                                       SUM(PTUC.cantidad_solicitada),
                                       COALESCE(KARLOG.total_exacto, 0) as total_exacto,
                                       COALESCE(KARLOG.cant_nuevo, 0) as nuevo,
                                       COALESCE(KARLOG.cant_usado, 0) as usado
                                FROM almin.tal_pedido_tuc_tmp PTUC
                                       LEFT JOIN 
                                       (
                                            SELECT id_item,
                                                   total_exacto,
                                                   nuevo as cant_nuevo,
                                                   usado as cant_usado,
                                                   id_almacen_logico,
                                                   id_parametro_almacen 
                                            FROM almin.val_kardex_logico_resumido 
                                            WHERE
                                                   id_almacen_logico = p_id_almacen_logico AND
                                                   id_parametro_almacen = p_id_parametro_almacen
                                         ) KARLOG ON ptuc.id_item =  KARLOG.id_item
                                WHERE PTUC.id_salida = p_id_salida
                                GROUP BY PTUC.id_salida,
                                         PTUC.id_item,
                                         KARLOG.total_exacto,
                                         KARLOG.cant_nuevo,
                                         KARLOG.cant_usado;  
                                         
    --Cursor lista el contendi del kardex_logico contejado con almin.tal_pedido_tuc_int
    g_cursor_int        CURSOR (p_id_parametro_almacen bigint,p_id_salida integer,p_id_almacen_logico integer) FOR 
                               SELECT PTUC.id_salida,
                                       PTUC.id_item,
                                       SUM(PTUC.cantidad_solicitada),
                                       SUM(COALESCE(PTUC.demasia,0)) as demasia,
                                       COALESCE(KARLOG.total_exacto, 0) as total_exacto,
                                       COALESCE(KARLOG.cant_nuevo, 0) as nuevo,
                                       COALESCE(KARLOG.cant_usado, 0) as usado
                                FROM almin.tal_pedido_tuc_int PTUC
                                       LEFT JOIN 
                                       (
                                            SELECT id_item,
                                                   total_exacto,
                                                   nuevo as cant_nuevo,
                                                   usado as cant_usado,
                                                   id_almacen_logico,
                                                   id_parametro_almacen 
                                            FROM almin.val_kardex_logico_resumido 
                                            WHERE
                                                   id_almacen_logico = p_id_almacen_logico AND
                                                   id_parametro_almacen = p_id_parametro_almacen
                                         ) KARLOG ON PTUC.id_item =  KARLOG.id_item
                                WHERE PTUC.id_salida = p_id_salida
                                GROUP BY PTUC.id_salida,
                                         PTUC.id_item,
                                         KARLOG.total_exacto,
                                         KARLOG.cant_nuevo,
                                         KARLOG.cant_usado;
   
  
   
   g_registro_cursor                    record; --VARIABLE QUE CONTENDRÁ CADA REGISTRO DEL CURSOR EN EL FETCH
   
   g_cursor2_tmp        CURSOR (p_id_item integer,p_id_salida integer) FOR 
                                    SELECT 
                                    id_pedido_tuc_tmp,
                                    id_item,
                                    cantidad_solicitada,
                                    demasia
                                    FROM 
                                    almin.tal_pedido_tuc_tmp
                                    WHERE 
                                    id_item=p_id_item AND
                                    id_salida=p_id_salida;
                                    
                                    
   g_cursor2_int        CURSOR (p_id_item integer,p_id_salida integer) FOR 
                                    SELECT 
                                    id_pedido_tuc_int,
                                    id_item,
                                    cantidad_solicitada,
                                    demasia
                                    FROM 
                                    almin.tal_pedido_tuc_int
                                    WHERE 
                                    id_item=p_id_item AND
                                    id_salida=p_id_salida;
                                    
   g_registro_cursor2         record; --VARIABLE QUE CONTENDRÁ CADA REGISTRO DEL CURSOR EN EL FETCH
   
   
   g_consulta                 text; 
   g_registros                record;  -- PARA ALMACENAR EL CONJUNTO DE DATOS RESULTADO DEL SELECT
   g_cantidad_solicitada           numeric; -- ID SUBSISTEMA
   g_cantidad_demasia              numeric;
   g_cantidad_disponible           numeric; -- ID SUBSISTEMA 
   g_id_pedido_tuc_tmp             integer; 
   g_id_pedido_tuc_int             integer; 
   g_id_parametro_almacen          integer;--gestion activa de paramatreo almacen  
   g_usado_aux                     numeric;
   g_nuevo_aux                     numeric;
   g_nuevo_ins                     numeric;
   g_usado_ins                     numeric;
   g_cantidad_aux                  numeric;
   g_id_almacen_logico             integer;
   g_id_parametro_almacen_logico	integer;
    
BEGIN

    ---*** INICIACIÓN DE VARIABLES 
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion := 'almin.f_tal_orden_salida_uc_detalle_ext';
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
    
   --*** VERIFICACION DE DISPONIBILIDAD DE LOS ITEMS DEL TUC ESPCIFICAO PARA EL ALMACEN LOGICO 
    IF pm_codigo_procedimiento = 'AL_OSUCDE_TUC_TMP_INS' THEN

        BEGIN  
                   
                g_consulta:= 'SELECT 
                              COMP.id_componente,
                              COMP.id_item,
                              COMP.id_tipo_unidad_constructiva, 
                              COMP.cantidad,
                              COMP.cosiderar_repeticion
                              FROM almin.tal_componente COMP                               
                              WHERE COMP.id_tipo_unidad_constructiva='||al_id_tipo_unidad_constructiva;
                
                FOR g_registros in EXECUTE(g_consulta) LOOP
               -- RETURN NEXT g_registros;                     
                
                 g_cantidad_solicitada:=g_registros.cantidad * al_cantidad;
                
               -- SELECT NEXTVAL('almin.tal_pedido_tuc_tmp_id_pedido_tuc_tpm_seq') INTO g_id_pedido_tuc_tmp; 
--                                almin.tal_tipo_unidad_constructiva_id_tipo_unidad_constructiva_seq
                   
                INSERT INTO almin.tal_pedido_tuc_tmp(
                id_salida     ,id_orden_salida_uc_detalle,
                id_tipo_unidad_constructiva    ,id_item       ,cantidad_solicitada,
                fecha_reg
                ) VALUES (
                al_id_salida  ,al_id_orden_salida_uc_detalle,
                al_id_tipo_unidad_constructiva  ,g_registros.id_item         ,g_cantidad_solicitada,
                now()
                );
              
        
            END LOOP;
      -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
     g_descripcion_log_error := 'Registro exitosode de items para en tabla temporal de pedido_tuc para el tuc='||al_id_tipo_unidad_constructiva;
     g_respuesta := 't'||g_separador||g_descripcion_log_error||g_separador||'true';
     END;
     
       /*
      Autor:	Rensi Arteaga Copari
      Fecha:	29/12/2016
      Desc:	 	- esta funcion corre cuando cuando tuc son agregadas al pedido
      			-  Si el item ya existen solo modifica las cantidades
      			
      
     
     */
     ELSEIF pm_codigo_procedimiento = 'AL_OSUCDE_TUC_INT_INS' THEN

        BEGIN  
                   
                g_consulta:= 'SELECT 
                                COMP.id_componente,
                                COMP.id_item,
                                COMP.id_tipo_unidad_constructiva, 
                                COMP.cantidad,
                                COMP.cosiderar_repeticion,
                                CASE SUPGRU.demasia
                                    WHEN ''si'' THEN (SELECT demasia_porc/100 FROM almin.tal_parametro_almacen WHERE cierre = ''no'')
                                    ELSE 0
                                END as porc_demasia
                              FROM almin.tal_componente COMP
                                INNER JOIN almin.tal_item ITEM ON ITEM.id_item = COMP.id_item
                                INNER JOIN almin.tal_supergrupo SUPGRU  ON SUPGRU.id_supergrupo = ITEM.id_supergrupo                               
                              WHERE COMP.id_tipo_unidad_constructiva='||al_id_tipo_unidad_constructiva;
                
                FOR g_registros in EXECUTE(g_consulta) LOOP
               -- RETURN NEXT g_registros;                     
                
                 g_cantidad_solicitada:=g_registros.cantidad * al_cantidad;
                 g_cantidad_demasia:=ROUND(g_registros.porc_demasia * g_cantidad_solicitada);
                
             
 				v_registros = NULL;
                
                select
                 *
                into
                  v_registros
                from almin.tal_pedido_tuc_int pti
                where pti.id_item = g_registros.id_item and pti.id_salida = al_id_salida;
                
                
                IF  v_registros.id_pedido_tuc_int is null  THEN
             
                    
                      INSERT INTO almin.tal_pedido_tuc_int(
                        id_salida            ,id_orden_salida_uc_detalle    ,id_tipo_unidad_constructiva,
                        id_item       		 ,cantidad_solicitada			,fecha_reg,
                        demasia
                        ) VALUES (
                        al_id_salida         ,al_id_orden_salida_uc_detalle ,al_id_tipo_unidad_constructiva,
                        g_registros.id_item  ,g_cantidad_solicitada			,now(),
                        g_cantidad_demasia
                        );
                ELSE
                    update almin.tal_pedido_tuc_int set
                        cantidad_solicitada = v_registros.cantidad_solicitada + g_cantidad_solicitada,
                        demasia = v_registros.demasia  + g_cantidad_demasia
                     where id_pedido_tuc_int = v_registros.id_pedido_tuc_int;
                
                END IF;
                   
              
              
        
            END LOOP;
      -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
     g_descripcion_log_error := 'Registro exitosode de items para en tabla temporal de pedido_tuc para el tuc='||al_id_tipo_unidad_constructiva;
     g_respuesta := 't'||g_separador||g_descripcion_log_error||g_separador||'true';
     END; 
     ELSEIF pm_codigo_procedimiento = 'AL_OSUCDE_ITEM_TMP_INS' THEN

        BEGIN  
                
                
              --  SELECT NEXTVAL('almin.tal_pedido_tuc_tmp_id_pedido_tuc_tpm_seq') INTO g_id_pedido_tuc_tmp; 
--                                almin.tal_tipo_unidad_constructiva_id_tipo_unidad_constructiva_seq
                   
                INSERT INTO almin.tal_pedido_tuc_tmp(
               id_salida     ,id_orden_salida_uc_detalle,
                id_tipo_unidad_constructiva    ,id_item       ,cantidad_solicitada,
                fecha_reg
                ) VALUES (
               al_id_salida  ,al_id_orden_salida_uc_detalle,
                al_id_tipo_unidad_constructiva  ,al_id_item         ,al_cantidad,
                now()
                );
              
        
            
      -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
     g_descripcion_log_error := 'Registro exitosode del items '||al_id_item||' en tabla almin.tal_pedido_tuc_tpm para la salida='||al_id_salida;
     g_respuesta := 't'||g_separador||g_descripcion_log_error;
     END; 
     
     /*
      Autor:	Rensi Arteaga Copari
      Fecha:	29/12/2016
      Desc:	 	- esta funcion corre cuando item se agregar directamente al pedido
      			-  Si el item ya existen solo modifica las cantidades
      			
      
     
     */
     
     ELSEIF pm_codigo_procedimiento = 'AL_OSUCDE_ITEM_INT_INS' THEN

        BEGIN  
                
                
              --  SELECT NEXTVAL('almin.tal_pedido_tuc_int_id_pedido_tuc_int_seq') INTO g_id_pedido_tuc_int; 
--                                almin.tal_tipo_unidad_constructiva_id_tipo_unidad_constructiva_seq

                --
                select
                 *
                into
                  v_registros
                from almin.tal_pedido_tuc_int pti
                where pti.id_item = al_id_item and pti.id_salida = al_id_salida;
                
           
                
                
                IF  v_registros.id_pedido_tuc_int is null  THEN
                
                    
                    INSERT INTO almin.tal_pedido_tuc_int(
                        id_salida     ,id_orden_salida_uc_detalle,
                        id_tipo_unidad_constructiva    ,id_item       ,cantidad_solicitada,
                        fecha_reg
                        ) VALUES (
                        al_id_salida  ,al_id_orden_salida_uc_detalle,
                        al_id_tipo_unidad_constructiva  ,al_id_item         ,al_cantidad,
                        now()
                    );
                ELSE
                    update almin.tal_pedido_tuc_int set
                        cantidad_solicitada = v_registros.cantidad_solicitada + al_cantidad
                     where id_pedido_tuc_int = v_registros.id_pedido_tuc_int;
                
                END IF;
              
        
            
                -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
                g_descripcion_log_error := 'Registro exitosode del items '||al_id_item||' en tabla almin.tal_pedido_tuc_tpm para la salida='||al_id_salida;
                g_respuesta := 't'||g_separador||g_descripcion_log_error;
         END;
     
     ELSEIF pm_codigo_procedimiento = 'AL_VERIF_EXI_TMP' THEN

        BEGIN 
             
            g_sw:='true';
            
            --RAC 05/12/2016  recuepra gestion vigente por almacen logico
            SELECT 
                  pl.id_parametro_almacen,
                  pl.id_parametro_almacen_logico
            INTO 
                  g_id_parametro_almacen,
                  g_id_parametro_almacen_logico
            FROM almin.tal_parametro_almacen_logico pl
            WHERE estado  = 'abierto'
                  and pl.id_almacen_logico = al_id_almacen_logico;
             
             
             if  g_id_parametro_almacen then
	             raise exception 'Nose encontro una gestión vigente para el almacen lógico';               
             end if; 
                 
             OPEN g_cursor_tmp(g_id_parametro_almacen,al_id_salida,al_id_almacen_logico);
             LOOP

                FETCH g_cursor_tmp INTO g_registro_cursor;
                EXIT WHEN NOT FOUND; 
                
                   g_nuevo_aux:=g_registro_cursor.nuevo;
                   g_usado_aux:=g_registro_cursor.usado;
                   
                   IF(g_usado_aux>0 OR g_nuevo_aux>0) THEN
                       
                
                       OPEN g_cursor2_tmp(g_registro_cursor.id_item,al_id_salida);
                        LOOP

                        FETCH g_cursor2_tmp INTO g_registro_cursor2;
                         EXIT WHEN NOT FOUND;    
                                                             
                          IF (g_nuevo_aux > g_registro_cursor2.cantidad_solicitada) THEN
                             g_nuevo_aux :=g_nuevo_aux-g_registro_cursor2.cantidad_solicitada;
                             g_nuevo_ins:=g_registro_cursor2.cantidad_solicitada;
                             g_usado_ins:=0;
                          ELSEIF (g_nuevo_aux + g_usado_aux> g_registro_cursor2.cantidad_solicitada) THEN
                            g_nuevo_ins:=g_nuevo_aux;
                            g_usado_ins:=g_registro_cursor2.cantidad_solicitada - g_nuevo_aux;
                            g_nuevo_aux:=0;
                            g_usado_aux:=g_usado_aux - g_registro_cursor2.cantidad_solicitada + g_nuevo_ins;
                          ELSE
                            g_sw:='false'; 
                            g_nuevo_ins:=g_nuevo_aux;
                            g_usado_ins:=g_usado_aux;
                            g_nuevo_aux:=0;
                            g_usado_aux:=0;
                          END IF;                   
                      
                      
                          UPDATE almin.tal_pedido_tuc_tmp SET
                          nuevo = g_nuevo_ins,
                          usado = g_usado_ins
                          WHERE 
                          id_pedido_tuc_tmp = g_registro_cursor2.id_pedido_tuc_tmp;              
                
                
                          IF (g_usado_aux=0 AND g_nuevo_aux=0) THEN
                            EXIT;
                          END IF;
                
                      END LOOP;
                      CLOSE g_cursor2_tmp;
                   END IF;  
                
                
                
                
                
              END LOOP;
            CLOSE g_cursor_tmp; 
            
          
         g_descripcion_log_error := 'Verificacion exitosa de pedido de TUC en la salida  id_salida='||al_id_salida;
         g_respuesta := 't'||g_separador||g_descripcion_log_error||g_separador||g_sw;     
        
        END;
    /*
    Autor:  	Rensi Arteaga Copari
    Fecha:		05/12/2016
    Desc:		- 05/12/2016  recuepra gestion vigente por almacen logico
    			-  
    */    
        
    ELSEIF pm_codigo_procedimiento = 'AL_VERIF_EXI_INT' THEN

        BEGIN 
             g_sw:='true'; 
             
            --RAC 05/12/2016  recuepra gestion vigente por almacen logico
            SELECT 
                  pl.id_parametro_almacen,
                  pl.id_parametro_almacen_logico
            INTO 
                  g_id_parametro_almacen,
                  g_id_parametro_almacen_logico
            FROM almin.tal_parametro_almacen_logico pl
            WHERE estado  = 'abierto'
                  and pl.id_almacen_logico = al_id_almacen_logico;
             
             OPEN g_cursor_int(g_id_parametro_almacen,al_id_salida,al_id_almacen_logico);
             LOOP
                 FETCH g_cursor_int INTO g_registro_cursor;
                 EXIT WHEN NOT FOUND; 
                
                 g_nuevo_aux:=g_registro_cursor.nuevo;
                 g_usado_aux:=g_registro_cursor.usado; 
                   
                 raise notice 'nuevo: %  usado: %',g_nuevo_aux,g_usado_aux;
                   
                 IF(g_usado_aux>0 OR g_nuevo_aux>0) THEN
                     OPEN g_cursor2_int(g_registro_cursor.id_item,al_id_salida);     
                     LOOP
                         FETCH g_cursor2_int INTO g_registro_cursor2;
                         EXIT WHEN NOT FOUND;    
                                                             
                         IF (g_nuevo_aux >= g_registro_cursor2.cantidad_solicitada+g_registro_cursor2.demasia) THEN
                             g_nuevo_aux :=g_nuevo_aux-(g_registro_cursor2.cantidad_solicitada+g_registro_cursor2.demasia);
                             g_nuevo_ins:=g_registro_cursor2.cantidad_solicitada+g_registro_cursor2.demasia;
                             g_usado_ins:=0;
                         ELSEIF (g_nuevo_aux + g_usado_aux>= g_registro_cursor2.cantidad_solicitada+g_registro_cursor2.demasia) THEN
                             g_nuevo_ins:=g_nuevo_aux;
                             g_usado_ins:=(g_registro_cursor2.cantidad_solicitada+g_registro_cursor2.demasia) - g_nuevo_aux;
                             g_nuevo_aux:=0;
                             g_usado_aux:=g_usado_aux - g_usado_ins;
                         ELSE
                             g_sw:='false';
                             g_nuevo_ins:=g_nuevo_aux;
                             g_usado_ins:=g_usado_aux;
                             g_nuevo_aux:=0;
                             g_usado_aux:=0;
                         END IF;                   
                      
                         UPDATE almin.tal_pedido_tuc_int SET
                         nuevo = g_nuevo_ins,
                         usado = g_usado_ins
                         WHERE id_pedido_tuc_int = g_registro_cursor2.id_pedido_tuc_int;              
                
                         /*IF (g_usado_aux=0 AND g_nuevo_aux=0) THEN
                            EXIT;
                         END IF;*/
                
                     END LOOP;
                     CLOSE g_cursor2_int;   
                 ELSE
                     g_sw:='false';
                     --EXIT;
                 END IF;  
              END LOOP;
            CLOSE g_cursor_int; 
            
              -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Verificacion exitosa de pedido de TUC en la salida  id_salida='||al_id_salida;
            g_respuesta := 't'||g_separador||g_descripcion_log_error||g_separador||g_sw;     
        
        END;  
    ELSIF pm_codigo_procedimiento = 'AL_OSUCDE_DEL_TMP' THEN

        BEGIN
            --BORRADO DE LOS DATOS DE LA TABLA TEMPORAL DE VERIFICACION
            DELETE FROM almin.tal_pedido_tuc_tmp
            WHERE id_salida = al_id_salida;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminación exitosa de los datos de la tabla almin.tal_peidodo_tuc_tmp  id_salida='||al_id_salida;
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END; 
        
    ELSIF pm_codigo_procedimiento = 'AL_OSUCDE_DEL_INT' THEN

        BEGIN
            --BORRADO DE LOS DATOS DE LA TABLA INTERMEDIA DE VERIFICACION
            DELETE FROM almin.tal_pedido_tuc_int
            WHERE id_salida = al_id_salida;

            --DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminación exitosa de los datos de la tabla almin.tal_peidodo_tuc_int  id_salida='||al_id_salida;
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;     
       
    ELSIF pm_codigo_procedimiento = 'AL_OSUCDE_UPD_TIPENTR' THEN

        BEGIN
            --BORRADO DE LOS DATOS DE LA TABLA INTERMEDIA DE VERIFICACION
            --al repeticion  null, verifiicado, total, parcial
            UPDATE almin.tal_salida SET
            tipo_entrega = al_repeticion
            WHERE id_salida = al_id_salida;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificado tipo de entrega='||al_repeticion;
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;     
            
     
    ELSIF pm_codigo_procedimiento = 'AL_VERIFRES_EXI_INT' THEN
    --Verifica y realiza la reserva de las existencias del pedido, y define el Tipo de Entrega como Parcial o Total
        BEGIN
            g_sw:='true';
            
            --SE OBTIENE EL ALMACÉN LÓGICO
            SELECT 
                 id_almacen_logico,
                 s.id_parametro_almacen
            INTO 
                 g_id_almacen_logico,
                 g_id_parametro_almacen
            FROM almin.tal_salida s
            WHERE id_salida = al_id_salida;
            
            
            
            raise notice 'id_salida: %     id_almacen_logico: %     id_parametro_almacen: %',al_id_salida,g_id_almacen_logico,g_id_parametro_almacen;
            
            OPEN g_cursor_int(g_id_parametro_almacen,al_id_salida,g_id_almacen_logico);
            LOOP

                FETCH g_cursor_int INTO g_registro_cursor;
                EXIT WHEN NOT FOUND;

                g_nuevo_aux:=g_registro_cursor.nuevo;
                g_usado_aux:=g_registro_cursor.usado;
                
                raise notice '###########   g_nuevo_aux: %     g_usado_aux: %',g_nuevo_aux,g_usado_aux;

                IF(g_usado_aux>0 OR g_nuevo_aux>0) THEN
                    raise notice 'entra if';
                    OPEN g_cursor2_int(g_registro_cursor.id_item,al_id_salida);
                    LOOP
                        FETCH g_cursor2_int INTO g_registro_cursor2;
                        EXIT WHEN NOT FOUND;
                        raise notice 'cant. solicitada: %',g_registro_cursor2.cantidad_solicitada;
                        IF (g_nuevo_aux > g_registro_cursor2.cantidad_solicitada) THEN
                            g_nuevo_aux :=g_nuevo_aux-g_registro_cursor2.cantidad_solicitada;
                            g_nuevo_ins:=g_registro_cursor2.cantidad_solicitada;
                            g_usado_ins:=0;
                        ELSIF (g_nuevo_aux + g_usado_aux> g_registro_cursor2.cantidad_solicitada) THEN
                            g_nuevo_ins:=g_nuevo_aux;
                            g_usado_ins:=g_registro_cursor2.cantidad_solicitada - g_nuevo_aux;
                            g_nuevo_aux:=0;
                            g_usado_aux:=g_usado_aux - g_registro_cursor2.cantidad_solicitada + g_nuevo_ins;
                        ELSE
                            g_sw:='false';
                            g_nuevo_ins:=g_nuevo_aux;
                            g_usado_ins:=g_usado_aux;
                            g_nuevo_aux:=0;
                            g_usado_aux:=0;
                            
                        END IF;


                        raise notice 'g_nuevo_ins: %     g_usado_ins: %',g_nuevo_ins,g_usado_ins;
                        raise notice 'id_pedido_tuc_int: %    id_item: %',g_registro_cursor2.id_pedido_tuc_int,g_registro_cursor2.id_item;
                        
                        UPDATE almin.tal_pedido_tuc_int SET
                        nuevo = g_nuevo_ins,
                        usado = g_usado_ins
                        WHERE id_pedido_tuc_int = g_registro_cursor2.id_pedido_tuc_int;
                        
                        --SE HACE LA RESERVA DEL MATERIAL
                        IF g_nuevo_ins > 0 THEN --Nuevos
                            UPDATE almin.tal_kardex_logico SET
                            reservado = COALESCE(reservado,0) + g_nuevo_ins
                            WHERE id_almacen_logico = g_id_almacen_logico
                            AND id_item = g_registro_cursor2.id_item
                            AND id_parametro_almacen = g_id_parametro_almacen
                            AND estado_item = 'Nuevo';
                        END IF;
                        
                        IF g_usado_ins > 0 THEN --Usados
                            UPDATE almin.tal_kardex_logico SET
                            reservado = COALESCE(reservado,0) + g_usado_ins
                            WHERE id_almacen_logico = g_id_almacen_logico
                            AND id_item = g_registro_cursor2.id_item
                            AND id_parametro_almacen = g_id_parametro_almacen
                            AND estado_item = 'Usado';
                        END IF;

                        --Verifica si las cantidades se consumieron para salir
                        IF (g_usado_aux=0 AND g_nuevo_aux=0) THEN
                            EXIT;
                        END IF;

                    END LOOP;
                    CLOSE g_cursor2_int;
                END IF;
            END LOOP;

            raise notice 'tipo entrega: %',g_sw;
            --Se cambia el Tipo de Entrega en función de si las existencias abastecen el pedido
            IF g_sw = 'true' THEN --Existencias suficientes
                raise notice 'suficientes';
                UPDATE almin.tal_salida SET
                tipo_entrega = 'Total'
                WHERE id_salida = al_id_salida;
            ELSE --Existencias insuficientes
                raise notice 'insuficientes';
                UPDATE almin.tal_salida SET
                tipo_entrega = 'Parcial'
                WHERE id_salida = al_id_salida;
            END IF;
            
            CLOSE g_cursor_int;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Verificacion y Reserva exitosa de pedido de TUC en la salida  id_salida='||al_id_salida;
            g_respuesta := 't'||g_separador||g_descripcion_log_error||g_separador||g_sw;
        END;
        
    ELSIF pm_codigo_procedimiento = 'AL_OSUCDE_DEL_RES' THEN
        --Borra los datos de la tabla intermedia y libera las reservas si es que hubieron
        BEGIN
        
           --RAC 05/12/2016  recuepra gestion vigente por almacen logico
            SELECT 
                  pl.id_parametro_almacen,
                  pl.id_parametro_almacen_logico
            INTO 
                  g_id_parametro_almacen,
                  g_id_parametro_almacen_logico
            FROM almin.tal_parametro_almacen_logico pl
            WHERE estado  = 'abierto'
                  and pl.id_almacen_logico = al_id_almacen_logico;
                  
                  
            --VERIFICA SI YA SE RESERVÓ EL MATERIAL
            IF EXISTS(SELECT 1 FROM almin.tal_salida
                      WHERE id_salida = al_id_salida
                      AND tipo_entrega IN ('Parcial','Total')) THEN

                --SE LIBERAN LOS ITEMS RESERVADOS
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
                AND almin.tal_kardex_logico.id_parametro_almacen = SALIDA.id_parametro_almacen
                AND almin.tal_kardex_logico.estado_item = ITEMS.estado_item;
                
            END IF;
            
            --BORRADO DE LOS DATOS DE LA TABLA INTERMEDIA DE VERIFICACION
            DELETE FROM almin.tal_pedido_tuc_int
            WHERE id_salida = al_id_salida;

            --DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminación exitosa de los datos de la tabla almin.tal_peidodo_tuc_int  id_salida='||al_id_salida;
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
    ELSIF pm_codigo_procedimiento = 'AL_VERIF_TIPOENT' THEN
        --Verifica el tipo de Entrega de un Pedido TUC
        BEGIN
            --VERIFICA SI YA SE RESERVÓ EL MATERIAL
            IF NOT EXISTS(SELECT 1 FROM almin.tal_salida
                          WHERE id_salida = al_id_salida
                          AND tipo_pedido <> 'Item') THEN

                g_descripcion_log_error := 'Aprobación no realizada: Pedido de (Tipo de) Unidad Constructiva inexistente';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                
            END IF;

            SELECT COALESCE(tipo_entrega,'')
            INTO g_sw
            FROM almin.tal_salida
            WHERE id_salida = al_id_salida;

            --DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminación exitosa de los datos de la tabla almin.tal_pedido_tuc_int  id_salida='||al_id_salida;
            g_respuesta := 't'||g_separador||g_descripcion_log_error||g_separador||g_sw;
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

    ---*** REGISTRO EN EL LOG EL ÉXITO DE LA EJECUCIÓN DEL PROCEDIMIENTO
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