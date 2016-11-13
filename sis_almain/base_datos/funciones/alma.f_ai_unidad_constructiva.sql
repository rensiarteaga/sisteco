--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_ai_unidad_constructiva (
  al_nodo_inicio integer,
  al_nodo_anterior integer,
  al_operacion varchar,
  al_nivel integer
)
RETURNS varchar AS
$body$
/*
*	Dado el nodo padre de un arbol, retorna todos los nodos finales del arbol
*/
DECLARE
g_rec		record;
g_rec2		record;
g_res		varchar;
g_res2		varchar;
g_id_uc		integer;

g_rec_det	record;
g_nivel		integer;
g_record	record;

BEGIN 

IF al_operacion='GENERAR_ARBOL'
THEN
	BEGIN
    	FOR g_rec IN (	select a.id_unidad_constructiva
        				from alma.tai_unidad_constructiva a
                        where a.id_unidad_constructiva_fk is null and a.estado='activo')
        LOOP
        	--recorrido de los nodos del arbol
            IF EXISTS (SELECT 1 FROM alma.tai_unidad_constructiva a WHERE a.id_unidad_constructiva_fk = g_rec.id_unidad_constructiva)
            THEN
            		g_nivel :=0;
                    
            		FOR g_rec_det IN (select b.id_unidad_constructiva from alma.tai_unidad_constructiva b where b.id_unidad_constructiva_fk=g_rec.id_unidad_constructiva)
                    LOOP
                    	IF EXISTS(select 1 from alma.tai_unidad_constructiva c where c.id_unidad_constructiva_fk = g_rec_det.id_unidad_constructiva and c.estado='activo')
                        THEN
                        	g_res = alma.f_ai_unidad_constructiva(g_rec.id_unidad_constructiva,g_rec_det.id_unidad_constructiva,'GENERAR_ARBOL2',al_nivel+1);
                        ELSE
                        	g_nivel = g_nivel+1;
                        	INSERT INTO alma.tmp_unidad_constructiva(id_unidad_constructiva,nivel,id_nodo_padre)
            				VALUES(g_rec_det.id_unidad_constructiva,g_nivel,g_rec.id_unidad_constructiva);
                        END IF;
                    END LOOP;
            ELSE
            		INSERT INTO alma.tmp_unidad_constructiva(id_unidad_constructiva,nivel,id_nodo_padre)
            		VALUES(g_rec.id_unidad_constructiva,0,NULL);
            END IF;
            
        END LOOP;
    END;
 
ELSIF al_operacion='GENERAR_ARBOL2'
THEN
	BEGIN
    
		FOR g_record IN (select a.id_unidad_constructiva from alma.tai_unidad_constructiva a where a.id_unidad_constructiva_fk=al_nodo_anterior and a.estado='activo')
        LOOP
        	IF EXISTS(select 1 from alma.tai_unidad_constructiva b where b.id_unidad_constructiva_fk=g_record.id_unidad_constructiva)
            THEN
            	g_res2 = alma.f_ai_unidad_constructiva(al_nodo_inicio,g_record.id_unidad_constructiva,'GENERAR_ARBOL2',al_nivel+1);
            ELSE
            	INSERT INTO alma.tmp_unidad_constructiva(id_unidad_constructiva,nivel,id_nodo_padre)
            	VALUES(g_record.id_unidad_constructiva,al_nivel+1,al_nodo_inicio);
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