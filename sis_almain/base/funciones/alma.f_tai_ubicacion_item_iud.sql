--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_tai_ubicacion_item_iud (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  al_id_ubicacion_item_detalle integer,
  al_id_ubicacion integer,
  al_id_almacen integer,
  al_id_item integer,
  al_orden integer,
  al_saldo_item_ubicacion numeric,
  al_cant_max_ingreso numeric,
  al_cant_max_salida numeric
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA ENDESIS - SISTEMA Almacen
***************************************************************************
 SCRIPT:          alma.f_tai_ubicacion_item_detalle_iud
 DESCRIPCI√?N:     Realiza modificaciones en la tabla alma.tai_ubicacion
 AUTOR:           
 FECHA:           
 COMENTARIOS:    
***************************************************************************



--------------------------
-- CUERPO DE LA FUNCI√??N --
--------------------------

-- PAR√Å¬ÅMETROS FIJOS
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

-- PAR√Å¬ÅMETROS VARIABLES
/*
cb_id_almacen
cb_id_sucursal
cb_id_usuario
cb_estado
*/

-- DECLARACI√?N DE VARIABLES PARTICULARES

--**** DECLARACION DE VARIABLES DE LA FUNCI√?N (LOCALES) ****---


DECLARE

    --PAR√ÅMETROS FIJOS

    g_id_subsistema               integer;     -- ID SUBSISTEMA
    g_id_lugar                    integer;     -- ID LUGAR
    g_numero_error                varchar;     -- ALMACENA EL N√?MERO DE ERROR
    g_mensaje_error               varchar;     -- ALMACENA MENSAJE DEL ERROR
    g_privilegio_procedimiento    boolean;     -- BANDERA PARA VERIFICAR LLAMADA DE LA FUNCI√?N
    g_descripcion_log_error       text;        -- PARA ALMACENAR EL MENSAJE DE ERROR O LOG
    g_reg_evento                  varchar; 
    g_reg_error                	  varchar; 
    g_respuesta                   varchar;     -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCI√?N
    g_nivel_error                 varchar;     -- VARIABLE QUE CONTIENE EL NIVEL DE ERROR
                                               --      ERROR DE SINTAXIS (cuando llega a exception) = 1
                                               --      ERROR L√?GICO (CR√çTICO) = 2
                                               --      ERROR L√?GICO (INTERMEDIO) = 3
                                               --      ERROR L√?GICO (ADVERTENCIA) = 4
    
    g_nombre_funcion               varchar;     -- NOMBRE F√çSICO DE LA FUNCI√?N
    g_separador                    varchar(10); -- SEPARADOR DE CADENAS
    g_id_fina_regi_prog_proy_acti  integer;     -- VARIABLE DE LA ESTRUCTURA PROGRAM√ÅTICA
    g_id_almacen					integer;
    g_registros						record;
    g_id_rol						integer;
    g_id_ubicacion			        integer;
    g_tipo_ubicacion				varchar;
    
    g_orden							integer;
    g_arbol							record;
    g_arbol_detalle					record;
    g_rec							record;
    g_detalle_arbol					varchar;

    
    
BEGIN
---*** INICIACI√?N DE VARIABLES 
    g_separador = '#@@@#'; --Separador para mensajes devueltos por la funci√≥n	
    g_nombre_funcion :='f_tai_ubicacion_item_iud';
    g_privilegio_procedimiento := FALSE;
    g_respuesta := FALSE;
   
    ---*** OBTENCI√?N DEL ID DEL SUBSISTEMA
    SELECT id_subsistema
    INTO g_id_subsistema
    FROM sss.tsg_procedimiento_db
    WHERE codigo_procedimiento = pm_codigo_procedimiento;


    ---*** OBTENCI√?N DEL ID DEL LUGAR ASIGNADO AL USUARIO
    SELECT tsg_usuario_lugar.id_lugar
    INTO   g_id_lugar
    FROM   sss.tsg_usuario_lugar
    WHERE  tsg_usuario_lugar.id_usuario = pm_id_usuario;
    
    
     ---*** VALIDACI√?N DE LLAMADA POR USUARIO O FUNCI√?N
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


    ---*** VERIFICACI√?N DE PERMISOS DEL USUARIO
    IF NOT g_privilegio_procedimiento THEN
       g_privilegio_procedimiento := sss.f_sg_validacion_procedimiento(pm_id_usuario,pm_codigo_procedimiento,NULL);
    END IF;

---*** SI NO SE TIENE PERMISOS DE EJECUCI√?N SE RETORNA EL MENSAJE DE ERROR
    IF NOT g_privilegio_procedimiento THEN
        g_nivel_error := '3';
        g_descripcion_log_error := 'El usuario no tiene permisos de ejecuci√≥n del procedimiento';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                             pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                             pm_codigo_procedimiento   ,pm_proc_almacenado);
        
        --DEVUELVE MENSAJE DE ERROR
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
    END IF;
    
    
      --*** EJECUCI√?N DEL PROCEDIMIENTO ESPEC√çFICO
    IF pm_codigo_procedimiento = 'AL_UBITEM_RAIZ_INS' OR pm_codigo_procedimiento = 'AL_UBITEM_RAMA_INS' THEN
    BEGIN
		IF EXISTS(SELECT 1 FROM alma.tai_ubicacion_item_detalle u
        		  WHERE u.id_ubicacion=al_id_ubicacion AND u.id_almacen=al_id_almacen
                  	    AND u.id_item=al_id_item
                  )
        THEN
        	 	g_descripcion_log_error := 'Insercion no realizada, registro duplicado ' ||al_id_ubicacion|| ' ,ya fue registrado en la ubicacion seleccionada.';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
        END IF;
        
        g_detalle_arbol='';
        
        for g_arbol_detalle in EXECUTE('select * 
        								from alma.f_ai_ubicacion_funciones(''ARBOL_COMPLETO'','||al_id_ubicacion||','||al_id_almacen||')
                                        as (id_ubicacion_detalle integer);')
        loop
        		g_detalle_arbol := g_detalle_arbol||g_arbol_detalle.id_ubicacion_detalle||',';
        end loop;
            
        g_detalle_arbol:=substring(g_detalle_arbol from 1 for(char_length(g_detalle_arbol)-1) );
        
        
        EXECUTE('create temp sequence seq_orden_ubicacion start with 1;');

        
        FOR g_registros IN (  SELECT ubi.id_ubicacion
        					  FROM
                              (
                              	select * 
                                from alma.f_ai_ubicacion_funciones('ARBOL_COMPLETO',al_id_ubicacion,al_id_almacen)
                                as (id_ubicacion_detalle integer)
                                ) tab
                              INNER JOIN alma.tai_ubicacion ubi on ubi.id_ubicacion=tab.id_ubicacion_detalle
                              WHERE ubi.tipo_ubicacion='nodo' )
        LOOP
        
        	 if NOT EXISTS(	select 1 from alma.tai_ubicacion_item_detalle a
             				where a.id_almacen=al_id_almacen and a.id_item=al_id_item and a.id_ubicacion =g_registros.id_ubicacion)
                            
        	 then
             
             		if EXISTS(	select 1 from alma.tai_ubicacion_item_detalle a 
                    				where a.id_almacen=al_id_almacen AND a.id_item=al_id_item) then
                		
                        select max(a.orden)+1 into g_orden    
                        from alma.tai_ubicacion_item_detalle a
                        where a.id_almacen=al_id_almacen AND a.id_item=al_id_item;
                        
                    else
                    	g_orden:= nextval('seq_orden_ubicacion')::integer; 
                    end if;
                    
                    INSERT INTO alma.tai_ubicacion_item_detalle(id_ubicacion_item_detalle,	id_ubicacion,	id_almacen,
             											 id_item,					orden,			ubicacion_arbol)
             		VALUES(									DEFAULT,				g_registros.id_ubicacion,	al_id_almacen,
             											al_id_item,					g_orden,							g_detalle_arbol);   
             
             end if;
        END LOOP;       
		
        execute('drop sequence seq_orden_ubicacion;');
        
        -- DESCRIPCI√?N DE √?XITO PARA GUARDAR EN EL LOG
        g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tai_ubicacion_item_detalle';
        g_respuesta := 't'||g_separador||g_descripcion_log_error;   
    END;
	
    /*ELSIF pm_codigo_procedimiento = 'AL_UBITEM_RAMA_INS' THEN
    BEGIN
    	IF EXISTS(SELECT 1 FROM alma.tai_ubicacion_item_detalle u
        		  WHERE u.id_ubicacion=al_id_ubicacion AND u.id_almacen=al_id_almacen
                  	    AND u.id_item=al_id_item
                  )
        THEN
        	 	g_descripcion_log_error := 'Insercion no realizada, registro duplicado ' ||al_id_ubicacion|| ' ,ya fue registrado en la ubicacion seleccionada.';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
        END IF;
        
        g_detalle_arbol='';
        
        for g_arbol_detalle in EXECUTE('select * 
        								from alma.f_ai_ubicacion_funciones(''ARBOL_COMPLETO'','||al_id_ubicacion||','||al_id_almacen||')
                                        as (id_ubicacion_detalle integer);')
        loop
        		g_detalle_arbol := g_detalle_arbol||g_arbol_detalle.id_ubicacion_detalle||',';
        end loop;
            
        g_detalle_arbol:=substring(g_detalle_arbol from 1 for(char_length(g_detalle_arbol)-1) );
        
        
        EXECUTE('create temp sequence seq_orden_ubicacion start with 1;');
        
       
        
        for g_registros in	EXECUTE('select * 
        								from alma.f_ai_ubicacion_funciones(''ARBOL_COMPLETO'','||al_id_ubicacion||','||al_id_almacen||')
                                        as (id_ubicacion_detalle integer);')
        loop
        	
            
        	select u.tipo_ubicacion,u.id_ubicacion_fk into g_rec
            from alma.tai_ubicacion u
            where u.id_ubicacion=g_registros.id_ubicacion_detalle;
        
        		
                
        	 if NOT EXISTS(	select 1 from alma.tai_ubicacion_item_detalle a
             				where a.id_almacen=al_id_almacen and a.id_item=al_id_item and a.id_ubicacion =g_registros.id_ubicacion_detalle)
        	 then

                  if(g_rec.tipo_ubicacion ='nodo') then
                  
                      if EXISTS(	select 1 from alma.tai_ubicacion_item_detalle a 
                                      where a.id_almacen=al_id_almacen AND a.id_item=al_id_item) then
                  		
                          select max(a.orden)+1 into g_orden    
                          from alma.tai_ubicacion_item_detalle a
                          where a.id_almacen=al_id_almacen AND a.id_item=al_id_item;
                          
                      else
                          g_orden:= nextval('seq_orden_ubicacion')::integer;
                          
                      end if;
                  	   
                      INSERT INTO alma.tai_ubicacion_item_detalle(id_ubicacion_item_detalle,	id_ubicacion,	id_almacen,
                                                           id_item,					orden,			ubicacion_arbol)
                      VALUES(									DEFAULT,				g_registros.id_ubicacion_detalle,	al_id_almacen,
                                                          al_id_item,					g_orden,							g_detalle_arbol);   
                  else                	
               
                      
                      if EXISTS(select 1
                                from pg_catalog.pg_class c 
                                where c.relname='tt_arbol')
                      then
                      		EXECUTE('delete from tt_arbol;');
                      end if;
                      
                      select max(id_ubicacion) as registro_ubicacion INTO  g_arbol
                      from alma.f_ai_ubicacion_funciones('ARMAR_ARBOL_RAIZ',g_registros.id_ubicacion_detalle,al_id_almacen) as (id_ubicacion integer);
					              
                              
                      if NOT EXISTS(select 1 from alma.tai_ubicacion a where a.tipo_ubicacion='nodo' and a.id_ubicacion=g_arbol.registro_ubicacion)
                      then
                          g_descripcion_log_error := 'Insercion no realizada, el registro seleccionado ' ||al_id_ubicacion|| ' ,no tiene nodos en su estructura .';
                          g_nivel_error := '4';
                          g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                          RETURN 'f'||g_separador||g_respuesta;
                      end if;
                    
                end if;
     
             end if;
        end loop;
        
        execute('drop sequence seq_orden_ubicacion;');
        
        -- DESCRIPCI√?N DE √?XITO PARA GUARDAR EN EL LOG
        g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tai_ubicacion_item_detalle';
        g_respuesta := 't'||g_separador||g_descripcion_log_error;  
     
        
    END;*/
       
    ELSIF pm_codigo_procedimiento='AL_UBITEM_NODO_INS' THEN
    BEGIN
    
    	if EXISTS(select 1 from alma.tai_ubicacion_item_detalle a where a.id_almacen=al_id_almacen and a.id_ubicacion=al_id_ubicacion and a.id_item=al_id_item)
        then
        	g_descripcion_log_error := 'Insercion no realizada, El item seleccionado ' ||al_id_item|| ',ya fue registrado en la ubicacion seleccionada '||al_id_ubicacion;
            g_nivel_error := '4';
            g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
            RETURN 'f'||g_separador||g_respuesta;
        end if;
        
         g_detalle_arbol='';
                      
         for g_arbol_detalle in EXECUTE('select * 
                                              from alma.f_ai_ubicacion_funciones(''ARBOL_COMPLETO'','||al_id_ubicacion||','||al_id_almacen||')
                                              as (id_ubicacion_detalle integer)')
         loop
              	
         	g_detalle_arbol := g_detalle_arbol||g_arbol_detalle.id_ubicacion_detalle||',';
         end loop;
              
        g_detalle_arbol:=substring(g_detalle_arbol from 1 for(char_length(g_detalle_arbol)-1) );
          
            
        if EXISTS(	select 1 from alma.tai_ubicacion_item_detalle a
        			where a.id_item=al_id_item AND a.id_almacen=al_id_almacen) then 
        	
        	select max(a.orden)+1 into g_orden
            from alma.tai_ubicacion_item_detalle a
            where a.id_item = al_id_item and a.id_almacen=al_id_almacen;
            
        else
        	g_orden:=1;  
        end if;
        
        INSERT INTO alma.tai_ubicacion_item_detalle(id_ubicacion_item_detalle,	id_ubicacion,	id_almacen,
             											 id_item,					orden,			ubicacion_arbol)
        VALUES(									DEFAULT,				al_id_ubicacion,	al_id_almacen,
             											al_id_item,					g_orden,							g_detalle_arbol); 
                                                        
         -- DESCRIPCI√?N DE √?XITO PARA GUARDAR EN EL LOG
        g_descripcion_log_error := 'Registro exitoso de un nuevo registro en la tabla alma.tai_ubicacion_item_detalle';
        g_respuesta := 't'||g_separador||g_descripcion_log_error;  
    
    END;

    ELSIF pm_codigo_procedimiento = 'AL_UBITRAIZ_DEL' THEN
        
    	BEGIN
            --VERIFICACION DE EXISTENCIA DEL REGISTRO

            
            IF NOT EXISTS(select 1 from alma.tai_ubicacion_item_detalle u where u.id_almacen=al_id_almacen AND u.id_item=al_id_item) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada:Verifique la existencia del registro' || al_id_ubicacion || 'en la tabla alma.tai_ubicacion_item_detalle';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
    
            END IF;
     
         /*  for g_arbol_detalle in ( select a.id_ubicacion,a.id_ubicacion_item_detalle
           							from alma.tai_ubicacion_item_detalle a
                                    where a.id_almacen = al_id_almacen and  a.id_item=al_id_item)
           loop
                	
             select * INTO g_arbol
             from alma.f_ai_ubicacion_funciones('BUCAR_RAIZ',g_arbol_detalle.id_ubicacion,al_id_almacen)
             as (id_ubicacion_raiz integer);
             
             if (g_arbol.id_ubicacion_raiz = al_id_ubicacion )
             then
             	DELETE FROM alma.tai_ubicacion_item_detalle 
                WHERE id_item=al_id_item and id_almacen=al_id_almacen and  id_ubicacion_item_detalle=g_arbol_detalle.id_ubicacion_item_detalle;
             end if;             
             
           end loop;*/
           
           FOR g_arbol IN (	select ubi.id_ubicacion
                            from 
                            (
                               select * 
                               from alma.f_ai_ubicacion_funciones('ARMAR_ARBOL_RAIZ',al_id_ubicacion,al_id_almacen) as (id_ubicacion_detalle integer)
                               ) tab
                            inner join alma.tai_ubicacion ubi on ubi.id_ubicacion=tab.id_ubicacion_detalle
                            where ubi.tipo_ubicacion = 'nodo')
           LOOP
           
              IF EXISTS (select 1 from alma.tai_ubicacion_item_detalle a where a.id_ubicacion=g_arbol.id_ubicacion AND a.id_item=al_id_item AND a.id_almacen=al_id_almacen)
              THEN
              
                  DELETE FROM alma.tai_ubicacion_item_detalle
                  WHERE 	id_ubicacion=g_arbol.id_ubicacion;
              
              END IF;
           		
           
           END LOOP;
                  
 			
            -- DESCRIPCI√?N DE √?XITO PARA GUARDAR EN EL LOG
            g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_ubicacion||' en alma.tai_ubicacion_item_detalle';
            g_respuesta := 't'||g_separador||g_descripcion_log_error;
        END;
    
    ELSIF pm_codigo_procedimiento = 'AL_UBITNODO_DEL' THEN
    BEGIN
    
    	 IF NOT EXISTS(select 1 from alma.tai_ubicacion_item_detalle u where u.id_almacen=al_id_almacen AND u.id_item=al_id_item) THEN
                              
                g_descripcion_log_error := 'Modificacion no realizada:Verifique la existencia del registro' || al_id_ubicacion || 'en la tabla alma.tai_ubicacion_item_detalle';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
    
         END IF;
         
         IF EXISTS (select 1 from alma.tai_ubicacion_item_detalle a where a.id_ubicacion=al_id_ubicacion)THEN
         
         	DELETE FROM alma.tai_ubicacion_item_detalle where  id_ubicacion=al_id_ubicacion and id_item=al_id_item and id_almacen=al_id_almacen;
         END IF;
         
         -- DESCRIPCI√?N DE √?XITO PARA GUARDAR EN EL LOG
         g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_ubicacion||' en alma.tai_ubicacion_item_detalle';
     	 g_respuesta := 't'||g_separador||g_descripcion_log_error;
    	
    END;  
    
    ELSIF pm_codigo_procedimiento = 'AL_UBITRAMA_DEL' THEN
    BEGIN
    	 IF NOT EXISTS(select 1 from alma.tai_ubicacion_item_detalle u where u.id_almacen=al_id_almacen AND u.id_item=al_id_item) THEN
                              
              g_descripcion_log_error := 'Modificacion no realizada:Verifique la existencia del registro' || al_id_ubicacion || 'en la tabla alma.tai_ubicacion_item_detalle';
              g_nivel_error := '4';
              g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
              RETURN 'f'||g_separador||g_respuesta;
    
         END IF;
         
         FOR g_arbol IN (	select ubi.id_ubicacion
                            from 
                            (
                               select * 
                               from alma.f_ai_ubicacion_funciones('ARMAR_ARBOL_RAIZ',al_id_ubicacion,al_id_almacen) as (id_ubicacion_detalle integer)
                               ) tab
                            inner join alma.tai_ubicacion ubi on ubi.id_ubicacion=tab.id_ubicacion_detalle
                            where ubi.tipo_ubicacion = 'nodo')
         LOOP
         
         	IF EXISTS (select 1 from alma.tai_ubicacion_item_detalle a where a.id_ubicacion=g_arbol.id_ubicacion AND a.id_item=al_id_item AND a.id_almacen=al_id_almacen)
            THEN
            
            	DELETE FROM alma.tai_ubicacion_item_detalle
                WHERE 	id_ubicacion=g_arbol.id_ubicacion;
            
            END IF;
         		
         
         END LOOP;
         
         -- DESCRIPCI√?N DE √?XITO PARA GUARDAR EN EL LOG
         g_descripcion_log_error := 'Eliminacion exitosa del registro '||al_id_ubicacion||' en alma.tai_ubicacion_item_detalle';
     	 g_respuesta := 't'||g_separador||g_descripcion_log_error;
         
    END;
    
    ELSIF pm_codigo_procedimiento ='AL_UBITEM_ORDEN_UPD' THEN
    BEGIN
    		IF NOT EXISTS(SELECT 1 FROM alma.tai_ubicacion_item_detalle a 
            			WHERE a.id_almacen=al_id_almacen AND a.id_item=al_id_item AND a.orden = al_orden) THEN
                        
            	g_descripcion_log_error := 'Modificacion no realizada: Verifique la existencia del orden ' || al_orden || ' en la tabla alma.tai_ubicacion_item_detalle';
                g_nivel_error := '4';
                g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                RETURN 'f'||g_separador||g_respuesta;
                
            END IF;
            
            if al_id_ubicacion is not NULL then
            
            
              SELECT a.id_ubicacion_item_detalle INTO     g_orden
              FROM alma.tai_ubicacion_item_detalle a
              WHERE a.id_almacen=al_id_almacen AND a.id_item=al_id_item AND a.orden=al_orden;
              
              UPDATE alma.tai_ubicacion_item_detalle
              SET orden = al_orden,
                  cant_max_ing = al_cant_max_ingreso,
                  cant_max_sal = al_cant_max_salida,
                  usuario_reg = "current_user"(),
                  fecha_reg = now()
              WHERE id_ubicacion_item_detalle = al_id_ubicacion_item_detalle;
              
              UPDATE alma.tai_ubicacion_item_detalle
              SET orden = al_id_ubicacion--orden anterior
              WHERE alma.tai_ubicacion_item_detalle.id_ubicacion_item_detalle= g_orden;
            else
             	  UPDATE alma.tai_ubicacion_item_detalle
            	  SET orden = al_orden,
                  		cant_max_ing = al_cant_max_ingreso,
                  		cant_max_sal = al_cant_max_salida,
                        usuario_reg = "current_user"(),
                  		fecha_reg = now()
              	  WHERE id_ubicacion_item_detalle = al_id_ubicacion_item_detalle;
            end if;
            
            
         -- DESCRIPCI√?N DE √?XITO PARA GUARDAR EN EL LOG
         g_descripcion_log_error := 'Actualizacion exitosa del registro '||al_id_ubicacion_item_detalle||' en alma.tai_ubicacion_item_detalle';
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

    ---*** REGISTRO EN EL LOG EL √?XITO DE LA EJECUI√?N DEL PROCEDIMIENTO
    g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario             ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                         pm_ip_origen              ,pm_mac_maquina            ,'log'              ,NULL,
                                         pm_codigo_procedimiento   ,pm_proc_almacenado);

    ---*** SE DEVUELVE LA RESPUESTA
    RETURN g_respuesta||g_separador||g_reg_evento;


EXCEPTION

    WHEN others THEN BEGIN

        --SE OBTIENE EL MENSAJE Y EL N√?MERO DEL ERROR LANZADO POR EL GESTOR DE BASE DE DATOS
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