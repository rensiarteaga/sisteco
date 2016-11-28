<?php
/*
**********************************************************
Nombre de la Archivo:	LibModeloSeguridad
Propósito:				Aqui se incluyen todas los custom necesarios para que funcionen
						el la capa de CONTROL
						Fecha de Creación:		18 - 02 - 07
Versión:				1.0.0
Autor:					Rensi Arteaga Copari
**********************************************************
*/

    include_once(dirname(__FILE__)."/../../lib/configuracion.inc.php");	//echo '1';exit;	
    include_once(dirname(__FILE__)."../../../lib/lib_general/cls_funciones.php");	//echo '2';
   	include_once(dirname(__FILE__)."../../../lib/lib_general/cls_archivos.php");	
	//	echo '3';
   	include_once(dirname(__FILE__)."../../modelo/cls_CustomDBSeguridad.php");
   	include_once(dirname(__FILE__)."../../../lib/lib_modelo/cls_middle.php");
   	include_once(dirname(__FILE__)."../../../lib/lib_modelo/cls_conexion.php");
   	include_once(dirname(__FILE__)."../../../lib/lib_modelo/cls_define_tipo_dato.php");
   	//include_once("../../../lib/lib_control/cls_validacion_serv.php");
   	include_once(dirname(__FILE__)."../../../lib/lib_control/cls_validacion_serv.php");
   	include_once(dirname(__FILE__)."../../../lib/lib_control/cls_manejo_xml.php");
   	include_once(dirname(__FILE__)."../../../lib/lib_control/cls_manejo_arbol.php");
   	include_once(dirname(__FILE__)."../../../lib/lib_control/cls_manejo_mensajes.php");
	include_once(dirname(__FILE__)."../../../lib/lib_control/cls_criterio_filtro.php");
	include_once(dirname(__FILE__)."../../../lib/lib_control/cls_criterio_sort.php");
	
   	
   	
   	
?>