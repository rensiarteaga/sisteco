<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarValor.php
Propósito:				Permite realizar el listado en tfl_valor y creación de un xml para que la vista pueda leerlo de tal forma
						que pueda aceptarlo como un ds que corresponda al formulario
Tabla:					tfl_valor
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2011-01-26 17:17:47
Versión:				1.0.0
Autor:					Ariel Ayaviri Omonte
**********************************************************
*/
//mi codigo para el firePHP

session_start();
include_once('../LibModeloFlujo.php');

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = 'ActionListarValor.php';

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

	if($sort == '') $sortcol = 'id_atributo';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;
	
	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> 'si', 'no'
	
	switch ($cod){
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
	for($i=0;$i<$CantFiltros;$i++){
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	//////////////////////////////////////////////////////////////////////
	// LLamada a la tabla atributo para saber la defincion de los datos //
	//////////////////////////////////////////////////////////////////////
	$c_names = array();
	$res = $Custom->ListarAtributo(1000,0,'id_atributo asc','asc'," TIPATR.id_tipo_formulario = $m_id_tipo_formulario");
	if(!$res){
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
	$i=0;
	foreach($Custom->salida as $f){
		$c_names[$i] = $f['nombre'];
		$i++;
	}
	
	//Se establece el total de registros en 0
	$total_registros = 0;
		//sumamos la cantidad de registros para este id_proceso
		$res = $Custom -> ContarValorDinamico($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$m_id_tipo_proceso,$m_id_empleado,$m_id_tipo_formulario,$c_names);
		if(!$res){
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
		$total_registros= intval($Custom->salida);
		
		//se crea el XML
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ListarValorDinamico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$m_id_tipo_proceso,$m_id_empleado,$m_id_tipo_formulario,$c_names);

		if($res)
		{
			foreach ($Custom->salida as $f)
			{
				$xml->add_rama('ROWS');
				$i=0;
				while($i<count($c_names))
				{
					$auxName = $c_names[$i];
					if($f[$auxName.'_idvalor']=="NULL"){$f[$auxName.'_idvalor']="";}
					if($f[$auxName.'_idnodo']=="NULL"){$f[$auxName.'_idnodo']="";}
					if($f[$auxName]=="NULL"){$f[$auxName]="";}
					$xml->add_nodo("ids_adicional_$i",$f[$auxName.'_idvalor']."@#@".$f[$auxName.'_idnodo']);
					$xml->add_nodo($auxName,$f[$auxName]);
					$i++;
				}
				$xml->add_nodo('id_formulario',$f["id_formulario"]);
				$xml->add_nodo('id_proceso',$f["id_proceso"]);
				$xml->add_nodo('id_tipo_nodo',$f["id_tipo_nodo"]);
				$xml->add_nodo('estado',$f["estado"]);
				$xml->fin_rama();
			}
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

	$xml->mostrar_xml();
	exit;
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