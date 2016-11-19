--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_control_stocks (
  tipo varchar,
  al_id_almacen integer,
  al_id_item integer
)
RETURNS varchar AS
$body$
DECLARE
res varchar;
existencias record;
reservas	record;
total		numeric;
separador 	varchar;
stock 		numeric;

BEGIN
separador = '#@@@#';

if(tipo = 'SOLIC')
then 
	select s.minimo into stock
    from alma.tai_stock_item s
    where s.id_almacen = al_id_almacen AND s.id_item = al_id_item;	

	existencias = alma.f_ai_calculo_saldo(NULL,NULL,al_id_almacen,al_id_item,'MOVIM');--existencias de id_item en id_almacen a la fecha
    reservas = alma.f_ai_calculo_saldo(NULL,NULL,al_id_almacen,al_id_item,'SOLIC');--id_items reservados en el almacen id_almacen
    total = existencias.al_saldo_item - reservas.al_saldo_item;
	raise notice '%,%',existencias,reservas;
	res = total||separador||stock;
end if;

return res;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;