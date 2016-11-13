--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_ai_ubicacion_funciones (
  al_procedimiento varchar,
  al_id_ubicacion integer,
  al_id_almacen integer
)
RETURNS SETOF record AS
$body$
DECLARE

g_detalle	record;
g_registros	record;
v_res	 	varchar;
v_aux		varchar;
v_rama		record;
v_cant		integer;
v_foreing	integer;


BEGIN

select a.codigo,a.nombre,a.estado,a.id_almacen,a.tipo_ubicacion,a.id_ubicacion,a.id_ubicacion_fk INTO g_detalle
from alma.tai_ubicacion a
where a.id_ubicacion=al_id_ubicacion;


IF al_procedimiento = 'BUCAR_RAIZ' THEN --DADO UNCA UBICAICON BUSCA LA RAIZ

	if not EXISTS(select 1
                  from pg_catalog.pg_class c 
                  where c.relname='tt_raiz')
    then
    		EXECUTE('create temp table tt_raiz(id_ubicacion integer) on commit drop;');
    end if;
    

    if EXISTS(select 1 from alma.tai_ubicacion a where a.id_ubicacion_fk is not null and a.id_almacen=al_id_almacen and a.id_ubicacion=al_id_ubicacion) then
        
    	EXECUTE('insert into tt_raiz(id_ubicacion) values('||al_id_ubicacion||');');
            
        for v_rama IN (	select a.id_ubicacion_fk
            				from alma.tai_ubicacion a 
                            where a.id_ubicacion = al_id_ubicacion and a.id_almacen=al_id_almacen)
        loop
            	
        	EXECUTE('insert into tt_raiz(id_ubicacion) values('||v_rama.id_ubicacion_fk||');');
            if EXISTS(select 1 from alma.tai_ubicacion a where a.id_ubicacion=v_rama.id_ubicacion_fk) then
            
            	v_aux = 'select * from alma.f_ai_ubicacion_funciones(''BUCAR_RAIZ'','||v_rama.id_ubicacion_fk||','||al_id_almacen||') AS (id_ubic integer)';
                EXECUTE(v_aux);
            
            end if;
            
        end loop;
    else
    	EXECUTE('insert into tt_raiz(id_ubicacion) values('||al_id_ubicacion||');');
    end if;
    
    for g_detalle in EXECUTE('select min(id_ubicacion) from tt_raiz')
    loop
    	RETURN NEXT g_detalle;
    end loop;

ELSIF al_procedimiento = 'ARMAR_ARBOL_ATRAS' THEN
BEGIN
	if not EXISTS(select 1
                  from pg_catalog.pg_class c 
                  where c.relname='tt_back')
    then
    		EXECUTE('create temp table tt_back(id_ubicacion integer) on commit drop;');
    end if;

	v_foreing := g_detalle.id_ubicacion_fk;
    
	while v_foreing IS NOT NULL
    loop
    	select a.id_ubicacion,a.id_ubicacion_fk,a.tipo_ubicacion into g_registros
        from alma.tai_ubicacion a
        where a.id_ubicacion = v_foreing and a.id_almacen=al_id_almacen;
        
        EXECUTE('insert into tt_back(id_ubicacion) values('||v_foreing||');');
        
        v_aux = 'select * from alma.f_ai_ubicacion_funciones(''ARMAR_ARBOL_ATRAS'','||v_foreing||','||al_id_almacen||') AS (id integer)';
        EXECUTE(v_aux);
        
    	v_foreing := g_registros.id_ubicacion_fk;

    end loop;
    
    for v_rama in EXECUTE('select DISTINCT id_ubicacion from tt_back')
    loop
    	RETURN NEXT v_rama;
    end loop;
    

END;

ELSIF al_procedimiento='ARBOL_COMPLETO' THEN
BEGIN

	if EXISTS(select 1
                  from pg_catalog.pg_class c 
                  where c.relname='tt_ubic')
    then
    		EXECUTE('drop table tt_ubic;');
    end if;

	if g_detalle.id_ubicacion_fk is null then
    	v_res='select * from alma.f_ai_ubicacion_funciones(''ARMAR_ARBOL_RAIZ'','||al_id_ubicacion||','||al_id_almacen||') as (id_ubicacion integer)'; 	
        
        for g_detalle in EXECUTE(v_res)
        loop
        	RETURN NEXT g_detalle;
        end loop;
    else
    	if g_detalle.tipo_ubicacion = 'rama' then
        	EXECUTE('create temp table tt_ubic(id_ubicacion integer) on commit drop;');
            
            for v_rama in EXECUTE('select * from alma.f_ai_ubicacion_funciones(''ARMAR_ARBOL_ATRAS'','||al_id_ubicacion||','||al_id_almacen||') as (id_ubicacion integer)')
            loop
            
            	EXECUTE('INSERT INTO tt_ubic(id_ubicacion) values('||v_rama.id_ubicacion||');');
            
            end loop;
            
             for v_rama in EXECUTE('select * from alma.f_ai_ubicacion_funciones(''ARMAR_ARBOL_RAIZ'','||al_id_ubicacion||','||al_id_almacen||') as (id_ubicacion integer)')
             loop
             	EXECUTE('INSERT INTO tt_ubic(id_ubicacion) values('||v_rama.id_ubicacion||');');
             end loop;
            
             for g_detalle in EXECUTE ('select DISTINCT * from tt_ubic')
             loop
             	RETURN NEXT g_detalle;
             end loop;
        elsif g_detalle.tipo_ubicacion = 'nodo' then
        	
        	EXECUTE('create temp table tt_nodos(id_ubicacion integer) on commit drop;');
            EXECUTE('INSERT INTO tt_nodos(id_ubicacion) values('||al_id_ubicacion||');');
            for v_rama in EXECUTE('select * from alma.f_ai_ubicacion_funciones(''ARMAR_ARBOL_ATRAS'','||al_id_ubicacion||','||al_id_almacen||') as (id_ubicacion integer)')
            loop
            	EXECUTE('INSERT INTO tt_nodos(id_ubicacion) values('||v_rama.id_ubicacion||');');
            end loop;
            
            for g_detalle in EXECUTE ('select DISTINCT * from tt_nodos')
            loop
             	RETURN NEXT g_detalle;
            end loop;
            
        end if;
    	
    end if;
END;

/*
	dado un id de raiz busca ramas inmediatas de la raiz
*/
ELSIF al_procedimiento = 'ARMAR_ARBOL_RAIZ' THEN --dado un  nodo busca todos los elementos inferiores a ese nodo

	if not EXISTS(select 1
                  from pg_catalog.pg_class c 
                  where c.relname='tt_arbol')
    then
    		EXECUTE('create temp table tt_arbol(id_ubicacion integer) on commit drop;');
    end if;
    

	if EXISTS (select 1 from alma.tai_ubicacion a where a.id_ubicacion_fk = al_id_ubicacion and a.id_almacen=al_id_almacen) 
    then
		
        EXECUTE('insert into tt_arbol(id_ubicacion) values('||al_id_ubicacion||');');
        
    	for v_rama in(select a.id_ubicacion
        				from alma.tai_ubicacion a 
                        where a.id_ubicacion_fk = al_id_ubicacion and a.id_almacen=al_id_almacen)
        loop

            EXECUTE('insert into tt_arbol(id_ubicacion) values('||v_rama.id_ubicacion||');');
            
        	if EXISTS (select 1 from alma.tai_ubicacion a where a.id_ubicacion_fk = v_rama.id_ubicacion)
            then
            	v_aux = 'select * from alma.f_ai_ubicacion_funciones(''ARMAR_ARBOL_RAIZ'','||v_rama.id_ubicacion||','||al_id_almacen||') AS (id_ubic integer)';
                EXECUTE(v_aux);
                              
            end if;
        
        end loop;
    else
    	EXECUTE('insert into tt_arbol(id_ubicacion) values('||al_id_ubicacion||');');
    end if;
    
    for g_detalle in EXECUTE('select DISTINCT id_ubicacion from tt_arbol')
    loop
    	RETURN NEXT g_detalle;
    end loop;
END IF;
RETURN ;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;