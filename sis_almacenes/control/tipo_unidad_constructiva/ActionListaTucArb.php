<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarTipoUnidadConstructiva.php
Propósito:				Permite realizar el listado en tal_tipo_unidad_constructiva
Tabla:					t_tal_tipo_unidad_constructiva
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2007-11-07 15:46:18
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../rcm_LibModeloAlmacenes.php');

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = 'ActionListarTipoUnidadConstructiva .php';

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

	if($sort == '') $sortcol = 'codigo';
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
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'TipoUnidadConstructiva');
	$sortcol = $crit_sort->get_criterio_sort();

	$nodos['totalCount']=0;
	if($node=='id'){

		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ListarTipoUnidadConstructivaAgrupador($cant,$puntero,'id_tipo_unidad_constructiva desc','desc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

		if($res)
		{
			foreach ($Custom->salida as $f)
			{
				if($f["codigo"]!='Basurero' && $f["codigo"]!='Obsoletos'){
					$tmp['text'] = utf8_encode($f["codigo"])." - ".utf8_encode($f["nombre"]);
					$tmp['id'] = utf8_encode($f["id_tipo_unidad_constructiva"]);
					$tmp['cls']	= 'folder';
					$tmp['leaf'] = false;
					$tmp['allowDelete']	= true;
					$tmp['allowDrag']	= false;
					$tmp['allowEdit']	= true;
					//$tmp['allowDrag']	= true;
					$tmp['terminado']=utf8_encode($f["estado"])=='Terminado' ? 'true':'false';
					$tmp['icon'] = "../../../lib/imagenes/ag.png";
					$tmp['tipo'] = "agrupador";
					$tmp['codigo'] = utf8_encode($f["codigo"]);
					$tmp['nombre'] = utf8_encode($f["nombre"]);
					$tmp['descripcion'] = utf8_encode($f["descripcion"]);
					$tmp['observaciones'] = utf8_encode($f["observaciones"]);

					$tmp['cantidad'] = 1;
					$tmp['opcional'] = 'false';
					$tmp['qtip'] = "Nombre: ".$tmp['nombre']." <br \/>Descripcion: ".$tmp["descripcion"];
					$tmp['qtipTitle']="Agrupador: ".$tmp["codigo"];
				}
				else{
					$tmp['text'] = utf8_encode($f["codigo"]);
					$tmp['id'] = utf8_encode($f["id_tipo_unidad_constructiva"]);
					$tmp['cls']	= 'folder';
					$tmp['leaf'] = false;
					$tmp['allowDelete']	= false;
					$tmp['allowEdit']	= false;
					$tmp['allowDrag']	= false;
					//$tmp['allowDrag']	= false;
					//$tmp['terminado']=utf8_encode($f["estado"])=='Terminado' ? 'true':'false';
					if($f["codigo"]=='Basurero')
					{
						$tmp['icon'] = "../../../lib/imagenes/basurero.png";
						$tmp['qtipTitle'] = "Papelera";
						$tmp['qtip']="Papelera de Reciclaje";
					}
					else
					{
						$tmp['icon'] = "../../../lib/imagenes/box.png";
						$tmp['qtip'] = "Agrupador de estructuras obsoletas";
						$tmp['qtipTitle']="Obsoletos";
					}
					$tmp['tipo'] = "agrupador";
					$tmp['codigo'] = utf8_encode($f["codigo"]);
					$tmp['nombre'] = utf8_encode($f["nombre"]);
					$tmp['descripcion'] = utf8_encode($f["descripcion"]);
					$tmp['observaciones'] = utf8_encode($f["observaciones"]);

				}


				$nodes[] = $tmp;
			}

			if(sizeof($nodes)>0){
				echo json_encode($nodes);
			}
			else {
				echo '{}';
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


	}
	elseif($tipo=='agrupador'){
		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ListarTipoUnidadConstructivaRaiz($cant,$puntero,'id_tipo_unidad_constructiva desc','desc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node);

		if($res)
		{
			foreach ($Custom->salida as $f)
			{

				$tmp['text'] = utf8_encode($f["codigo"])." - ".utf8_encode($f["nombre"]);
				$tmp['id'] = utf8_encode($f["id_tipo_unidad_constructiva"]);
				$tmp['id_p'] = utf8_encode($f["id_tuc_padre"]);

				$tmp['cls']	= 'folder';
				$tmp['leaf'] = false;
				$tmp['allowDelete']	= true;
				$tmp['allowEdit']	= true;
				//$tmp['allowDrag']	= true;
				$tmp['terminado']=utf8_encode($f["estado"])=='Terminado' ? 'true':'false';
				if($tmp['terminado']=='true'){
					$tmp['icon'] = "../../../lib/imagenes/tucr.png";
				}
				else{
					$tmp['icon'] = "../../../lib/imagenes/etucr.png";
				}
				$tmp['tipo'] = "raiz";
				$tmp['codigo'] = utf8_encode($f["codigo"]);
				$tmp['nombre'] = utf8_encode($f["nombre"]);
				$tmp['descripcion'] = utf8_encode($f["descripcion"]);
				$tmp['observaciones'] = utf8_encode($f["observaciones"]);
				//$tmp['cantidad_item'] = utf8_encode($f["cantidad_item"]);
				$tmp['cantidad'] = utf8_encode($f["cantidad"]);
				$tmp['opcional'] = utf8_encode($f["opcional"])=='si' ? 'true':'false';
				$tmp['qtip'] = "Nombre: ".$tmp['nombre']." <br \/>Descripcion: ".$tmp["descripcion"];
				$tmp['qtipTitle']="Codigo: ".$tmp["codigo"];


				$nodes[] = $tmp;
			}

			if(sizeof($nodes)>0){
				echo json_encode($nodes);
			}
			else {
				echo '{}';
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
	}
	elseif($tipo=='raiz')
	{

		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ListarTipoUnidadConstructivaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node);

		if($res)
		{
			foreach ($Custom->salida as $f)
			{

				$tmp['text'] = utf8_encode($f["codigo"]." - ".$f["nombre"]." <b>[".$f["cantidad"]."]</b>");
				$tmp['id'] = utf8_encode($f["id_tipo_unidad_constructiva"]);
				$tmp['leaf'] = false;
				$tmp['terminado'] = utf8_encode($f["estado"])=='Terminado' ? 'true':'false';
				if($tmp['terminado']=='true'){
					$tmp['icon'] = "../../../lib/imagenes/tuc.png";
				}
				else{
					$tmp['icon'] = "../../../lib/imagenes/etuc.png";
				}

				$tmp['allowDelete']	= true;
				$tmp['allowEdit']	= true;
				//$tmp['allowDrag']	= true;

				$tmp['tipo'] = "rama";
				$tmp['id_p'] = utf8_encode($f["id_tuc_padre"]);
				$tmp['nombre_p'] = utf8_encode($f["nombre_padre"]);
				$tmp['codigo'] = utf8_encode($f["codigo"]);
				$tmp['nombre'] = utf8_encode($f["nombre"]);
				$tmp['descripcion'] = utf8_encode($f["descripcion"]);
				$tmp['observaciones'] = utf8_encode($f["observaciones"]);
				//$tmp['cantidad_item'] = utf8_encode($f["cantidad_item"]);
				$tmp['id_composicion_tuc'] = utf8_encode($f["id_composicion_tuc"]);
				$tmp['cantidad'] = utf8_encode($f["cantidad"]);
				$tmp['opcional'] = utf8_encode($f["opcional"])=='si' ? 'true':'false';
				$tmp['qtip'] = "Nombre: ".$tmp['nombre']." <br \/>Descripcion: ".$tmp["descripcion"];
				$tmp['qtipTitle']="Codigo: ".$tmp["codigo"];


				$nodes[] = $tmp;
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

		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ListarTipoUnidadConstructivaItem($cant,$puntero,'ITEM.id_supergrupo,COMP.orden,ITEM.codigo',$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node);

		/*************LISTA ITEM ************/
		if($res)
		{
			foreach ($Custom->salida as $f){

				//$tmp['text'] = utf8_encode($f["codigo_item"])." - ".utf8_encode($f["nombre_item"]." <b>[".$f["cantidad"]."]</b>");
				if($f["cant_demasia"]>0){
					$dem="<b><FONT COLOR=blue>+ ".$f["demasia_porc"]."%</FONT></b>";
					$tmp['text'] = utf8_encode($f["codigo_item"]). " - ".utf8_encode($f["nombre_item"]." <b>[".$f["cant_tot"]."]</b>")." $dem";
				}
				else{
					$tmp['text'] = utf8_encode($f["codigo_item"]). " - ".utf8_encode($f["nombre_item"]." <b>[".$f["cant_tot"]."]</b>");
				}
				$tmp['id'] = utf8_encode($f["id_item"]);
				$tmp['leaf']= true;
				$tmp['allowDelete'] = true;
				$tmp['allowEdit'] = true;
				$tmp['icon'] = "../../../lib/imagenes/item.png";
				$tmp['tipo'] = "item";
				$tmp['id_p'] = utf8_encode($f["id_tipo_unidad_constructiva"]);
				$tmp['codigo'] = utf8_encode($f["codigo_item"]);
				$tmp['nombre'] = utf8_encode($f["nombre_item"]);
				$tmp['descripcion'] = utf8_encode($f["descripcion"]);
				$tmp['observaciones'] = utf8_encode($f["observaciones"]);
				//$tmp['cantidad'] = utf8_encode($f["cantidad"]);
				$tmp['cantidad'] = utf8_encode($f["cant_tot"]);
				$tmp['opcional'] = utf8_encode($f["cosiderar_repeticion"])=='si' ? 'true':'false';
				$tmp['qtip'] = "Nombre: ".$tmp['nombre']." <br \/>Descripcion: ".$tmp["descripcion"]." <br \/>Cantidad: ".$f["cantidad"]." <br \/>Demasia: ".$f["cant_demasia"];
				$tmp['qtipTitle']="Codigo: ".$tmp["codigo"];

				$nodes[] = $tmp;
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


		if(sizeof($nodes)>0){
			echo json_encode($nodes);
		}
		else {
			echo '{}';
		}

	}

	elseif($tipo=='rama')
	{

		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ListarTipoUnidadConstructivaRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node);

		if($res)
		{
			foreach ($Custom->salida as $f)
			{

				$tmp['text'] = utf8_encode($f["codigo"]." - ".utf8_encode($f["nombre"])." <b>[".$f["cantidad"]."]</b>");
				$tmp['id'] = utf8_encode($f["id_tipo_unidad_constructiva"]);
				$tmp['leaf'] = false;
				$tmp['terminado'] = utf8_encode($f["estado"])=='Terminado' ? 'true':'false';
				if($tmp['terminado']=='true'){
					$tmp['icon'] = "../../../lib/imagenes/tuc.png";
				}
				else{
					$tmp['icon'] = "../../../lib/imagenes/etuc.png";
				}

				$tmp['allowDelete']	= true;
				$tmp['allowEdit']	= true;
				//$tmp['allowDrag']	= true;

				$tmp['tipo'] = "rama";
				$tmp['id_p'] = utf8_encode($f["id_tuc_padre"]);
				$tmp['nombre_p'] = utf8_encode($f["nombre_padre"]);
				$tmp['codigo'] = utf8_encode($f["codigo"]);
				$tmp['nombre'] = utf8_encode($f["nombre"]);
				$tmp['descripcion'] = utf8_encode($f["descripcion"]);
				$tmp['observaciones'] = utf8_encode($f["observaciones"]);
				//$tmp['cantidad'] = utf8_encode($f["cantidad_item"]);
				$tmp['id_composicion_tuc'] = utf8_encode($f["id_composicion_tuc"]);
				$tmp['cantidad'] = utf8_encode($f["cantidad"]);
				$tmp['opcional'] = utf8_encode($f["opcional"])=='si' ? 'true':'false';
				$tmp['qtip'] = "Nombre: ".$tmp['nombre']." <br \/>Descripcion: ".$tmp["descripcion"];
				$tmp['qtipTitle']="Codigo: ".$tmp["codigo"];


				$nodes[] = $tmp;
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

		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ListarTipoUnidadConstructivaItem($cant,$puntero,'ITEM.id_supergrupo,COMP.orden,ITEM.codigo',$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node);

		/*************LISTA ITEM ************/
		if($res)
		{
			foreach ($Custom->salida as $f){

				//$tmp['text'] = utf8_encode($f["codigo_item"]). " - ".utf8_encode($f["nombre_item"]." <b>[".$f["cantidad"]."]</b>");
				if($f["cant_demasia"]>0){
					$dem="<b><FONT COLOR=blue>+ ".$f["demasia_porc"]."%</FONT></b>";
					$tmp['text'] = utf8_encode($f["codigo_item"]). " - ".utf8_encode($f["nombre_item"]." <b>[".$f["cant_tot"]."]</b>")." $dem";
				}
				else{
					$tmp['text'] = utf8_encode($f["codigo_item"]). " - ".utf8_encode($f["nombre_item"]." <b>[".$f["cant_tot"]."]</b>");
				}
				$tmp['id'] = utf8_encode($f["id_item"]);
				$tmp['leaf']= true;
				$tmp['allowDelete'] = true;
				$tmp['allowEdit'] = true;
				$tmp['icon'] = "../../../lib/imagenes/item.png";
				$tmp['tipo'] = "item";
				$tmp['id_p'] = utf8_encode($f["id_tipo_unidad_constructiva"]);
				$tmp['codigo'] = utf8_encode($f["codigo_item"]);
				$tmp['nombre'] = utf8_encode($f["nombre_item"]);
				$tmp['descripcion'] = utf8_encode($f["descripcion"]);
				$tmp['observaciones'] = utf8_encode($f["observaciones"]);
				//$tmp['cantidad'] = utf8_encode($f["cantidad"]);
				$tmp['cantidad'] = utf8_encode($f["cant_tot"]);
				$tmp['opcional'] = utf8_encode($f["cosiderar_repeticion"])=='si' ? 'true':'false';
				$tmp['qtip'] = "Nombre: ".$tmp['nombre']." <br \/>Descripcion: ".$tmp["descripcion"]." <br \/>Cantidad: ".$f["cantidad"]." <br \/>Demasia: ".$f["cant_demasia"];
				$tmp['qtipTitle']="Codigo: ".$tmp["codigo"];

				$nodes[] = $tmp;
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


		if(sizeof($nodes)>0){
			echo json_encode($nodes);
		}
		else {
			echo '{}';
		}

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





