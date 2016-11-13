<?php
/**
**********************************************************
Nombre de archivo:	ActionListaPermiso.php
Propósito:			Permite desplegar los permisos asignados a un usuario
Tabla:				tsg_metaproceso
Parámetros:			$cant
					$puntero
					$sortcol
					$sortdir
					$criterio_filtro
					$id_usuario_asignacion

Valores de Retorno:    	Listado de Permisos para el usuario
Fecha de Creación:		08 - 06 - 07
Versión:				2.0.0
Autor:					ensi Arteaga Copari				
**********************************************************
*/
session_start();
if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI"){
  echo "[
 {
 	'text':'Seguridad (SSS)','nombre':'Seguridad (SSS)',
 	'id':'24',
 	'ruta':null,
 	'leaf':false,
 	'allowDelete':false,
 	'allowEdit':false,
 	'allowDrag':false,
 	'icon':'..\/..\/..\/lib\/imagenes\/seguridad3.png',
 	'tipo':'raiz',
 	'children':[
 	    {
 	    	'text':'Usuario',
 	    	'nombre':'Usuario',
 	    	'id':'25',
 	    	'ruta':'',
 	    	'allowDelete':false,
 	    	'allowEdit':false,
 	    	'allowDrag':false,
 	    	'tipo':'rama',
 	    	'leaf':false,
 	    	'cls':'folder',
 	    	'children':[{'text':'Usuarios','nombre':'Usuarios','id':'33','ruta':'sis_seguridad\/vista\/usuario\/usuario.php','allowDelete':false,'allowEdit':false,'allowDrag':false,'tipo':'hoja','leaf':true,'icon':'..\/..\/..\/lib\/imagenes\/a_form.png'}]
 	    },
 	    {
 	    	'text':'Roles',
 	    	'nombre':'Roles',
 	    	'id':'40',
 	    	'ruta':'',
 	    	'allowDelete':false,
 	    	'allowEdit':false,
 	    	'allowDrag':false,
 	    	'tipo':'rama',
 	    	'leaf':false,
 	    	'cls':'folder',
 	    	'children':[{'text':'Rol','nombre':'Rol','id':'30','ruta':'\/lib\/ext2\/examples\/tree\/column-tree.html','allowDelete':false,'allowEdit':false,'allowDrag':false,'tipo':'hoja','leaf':true,'icon':'..\/..\/..\/lib\/imagenes\/a_form.png'},
 	    	{'text':'Asignaci\u00f3n Estructura','nombre':'Asignaci\u00f3n Estructura','id':'45','ruta':'lib\/ext2\/examples\/tree\/reorder.html','allowDelete':false,'allowEdit':false,'allowDrag':false,'tipo':'hoja','leaf':true,'icon':'..\/..\/..\/lib\/imagenes\/a_form.png'},{'text':'Envio Alerta','nombre':'Envio Alerta','id':'46','ruta':'lib\/ext2\/examples\/','allowDelete':false,'allowEdit':false,'allowDrag':false,'tipo':'hoja','leaf':true,'icon':'..\/..\/..\/lib\/imagenes\/a_form.png'},{'text':'Lugar','nombre':'Lugar','id':'48','ruta':'lib\/ext2\/examples\/','allowDelete':false,'allowEdit':false,'allowDrag':false,'tipo':'hoja','leaf':true,'icon':'..\/..\/..\/lib\/imagenes\/a_form.png'}]},
	{
		'text':'Par\u00e1metros Sistema',
		'nombre':'Par\u00e1metros Sistema',
		'id':'41',
		'ruta':'',
		'allowDelete':false,
		'allowEdit':false,
		'allowDrag':false,
		'tipo':'rama',
		'leaf':false,
		'cls':'folder',
		'children':[{'text':'Tipo de Documento de Identificaci\u00f3n','nombre':'Tipo de Documento de Identificaci\u00f3n','id':'49','ruta':'sis_seguridad\/vista\/tipo_doc_identificacion\/tipo_doc_identificacion.php','allowDelete':false,'allowEdit':false,'allowDrag':false,'tipo':'hoja','leaf':true,'icon':'..\/..\/..\/lib\/imagenes\/a_form.png'},{'text':'Preferencia del Usuario','nombre':'Preferencia del Usuario','id':'27','ruta':'sis_seguridad\/vista\/preferencia\/preferencia.php','allowDelete':false,'allowEdit':false,'allowDrag':false,'tipo':'hoja','leaf':true,'icon':'..\/..\/..\/lib\/imagenes\/a_form.png'},{'text':'Parametro General','nombre':'Parametro General','id':'34','ruta':'sis_seguridad\/vista\/parametro_general\/parametro_general.php','allowDelete':false,'allowEdit':false,'allowDrag':false,'tipo':'hoja','leaf':true,'icon':'..\/..\/..\/lib\/imagenes\/a_form.png'},{'text':'Log del Sistema','nombre':'Log del Sistema','id':'36','ruta':'sis_seguridad\/vista\/registro_evento\/registro_evento.php','allowDelete':false,'allowEdit':false,'allowDrag':false,'tipo':'hoja','leaf':true,'icon':'..\/..\/..\/lib\/imagenes\/a_form.png'},{'text':'Subsistema','nombre':'Subsistema','id':'37','ruta':'sis_seguridad\/vista\/subsistema\/subsistema.php','allowDelete':false,'allowEdit':false,'allowDrag':false,'tipo':'hoja','leaf':true,'icon':'..\/..\/..\/lib\/imagenes\/a_form.png'},{'text':'Persona','nombre':'Persona','id':'39','ruta':'sis_seguridad\/vista\/persona\/persona.php','allowDelete':false,'allowEdit':false,'allowDrag':false,'tipo':'hoja','leaf':true,'icon':'..\/..\/..\/lib\/imagenes\/a_form.png'},{'text':'Tareas Pendientes','nombre':'Tareas Pendientes','id':'50','ruta':'sis_seguridad\/vista\/tarea_pendiente\/tarea_pendiente.php','allowDelete':false,'allowEdit':false,'allowDrag':false,'tipo':'hoja','leaf':true,'icon':'..\/..\/..\/lib\/imagenes\/a_form.png'},{'text':'Persona_foto','nombre':'Persona_foto','id':'51','ruta':'sis_seguridad\/vista\/persona1\/persona.php','allowDelete':false,'allowEdit':false,'allowDrag':false,'tipo':'hoja','leaf':true,'icon':'..\/..\/..\/lib\/imagenes\/a_form.png'}]}
	
	]
 },
 {
 	'text':'Par\u00e1metros Generales (PARAM)',
 	'nombre':'Par\u00e1metros Generales (PARAM)',
 	'id':'2',
 	'ruta':null,
 	'leaf':false,
 	'allowDelete':false,
 	'allowEdit':false,
 	'allowDrag':false,
 	'icon':'..\/..\/..\/lib\/imagenes\/parametros3.png',
 	'tipo':'raiz',
 	 	'children':[
 	    {
 	    	'text':'Usuario',
 	    	'nombre':'Usuario',
 	    	'id':'25',
 	    	'ruta':'',
 	    	'allowDelete':false,
 	    	'allowEdit':false,
 	    	'allowDrag':false,
 	    	'tipo':'rama',
 	    	'leaf':false,
 	    	'cls':'folder',
 	    	'children':[{'text':'Usuarios','nombre':'Usuarios','id':'33','ruta':'sis_seguridad\/vista\/usuario\/usuario.php','allowDelete':false,'allowEdit':false,'allowDrag':false,'tipo':'hoja','leaf':true,'icon':'..\/..\/..\/lib\/imagenes\/a_form.png'}]},
 	    {
 	    	'text':'Roles',
 	    	'nombre':'Roles',
 	    	'id':'40',
 	    	'ruta':'',
 	    	'allowDelete':false,
 	    	'allowEdit':false,
 	    	'allowDrag':false,
 	    	'tipo':'rama',
 	    	'leaf':false,
 	    	'cls':'folder',
 	    	'children':[{'text':'Rol','nombre':'Rol','id':'30','ruta':'sis_seguridad\/vista\/rol\/rol.php','allowDelete':false,'allowEdit':false,'allowDrag':false,'tipo':'hoja','leaf':true,'icon':'..\/..\/..\/lib\/imagenes\/a_form.png'}]},
	{
		'text':'Par\u00e1metros Sistema',
		'nombre':'Par\u00e1metros Sistema',
		'id':'41',
		'ruta':'',
		'allowDelete':false,
		'allowEdit':false,
		'allowDrag':false,
		'tipo':'rama',
		'leaf':false,
		'cls':'folder',
		'children':[{'text':'Tipo de Documento de Identificaci\u00f3n','nombre':'Tipo de Documento de Identificaci\u00f3n','id':'49','ruta':'sis_seguridad\/vista\/tipo_doc_identificacion\/tipo_doc_identificacion.php','allowDelete':false,'allowEdit':false,'allowDrag':false,'tipo':'hoja','leaf':true,'icon':'..\/..\/..\/lib\/imagenes\/a_form.png'}]}
	
	]
 },
 {
 	'text':'Facturaci\u00f3n y Ventas (FACTUR)',
 	'nombre':'Facturaci\u00f3n y Ventas (FACTUR)',
 	'id':'75',
 	'ruta':'',
 	'leaf':false,
 	'allowDelete':false,
 	'allowEdit':false,
 	'allowDrag':false,
 	'icon':'..\/..\/..\/lib\/imagenes\/factur.png',
 	'tipo':'raiz',
 	'children':[]
 },
 {
 	'text':'Gesti\u00f3n de Almacenes  (ALMIN)',
 	'nombre':'Gesti\u00f3n de Almacenes  (ALMIN)',
 	'id':'176',
 	'ruta':'',
 	'leaf':false,
 	'allowDelete':false,
 	'allowEdit':false,
 	'allowDrag':false,
 	'icon':'..\/..\/..\/lib\/imagenes\/almin.png',
 	'tipo':'raiz',
     'children':[]
 },
 	{'text':'Control de Asistencia (CASIS)',
 	'nombre':'Control de Asistencia (CASIS)',
 	'id':'392',
 	'ruta':'',
 	'leaf':false,
 	'allowDelete':false,
 	'allowEdit':false,
 	'allowDrag':false,
 	'cls':'folder',
 	'tipo':'raiz',
 	'children':[]
 	}
 	,
 	{
 		'text':'Administraci\u00f3n del Kardex del Personal (KARD)',
 		'nombre':'Administraci\u00f3n del Kardex del Personal (KARD)',
 		'id':'54',
 		'ruta':'',
 		'leaf':false,
 		'allowDelete':false,
 		'allowEdit':false,
 		'allowDrag':false,
 		'cls':'folder',
 		'tipo':'raiz',
 		'children':[]
 	}
 	,
 	{
 		'text':'Contabilidad  (SIC)',
 		'nombre':'Contabilidad  (SIC)',
 		'id':'57',
 		'ruta':'',
 		'leaf':false,
 		'allowDelete':false,
 		'allowEdit':false,
 		'allowDrag':false,
 		'cls':'folder',
 		'tipo':'raiz',
 		'children':[]
 	},
 	{
 		'text':'Gesti\u00f3n Telef\u00f3nica (GESTEL)',
 		'nombre':'Gesti\u00f3n Telef\u00f3nica (GESTEL)',
 		'id':'61',
 		'ruta':'',
 		'leaf':false,
 		'allowDelete':false,
 		'allowEdit':false,
 		'allowDrag':false,
 		'icon':'..\/..\/..\/lib\/imagenes\/telephone.png',
 		'tipo':'raiz',
 		'children':[]
 	}
 	,
 	{
 	'text':'Sistema de Adquisiciones (COMPRO)',
 	'nombre':'Sistema de Adquisiciones (COMPRO)',
 	'id':'376',
 	'ruta':null,
 	'leaf':false,
 	'allowDelete':false,
 	'allowEdit':false,
 	'allowDrag':false,
 	'icon':'..\/..\/..\/lib\/imagenes\/adqui.png',
 	'tipo':'raiz',
 	'children':[]
 	}
 	,
 	{
 		'text':'Salir',
 		'nombre':'Salir',
 		'id':'salir',
 		'ruta':'..\/..\/control\/auten\/cerrar.php',
 		'leaf':true,
 		'allowDelete':false,
 		'allowEdit':false,
 		'allowDrag':false,
 		'icon':'..\/..\/..\/lib\/imagenes\/lock.png',
 		'tipo':'hoja'
 	}
 	]";
  exit;
	

}
else{
	$resp = new cls_manejo_mensajes(true, " 401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;

}
?>