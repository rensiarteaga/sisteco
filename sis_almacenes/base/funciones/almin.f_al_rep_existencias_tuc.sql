--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_al_rep_existencias_tuc (
  pm_id_usuario integer,
  pm_ip_origen varchar,
  pm_mac_maquina text,
  pm_codigo_procedimiento varchar,
  pm_proc_almacenado varchar,
  pm_cant integer,
  pm_puntero integer,
  pm_sortcol varchar,
  pm_sortdir varchar,
  pm_criterio_filtro varchar,
  al_id_salida integer
)
RETURNS SETOF record AS
$body$
DECLARE
    v_registros_salida				record;
    v_regitros_tuc					record;
    v_resp							boolean;
    v_registros						record;
BEGIN

    --crear tabla temporal 
    
      CREATE TEMPORARY TABLE existencias_tuc (
         							id 				SERIAL,
                                    id_salida 		integer,
                                    id_item   		integer,
                                    id_tuc	   		integer,
                                    id_tuc_padre 	integer,
                                    nombre_item 	varchar,
                                    codigo_item  	varchar,
                                    codigo_tuc   	varchar,
                                    nombre_tuc   		varchar,                                    
                                    codigo_tuc_padre   	varchar,
                                    nombre_tuc_padre   	varchar,
                                    cantidad_solicitada numeric,
                                    candidad_disponible numeric,
                                    cantidad_minima		numeric,
                                    unidades_posibles		numeric
                             
                                    
                                 ) ON COMMIT DROP;

    --listar datos de la salida 
    select
       s.id_salida,
       s.id_almacen_logico,
       s.id_parametro_almacen_logico,
       s.id_parametro_almacen,
       s.descripcion
     into
       v_registros_salida
    from almin.tal_salida s
    where s.id_salida = al_id_salida;
    
    --listar TUC de la salida
    
    FOR v_regitros_tuc in ( SELECT
                             OSUCDE.id_orden_salida_uc_detalle,                          
                             OSUCDE.id_tipo_unidad_constructiva,
                             OSUCDE.cantidad,
                             OSUCDE.repeticion,
                             OSUCDE.id_item
                           FROM almin.tal_orden_salida_uc_detalle OSUCDE 
                           WHERE OSUCDE.id_salida = al_id_salida) LOOP
       
       --generar recusivamente los item del tuc  (multiplicado por la cantidad solicitada)       
       v_resp =  almin.f_al_rep_existencias_tuc_rec(
       												v_regitros_tuc.id_tipo_unidad_constructiva, 
                                                    v_regitros_tuc.id_item, 
                                                    v_regitros_tuc.cantidad,
                                                    NULL::integer  ,                                              
                                                    1, -- cantidad minima    
                                                    v_registros_salida.id_almacen_logico,
                                                    v_registros_salida.id_parametro_almacen,
                                                    ''::varchar,
                                                    ''::varchar);
                                                    
                                                    
       
       
       END LOOP;  
       
       FOR v_registros in( select  id 				,
                                    id_salida 		,
                                    id_item   		,
                                    id_tuc	   		,
                                    id_tuc_padre 	,
                                    nombre_item 	,
                                    codigo_item  	,
                                    codigo_tuc   	,
                                    nombre_tuc   		,                                    
                                    codigo_tuc_padre   	,
                                    nombre_tuc_padre   	,
                                    cantidad_solicitada ,
                                    candidad_disponible ,
                                    cantidad_minima		,
                                    unidades_posibles
                               from existencias_tuc
                               order by id desc) LOOP
                RETURN NEXT v_registros;
       END LOOP;
    
      --listar tabla temporal
      
  
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;