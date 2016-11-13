<?php
/**
* Nombre de archivo:	    ActionListaEmpleado.php
* Propósito:				Permite desplegar los registros de los Empleados
* Tabla:					tkp_empleado
* Parámetros:
* Valores de Retorno:   	Listado de los Empleados, y el total de registros listados
* Autor:					Rodrigo Chumacero Moscoso
* Fecha de Creación:		21-06-2007
*/
session_start();

include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = 'ActionListaEmpleado.php';

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

	if($sort == "") $sortcol = 'PERSON.apellido_paterno,PERSON.apellido_materno,PERSON.nombre';
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
	$condicion=$_GET['condicion'];
	if($condicion==1){
		
	//$criterio_filtro=$criterio_filtro." AND EMP.id_empleado NOT IN(SELECT lib.id_empleado from tfv_libre lib where lib.estado=1)";
    }
/*	echo "mensaje->".$criterio_filtro;
	exit;*/
	
	//Obtiene el total de los registros
	$res = $Custom->ContarListaEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);

	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		if($origen == 'filtro'){
				
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_empleado', '%');
			$xml->add_nodo('id_persona',"TODOS");
			$xml->add_nodo('desc_persona',"TODOS");
			$xml->add_nodo('codigo_empleado',"TODOS");
			$xml->add_nodo('nombre_tipo_documento',"TODOS");
			$xml->add_nodo('doc_id',"TODOS");
			$xml->add_nodo('email1',"TODOS");
			
			
			    
			$xml->fin_rama();
		}
		
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_empleado',$f["id_empleado"]);
			$xml->add_nodo('id_persona',$f["id_persona"]);
			$xml->add_nodo('desc_persona',$f["desc_persona"]);
			$xml->add_nodo('codigo_empleado',$f["codigo_empleado"]);
			$xml->add_nodo('nombre_tipo_documento',$f["nombre_tipo_documento"]);
			$xml->add_nodo('doc_id',$f["doc_id"]);
			$xml->add_nodo('email1',$f["email1"]);
			$xml->fin_rama();
		}
		//$xml->mostrar_xml();
		header('HTTP/1.0 200 OK');
		header('Content-Type:text/xml');
		echo $xml -> cadena_xml();
		exit;
		//$xml->mostrar_xml();
	}
	
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true,"406");
		$resp->mensaje_error = $Custom->salida[1];
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
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

}?>