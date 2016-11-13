----------------AAO - 12/08/2013
CREATE SCHEMA alma AUTHORIZATION postgres;

CREATE TABLE alma.tal_clasificacion (
  id_clasificacion SERIAL NOT NULL, 
  codigo VARCHAR(5) NOT NULL, 
  codigo_largo VARCHAR(100) NOT NULL, 
  nombre VARCHAR(100) NOT NULL, 
  estado VARCHAR(15) NOT NULL, 
  id_clasificacion_fk INTEGER, 
  id_usuario_reg INTEGER NOT NULL, 
  id_usuario_mod INTEGER, 
  fecha_reg TIMESTAMP NOT NULL, 
  fecha_mod TIMESTAMP, 
  PRIMARY KEY(id_clasificacion)
) WITHOUT OIDS;

ALTER TABLE alma.tal_clasificacion
  ADD CONSTRAINT fk_tal_clasificacion__id_clasificacion_fk FOREIGN KEY (id_clasificacion_fk)
    REFERENCES alma.tal_clasificacion(id_clasificacion)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
ALTER TABLE alma.tal_clasificacion
  ADD CONSTRAINT fk_tal_clasificacion__id_usuario_reg FOREIGN KEY (id_usuario_reg)
    REFERENCES sss.tsg_usuario(id_usuario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
ALTER TABLE alma.tal_clasificacion
  ADD CONSTRAINT fk_tal_clasificacion__id_usuario_mod FOREIGN KEY (id_usuario_mod)
    REFERENCES sss.tsg_usuario(id_usuario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

ALTER TABLE alma.tal_clasificacion
  ADD CONSTRAINT chk_tal_clasificacion__estado CHECK (estado = 'activo' or estado = 'inactivo');
 
----------------RLB - 30/08/2013
CREATE TABLE alma.tal_almacen (
  id_almacen SERIAL NOT NULL, 
  codigo VARCHAR(20) NOT NULL, 
  nombre VARCHAR(100) NOT NULL, 
  direccion VARCHAR(200) NOT NULL, 
  estado VARCHAR(15) NOT NULL, 
  tipo_control VARCHAR(20) NOT NULL, 
  id_lugar INTEGER NOT NULL, 
  id_depto INTEGER NOT NULL, 
  id_usuario_reg INTEGER NOT NULL, 
  id_usuario_mod INTEGER, 
  fecha_reg TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, 
  fecha_mod TIMESTAMP(0) WITHOUT TIME ZONE, 
  CONSTRAINT "alma.tal_almacen_pkey" PRIMARY KEY(id_almacen), 
  CONSTRAINT fk_tal_almacen__id_depto FOREIGN KEY (id_depto)
    REFERENCES param.tpm_depto(id_depto)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE, 
  CONSTRAINT fk_tal_almacen__id_lugar FOREIGN KEY (id_lugar)
    REFERENCES sss.tsg_lugar(id_lugar)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE, 
  CONSTRAINT fk_tal_almacen__id_usuario_mod FOREIGN KEY (id_usuario_mod)
    REFERENCES sss.tsg_usuario(id_usuario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE, 
  CONSTRAINT fk_tal_almacen__id_usuario_reg FOREIGN KEY (id_usuario_reg)
    REFERENCES sss.tsg_usuario(id_usuario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE
) WITHOUT OIDS;

ALTER TABLE alma.tal_almacen
  ADD CONSTRAINT chk_tal_almacen__estado CHECK (estado = 'activo' or estado = 'inactivo');

  
CREATE TABLE alma.tal_ubicacion (
  id_ubicacion SERIAL, 
  codigo VARCHAR(20) NOT NULL, 
  nombre VARCHAR(100) NOT NULL, 
  estado VARCHAR(15) NOT NULL, 
  id_almacen INTEGER, 
  id_ubicacion_fk INTEGER, 
  id_usuario_reg INTEGER NOT NULL, 
  id_usuario_mod INTEGER, 
  fecha_reg TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, 
  fecha_mod TIMESTAMP(0) WITHOUT TIME ZONE, 
  CONSTRAINT tal_ubicacion_pkey PRIMARY KEY(id_ubicacion), 
  CONSTRAINT fk_tal_ubicacion__id_almacen FOREIGN KEY (id_almacen)
    REFERENCES alma.tal_almacen(id_almacen)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE, 
  CONSTRAINT fk_tal_ubicacion__id_ubicacion_fk FOREIGN KEY (id_ubicacion_fk)
    REFERENCES alma.tal_ubicacion(id_ubicacion)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE, 
  CONSTRAINT fk_tal_ubicacion__id_usuario_mod FOREIGN KEY (id_usuario_mod)
    REFERENCES sss.tsg_usuario(id_usuario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE, 
  CONSTRAINT fk_tal_ubicacion__id_usuario_reg FOREIGN KEY (id_usuario_reg)
    REFERENCES sss.tsg_usuario(id_usuario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE
) WITHOUT OIDS;

ALTER TABLE alma.tal_ubicacion
  ALTER COLUMN id_ubicacion SET STATISTICS 0;  

----------------RLB - 10/09/2013
--------------- SQL ---------------

  CREATE TABLE alma.tal_item (
  id_item SERIAL, 
  id_clasificacion INTEGER NOT NULL, 
  codigo VARCHAR(30) NOT NULL, 
  nombre VARCHAR(100) NOT NULL, 
  descripcion VARCHAR(1000), 
  codigo_fabrica VARCHAR(30), 
  id_unidad_medida INTEGER NOT NULL, 
  num_por_clasificacion INTEGER NOT NULL, 
  bajo_responsabilidad VARCHAR(2) NOT NULL, 
  estado VARCHAR(10) NOT NULL, 
  id_usuario_reg INTEGER NOT NULL, 
  id_usuario_mod INTEGER, 
  fecha_reg TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, 
  fecha_mod TIMESTAMP(0) WITHOUT TIME ZONE, 
  metodo_valoracion VARCHAR(4), 
  CONSTRAINT tal_item_pkey PRIMARY KEY(id_item), 
  CONSTRAINT chk_tal_item__estado CHECK (((estado)::text = 'activo'::text) OR ((estado)::text = 'inactivo'::text)), 
  CONSTRAINT fk_tal_item__id_clasificacion FOREIGN KEY (id_clasificacion)
    REFERENCES alma.tal_clasificacion(id_clasificacion)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE, 
  CONSTRAINT fk_tal_item__id_unidad_medida FOREIGN KEY (id_unidad_medida)
    REFERENCES param.tpm_unidad_medida_base(id_unidad_medida_base)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE, 
  CONSTRAINT fk_tal_item__id_usuario_mod FOREIGN KEY (id_usuario_mod)
    REFERENCES sss.tsg_usuario(id_usuario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE, 
  CONSTRAINT fk_tal_item__id_usuario_reg FOREIGN KEY (id_usuario_reg)
    REFERENCES sss.tsg_usuario(id_usuario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE
) WITHOUT OIDS;
  


ALTER TABLE alma.tal_ubicacion
  ADD CONSTRAINT chk_tal_ubicacion__estado CHECK (((estado)::text = 'activo'::text) OR ((estado)::text = 'inactivo'::text));
   
-------- AAO - 10/09/2013
  
  CREATE TABLE alma.tal_tipo_movimiento (
  id_tipo_movimiento SERIAL, 
  id_documento INTEGER NOT NULL, 
  tipo VARCHAR(20) NOT NULL, 
  id_usuario_reg INTEGER NOT NULL, 
  id_usuario_mod INTEGER, 
  fecha_reg TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, 
  fecha_mod TIMESTAMP(0) WITHOUT TIME ZONE, 
  CONSTRAINT tal_tipo_movimiento_pkey PRIMARY KEY(id_tipo_movimiento), 
  CONSTRAINT fk_tal_tipo_movimiento__id_documento FOREIGN KEY (id_documento)
    REFERENCES param.tpm_documento(id_documento)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE
) WITHOUT OIDS;

ALTER TABLE alma.tal_tipo_movimiento
  ALTER COLUMN id_tipo_movimiento SET STATISTICS 0;
  
-----------------------------------------

----------------RLB - 10/09/2013   segundo commit
--------------- SQL --------------- 
  
  CREATE TABLE alma.tal_movimiento (
  id_movimiento SERIAL, 
  id_tipo_movimiento INTEGER NOT NULL, 
  id_almacen INTEGER NOT NULL, 
  id_solicitud_salida INTEGER, 
  codigo VARCHAR(20), 
  fecha_movimiento TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, 
  fecha_finalizacion TIMESTAMP(0) WITHOUT TIME ZONE, 
  descripcion VARCHAR(200), 
  observaciones VARCHAR(200), 
  estado VARCHAR(20) NOT NULL, 
  id_usuario_reg INTEGER NOT NULL, 
  id_usuario_mod INTEGER, 
  fecha_reg TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, 
  fecha_mod TIMESTAMP(0) WITHOUT TIME ZONE,
   CONSTRAINT tal_movimiento_pkey PRIMARY KEY(id_movimiento), 
  CONSTRAINT chk_tal_movimiento__estado CHECK (((estado)::text = 'borrador'::text) OR ((estado)::text = 'finalizado'::text)), 
  CONSTRAINT fk_tal_movimiento__id_almacen FOREIGN KEY (id_almacen)
    REFERENCES alma.tal_almacen(id_almacen)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE, 
  CONSTRAINT fk_tal_movimiento__id_tipo_movimiento FOREIGN KEY (id_tipo_movimiento)
    REFERENCES alma.tal_tipo_movimiento(id_tipo_movimiento)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE, 
  CONSTRAINT fk_tal_movimiento__id_usuario_mod FOREIGN KEY (id_usuario_mod)
    REFERENCES sss.tsg_usuario(id_usuario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE, 
  CONSTRAINT fk_tal_movimiento__id_usuario_reg FOREIGN KEY (id_usuario_reg)
    REFERENCES sss.tsg_usuario(id_usuario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE
) WITHOUT OIDS;
---------------------------------

  
--------- AAO - 10/09/2013 2do commit
  
CREATE TABLE alma.tal_solicitud_salida (
  id_solicitud_salida SERIAL NOT NULL, 
  id_almacen INTEGER NOT NULL, 
  id_unidad_organizacional INTEGER NOT NULL, 
  id_emplelado INTEGER NOT NULL, 
  cargo_empleado VARCHAR(50) NOT NULL, 
  id_aprobador INTEGER NOT NULL, 
  cargo_aprobador VARCHAR(50) NOT NULL,
  fecha_solicitud TIMESTAMP WITHOUT TIME ZONE NOT NULL, 
  descripcion VARCHAR(1000) NOT NULL, 
  estado VARCHAR NOT NULL, 
  id_usuario_reg INTEGER NOT NULL, 
  id_usuario_mod INTEGER, 
  fecha_reg TIMESTAMP WITHOUT TIME ZONE NOT NULL, 
  fecha_mod TIMESTAMP WITHOUT TIME ZONE, 
  PRIMARY KEY(id_solicitud_salida)
) WITHOUT OIDS;

ALTER TABLE alma.tal_solicitud_salida
  ADD CONSTRAINT fk_tal_solicitud_salida__id_almacen FOREIGN KEY (id_almacen)
    REFERENCES alma.tal_almacen(id_almacen)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

  ALTER TABLE alma.tal_solicitud_salida
  ADD CONSTRAINT fk_tal_solicitud_salida__id_unidad_organizacional FOREIGN KEY (id_unidad_organizacional)
    REFERENCES kard.tkp_unidad_organizacional(id_unidad_organizacional)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
  
  ALTER TABLE alma.tal_solicitud_salida
  ADD CONSTRAINT fk_tal_solicitud_salida__id_empleado FOREIGN KEY (id_emplelado)
    REFERENCES kard.tkp_empleado(id_empleado)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
  
  ALTER TABLE alma.tal_solicitud_salida
  ADD CONSTRAINT fk_tal_solicitud_salida__id_usuario_reg FOREIGN KEY (id_usuario_reg)
    REFERENCES sss.tsg_usuario(id_usuario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
  
ALTER TABLE alma.tal_solicitud_salida
  ADD CONSTRAINT fk_tal_solicitud_salida__id_usuario_mod FOREIGN KEY (id_usuario_mod)
    REFERENCES sss.tsg_usuario(id_usuario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
ALTER TABLE alma.tal_solicitud_salida
  ADD CONSTRAINT chk_tal_solicitud_salida__estado CHECK (estado = 'borrador' or estado = 'pendiente_aprobacion' or estado = 'pendiente_entrega' or estado = 'procesa_entrega' or estado = 'entregado');

ALTER TABLE alma.tal_solicitud_salida
  RENAME COLUMN id_emplelado TO id_empleado;

-------------------------------

----------------------------------------
----------------RLB - 13/09/2013  
--------------- SQL ---------------

CREATE TABLE alma.tal_detalle_movimiento (
  id_detalle_movimiento SERIAL, 
  id_movimiento INTEGER NOT NULL, 
  id_item INTEGER NOT NULL, 
  cantidad NUMERIC(18,2), 
  id_usuario_reg INTEGER NOT NULL, 
  id_usuario_mod INTEGER, 
  fecha_reg TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, 
  fecha_mod TIMESTAMP(0) WITHOUT TIME ZONE, 
  CONSTRAINT tal_detalle_movimiento_pkey PRIMARY KEY(id_detalle_movimiento), 
  CONSTRAINT fk_detalle_movimiento__id_item FOREIGN KEY (id_item)
    REFERENCES alma.tal_item(id_item)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE, 
  CONSTRAINT fk_detalle_movimiento__id_movimiento FOREIGN KEY (id_movimiento)
    REFERENCES alma.tal_movimiento(id_movimiento)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE
) WITHOUT OIDS;


----------------RLB - 18/09/2013
--------------- SQL ---------------

-- object recreation

ALTER TABLE alma.tal_detalle_movimiento
  ADD CONSTRAINT fk_tal_detalle_movimiento__id_usuario_mod FOREIGN KEY (id_usuario_mod)
    REFERENCES sss.tsg_usuario(id_usuario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
    -- object recreation
ALTER TABLE alma.tal_detalle_movimiento
  ADD CONSTRAINT fk_tal_detalle_movimiento__id_usuario_reg FOREIGN KEY (id_usuario_reg)
    REFERENCES sss.tsg_usuario(id_usuario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
    
  
----------------RLB - 18/09/2013
--------------- SQL ---------------  
    
    
 CREATE TABLE alma.tal_detalle_solicitud (
  id_detalle_solicitud SERIAL, 
  id_solicitud_salida INTEGER NOT NULL, 
  id_item INTEGER NOT NULL, 
  cantidad NUMERIC(18,2), 
  id_usuario_reg INTEGER NOT NULL, 
  id_usuario_mod INTEGER, 
  fecha_reg TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, 
  fecha_mod TIMESTAMP(0) WITHOUT TIME ZONE, 
  CONSTRAINT tal_detalle_solicitud_pkey PRIMARY KEY(id_detalle_solicitud), 
  CONSTRAINT fk_tal_detalle_solicitud__id_item FOREIGN KEY (id_item)
    REFERENCES alma.tal_item(id_item)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE, 
  CONSTRAINT fk_tal_detalle_solicitud__id_solicitud_salida FOREIGN KEY (id_solicitud_salida)
    REFERENCES alma.tal_solicitud_salida(id_solicitud_salida)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE, 
  CONSTRAINT fk_tal_detalle_solicitud__id_usuario_mod FOREIGN KEY (id_usuario_mod)
    REFERENCES sss.tsg_usuario(id_usuario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE, 
  CONSTRAINT fk_tal_detalle_solicitud__id_usuario_reg FOREIGN KEY (id_usuario_reg)
    REFERENCES sss.tsg_usuario(id_usuario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE
) WITHOUT OIDS;

ALTER TABLE alma.tal_detalle_solicitud
  ALTER COLUMN cantidad SET STATISTICS 100;
  
  
  
  --------------- SQL --------------- 24.09.2013

ALTER TABLE alma.tal_tipo_movimiento
  ADD COLUMN requiere_aprobacion VARCHAR(2);
  
  
  
  
  --------------- SQL ---------------01.10.2013

 -- object recreation
ALTER TABLE alma.tal_solicitud_salida
  DROP CONSTRAINT chk_tal_solicitud_salida__estado RESTRICT;

ALTER TABLE alma.tal_solicitud_salida
  ADD CONSTRAINT chk_tal_solicitud_salida__estado CHECK ((((((estado)::text = 'borrador'::text) OR ((estado)::text = 'pendiente_aprobacion'::text)) OR ((estado)::text = 'pendiente_entrega'::text)) OR ((estado)::text = 'proceso_entrega'::text)) OR ((estado)::text = 'entregado'::text));
  
  --------------- SQL ---------------    07.10.2013

 -- object recreation
ALTER TABLE alma.tal_movimiento
  DROP CONSTRAINT chk_tal_movimiento__estado RESTRICT;

ALTER TABLE alma.tal_movimiento
  ADD CONSTRAINT chk_tal_movimiento__estado CHECK (((estado)::text = 'borrador'::text) OR ((estado)::text = 'finalizado'::text) OR ((estado)::text = 'proceso_aprobacion'::text));
  
  --------------- SQL --------------- 10.10.2013

ALTER TABLE alma.tal_detalle_movimiento
  ADD COLUMN tipo_saldo VARCHAR(15);
  
  
  
   --------------- SQL --------------- 15.10.2013 

ALTER TABLE alma.tal_detalle_movimiento
  ADD COLUMN cantidad_solicitada NUMERIC(18,2);
 
   --------------- SQL --------------- 15.10.2013
ALTER TABLE alma.tal_detalle_movimiento
  ADD CONSTRAINT chk_tal_detalle_movimiento__tipo_saldo CHECK (((tipo_saldo)::text = 'rechazado'::text) OR ((tipo_saldo)::text = 'por_entregar'::text));
  
  