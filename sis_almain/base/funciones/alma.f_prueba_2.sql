--------------- SQL ---------------

CREATE FUNCTION alma.f_prueba_2 (
)
RETURNS boolean AS
$body$
DECLARE
  
BEGIN
raise exception 'HOLAAAAAAAAAAAAA';
return false;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;