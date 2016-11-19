--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_ai_define_tipo_movimiento (
  al_id_movimiento integer
)
RETURNS varchar AS
$body$
/*
*Funcion para definir los tipos de movimientos basicos en el sistema
*/
DECLARE

v_res	varchar;
v_rec	record;

BEGIN

--detalle del tipo de movimiento
SELECT mov.id_tipo_movimiento,lower(tip.tipo)as tipo INTO v_rec
FROM alma.tai_movimiento mov 
INNER JOIN alma.tai_tipo_movimiento tip on tip.id_tipo_movimiento=mov.id_tipo_movimiento
WHERE mov.id_movimiento=al_id_movimiento;

IF v_rec.tipo IN ('ingreso','devolucion','transpaso_ingreso')THEN
		v_res := 'ingreso';
ELSIF v_rec.tipo IN ('salida','solicitud','transpaso_salida')THEN 
		v_res := 'salida';
ELSIF  v_rec.tipo IN ('ingreso_proyecto','salida_proyecto')THEN 
		v_res := 'proyecto';
ELSIF  v_rec.tipo IN ('salida_uc')THEN
		v_res := 'uc';
END IF;

RETURN v_res;

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;