<?php
session_start();
/* Autor: Ana Maria Villegas
   Fecha de Creación: 19/06/2009
   Descripción: El Action para el reporte Balance de Sumas y Saldos
*/

include_once('../../LibModeloContabilidad.php');
$Custom = new cls_CustomDBContabilidad();

$nombre_archivo = 'ActionPDFBalanceSS.php';



if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    if($limit == "") $cant = 5000;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

if($sort == '') $sortcol = 'id_cuenta'; // aqui tengo que colocar porque se va a ordenar
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
	
$criterio_filtro = $cond -> obtener_criterio_filtro();
	 $_SESSION['PDF_gestion_bss']=$gestion;
			    $_SESSION['PDF_desc_moneda_bss']=$desc_moneda;
                $_SESSION['PDF_desc_dpto_conta_bss']=$desc_dpto_conta;				       
                $_SESSION['PDF_fecha_bss']=$fecha;
                $_SESSION['PDF_nivel_bss']=$nivel;
	$BalanceSS = array();
	$BalanceSSDetalle = array();
	
	/*$BalanceSS = $Custom-> LibroMayorPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_partida,$id_moneda,$fecha_inicio_b,$fecha_fin_b);
	$_SESSION['PDF_libro_mayor_partida']=$Custom->salida;
	    foreach ($Custom->salida as $f)
			{   $id_comprobante=$f["id_comprobante"];
			    $_SESSION['PDF_codigo_partida']=$f["codigo_partida"];
			    $_SESSION['PDF_nombre_partida']=$f["nombre_partida"];
                $_SESSION['PDF_desc_partida']=$f["desc_partida"];				       
                $_SESSION['PDF_fecha_inicio']=$fecha_inicio;
                $_SESSION['PDF_fecha_fin']=$fecha_fin;
             
     	}*/
     	$BalanceSSDetalle = $Custom->BalanceSSDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$id_moneda,$nivel,$fecha_fin,$id_depto_conta);
	
        $_SESSION['PDF_BalanceSSDetalle']=$Custom->salida;
                
    
    header("location: ../../../vista/balance_ss/PDFBalanceSS.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>