<?php
/**
**********************************************************
Nombre de archivo:	    ActionPDFPrestacionServicios.php
Propósito:				Permite realizar el reporte de prestacion de servicios
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro
Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:	    08/03/2010
Versión:				1.0.0
Autor:					Ana Maria villegas
**********************************************************
*/
session_start();
include_once("../../LibModeloPresupuesto.php");
$nombre_archivo = 'ActionPDFRepVerificarPresto.php';

$Custom = new cls_CustomDBPresupuesto();
if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 30000;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_devengado_detalle';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> 'si', 'no'
	
	switch ($cod)
	{
		case 'si':
			$decodificar = true;
			break;
		case 'no':
			$decodificar = false;
			break;
		default:
			$decodificar = true;
			break;
	}

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	$id_usuario=$_POST["id_usuario"];
	$id_presupuesto=$_POST["id_presupuesto"];
	$id_usuario=$_GET["id_usuario"];
	$id_presupuesto=$_GET["id_presupuesto"];
	$nombre_usuario=$_GET["nombre_usuario"];
	$res = $Custom->VerificarPresUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_presupuesto,$id_usuario);
	
		
	$_SESSION["PDF_verificarPresUsuario"]=$Custom->salida;
	$_SESSION["PDF_nombre_usuario"]=$nombre_usuario;
	
	if($res)
	{
		header("location: ../../../vista/_reportes/ver_eps_x_presusuario/PDFVerificarPresto.php");
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true,'406');
		$resp->mensaje_error = $Custom->salida[1];
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
		echo $resp->get_mensaje();
		exit;
	}
}
else
{
	    header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";

}?>
