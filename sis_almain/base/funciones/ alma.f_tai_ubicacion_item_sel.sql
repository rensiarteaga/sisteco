--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_tai_ubicacion_item_sel (
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
  pm_id_almacen integer,
  pm_id_nodo integer,
  pm_id_item integer
)
RETURNS SETOF record AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA DE ALMACEN
***************************************************************************
 SCRIPT:          alma.f_tai_ubicacion_item_sel
 DESCRIPCI√?N:     Devuelve las consultas a la tabla tal_ubicacion_item
 AUTOR:           
 FECHA:           
 COMENTARIOS:    

***************************************************************************/
--------------------------
-- CUERPO DE LA FUNCI√?N --
--------------------------

-- PAR√ÅMETROS FIJOS
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

-- DECLARACI√?N DE VARIABLES PARTICULARES


-- DECLARACI√?N DE VARIABLES DE LA FUNCI√?N (LOCALES)

DECLARE

    --PAR√ÅMETROS FIJOS
    g_id_subsistema            integer; -- ID SUBSISTEMA
    g_id_lugar                 integer; -- ID LUGAR
    g_numero_error             varchar; -- ALMACENA EL N√?MERO DE ERROR
    g_mensaje_error            varchar; -- ALMACENA MENSAJE DEL ERROR
    
    g_privilegio_procedimiento boolean; -- BANDERA PARA VERIFICAR LLAMADA DE PROCEDIMIENTO
    
    g_descripcion_log_error    text;    -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento               boolean;
    g_reg_error                boolean;
    g_registros                record;  -- PARA ALMACENAR EL CONJUNTO DE DATOS RESULTADO DEL SELECT
    g_respuesta                varchar; -- VARIABLE QUE CONTENDR√Å LOS MENSAJES DE ERROR
    g_consulta                 text;    -- VARIABLE QUE CONTENDR√Å LA CONSULTA DIN√ÅMICA PARA EL FILTRO
    g_nivel_error              varchar; -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                        --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                        --      ERROR L√?GICO (CR√çTICO) = 2
                                        --      ERROR L√?GICO (INTERMEDIO) = 3
                                        --      ERROR L√?GICO (ADVERTENCIA) = 4
    g_nombre_funcion           varchar; --NOMBRE F√çSICO DE LA FUNCI√?N
    g_separador                varchar(10); --Caracteres que servir√°n para separar el mensaje, nivel y origen del error
    g_rol_adm		           boolean;	-- Identifica si el usuario tiene rol administrador

	g_pos						integer;
    g_aux						varchar;
	g_rec						record;



BEGIN

    ---*** INICIACI√?N DE VARIABLES
    g_privilegio_procedimiento := FALSE;
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funci√≥n
    g_nombre_funcion :='f_tai_ubicacion_sel';
    g_rol_adm:= false;
    ---*** VERIFICACI√?N ROL ADMINISTRADOR
    
    IF EXISTS(SELECT 1 FROM sss.tsg_usuario_rol usrol WHERE usrol.id_usuario = pm_id_usuario AND usrol.id_rol=1) THEN
        g_rol_adm := true;
    END IF;
    
    ---*** OBTENCI√?N DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;

    ---*** OBTENCI√?N DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT ul.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar ul
    WHERE  ul.id_usuario = pm_id_usuario;


    ---*** VALIDACI√?N DE LLAMADA POR USUARIO O FUNCI√?N
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

    ---*** VERIFICACI√?N DE PERMISOS DEL USUARIO
    IF NOT g_privilegio_procedimiento THEN
       g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;
   

    ---***SELECCI√?N DE OPERACI√?N A REALIZAR
    IF pm_codigo_procedimiento  = 'AL_ALUBITEM_RAIZ_SEL' THEN
        BEGIN
        	g_aux:='';
        	if EXISTS (select 1 from alma.tai_ubicacion_item_detalle a where a.id_item=pm_id_item AND a.id_almacen=pm_id_almacen)
            then
    			
            	for g_rec in (  select DISTINCT u.ubicacion_arbol 
                                      from alma.tai_ubicacion_item_detalle u
                                      where u.id_almacen = pm_id_almacen AND u.id_item=pm_id_item )
                loop
                	
                	g_aux := g_rec.ubicacion_arbol||','||g_aux;
                end loop;
            	
            else
            	g_aux := '';
     
            end if;
            
             
              g_consulta := 'SELECT ub.usuario_reg,
                                    COALESCE(to_char(ub.fecha_reg,''dd-mm-yyyy''),''0'') AS fecha_reg,
                                    ub.id_ubicacion,ub.id_ubicacion_fk,ub.id_almacen,
                                    ub.codigo,ub.nombre,ub.estado,al.codigo||'' - ''||al.nombre as desc_almacen
                                    ,ub.tipo_ubicacion
                                    ,FALSE::boolean as checked
                            FROM alma.tai_ubicacion ub
                            INNER JOIN alma.tai_almacen al on ub.id_almacen=al.id_almacen AND al.estado=''activo''
                            WHERE ub.id_almacen like('||pm_id_almacen||') and ub.id_ubicacion_fk IS NULL  AND  ';

            g_consulta := g_consulta || pm_criterio_filtro;
			-- SE AUMENTA EL ORDEN Y LOS PAR√ÅMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
            g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol || ' ' ||pm_sortdir;
            g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;
            
            
            FOR g_registros in EXECUTE(g_consulta)
            LOOP
            	
                select position(g_registros.id_ubicacion IN g_aux)  into g_pos ;
                if(g_pos>0)then
                	g_registros.checked = TRUE;
                end if;
                
                RETURN NEXT g_registros;
            END LOOP;
                
            -- DESCRIPCI√?N DE √?XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
        END;
    ELSIF pm_codigo_procedimiento = 'AL_ALUBITEM_RAMNOD_SEL' THEN
    BEGIN
    	   g_aux:='';
           if EXISTS (select 1 from alma.tai_ubicacion_item_detalle a where a.id_item=pm_id_item AND a.id_almacen=pm_id_almacen)
           then
    			
             for g_rec in (  select DISTINCT u.ubicacion_arbol 
                            from alma.tai_ubicacion_item_detalle u
                            where u.id_almacen = pm_id_almacen AND u.id_item=pm_id_item )
           	 loop
             	  	g_aux := g_rec.ubicacion_arbol||','||g_aux;
             end loop;
            	
            else
            	g_aux := '';
            end if;	
    		
           g_consulta := 'SELECT ub.usuario_reg,
                                    COALESCE(to_char(ub.fecha_reg,''dd-mm-yyyy''),''0'') AS fecha_reg,
                                    ub.id_ubicacion,ub.id_ubicacion_fk,ub.id_almacen,
                                    ub.codigo,ub.nombre,ub.estado,al.codigo||'' - ''||al.nombre as desc_almacen
                                    ,ub.tipo_ubicacion
                                    ,FALSE::boolean as checked
           					FROM alma.tai_ubicacion ub
                            INNER JOIN alma.tai_almacen al on ub.id_almacen=al.id_almacen AND al.estado=''activo''
                            WHERE ub.id_almacen like('||pm_id_almacen||') AND  ';
           
           g_consulta := g_consulta || pm_criterio_filtro;
		   -- SE AUMENTA EL ORDEN Y LOS PAR√ÅMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
           g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol || ' ' ||pm_sortdir;
           g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;
           
           
            FOR g_registros in EXECUTE(g_consulta)
            LOOP
            	 select position(g_registros.id_ubicacion IN g_aux)  into g_pos ;
                 
                 if(g_pos>0)then
                	g_registros.checked = TRUE;
                end if;
                
                 RETURN NEXT g_registros;
            END LOOP;
            
           	-- DESCRIPCI√?N DE √?XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Consulta ejecutada';
    
    END;
    ELSIF pm_codigo_procedimiento = 'AL_ORDUBIC_SEL' THEN
    BEGIN
    	g_consulta:='select   ord.id_ubicacion_item_detalle,ord.id_ubicacion,
                              ord.orden,
                              ub.codigo,ub.nombre,
                              ord.id_almacen,
                              ord.id_item,ord.usuario_reg,COALESCE(to_char(ord.fecha_reg,''dd-mm-yyyy''),''0'') AS fecha_reg
                              ,ord.saldo_item_ubicacion,ord.cant_max_ing,ord.cant_max_sal
                              
                      from alma.tai_ubicacion_item_detalle ord
                      inner join alma.tai_ubicacion ub on ub.id_ubicacion=ord.id_ubicacion
                      inner join alma.tai_almacen alm on alm.id_almacen=ord.id_almacen and alm.estado=''activo''
                      where ';
                      
        g_consulta := g_consulta || pm_criterio_filtro;

        -- SE AUMENTA EL ORDEN Y LOS PARAÅMETROS DE LA CANTIDAD DE REGISTROS A DESPLEGAR
        g_consulta := g_consulta || ' ORDER BY ' || pm_sortcol ;
        g_consulta := g_consulta || ' LIMIT ' || pm_cant || ' OFFSET ' || pm_puntero;
            
        FOR g_registros in EXECUTE(g_consulta) LOOP            
        	RETURN NEXT g_registros;
        END LOOP;
        -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
        g_descripcion_log_error := 'Consulta ejecutada';
                      
    END;
    
    ELSIF pm_codigo_procedimiento='AL_ORDUBIC_COUNT' THEN 
    BEGIN 
    	g_consulta:=' select  COUNT(ord.id_ubicacion_item_detalle) as total
                      from alma.tai_ubicacion_item_detalle ord
                      inner join alma.tai_ubicacion ub on ub.id_ubicacion=ord.id_ubicacion
                      inner join alma.tai_almacen alm on alm.id_almacen=ord.id_almacen and alm.estado=''activo''
                      where  ';
                      
        g_consulta := g_consulta || pm_criterio_filtro;
        FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
        END LOOP;

        -- DESCRIPCION DE EXITO PARA GUARDAR EN EL LOG
        g_descripcion_log_error := 'Consulta de cantidad registrada';
        
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


    ---*** REGISTRO EN EL LOG EL √?XITO DE LA EJECUCI√?N DEL PROCEDIMIENTO
    	g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);
   RETURN;

EXCEPTION

    WHEN others THEN BEGIN
    
        --SE OBTIENE EL MENSAJE Y EL N√?MERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
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