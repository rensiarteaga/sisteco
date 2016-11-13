--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_ai_saldo_almacen_items (
  al_id_almacen integer,
  al_id_item integer,
  al_procedimiento varchar
)
RETURNS SETOF record AS
$body$
--devuelve el saldo de los items de un almacen
DECLARE
 g_registros	record;
 g_rec			record;
BEGIN
		if al_procedimiento = 'SALDO_ALMACEN'
        then
        
        	EXECUTE('create temp table tt_cantidad_item (id_item integer,cantidad numeric) on commit drop;');
            
			for g_registros IN EXECUTE('	 select det.id_item
                                                 from alma.tai_movimiento mov 
                                                 inner join alma.tai_detalle_movimiento det on det.id_movimiento=mov.id_movimiento
                                                 where  det.id_item like(''%'') and mov.estado=''finalizado'' and mov.id_almacen='||al_id_almacen||'
                                                 group by det.id_item
                                                 order by det.id_item ASC')
            loop
            	
            		g_rec := (alma.f_ai_calculo_saldo(NULL,NULL,al_id_almacen,g_registros.id_item,'MOVIM'));	
            		 EXECUTE('insert INTO tt_cantidad_item values('||g_registros.id_item||','||g_rec.al_saldo_item||');');
            end loop;
            
            FOR g_registros in    EXECUTE ('select * from tt_cantidad_item ;')
            LOOP
                    RETURN NEXT g_registros;
            END LOOP;
            
        elsif al_procedimiento='SALDO_ALMACEN_ITEM' then
        
        	EXECUTE('create temp table tt_cantidad_item (id_item integer,cantidad numeric) on commit drop;');
        	g_rec := (alma.f_ai_calculo_saldo(NULL,NULL,al_id_almacen,al_id_item,'MOVIM'));	
            EXECUTE('insert INTO tt_cantidad_item values('||al_id_item||','||g_rec.al_saldo_item||');');
            
            FOR g_registros in    EXECUTE ('select * from tt_cantidad_item ;')
            LOOP
                    RETURN NEXT g_registros;
            END LOOP;
            
        end if;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;