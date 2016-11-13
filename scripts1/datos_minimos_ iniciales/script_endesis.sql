/**************************************************************************
 SISTEMA ENDESIS
***************************************************************************
 SCRIPT: 		script_endesis.sql
 DESCRIPCIÓN: 	Script que inserta los datos iniciales mínimos de la BD para el funcionamiento del sistema ENDESIS
 AUTOR: 		Rodrigo Chumacero Moscoso
 FECHA:			20-07-2007
 COMENTARIOS:	
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCIÓN:
 AUTOR:
 FECHA:

***************************************************************************/



/*###################### PARA LOGIN DE USUARIO ADMINISTRADOR ######################*/

/* TSG_LUGAR */
INSERT INTO tsg_lugar(id_lugar,fk_id_lugar,nivel,codigo,nombre,ubicacion,telefono1,telefono2,fax,observacion) VALUES(1,1,0,'CBBA','Cochabamba','Av. Ballivián No. 503 Edif. Colón','4520317','4520321', '4520317', NULL);

/* TSG_TIPO_DOC_IDENTIFICACION */
INSERT INTO tsg_tipo_doc_identificacion(id_tipo_doc_identificacion,nombre_tipo_documento,descripcion,fecha_ultima_modificacion,hora_ultima_modificacion) VALUES (1,'ci','Cédula de Identidad',NULL,NULL);

/* TSG_PERSONA */
INSERT INTO tsg_persona(id_persona,apellido_paterno,apellido_materno,nombres,fecha_nacimiento,foto_persona,doc_id,genero,casilla,telefono1,telefono2,celular1,celular2,pag_web,email1,email2,email3,fecha_ultima_modificacion,hora_ultima_modificacion,observaciones,id_tipo_doc_identificacion) VALUES(1,'administrador','administrador','administrador',NULL,NULL,NULL,'varon',NULL,NULL,NULL,NULL,NULL,NULL,'administrador@ende.bo',NULL,NULL,NULL,NULL,NULL,1);

/* TSG_USUARIO */
INSERT INTO tsg_usuario(id_usuario,id_persona,login,contrasenia,fecha_ultima_modificacion,hora_ultima_modificacion,estado_usuario,estilo_usuario,filtro_avanzado) VALUES(1,1,'administrador','administrador',NULL,NULL,'activo','ytheme-vista.css','si');

/* TSG_USUARIO_LUGAR */
INSERT INTO tsg_usuario_lugar(id_usuario_lugar,id_lugar,id_usuario) VALUES(1,1,1);

/* TPM_MONEDA */
INSERT INTO tpm_moneda(id_moneda,nombre,simbolo,estado,origen,prioridad) VALUES(1, 'Bolivianos', 'Bs.', 'activo', 'nacional', 1);
INSERT INTO tpm_moneda(id_moneda,nombre,simbolo,estado,origen,prioridad) VALUES(2, 'Dólares Americanos', 'US', 'activo', 'extranjera', 2);

/* TSG_ROL */
INSERT INTO tsg_rol(id_rol,nombre,descripcion,fecha_ultima_modificacion,hora_ultima_modificacion) VALUES(1,'Administrador del Sistema','Rol Administrador del Sistema',NULL, NULL);

/* TSG_USUARIO_ROL */
INSERT INTO tsg_usuario_rol(id_usuario_rol,id_rol,id_usuario) VALUES(1,1,1);

/* TSG_SUBSISTEMA */
INSERT INTO tsg_subsistema (id_subsistema,nombre_corto,nombre_largo,descripcion,version_desarrollo,desarrolladores,fecha_ultima_modificacion,hora_ultima_modificacion,observaciones) VALUES(1,'ENDESIS','Sistema de Información  Administrativo Financiero ENDE','Sistema de Información  Administrativo Financiero ENDE','1',NULL,NULL,NULL,NULL);
INSERT INTO tsg_subsistema (id_subsistema,nombre_corto,nombre_largo,descripcion,version_desarrollo,desarrolladores,fecha_ultima_modificacion,hora_ultima_modificacion,observaciones) VALUES(2,'ACTIF','Sistema de Activos Fijos','Sistema de administración y control de activos fijos','1',NULL,NULL,NULL,NULL);
INSERT INTO tsg_subsistema (id_subsistema,nombre_corto,nombre_largo,descripcion,version_desarrollo,desarrolladores,fecha_ultima_modificacion,hora_ultima_modificacion,observaciones) VALUES(3,'ALMIN','Sistema de Almacenes e Inventarios','Sistema de Almacenes e Inventarios','1',NULL,NULL,NULL,NULL);
INSERT INTO tsg_subsistema (id_subsistema,nombre_corto,nombre_largo,descripcion,version_desarrollo,desarrolladores,fecha_ultima_modificacion,hora_ultima_modificacion,observaciones) VALUES(4,'SICOMP','Sistema de Compras','Sistema de Compras','1',NULL,NULL,NULL,NULL);
INSERT INTO tsg_subsistema (id_subsistema,nombre_corto,nombre_largo,descripcion,version_desarrollo,desarrolladores,fecha_ultima_modificacion,hora_ultima_modificacion,observaciones) VALUES(5,'KARD','Sistema de Kardex de Personal','Sistema de Recursos Humanos para seguimiento de Kardex de Personal','1',NULL,NULL,NULL,NULL);
INSERT INTO tsg_subsistema (id_subsistema,nombre_corto,nombre_largo,descripcion,version_desarrollo,desarrolladores,fecha_ultima_modificacion,hora_ultima_modificacion,observaciones) VALUES(6,'SSS','Sistema de Seguridad','Sistema de Seguridad','1',NULL,NULL,NULL,NULL);
INSERT INTO tsg_subsistema (id_subsistema,nombre_corto,nombre_largo,descripcion,version_desarrollo,desarrolladores,fecha_ultima_modificacion,hora_ultima_modificacion,observaciones) VALUES(7,'PM','Sistema de Parámetros','Sistema de parámetros','1',NULL,NULL,NULL,NULL);
INSERT INTO tsg_subsistema (id_subsistema,nombre_corto,nombre_largo,descripcion,version_desarrollo,desarrolladores,fecha_ultima_modificacion,hora_ultima_modificacion,observaciones) VALUES(8,'SAJ','Sistema Jurídico','Sistema Jurídico','1',NULL,NULL,NULL,NULL);
INSERT INTO tsg_subsistema (id_subsistema,nombre_corto,nombre_largo,descripcion,version_desarrollo,desarrolladores,fecha_ultima_modificacion,hora_ultima_modificacion,observaciones) VALUES(9,'SCI','Sistema de Contabilidad Integrada','Sistema de Contabilidad Integrada','1',NULL,NULL,NULL,NULL);

/* TSG_ROL_METAPROCESO */
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(1, 1, 26);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(2, 1, 1);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(3, 1, 2);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(4, 1, 10);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(5, 1, 11);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(6, 1, 12);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(7, 1, 13);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(8, 1, 14);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(9, 1, 15);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(10, 1, 25);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(11, 1, 27);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(12, 1, 54);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(13, 1, 53);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(14, 1, 3);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(15, 1, 4);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(16, 1, 5);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(17, 1, 6);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(18, 1, 7);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(19, 1, 8);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(20, 1, 9);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(21, 1, 16);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(22, 1, 17);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(23, 1, 18);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(24, 1, 46);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(25, 1, 48);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(26, 1, 49);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(27, 1, 50);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(28, 1, 51);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(29, 1, 39);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(30, 1, 40);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(31, 1, 41);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(32, 1, 42);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(33, 1, 52);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(34, 1, 19);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(35, 1, 38);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(36, 1, 20);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(37, 1, 21);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(38, 1, 22);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(39, 1, 43);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(40, 1, 44);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(41, 1, 29);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(42, 1, 30);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(43, 1, 31);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(44, 1, 32);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(45, 1, 33);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(46, 1, 34);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(47, 1, 47);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(48, 1, 28);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(49, 1, 45);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(50, 1, 35);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(51, 1, 36);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(52, 1, 37);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(53, 1, 55);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(54, 1, 56);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(55, 1, 57);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(56, 1, 23);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(57, 1, 24);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(58, 1, 58);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(59, 1, 59);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(60, 1, 60);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(61, 1, 61);
INSERT INTO tsg_rol_metaproceso(id_rol_metaproceso,id_rol,id_metaproceso) VALUES(62, 1, 62);

/*#################################################################################*/


/*###################### ACTIVOS FIJOS ######################*/

/* TAF_PARAM_GRAL */
INSERT INTO taf_param_gral(id_param_gral,id_moneda) VALUES(1,2);

/* TAF_PROCESO */
INSERT INTO taf_proceso(id_proceso,descripcion,flag_comprobante,tipo_comprobante) VALUES(1,'Alta','no',NULL);
INSERT INTO taf_proceso(id_proceso,descripcion,flag_comprobante,tipo_comprobante) VALUES(2,'Mejora','no',NULL);
INSERT INTO taf_proceso(id_proceso,descripcion,flag_comprobante,tipo_comprobante) VALUES(3,'Revalorización','no',NULL);
INSERT INTO taf_proceso(id_proceso,descripcion,flag_comprobante,tipo_comprobante) VALUES(4,'Baja','no',NULL);

/* TAF_METODO_DEPRECIACION */
INSERT INTO taf_metodo_depreciacion(id_metodo_depreciacion,descripcion) VALUES(1,'Depreciación Lineal');
INSERT INTO taf_metodo_depreciacion(id_metodo_depreciacion,descripcion) VALUES(2,'Depreciación por unidades de producción');

/* TAF_PROCESO_MOTIVO */
INSERT INTO taf_proceso_motivo(id_motivo,descripcion,id_proceso) VALUES(1,'Por robo',4);

/*################################################################*/
