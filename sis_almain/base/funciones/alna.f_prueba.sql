--------------- SQL ---------------

CREATE FUNCTION almin.f_al_prueba (
)
RETURNS boolean AS
$body$
DECLARE
 
BEGIN
  
raise exception 'llega';
return  true;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;