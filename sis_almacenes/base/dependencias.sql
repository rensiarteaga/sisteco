

/***********************************I-DEP-RAC-ALMIN-1-14/12/2016****************************************/
--------------- SQL ---------------

 -- object recreation
DROP VIEW almin.val_kardex_logico;

CREATE VIEW almin.val_kardex_logico
AS
 SELECT DISTINCT ite.id_item,
         ite.codigo,
         ite.descripcion,
         ite.precio_venta_almacen,
         ite.costo_estimado,
         ite.stock_min,
         ite.observaciones,
         ite.nivel_convertido,
         ite.estado_registro,
         ite.fecha_reg,
         ite.id_unidad_medida_base,
         ite.id_id3,
         ite.id_id2,
         ite.id_id1,
         ite.id_subgrupo,
         ite.id_grupo,
         ite.id_supergrupo,
         ite.nombre,
         id3.nombre AS nombre_id3,
         id2.nombre AS nombre_id2,
         id1.nombre AS nombre_id1,
         sub.nombre AS nombre_subg,
         g.nombre AS nombre_grupo,
         supgru.nombre AS nombre_supg,
         umb.nombre AS nombre_unid_base,
         sum(karlog.cantidad) AS total,
         sum(karlog.cantidad) - sum(karlog.reservado) AS total_exacto,
         COALESCE((
                    SELECT kl.cantidad - kl.reservado AS cantidad
                    FROM almin.tal_kardex_logico kl
                         JOIN almin.tal_parametro_almacen_logico pa ON pa.id_parametro_almacen = kl.id_parametro_almacen AND  pa.estado::text = 'abierto'::text AND pa.id_almacen_logico = kl.id_almacen_logico
                    WHERE kl.id_item = ite.id_item AND kl.estado_item::text = 'Nuevo'::text AND karlog.id_almacen_logico = kl.id_almacen_logico
         ), 0::numeric) AS nuevo,
         COALESCE((
                    SELECT klg.cantidad - klg.reservado AS cantidad
                    FROM almin.tal_kardex_logico klg
                         JOIN almin.tal_parametro_almacen_logico pal ON pal.id_parametro_almacen = klg.id_parametro_almacen AND pal.estado::text = 'abierto'::text  AND pal.id_almacen_logico = klg.id_almacen_logico
                    WHERE klg.id_item = ite.id_item AND  klg.estado_item::text = 'Usado'::text AND karlog.id_almacen_logico = klg.id_almacen_logico
         ), 0::numeric) AS usado,
         karlog.id_almacen_logico,
         paralm.id_parametro_almacen
  FROM almin.tal_item ite
       JOIN almin.tal_id3 id3 ON id3.id_id3 = ite.id_id3
       JOIN almin.tal_id2 id2 ON id2.id_id2 = ite.id_id2
       JOIN almin.tal_id1 id1 ON id1.id_id1 = ite.id_id1
       JOIN almin.tal_subgrupo sub ON sub.id_subgrupo = ite.id_subgrupo
       JOIN almin.tal_grupo g ON g.id_grupo = ite.id_grupo
       JOIN almin.tal_supergrupo supgru ON supgru.id_supergrupo =
         ite.id_supergrupo
       LEFT JOIN param.tpm_unidad_medida_base umb ON umb.id_unidad_medida_base =
         ite.id_unidad_medida_base
       JOIN almin.tal_kardex_logico karlog ON karlog.id_item = ite.id_item
       JOIN almin.tal_parametro_almacen_logico paralm ON paralm.id_parametro_almacen = karlog.id_parametro_almacen 
            AND paralm.id_almacen_logico = karlog.id_almacen_logico
            AND paralm.estado::text = 'abierto'::text
  GROUP BY ite.id_item,
           ite.codigo,
           ite.descripcion,
           ite.precio_venta_almacen,
           ite.costo_estimado,
           ite.stock_min,
           ite.observaciones,
           ite.nivel_convertido,
           ite.fecha_reg,
           ite.id_unidad_medida_base,
           ite.id_id3,
           ite.id_id2,
           ite.id_id1,
           ite.id_subgrupo,
           ite.id_grupo,
           ite.id_supergrupo,
           ite.nombre,
           id3.nombre,
           id2.nombre,
           id1.nombre,
           sub.nombre,
           g.nombre,
           supgru.nombre,
           umb.nombre,
           ite.estado_registro,
           karlog.id_almacen_logico,
           paralm.id_parametro_almacen
  ORDER BY ite.id_item,
           ite.codigo;

ALTER TABLE almin.val_kardex_logico
  OWNER TO postgres;
  
  
/***********************************F-DEP-RAC-ALMIN-1-14/12/2016****************************************/

