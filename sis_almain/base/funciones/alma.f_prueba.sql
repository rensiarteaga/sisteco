--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_al_prueba (
)
RETURNS boolean AS
$body$
DECLARE
 
BEGIN
  
raise exception 'llega   --------------------------------> 2222222222222222222222222';
return  true;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;