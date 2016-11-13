<?php

session_start();
include_once('../../LibModeloTesoreria.php');
$Custom = new cls_CustomDBTesoreria();

$nombre_archivo = 'ActionPDFRendicionCuentaDoc2.php';



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
	
	
	$_SESSION['PDF_subtitulo']='Fondo Rotatorio'; 
	$_SESSION['PDF_nombre_completo']='';
    $_SESSION['PDF_nombre_cargo']='';				       
    $_SESSION['PDF_nombre_lugar']='';
    $_SESSION['PDF_concepto']='Vista Previa Rendición';				       
    $_SESSION['PDF_fecha_ini_rendicion']=$fecha_ini;				       
    $_SESSION['PDF_fecha_fin_rendicion']=$fecha_fin;		
    $_SESSION['PDF_fecha_avance']=$fecha_fin;		
    $_SESSION['PDF_nro_avance']='';		
                
    $fecha_ini_bd=substr($fecha_ini,3,2)."/".substr($fecha_ini,0,2)."/".substr($fecha_ini,6,4); 
    $fecha_fin_bd=substr($fecha_fin,3,2)."/".substr($fecha_fin,0,2)."/".substr($fecha_fin,6,4);             
    $DetRendicionCuenta=$Custom->DetalleRendicionCuentaDoc2($id_caja,$fecha_ini_bd,$fecha_fin_bd,$tipo_rendicion);
    $_SESSION['PDF_DetRendicionCuenta']=$Custom->salida;
              
 if(count($Custom->salida)!=0){
		   header("location: ../../../vista/solicitud_viaticos2/PDFRendicionCuentaDoc.php");
	}else{
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