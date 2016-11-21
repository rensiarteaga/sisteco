
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





