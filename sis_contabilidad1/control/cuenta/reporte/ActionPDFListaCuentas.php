<?php
session_start();
include_once("../../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarCuenField.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
  if($limit == "") $cant = 1000;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

    if($sort == '') $sortcol = 'CUENTA.nro_cuenta';
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
	
//	$criterio_filtro= $criterio_filtro ." AND PROCOM.id_proceso_compra=".$m_id_proceso_compra;
	
	
	
	$Proceso = array();
	$Proceso_det = array();
	$Proceso_det_sol = array();
	$Proceso = $Custom-> RepCuentas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	$_SESSION['PDF_cuentas']=$Custom->salida;
	/*foreach ($Custom->salida as $f)
			{   $_SESSION['PDF_codigo_proceso'] = $f["codigo_proceso"];
				$_SESSION['PDF_nombre']=$f["nombre"];
                $_SESSION['PDF_num_proceso']=$f["num_proceso"];				       
                $_SESSION['PDF_periodo']=$f["periodo"];
                $_SESSION['PDF_gestion']=$f["gestion"];				       
                $_SESSION['PDF_num_convocatoria']=$f["num_convocatoria"];
                $tipo_adq = $f["tipo_adq"];
                $_SESSION['PDF_tipo_adq']=$f["tipo_adq"];
                $_SESSION['PDF_nombre_moneda']=$f["nombre_moneda"];
              }
	*//*$Proceso_det = $Custom-> ListarRepProcesoDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	$_SESSION['PDF_proceso_det']=$Custom->salida;
	$i=0;
if($tipo_adq=='Bien'){
	foreach ($Custom->salida as $f)
			{   $id_item=$f["id_item"];
			    $id_proceso_compra_det=$f["id_proceso_compra_det"];
			    $_SESSION['PDF_titulo1']="ITEM";
			    //$_SESSION['PDF_id__'.$i] = $f["id_item"];
				$_SESSION['PDF_id_item_'.$i] = $f["id_item"];
				$_SESSION['PDF_cantidad_'.$i]=$f["cantidad"];
				 $Proceso_det_sol = $Custom->ListarRepProcesoSol($cant,$puntero,$sortcol,$sortdir," PROCOM.id_proceso_compra=$m_id_proceso_compra and prodet.id_proceso_compra_det=$id_proceso_compra_det",$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);	
                 $_SESSION['PDF_proceso_det_sol_'.$i]=$Custom->salida;
             
                 $i=$i+1;
                   
			}
    	
	}else{
	foreach ($Custom->salida as $f)
			{   $_SESSION['PDF_titulo1']="SERVICIO";
			   $id_proceso_compra_det=$f["id_proceso_compra_det"];
				$id_servicio=$f["id_servicio"];
				$_SESSION['PDF_id_servicio_'.$i] = $f["id_servicio"];
				$_SESSION['PDF_cantidad_'.$i]=$f["cantidad"];
				 $Proceso_det_sol = $Custom->ListarRepProcesoSol($cant,$puntero,$sortcol,$sortdir," PROCOM.id_proceso_compra=$m_id_proceso_compra and prodet.id_proceso_compra_det=$id_proceso_compra_det",$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);	
                 $_SESSION['PDF_proceso_det_sol_'.$i]=$Custom->salida;
             
                 $i=$i+1;
                   
			}
    	
	}*/
     	
    header("location: ../../../vista/cuenta/PDFListaCuentas.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>