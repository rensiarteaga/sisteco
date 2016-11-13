<?php

session_start();
include_once('../../LibModeloContabilidad.php');
$Custom = new cls_CustomDBContabilidad();

$nombre_archivo = 'ActionPDFLibroMayorOT.php';



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

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
   	
	function cambiar_a_postgres($fecha){
    	ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
    	$lafecha=$mifecha[2]."-".$mifecha[1]."-".$mifecha[3];
    	return $lafecha;
    }
    
   	$id_usuario=$_SESSION["ss_id_usuario"];
   	$_SESSION["PDF_moneda"]=utf8_decode($desc_moneda);
   	$fecha_inicio_b=cambiar_a_postgres($fecha_inicio);
   	$fecha_fin_b=cambiar_a_postgres($fecha_fin);
	$criterio_filtro = $cond->obtener_criterio_filtro();
	$_SESSION['PDF_fecha_inicio']=$fecha_inicio;
    $_SESSION['PDF_fecha_fin']=$fecha_fin;
     $_SESSION['PDF_nombre_depto']=$nombre_depto;
    
	 if($por_rango=='true'){
    	$id_cuenta='NULL';
    } else{
    	$cuenta_ini='';
    	$cuenta_fin='';
    }
	
	$Transaccion = array();
	
 	$Transaccion = $Custom->ReporteLibroMayorOT($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$fecha_inicio_b,$fecha_fin_b,$id_depto,$cuenta_ini,$cuenta_fin,$por_rango,$id_gestion);
 	
//echo $Custom->query;
//exit;
 	
    $_SESSION['PDF_transaccion_ot']=$Custom->salida;
    
    header("location: ../../../vista/libro_mayor/PDFLibroMayorOT.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}
?>