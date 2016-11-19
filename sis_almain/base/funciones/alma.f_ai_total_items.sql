--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_ai_total_items (
  al_id_item integer,
  al_id_almacen integer
)
RETURNS numeric AS
$body$
DECLARE
v_res numeric;
BEGIN

if EXISTS(	select 1 from alma.tai_solicitud_salida a 
			inner join alma.tai_detalle_solicitud b on b.id_solicitud_salida=a.id_solicitud_salida
            where a.estado='proceso_entrega' and a.id_almacen=al_id_almacen and b.id_item=al_id_item
            )
then
      select sum(det.cantidad) as items_reservados into v_res
      from alma.tai_solicitud_salida sol
      inner join alma.tai_detalle_solicitud det on det.id_solicitud_salida=sol.id_solicitud_salida
      where sol.id_almacen = al_id_almacen AND det.id_item = al_id_item and sol.estado='proceso_entrega'
      group by det.id_item;
else
v_res=0;
end if;
return v_res;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;