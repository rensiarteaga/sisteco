-- tpm_depto

INSERT INTO param.tpm_depto ("id_depto", "codigo_depto", "nombre_depto", "estado", "id_subsistema", "despliegue_rep", "id_lugar", "id_tipo_proceso", "codificacion")
VALUES (47, E'ALMCBA', E'Departamento de Almacenes Cochabamba', E'activo', 43, NULL, 2, NULL, E'normal');

INSERT INTO param.tpm_depto ("id_depto", "codigo_depto", "nombre_depto", "estado", "id_subsistema", "despliegue_rep", "id_lugar", "id_tipo_proceso", "codificacion")
VALUES (48, E'ALMSC', E'Departamento de Almacenes Santa Cruz', E'activo', 43, NULL, 63, NULL, E'normal');

ALTER SEQUENCE param.tpm_depto_id_depto_seq RESTART 49;

-- tpm_documento

INSERT INTO param.tpm_documento ("id_documento", "codigo", "descripcion", "documento", "prefijo", "sufijo", "estado", "id_subsistema", "num_firma", "tipo_numeracion", "id_tipo_proceso", "tipo")
VALUES (118, E'ICOM', E'Documento de Ingreso por compra para el control de almacenes.', E'Ingreso por compra', NULL, NULL, E'activo', 43, 1, E'depto', NULL, NULL);

INSERT INTO param.tpm_documento ("id_documento", "codigo", "descripcion", "documento", "prefijo", "sufijo", "estado", "id_subsistema", "num_firma", "tipo_numeracion", "id_tipo_proceso", "tipo")
VALUES (119, E'INVINI', E'Documento de Inventario inicial del sistema', E'INVENTARIO INICIAL', NULL, NULL, E'activo', 43, 1, E'depto', NULL, NULL);

INSERT INTO param.tpm_documento ("id_documento", "codigo", "descripcion", "documento", "prefijo", "sufijo", "estado", "id_subsistema", "num_firma", "tipo_numeracion", "id_tipo_proceso", "tipo")
VALUES (120, E'SSOL', E'Documento de salida por solicitud aprobada.', E'Salida por solicitud aprobada', NULL, NULL, E'activo', 43, 1, E'depto', NULL, NULL);

INSERT INTO param.tpm_documento ("id_documento", "codigo", "descripcion", "documento", "prefijo", "sufijo", "estado", "id_subsistema", "num_firma", "tipo_numeracion", "id_tipo_proceso", "tipo")
VALUES (121, E'SNORM', E'Documento de salida normal', E'Salida normal', NULL, NULL, E'activo', 43, 1, E'depto', NULL, NULL);