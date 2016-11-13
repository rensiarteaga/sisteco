<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarSelPersonal.php
Propósito:				Permite realizar el listado en tsg_personas
Tabla:					t_tsg_persona
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		10Ç/09/2010
Versión:				1.0.0
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once('../LibModeloKardexPersonal.php');

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = 'ActionListarSelPersonal.php'; 

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	
	if($sort == '') $sortcol = 'person.apellido_paterno';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> 'si', 'no'
	
	switch ($cod)
	{
		case 'si':
			$decodificar = true;
			break;
		case 'no':
			$decodificar = false;
			break;
		default:
			$decodificar = true;
			break;
	}

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Personal');
	$sortcol = $crit_sort->get_criterio_sort();
	
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarFuncionario($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarSelPersonal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		if($filtro>0){
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_persona', '0');
			//$xml->add_nodo('id_persona','');
			$xml->add_nodo('desc_persona','Ninguno');
			//$xml->add_nodo('codigo_empleado','Ninguno');
			$xml->add_nodo('nombre_tipo_documento','Documento');
			$xml->add_nodo('doc_id','Ninguno');
			$xml->add_nodo('email1','Ninguno');			
			
			$xml->fin_rama();
		}

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			
			$xml->add_nodo('id_persona',$f["id_persona"]);
			$xml->add_nodo('desc_persona',$f["desc_persona"]);
			$xml->add_nodo('direccion',$f["direccion"]);
			$xml->add_nodo('doc_id',$f["doc_id"]);
			$xml->add_nodo('id_tipo_doc_identificacion',$f["id_tipo_doc_identificacion"]);
			$xml->add_nodo('genero',$f["genero"]);
			$xml->add_nodo('telefono1',$f["telefono1"]);
			$xml->add_nodo('celular1',$f["celular1"]);
			$xml->add_nodo('email1',$f["email1"]);
			$xml->add_nodo('fecha_nacimiento',$f["fecha_nacimiento"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('nro_registro',$f["nro_registro"]);
			
			$xml->fin_rama();
		}
		$xml->mostrar_xml();
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true,'406');
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