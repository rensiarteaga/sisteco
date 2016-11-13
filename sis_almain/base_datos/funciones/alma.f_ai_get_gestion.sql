--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_ai_get_gestion (
)
RETURNS integer AS
$body$
DECLARE
	res	integer;
BEGIN

	select ges.id_gestion into res
    from param.tpm_gestion ges
    where ges.id_gestion = (select max(a.id_gestion) 
    						from param.tpm_gestion a 
                            where a.estado_vigente = 'si' AND a.estado_ges_gral = 'abierto') ; 
    
    return res;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;