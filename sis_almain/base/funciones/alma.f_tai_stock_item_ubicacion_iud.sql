--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_tai_stock_item_ubicacion_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_stock_item integer,
  al_id_almacen integer,
  al_id_item integer,
  al_minimo double precision,
  al_maximo double precision,
  al_id_ubicacion integer
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA Almacen 
***************************************************************************
 SCRIPT:          alma.f_tai_stock_item_iud
 DESCRIPCIÃ??N:    insercion, modificacion y eliminacion de la tabla alma.tal_stock_item
 AUTOR:           UNKNOW
 FECHA:           
 COMENTARIOS:    
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCIÃ??N:  
 AUTOR:           Ruddy Lujan Bravo
 FECHA:           27-08-2013 17:10:00

***************************************************************************/

--------------------------
-- CUERPO DE LA FUNCIÃ???N --
--------------------------

-- PARÃ?ÂÃ?ÂMETROS FIJOS
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

-- PARÃ?ÂÃ?ÂMETROS VARIABLES
/*
cb_id_almacen_item
cb_id_sucursal
cb_id_usuario
cb_estado
*/

-- DECLARACIÃ??N DE VARIABLES PARTICULARES

--**** DECLARACION DE VARIABLES DE LA FUNCIÃ??N (LOCALES) ****---


DECLARE

    --PARÃ?ÂMETROS FIJOS

    g_id_subsistema               integer;     -- ID SUBSISTEMA
    g_id_lugar                    integer;     -- ID LUGAR
    g_numero_error                varchar;     -- ALMACENA EL NÃ??MERO DE ERROR
    g_mensaje_error               varchar;     -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento    boolean;     -- BANDERA PARA VERIFICAR LLAMADA DE LA FUNCIÃ??N
    g_descripcion_log_error       text;        -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento                  varchar; 
    g_reg_error                	  varchar; 
    g_respuesta                   varchar;     -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCIÃ??N
    g_nivel_error                 varchar;     -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                               --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                               --      ERROR LÃ??GICO (CRÃ?ÂTICO) = 2
                                               --      ERROR LÃ??GICO (INTERMEDIO) = 3
                                               --      ERROR LÃ??GICO (ADVERTENCIA) = 4
    
    g_nombre_funcion              varchar;     -- NOMBRE FÃ?ÂSICO DE LA FUNCIÃ??N
    g_separador                   varchar(10); -- SEPARADOR DE CADENAS
    g_id_stock_item					integer;
    g_codigo_padre				varchar;
    g_num_clasificacion			integer;
    g_registros					record;
    g_cant_repeticiones			integer;
    
BEGIN
---*** INICIACIÃ??N DE VARIABLES 
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funciÃ?Â³n	
    g_nombre_funcion :='f_taf_stock_item_iud';
    g_privilegio_procedimiento := FALSE;
    g_respuesta := FALSE;
   
    ---*** OBTENCIÃ??N DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENCIÃ??N DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT tsg_usuario_lugar.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar
    WHERE  tsg_usuario_lugar.id_usuario = pm_id_usuario;
    
    
     ---*** VALIDACIÃ??N DE LLAMADA POR USUARIO O FUNCIO?N
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


    ---*** VERIFICACIÃ??N DE PERMISOS DEL USUARIO
    IF NOT g_privilegio_procedimiento THEN
       g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;

---*** SI NO SE TIENE PERMISOS DE EJECUCIO?N SE RETORNA EL MENSAJE DE ERROR
    IF NOT g_privilegio_procedimiento THEN
        g_nivel_error := '3';
        g_descripcion_log_error := 'El usuario no tiene permisos de ejecucion del procedimiento';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                             pm_codigo_procedimiento   ,pm_proc_almacenado);
        
        --DEVUELVE MENSAJE DE ERROR
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
    END IF;
    
    
      --*** EJECUCIÃ??N DEL PROCEDIMIENTO ESPECIÂFICO
    IF pm_codigo_procedimiento = 'AL_STOCKITEM_INS' THEN
    BEGIN
		--verifica que la el stock_minimo jamas sea  mayor al stock_maximo
        IF(al_minimo > al_maximo)
        THEN
        	raise EXCEPTION 'Verifique que el stock maximo sea mayor al stock minimo';
       	END IF;
        if exists(	 select 1
                     from alma.tai_stock_item st
                     where st.id_almacen = al_id_almacen and
                         st.id_item = al_id_item )
        then
        		select st.id_stock_item,st.fecha_reg,al.codigo||'-'||al.nombre as desc_almacen,it.codigo||'-'||it.nombre as desc_item into g_registros
                from alma.tai_stock_item st
                	 inner join alma.tai_almacen al on al.id_almacen=st.id_almacen
                     inner join alma.tai_item it on it.id_item=st.id_item
                where st.id_almacen=al_id_almacen and st.id_item=al_id_item
                order by st.id_stock_item DESC
                limit 1 ;
        		g_descripcion_log_error := 'El Item: ' ||g_registros.desc_item||' fue registrado anteriormente.'||chr(10)||
            							'Almacen: '||g_registros.desc_almacen||chr(10)||
                                        'Fecha Registro: '||g_registros.fecha_reg;
                                       
            	g_nivel_error := '1';
            	g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
            	RETURN 'f'||g_separador||g_respuesta;
        end if;
        
		INSERT INTO alma.tai_stock_item (
            id_almacen,
            id_item,
            minimo, 
            maximo,id_ubicacion
            
        ) VALUES (
            al_id_almacen,
            al_id_item,
            al_minimo,
            al_maximo,al_id_ubicacion
        );
            
            -- DESCRIPCIÃ??N DE Ã??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tai_stock_item';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;   
        END;
        
  --procedimiento de modificacion      
	ELSIF pm_codigo_procedimiento = 'AL_STOCKITEM_UPD' THEN
	BEGIN
            --VERIFICA EXISTENCIA DEL REGISTRO
            select sti.id_stock_item into g_id_stock_item
            from alma.tai_stock_item sti
            where sti.id_stock_item=al_id_stock_item;
            
            IF (g_id_stock_item is null) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada: no existe el registro' || al_id_stock_item || 'en la tabla alma.taf_stock_item';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;                    
            END IF;
            --verifica que la el stock_minimo jamas sea  mayor al stock_maximo
            IF(al_minimo > al_maximo)
            THEN
                raise EXCEPTION 'Verifique que el stock maximo sea mayor al stock minimo';
            END IF;
			--se verifica que id_stock item no pueda ser aÃ±adido mas de una vez en un mismo almacen
                select count(st.id_stock_item) + 1 into g_cant_repeticiones
                from alma.tai_stock_item st
                where st.id_almacen = al_id_almacen and
                      st.id_item = al_id_item ;
               
            if(g_cant_repeticiones = 1)
       		then 
             	UPDATE alma.tai_stock_item SET 
                	usuario_reg = "current_user"(),
                	fecha_reg = now(),
                    id_almacen = al_id_almacen,
                    id_item = al_id_item,
                	minimo = al_minimo,
                	maximo = al_maximo,
                    id_ubicacion = al_id_ubicacion
				WHERE alma.tai_stock_item.id_stock_item = al_id_stock_item;
            else 
            	select st.id_stock_item,st.fecha_reg,al.codigo||'-'||al.nombre as desc_almacen,it.codigo||'-'||it.nombre as desc_item into g_registros
                from alma.tai_stock_item st
                	 inner join alma.tai_almacen al on al.id_almacen=st.id_almacen
                     inner join alma.tai_item it on it.id_item=st.id_item
                where st.id_almacen=al_id_almacen and st.id_item=al_id_item
                order by st.id_stock_item DESC
                limit 1 ;
        		g_descripcion_log_error := 'El Item: ' ||g_registros.desc_item||' fue registrado anteriormente.'||chr(10)||
            							'Almacen: '||g_registros.desc_almacen||chr(10)||
                                        'Fecha Registro: '||g_registros.fecha_reg;
                                       
            	g_nivel_error := '1';
            	g_respuesta := f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
            	RETURN 'f'||g_separador||g_respuesta;
        	end if;
		-- DESCRIPCIÃ??N DE Ã??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Modificacion exitosa en alma.tai_stock_item del registro '||al_id_stock_item;
            g_respuesta := 't'||g_separador||g_descripcion_log_error;

        END;
        
        ELSIF pm_codigo_procedimiento = 'AL_STOCKITEM_DEL' THEN
        
    	BEGIN
            --VERIFICACIÃ??N DE EXISTENCIA DEL REGISTRO
            select sti.id_stock_item into g_id_stock_item
            from alma.tai_stock_item sti
            where sti.id_stock_item=al_id_stock_item;

            IF (g_id_stock_item is null) THEN
                              
                g_descripcion_log_error := 'Eliminacion no realizada: no existe el registro' || al_id_stock_item || 'en la tabla alma.tai_stock_item';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                    
            END IF;
            
            --control añadido 31/07/2015
            select a.id_item INTO g_id_stock_item
            from alma.tai_stock_item a
            where a.id_stock_item =al_id_stock_item;
            
            if EXISTS(	select 1 
            			from alma.tai_movimiento m 
                        inner join alma.tai_detalle_movimiento d on d.id_movimiento=m.id_movimiento
                        where d.id_item = g_id_stock_item
                        )
            then
            		g_descripcion_log_error := 'Eliminacion no realizada: el item ' || g_id_stock_item || ' ya fue registrado en un movimiento.';
                	g_nivel_error := '4';
                	g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                	RETURN 'f'||g_separador||g_respuesta;
            end if;
            
            if EXISTS(	select 1 
            			from alma.tai_solicitud_salida m 
                        inner join alma.tai_detalle_solicitud d on d.id_solicitud_salida=m.id_solicitud_salida
                        where d.id_item = g_id_stock_item
                        )
            then
            		g_descripcion_log_error := 'Eliminacion no realizada: el item ' || g_id_stock_item || ' ya fue registrado en una solicitud.';
                	g_nivel_error := '4';
                	g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                	RETURN 'f'||g_separador||g_respuesta;
            end if;
              
            
            DELETE FROM alma.tai_stock_item
			WHERE alma.tai_stock_item.id_stock_item=al_id_stock_item;
                
 			
            -- DESCRIPCIÃ??N DE Ã??XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_stock_item||' en alma.tai_stock_item';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
        
    ELSIF pm_codigo_procedimiento = 'AL_UBICACIONSTOCK_UPD' THEN
	    BEGIN
        
        	UPDATE alma.tai_stock_item
            SET id_ubicacion = al_id_ubicacion
            WHERE id_stock_item =al_id_stock_item;
        
        	g_descripcion_log_error := 'Modificacion exitosa en alma.tai_stock_item del registro '||al_id_stock_item;
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

    ---*** REGISTRO EN EL LOG EL Ã??XITO DE LA EJECUIÃ??N DEL PROCEDIMIENTO
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);

    ---*** SE DEVUELVE LA RESPUESTA
    RETURN g_respuesta||g_separador||g_reg_evento;


EXCEPTION

    WHEN others THEN BEGIN

        --SE OBTIENE EL MENSAJE Y EL NÃ??MERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
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