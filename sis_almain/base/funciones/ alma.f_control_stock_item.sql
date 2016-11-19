--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_control_stock_item (
  id_movimiento integer
)
RETURNS boolean AS
$body$
DECLARE
  res 	boolean;
  data 	record;
  stock numeric;
  existencias numeric;	
  calculo_existencias	record;	
  
BEGIN

	FOR data  IN (
        			SELECT mov.id_almacen,det.id_item, det.cantidad    
                    FROM alma.tai_movimiento mov
                    INNER JOIN alma.tai_detalle_movimiento det on det.id_movimiento=mov.id_movimiento
                    WHERE mov.id_movimiento = id_movimiento	
                    ORDER BY det.id_item ASC
        		)
    LOOP
    	
    	
    	
    	if(alma.f_ai_define_tipo_movimiento(id_movimiento) = 'ingreso')
        then
        
        	select st.maximo into stock
            from alma.tai_stock_item st
            where st.id_almacen = data.id_almacen AND st.id_item = data.id_item;
            
            --existencias = alma.f_ai_detalle_saldos(data.id_almacen,data.id_item,'MOVIMIENTO',id_movimiento) + data.cantidad - alma.;
			calculo_existencias = alma.f_ai_calculo_saldo(NULL,NULL,data.id_almacen,data.id_item,'MOVIM');--detalle de omvimeintos del item finalizados en el almacen
            existencias = calculo_existencias.al_saldo_item + data.cantidad;--total existencias item en el almacen + cantidad a ingresar
            calculo_existencias = alma.f_ai_calculo_saldo(NULL,NULL,data.id_almacen,data.id_item,'SOLIC');--detalle de reservas del item en el almacen
            existencias = existencias - calculo_existencias.al_saldo_item;
            
            if(existencias > stock) then
            	res = false;
                raise notice 'El item % , sobrepasa el stock maximo de items parametrizado en el almacen % (stock items-almacen)',data.id_item,data.id_almacen;

            else
            	res = true;
            end if;
            
        
        elsif alma.f_ai_define_tipo_movimiento(id_movimiento) = 'salida' then
        	
        	select st.minimo into stock
            from alma.tai_stock_item st
            where st.id_almacen = data.id_almacen AND st.id_item = data.id_item;

            -- existencias = alma.f_ai_detalle_saldos(data.id_almacen,data.id_item,'MOVIMIENTO',id_movimiento) - data.cantidad;
            calculo_existencias = alma.f_ai_calculo_saldo(NULL,NULL,data.id_almacen,data.id_item,'MOVIM');--detalle de omvimeintos del item finalizados en el almacen
            existencias = calculo_existencias.al_saldo_item - data.cantidad;--total existencias item en el almacen - cantidad a despacharse
           	calculo_existencias = alma.f_ai_calculo_saldo(NULL,NULL,data.id_almacen,data.id_item,'SOLIC');--detalle de reservas del item en el almacen
            existencias = existencias - calculo_existencias.al_saldo_item;
            
            if(existencias > stock) then
            	res = true;
            else
                raise notice 'El stock minimo del item %, en el almacen % es inferior al parametrizado',data.id_almacen,data.id_item;
                res = false;
            end if;
            
    	else
        	raise notice 'tipo de movimiento no fue definido';
        	raise exception 'Definir tipo movimiento %';
            
        end if;
    
    END LOOP;


return res;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;