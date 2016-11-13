<?php

session_start();
include_once('../../LibModeloContabilidad.php');
$Custom = new cls_CustomDBContabilidad();

$nombre_archivo = 'ActionPDFValidacionLibroMayorBancaria.php';



if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    if($limit == "") $cant = 2000;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = ''; // aqui tengo que colocar porque se va a ordenar
	else $sortcol = $sort;

	if($dir == "") $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> "si", "no"
	switch ($cod)
	{
		case "si":
			$decodificar = true;
			break;
		case "no":
			$decodificar = false;
			break;
		default:
			$decodificar = true;
			break;
	}

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=="") $CantFiltros = 0;
	/*echo $departamento;
	echo $fecha_ini;
	echo $fecha_fin;
	echo $rep_fecha_ini;
	echo $rep_fecha_fin;
	echo $nombre_departamento;
	echo $id_moneda;
	echo $nombre_moneda;
	exit;*/
	
	$_SESSION['PDF_nombre_departamento_lvmb']=$nombre_departamento;
	$_SESSION['PDF_fecha_ini_vmb']=$rep_fecha_ini;
	$_SESSION['PDF_fecha_fin_vmb']=$rep_fecha_fin;
	$_SESSION['PDF_nombre_departamento_vmb']=$nombre_departamento;
	$_SESSION['PDF_nombre_moneda_vmb']=$nombre_moneda;
	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
   	$validacionLibroMayor = array();
	$validacionLibroMayor = $Custom->ReporteValidacionLibroMayorBancaria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$departamento,$id_moneda,$fecha_ini,$fecha_fin);

    $_SESSION['PDF_val_libro_mayor_bancaria']=$Custom->salida;
   /* print_r($Custom->salida);
    exit;*/
    
    header("location: ../../../vista/_reportes/val_libro_mayor_bancaria/PDFValLibroMayorBancaria.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}
?>