<<<<<<< HEAD
-- tal_almacen
=======
-- tal_almacen 
>>>>>>> a5afe13a0081bb0c2f7d8fa68b61984216732d4b

INSERT INTO alma.tal_almacen ("id_almacen", "codigo", "nombre", "direccion", "estado", "tipo_control", "id_lugar", "id_depto", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (1, E'ALMCB1', E'Almacen Central', E'El prado #455 plaza colon', E'activo', E'valorado', 2, 47, 177, 177, E'2013-09-16 11:14:23', E'2013-09-16 16:21:01');

INSERT INTO alma.tal_almacen ("id_almacen", "codigo", "nombre", "direccion", "estado", "tipo_control", "id_lugar", "id_depto", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (2, E'ALMSC1', E'Almacen Santa Cruz 1', E'Av. Juan de la Rosa 466', E'activo', E'valorado', 63, 48, 177, 177, E'2013-09-16 11:17:40', E'2013-09-16 16:23:26');

INSERT INTO alma.tal_almacen ("id_almacen", "codigo", "nombre", "direccion", "estado", "tipo_control", "id_lugar", "id_depto", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (3, E'ALMCB2', E'Almacen central fisico', E'Av. Ballivian #455 plaza Colon', E'activo', E'fisico', 2, 47, 177, 177, E'2013-09-16 11:19:08', E'2013-09-16 16:23:18');


ALTER SEQUENCE alma.tal_almacen_id_almacen_seq RESTART 4;

-- tal_clasificacion

INSERT INTO alma.tal_clasificacion ("id_clasificacion", "codigo", "codigo_largo", "nombre", "estado", "id_clasificacion_fk", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (1, E'COMPU', E'COMPU', E'Equipos de computacion', E'activo', NULL, 177, NULL, E'2013-09-16 11:48:18.698', NULL);

INSERT INTO alma.tal_clasificacion ("id_clasificacion", "codigo", "codigo_largo", "nombre", "estado", "id_clasificacion_fk", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (2, E'ELEC', E'ELEC', E'Equipos electrico', E'activo', NULL, 177, NULL, E'2013-09-16 11:55:31.498', NULL);

INSERT INTO alma.tal_clasificacion ("id_clasificacion", "codigo", "codigo_largo", "nombre", "estado", "id_clasificacion_fk", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (3, E'OFI', E'OFI', E'Material de oficina', E'activo', NULL, 177, NULL, E'2013-09-16 11:55:55.945', NULL);

INSERT INTO alma.tal_clasificacion ("id_clasificacion", "codigo", "codigo_largo", "nombre", "estado", "id_clasificacion_fk", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (4, E'COM1', E'COMPU.COM1', E'Computadora portatil', E'activo', 1, 177, NULL, E'2013-09-16 11:57:06.059', NULL);

INSERT INTO alma.tal_clasificacion ("id_clasificacion", "codigo", "codigo_largo", "nombre", "estado", "id_clasificacion_fk", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (5, E'COM2', E'COMPU.COM2', E'Computadora de Escritorio', E'activo', 1, 177, NULL, E'2013-09-16 11:57:21.594', NULL);

INSERT INTO alma.tal_clasificacion ("id_clasificacion", "codigo", "codigo_largo", "nombre", "estado", "id_clasificacion_fk", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (6, E'ELEC1', E'ELEC.ELEC1', E'Cables de alta tension', E'activo', 2, 177, NULL, E'2013-09-16 11:57:41.782', NULL);

INSERT INTO alma.tal_clasificacion ("id_clasificacion", "codigo", "codigo_largo", "nombre", "estado", "id_clasificacion_fk", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (7, E'ELEC2', E'ELEC.ELEC2', E'Transformadores', E'activo', 2, 177, NULL, E'2013-09-16 11:58:00.981', NULL);

INSERT INTO alma.tal_clasificacion ("id_clasificacion", "codigo", "codigo_largo", "nombre", "estado", "id_clasificacion_fk", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (8, E'OFI', E'OFI.OFI', E'Papaeleria', E'activo', 3, 177, NULL, E'2013-09-16 11:58:33.337', NULL);

ALTER SEQUENCE alma.tal_clasificacion_id_clasificacion_seq RESTART 9;

-- tal_item

INSERT INTO alma.tal_item ("id_item", "id_clasificacion", "codigo", "nombre", "descripcion", "codigo_fabrica", "id_unidad_medida", "num_por_clasificacion", "bajo_responsabilidad", "estado", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "metodo_valoracion")
VALUES (1, 4, E'COMPU.COM1.1', E'Laptop Dell Latitude E6430', E'15 pulgadas Core i7 Windows 7', E'456789', 21, 1, E'si', E'activo', 177, NULL, E'2013-09-16 12:23:08', NULL, E'PP');

INSERT INTO alma.tal_item ("id_item", "id_clasificacion", "codigo", "nombre", "descripcion", "codigo_fabrica", "id_unidad_medida", "num_por_clasificacion", "bajo_responsabilidad", "estado", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "metodo_valoracion")
VALUES (2, 4, E'COMPU.COM1.2', E'Toshiba Maximum 54345', E'15 pulgadas, 4kg. Core i3 Windows 7 HDD: 1Tb Memoria Ram 4Gb', E'65432', 21, 2, E'no', E'activo', 177, NULL, E'2013-09-16 12:31:07', NULL, E'PP');

INSERT INTO alma.tal_item ("id_item", "id_clasificacion", "codigo", "nombre", "descripcion", "codigo_fabrica", "id_unidad_medida", "num_por_clasificacion", "bajo_responsabilidad", "estado", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "metodo_valoracion")
VALUES (3, 6, E'ELEC.ELEC1.1', E'Cable M44', E'Cable para alta tencion categoria z35', E'213', 17, 1, E'no', E'activo', 177, NULL, E'2013-09-16 15:17:18', NULL, E'PP');

INSERT INTO alma.tal_item ("id_item", "id_clasificacion", "codigo", "nombre", "descripcion", "codigo_fabrica", "id_unidad_medida", "num_por_clasificacion", "bajo_responsabilidad", "estado", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "metodo_valoracion")
VALUES (4, 6, E'ELEC.ELEC1.2', E'Cable de alta tension M47', E'Rollo de cable de alta tension 100mts categoria z40', E'43567', 17, 2, E'no', E'activo', 177, NULL, E'2013-09-16 15:18:12', NULL, E'PP');

INSERT INTO alma.tal_item ("id_item", "id_clasificacion", "codigo", "nombre", "descripcion", "codigo_fabrica", "id_unidad_medida", "num_por_clasificacion", "bajo_responsabilidad", "estado", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "metodo_valoracion")
VALUES (5, 7, E'ELEC.ELEC2.1', E'Transformador A-M f354', E'Transformador de alta tension a media tension f354 10000wtz', E'34567', 21, 1, E'si', E'inactivo', 177, NULL, E'2013-09-16 15:19:46', NULL, E'PP');

INSERT INTO alma.tal_item ("id_item", "id_clasificacion", "codigo", "nombre", "descripcion", "codigo_fabrica", "id_unidad_medida", "num_por_clasificacion", "bajo_responsabilidad", "estado", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "metodo_valoracion")
VALUES (6, 7, E'ELEC.ELEC2.2', E'Transofomadro M-B f455', E'Transformador de Media a Baja tension 1100 wtz 110 - 230v ', E'76543', 21, 2, E'si', E'activo', 177, NULL, E'2013-09-16 15:26:35', NULL, E'PP');

INSERT INTO alma.tal_item ("id_item", "id_clasificacion", "codigo", "nombre", "descripcion", "codigo_fabrica", "id_unidad_medida", "num_por_clasificacion", "bajo_responsabilidad", "estado", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "metodo_valoracion")
VALUES (7, 8, E'OFI.OFI.1', E'Papel bond carta 50g', E'Paquete de papel bond tamaño carta', E'6543', 12, 1, E'no', E'activo', 177, NULL, E'2013-09-16 15:44:34', NULL, E'PP');

INSERT INTO alma.tal_item ("id_item", "id_clasificacion", "codigo", "nombre", "descripcion", "codigo_fabrica", "id_unidad_medida", "num_por_clasificacion", "bajo_responsabilidad", "estado", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "metodo_valoracion")
VALUES (8, 8, E'OFI.OFI.2', E'Hojas papel bond officio 90g', E'Paquete de hojas papel bond blanco tamano oficio de 90g', E'2566', 12, 2, E'no', E'activo', 177, NULL, E'2013-09-16 15:45:43', NULL, E'PP');

INSERT INTO alma.tal_item ("id_item", "id_clasificacion", "codigo", "nombre", "descripcion", "codigo_fabrica", "id_unidad_medida", "num_por_clasificacion", "bajo_responsabilidad", "estado", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "metodo_valoracion")
VALUES (9, 5, E'COMPU.COM2.1', E'Case Combo Delux F654h', E'Case Combo Delux F654h', NULL, 21, 1, E'si', E'activo', 177, NULL, E'2013-10-04 11:49:38', NULL, E'PP');

ALTER SEQUENCE alma.tal_item_id_item_seq RESTART 10;

-- tal_tipo_movimiento

INSERT INTO alma.tal_tipo_movimiento ("id_tipo_movimiento", "id_documento", "tipo", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (1, 118, E'ingreso', 177, NULL, E'2013-09-17 10:29:12', NULL);

INSERT INTO alma.tal_tipo_movimiento ("id_tipo_movimiento", "id_documento", "tipo", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (2, 119, E'ingreso', 177, NULL, E'2013-09-17 10:29:30', NULL);

INSERT INTO alma.tal_tipo_movimiento ("id_tipo_movimiento", "id_documento", "tipo", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (3, 120, E'salida', 177, NULL, E'2013-09-17 10:29:51', NULL);

INSERT INTO alma.tal_tipo_movimiento ("id_tipo_movimiento", "id_documento", "tipo", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (4, 121, E'salida', 177, NULL, E'2013-09-17 10:30:07', NULL);

ALTER SEQUENCE alma.tal_tipo_movimiento_id_tipo_movimiento_seq RESTART 5;




/* Data for the 'alma.tal_solicitud_salida' table  (Records 1 - 6) */

INSERT INTO alma.tal_solicitud_salida ("id_solicitud_salida", "id_almacen", "id_unidad_organizacional", "id_empleado", "cargo_empleado", "id_aprobador", "cargo_aprobador", "fecha_solicitud", "descripcion", "estado", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (1, 1, 632, 618, E'cargo de prueba', 22, E'cargo de prueba', E'2013-10-05 00:00:00', E'Sin observaciones', E'borrador', 177, NULL, E'2013-10-04 11:23:17.710', NULL);

INSERT INTO alma.tal_solicitud_salida ("id_solicitud_salida", "id_almacen", "id_unidad_organizacional", "id_empleado", "cargo_empleado", "id_aprobador", "cargo_aprobador", "fecha_solicitud", "descripcion", "estado", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (2, 1, 613, 461, E'cargo de prueba', 24, E'cargo de prueba', E'2013-10-16 00:00:00', E'ninguno', E'borrador', 177, NULL, E'2013-10-04 11:24:06.422', NULL);

INSERT INTO alma.tal_solicitud_salida ("id_solicitud_salida", "id_almacen", "id_unidad_organizacional", "id_empleado", "cargo_empleado", "id_aprobador", "cargo_aprobador", "fecha_solicitud", "descripcion", "estado", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (3, 1, 742, 460, E'cargo de prueba', 25, E'cargo de prueba', E'2013-10-15 00:00:00', E'solo retrasos', E'borrador', 177, NULL, E'2013-10-04 11:24:22.687', NULL);

INSERT INTO alma.tal_solicitud_salida ("id_solicitud_salida", "id_almacen", "id_unidad_organizacional", "id_empleado", "cargo_empleado", "id_aprobador", "cargo_aprobador", "fecha_solicitud", "descripcion", "estado", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (4, 1, 670, 461, E'cargo de prueba', 55, E'cargo de prueba', E'2013-10-18 00:00:00', E'sin ninguna observacion', E'pendiente_aprobacion', 177, NULL, E'2013-10-04 11:24:43.603', NULL);

INSERT INTO alma.tal_solicitud_salida ("id_solicitud_salida", "id_almacen", "id_unidad_organizacional", "id_empleado", "cargo_empleado", "id_aprobador", "cargo_aprobador", "fecha_solicitud", "descripcion", "estado", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (5, 1, 741, 588, E'cargo de prueba', 22, E'cargo de prueba', E'2013-10-20 00:00:00', E'No hay observaciones', E'pendiente_aprobacion', 177, NULL, E'2013-10-04 11:25:09.713', NULL);

INSERT INTO alma.tal_solicitud_salida ("id_solicitud_salida", "id_almacen", "id_unidad_organizacional", "id_empleado", "cargo_empleado", "id_aprobador", "cargo_aprobador", "fecha_solicitud", "descripcion", "estado", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (6, 1, 603, 6, E'cargo de prueba', 60, E'cargo de prueba', E'2013-10-22 00:00:00', E'No hay observaciones', E'pendiente_aprobacion', 177, NULL, E'2013-10-04 11:25:55.725', NULL);

ALTER SEQUENCE alma.tal_solicitud_salida_id_solicitud_salida_seq RESTART 7;



/* Data for the 'alma.tal_detalle_solicitud' table  (Records 1 - 4) */

INSERT INTO alma.tal_detalle_solicitud ("id_detalle_solicitud", "id_solicitud_salida", "id_item", "cantidad", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (1, 4, 2, '78', 177, NULL, E'2013-10-04 11:26:47', NULL);

INSERT INTO alma.tal_detalle_solicitud ("id_detalle_solicitud", "id_solicitud_salida", "id_item", "cantidad", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (2, 4, 4, '3', 177, NULL, E'2013-10-04 11:26:54', NULL);

INSERT INTO alma.tal_detalle_solicitud ("id_detalle_solicitud", "id_solicitud_salida", "id_item", "cantidad", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (3, 5, 7, '12', 177, NULL, E'2013-10-04 11:27:02', NULL);

INSERT INTO alma.tal_detalle_solicitud ("id_detalle_solicitud", "id_solicitud_salida", "id_item", "cantidad", "id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod")
VALUES (4, 6, 4, '45', 177, NULL, E'2013-10-04 11:27:11', NULL);

ALTER SEQUENCE alma.tal_detalle_solicitud_id_detalle_solicitud_seq RESTART 5;
