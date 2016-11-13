<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarInstitucion.php
Propósito:				Permite realizar el listado en tpm_institucion
Tabla:					t_tpm_institucion
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2007-11-06 21:04:28
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloParametros.php');

$Custom = new cls_CustomDBParametros();
$nombre_archivo = 'ActionListarInstitucion .php';

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

	if($sort == '') $sortcol = 'nombre';
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
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Institucion');
	$sortcol = $crit_sort->get_criterio_sort();
	
if($banco=='si'){//add filtro para vista kard.cta_bancaria (6sep10)
		$criterio_filtro=$criterio_filtro. " AND INSTIT.codigo_banco is not null";
	}
	
	//adicion de filtro para vista kard.gestion_hoja_vida(13jul11)
	if(isset($id_institucion_trabajo)){
		if($id_institucion_trabajo>0){
			$criterio_filtro=$criterio_filtro. " and  id_institucion in (select id_institucion from kard.tkp_empleado_trabajo)"; 
		}
	}
	//Obtiene el total de los registros
	$res = $Custom -> ContarInstitucion($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarInstitucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		if(isset($no_existe)){
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_institucion',0);
			$xml->add_nodo('doc_id',0);
			$xml->add_nodo('nombre','-- NO EXISTE --');
			$xml->fin_rama();
		}
		
		if(isset($id_institucion_trabajo)){
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_institucion',0);
			$xml->add_nodo('doc_id',0);
			$xml->add_nodo('nombre','Todos');
			$xml->fin_rama();
		}
		
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_institucion',$f["id_institucion"]);
			$xml->add_nodo('doc_id',$f["doc_id"]);
			$xml->add_nodo('nombre',$f["nombre"]);
			$xml->add_nodo('casilla',$f["casilla"]);
			$xml->add_nodo('telefono1',$f["telefono1"]);
			$xml->add_nodo('telefono2',$f["telefono2"]);
			$xml->add_nodo('celular1',$f["celular1"]);
			$xml->add_nodo('celular2',$f["celular2"]);
			$xml->add_nodo('fax',$f["fax"]);
			$xml->add_nodo('email1',$f["email1"]);
			$xml->add_nodo('email2',$f["email2"]);
			$xml->add_nodo('pag_web',$f["pag_web"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('fecha_registro',$f["fecha_registro"]);
			$xml->add_nodo('hora_registro',$f["hora_registro"]);
			$xml->add_nodo('fecha_ultima_modificacion',$f["fecha_ultima_modificacion"]);
			$xml->add_nodo('hora_ultima_modificacion',$f["hora_ultima_modificacion"]);
			$xml->add_nodo('estado_institucion',$f["estado_institucion"]);
			$xml->add_nodo('id_persona',$f["id_persona"]);
			$xml->add_nodo('desc_persona',$f["desc_persona"]);
			$xml->add_nodo('direccion',$f["direccion"]);
			$xml->add_nodo('id_tipo_doc_institucion',$f["id_tipo_doc_institucion"]);
			$xml->add_nodo('desc_tipo_doc_institucion',$f["desc_tipo_doc_institucion"]);

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