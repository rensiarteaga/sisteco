
/***********************************I-SCP-RAC-PARAM-1-21/11/2016****************************************/
CREATE TABLE alma.tprueba (
  id_prueba SERIAL NOT NULL,
  nombre VARCHAR DEFAULT 'hola' NOT NULL,
  PRIMARY KEY(id_prueba)
) WITHOUT OIDS;
/***********************************F-SCP-RAC-PARAM-1-21/11/2016****************************************/ 


/***********************************I-SCP-RAC-PARAM-1-23/11/2016****************************************/ 

--------------- SQL ---------------

CREATE TABLE alma.tprueba_2 (
  id_prueba_2 SERIAL NOT NULL,
  codigo VARCHAR,
  nombre VARCHAR,
  PRIMARY KEY(id_prueba_2)
) WITHOUT OIDS;



/***********************************F-SCP-RAC-PARAM-1-23/11/2016****************************************/ 



/***********************************I-SCP-RAC-PARAM-2-23/11/2016****************************************/ 


--------------- SQL ---------------

ALTER TABLE almin.tprueba
  ADD COLUMN xxxxxx VARCHAR;
  
/***********************************F-SCP-RAC-PARAM-2-23/11/2016****************************************/ 
  
