--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.trig_control_stock_item (
)
RETURNS trigger AS
$body$
DECLARE
  cantidad_item		numeric;
  detalle  			record;
  v_almacen			integer;
  v_item			integer;
  minimo			numeric;
  maximo			numeric;
BEGIN
	if TG_OP = 'INSERT' OR TG_OP = 'UPDATE' THEN
      BEGIN
       	select det.id_item into v_item from alma.tai_detalle_movimiento det where det.id_detalle_movimiento = NEW.id_detalle_movimiento;
        select mov.id_almacen into v_almacen from alma.tai_movimiento mov where mov.id_movimiento=NEW.id_movimiento;
      	
        --stock min y max del item que se registra o se modifica en el almacen
        select stock.minimo,stock.maximo INTO minimo,maximo
        from alma.tai_stock_item stock 
        where stock.id_item = v_item AND stock.id_almacen = v_almacen; 
        
        if (minimo > 0 AND maximo > 0)
        then
        	--llamada a la funcion que calcula el saldo del item de un almacen
            cantidad_item := alma.f_ai_detalle_saldos(v_almacen,NEW.id_item,'MOVIMIENTO',NULL);
            
            raise exception '%',cantidad_item;
        else
        	raise exception '%','Error: El item '||NEW.id_item||' no tiene registrado un stock minimo ni maximo, en el almacen correspondiente';
        end if;
      
      END;      
    END if;
RETURN NULL;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;