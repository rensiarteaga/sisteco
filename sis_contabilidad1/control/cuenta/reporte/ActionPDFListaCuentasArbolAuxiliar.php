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
	
	$criterio_filtro= $criterio_filtro ."  AND GESTION.id_gestion=".$m_id_gestion;
	
	
	
	
	$Cuentas = array();
	$CuentaAuxiliar=array();
	$Cuenta = $Custom-> RepCuentas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	$_SESSION['PDF_cuentas']=$Custom->salida;
	$i=0;
	$j=0;
	foreach ($Custom->salida as $f)
			{   $id_cuenta=$f["id_cuenta"];
				$_SESSION['PDF_id_cuenta'] = $f["id_cuenta"];
				$_SESSION['PDF_gestion'] = $f["gestion"];
				$sw_aux=$f["sw_aux"];
				$_SESSION['PDF_sw_aux'] = $f["sw_aux"];
				if($sw_aux==1){
			       $CuentaAuxiliar = $Custom->ReporteCuentaAuxiliar($cant,$puntero,"  AUXILI.nombre_auxiliar",$sortdir," CUEAUX.id_cuenta=".$id_cuenta,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);				
                   $_SESSION['PDF_auxiliar_'.$i]=$Custom->salida;                
            	//    $j=$j+1;	
				}
              $i=$i+1;       
                     
			}
     /*	echo $j;
     	exit;*/
    header("location: ../../../vista/cuenta/PDFListaCuentasArbolAuxiliar.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>