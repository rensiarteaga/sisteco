--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_ai_ubicacion_item_almacen (
  al_id_ubicacion integer,
  al_id_almacen integer,
  al_procedimiento varchar
)
RETURNS SETOF record AS
$body$
DECLARE

v_det_ubic 	record;
v_raiz 		record;
v_rama		record;
g_registros record;
g_rec		record;
v_find		varchar;
g_consulta  varchar;
  
BEGIN

--detalle de la ubicacion enviada como parametro
select ubic.estado,ubic.codigo,ubic.tipo_ubicacion INTO v_det_ubic
from alma.tai_ubicacion ubic
where ubic.id_ubicacion = al_id_ubicacion AND ubic.id_almacen=al_id_almacen;

IF al_procedimiento = 'BUSQUEDA1' THEN

	EXECUTE('CREATE TEMP TABLE tt_ubicacion(id_ubicacion integer,id_ubicacion_fk integer) ON COMMIT DROP;');

    if lower(v_det_ubic.tipo_ubicacion) = 'raiz' then--se arma el arbol completo

		EXECUTE('INSERT INTO tt_ubicacion(id_ubicacion,id_ubicacion_fk) VALUES('||al_id_ubicacion||',Null);');--INSERCION DE LA RAIZ
        
    	FOR v_raiz IN (SELECT a.id_ubicacion,a.id_ubicacion_fk from alma.tai_ubicacion a WHERE a.id_ubicacion_fk = al_id_ubicacion AND a.id_almacen=al_id_almacen)--BUSQUEDA DE  LAS RAMAS
        LOOP
        	EXECUTE('INSERT INTO tt_ubicacion(id_ubicacion,id_ubicacion_fk) VALUES('||v_raiz.id_ubicacion||','||v_raiz.id_ubicacion_fk||');');--INSERCION PRIMERA RAMA
            
            	if EXISTS(select 1 from alma.tai_ubicacion a where a.id_ubicacion_fk =v_raiz.id_ubicacion )--BUSQUEDA DE  RAMAS O NODOS
                then
                --	g_rec = select * from alma.f_ai_ubicacion_item_almacen(v_raiz.id_ubicacion,al_id_almacen,'BUSQUEDA2') as (id_ubicacion integer,id_ubicacion_fk integer);
                     
                end if;
    
        END LOOP;
        g_consulta:='select * from tt_ubicacion';
        FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
        END LOOP;
        
    end if;
    
ELSIF al_procedimiento ='BUSQUEDA2' THEN
	    
	
    	FOR v_rama IN (select u.id_ubicacion,u.id_ubicacion_fk
    				from alma.tai_ubicacion u
                    where u.id_ubicacion_fk = al_id_ubicacion)
    	LOOP
    		EXECUTE('INSERT INTO tt_ubicacion(id_ubicacion,id_ubicacion_fk) VALUES('||v_rama.id_ubicacion||','||v_rama.id_ubicacion_fk||');');--INSERCION RAMAS
        	
            IF EXISTS(select 1 from alma.tai_ubicacion a where a.id_ubicacion_fk = v_rama.id_ubicacion) then
            --	g_rec = alma.f_ai_ubicacion_item_almacen(v_rama.id_ubicacion,al_id_almacen,'BUSQUEDA2') as (id_ubicacion integer,id_ubicacion_fk integer);
            END IF;

        END LOOP;
        
        g_consulta:='select * from tt_ubicacion';
        FOR g_registros in EXECUTE(g_consulta) LOOP
                RETURN NEXT g_registros;
        END LOOP;
    	
    
END IF;

RETURN;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;