--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_al_prueba (
)
RETURNS boolean AS
$body$
DECLARE
 
BEGIN
  
raise exception 'llega ....funcion modificada';
return  true;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;  