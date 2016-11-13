--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_ai_tipo_movimiento (
  al_tipo_movimiento varchar
)
RETURNS SETOF record AS
$body$
/*
* devuelve los ID y la descripcion de los tipos de movimiento
*/

DECLARE
  g_consulta 	text;
  g_rec			record;
BEGIN

	if al_tipo_movimiento = 'ingreso' then
    	g_consulta=' 	select  tip.id_tipo_movimiento
        				from alma.tai_tipo_movimiento tip
        				where tip.tipo =''ingreso'' OR tip.tipo=''transpaso_ingreso'' OR tip.tipo=''devolucion'' 
                        order by tip.id_tipo_movimiento ASC ';
                        
    elsif al_tipo_movimiento = 'salida' then
    	g_consulta:='	select  tip.id_tipo_movimiento
        				from alma.tai_tipo_movimiento tip
        				where tip.tipo =''salida'' OR tip.tipo=''transpaso_salida'' OR tip.tipo=''solicitud'' 
                        order by tip.id_tipo_movimiento ASC ';
    else 
    		raise exception 'Tipo de movimiento no definido ';
    end if;
    
    
    FOR g_rec in EXECUTE g_consulta
    LOOP
    	RETURN NEXT g_rec;
    END LOOP;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;