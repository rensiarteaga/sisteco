--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_tal_tuc_arb_sel (
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
  al_raiz integer,
  al_id_almacen_logico integer
)
RETURNS SETOF record AS
$body$
                  	/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ...
***************************************************************************
 SCRIPT: 		almin.f_tal_tuc_arb_sel
 DESCRIPCIÓN: 	Devuelve las consultas a la tabla almin.tal_composicion_tuc
 AUTOR: 		(Generado Automaticamente)
 FECHA:			2007-11-06 16:27:45
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
    g_rol_adm		           boolean;	-- Identifica si el usuario tiene rol administrador
    v_id_parametro_almacen_logico	integer;
    v_id_parametro_almacen			INTEGER;

BEGIN

    ---*** INICIACIÓN DE VARIABLES
    g_privilegio_procedimiento := FALSE;
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
    g_nombre_funcion := 'almin.f_tal_tuc_arb_sel';

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

    ---***SELECCIÓN DE OPERACIÓN A REALIZAR
    IF pm_codigo_procedimiento  = 'AL_TIPOUC_AGRUP_SEL' THEN
        BEGIN
            g_consulta := ' SELECT
							TIPOUC.id_tipo_unidad_constructiva,
							TIPOUC.codigo,
							TIPOUC.nombre,
							TIPOUC.tipo,
							TIPOUC.descripcion,
							TIPOUC.observaciones,
							TIPOUC.fecha_reg,
							1 as cantidad,
                            ''no''::varchar as opcional,
                            ''no''::varchar as considerar_repeticion,
                            TIPOUC.estado
							FROM almin.tal_tipo_unidad_constructiva TIPOUC
						  	WHERE TIPOUC.tipo = ''Agrupador'' AND ';


            g_consulta := g_consulta || pm_criterio_filtro;
	        -- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
--            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;

    ELSIF pm_codigo_procedimiento  = 'AL_TIPOUC_REEMP_SEL' THEN
    --DESPLIEGA TODOS LOS TUC QUE NO SON AGRUPADORES, SON RAMAS Y ESTÁN TERMINADOS, PARA REGISTRAR REEMPLAZOS
        BEGIN
            g_consulta := 'SELECT
                           TIPOUC.id_tipo_unidad_constructiva,
                           TIPOUC.codigo,
                           TIPOUC.nombre,
                           TIPOUC.tipo,
                           TIPOUC.descripcion,
                           TIPOUC.observaciones,
                           TIPOUC.fecha_reg
                           FROM almin.tal_tipo_unidad_constructiva TIPOUC
                           WHERE TIPOUC.tipo <> ''Agrupador''
                           AND TIPOUC.estado = ''Terminado''
                           AND TIPOUC.tipo = ''Rama'' AND ' ;

            g_consulta := g_consulta || pm_criterio_filtro;
	        -- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
--            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;

    ELSIF pm_codigo_procedimiento  = 'AL_TIPOUC_REEMP_COUNT' THEN
    --CUENTA TODOS LOS TUC QUE NO SON AGRUPADORES, SON RAMAS Y ESTÁN TERMINADOS, PARA REGISTRAR REEMPLAZOS
        BEGIN
            g_consulta := 'SELECT
                           COUNT(TIPOUC.id_tipo_unidad_constructiva) as total
                           FROM almin.tal_tipo_unidad_constructiva TIPOUC
                           WHERE TIPOUC.tipo <> ''Agrupador''
                           AND TIPOUC.estado = ''Terminado''
                           AND TIPOUC.tipo = ''Rama'' AND ' ;

            g_consulta := g_consulta || pm_criterio_filtro;
	        -- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            --g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
--            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;

    ELSIF pm_codigo_procedimiento  = 'AL_TIPOUC_RAIZ_SEL' THEN
        BEGIN
            /*g_consulta := 'SELECT
							TIPOUC.id_tipo_unidad_constructiva,
							TIPOUC.codigo,
							TIPOUC.nombre,
							TIPOUC.tipo,
							TIPOUC.descripcion,
							TIPOUC.observaciones,
							TIPOUC.fecha_reg,
							1 as cantidad,
                            ''no''::varchar as opcional,
                            ''no''::varchar as considerar_repeticion,
                            TIPOUC.estado
							FROM almin.tal_tipo_unidad_constructiva TIPOUC
						  	WHERE tipo = ''Raiz'' AND ';*/
						  	
	  	    g_consulta := 'SELECT
                           		TIPOUC.id_tipo_unidad_constructiva,
                           		TIPOUC.codigo,
                           		TIPOUC.nombre,
                           		TIPOUC.tipo,
                           		TIPOUC.descripcion,
                           		TIPOUC.observaciones,
                           		COMTUC.id_composicion_tuc,
                           		COMTUC.cantidad,
                           		COMTUC.opcional,
                           		COMTUC.id_tipo_unidad_constructiva as id_tuc_padre,
                           		TIPOUCC.nombre as nombre_padre,
                           		''no''::varchar as considerar_repeticion,
                           		TIPOUC.estado
                           FROM almin.tal_composicion_tuc COMTUC
                            	INNER JOIN almin.tal_tipo_unidad_constructiva TIPOUC ON
      							TIPOUC.id_tipo_unidad_constructiva = COMTUC.id_tuc_hijo
     							INNER JOIN almin.tal_tipo_unidad_constructiva TIPOUCC ON
      							TIPOUCC.id_tipo_unidad_constructiva = COMTUC.id_tipo_unidad_constructiva
     							
                           WHERE COMTUC.id_tipo_unidad_constructiva = '||COALESCE(al_raiz,'0')||'
                            AND ';


            g_consulta := g_consulta || pm_criterio_filtro;
	        -- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
--            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;



    -- PARA LA CONSULTA DE SELECCIÓN
    ELSIF pm_codigo_procedimiento  = 'AL_TIPOUC_RAIZ_COUNT' THEN

        BEGIN
        --Cuenta todos los registros
            g_consulta := 	'SELECT
                          	COUNT(TIPOUC.id_tipo_unidad_constructiva) AS total
                          	FROM almin.tal_tipo_unidad_constructiva TIPOUC
                            INNER JOIN almin.tal_tipo_unidad_constructiva TIPOUC ON
      							TIPOUC.id_tipo_unidad_constructiva = COMTUC.id_tuc_hijo
     							INNER JOIN almin.tal_tipo_unidad_constructiva TIPOUCC ON
      							TIPOUCC.id_tipo_unidad_constructiva = COMTUC.id_tipo_unidad_constructiva
     						
						  	WHERE tipo=''Raiz'' 
                            
                            AND ';
            g_consulta := g_consulta || pm_criterio_filtro;
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;

            ---***SELECCIÓN DE OPERACIÓN A REALIZAR
    ---***SELECCIÓN DE OPERACIÓN A REALIZAR
    ELSIF pm_codigo_procedimiento  = 'AL_TIPOUC_RAMAS_SEL' THEN

        BEGIN
						
            g_consulta := 'SELECT
                           TIPOUC.id_tipo_unidad_constructiva,
                           TIPOUC.codigo,
                           TIPOUC.nombre,
                           TIPOUC.tipo,
                           TIPOUC.descripcion,
                           TIPOUC.observaciones,
                           COMTUC.id_composicion_tuc,
                           COMTUC.cantidad,
                           COMTUC.opcional,
                           COMTUC.id_tipo_unidad_constructiva as id_tuc_padre,
                           TIPOUCC.nombre as nombre_padre,
                           ''no''::varchar as considerar_repeticion,
                           TIPOUC.estado
                           FROM almin.tal_composicion_tuc COMTUC
                           INNER JOIN almin.tal_tipo_unidad_constructiva TIPOUC
                           ON TIPOUC.id_tipo_unidad_constructiva = COMTUC.id_tuc_hijo
                           INNER JOIN almin.tal_tipo_unidad_constructiva TIPOUCC
                           ON TIPOUCC.id_tipo_unidad_constructiva = COMTUC.id_tipo_unidad_constructiva
                           WHERE COMTUC.id_tipo_unidad_constructiva = '||COALESCE(al_raiz,'0')||' AND ';
            g_consulta := g_consulta || pm_criterio_filtro;
	        -- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
--            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;


    -- PARA LA CONSULTA DE SELECCIÓN
 ELSIF pm_codigo_procedimiento  = 'AL_TIPOUC_RAMAS_COUNT' THEN

        BEGIN
            --Cuenta todos los registros

			g_consulta := 	'SELECT COUNT(COMPTUC.id_composicion_tuc)
                          	 FROM almin.tal_composicion_tuc COMTUC
                             INNER JOIN almin.tal_tipo_unidad_constructiva TIPOUC
                             ON TIPOUC.id_tipo_unidad_constructiva = COMTUC.id_tuc_hijo
                             INNER JOIN almin.tal_tipo_unidad_constructiva TIPOUCC
                             ON TIPOUCC.id_tipo_unidad_constructiva = COMTUC.id_tipo_unidad_constructiva
                             
                             WHERE COMTUC.id_tipo_unidad_constructiva = '||COALESCE(al_raiz,'0')||' AND ';
            g_consulta := g_consulta || pm_criterio_filtro;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta de cantidad registrada';
        END;
    ELSIF pm_codigo_procedimiento  = 'AL_TIPOUC_ITEM_SEL' THEN
        BEGIN
            g_consulta := 'SELECT
                           COMP.id_componente,
                           COMP.id_item,
                           COMP.id_tipo_unidad_constructiva,
                           ITEM.codigo as codigo_item,
                           ITEM.nombre as nombre_item,
                           ''item''::varchar as tipo,
                           ITEM.descripcion,
                     
                           COMP.descripcion as observaciones,
                           COMP.cantidad,
                     
                           ''no''::varchar as opcional,
                           COMP.cosiderar_repeticion,
                           CASE SUPGRU.demasia
    					       WHEN ''si'' THEN (SELECT CEIL(COMP.cantidad*(demasia_porc/100)) FROM almin.tal_parametro_almacen WHERE cierre = ''no'' ORDER BY gestion DESC LIMIT 1)
    						   ELSE 0
						   END as cant_demasia,
						   CASE SUPGRU.demasia
    						   WHEN ''si'' THEN (SELECT CEIL(COMP.cantidad + comp.cantidad*(demasia_porc/100)) FROM almin.tal_parametro_almacen WHERE cierre = ''no'' ORDER BY gestion DESC LIMIT 1)
    						   ELSE COMP.cantidad
						   END as cant_tot,
            			   (SELECT demasia_porc FROM almin.tal_parametro_almacen WHERE cierre = ''no'' ORDER BY gestion DESC LIMIT 1) as demasia_porc,
 ITEM.calidad,
                   SUPGRU.nombre as nombre_super
                   
       FROM almin.tal_componente COMP
                           INNER JOIN almin.tal_item ITEM
                           ON ITEM.id_item=COMP.id_item
                           INNER JOIN almin.tal_supergrupo SUPGRU
						   ON SUPGRU.id_supergrupo = ITEM.id_supergrupo
						   WHERE COMP.id_tipo_unidad_constructiva='||al_raiz||' AND ';
            g_consulta := g_consulta || pm_criterio_filtro;
	-- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
--            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;
		
            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;
    /*
    Autor:	RAC
    Fecha:	12/01/2017
    DESC	-  se uamenta los  filtros para que la busqueda solo sea en la gestion abierta, filtrando por almacen logico
    
    */     
    ELSIF pm_codigo_procedimiento  = 'AL_EXTITE_SEL' THEN --Existencias por Item y UC  RAICES
    --Devuelve todos los items de una UC y sus existencias (incluidos items de sus reemplazos)
        BEGIN
        
            select 
               p.id_parametro_almacen
             into
               v_id_parametro_almacen
            from almin.tal_parametro_almacen_logico p
            where p.id_parametro_almacen_logico = al_id_almacen_logico
            and  p.estado = 'abierto' ;
            
            IF  v_id_parametro_almacen is null THEN
               raise exception 'no se encontro gestion abierta para el almacen logico ID %',al_id_almacen_logico;
            END IF;
            
           
            g_consulta := 'SELECT
						   item_uc.id_item, COALESCE(SUM(KARLOG.cantidad),0) as cantidad,
							(SELECT COUNT(COMPON1.id_tipo_unidad_constructiva)
							FROM almin.tal_componente COMPON1
							WHERE (COMPON1.id_tipo_unidad_constructiva IN (SELECT id_tuc_hijo
						 					 								FROM almin.tal_composicion_tuc
                         					 								WHERE id_tipo_unidad_constructiva = ' ||al_raiz || ')
      								OR COMPON1.id_tipo_unidad_constructiva IN (SELECT
																				id_tipo_unidad_constructiva
																				FROM almin.tal_tipo_unidad_cons_reemp
																				WHERE id_composicion_tuc IN (SELECT
							 																				id_composicion_tuc
							 																				FROM almin.tal_composicion_tuc
                             																				WHERE id_tipo_unidad_constructiva = ' ||al_raiz || ')
       																			)
		      					)		
								AND COMPON1.id_item = item_uc.id_item
								GROUP BY COMPON1.id_item) as cant_repetida
						   FROM
						  (SELECT
			               DISTINCT COMPON.id_item
						   FROM almin.tal_componente COMPON
						   WHERE (COMPON.id_tipo_unidad_constructiva IN (SELECT id_tuc_hijo
						 					 							 FROM almin.tal_composicion_tuc
                         					 							 WHERE id_tipo_unidad_constructiva = ' ||al_raiz || ')
	   					   OR COMPON.id_tipo_unidad_constructiva IN (SELECT
																	 id_tipo_unidad_constructiva
																	 FROM almin.tal_tipo_unidad_cons_reemp
																	 WHERE id_composicion_tuc IN (SELECT
							 																	  id_composicion_tuc
							 																	  FROM almin.tal_composicion_tuc
                             																	  WHERE id_tipo_unidad_constructiva = ' ||al_raiz || ')
       											)
       						)
						  GROUP BY COMPON.id_item
                          ORDER BY COMPON.id_item) as item_uc
						LEFT JOIN almin.tal_kardex_logico KARLOG
						ON KARLOG.id_item = item_uc.id_item  AND KARLOG.id_almacen_logico = '||COALESCE(al_id_almacen_logico,0) ||' AND KARLOG.id_parametro_almacen = '||COALESCE(v_id_parametro_almacen,0) ||'
						GROUP BY item_uc.id_item';


            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;   
        
    ELSIF pm_codigo_procedimiento  = 'AL_EXIRAM_SEL' THEN --Existencias por Item y UC    RAMA
    --Devuelve todos los items de una UC y sus existencias (incluidos items de sus reemplazos)
        BEGIN
        
            --obtener gestion abierta
            
            
            select 
               p.id_parametro_almacen
             into
               v_id_parametro_almacen
            from almin.tal_parametro_almacen_logico p
            where p.id_parametro_almacen_logico = al_id_almacen_logico
            and  p.estado = 'abierto' ;
            
            IF  v_id_parametro_almacen is null THEN
               raise exception 'no se encontro gestion abierta para el almacen logico ID %',al_id_almacen_logico;
            END IF;
            
        
        
            g_consulta := 'SELECT
						COMPON.id_item, sum(COALESCE(KARLOG.cantidad,0)), 1 as cant_repetida
						FROM almin.tal_componente COMPON
						LEFT JOIN almin.tal_kardex_logico KARLOG
						ON KARLOG.id_item = COMPON.id_item
						WHERE COMPON.id_tipo_unidad_constructiva = ' ||al_raiz || ' AND KARLOG.id_almacen_logico = '||COALESCE(al_id_almacen_logico,0) ||' KARLOG.id_parametro_almacen = '||COALESCE(v_id_parametro_almacen,0) ||' 
						GROUP BY COMPON.id_item
						ORDER BY COMPON.id_item';

            --g_consulta := g_consulta || pm_criterio_filtro;
	        -- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            --g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
--            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END; 
        
    ELSIF pm_codigo_procedimiento  = 'AL_SALIUC_SEL' THEN --Salidas de UC por Origen
    --Devuelve todas las salidas de un UC con el origen del pedido
        BEGIN
            g_consulta := 'SELECT
							SALIDA_UC.id_tipo_unidad_constructiva, SALIDA_UC.codigo,SALIDA_UC.nombre,
							SALIDA_UC.origen, SUM(SALIDA_UC.cantidad) as cantidad
							FROM 
							(SELECT
							SAORUC.id_tipo_unidad_constructiva,TIPOUC.codigo,TIPOUC.nombre,SAORUC.cantidad,
							CASE COALESCE(SALIDA.id_contratista,0)
							    WHEN 0 THEN
							        CASE COALESCE(SALIDA.id_institucion,0)
							            WHEN 0 THEN
							                (SELECT COALESCE(apellido_paterno,'''')||'' ''||COALESCE(apellido_materno,'''')||'' ''||COALESCE(nombre,'''')
							                 FROM sss.tsg_persona WHERE id_persona = EMPLEA.id_persona)
							            ELSE
							            	INSTIT.nombre
							        END
							    ELSE
							    	(SELECT nombre FROM param.tpm_institucion WHERE id_institucion = CONTRA.id_institucion)
							END as origen
							FROM almin.tal_salida SALIDA
							INNER JOIN almin.tal_orden_salida_uc_detalle SAORUC
							ON SAORUC.id_salida = SALIDA.id_salida
							INNER JOIN almin.tal_tipo_unidad_constructiva TIPOUC
							ON TIPOUC.id_tipo_unidad_constructiva = SAORUC.id_tipo_unidad_constructiva
							LEFT JOIN param.tpm_contratista CONTRA
							ON CONTRA.id_contratista = SALIDA.id_contratista
							LEFT JOIN param.tpm_institucion INSTIT
							ON INSTIT.id_institucion = SALIDA.id_institucion
							LEFT JOIN kard.tkp_empleado EMPLEA
							ON EMPLEA.id_empleado = SALIDA.id_empleado
							WHERE (SAORUC.id_tipo_unidad_constructiva IN (SELECT id_tuc_hijo
						 												 FROM almin.tal_composicion_tuc
							                         					 WHERE id_tipo_unidad_constructiva = '|| al_raiz ||')
						      OR SAORUC.id_tipo_unidad_constructiva IN (SELECT
																		id_tipo_unidad_constructiva
																		FROM almin.tal_tipo_unidad_cons_reemp
																		WHERE id_composicion_tuc IN (SELECT
							 																		id_composicion_tuc
							 																		FROM almin.tal_composicion_tuc
						                             												WHERE id_tipo_unidad_constructiva = '|| al_raiz ||')
					       											)
						      )
							--AND SALIDA.estado_salida = ''Finalizado''
							ORDER BY SALIDA.id_salida, TIPOUC.nombre, origen) as SALIDA_UC
							GROUP BY SALIDA_UC.id_tipo_unidad_constructiva, SALIDA_UC.codigo,SALIDA_UC.nombre,
							SALIDA_UC.origen';

            --g_consulta := g_consulta || pm_criterio_filtro;
	        -- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            --g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
--            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;
        
    ELSIF pm_codigo_procedimiento  = 'AL_TUCPAD_SEL' THEN 
    --RCM 18/07/2008: LISTA LOS DATOS DE UN TIPO DE UNIDAD CONSTRUCTIVA MAS LOS DATOS DE SU PADRE
        BEGIN
            g_consulta := 'SELECT 
							TIPOUC.id_tipo_unidad_constructiva, TIPOUC.nombre,
							TIPOUC1.id_tipo_unidad_constructiva as id_tuc_padre, TIPOUC1.nombre as nombre_padre,
							1 as cantidad, TIPOUC.codigo, TIPOUC1.codigo as codigo_padre
							FROM almin.tal_tipo_unidad_constructiva TIPOUC
							LEFT JOIN almin.tal_composicion_tuc COMPON
							ON COMPON.id_tuc_hijo = TIPOUC.id_tipo_unidad_constructiva
							LEFT JOIN almin.tal_tipo_unidad_constructiva TIPOUC1
							ON TIPOUC1.id_tipo_unidad_constructiva = COMPON.id_tipo_unidad_constructiva
 						    WHERE TIPOUC.id_tipo_unidad_constructiva='||al_raiz;
            --g_consulta := g_consulta || pm_criterio_filtro;
			-- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            --g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
--            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;

            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;

            -- DESCRIPCIÓN DE ÉXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;
        
    ELSIF pm_codigo_procedimiento  = 'AL_UCITEX_SEL' THEN --Tipo Unidad Constructiva Item Existencias
    --RCM 18/07/2008: LISTA LA EXISTENCIA DE TODOS LOS ITEMS DE UN TIPO DE UNIDAD CONSTRUCTIVA
        BEGIN
            g_consulta := 'SELECT 
							ITEMS.id_item, COALESCE(SUM(KARLOG.cantidad),0) as cantidad
							FROM
							(SELECT
							DISTINCT COMPON.id_item
							FROM almin.tal_componente COMPON
							WHERE COMPON.id_tipo_unidad_constructiva = '||al_raiz||'
							ORDER BY COMPON.id_item) ITEMS
							LEFT JOIN almin.tal_kardex_logico KARLOG
							ON KARLOG.id_item = ITEMS.id_item
							GROUP BY ITEMS.id_item';
                            
            --g_consulta := g_consulta || pm_criterio_filtro;
			-- SE AUMENTA EL ORDEN Y LOS PARÁMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            --g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
--            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;

            FOR g_registros in EXECUTE(g_consulta) LOOP
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