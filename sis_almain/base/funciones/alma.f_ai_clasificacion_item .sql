--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_ai_clasificacion_item (
  al_nodo_inicio integer,
  al_nodo_anterior integer,
  al_operacion varchar,
  al_nivel integer
)
RETURNS varchar AS
$body$
DECLARE
g_rec		record;
g_rec_det	record;
g_record	record;

g_nivel 	integer;
g_consulta 	text;
g_res		varchar;
g_res2		varchar;

BEGIN
	
    IF al_operacion = 'CLASIF_ITEM'
    THEN
        DELETE FROM alma.tmp_clasificacion_item;
    	FOR g_rec in (	SELECT c.id_clasificacion,c.id_clasificacion_fk,c.codigo,c.codigo_largo,c.nombre
        				FROM alma.tai_clasificacion c 
                        WHERE c.id_clasificacion_fk IS NULL  AND c.estado = 'activo' )
        loop
        
        	if not EXISTS (select 1 from alma.tmp_clasificacion_item a where a.id_clasificacion =g_rec.id_clasificacion )
            then
            		INSERT into alma.tmp_clasificacion_item(id_clasificacion,id_clasificacion_fk,nivel)
            		VALUES(g_rec.id_clasificacion,g_rec.id_clasificacion_fk,0);
            end if;
        	            
        	--recorrido de los nodos del arbol
            IF EXISTS (SELECT 1 FROM alma.tai_clasificacion a WHERE a.id_clasificacion_fk = g_rec.id_clasificacion)
            THEN
            		g_nivel :=1;
                    
            		FOR g_rec_det IN (select b.id_clasificacion,b.id_clasificacion_fk from alma.tai_clasificacion b where b.id_clasificacion_fk=g_rec.id_clasificacion)
                    LOOP
                    	IF EXISTS(select 1 from alma.tai_clasificacion c where c.id_clasificacion_fk = g_rec_det.id_clasificacion and c.estado='activo')
                        THEN
                        	g_res = alma.f_ai_clasificacion_item(g_rec_det.id_clasificacion,g_rec_det.id_clasificacion_fk,'BUSCAR_ITEM',al_nivel+1);
                        ELSE
                        	g_nivel = g_nivel +1;
                        	INSERT into alma.tmp_clasificacion_item(id_clasificacion,id_clasificacion_fk,nivel)
            				VALUES(g_rec_det.id_clasificacion,g_rec_det.id_clasificacion_fk,g_nivel);
                        END IF;
                    END LOOP;
            ELSE
            		if not EXISTS (select 1 from alma.tmp_clasificacion_item a where a.id_clasificacion =g_rec.id_clasificacion )
            		then
            		INSERT into alma.tmp_clasificacion_item(id_clasificacion,id_clasificacion_fk,nivel)
            		VALUES(g_rec.id_clasificacion,g_rec.id_clasificacion_fk,0);
            		end if;
            END IF;
        
        end loop;
        
        
    ELSIF al_operacion = 'BUSCAR_ITEM' THEN
    BEGIN
            FOR g_record IN (select i.id_clasificacion,i.id_clasificacion_fk from alma.tai_clasificacion i where i.id_clasificacion_fk=al_nodo_inicio and i.estado='activo')
        	LOOP
              IF EXISTS(select 1 from alma.tai_clasificacion b where b.id_clasificacion_fk=g_record.id_clasificacion)
              THEN
                  g_res2 = alma.f_ai_clasificacion_item(g_record.id_clasificacion,g_record.id_clasificacion_fk,'BUSCAR_ITEM',al_nivel+1);
              ELSE
                                   
                  INSERT into alma.tmp_clasificacion_item(id_clasificacion,id_clasificacion_fk,nivel)
            	  VALUES(g_record.id_clasificacion,g_record.id_clasificacion_fk,al_nivel);
                  
              END IF;
        	END LOOP;
    END;
    ELSIF al_operacion = 'BUSQUEDA1' THEN
    	BEGIN 
        		if EXISTS(select 1 from alma.tai_clasificacion c where c.id_clasificacion_fk = al_nodo_inicio and c.estado='activo')
                then 
                	IF NOT EXISTS(SELECT 1 FROM alma.tmp_clasificacion_item a WHERE a.id_clasificacion=al_nodo_inicio)
                    THEN
                			--registrar el nodo rama
                        	insert into alma.tmp_clasificacion_item(id_clasificacion,id_clasificacion_fk,nivel)
                        	values(al_nodo_inicio,NULL,0);
                    END IF;
                    
                   
                	FOR g_rec IN (select t.id_clasificacion,t.id_clasificacion_fk from alma.tai_clasificacion t where t.id_clasificacion_fk = al_nodo_inicio and t.estado='activo' )
            		LOOP 
                        g_nivel :=1;                       
                		if EXISTS(select 1 from alma.tai_clasificacion c where c.id_clasificacion_fk=g_rec.id_clasificacion and c.estado='activo')
                		then
                        	--registra el nodo superioro antes de ir a buscarlo
                            insert into alma.tmp_clasificacion_item(id_clasificacion,id_clasificacion_fk,nivel)
                        	values(g_rec.id_clasificacion,g_rec.id_clasificacion_fk,g_nivel);
                            
                        	g_res = alma.f_ai_clasificacion_item(g_rec.id_clasificacion,NULL,'BUSQUEDA2',g_nivel+1);	
                        else
                        --registrar el nodo sin hijos
                        	insert into alma.tmp_clasificacion_item(id_clasificacion,id_clasificacion_fk,nivel)
                        	values(g_rec.id_clasificacion,g_rec.id_clasificacion_fk,g_nivel);	
                        end if;
                    END LOOP;
                else
                	--insercion solo raiz
                    insert into alma.tmp_clasificacion_item(id_clasificacion,id_clasificacion_fk,nivel)
                    values(al_nodo_inicio,null,0);
                end if;
    	END;
    ELSIF al_operacion = 'BUSQUEDA2' THEN
    BEGIN
    			g_nivel :=al_nivel; 
    			FOR g_record IN (select i.id_clasificacion,i.id_clasificacion_fk from alma.tai_clasificacion i where i.id_clasificacion_fk=al_nodo_inicio and i.estado='activo')
                LOOP
                	IF EXISTS (SELECT 1 FROM alma.tai_clasificacion c WHERE c.id_clasificacion_fk = g_record.id_clasificacion)
                    THEN
                    		
                    		insert into alma.tmp_clasificacion_item(id_clasificacion,id_clasificacion_fk,nivel)
                        	values(g_record.id_clasificacion,g_record.id_clasificacion_fk,g_nivel);	
                            g_nivel=g_nivel+1;
                            
                            g_res2 = alma.f_ai_clasificacion_item(g_record.id_clasificacion,g_record.id_clasificacion_fk,'BUSQUEDA2',g_nivel);
                    
                    ELSE
                    		                   
                 		 	INSERT into alma.tmp_clasificacion_item(id_clasificacion,id_clasificacion_fk,nivel)
            	  		 	VALUES(g_record.id_clasificacion,g_record.id_clasificacion_fk,al_nivel);
                            
                    END IF;
                END LOOP;
    END;
    
    END IF;

    RETURN 'exito';
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;