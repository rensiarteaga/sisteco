--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_al_migrar_componente_tmp (
)
RETURNS boolean AS
$body$
DECLARE
  v_registros 		record;
  v_array_codigo	varchar[];
  v_id_super		integer;
  v_id_grupo			integer;
  v_id_sub			integer;
  v_id_1				integer;
  v_id_2				integer;
  v_id_3				integer;
  v_codigo_ant		varchar;
  v_id_unidad_medida	integer;
  v_contador_aux		integer;
  v_codigo_item			varchar;
  v_cont_duplicados		integer;
BEGIN

     v_codigo_ant = '';
     
     v_cont_duplicados = 0;
    
     -- leer tabla tamporal
     for v_registros in (
     						select 
                                c.cantidad,
                                tuc.id_tipo_unidad_constructiva,
                                i.id_item,
                                c.nombre,
                                c.codigo_uc,
                                i.nombre
                            from almin.tal_componente_tmp c
                            inner join almin.tal_item i on i.nombre = c.nombre
                            inner join almin.tal_tipo_unidad_constructiva tuc on tuc.codigo = c.codigo_uc
                            where c.migrado = 'no'
     						
      						)LOOP
                            
                            
                            IF   exists(select 1 from almin.tal_componente 
                                 where  id_item = v_registros.id_item
                                 and id_tipo_unidad_constructiva  = v_registros.id_tipo_unidad_constructiva)   THEN
                            
                                  v_cont_duplicados = v_cont_duplicados +1;
                                 raise notice 'insercion duplicada %,   item % tuc %', v_cont_duplicados,   v_registros.nombre  ,   v_registros.codigo_uc ;
                            
                            ELSE
                            
                                 
                                         INSERT INTO 
                                            almin.tal_componente
                                          (
                                           
                                            cantidad,
                                            estado_registro,
                                            cosiderar_repeticion,
                                            fecha_reg,
                                            descripcion,
                                            id_item,
                                            id_tipo_unidad_constructiva
                                          )
                                          VALUES (
                                           
                                            v_registros.cantidad,
                                            'activo',
                                            'no',
                                            now(),
                                            '',
                                            v_registros.id_item,
                                            v_registros.id_tipo_unidad_constructiva
                                          );
                                          
                                 update almin.tal_componente_tmp  set
                                    migrado = 'si'
                                 where       nombre = v_registros.nombre 
                                        and codigo_uc = v_registros.codigo_uc;
                            
                            END IF;
                            
                            
                            
                             
         
         
          
     END LOOP;
     
     IF v_cont_duplicados > 0 THEN
       raise exception 'se encontraros registros duplicados : %',v_cont_duplicados;
     END IF;

    RETURN TRUE;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;