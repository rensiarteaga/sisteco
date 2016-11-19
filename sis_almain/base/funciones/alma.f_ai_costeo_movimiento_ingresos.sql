--------------- SQL ---------------

CREATE OR REPLACE FUNCTION alma.f_ai_costeo_movimiento_ingresos (
  al_id_costeo integer,
  al_pm_procediemiento varchar
)
RETURNS varchar AS
$body$
DECLARE
 
g_nombre_funcion              varchar;     -- NOMBRE FÍSICO DE LA FUNCIÓN
g_separador                   varchar(10); -- SEPARADOR DE CADENAS
g_descripcion_log_error       text; 
g_respuesta                   varchar;     -- VARIABLE QUE CONTIENE LA RESPUESTA DE LA FUNCIÓN
g_reg_evento                  varchar;
--variables exclusivas utilizadas para el costeo
g_datos_costeo				  record;
g_sum_costos				  numeric;
g_sum_cant_peso				  numeric;
g_registros					  record;

g_sum_precios		   		  numeric;

--variables registro en la tabla temporal
v_cociente_1	numeric;
v_producto_1 	numeric;
v_cociente_2	numeric;
v_producto_2	numeric;


    
BEGIN

g_separador = '#@@@#'; --Separador para mensajes devueltos por la función
g_nombre_funcion = 'f_ai_costeo_movimiento_ingresos';

IF al_pm_procediemiento = 'COSTEO_PESO' THEN
BEGIN
		--verificacion de existencia de al_id_costeo
        /*
        	1. obtencion y sumatoria de todos los costos que incurren segun al_id_costeo
            2. obtencion de la suma de los productos sum(cantidad item * peso item)
            3. cociente (cantidad item * peso item)/punto 2
            4. producto  (costo totales * punto 3)
            5. cociente (punto 4 / cantidad item)
            6. producto (punto 5 * cantidad item)
        */
        
        --obtencion de todos los datos relacionado con al_id_costeo
        SELECT cos.fecha_ingreso,cos.fecha_salida,cos.estado,cos.id_almacen,cos.id_movimiento_proyecto,cos.tipo_costeo INTO  g_datos_costeo
        FROM alma.tai_costeo cos
        WHERE cos.id_costeo = al_id_costeo and cos.estado='borrador';
        
        --1 . sumatoria costos incurridos en al_id_costeo
        SELECT sum(det.valor_costo) INTO g_sum_costos
        FROM alma.tai_costeo_detalle det
        WHERE det.id_costeo = al_id_costeo;
        
        --2 . sumatoria productos(cantidad item * peso item)
        SELECT sum(COALESCE((det.cantidad * it.peso),'0'))  INTO g_sum_cant_peso
        FROM alma.tai_movimiento_proyecto_det det
        INNER JOIN alma.tai_item it on it.id_item=det.id_item AND it.estado='activo'
        WHERE det.id_movimiento_proyecto = g_datos_costeo.id_movimiento_proyecto;
        
         --creacion de la tabla temporal donde se registraran todas las operaciones
       /*  EXECUTE('CREATE TEMP TABLE tt_ope_costeo(	cantidad_it numeric,
                								 	peso_it numeric,
                                                 	prod_cant_peso numeric,
                                                 	cociente_1 numeric,-- (cantidad item * peso item)/g_sum_cant_peso
                                                 	producto_1 numeric,-- (g_sum_costos * cociente_1)
                                                 	cociente_2 numeric,-- (producto_1/cantidad_item)
                                                 	producto_2 numeric -- (cociente_2 * cantidad_item)
                								) ON COMMIT DROP;');*/
        
        FOR g_registros IN (	SELECT  it.id_item,it.peso,det.id_proyecto_mov_det,det.cantidad
                            	FROM alma.tai_movimiento_proyecto_det det
                            	INNER JOIN alma.tai_item it on it.id_item = det.id_item and it.estado='activo'
                            	WHERE det.id_movimiento_proyecto = g_datos_costeo.id_movimiento_proyecto )
        LOOP
        	IF (g_registros.peso IS NULL OR g_registros.cantidad < 0 OR  g_registros.cantidad IS NULL )
            THEN
            	g_descripcion_log_error := 'Error verifique el peso y la cantidad del item '||g_registros.id_item;
                --g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);
                --REGISTRA EL LOG
               /*g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario            ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                                    pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                                    pm_codigo_procedimiento   ,pm_proc_almacenado);*/
                --DEVUELVE MENSAJE DE ERROR
                RETURN 'f'||g_separador||g_descripcion_log_error;
            END IF;
            v_cociente_1 = (g_registros.cantidad * g_registros.peso)/(g_sum_cant_peso);	
			v_producto_1 = g_sum_costos * (v_cociente_1);	
			v_cociente_2 = v_producto_1 / g_registros.cantidad;	
			v_producto_2 = v_cociente_2 * g_registros.cantidad;
            
          /*  EXECUTE('INSERT INTO tt_ope_costeo VALUES('||g_registros.cantidad||','||g_registros.peso||','||(g_registros.cantidad * g_registros.peso)||','
            										   ||v_cociente_1||','||v_producto_1||','||v_cociente_2||','||v_producto_2||');');*/
                                                       
              --actualizar el costeo unitario realizado en alma.tai_movimiento_proyecto_det en peso_unitario_costeado segun id_proyecto_mov_det
             UPDATE alma.tai_movimiento_proyecto_det 
             SET calculo_costeado = round((v_cociente_2)::numeric,4)   
             WHERE alma.tai_movimiento_proyecto_det.id_proyecto_mov_det = g_registros.id_proyecto_mov_det;
          
        END LOOP;                
END;
ELSIF al_pm_procediemiento = 'COSTEO_PRECIO' THEN
	BEGIN
			--obtencion de todos los datos relacionado con al_id_costeo
        	SELECT cos.fecha_ingreso,cos.fecha_salida,cos.estado,cos.id_almacen,cos.id_movimiento_proyecto,cos.tipo_costeo INTO  g_datos_costeo
        	FROM alma.tai_costeo cos
        	WHERE cos.id_costeo = al_id_costeo and cos.estado='borrador';
                        
            --1 . sumatoria costos incurridos en al_id_costeo
            SELECT sum(det.valor_costo) INTO g_sum_costos
            FROM alma.tai_costeo_detalle det
            WHERE det.id_costeo = al_id_costeo;
            
            --sumatoria de los precios unitarios
            SELECT  sum(COALESCE(det.costo_unitario * det.cantidad,'0')) INTO g_sum_precios
            FROM alma.tai_movimiento_proyecto_det det
            WHERE det.id_movimiento_proyecto = g_datos_costeo.id_movimiento_proyecto;
            
            FOR g_registros IN ( SELECT d.cantidad,d.costo_unitario,d.id_item,d.id_proyecto_mov_det
            					 FROM alma.tai_movimiento_proyecto_det d
                                 WHERE d.id_movimiento_proyecto= g_datos_costeo.id_movimiento_proyecto)
    		LOOP
            	
            	IF (g_registros.cantidad IS NULL) OR (g_registros.costo_unitario IS NULL)
                THEN
                	g_descripcion_log_error := 'Error verifique el costo unitario y la cantidad del item '||g_registros.id_item;
   
                	--DEVUELVE MENSAJE DE ERROR
                	RETURN 'f'||g_separador||g_descripcion_log_error;
                END IF;
            
             	v_cociente_1 = (g_registros.cantidad * g_registros.costo_unitario)/(g_sum_precios);	
				v_producto_1 = g_sum_costos * (v_cociente_1);	
				v_cociente_2 = (v_producto_1 + (g_registros.cantidad * g_registros.costo_unitario)) / g_registros.cantidad;	--calculo para constatar el costeo
				v_producto_2 = v_cociente_2 * g_registros.cantidad;
                
   
               UPDATE alma.tai_movimiento_proyecto_det 
               SET calculo_costeado =round((v_cociente_2)::numeric,4)   
               WHERE id_proyecto_mov_det = g_registros.id_proyecto_mov_det;
            END LOOP; 
          		
	END;
ELSE
	--procedimiento inexistente
    	g_descripcion_log_error := 'Procedimiento inexistente';
        g_respuesta := param.f_pm_mensaje_error(g_descripcion_log_error, g_nombre_funcion, g_nivel_error, pm_codigo_procedimiento);

        --REGISTRA EL LOG
        g_reg_evento:= sss.f_tsg_registro_evento(pm_id_usuario            ,g_id_subsistema           ,g_id_lugar         ,g_descripcion_log_error,
                                            pm_ip_origen              ,pm_mac_maquina            ,'error'            ,NULL,
                                            pm_codigo_procedimiento   ,pm_proc_almacenado);
        --DEVUELVE MENSAJE DE ERROR
        RETURN 'f'||g_separador||g_respuesta||g_separador||g_reg_evento;
END IF;

RETURN 'exito';

END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;