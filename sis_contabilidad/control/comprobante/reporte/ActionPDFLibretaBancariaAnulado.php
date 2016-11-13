<?php

session_start();
include_once('../../LibModeloContabilidad.php');
$Custom = new cls_CustomDBContabilidad();

$nombre_archivo = 'ActionPDFLibretaBancariaAnulado.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    if($limit == "") $cant = 1000000;
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
        ($ids_financiador) == ""? $ids_financiador="NULL": $ids_financiador;
		(($ids_regional) == "")? $ids_regional="NULL": $ids_regional;
		(($ids_programa) == "")? $ids_programa="NULL": $ids_programa;
		(($ids_proyecto) == "")? $ids_proyecto="NULL": $ids_proyecto;
		(($ids_actividad) == "")? $ids_actividad="NULL": $ids_actividad;
	
	$Comprobante = array();
	$Transaccion = array();
	
	// $_SESSION['PDF_nro_cuenta']=;
	 $_SESSION['PDF_nombre_cuenta']=$m_desc_cuenta.' -- '.$m_desc_institucion.' - '.$m_nro_cuenta_banco;
     $_SESSION['PDF_desc_moneda']=$m_nombre_moneda;				       
     $_SESSION['PDF_fecha_inicio']=$m_fecha_inicio;
     $_SESSION['PDF_fecha_fin']=$m_fecha_fin;
     $_SESSION['PDF_sw_actualizacion']=$m_sw_actualizacion;

     $res = $Custom->ListarLibretaBancariaAnulado(1000000,0,'nro_cheque asc',$sortdir,'0=0',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_id_cuenta_bancaria,$m_id_moneda,$m_fecha_inicio,$m_fecha_fin,$_SESSION['PDF_sw_actualizacion']);
	
     $_SESSION['PDF_libreta_bancaria_anulado']=$Custom->salida;
     
     //echo ($Custom->query); exit() ;
    /*print_r($Custom->salida);
      exit;   */
    
    header("location: ../../../vista/libreta_bancaria/PDFLibretaBancariaAnulado.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>