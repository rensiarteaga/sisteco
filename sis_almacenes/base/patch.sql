
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
 
 
 