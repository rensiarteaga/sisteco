SELECT oid,relname,reltype FROM pg_class
SELECT * FROM pg_class
SELECT * FROM pg_class where relname like 'tal%' and relkind = 'r'

--OBTENER EL OID DE LA TABLA tal_ingreso
select ('tal_item'::regclass)::oid;
--(otra forma de obtener oid)
select distinct tableoid from tpm_tipo_unidad_medida;

--OBTENER LOS COMMENTS DE LAS TABLAS EN BASE AL OID DE LA TABLA Y EL NÚMERO DE COL
select  pg_catalog.col_description(746863,15);
select  pg_catalog.


--OBTENER CONSTRAINTS DE LA BASE DE DATOS
SELECT c.conname AS constraint_name, c.consrc AS restriccion,
CASE c.contype WHEN 'c' THEN 'CHECK' WHEN 'f' THEN 'FOREIGN KEY' WHEN 'p'
THEN 'PRIMARY KEY' WHEN 'u' THEN 'UNIQUE' END AS "constraint_type",
CASE WHEN c.condeferrable = 'f' THEN 0 ELSE 1 END AS is_deferrable,
CASE WHEN c.condeferred = 'f' THEN 0 ELSE 1 END AS is_deferred, t.relname AS table_name, array_to_string(c.conkey, ' ') AS constraint_key,
CASE confupdtype WHEN 'a' THEN 'NO ACTION' WHEN 'r' THEN 'RESTRICT' WHEN 'c' THEN 'CASCADE' WHEN 'n' THEN 'SET NULL' WHEN 'd' THEN 'SET DEFAULT' END AS on_update,
CASE confdeltype WHEN 'a' THEN 'NO ACTION' WHEN 'r' THEN 'RESTRICT' WHEN 'c' THEN 'CASCADE' WHEN 'n' THEN 'SET NULL' WHEN 'd' THEN 'SET DEFAULT' END AS on_delete,
CASE confmatchtype WHEN 'u' THEN 'UNSPECIFIED' WHEN 'f' THEN 'FULL' WHEN 'p' THEN 'PARTIAL' END AS match_type, t2.relname AS references_table, array_to_string(c.confkey, ' ') AS fk_constraint_key
FROM pg_constraint c LEFT JOIN pg_class t ON c.conrelid = t.oid LEFT JOIN pg_class t2 ON c.confrelid = t2.oid
WHERE t.relname = 'tal_item' AND c.conname = 'tal_item_estado_item_check'


--OBTENER LOS NOMBRES DE LOS CONTRAINTS
SELECT
constraint_name, constraint_type
FROM information_schema.table_constraints WHERE table_name = 'tal_item';


SELECT DISTINCT
tableoid
FROM tpm_tipo_unidad_medida;

SELECT
pg_catalog.col_description(746863,15);

SELECT
pg_catalog.table_description(746863);



--select *
--into meta
--from tsg_metaproceso

select * from meta

--delete from meta where id_subsistema <> 3





SELECT
meta.id_metaproceso           ,meta.nombre                    ,meta.nivel,
meta.fk_id_metaproceso        ,meta.codigo_procedimiento      ,meta.nombre_achivo,
meta.ruta_archivo             ,meta.visible                   ,meta.orden_logico,
meta.icono                    ,meta.nombre_tabla              ,meta.prefijo,
meta.codigo_base              ,meta.tipo_vista                ,meta.con_ep,
meta.con_interfaz             ,meta.num_datos_hijo
FROM meta
WHERE  meta.con_interfaz = 'si'
AND (meta.id_metaproceso = 240 OR meta.fk_id_metaproceso = 240)
ORDER BY meta.fk_id_metaproceso ASC,meta.orden_logico

select * from meta where meta.fk_id_metaproceso = 240 and meta.con_interfaz = 'si'





select pg_catalog.obj_description(t.tableoid), from;

select distinct tableoid from tal_item;

SELECT distinct
pg_catalog.obj_description(t.tableoid)
FROM tal_item t



SELECT
a.attnum, a.attname, t.typname, a.attlen, a.atttypmod, a.attnotnull, a.atthasdef,
pg_catalog.obj_description(c.oid)
FROM pg_class as c, pg_attribute a, pg_type t
WHERE a.attnum > 0
AND a.attrelid = c.oid
AND c.relname = 'tal_item'
AND a.atttypid = t.oid
ORDER BY a.attnum
