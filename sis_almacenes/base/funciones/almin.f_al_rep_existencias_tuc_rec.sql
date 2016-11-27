--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_al_rep_existencias_tuc_rec (
  al_id_tuc integer,
  al_id_item integer,
  al_cantidad_solicitada numeric,
  al_id_tuc_padre integer,
  al_cantidad_minima numeric,
  al_id_almacen_logico integer,
  al_id_parametro_almacen integer,
  al_codigo_tuc_padre varchar,
  al_nombre_tuc_padre varchar
)
RETURNS boolean AS
$body$
DECLARE
    v_registros				record;
    v_registros_tuc					record;
    v_registros_item				record;
    v_resp							boolean;
    v_reg_kardex					record;
    v_total_candidad_disponible		numeric;
    v_candidad_disponible			numeric;
    v_unidades_posibles				integer;
    v_candidad_asignada		    	numeric;
    
BEGIN

   IF al_id_tuc is not null THEN
       
             --recuperamos los datos del TUC
             select 
                tuc.codigo,
                tuc.descripcion,
                tuc.id_tipo_unidad_constructiva,
                tuc.codigo,
                tuc.nombre
              into
                 v_registros_tuc
             from almin.tal_tipo_unidad_constructiva tuc
             where tuc.id_tipo_unidad_constructiva = al_id_tuc;
             
             
             --listamos partes
                FOR v_registros in (
                                    SELECT 
                                          ct.id_tuc_hijo,
                                          ct.cantidad 
                                    FROM almin.tal_composicion_tuc ct
                                   WHERE ct.id_tipo_unidad_constructiva = al_id_tuc )LOOP
                    --llamada recursiva 
                   v_resp =  almin.f_al_rep_existencias_tuc_rec(v_registros.id_tuc_hijo, 
                                                                 NULL, 
                                                                 v_registros.cantidad * al_cantidad_solicitada ,
                                                                 al_id_tuc,  
                                                                 v_registros.cantidad,
                                                                 al_id_almacen_logico,
                                                                 al_id_parametro_almacen,
                                                                 v_registros_tuc.codigo,
                                                                 v_registros_tuc.nombre
                                                                 );
                END LOOP;
              --listamos los item
              
               FOR v_registros in (
                                  SELECT 
                                          ct.id_item,
                                          ct.cantidad,
                                          ct.cosiderar_repeticion 
                                    FROM almin.tal_componente ct
                                    WHERE ct.id_tipo_unidad_constructiva = al_id_tuc )LOOP
                    --llamada recursiva 
                   v_resp =  almin.f_al_rep_existencias_tuc_rec(NULL::integer, 
                                                                 v_registros.id_item , 
                                                                 v_registros.cantidad * al_cantidad_solicitada ,
                                                                 al_id_tuc, 
                                                                 v_registros.cantidad,
                                                                 al_id_almacen_logico,
                                                                 al_id_parametro_almacen,
                                                                 v_registros_tuc.codigo,
                                                                 v_registros_tuc.nombre);
                END LOOP;
                
                --caclular las unidades disponibles para el TUC
               select 
                   min(unidades_posibles)
                  into
                   v_candidad_asignada
               from existencias_tuc  
               where id_tuc_padre = al_id_tuc;
                
                          
              v_unidades_posibles = trunc(COALESCE(v_candidad_asignada,0)/al_cantidad_minima); --  con esta pieza cuantas unidades posible del TUC padre se peude crear
             
             
               
              -- insertamos TUC
             
             INSERT INTO  existencias_tuc (
                                          id_tuc	   		,
                                          id_tuc_padre 	,
                                          codigo_tuc   	,
                                          nombre_tuc   		,                                    
                                          cantidad_solicitada ,
                                          candidad_disponible ,
                                          unidades_posibles,
                                          codigo_tuc_padre,
                                          nombre_tuc_padre ,
                                          cantidad_minima                                  
                                       ) 
                                       values
                                       (
                                          v_registros_tuc.id_tipo_unidad_constructiva	   		,
                                          al_id_tuc_padre 	,
                                          v_registros_tuc.codigo ,
                                          v_registros_tuc.nombre	,                                    
                                          al_cantidad_solicitada ,
                                          COALESCE(v_candidad_asignada,0) ,
                                          v_unidades_posibles,
                                          al_codigo_tuc_padre,
                                          al_nombre_tuc_padre,
                                          al_cantidad_minima
                                       );
                 
        
   ELSE
      --recuperamos lso datos del item
      select 
          i.nombre,
          i.codigo,
          i.id_item
        into 
          v_registros_item
      from almin.tal_item i
      where i.id_item = al_id_item;
      
      -- verificamos existencias 
         
          SELECT 
             cantidad
          into
             v_reg_kardex
          FROM almin.tal_kardex_logico k 
          WHERE id_item = v_registros_item.id_item
          AND estado_item = 'Nuevo'
          AND id_almacen_logico = al_id_almacen_logico
          AND id_parametro_almacen = al_id_parametro_almacen;
          
          --sumamos piezas ya asignadas
          
          select
            sum(candidad_disponible)
           into
             v_total_candidad_disponible
          from existencias_tuc 
          where  id_item = v_registros_item.id_item;         
          
          --calculamos unidades_posibles
          v_candidad_disponible = COALESCE(v_reg_kardex.cantidad,0) - COALESCE(v_total_candidad_disponible,0);
          
         
          
          IF  al_cantidad_solicitada <= COALESCE(v_candidad_disponible,0) THEN
           	v_candidad_asignada = al_cantidad_solicitada;
          ELSE
          	 v_candidad_asignada = COALESCE(v_candidad_disponible,0);
          END IF;
          
           v_unidades_posibles = trunc(v_candidad_asignada/al_cantidad_minima);
          
      
      
      --insertamos item 
      
      INSERT INTO  existencias_tuc (
         							id_item	   		,
                                    id_tuc_padre 	,
                                    codigo_item   	,
                                    nombre_item   		,                                    
                                    cantidad_solicitada ,
                                    candidad_disponible ,
                                    cantidad_minima,
                                    unidades_posibles,
                                    codigo_tuc_padre,
                                    nombre_tuc_padre
                                    
                                 ) 
                                 values
                                 (
                                    v_registros_item.id_item	   		,
                                    al_id_tuc_padre 	,
                                    v_registros_item.codigo,
                                    v_registros_item.nombre	,                                    
                                    al_cantidad_solicitada ,
                                    v_candidad_asignada,
                                    al_cantidad_minima,
                                    v_unidades_posibles,
                                    al_codigo_tuc_padre,
                                    al_nombre_tuc_padre
                                 );
              
   END IF;
  
  RETURN TRUE;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;