/**************************************************************************
 SISTEMA ENDESIS
***************************************************************************
 SCRIPT: 		script_endesis_metaprocesos.sql
 DESCRIPCIÓN: 	Script de creación de los metaprocesos definidos (para la estructura del menú de la aplicación)
 AUTOR: 		Rodrigo Chumacero Moscoso
 FECHA:			20-07-2007
 COMENTARIOS:	
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCIÓN:
 AUTOR:
 FECHA:

***************************************************************************/

/* Data for the `public.tsg_metaproceso` table  (Records 1 - 64) */
INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (1, 1, 1, 0, 'ENDESIS', 'ENDESIS', NULL, NULL, '11/05/2007', '10:42:00', NULL, NULL, 'Sistema de Información Administrativo Financiero ENDE', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (2, 2, 1, 1, 'ACTIF', 'ACTIF', NULL, NULL, '11/05/2007', '10:44:00', NULL, NULL, 'Sistema de Administración y Control de Activos Fijos', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (3, 3, 1, 1, 'ALMIN', 'ALMIN', NULL, NULL, '11/05/2007', '10:55:00', NULL, NULL, 'Sistema de Almacenes e Inventarios', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (4, 4, 1, 1, 'SICOMP', 'SICOMP', NULL, NULL, '11/05/2007', '10:57:00', NULL, NULL, 'Sistema de Compras', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (5, 5, 1, 1, 'KARD', 'KARD', NULL, NULL, '11/05/2007', '10:58:00', NULL, NULL, 'Sistema de Kardex de Personal', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (6, 6, 1, 1, 'SSS', 'SSS', NULL, NULL, '11/05/2007', '10:58:00', NULL, NULL, 'Sistema de Seguridad', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (7, 7, 1, 1, 'PM', 'PM', NULL, NULL, '11/05/2007', '10:59:00', NULL, NULL, 'Sistema de Parámetros', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (8, 8, 1, 1, 'SAJ', 'SAJ', NULL, NULL, '11/05/2007', '11:00:00', NULL, NULL, 'Sistema Jurídico', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (9, 9, 1, 1, 'SCI', 'SCI', NULL, NULL, '11/05/2007', '11:00:00', NULL, NULL, 'Sistema de Contabilidad Integrada', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (10, 1, 2, 2, 'Parámetros', 'AF_PARAM', NULL, NULL, '11/05/2007', '11:11:00', NULL, NULL, 'Parámetros de Activos Fijos', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (11, 1, 2, 2, 'Procesos', 'AF_OPER', NULL, NULL, '11/05/2007', '11:12:00', NULL, NULL, 'Operaciones de Activos Fijos', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (12, 1, 2, 2, 'Reportes', 'AF_REP', NULL, NULL, '11/05/2007', '11:13:00', NULL, NULL, 'Reportes de Activos Fijos', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (13, 1, 10, 3, 'Métodos de Depreciación', 'AF_MET_DEP', 'f_taf_metodo_depreciacion', 'sis_activos_fijos/vista/metodo_depreciacion/metodo_depreciacion.php', '11/05/2007', '11:14:00', NULL, NULL, 'Métodos de Depreciación considerados', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (14, 1, 10, 3, 'Definición de Procesos ', 'AF_PROC', 'f_taf_proceso', 'sis_activos_fijos/vista/proceso/proceso.php', '11/05/2007', '11:16:00', NULL, NULL, 'Procesos a realizar con los Activos Fijos', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (15, 1, 10, 3, 'Tipos de Activos Fijos', 'AF_TIP', 'f_taf_tipo_activo', 'sis_activos_fijos/vista/tipo_activo/tipo_activo.php', '11/05/2007', '11:23:00', NULL, NULL, 'Tipos de Activos Fijos', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (16, 1, 14, 4, 'Motivos para la realización de los procesos con los Activos Fijos', 'AF_MOT_PROC', 'f_taf_proceso_motivo', NULL, '11/05/2007', '11:27:00', NULL, NULL, 'Motivos para la realización de los procesos con los Activos Fijos', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (17, 1, 15, 4, 'Subtipos de Activos Fijos', 'AF_SUBTIP', 'f_taf_sub_tipo_activo', NULL, '11/05/2007', '11:31:00', NULL, NULL, 'Subtipos de los Activos Fijos', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (18, 1, 15, 4, 'Relacionador Tipos/Proceso/Cuentas Contables', 'AF_TIPO_PROC_CTA', 'f_taf_tipo_activo_proceso', NULL, '11/05/2007', '11:33:00', NULL, NULL, 'Relaciona los procesos por Tipo con las cuentas contables', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (19, 1, 15, 4, 'Características por Tipo', 'AF_TIP_CAR', 'f_taf_caracteristicas', NULL, '11/05/2007', '12:07:00', NULL, NULL, 'Característifcas generales de los activos fijos por Tipo', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (20, 1, 13, 4, 'Inserción Métodos de Depreciación', 'AF_MET_DEP_INS', 'f_taf_metodo_depreciacion', NULL, '11/05/2007', '12:09:00', NULL, NULL, 'Inserción de Métodos de Depreciación', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (21, 1, 13, 4, 'Modificación de Métodos de Depreciación', 'AF_MET_DEP_UPD', 'f_taf_metodo_depreciacion', NULL, '11/05/2007', '12:11:00', NULL, NULL, 'Modificación de Métodos de Depreciación', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (22, 1, 13, 4, 'Eliminación de Métodos de Depreciación', 'AF_MET_DEP_DEL', 'f_taf_metodo_depreciacion', NULL, '11/05/2007', '12:12:00', NULL, NULL, 'Eliminación de Métodos de Depreciación', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (23, 1, 14, 4, 'Inserción de Procesos de Activos Fijos', 'AF_PROC_INS', 'f_taf_proceso', NULL, '11/05/2007', '12:19:00', NULL, NULL, 'Inserción de Procesos', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (24, 1, 14, 4, 'Modificación de Procesos de Activos Fijos', 'AF_PROC_UPD', 'f_taf_proceso', '', '11/05/2007', '12:19:00', NULL, NULL, 'Modificación de Procesos', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (25, 1, 15, 4, 'Eliminación de Procesos de Activos Fijos', 'AF_PROC_DEL', 'f_taf_proceso', '', '11/05/2007', '12:23:00', NULL, NULL, 'Eliminación de Procesos', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (26, 1, 15, 4, 'Inserción de Tipos de Activos', 'AF_TIP_INS', 'f_taf_tipo_activo', 'sis_activos_fijos/vista/tipo_activo/tipo_activo.php', '11/05/2007', '12:23:00', NULL, NULL, 'Inserción de Tipos de Activos', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (27, 1, 15, 4, 'Modificación de Tipos de Activos', 'AF_TIP_UPD', 'f_taf_tipo_activo', NULL, '11/05/2007', '12:23:00', NULL, NULL, 'Modificación de Tipos de Activos', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (28, 1, 15, 4, 'Eliminación de Tipos de Activos', 'AF_TIP_DEL', 'f_taf_tipo_activo', NULL, '11/05/2007', '12:23:00', NULL, NULL, 'Eliminación de Tipos de Activos', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (29, 1, 16, 5, 'Inserción de Motivos de Procesos de Activos Fijos', 'AF_MOT_PROC_INS', 'f_taf_proceso_motivo', NULL, '11/05/2007', '12:23:00', NULL, NULL, 'Inserción de Motivos', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (30, 1, 16, 5, 'Modificación de Motivos de Procesos de Activos Fijos', 'AF_MOT_PROC_UPD', 'f_taf_proceso_motivo', NULL, '11/05/2007', '12:23:00', NULL, NULL, 'Modificación de Motivos', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (31, 1, 16, 5, 'Eliminación de Motivos de Procesos de Activos Fijos', 'AF_MOT_PROC_DEL', 'f_taf_proceso_motivo', NULL, '11/05/2007', '12:23:00', NULL, NULL, 'Eliminación de Motivos', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (32, 1, 17, 5, 'Inserción de Subtipos de Activos Fijos', 'AF_SUBTIP_INS', 'f_taf_sub_tipo_activo', NULL, '11/05/2007', '11:31:00', NULL, NULL, 'Inserción de subtipos de activos fijos', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (33, 1, 17, 5, 'Modificación de Subtipos de Activos Fijos', 'AF_SUBTIP_UPD', 'f_taf_sub_tipo_activo', NULL, '11/05/2007', '11:31:00', NULL, NULL, 'Modificación de subtipos de activos fijos', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (34, 1, 17, 5, 'Eliminación de Subtipos de Activos Fijos', 'AF_SUBTIP_DEL', 'f_taf_sub_tipo_activo', NULL, '11/05/2007', '11:31:00', NULL, NULL, 'Eliminación de subtipos de activos fijos', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (35, 1, 18, 5, 'Inserción de relación Tipo/Proceso/Cuenta', 'AF_TIPO_PROC_CTA_INS', 'f_taf_tipo_activo_proceso', NULL, '11/05/2007', '11:33:00', NULL, NULL, 'Inserción relación Tipo/Proceso/Cuenta', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (36, 1, 18, 5, 'Modificación relación Tipo/Proceso/Cuenta', 'AF_TIPO_PROC_CTA_UPD', 'f_taf_tipo_activo_proceso', NULL, '11/05/2007', '11:33:00', NULL, NULL, 'Modificación relación Tipo/Proceso/Cuenta', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (37, 1, 18, 5, 'Eliminación relación Tipo/Proceso/Cuenta', 'AF_TIPO_PROC_CTA_DEL', 'f_taf_tipo_activo_proceso', NULL, '11/05/2007', '11:33:00', NULL, NULL, 'Eliminación relación Tipo/Proceso/Cuenta', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (38, 1, 19, 5, 'Inserción Características Generales por Tipo', 'AF_TIP_CAR_INS', 'f_taf_caracteristicas', NULL, '11/05/2007', '12:07:00', NULL, NULL, 'Inserción de características generales de los activos fijos por Tipo', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (39, 1, 11, 3, 'Alta de Activos Fijos', 'AF_AF', 'f_taf_activo_fijo', 'sis_activos_fijos/vista/activo_fijo/activo_fijo.php', '15/05/2007', '20:00:00', NULL, NULL, 'Registro de Activos Fijos', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (40, 1, 39, 4, 'Inserción Activos Fijos', 'AF_AF_INS', 'f_taf_activo_fijo', NULL, '15/05/2007', '20:00:00', NULL, NULL, 'Inserción de Activos Fijos', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (41, 1, 39, 4, 'Modificación Activos Fijos', 'AF_AF_UPD', 'f_taf_activo_fijo', NULL, '15/05/2007', '20:00:00', NULL, NULL, 'Modificación de Activos Fijos', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (42, 1, 39, 4, 'Eliminación Activos Fijos', 'AF_AF_DEL', 'f_taf_activo_fijo', NULL, '15/05/2007', '20:00:00', NULL, NULL, 'Eliminación de Activos Fijos', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (43, 1, 13, 4, 'Selección de Métodos de Depreciación', 'AF_MET_DEP_SEL', 'f_taf_metodo_depreciacion', NULL, '15/05/2007', '20:00:00', NULL, NULL, 'Selección de Métodos de depreciación', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (44, 1, 14, 4, 'Selección de Procesos de Activos Fijos', 'AF_PROC_SEL', 'f_taf_proceso', NULL, '15/05/2007', '20:00:00', NULL, NULL, 'Selección de Procesos', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (45, 1, 15, 4, 'Selección de Tipos de Activos', 'AF_TIP_SEL', 'f_taf_tipo_activo', NULL, '15/05/2007', '20:00:00', NULL, NULL, 'Selección de Tipos de Activos', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (46, 1, 16, 5, 'Selección de Motivos de los Procesos', 'AF_MOT_PROC_SEL', 'f_taf_proceso_motivo', NULL, '15/05/2007', '20:00:00', NULL, NULL, 'Selección de Motivos de los Procesos', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (47, 1, 17, 5, 'Selección de Subtipos de Activos Fijos', 'AF_SUBTIP_SEL', 'f_taf_sub_tipo_activo', NULL, '15/05/2007', '20:00:00', NULL, NULL, 'Selección de Sub Tipos de Activos', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (48, 1, 18, 5, 'Selección de Relación Tipo/Proceso/Cuenta', 'AF_TIPO_PROC_CTA_SEL', 'f_taf_tipo_activo_proceso', NULL, '15/05/2007', '20:00:00', NULL, NULL, 'Selección de Relación Tipo/Proceso/Cuenta', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (49, 1, 19, 5, 'Modificación de Características Generales por Tipo', 'AF_TIP_CAR_UPD', 'f_taf_caracteristicas', NULL, '15/05/2007', '20:00:00', NULL, NULL, 'Modificación de Características Generales por Tipo', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (50, 1, 19, 5, 'Eliminación de Características Generales por Tipo', 'AF_TIP_CAR_DEL', 'f_taf_caracteristicas', NULL, '15/05/2007', '20:00:00', NULL, NULL, 'Eliminación de Características Generales por Tipo', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (51, 1, 19, 5, 'Selección de Características Generales por Tipo', 'AF_TIP_CAR_SEL', 'f_taf_caracteristicas', NULL, '15/05/2007', '20:00:00', NULL, NULL, 'Selección de Características Generales por Tipo', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (52, 1, 39, 4, 'Selección de Activos Fijos', 'AF_AF_SEL', 'f_taf_activo_fijo', NULL, '15/05/2007', '20:00:00', NULL, NULL, 'Selección de Activos Fijos', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (53, 1, 11, 3, 'Unidades Constructivas', 'AF_UNI_CONS', 'f_taf_unidad_constructiva', 'sis_activos_fijos/vista/unidad_constructiva/unidad_constructiva.php', '01/06/2007', '20:00:00', NULL, NULL, 'Unidades Constructivas', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (54, 1, 53, 4, 'Inserción Unidades Constructivas', 'AF_UNI_CONS_INS', 'f_taf_unidad_constructiva', NULL, '01/06/2007', '20:00:00', NULL, NULL, 'Inserción de Unidades Constructivas', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (55, 1, 53, 4, 'Modificación Unidades Constructivas', 'AF_UNI_CONS_UPD', 'f_taf_unidad_constructiva', NULL, '01/06/2007', '20:00:00', NULL, NULL, 'Modificación de Unidades Constructivas', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (56, 1, 53, 4, 'Eliminación Unidades Constructivas', 'AF_UNI_CONS_DEL', 'f_taf_unidad_constructiva', NULL, '01/06/2007', '20:00:00', NULL, NULL, 'Eliminación de Unidades Constructivas', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (57, 1, 53, 4, 'Selección Unidades Constructivas', 'AF_UNI_CONS_SEL', 'f_taf_unidad_constructiva', NULL, '01/06/2007', '20:00:00', NULL, NULL, 'Selección de Unidades Constructivas', 'si', 'si');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (58, 1, 11, 3, 'Registro de Mejoras', 'AF_AF_PROC', 'f_taf_activo_fijo_proceso', 'sis_activos_fijos/vista/activo_fijo_proceso/activo_fijo_proceso__mejora.php', '15/05/2007', '20:00:00', NULL, NULL, 'Registro de Mejoras de Activos Fijos', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (59, 1, 11, 3, 'Registro de Revalorizaciones', 'AF_AF_PROC', 'f_taf_activo_fijo_proceso', 'sis_activos_fijos/vista/activo_fijo_proceso/activo_fijo_proceso__reval.php', '15/05/2007', '20:00:00', NULL, NULL, 'Registro de Revalorizaciones de Activos Fijos', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (60, 1, 11, 3, 'Registro de Bajas', 'AF_AF_PROC', 'f_taf_activo_fijo_proceso', 'sis_activos_fijos/vista/activo_fijo_proceso/activo_fijo_proceso__baja.php', '15/05/2007', '20:00:00', NULL, NULL, 'Registro de Bajas de Activos Fijos', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (61, 1, 11, 3, 'Aprobación (Mejora, Revalorización, Baja)', 'AF_AF_PROC', 'f_taf_activo_fijo_proceso', 'sis_activos_fijos/vista/activo_fijo_proceso/activo_fijo_proceso__aprobacion.php', '15/05/2007', '20:00:00', NULL, NULL, 'Aprobación de procesos aplicados sobre los Activos Fijos', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (62, 1, 11, 3, 'Depreciaciones', 'AF_DEP', 'f_af_depreciacion', 'sis_activos_fijos/vista/depreciacion/proc_depreciacion.php', '15/05/2007', '20:00:00', NULL, NULL, 'Ejecución de Depreciación de Activos Fijos', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (63, 6, 6, 2, 'Parámetros', '', NULL, NULL, '13/07/2007', '20:00:00', NULL, NULL, 'Parámetros Sistema Seguridad', 'si', 'no');

INSERT INTO "public"."tsg_metaproceso" ("id_metaproceso", "id_subsistema", "fk_id_metaproceso", "nivel", "nombre", "codigo_procedimiento", "nombre_achivo", "ruta_archivo", "fecha_registro", "hora_registro", "fecha_ultima_modificacion", "hora_ultima_modificacion", "descripcion", "visible", "habilitar_log")
VALUES 
  (64, 6, 63, 3, 'Ingreso de Parámetros Generales', 'SG_INS_PG', 'f_tsg_parametros_general', NULL, '13/07/2007', '20:00:00', NULL, NULL, NULL, 'si', 'no');
