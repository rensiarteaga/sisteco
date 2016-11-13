<?php

session_start();
include_once('../../LibModeloContabilidad.php');
$Custom = new cls_CustomDBContabilidad();

$nombre_archivo = 'ActionPDFLibroMayorPartida.php';



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
        ($ids_financiador) == ""? $ids_financiador="NULL": $ids_financiador;
		(($ids_regional) == "")? $ids_regional="NULL": $ids_regional;
		(($ids_programa) == "")? $ids_programa="NULL": $ids_programa;
		(($ids_proyecto) == "")? $ids_proyecto="NULL": $ids_proyecto;
		(($ids_actividad) == "")? $ids_actividad="NULL": $ids_actividad;
		$criterio_filtro=$criterio_filtro." AND COMPROB.id_comprobante IN (select tranpar.id_comprobante from tt_tct_transaccion_partida tranpar where tranpar.id_fina_regi_prog_proy_acti IN ('||presto.f_tpr_get_ep($ids_programa,$ids_proyecto,$ids_actividad,$ids_regional,$ids_financiador,$id_usuario)||'))";

	
	
		$Comprobante = array();
	$Transaccion = array();
	
	$Comprobante = $Custom-> LibroMayorPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_partida,$id_moneda,$fecha_inicio_b,$fecha_fin_b);
	$_SESSION['PDF_libro_mayor_partida']=$Custom->salida;
	    foreach ($Custom->salida as $f)
			{   $id_comprobante=$f["id_comprobante"];
			    $_SESSION['PDF_codigo_partida']=$f["codigo_partida"];
			    $_SESSION['PDF_nombre_partida']=$f["nombre_partida"];
                $_SESSION['PDF_desc_partida']=$f["desc_partida"];				       
                $_SESSION['PDF_fecha_inicio']=$fecha_inicio;
                $_SESSION['PDF_fecha_fin']=$fecha_fin;
             
     	}
     	$Transaccion = $Custom->LibroMayorPartidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_partida,$id_moneda,$fecha_inicio_b,$fecha_fin_b);
	
        $_SESSION['PDF_transaccion']=$Custom->salida;
                
    
    header("location: ../../../vista/libro_mayor_partida/PDFLibroMayorPartida.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>