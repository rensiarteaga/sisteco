--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.trig_upd_unidad_constructiva (
)
RETURNS trigger AS
$body$
DECLARE
	v_res	varchar;
BEGIN
	IF TG_OP = 'INSERT' OR TG_OP = 'UPDATE' OR TG_OP = 'DELETE'
    THEN
    	DELETE FROM alma.tmp_unidad_constructiva;
    	select alma.f_ai_unidad_constructiva(NULL,NULL,'GENERAR_ARBOL',0) INTO v_res;
    END IF;
    
    RETURN NULL;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;