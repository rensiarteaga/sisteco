<?php
/*
**********************************************************
Nombre de archivo:	    ActionListaActivoFijoProceso.php
Propósito:				Permite desplegar los ActivoFijoProceso registrados
Tabla:					taf_activo_fijo_proceso
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro
						$id_usuario_asignacion

Valores de Retorno:    	Listado de ActivoFijoProceso
Fecha de Creación:		06- 06 - 07
Versión:				1.0.0
Autor:					
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");

$CustomActivos = new cls_CustomDBActivoFijo();
$nombre_archivo='ActionListaProcesoTipoCuenta.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	
	//Parámetros del filtro
	if($limit == "") $cant = 15;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

	if($sort == "") $sortcol = 'id_proceso_tipo_cuenta';
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
	
	//Verifica si tiene un id_proceso por defecto, para sólo mostrar la información de un proceso específico
	if($hidden_id_proceso_tipo_cuenta != '' || $hidden_id_proceso_tipo_cuenta != 'undefined')
	{
		$cond->add_condicion_filtro('prot.id_proceso_tipo_cuenta', $hidden_id_proceso_tipo_cuenta, 'true');
	}
	
	//echo $maestro_id_proceso ; exit;
	 
	//Obtiene el criterio del filtro
	$criterio_filtro = $cond->obtener_criterio_filtro();
	if($maestro_id_proceso>0){
		$criterio_filtro=$criterio_filtro. " AND prot.id_proceso=$maestro_id_proceso";
	}
	$res = $CustomActivos->ContarProcesoTipoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	if($res)
	{
		$total_registros= $CustomActivos->salida;
	}
	
	//Obtiene el conjunto de datos de la consulta
	
	$res = $CustomActivos->ListarProcesoTipoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);

	if($res)
	{	
		
		// PREPARA EL ARCHIVO XML
		$xml= new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		foreach ($CustomActivos->salida as $f)
		{ 
		    $xml->add_rama('ROWS');
		    $xml->add_nodo('id_proceso_tipo_cuenta',$f["id_proceso_tipo_cuenta"]);
		    $xml->add_nodo('id_proceso',$f["id_proceso"]);
		    $xml->add_nodo('id_tipo_cuenta',$f["id_tipo_cuenta"]);
		    $xml->add_nodo('descripcion',$f["descripcion"]);
		    $xml->add_nodo('codigo',$f["codigo"]);
		    $xml->add_nodo('debe_haber',$f["debe_haber"]);
		    		    
		    $xml->fin_rama();
		}
		/*header('HTTP/1.0 200 OK');
		header('Content-Type:text/xml');
		echo $xml -> cadena_xml();
		exit;*/
		$xml->mostrar_xml();
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = $CustomActivos->salida[1];
		$resp->origen = $CustomActivos->salida[2];
		$resp->proc = $CustomActivos->salida[3];
		$resp->nivel = $CustomActivos->salida[4];
		$resp->query = $CustomActivos->query;
		echo $resp->get_mensaje();
		exit;
	}
	
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;

}
	 
	 
?>