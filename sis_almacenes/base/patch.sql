
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




