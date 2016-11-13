--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_ai_reportes (
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
  pm_id_actividad varchar
)
RETURNS SETOF record AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ALMACEN
***************************************************************************
 SCRIPT:          	alma.f_ai_reportes
 DESCRIPCIÃ??N:      none
 AUTOR:           	unknow
 FECHA:         	08072014
 COMENTARIOS:    

***************************************************************************/
--------------------------
-- CUERPO DE LA FUNCIÃ??N --
--------------------------

-- PARÃ?ÂMETROS FIJOS
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
pm_cant
pm_puntero
pm_sortcol
pm_sortdir
pm_criterio_filtro
pm_id_financiador
pm_id_regional
pm_id_programa
pm_id_proyecto
pm_id_actividad

*/

-- DECLARACIÃ??N DE VARIABLES PARTICULARES


-- DECLARACIÃ??N DE VARIABLES DE LA FUNCIÃ??N (LOCALES)

DECLARE

    --PARÃ?ÂMETROS FIJOS
    g_id_subsistema            integer; -- ID SUBSISTEMA
    g_id_lugar                 integer; -- ID LUGAR
    g_numero_error             varchar; -- ALMACENA EL NÃ??MERO DE ERROR
    g_mensaje_error            varchar; -- ALMACENA MENSAJE DEL ERROR
    
    g_privilegio_procedimiento boolean; -- BANDERA PARA VERIFICAR LLAMADA DE PROCEDIMIENTO
        
    g_descripcion_log_error    text;    -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento               boolean;
    g_reg_error                boolean;
    g_registros                record;  -- PARA ALMACENAR EL CONJUNTO DE DATOS RESULTADO DEL SELECT
    g_respuesta                varchar; -- VARIABLE QUE CONTENDRÃ?Â LOS MENSAJES DE ERROR
    g_consulta                 text;    -- VARIABLE QUE CONTENDRÃ?Â LA CONSULTA DINÃ?ÂMICA PARA EL FILTRO
    g_nivel_error              varchar; -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                        --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                        --      ERROR LÃ??GICO (CRÃ?ÂTICO) = 2
                                        --      ERROR LÃ??GICO (INTERMEDIO) = 3
                                        --      ERROR LÃ??GICO (ADVERTENCIA) = 4
    g_nombre_funcion           varchar; --NOMBRE FÃ?ÂSICO DE LA FUNCIÃ??N
    g_separador                varchar(10); --Caracteres que servirÃ?Â¡n para separar el mensaje, nivel y origen del error
    g_rol_adm		           boolean;	-- Identifica si el usuario tiene rol administrador
    g_res					   varchar;
    
    g_control_precios		   record;
    
    g_parametros				varchar [];
    g_item_valoracion			record;
    g_valoracion				record;
    g_contador					numeric;
    g_id_item					integer;
    g_aux						record;
    g_auxiliar					varchar;
  
    
BEGIN

    ---*** INICIACIÃ??N DE VARIABLES
    g_privilegio_procedimiento := FALSE;
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funciÃ?Â³n
    g_nombre_funcion :='f_ai_reportes';
    g_rol_adm:= false;
    ---*** VERIFICACIÃ??N ROL ADMINISTRADOR
    
    IF EXISTS(SELECT 1 FROM sss.tsg_usuario_rol usrol WHERE usrol.id_usuario = pm_id_usuario AND usrol.id_rol=1) THEN
        g_rol_adm := true;
    END IF;
    
    ---*** OBTENCIÃ??N DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;

    ---*** OBTENCIÃ??N DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT ul.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar ul
    WHERE  ul.id_usuario = pm_id_usuario;


    ---*** VALIDACIÃ??N DE LLAMADA POR USUARIO O FUNCIÃ??N
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

    ---*** VERIFICACIÃ??N DE PERMISOS DEL USUARIO
    IF NOT g_privilegio_procedimiento THEN
       g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;
 

    ---*** SI NO SE TIENE PERMISOS DE EJECUCIÃ??N SE RETORNA EL MENSAJE DE ERROR
    IF NOT (g_privilegio_procedimiento ) THEN
    
        g_nivel_error := '3';
        g_descripcion_log_error := 'El usuario no tiene permisos de ejecucion del procedimiento';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

    --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                             pm_codigo_procedimiento   ,pm_proc_almacenado);
        --DEVUELVE MENSAJE DE ERROR
        RAISE EXCEPTION '%',g_descripcion_log_error;
    END IF; 

    ---***SELECCIÃ??N DE OPERACIÃ??N A REALIZAR
    IF pm_codigo_procedimiento  = 'AL_REP_MOVSOL' THEN
        BEGIN
        	  g_consulta := 'SELECT   tipmov.tipo,mov.codigo
                                      ,al.codigo||'' - ''||al.nombre as almacen
                                      ,to_char(mov.fecha_finalizacion,''dd'')::varchar as dia_fin,to_char(mov.fecha_finalizacion,''MM'')::VARCHAR as mes_fin,to_char(mov.fecha_finalizacion,''YYYY'')::VARCHAR as anio_fin
                                      ,mov.descripcion
                                      ,it.codigo||'' - ''||it.descripcion as det_item
                                      ,uni.nombre as unidad_medida
                                      ,detmov.cantidad_solicitada
                                      ,detmov.cantidad as cant_entregada
                                      ,detmov.tipo_saldo
                                      ,mov.observaciones
              							
                              FROM alma.tai_movimiento mov  
                              INNER JOIN alma.tai_detalle_movimiento detmov on detmov.id_movimiento=mov.id_movimiento
                              INNER JOIN alma.tai_almacen al on al.id_almacen=mov.id_almacen and al.estado=''activo''
                              INNER JOIN alma.tai_tipo_movimiento tipmov on tipmov.id_tipo_movimiento=mov.id_tipo_movimiento
                              INNER JOIN alma.tai_item it on it.id_item=detmov.id_item
                              INNER JOIN param.tpm_unidad_medida_base uni on uni.id_unidad_medida_base=it.id_unidad_medida and uni.estado_registro=''activo''
                              WHERE   ';

                                  
            g_consulta := g_consulta || pm_criterio_filtro;
			-- SE AUMENTA EL ORDEN Y LOS PARÃ?ÂMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;
            
            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;
                
            -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;
     
    	ELSIF pm_codigo_procedimiento  = 'AL_REP_MOV' THEN

        BEGIN
			EXECUTE('CREATE TEMP SEQUENCE numero_fila START 1;');
        
            g_consulta := 'SELECT 	  
            						  doc.documento as desc_documento
            						  ,mov.codigo
                                      ,al.codigo||'' - ''||al.nombre as almacen
                                      ,to_char(mov.fecha_finalizacion,''dd'')::varchar as dia_fin,to_char(mov.fecha_finalizacion,''MM'')::VARCHAR as mes_fin,to_char(mov.fecha_finalizacion,''YYYY'')::VARCHAR as anio_fin
                                      ,mov.descripcion
                                      ,nextval(''numero_fila'') as fila
                                      ,it.codigo||'' - ''||it.descripcion as det_item
                                      ,uni.nombre as unidad_medida
                                      ,detmov.cantidad
                                      ,detmov.costo_unitario as precio_unitario,detmov.costo_total as precio_total
                                      ,mov.observaciones
                                      --añadido 2707/2015
                                      ,mov.nro_compra
                                      ,(detmov.costo_unitario*detmov.cantidad) as precio_promedio
                              FROM alma.tai_movimiento mov  
                              INNER JOIN alma.tai_detalle_movimiento detmov on detmov.id_movimiento=mov.id_movimiento
                              INNER JOIN alma.tai_almacen al on al.id_almacen=mov.id_almacen and al.estado=''activo''
                              INNER JOIN alma.tai_tipo_movimiento tipmov on tipmov.id_tipo_movimiento=mov.id_tipo_movimiento
                              INNER JOIN alma.tai_item it on it.id_item=detmov.id_item
                              INNER JOIN param.tpm_unidad_medida_base uni on uni.id_unidad_medida_base=it.id_unidad_medida and uni.estado_registro=''activo''
                              LEFT JOIN param.tpm_documento doc on doc.id_documento=tipmov.id_documento and doc.estado=''activo''
                              WHERE    ';
            
            g_consulta := g_consulta || pm_criterio_filtro;
            
			-- SE AUMENTA EL ORDEN Y LOS PARÃ?ÂMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
           -- g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;
          
            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;
            
            EXECUTE('DROP  SEQUENCE  numero_fila;');
                        
            -- DESCRIPCIÃ??N DE Ã??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;
        
        ELSIF pm_codigo_procedimiento  = 'AL_REP_SOL' THEN
        BEGIN
            g_consulta := 'SELECT 	sal.codigo
                                    ,al.codigo||'' - ''||al.nombre as desc_almacen
                                    ,to_char(sal.fecha_solicitud,''dd'')::varchar as dia
                                    ,to_char(sal.fecha_solicitud,''MM'')::varchar as mes
                                    ,to_char(sal.fecha_solicitud,''YYYY'')::varchar as anio
                                    ,per.apellido_paterno||'' ''||per.apellido_materno||'' ''||per.nombre as desc_persona
                                    ,sal.cargo_empleado
                                    ,uni.codigo||'' - ''||uni.descripcion as desc_unidad_org
                                    ,sal.descripcion
                                    ,it.codigo||'' - ''||it.descripcion as desc_item
                                    ,med.nombre as unidad_medida
                                    ,det.cantidad as cantidad_solicitada
                                    --añadido uo_jefe,jefe y cargo_jefe
                                    ,per2.apellido_paterno||'' '' ||per2.apellido_materno||'' ''||per2.nombre as desc_jefe
        							,sal.cargo_aprobador
                                   --pendiente ,uo2.nombre_cargo as desc_uo_aprobador
                                    
                            FROM alma.tai_solicitud_salida sal
                            INNER JOIN alma.tai_almacen al on al.id_almacen=sal.id_almacen and al.estado=''activo''
                            LEFT JOIN kard.tkp_empleado emp on emp.id_empleado=sal.id_empleado
                            LEFT JOIN sss.tsg_persona per on per.id_persona=emp.id_persona
                            LEFT JOIN kard.tkp_unidad_organizacional uni on uni.id_unidad_organizacional=sal.id_unidad_organizacional
                            INNER JOIN alma.tai_detalle_solicitud det on det.id_solicitud_salida=sal.id_solicitud_salida
                            INNER JOIN alma.tai_item it on it.id_item=det.id_item and it.estado=''activo''
                            LEFT JOIN param.tpm_unidad_medida_base med on med.id_unidad_medida_base=it.id_unidad_medida
                             --añadido jefe y cargo_jefe
                            LEFT JOIN param.tpm_config_aprobador apr ON apr.id_config_aprobador = sal.id_aprobador
                            LEFT JOIN kard.tkp_unidad_organizacional uo2 ON uo2.id_unidad_organizacional = apr.id_uo
                            left join kard.tkp_empleado emp2 on emp2.id_empleado=apr.id_empleado
                          	left join sss.tsg_persona per2 on per2.id_persona=emp2.id_persona

                            WHERE    ';
            
            g_consulta := g_consulta || pm_criterio_filtro;
            
			-- SE AUMENTA EL ORDEN Y LOS PARÃ?ÂMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;
            
            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;
                
            -- DESCRIPCIÃ??N DE Ã??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;
        ELSIF pm_codigo_procedimiento  = 'AL_REP_PIEMOVSOL' THEN
        BEGIN
       
            g_consulta := 'SELECT  per.apellido_paterno||'' ''||per.apellido_materno||'' ''||per.nombre as desc_persona
                                  ,sal.cargo_empleado
                                  ,per2.apellido_paterno||'' ''||per2.apellido_materno||'' ''||per2.nombre as desc_jefe
                                  ,sal.cargo_aprobador
                          FROM alma.tai_movimiento mov
                          INNER JOIN alma.tai_solicitud_salida sal on sal.id_solicitud_salida=mov.id_solicitud_salida
                          LEFT JOIN kard.tkp_empleado emp on emp.id_empleado=sal.id_empleado and emp.estado_reg=''activo''
                          LEFT JOIN sss.tsg_persona per on per.id_persona=emp.id_persona
                          LEFT JOIN kard.tkp_unidad_organizacional uo on uo.id_unidad_organizacional=sal.id_unidad_organizacional

                          LEFT JOIN param.tpm_config_aprobador apr on apr.id_config_aprobador=sal.id_aprobador
                          LEFT JOIN kard.tkp_unidad_organizacional uo2 on uo2.id_unidad_organizacional=apr.id_uo
                          LEFT JOIN kard.tkp_empleado emp2 on emp2.id_empleado=apr.id_empleado
                          LEFT JOIN sss.tsg_persona per2 on per2.id_persona=emp2.id_persona
                          WHERE   ';
            
            g_consulta := g_consulta || pm_criterio_filtro;
            
			-- SE AUMENTA EL ORDEN Y LOS PARÃ?ÂMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
         --   g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol;
         --   g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;
            
            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;
                
            -- DESCRIPCIÃ??N DE Ã??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;
        
        ELSIF pm_codigo_procedimiento = 'AL_REP_CLASIF_ITEM' THEN
        BEGIN
        	--EXECUTE('create temp table tt_clasificacion (id_clasificacion integer,id_clasificacion_fk integer,codigo varchar,codigo_largo varchar,nombre varchar) on commit drop;');
            DELETE FROM alma.tmp_clasificacion_item;
            for g_registros in ( select a.id_clasificacion,a.id_clasificacion_fk,a.codigo,a.codigo_largo,a.nombre
           						 from alma.tai_clasificacion a 
                                 where a.id_clasificacion_fk is null 
                                 ORDER BY a.id_clasificacion ASC)
            loop
            	g_res = alma.f_ai_clasificacion_item(g_registros.id_clasificacion,NULL,'BUSQUEDA1',0);
                		
            end loop;       			
            
            g_consulta = 'select t.id_clasificacion,t.id_clasificacion_fk,c.codigo,c.codigo_largo,c.nombre,c.orden,t.nivel,c.codigo_largo||'' - ''||c.nombre as desc_clasif
                          from alma.tai_clasificacion c
                          inner join alma.tmp_clasificacion_item t on t.id_clasificacion=c.id_clasificacion ';
    
            
            FOR g_registros in EXECUTE(g_consulta) 
            LOOP
            	if(g_registros.nivel IS NOT NULL)
                then
                	if(g_registros.nivel = 0)
                    then
            			g_registros.desc_clasif = repeat('       ',g_registros.nivel)||g_registros.desc_clasif;
                    else
                    	g_registros.desc_clasif = repeat('       ',g_registros.nivel)||g_registros.orden||' .- '||g_registros.desc_clasif;
                    end if;
                end if;
                RETURN NEXT g_registros;
            END LOOP;
                
            -- DESCRIPCIÃ??N DE Ã??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
            
        END;
    ELSIF pm_codigo_procedimiento = 'AL_REP_TIP_MOVS' THEN
    BEGIN
    
    	  g_consulta := 'SELECT ite.codigo,mov.codigo as cod_movimiento,ite.nombre as descripcion,uni.nombre,COALESCE(to_char(mov.fecha_movimiento, ''dd-mm-yyyy''),''0'') AS fecha_movimiento
          						,det.cantidad,det.costo_unitario as precio_unitario,det.costo_total as precio_total
                               ,alm.codigo||'' - ''||alm.nombre as desc_almacen
                               ,CASE tip.tipo
                                    WHEN ''ingreso'' THEN ''INGRESOS''
                                    WHEN ''salida'' THEN ''SALIDAS''
                                    WHEN ''solicitud'' THEN ''SOLICITUDES''
                                    WHEN ''transpaso_salida'' THEN ''TRANSPASO DE SALIDAS''
                                    WHEN ''transpaso_ingreso'' THEN ''TRANSPASO DE INGRESOS''
                               ELSE
                                    ''OTROS MOVIMIENTOS''
                               END AS tipo_movimiento
                                                              
                        FROM alma.tai_almacen alm
                        INNER JOIN alma.tai_movimiento mov on mov.id_almacen=alm.id_almacen AND alm.estado=''activo''
                        INNER JOIN alma.tai_detalle_movimiento det on det.id_movimiento=mov.id_movimiento
                        INNER JOIN alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                        INNER JOIN alma.tai_item ite on ite.id_item=det.id_item AND ite.estado=''activo''
                        LEFT JOIN param.tpm_unidad_medida_base uni on uni.id_unidad_medida_base=ite.id_unidad_medida AND uni.estado_registro=''activo''
                        WHERE   ';
            
            g_consulta := g_consulta || pm_criterio_filtro;
            
            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;
                
            -- DESCRIPCIÃ??N DE Ã??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
    END;
    ELSIF pm_codigo_procedimiento = 'AL_REP_TIPMOV_SOL' THEN
    BEGIN
        
    		EXECUTE('CREATE TEMP SEQUENCE numero_fila START 1;');
    		g_consulta := 'SELECT 	nextval(''numero_fila'') as fila,
            		          uo.nombre_unidad,uo.nombre_cargo,per.apellido_paterno||'' ''||per.apellido_materno||'' ''||per.nombre as desc_persona
                              ,tab1.desc_almacen,tab1.desc_item,tab1.unidad_medida,sal.fecha_solicitud::date
                              ,tab1.cantidad_solicitada,tab1.cantidad_entregada,tab1.costo_unitario,tab1.costo_total,sal.id_solicitud_salida,sal.codigo
                           FROM(                                    
                           
                                  SELECT 	mov.id_solicitud_salida,alm.codigo||'' - ''||alm.nombre as desc_almacen,ite.codigo||'' - ''||ite.nombre as desc_item
                                          ,um.abreviatura as unidad_medida,det.cantidad_solicitada,det.cantidad as cantidad_entregada,det.costo_unitario,(det.costo_unitario*det.cantidad)as costo_total
                                  FROM alma.tai_almacen alm
                                  INNER JOIN alma.tai_movimiento mov ON mov.id_almacen=alm.id_almacen AND alm.estado=''activo''
                                  INNER JOIN alma.tai_detalle_movimiento det ON det.id_movimiento=mov.id_movimiento
                                  INNER JOIN alma.tai_item ite ON ite.id_item=det.id_item AND ite.estado=''activo''
                                  LEFT JOIN param.tpm_unidad_medida_base um ON um.id_unidad_medida_base=ite.id_unidad_medida AND um.estado_registro=''activo''

                                  WHERE ';	

    	 	g_consulta := g_consulta || pm_criterio_filtro || ' ORDER BY mov.fecha_movimiento ASC';
            g_consulta := g_consulta || ' ) tab1 
                              INNER JOIN alma.tai_solicitud_salida sal ON sal.id_solicitud_salida=tab1.id_solicitud_salida
                              LEFT JOIN kard.tkp_unidad_organizacional uo ON uo.id_unidad_organizacional=sal.id_unidad_organizacional AND uo.estado_reg=''activo''
                              LEFT JOIN kard.tkp_empleado emp on emp.id_empleado=sal.id_empleado AND emp.estado_reg=''activo''
                              LEFT JOIN sss.tsg_persona per on per.id_persona=emp.id_persona 
                              ORDER BY sal.id_solicitud_salida ASC ';
                  				
    		
            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;
                
            -- DESCRIPCIÃ??N DE Ã??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
    END;
    ELSIF pm_codigo_procedimiento ='AL_REP_SAL_GRAL' THEN
    BEGIN
    
    	  	g_consulta :='  SELECT  alm.codigo||'' - ''||alm.nombre as desc_almacen,it.codigo||'' - ''||it.nombre as desc_item,um.abreviatura as unidad_medida
                                    ,mov.fecha_movimiento::date,det.cantidad,det.costo_unitario as precio_promedio
                                    ,(det.costo_unitario*det.cantidad) as precio_total,tip.tipo,
                                    CASE tip.tipo
                                        WHEN ''solicitud'' THEN uo.codigo/*||''-''||split_part(it.codigo,''.'',1)*/||'' - ''||mov.codigo
                                        WHEN ''salida'' THEN alm.codigo/*||''-''||split_part(it.codigo,''.'',1)*/||'' - ''||mov.codigo
                                        WHEN ''transpaso_salida'' THEN alm.codigo/*||''-''||split_part(it.codigo,''.'',1)*/||'' - ''||mov.codigo
                                    END as desc_tipo_mov,
                                    CASE tip.tipo
                                    WHEN ''transpaso_salida'' THEN ''TRANSPASO SALIDA''
                                    ELSE upper(tip.tipo) END as tipo_movimiento
                                    ,mov.id_movimiento
                            FROM alma.tai_movimiento mov 
                            INNER JOIN alma.tai_detalle_movimiento det on det.id_movimiento=mov.id_movimiento
                            INNER JOIN alma.tai_item it on it.id_item=det.id_item
                            INNER JOIN alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                            INNER JOIN param.tpm_unidad_medida_base um on um.id_unidad_medida_base=it.id_unidad_medida and um.estado_registro=''activo''
                            INNER JOIN alma.tai_almacen alm on alm.id_almacen=mov.id_almacen

                            LEFT JOIN alma.tai_solicitud_salida sal on sal.id_solicitud_salida=mov.id_solicitud_salida
                            LEFT JOIN kard.tkp_unidad_organizacional uo on uo.id_unidad_organizacional=sal.id_unidad_organizacional AND uo.estado_reg=''activo''
                            LEFT JOIN kard.tkp_empleado emp on emp.id_empleado=sal.id_empleado AND emp.estado_reg=''activo''
                            LEFT JOIN sss.tsg_persona per on per.id_persona=emp.id_persona  

                            WHERE  '; 
            g_consulta := g_consulta || pm_criterio_filtro || ' ORDER BY mov.fecha_finalizacion,mov.id_movimiento   ASC';
            
            FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
            END LOOP;
                
            -- DESCRIPCIÃ??N DE Ã??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
    
    END;
    
    ELSIF pm_codigo_procedimiento = 'AL_REP_KARDIT' THEN
      BEGIN
      		g_parametros = pm_criterio_filtro;
            /*
            	g_parametros[1] -> id_almacen
                g_parametros[2] -> id_item
                g_parametros[3] -> fecha desde
                g_parametros[4] -> fecha hasta
            */
      		--llamada a la funcion de kardex, segun un almacen
          	
     		--select alma.f_ai_detalle_procesos(g_parametros[1]::integer,'VALORIZACION') INTO g_consulta;


                
            g_consulta:= 'SELECT   alm.codigo||'' - ''||alm.nombre as desc_almacen,
                                           CASE tip.tipo 
                                           WHEN ''transpaso_ingreso'' THEN ''TRANSFERECIA INGRESO'' 
                                           WHEN ''transpaso_salida'' THEN ''TRANSFERENCIA SALIDA''
                                           ELSE upper(tip.tipo)
                                           END as desc_tipo_movimiento ,
                                           mov.fecha_finalizacion::date ,
                                           det.cantidad,''0''::numeric as cant_ingreso,''0''::numeric as cant_salida,''0''::numeric as cant_saldo ,                                        
                                           det.costo_unitario,

                                           det.costo_valorado  as precio_prom_ponderado,
                                           
                                           ''0''::numeric as precio_ingreso,''0''::numeric as precio_salida,
                                           tip.tipo,it.id_item ,it.codigo,it.nombre as nombre_item,
                                           um.nombre as unidad_medida,mov.codigo as cod_movimiento,
                                           (select alma.f_ai_saldo_fecha(''SALDO_ITEM_FECHA'','||g_parametros[1]||',det.id_item, '''||g_parametros[3]||''' )) as saldo_item
                                           
            				FROM alma.tai_movimiento mov
                            INNER JOIN alma.tai_detalle_movimiento det on det.id_movimiento=mov.id_movimiento
                            INNER JOIN alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
                            INNER JOIN alma.tai_almacen alm on alm.id_almacen=mov.id_almacen AND alm.estado=''activo''
                            INNER JOIN alma.tai_item it on it.id_item=det.id_item
                            LEFT JOIN param.tpm_unidad_medida_base um on um.id_unidad_medida_base=it.id_unidad_medida AND um.estado_registro=''activo''

                            WHERE mov.estado=''finalizado'' AND mov.id_almacen='||g_parametros[1]||' AND det.id_item like('''||g_parametros[2]||''') 
                            AND mov.fecha_finalizacion BETWEEN '''||g_parametros[3]|| ' 00:00:00'''||' AND '''|| g_parametros[4] ||' 23:59:59'''||'

                            GROUP BY det.id_item,alm.codigo,alm.nombre,mov.id_movimiento,tip.tipo,mov.fecha_finalizacion,det.costo_unitario,det.cantidad,
                                     tip.tipo,it.id_item,it.codigo,it.nombre,um.nombre,mov.codigo,det.costo_valorado
                            ORDER BY det.id_item,mov.fecha_finalizacion ASC';
               
        
            raise notice '%',g_consulta;   
            	g_contador:=0;
                FOR g_registros in EXECUTE (g_consulta)
                LOOP
                     
                         IF(	lower(g_registros.tipo) IN ('ingreso','transpaso_ingreso','devolucion')	) THEN
                         
                         	g_contador := g_contador + g_registros.cantidad;
                         	g_registros.cant_ingreso = g_registros.cantidad;
                        	g_registros.precio_ingreso = g_registros.costo_unitario;
                                
                            g_registros.cant_saldo =  g_contador ;
                                
                                
                         ELSE
                         
                         	g_contador := g_contador - g_registros.cantidad;
                         	g_registros.cant_salida = g_registros.cantidad;
                            g_registros.precio_salida = g_registros.costo_unitario;          
                            g_registros.cant_saldo = g_contador;
                            
                            g_registros.precio_prom_ponderado=g_registros.costo_unitario;
                                
                	END IF; 
                    RETURN NEXT g_registros;
                END LOOP;
                                                  
            -- DESCRIPCIÃ??N DE Ã??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
      END;
	ELSIF pm_codigo_procedimiento = 'AL_REP_EXISTENCIAS' THEN
    BEGIN
    	g_parametros = pm_criterio_filtro;
            /*
            	g_parametros[1] -> id_almacen
                g_parametros[2] -> id_item
                g_parametros[3] -> fecha desde
                g_parametros[4] -> fecha hasta
            */
    		EXECUTE('CREATE TEMP TABLE tt_mov_finalizados(id_detalle_movimiento integer) ON COMMIT DROP;');
            EXECUTE('INSERT INTO tt_mov_finalizados ( select   max(b.id_detalle_movimiento)
                                                      from alma.tai_movimiento a
                                                      inner join alma.tai_detalle_movimiento b on b.id_movimiento=a.id_movimiento
                                                      where a.estado=''finalizado'' AND a.id_almacen='||g_parametros[1]||' AND b.id_item like('''||g_parametros[2]||''') AND a.fecha_finalizacion <= '''|| g_parametros[4] ||' 23:59:59'''||'
                                                      group by b.id_item
                                                      order by b.id_item ASC);');
                                                      
            g_consulta:='SELECT  it.codigo,it.nombre
                               ,(select alma.f_ai_saldo_fecha(''SALDO_EXISTENCIAS'',mov.id_almacen,it.id_item,to_date('''||g_parametros[4]||''',''mm/dd/YYYY'')))AS existencias
                               ,um.abreviatura as unidad_medida,det.costo_unitario as precio_unitario,0::numeric as precio_total
                              
                        FROM  tt_mov_finalizados tt
                        INNER JOIN alma.tai_detalle_movimiento det on det.id_detalle_movimiento=tt.id_detalle_movimiento
                        INNER JOIN alma.tai_movimiento mov on mov.id_movimiento=det.id_movimiento
                        INNER JOIN alma.tai_almacen alm on alm.id_almacen=mov.id_almacen
                        INNER JOIN alma.tai_item it on it.id_item=det.id_item
                        INNER JOIN param.tpm_unidad_medida_base um on um.id_unidad_medida_base=it.id_unidad_medida and um.estado_registro=''activo''
                        ORDER BY it.id_item ASC';


                       
         FOR g_registros in EXECUTE(g_consulta) LOOP
         
         		g_registros.precio_total = (g_registros.precio_unitario * g_registros.existencias);
         		RETURN NEXT g_registros;
         END LOOP;
                
         -- DESCRIPCIÃ??N DE Ã??XITO PARA GUARDAR EN EL LOG
         g_descripcion_log_error := 'Consulta ejecutada'; 	
    END;
    ELSIF pm_codigo_procedimiento = 'AL_DATOS_ALMACENERO' THEN
    	BEGIN
        	
        	 g_consulta :=' select COALESCE(per.apellido_paterno,'''')||'' ''||COALESCE(per.apellido_materno,'''')||'' ''||COALESCE(per.nombre,'''') as desc_usuario,per.id_persona,us.id_usuario
                            from sss.tsg_usuario us
                            inner join sss.tsg_persona per on per.id_persona=us.id_persona
                            where  us.login = (	select split_part(m.usuario_reg::varchar,''_'',2)
                                                  from alma.tai_movimiento m
                                                  where '||pm_criterio_filtro||' 
                                                  limit 1) ';
                                                  
             FOR g_registros in EXECUTE(g_consulta) LOOP
         		RETURN NEXT g_registros;
         	 END LOOP;
                
             -- DESCRIPCIÃ??N DE Ã??XITO PARA GUARDAR EN EL LOG
             g_descripcion_log_error := 'Consulta ejecutada'; 	
        
        END;
    ELSIF pm_codigo_procedimiento = 'AL_REP_CONEXIS' THEN
    	BEGIN
        	g_parametros = pm_criterio_filtro;
        	g_consulta:=' SELECT it.codigo,it.nombre,val.cantidad,um.abreviatura,trunc(det.costo_unitario,6) as precio_unitario, trunc(val.cantidad*det.costo_unitario,6) as precio_total
                          FROM alma.tai_item_valoracion_pp val
                          INNER JOIN alma.tai_almacen alm on alm.id_almacen=val.id_almacen
                          INNER JOIN alma.tai_item it on it.id_item=val.id_item
                          INNER JOIN param.tpm_unidad_medida_base um on um.id_unidad_medida_base=it.id_unidad_medida AND um.estado_registro=''activo''
                          INNER JOIN alma.tai_detalle_movimiento det on det.id_detalle_movimiento=val.id_detalle_movimiento
                          WHERE val.id_almacen like('''||g_parametros[1]||''') AND val.id_item like('''||g_parametros[2]||''')
                          ORDER BY val.id_item';                  
            
            FOR g_registros in EXECUTE(g_consulta) LOOP
         		RETURN NEXT g_registros;
         	END LOOP;
                
         	-- DESCRIPCIÃ??N DE Ã??XITO PARA GUARDAR EN EL LOG
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


    ---*** REGISTRO EN EL LOG EL Ã??XITO DE LA EJECUCIÃ??N DEL PROCEDIMIENTO
    	g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);
   RETURN;

EXCEPTION

    WHEN others THEN BEGIN
    
        --SE OBTIENE EL MENSAJE Y EL NÃ??MERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
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