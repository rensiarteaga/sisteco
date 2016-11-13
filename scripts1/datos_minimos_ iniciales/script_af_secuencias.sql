/**************************************************************************
 SISTEMA ENDESIS
***************************************************************************
 SCRIPT: 		script_af_secuencias.sql
 DESCRIPCIÓN: 	Script de creación de las secuencias del sistema de Activos Fijos
 AUTOR: 		Rodrigo Chumacero Moscoso
 FECHA:			20-07-2007
 COMENTARIOS:	
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCIÓN:
 AUTOR:
 FECHA:

***************************************************************************/

CREATE SEQUENCE "public"."taf_activo_fijo_id_activo_fijo_seq"
MAXVALUE 2147483647;

ALTER TABLE "public"."taf_activo_fijo"
  ALTER COLUMN "id_activo_fijo" TYPE INTEGER;

ALTER TABLE "public"."taf_activo_fijo"
  ALTER COLUMN "id_activo_fijo" SET DEFAULT nextval('"public"."taf_activo_fijo_id_activo_fijo_seq"'::text);



CREATE SEQUENCE "public"."taf_activo_fijo_caracteristicas_id_activo_fijo_caracteristicas_seq"
MAXVALUE 2147483647;

ALTER TABLE "public"."taf_activo_fijo_caracteristicas"
  ALTER COLUMN "id_activo_fijo_caracteristicas" TYPE INTEGER;

ALTER TABLE "public"."taf_activo_fijo_caracteristicas"
  ALTER COLUMN "id_activo_fijo_caracteristicas" SET DEFAULT nextval('"public"."taf_activo_fijo_caracteristicas_id_activo_fijo_caracteristicas_seq"'::text);



CREATE SEQUENCE "public"."taf_activo_fijo_comp_caract_id_activo_fijo_comp_caract_seq"
MAXVALUE 2147483647;

ALTER TABLE "public"."taf_activo_fijo_comp_caract"
  ALTER COLUMN "id_activo_fijo_comp_caract" TYPE INTEGER;

ALTER TABLE "public"."taf_activo_fijo_comp_caract"
  ALTER COLUMN "id_activo_fijo_comp_caract" SET DEFAULT nextval('"public"."taf_activo_fijo_comp_caract_id_activo_fijo_comp_caract_seq"'::text);



CREATE SEQUENCE "public"."taf_activo_fijo_componentes_id_componente_seq"
MAXVALUE 2147483647;

ALTER TABLE "public"."taf_activo_fijo_componentes"
  ALTER COLUMN "id_componente" TYPE INTEGER;

ALTER TABLE "public"."taf_activo_fijo_componentes"
  ALTER COLUMN "id_componente" SET DEFAULT nextval('"public"."taf_activo_fijo_componentes_id_componente_seq"'::text);



CREATE SEQUENCE "public"."taf_activo_fijo_empleado_id_activo_fijo_empleado_seq"
MAXVALUE 2147483647;

ALTER TABLE "public"."taf_activo_fijo_empleado"
  ALTER COLUMN "id_activo_fijo_empleado" TYPE INTEGER;

ALTER TABLE "public"."taf_activo_fijo_empleado"
  ALTER COLUMN "id_activo_fijo_empleado" SET DEFAULT nextval('"public"."taf_activo_fijo_empleado_id_activo_fijo_empleado_seq"'::text);



CREATE SEQUENCE "public"."taf_activo_fijo_proceso_id_activo_fijo_proceso_seq"
MAXVALUE 2147483647;

ALTER TABLE "public"."taf_activo_fijo_proceso"
  ALTER COLUMN "id_activo_fijo_proceso" TYPE INTEGER;

ALTER TABLE "public"."taf_activo_fijo_proceso"
  ALTER COLUMN "id_activo_fijo_proceso" SET DEFAULT nextval('"public"."taf_activo_fijo_proceso_id_activo_fijo_proceso_seq"'::text);



CREATE SEQUENCE "public"."taf_activo_fijo_tiempo_prod_id_activo_fijo_tiempo_prod_seq"
MAXVALUE 2147483647;

ALTER TABLE "public"."taf_activo_fijo_tiempo_prod"
  ALTER COLUMN "id_activo_fijo_tiempo_prod" TYPE INTEGER;

ALTER TABLE "public"."taf_activo_fijo_tiempo_prod"
  ALTER COLUMN "id_activo_fijo_tiempo_prod" SET DEFAULT nextval('"public"."taf_activo_fijo_tiempo_prod_id_activo_fijo_tiempo_prod_seq"'::text);



CREATE SEQUENCE "public"."taf_activo_fijo_tpm_frppa_id_activo_fijo_frppa_seq"
MAXVALUE 2147483647;

ALTER TABLE "public"."taf_activo_fijo_tpm_frppa"
  ALTER COLUMN "id_activo_fijo_frppa" TYPE INTEGER;

ALTER TABLE "public"."taf_activo_fijo_tpm_frppa"
  ALTER COLUMN "id_activo_fijo_frppa" SET DEFAULT nextval('"public"."taf_activo_fijo_tpm_frppa_id_activo_fijo_frppa_seq"'::text);



CREATE SEQUENCE "public"."taf_caracteristicas_id_caracteristica_seq"
MAXVALUE 2147483647;

ALTER TABLE "public"."taf_caracteristicas"
  ALTER COLUMN "id_caracteristica" TYPE INTEGER;

ALTER TABLE "public"."taf_caracteristicas"
  ALTER COLUMN "id_caracteristica" SET DEFAULT nextval('"public"."taf_caracteristicas_id_caracteristica_seq"'::text);



CREATE SEQUENCE "public"."taf_depreciacion_id_depreciacion_seq";

ALTER TABLE "public"."taf_depreciacion"
  ALTER COLUMN "id_depreciacion" TYPE BIGINT;

ALTER TABLE "public"."taf_depreciacion"
  ALTER COLUMN "id_depreciacion" SET DEFAULT nextval('"public"."taf_depreciacion_id_depreciacion_seq"'::text);



CREATE SEQUENCE "public"."taf_metodo_depreciacion_id_metodo_depreciacion_seq"
MAXVALUE 2147483647;

ALTER TABLE "public"."taf_metodo_depreciacion"
  ALTER COLUMN "id_metodo_depreciacion" TYPE INTEGER;

ALTER TABLE "public"."taf_metodo_depreciacion"
  ALTER COLUMN "id_metodo_depreciacion" SET DEFAULT nextval('"public"."taf_metodo_depreciacion_id_metodo_depreciacion_seq"'::text);



CREATE SEQUENCE "public"."taf_param_gral_id_param_gral_seq"
MAXVALUE 2147483647;

ALTER TABLE "public"."taf_param_gral"
  ALTER COLUMN "id_param_gral" TYPE INTEGER;

ALTER TABLE "public"."taf_param_gral"
  ALTER COLUMN "id_param_gral" SET DEFAULT nextval('"public"."taf_param_gral_id_param_gral_seq"'::text);



CREATE SEQUENCE "public"."taf_proceso_id_proceso_seq"
MAXVALUE 2147483647;

ALTER TABLE "public"."taf_proceso"
  ALTER COLUMN "id_proceso" TYPE INTEGER;

ALTER TABLE "public"."taf_proceso"
  ALTER COLUMN "id_proceso" SET DEFAULT nextval('"public"."taf_proceso_id_proceso_seq"'::text);



CREATE SEQUENCE "public"."taf_proceso_motivo_id_motivo_seq"
MAXVALUE 2147483647;

ALTER TABLE "public"."taf_proceso_motivo"
  ALTER COLUMN "id_motivo" TYPE INTEGER;

ALTER TABLE "public"."taf_proceso_motivo"
  ALTER COLUMN "id_motivo" SET DEFAULT nextval('"public"."taf_proceso_motivo_id_motivo_seq"'::text);



CREATE SEQUENCE "public"."taf_reparacion_id_reparacion_seq"
MAXVALUE 2147483647;

ALTER TABLE "public"."taf_reparacion"
  ALTER COLUMN "id_reparacion" TYPE INTEGER;

ALTER TABLE "public"."taf_reparacion"
  ALTER COLUMN "id_reparacion" SET DEFAULT nextval('"public"."taf_reparacion_id_reparacion_seq"'::text);



CREATE SEQUENCE "public"."taf_sub_tipo_activo_id_sub_tipo_activo_seq"
MAXVALUE 2147483647;

ALTER TABLE "public"."taf_sub_tipo_activo"
  ALTER COLUMN "id_sub_tipo_activo" TYPE INTEGER;

ALTER TABLE "public"."taf_sub_tipo_activo"
  ALTER COLUMN "id_sub_tipo_activo" SET DEFAULT nextval('"public"."taf_sub_tipo_activo_id_sub_tipo_activo_seq"'::text);



CREATE SEQUENCE "public"."taf_tipo_activo_id_tipo_activo_seq"
MAXVALUE 2147483647;

ALTER TABLE "public"."taf_tipo_activo"
  ALTER COLUMN "id_tipo_activo" TYPE INTEGER;

ALTER TABLE "public"."taf_tipo_activo"
  ALTER COLUMN "id_tipo_activo" SET DEFAULT nextval('"public"."taf_tipo_activo_id_tipo_activo_seq"'::text);



CREATE SEQUENCE "public"."taf_tipo_activo_proceso_id_tipo_activo_proceso_seq"
MAXVALUE 2147483647;

ALTER TABLE "public"."taf_tipo_activo_proceso"
  ALTER COLUMN "id_tipo_activo_proceso" TYPE INTEGER;

ALTER TABLE "public"."taf_tipo_activo_proceso"
  ALTER COLUMN "id_tipo_activo_proceso" SET DEFAULT nextval('"public"."taf_tipo_activo_proceso_id_tipo_activo_proceso_seq"'::text);



CREATE SEQUENCE "public"."taf_unidad_constructiva_id_unidad_constructiva_seq"
MAXVALUE 2147483647;

ALTER TABLE "public"."taf_unidad_constructiva"
  ALTER COLUMN "id_unidad_constructiva" TYPE INTEGER;

ALTER TABLE "public"."taf_unidad_constructiva"
  ALTER COLUMN "id_unidad_constructiva" SET DEFAULT nextval('"public"."taf_unidad_constructiva_id_unidad_constructiva_seq"'::text);