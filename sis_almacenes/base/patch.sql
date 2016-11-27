
/***********************************I-SCP-RAC-PARAM-1-21/11/2016****************************************/
--------------- SQL ---------------

ALTER TABLE sss.tsg_tarea_pendiente
  ADD COLUMN id_usuario INTEGER;
  
  --------------- SQL ---------------

ALTER TABLE sss.tsg_tarea_pendiente
  ADD COLUMN codigo_procedimiento VARCHAR;
  
  --------------- SQL ---------------

ALTER TABLE sss.tsg_tarea_pendiente
  ALTER COLUMN id_usuario_asignado DROP NOT NULL;
  
  --------------- SQL ---------------

ALTER TABLE sss.tsg_tarea_pendiente
  ALTER COLUMN id_registro DROP NOT NULL;
  
  --------------- SQL ---------------

ALTER TABLE sss.tsg_tarea_pendiente
  ALTER COLUMN nombre_tabla DROP NOT NULL;
  
  --------------- SQL ---------------

ALTER TABLE almin.tal_salida_detalle
  ALTER COLUMN cant_consolidada SET DEFAULT 0;

ALTER TABLE almin.tal_salida_detalle
  ALTER COLUMN cant_consolidada SET NOT NULL;
  
  
  --------------- SQL ---------------

ALTER TABLE almin.tal_salida
  ADD COLUMN fecha_finalizado_exacta TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT now() NOT NULL;
  
 --------------- SQL ---------------

ALTER TABLE almin.tal_ingreso
  ADD COLUMN fecha_finalizado_exacta TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT now() NOT NULL;
  
  
/***********************************F-SCP-RAC-PARAM-1-21/11/2016****************************************/ 


/***********************************I-SCP-RAC-ALMIN-1-03/12/2016****************************************/ 

--------------- SQL ---------------

CREATE TABLE almin.tal_parametro_almacen_logico (
  id_parametro_almacen_logico SERIAL NOT NULL,
  id_parametro_almacen INTEGER NOT NULL,
  id_almacen_logico INTEGER NOT NULL,
  estado VARCHAR(20) DEFAULT 'cerrado' NOT NULL,
  PRIMARY KEY(id_parametro_almacen_logico)
) WITHOUT OIDS;

COMMENT ON COLUMN almin.tal_parametro_almacen_logico.estado
IS 'cerrado o abierto, solo puede haber un registro abierto simultanemanete';



--------------- SQL ---------------

ALTER TABLE almin.tal_parametro_almacen_logico
  ADD CONSTRAINT tal_parametro_almacen_logico_fk FOREIGN KEY (id_parametro_almacen)
    REFERENCES almin.tal_parametro_almacen(id_parametro_almacen)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    

--------------- SQL ---------------

ALTER TABLE almin.tal_parametro_almacen_logico
  ADD CONSTRAINT tal_parametro_almacen_logico_fk1 FOREIGN KEY (id_almacen_logico)
    REFERENCES almin.tal_almacen_logico(id_almacen_logico)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
    --------------- SQL ---------------

ALTER TABLE almin.tal_ingreso
  ADD COLUMN id_parametro_almacen_logico INTEGER NOT NULL;

COMMENT ON COLUMN almin.tal_ingreso.id_parametro_almacen_logico
IS 'para difentifica los cierres y apertura de manera independiente';

--------------- SQL ---------------

ALTER TABLE almin.tal_ingreso
  ADD CONSTRAINT tal_ingreso_fk FOREIGN KEY (id_parametro_almacen_logico)
    REFERENCES almin.tal_parametro_almacen_logico(id_parametro_almacen_logico)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
    
  --------------- SQL ---------------

ALTER TABLE almin.tal_salida
  ADD COLUMN id_parametro_almacen_logico INTEGER NOT NULL;
  
--------------- SQL ---------------

ALTER TABLE almin.tal_salida
  ADD CONSTRAINT tal_salida_fk FOREIGN KEY (id_parametro_almacen_logico)
    REFERENCES almin.tal_parametro_almacen_logico(id_parametro_almacen_logico)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;


/***********************************F-SCP-RAC-ALMIN-1-03/12/2016****************************************/ 


/***********************************I-SCP-RAC-ALMIN-1-13/12/2016****************************************/ 


CREATE TABLE almin.tal_item_tmp (
  id_item_tmp SERIAL,
  nro INTEGER,
  nombre VARCHAR,
  descripcion VARCHAR,
  calidad VARCHAR,
  unidad VARCHAR,
  peso_unitario NUMERIC,
  desc_aux VARCHAR,
  mat_resp VARCHAR,
  precio_venta NUMERIC,
  costo_estimado NUMERIC,
  stock_minimo NUMERIC,
  codigo_id3 VARCHAR NOT NULL,
  sw_migrado VARCHAR(6) DEFAULT 'no'::character varying NOT NULL,
  CONSTRAINT table_pkey PRIMARY KEY(id_item_tmp)
) WITHOUT OIDS;


/***********************************F-SCP-RAC-ALMIN-1-13/12/2016****************************************/ 




/***********************************I-SCP-RAC-ALMIN-1-14/12/2016****************************************/ 

--------------- SQL ---------------

ALTER TABLE almin.tal_almacen_logico
  ADD COLUMN costeo_obligatorio VARCHAR(10) DEFAULT 'si' NOT NULL;


/***********************************F-SCP-RAC-ALMIN-1-14/12/2016****************************************/ 



/***********************************I-SCP-RAC-ALMIN-1-15/12/2016****************************************/ 

--------------- SQL ---------------

ALTER TABLE almin.tal_parametro_almacen_logico
  ADD COLUMN costeo_pendiente VARCHAR(20) DEFAULT 'no' NOT NULL;

COMMENT ON COLUMN almin.tal_parametro_almacen_logico.costeo_pendiente
IS 'si o no, si la gestion tiene costeo pendiente no permitira realizar el cierre';

--------------- SQL ---------------

ALTER TABLE almin.tal_ingreso
  ADD COLUMN tipo_costeo VARCHAR(30) DEFAULT 'peso' NOT NULL;

COMMENT ON COLUMN almin.tal_ingreso.tipo_costeo
IS 'peso o precio, el mas comun es peso, solo cuando el motivo de ingreso es importacion';


/***********************************F-SCP-RAC-ALMIN-1-15/12/2016****************************************/ 



/***********************************I-SCP-RAC-ALMIN-1-20/12/2016****************************************/ 



CREATE TABLE almin.tal_kardex_logico_aux (
  id_kardex_logico SERIAL,
  estado_item VARCHAR(10) DEFAULT 'Nuevo'::character varying NOT NULL,
  stock_minimo INTEGER NOT NULL,
  cantidad NUMERIC(18,2) NOT NULL,
  costo_unitario NUMERIC NOT NULL,
  costo_total NUMERIC NOT NULL,
  fecha_reg DATE DEFAULT now() NOT NULL,
  id_item INTEGER NOT NULL,
  id_almacen_logico INTEGER NOT NULL,
  reservado NUMERIC DEFAULT 0,
  id_parametro_almacen INTEGER NOT NULL,
  CONSTRAINT tal_kardex_logico_aux_pkey PRIMARY KEY(id_kardex_logico),
  CONSTRAINT tal_kardex_logico_aux_estado_item_check CHECK (((estado_item)::text = 'Nuevo'::text) OR ((estado_item)::text = 'Usado'::text)),
  CONSTRAINT fk_tal_kardex_logico__id_almacen_logico FOREIGN KEY (id_almacen_logico)
    REFERENCES almin.tal_almacen_logico(id_almacen_logico)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE,
  CONSTRAINT fk_tal_kardex_logico__id_item FOREIGN KEY (id_item)
    REFERENCES almin.tal_item(id_item)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE,
  CONSTRAINT fk_tal_kardex_logico__id_parametro_almacen FOREIGN KEY (id_parametro_almacen)
    REFERENCES almin.tal_parametro_almacen(id_parametro_almacen)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE
) WITHOUT OIDS;

COMMENT ON TABLE almin.tal_kardex_logico_aux
IS 'sistema=Almacenes&codigo=KARLOG&prefijo=AL&titulo=Kardex lógico';

COMMENT ON COLUMN almin.tal_kardex_logico_aux.fecha_reg
IS 'label=Fecha registro&disable=no&desc=Dominio para definir la fecha de registro de un dato';

COMMENT ON COLUMN almin.tal_kardex_logico_aux.reservado
IS 'label=Reservado';

CREATE INDEX tal_kardex_logico_aux_fk_tal_kardex_logico__id_item ON almin.tal_kardex_logico_aux
  USING btree (id_item);
  
  
 /***********************************F-SCP-RAC-ALMIN-1-20/12/2016****************************************/ 
 
 
 
/***********************************I-SCP-RAC-ALMIN-1-29/12/2016****************************************/ 
 
 
 --------------- SQL ---------------

ALTER TABLE almin.tal_pedido_tuc_int
  ADD COLUMN sw_autorizado VARCHAR(10) DEFAULT 'no' NOT NULL;

COMMENT ON COLUMN almin.tal_pedido_tuc_int.sw_autorizado
IS 'cuanto las existencias no alcazan para realizar la entrega este sw permite entregar lo que hay';

--------------- SQL ---------------

ALTER TABLE almin.tal_pedido_tuc_int
  ADD COLUMN sw_entregado VARCHAR(10) DEFAULT 'no' NOT NULL;

COMMENT ON COLUMN almin.tal_pedido_tuc_int.sw_entregado
IS 'cuando el material a sido entegado sin existencias, este sw marca en si cuando se entreg el faltante en otra salida';


--------------- SQL ---------------

ALTER TABLE almin.tal_pedido_tuc_int
  ADD COLUMN id_salida_complementaria INTEGER;

COMMENT ON COLUMN almin.tal_pedido_tuc_int.id_salida_complementaria
IS 'identifica con que salida se entrego el faltante';



/***********************************F-SCP-RAC-ALMIN-1-29/12/2016****************************************/ 
 


  
 
/***********************************I-SCP-RAC-ALMIN-2-29/12/2016****************************************/ 
 
  
  --------------- SQL ---------------

ALTER TABLE almin.tal_salida
  ADD COLUMN sw_faltante_tuc VARCHAR(5) DEFAULT 'no' NOT NULL;

COMMENT ON COLUMN almin.tal_salida.sw_faltante_tuc
IS 'si la salida se realiza con faltantes autorizados esta sw cambia al valor si';

 
/***********************************F-SCP-RAC-ALMIN-2-29/12/2016****************************************/ 
 

/***********************************I-SCP-RAC-ALMIN-2-03/01/2017****************************************/ 

  CREATE TABLE almin.tal_componente_tmp (
  nombre VARCHAR,
  cantidad INTEGER DEFAULT 0 NOT NULL,
  codigo_uc VARCHAR,
  migrado VARCHAR(20) DEFAULT 'no' NOT NULL
) WITHOUT OIDS;

ALTER TABLE almin.tal_componente_tmp
  ALTER COLUMN nombre SET STATISTICS 0;

ALTER TABLE almin.tal_componente_tmp
  ALTER COLUMN migrado SET STATISTICS 0;

  
 /***********************************F-SCP-RAC-ALMIN-2-03/01/2017****************************************/ 
 
 
 /***********************************I-SCP-RAC-ALMIN-2-06/01/2017****************************************/ 
 
 
 --------------- SQL ---------------

ALTER TABLE almin.tal_transferencia
  ADD COLUMN tipo_transferencia VARCHAR(50) DEFAULT 'definitiva' NOT NULL;

COMMENT ON COLUMN almin.tal_transferencia.tipo_transferencia
IS 'definitiva, prestamos, devolucion,  identifica las caractersticas del prestamo';


--------------- SQL ---------------

ALTER TABLE almin.tal_transferencia
  ADD COLUMN id_transferencia_dev INTEGER;

COMMENT ON COLUMN almin.tal_transferencia.id_transferencia_dev
IS 'identifica la transferencia para la devolucion';


--------------- SQL ---------------

ALTER TABLE almin.tal_transferencia
  ADD COLUMN importe_abierto VARCHAR(5) DEFAULT 'no' NOT NULL;

COMMENT ON COLUMN almin.tal_transferencia.importe_abierto
IS 'si o no, solo para prestamos es factible dejar el importe abierto (si). signifca que los costos de ingreso no se copian de la salida y tiene que ser introducidos manualmente cuadno tenga el dato oficial  (tiene cierta utilidad para no distorcionar los valores del almacen)';


/***********************************F-SCP-RAC-ALMIN-2-06/01/2017****************************************/ 



/***********************************I-SCP-RAC-ALMIN-2-11/01/2017****************************************/ 

--------------- SQL ---------------

ALTER TABLE almin.tal_salida
  ADD COLUMN tipo_reg VARCHAR(30) DEFAULT 'movimiento' NOT NULL;

COMMENT ON COLUMN almin.tal_salida.tipo_reg
IS 'movimiento, o reporte, el tipo reporte aprovecha al estructura para generar los reportes de estructuras';


--------------- SQL ---------------

ALTER TABLE almin.tal_salida
  ALTER COLUMN id_firma_autorizada DROP NOT NULL;
  
  
 --------------- SQL ---------------

ALTER TABLE almin.tal_salida
  ALTER COLUMN id_motivo_salida_cuenta DROP NOT NULL;
  
  --------------- SQL ---------------

ALTER TABLE almin.tal_salida
  ALTER COLUMN id_tipo_material DROP NOT NULL;


/***********************************F-SCP-RAC-ALMIN-2-11/01/2017****************************************/ 



/***********************************I-SCP-RAC-ALMIN-2-16/01/2017****************************************/ 

--------------- SQL ---------------

ALTER TABLE almin.tal_ingreso
  ADD COLUMN nro_pedido_compra VARCHAR;

COMMENT ON COLUMN almin.tal_ingreso.nro_pedido_compra
IS 'nro de pedido de compra del material';


/***********************************F-SCP-RAC-ALMIN-2-16/01/2017****************************************/ 




/***********************************I-SCP-RAC-ALMIN-2-24/01/2017****************************************/ 

ALTER TABLE almin.tal_unidad_constructiva
  ADD COLUMN id_prog_proy_acti INTEGER;
  
  --------------- SQL ---------------

ALTER TABLE almin.tal_unidad_constructiva
  ADD CONSTRAINT tal_unidad_constructiva__id_prog_proy_acti_fk FOREIGN KEY (id_prog_proy_acti)
    REFERENCES param.tpm_programa_proyecto_actividad(id_prog_proy_acti)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
    --------------- SQL ---------------

ALTER TABLE almin.tal_tramo
  ADD COLUMN id_prog_proy_acti INTEGER;

COMMENT ON COLUMN almin.tal_tramo.id_prog_proy_acti
IS 'identifica a que poryecto pertene el tramo';




--------------- SQL ---------------

ALTER TABLE almin.tal_tramo
  ADD CONSTRAINT tal_tramo_id_prog_proy_acti_fk FOREIGN KEY (id_prog_proy_acti)
    REFERENCES param.tpm_programa_proyecto_actividad(id_prog_proy_acti)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
  
  
/***********************************F-SCP-RAC-ALMIN-2-24/01/2017****************************************/ 



/***********************************I-SCP-RAC-ALMIN-2-25/01/2017****************************************/ 



--------------- SQL ---------------

 -- object recreation
DROP VIEW almin.val_item;

CREATE VIEW almin.val_item
AS
  SELECT ite.id_item,
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
         id3.descripcion AS descripcion_id3,
         id2.descripcion AS descripcion_id2,
         id1.descripcion AS descripcion_id1,
         sub.descripcion AS descripcion_subg,
         g.descripcion AS descripcion_grupo,
         supgru.descripcion AS descripcion_supg,
         ite.mat_bajo_responsabilidad,
         ite.descripcion_aux
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
  ORDER BY ite.id_supergrupo,
           ite.id_grupo,
           ite.id_subgrupo,
           ite.id_id1,
           ite.id_id2,
           ite.id_id3;

ALTER TABLE almin.val_item
  OWNER TO postgres;
  
  
  
  
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
                         JOIN almin.tal_parametro_almacen_logico pa ON
                           pa.id_parametro_almacen = kl.id_parametro_almacen AND
                           pa.estado::text = 'abierto'::text AND
                           pa.id_almacen_logico = kl.id_almacen_logico
                    WHERE kl.id_item = ite.id_item AND
                          kl.estado_item::text = 'Nuevo'::text AND
                          karlog.id_almacen_logico = kl.id_almacen_logico
         ), 0::numeric) AS nuevo,
         COALESCE((
                    SELECT klg.cantidad - klg.reservado AS cantidad
                    FROM almin.tal_kardex_logico klg
                         JOIN almin.tal_parametro_almacen_logico pal ON
                           pal.id_parametro_almacen = klg.id_parametro_almacen
                           AND pal.estado::text = 'abierto'::text AND
                           pal.id_almacen_logico = klg.id_almacen_logico
                    WHERE klg.id_item = ite.id_item AND
                          klg.estado_item::text = 'Usado'::text AND
                          karlog.id_almacen_logico = klg.id_almacen_logico
         ), 0::numeric) AS usado,
         karlog.id_almacen_logico,
         paralm.id_parametro_almacen,
         ite.descripcion_aux
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
       JOIN almin.tal_parametro_almacen_logico paralm ON
         paralm.id_parametro_almacen = karlog.id_parametro_almacen AND
         paralm.id_almacen_logico = karlog.id_almacen_logico AND paralm.estado::
         text = 'abierto'::text
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
           paralm.id_parametro_almacen,
           ite.descripcion_aux
  ORDER BY ite.id_item;

ALTER TABLE almin.val_kardex_logico
  OWNER TO postgres;



/***********************************F-SCP-RAC-ALMIN-2-25/01/2017****************************************/ 


  
 