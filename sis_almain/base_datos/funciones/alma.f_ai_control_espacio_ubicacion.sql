--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_ai_control_espacio_ubicacion (
  al_procedimiento varchar,
  al_id_almacen integer,
  al_id_item integer,
  al_cantidad numeric,
  al_orden integer
)
RETURNS boolean AS
$body$
DECLARE
v_res 							boolean DEFAULT false;
v_rec							record;
v_ubicaciones					record;
v_espacio_ubicacion				numeric DEFAULT 0;
v_cant_restante					numeric;
v_total_espacio_ubicacion		numeric;
v_espacio_parcial				numeric;
v_espacio_ocupado				numeric;
v_max_orden						integer;

-- variables salida
v_restante						numeric;

BEGIN
  

    
 if al_procedimiento = 'REG_INGRESO'
 then
 
 	select sum(a.cant_max_ing)  into v_total_espacio_ubicacion
    from alma.tai_ubicacion_item_detalle a
    where a.id_item=al_id_item and a.id_almacen=al_id_almacen and a.sw_espacio=true;
        

    if(v_total_espacio_ubicacion < al_cantidad)
    then
      	raise exception '%','Error al registrar el item '||al_id_item||' ,en el almacen '||al_id_almacen||' no existe espacio suficiente en las ubicaciones  registradas';
        v_res:=false;
    end if;
 
 	
 	for v_rec IN (	   select a.id_ubicacion_item_detalle,a.id_ubicacion,a.orden,a.saldo_item_ubicacion,a.cant_max_ing as total_ingreso_ubicacion,a.sw_espacio
                       from alma.tai_ubicacion_item_detalle a
                       where a.id_almacen=al_id_almacen AND a.id_item=al_id_item and a.sw_espacio=true 
	                         and a.orden	 = (		select min(b.orden)
            		                                    from alma.tai_ubicacion_item_detalle b
      		        	                                where b.id_almacen=al_id_almacen and b.id_item=al_id_item and b.sw_espacio=true)
                    )
    loop
    	    
    		v_espacio_ubicacion = v_rec.total_ingreso_ubicacion - v_rec.saldo_item_ubicacion; --espacio disponible en la ubicacion
        
    		if (v_espacio_ubicacion > 0 OR (v_rec.saldo_item_ubicacion < v_rec.total_ingreso_ubicacion) )--hay espacio (v_espacio_ubicacion) para el item en la ubicacion X
            then
            	
            	v_cant_restante = al_cantidad - v_espacio_ubicacion;
                
            	if(v_cant_restante < 0)then--hay espacio de sobra para la el item en la ubicacion
                
                		UPDATE alma.tai_ubicacion_item_detalle
                        SET saldo_item_ubicacion = saldo_item_ubicacion + al_cantidad,
                            sw_espacio = true
                        WHERE id_ubicacion_item_detalle = v_rec.id_ubicacion_item_detalle;
                	
                		v_res:=true;
                        
                elsif( v_cant_restante = 0) then--existe el espacio justo en la ubicacion
                
                		UPDATE alma.tai_ubicacion_item_detalle
                        SET saldo_item_ubicacion = saldo_item_ubicacion + al_cantidad,
                            sw_espacio = false
                        WHERE id_ubicacion_item_detalle = v_rec.id_ubicacion_item_detalle;
                        
                        v_res:=true;
                        
                else --falta espacio en la ubicacion
                		--llena la ubicacion 1
                		UPDATE alma.tai_ubicacion_item_detalle
                        SET saldo_item_ubicacion = saldo_item_ubicacion +  v_espacio_ubicacion,
                            sw_espacio = false
                        WHERE id_ubicacion_item_detalle = v_rec.id_ubicacion_item_detalle;
                        
                        --llamada a la funcion que busca ordenar el item en las ubicaciones libres restantes (existe espacio)
                        v_res = alma.f_ai_control_espacio_ubicacion('BUSCA_OTRAS_UBICACIONES',al_id_almacen,al_id_item,v_cant_restante,v_rec.orden);
                end if;
                
            	
            else
            --pasar a la otra ubicacion,no hay  mas espacio para el item en esta ubicacion
                v_res:=false;
            
            end if;
    end loop;
    
 elsif al_procedimiento = 'BUSCA_OTRAS_UBICACIONES' then
 	BEGIN
    
		select max(a.orden)  into v_max_orden
        from alma.tai_ubicacion_item_detalle a
        where a.id_almacen = al_id_almacen and a.id_item=al_id_item;
        
        if (al_orden < v_max_orden) then 
        
          
          if NOT EXISTS (select 1 from alma.tai_ubicacion_item_detalle a where a.id_almacen=al_id_almacen and a.id_item=al_id_item and a.orden = al_orden + 1 and a.sw_espacio=true) then
          
              raise exception '%','Error al registrar el item '||al_id_item||' ,en el almacen '||al_id_almacen||' no existe el orden '||al_orden;
              v_res:=false;
          
          end if;
          
        
        end if;
        
    
        
        for v_ubicaciones in (	SELECT a.id_ubicacion_item_detalle,a.id_ubicacion,a.orden,a.saldo_item_ubicacion,a.cant_max_ing as total_ingreso_ubicacion
    							FROM alma.tai_ubicacion_item_detalle a 
                                WHERE a.id_almacen =al_id_almacen and a.id_item=al_id_item and a.sw_espacio=true and a.orden = al_orden+1)  
        loop
            
            	v_espacio_ubicacion = v_ubicaciones.total_ingreso_ubicacion - v_ubicaciones.saldo_item_ubicacion; --espacio disponible en la ubicacion
                v_espacio_parcial = al_cantidad - v_espacio_ubicacion;
            
               if(al_cantidad < v_espacio_ubicacion) then --existe espacio de sobra
               	 	
                    UPDATE alma.tai_ubicacion_item_detalle
                    SET saldo_item_ubicacion = saldo_item_ubicacion +  al_cantidad,
                    	sw_espacio = true
                    WHERE id_ubicacion_item_detalle = v_ubicaciones.id_ubicacion_item_detalle;
                    
                     v_res:=true;
                    
               elsif(al_cantidad =  v_espacio_ubicacion) then --el espacio en la ubicacion es exacta 
                
                      UPDATE alma.tai_ubicacion_item_detalle
                      SET saldo_item_ubicacion = saldo_item_ubicacion +  al_cantidad,
                          sw_espacio = false
                      WHERE id_ubicacion_item_detalle = v_ubicaciones.id_ubicacion_item_detalle;
                      
                       v_res:=true;
                       
               else--la cantidad a ingresar sobrepasa el limite de la ubicacion
               		
               		  UPDATE alma.tai_ubicacion_item_detalle
                      SET saldo_item_ubicacion = saldo_item_ubicacion +  v_espacio_ubicacion,
                          sw_espacio = false
                      WHERE id_ubicacion_item_detalle = v_ubicaciones.id_ubicacion_item_detalle;  
                      
                      v_res = alma.f_ai_control_espacio_ubicacion('BUSCA_OTRAS_UBICACIONES',al_id_almacen,al_id_item,v_espacio_parcial,v_ubicaciones.orden);             	
               end if;
                
            
        end loop;


    END;
    
 elsif al_procedimiento = 'REG_SALIDAS' then
 	BEGIN
    	
    	--verificacion de que se tenga la cantidad suficiente del item en el almacen
        select sum(a.saldo_item_ubicacion)	into v_cant_restante
        from alma.tai_ubicacion_item_detalle a
        where a.id_almacen=al_id_almacen and a.id_item=al_id_item;
        
        if  (v_cant_restante < al_cantidad) then --no existe la cantidad suficiente para la salida del almacen
        
        	v_res = false;
            raise exception '%','Verifique las existencias del item '||al_id_item||' , en el almacen '||al_id_almacen||' (existencias insuficientes)';
        end if;
        
        for v_rec in (	select a.id_ubicacion_item_detalle,a.orden,a.saldo_item_ubicacion
        				from alma.tai_ubicacion_item_detalle a
                        where a.id_almacen = al_id_almacen AND a.id_item = al_id_item 
                        	  and a.orden = (	select min(b.orden)
                              					from alma.tai_ubicacion_item_detalle b
                                                where b.id_almacen=al_id_almacen and b.id_item=al_id_item
                        	 				)
                        )
        loop
        
        	        
        	if v_rec.saldo_item_ubicacion > al_cantidad then --existe suficientes existencias en la primera ubicacion para la salida del item
            
            	v_res = true;
                
                UPDATE alma.tai_ubicacion_item_detalle
                SET saldo_item_ubicacion = saldo_item_ubicacion - al_cantidad,
                	sw_espacio = true 
                WHERE id_ubicacion_item_detalle = v_rec.id_ubicacion_item_detalle;
                
            elsif(v_rec.saldo_item_ubicacion = al_cantidad)then--la cantidad de salida es igual a las existencias en la ubicacion
            
            	v_res = true;
                
            	UPDATE alma.tai_ubicacion_item_detalle
                SET saldo_item_ubicacion = saldo_item_ubicacion - al_cantidad,
                	sw_espacio = true 
                WHERE id_ubicacion_item_detalle = v_rec.id_ubicacion_item_detalle;
            else --no existen las existencias suficientes en la ubicacion por lo que se deberia utilizar las otras ubicaciones
            
				v_restante = al_cantidad - v_rec.saldo_item_ubicacion;	
            	            
            	UPDATE alma.tai_ubicacion_item_detalle
                SET saldo_item_ubicacion = 0,
                	sw_espacio = true 
                WHERE id_ubicacion_item_detalle = v_rec.id_ubicacion_item_detalle;
                
            	v_res = alma.f_ai_control_espacio_ubicacion('BUSCA_UBICACIONES_SALIDA',al_id_almacen,al_id_item,v_restante,v_rec.orden);
                
            end if;

        
        end loop;
    
	END;
 
 elsif al_procedimiento = 'BUSCA_UBICACIONES_SALIDA' then
 	BEGIN
    
    
    	select max(a.orden)  into v_max_orden
        from alma.tai_ubicacion_item_detalle a
        where a.id_almacen = al_id_almacen and a.id_item=al_id_item;
        
        if (al_orden < v_max_orden) then 
        
          
          if NOT EXISTS (select 1 from alma.tai_ubicacion_item_detalle a where a.id_almacen=al_id_almacen and a.id_item=al_id_item and a.orden = al_orden + 1 ) then
          
              raise exception '%','Error al registrar el item '||al_id_item||' ,en el almacen '||al_id_almacen||' no existe el orden '||al_orden;
              v_res:=false;
          
          end if;
          
        
        end if;

            
        for v_ubicaciones in (	select a.id_ubicacion_item_detalle,a.orden,a.saldo_item_ubicacion
            					from alma.tai_ubicacion_item_detalle a 
                                where a.id_almacen = al_id_almacen and a.id_item = al_id_item and a.orden=al_orden + 1)
        loop
        
        	if v_ubicaciones.saldo_item_ubicacion > al_cantidad --existen suficientes existencias para la salida
            then
            	v_res=true;
                
                UPDATE alma.tai_ubicacion_item_detalle
                SET saldo_item_ubicacion = saldo_item_ubicacion - al_cantidad,
                	sw_espacio = true
                WHERE id_ubicacion_item_detalle = v_ubicaciones.id_ubicacion_item_detalle;
                
            elsif v_ubicaciones.saldo_item_ubicacion = al_cantidad then
            	v_res =true;
                
                UPDATE alma.tai_ubicacion_item_detalle
                SET saldo_item_ubicacion = saldo_item_ubicacion - al_cantidad,
                	sw_espacio = true
                WHERE id_ubicacion_item_detalle = v_ubicaciones.id_ubicacion_item_detalle;
           else
           	     
           		UPDATE alma.tai_ubicacion_item_detalle
                SET saldo_item_ubicacion = 0,
                	sw_espacio = true
                WHERE id_ubicacion_item_detalle = v_ubicaciones.id_ubicacion_item_detalle;  
        
                
               v_res = alma.f_ai_control_espacio_ubicacion('BUSCA_UBICACIONES_SALIDA',al_id_almacen,al_id_item,(al_cantidad - v_ubicaciones.saldo_item_ubicacion ),v_ubicaciones.orden);
                	
           end if;
        
        end loop;
    
    END;
 
 end if;
 
RETURN v_res;


END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;