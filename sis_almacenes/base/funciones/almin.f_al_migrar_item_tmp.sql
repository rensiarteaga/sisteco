--------------- SQL ---------------

CREATE OR REPLACE FUNCTION almin.f_al_migrar_item_tmp (
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
BEGIN

     v_codigo_ant = '';
     -- leer tabla tamporal
     for v_registros in (
     						select 
                                id_item_tmp,
                                nro,
                                nombre,
                                descripcion,
                                calidad,
                                unidad,
                                peso_unitario,
                                desc_aux,
                                mat_resp,
                                precio_venta,
                                costo_estimado,
                                stock_minimo,
                                codigo_id3,
                                sw_migrado
                            from almin.tal_item_tmp i
                            where i.sw_migrado = 'no' 
                            order by codigo_id3, nro
      						)LOOP
     
          
           IF v_codigo_ant !=  v_registros.codigo_id3   THEN
                      ------------------------------
                      --  determinarcodigo superior
                      ------------------------------
                 
                       -- explotar codigo
                       v_array_codigo =   string_to_array(v_registros.codigo_id3,'.');
                       
                       raise notice '...codigo...  % ',v_array_codigo;
                     
                       -- recuperar id de clasificaciones  de supergrupo
                        select   
                          sg.id_supergrupo
                        into
                          v_id_super
                        from  almin.tal_supergrupo sg 
                        where sg.codigo = v_array_codigo[1];
                        
                        IF   v_id_super is null THEN
                         raise exception 'No se encontro el super grupo  para el codigo %',v_array_codigo[1];                
                        END IF;
                        
                        --recupera el id de clasificacion del grupo
                        select   
                          g.id_grupo
                        into
                          v_id_grupo
                        from  almin.tal_grupo g 
                        where g.codigo = v_array_codigo[1]||'.'||v_array_codigo[2] 
                              and g.id_supergrupo = v_id_super;
                              
                        IF   v_id_grupo is null THEN
                         raise exception 'No se encontro el  grupo  para el codigo %',v_array_codigo[1]||'.'||v_array_codigo[2];                
                        END IF;       
                        
                        --recupera el id declasificacion del subgrupo  
                        
                         select   
                          sg.id_subgrupo
                        into
                          v_id_sub
                        from  almin.tal_subgrupo sg 
                        where sg.codigo = v_array_codigo[1]||'.'||v_array_codigo[2]||'.'||v_array_codigo[3]
                              and sg.id_supergrupo = v_id_super  
                                and sg.id_grupo = v_id_grupo;
                                
                        IF   v_id_sub is null THEN
                         raise exception 'No se encontro el sub  grupo  para el codigo %', v_array_codigo[1]||'.'||v_array_codigo[2]||'.'||v_array_codigo[3];                
                        END IF;  
                              
                        
                        --recupera el id declasificacion del ID1  
                        
                         select   
                          sg.id_id1
                        into
                          v_id_1
                        from  almin.tal_id1 sg 
                        where sg.codigo = v_array_codigo[1]||'.'||v_array_codigo[2]||'.'||v_array_codigo[3]||'.'||v_array_codigo[4]
                              and sg.id_supergrupo = v_id_super  
                              and sg.id_grupo = v_id_grupo
                              and sg.id_subgrupo = v_id_sub; 
                              
                        IF   v_id_1 is null THEN
                         raise exception 'No se encontro el   ID1  para el codigo %', v_array_codigo[1]||'.'||v_array_codigo[2]||'.'||v_array_codigo[3]||'.'||v_array_codigo[4];                
                        END IF;        
                              
                        --recupera el id declasificacion del ID2            
                        select   
                          sg.id_id2
                        into
                          v_id_2
                        from  almin.tal_id2 sg 
                        where sg.codigo = v_array_codigo[1]||'.'||v_array_codigo[2]||'.'||v_array_codigo[3]||'.'||v_array_codigo[4]||'.'||v_array_codigo[5]
                              and sg.id_supergrupo = v_id_super  
                              and sg.id_grupo = v_id_grupo
                              and sg.id_subgrupo = v_id_sub
                              and sg.id_id1 = v_id_1; 
                        
                        
                        IF   v_id_2 is null THEN
                         raise exception 'No se encontro el   ID2  para el codigo %', v_array_codigo[1]||'.'||v_array_codigo[2]||'.'||v_array_codigo[3]||'.'||v_array_codigo[4]||'.'||v_array_codigo[5];                
                        END IF;     
                                      
                         --recupera el id declasificacion del ID3           
                        select   
                          sg.id_id3
                        into
                          v_id_3
                        from  almin.tal_id3 sg 
                        where sg.codigo = v_array_codigo[1]||'.'||v_array_codigo[2]||'.'||v_array_codigo[3]||'.'||v_array_codigo[4]||'.'||v_array_codigo[5]||'.'||v_array_codigo[6]
                              and sg.id_supergrupo = v_id_super  
                              and sg.id_grupo = v_id_grupo
                              and sg.id_subgrupo = v_id_sub
                              and sg.id_id1 = v_id_1
                              and sg.id_id2 = v_id_2; 
                              
                      IF   v_id_3 is null THEN
                         raise exception 'No se encontro el id3 para el codigo %',v_array_codigo[1]||'.'||v_array_codigo[2]||'.'||v_array_codigo[3]||'.'||v_array_codigo[4]||'.'||v_array_codigo[5]||'.'||v_array_codigo[6];                
                      END IF;
                              
                              
                  --almacena nuevo codigo previo
                  IF v_codigo_ant  = '' THEN
                      v_codigo_ant = v_registros.codigo_id3;
                  END IF;             
            
           END IF;
           
            
           ---------------------------------------
           -- recuperar id de unidad de medida 
           ---------------------------------------
           
           select 
               um.id_unidad_medida_base
             into
               v_id_unidad_medida
           from param.tpm_unidad_medida_base um
           where  lower(um.abreviatura) =  lower(v_registros.unidad);
           
           raise notice 'unida de medida id: %',v_id_unidad_medida;
         
           ------------------------------
           --  determinar correlativo
           -------------------------------
         
             --contar la catidad de items para el id 3
             v_contador_aux = NULL;
             
             
             
             select 
               count(it.id_item)
             into
               v_contador_aux
             from almin.tal_item it
             where     it.id_id3 = v_id_3  and  upper(codigo) !=  upper( v_registros.codigo_id3::varchar||'.00'::varchar)::varchar;
                  
             
             raise notice 'contador %',v_contador_aux;    
                  
              
             --determinar nuevo codigo
             if v_contador_aux is null then
               v_codigo_item = v_registros.codigo_id3||'00';
             elseif (v_contador_aux +1 ) < 10 then
               v_codigo_item = v_registros.codigo_id3||'0'||(v_contador_aux + 1)::varchar; 
             else
               v_codigo_item = v_registros.codigo_id3||(v_contador_aux + 1)::varchar; 
             end if;
         
             ----------------------------------------------------
             -- revisar que el nuevo codigo no este dupicado
             -------------------------------------------------
              
             IF exists(select 1 from almin.tal_item i where i.codigo = v_codigo_item) THEN
                raise exception 'Elcodigo % se encuentra duplicado', v_codigo_item;
             END IF; 
     
             -------------------- 
             -- insertar item
             -------------------
             
             INSERT INTO almin.tal_item(
                codigo                      ,
                descripcion         ,
                precio_venta_almacen      ,
                costo_estimado,
                stock_min                   ,
                observaciones,
                nivel_convertido            ,
                estado_registro     ,
                fecha_reg,
                id_unidad_medida_base       ,
                id_id3              ,
                id_id2,
                id_id1                      ,
                id_subgrupo         ,
                id_grupo,
                id_supergrupo               ,
                nombre              ,
                peso_kg,
                mat_bajo_responsabilidad    ,
                calidad             ,
                descripcion_aux,
                id_usuario
            ) VALUES (
                upper(v_codigo_item) ,       
                v_registros.descripcion      ,
                v_registros.precio_venta  ,
                v_registros.costo_estimado,
                v_registros.stock_minimo                ,
                v_registros.desc_aux,
                '4'                         ,
                'activo',
                now(),
                v_id_unidad_medida    ,
                v_id_3           ,
                v_id_2,
                v_id_1                   ,
                v_id_sub      ,
                v_id_grupo,
                v_id_super            ,
                v_registros.nombre           ,
                v_registros.peso_unitario,
                v_registros.mat_resp ,
                v_registros.calidad          ,
                v_registros.desc_aux,
                1
            );
            
           update almin.tal_item_tmp  set
              sw_migrado = 'si'
           where id_item_tmp = v_registros.id_item_tmp;
         
         
          
     END LOOP;

    RETURN TRUE;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;