<?php

session_start();
include_once('../../LibModeloTesoreria.php');
$Custom = new cls_CustomDBTesoreria();

$nombre_archivo = 'ActionPDFRepFondoRotatorio.php';



if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    if($limit == '') $cant = 1500;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = ' ';   /// tengo que   cambiar de acuerdo a la consulta
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'desc';
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
	
		/*if ($get)
		{*/
			$id_caja= $_GET["id_caja"];
			$fecha_inicio= $_GET["fecha_inicio"];
			$fecha_fin= $_GET["fecha_fin"];
		//}
		/*else
		{
			
			$id_caja= $_POST["id_caja"];
			$fecha_inicio= $_POST["fecha_inicio_$j"];
			$fecha_fin= $_POST["fecha_fin_$j"];
		
	
		}*/
			$_SESSION["caja"]=$caja;
			$_SESSION["fecha_inicio"]=$fecha_inicio;
			$_SESSION["fecha_fin"]=$fecha_fin;
			$fecha_inicio= substr( $fecha_inicio,3,2)."/".substr($fecha_inicio,0,2)."/".substr($fecha_inicio,6,4);
			$fecha_fin= substr($fecha_fin,3,2)."/".substr($fecha_fin,0,2)."/".substr($fecha_fin,6,4);
			
//Verifica si se manda la cantidad de filtros
	if($CantFiltros=="") $CantFiltros = 0;


//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}

	$criterio_filtro = $cond->obtener_criterio_filtro();
	
	
	
	$DetRendicionCuenta = array();
	
        $DetFondoRotatorio=$Custom->RepFondoRotatorio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_caja,$fecha_inicio,$fecha_fin);
        $_SESSION['PDF_detFondoRotatorio']=$Custom->salida;
    
	 	if(count($Custom->salida)!=0)
	 	{
			header("location: ../../../vista/solicitud_viaticos2/PDFSumFondoRotatorio.php");
		}
		else
		{
			echo"No retorna ningún valor de la base de datos consulte con el Administrador";
		}
}
else
{
	header("HTTP/1.0 401 No autorizado");
	header('Content-Type: text/plain; charset=iso-8859-1');
	echo "No tiene los permisos necesarios ";
}

?>