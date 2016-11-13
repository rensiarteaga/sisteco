<?php

session_start();
include_once('../../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFReporteUOSol.php';



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
	
	//$criterio_filtro= $criterio_filtro ."  and item.id_item in (3258,3261,4045)  ";
/*	echo 'asdfsdf'.$supergrupo;
	exit;*/
	$_SESSION["PDF_titulo"]='ITEM';
	if($sw_item_clasificacion==0){
		
	$criterio_filtro= $criterio_filtro ." and item.id_item=$id_item";
	$_SESSION["PDF_clasificacion"]=0;
	}else{
	$criterio_filtro= $criterio_filtro ." and item.id_supergrupo like ''$txt_id_supergrupo'' and item.id_grupo like ''$txt_id_grupo''
and item.id_subgrupo like ''$txt_id_subgrupo''
and item.id_id1 like ''$txt_id_id1''
and item.id_id2 like ''$txt_id_id2''
and item.id_id3 like ''$txt_id_id3''";	
	$_SESSION['PDF_nombre_supergrupo']=utf8_decode($supergrupo);
	$_SESSION['PDF_nombre_grupo']=utf8_decode($grupo);
	$_SESSION['PDF_nombre_subgrupo']=utf8_decode($subgrupo);
	$_SESSION['PDF_nombre_id1']=utf8_decode($id1);
	$_SESSION['PDF_nombre_id2']=utf8_decode($id2);
	$_SESSION['PDF_nombre_id3']=utf8_decode($id3);
	$_SESSION["PDF_clasificacion"]=1;
	}
	$UOCabecera = array();
	$Proveedores= array();
	
	$i=0;
	$UOCabecera = $Custom-> ListarItemCaracteristicasCostos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$_SESSION['ItemsCaracteristicasCostos']=$Custom->salida;
	foreach ($Custom->salida as $f)
	{  
	   $id_item=$f["id_item"];
	   
	   $Proveedores = $Custom->ListarProveedoresItem($cant,$puntero,$sortcol,$sortdir,' itepro.id_item='.$id_item.' and itepro.id_item_proveedor in (select max(itepro1.id_item_proveedor)
FROM compro.tad_item_proveedor itepro1 
where itepro1.id_item=itepro.id_item and itepro1.id_proveedor=itepro.id_proveedor)' ,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	  /* print_r($_SESSION['Proveedores_Item_'.$i]);
	   exit;*/
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