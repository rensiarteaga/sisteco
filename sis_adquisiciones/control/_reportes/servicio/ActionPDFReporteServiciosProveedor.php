<?php
session_start();

include_once('../../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFReporteItemsProveedor.php';


if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    if($limit == "") $cant = 15;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

if($sort == '') $sortcol = '';
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

	
	$criterio_filtro = $cond->obtener_criterio_filtro();

	if($sw_servicio_clasificacion==0){
		
	$criterio_filtro= $criterio_filtro ." and serv.id_servicio=$id_servicio";
//	$_SESSION['PDF_nombre_servicio']=utf8_decode($servicio);
    $_SESSION['PDF_clasificacion']=0;
	 
	}else{
	$criterio_filtro= $criterio_filtro ."  and serv.id_servicio in (SELECT serv.id_servicio
																	FROM compro.tad_tipo_adq tipadq  
																	INNER JOIN compro.tad_tipo_servicio tipser ON (tipser.id_tipo_adq=tipadq.id_tipo_adq)
																	INNER JOIN compro.tad_servicio serv1 ON (serv.id_tipo_servicio=tipser.id_tipo_servicio)
																	WHERE tipadq.id_tipo_adq like ''$id_tipo_adq'' and tipser.id_tipo_servicio like ''$id_tipo_servicio'')";	

	$_SESSION['PDF_nombre_tipo_adq']=utf8_decode($tipo_adq);
	$_SESSION['PDF_nombre_tipo_servicio']=utf8_decode($tipo_servicio);
	$_SESSION['PDF_clasificacion']=1;
	}
    $_SESSION["PDF_titulo"]='SERVICIO';
	
	$UOCabecera = array();
	$Proveedores= array();
	
	$i=0;
	
	$UOCabecera = $Custom-> ListarServiciosCaracteristicasCostos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$_SESSION['ItemsCaracteristicasCostos']=$Custom->salida;
	
	
	foreach ($Custom->salida as $f)
	{  
	   $id_servicio_ob=$f["id_servicio"];
	   
	   $Proveedores = $Custom->ListarProveedoresServicio($cant,$puntero,$sortcol,$sortdir,' serpro.id_servicio='.$id_servicio_ob.' and serpro.id_servicio_proveedor in (select max(serpro1.id_servicio_proveedor)
FROM compro.tad_servicio_proveedor serpro1 
where serpro1.id_servicio=serpro.id_servicio and serpro1.id_proveedor=serpro.id_proveedor)' ,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	   $_SESSION['Proveedores_Item_'.$i]=$Custom->salida;
	   $i=$i+1;
    }
	 header("location: ../../../vista/_reportes/item/PDFItemsProveedores.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>