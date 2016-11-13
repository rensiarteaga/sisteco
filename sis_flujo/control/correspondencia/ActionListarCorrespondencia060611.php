<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCorrespondencia.php
Propósito:				Permite realizar el listado en tfl_correspondencia
Tabla:					tfl_tfl_correspondencia
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2011-02-11 10:52:59
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloFlujo.php');

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = 'ActionListarCorrespondencia .php';

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
	
	//Flag para limpiar el criterio de Ordenación
	//aayaviri 20-04-2011 11:42
	if($limpiar_ord==1){
		$nombre='correspondencia-'.$vista;
		unset($_SESSION["'$nombre'"]);
		$sortcol = 'id_correspondencia';
		$sortdir = 'desc';
	}
	else{
		if($sort == '') $sortcol = 'id_correspondencia';
		else $sortcol = $sort;
	
		if($dir == '') $sortdir = 'desc';
		else $sortdir = $dir;
	}
	//-----------------------
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

	if(isset($id_correspondencia_fk)){
		$criterio_filtro.=" and CORRE.id_correspondencia_fk=$id_correspondencia_fk ";
	}
	
	if($vista=='recibido'){
		$criterio_filtro.=" and CORRE.id_correspondencia_fk is not null ";
		$criterio_filtro.=" and CORRE.estado!=''archivado''";
		if(isset($tipo)){
			$criterio_filtro.=" and CORRE.tipo = ''$tipo''";
		}
	}
	if($vista=='recibido_archivado'){
		$criterio_filtro.=" and CORRE.estado=''archivado''";
	}
	
	if($vista=='externo_recibido'){
		$criterio_filtro.=" and CORRE.id_correspondencia_fk is null and CORRE.estado=''borrador_recibido''";
	}

	if($vista=='detalle_externo')
	{
		$criterio_filtro.=" and CORRE.id_correspondencia_fk is null and (CORRE.estado=''registrado_recibido'' or CORRE.estado=''recibido'')";
		if(isset($id_gestion)){
				$criterio_filtro.=" and CORRE.id_gestion = $id_gestion";
				if(isset($mes)&&isset($gestion)){
					if($mes=='12'){
						$mesNext = '01';
						$gestionNext = $gestion+1;
					}
					else{
						$mesNext = $mes+1;
						if($mesNext<10)
							$mesNext= '0'.$mesNext;
						$gestionNext = $gestion;
					}
					$criterio_filtro.=" and CORRE.fecha_reg>=".$gestion.$mes."01 and CORRE.fecha_reg <".$gestionNext.$mesNext."01";
				}
			}
	}
	if($vista=='externo_derivado'){
		if(isset($estado)){
			$criterio_filtro.=" and CORRE.id_correspondencia_fk is null and CORRE.estado=''$estado''";
		}
		else
			$criterio_filtro.=" and CORRE.id_correspondencia_fk is null and CORRE.estado<>''borrador_recibido''";
	}
	
	if($empleado=='si'){
		$criterio_filtro.=" and CORRE.id_empleado is not null ";
	}
	
	if(!isset($vista)){
		if(isset($tipo)){
			$criterio_filtro.=" and CORRE.tipo = ''$tipo''";
		}/*
		if(isset($id_gestion)){
			$criterio_filtro.=" and CORRE.id_gestion = $id_gestion";
			if(isset($mes)&&isset($gestion)){
				if($mes=='12'){
					$mesNext = '01';
					$gestionNext = $gestion+1;
				}
				else{
					$mesNext = $mes+1;
					if($mesNext<10)
						$mesNext= '0'.$mesNext;
					$gestionNext = $gestion;
				}
				$criterio_filtro.=" and CORRE.fecha_origen>=".$gestion.$mes."01 and CORRE.fecha_origen <".$gestionNext.$mesNext."01";
			}
		}*/
	}

	//Obtiene el criterio de orden de columnas
	if($sortcol=='fecha_reg'){
		$sortcol='CORRE.fecha_reg';
	}
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'correspondencia-'.$vista);
	

	//var_dump($crit_sort);
	$sortcol = $crit_sort->get_criterio_sort();
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarCorrespondencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$vista);
//	var_dump($Custom->query);
//	exit;
	if($res) $total_registros= $Custom->salida;
	
	
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCorrespondencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$vista);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_correspondencia',$f["id_correspondencia"]);
			$xml->add_nodo('id_depto',$f["id_depto"]);
			$xml->add_nodo('desc_depto',$f["desc_depto"]);
			$xml->add_nodo('numero',$f["numero"]);
			$xml->add_nodo('id_documento',$f["id_documento"]);
			$xml->add_nodo('desc_documento',$f["desc_documento"]);
			$xml->add_nodo('id_empleado',$f["id_empleado"]);
			$xml->add_nodo('desc_empleado',$f["desc_empleado"]);
			$xml->add_nodo('id_uo',$f["id_uo"]);
			$xml->add_nodo('desc_uo',$f["desc_uo"]);
			$xml->add_nodo('id_institucion',$f["id_institucion"]);
			$xml->add_nodo('desc_institucion',$f["desc_institucion"]);
			$xml->add_nodo('id_persona',$f["id_persona"]);
			$xml->add_nodo('desc_persona',$f["desc_persona"]);
			$xml->add_nodo('referencia',$f["referencia"]);
			$xml->add_nodo('fecha_origen',$f["fecha_origen"]);
			$xml->add_nodo('hora_origen',$f["hora_origen"]);
			$xml->add_nodo('fecha_destino',$f["fecha_destino"]);
			$xml->add_nodo('hora_destino',$f["hora_destino"]);
			$xml->add_nodo('desc_usuario',$f["desc_usuario"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('accion',$f["accion"]);
			$xml->add_nodo('tipo',$f["tipo"]);
			$xml->add_nodo('url_archivo',$f["url_archivo"]);
			$xml->add_nodo('empleado_remitente',$f["empleado_remitente"]);
			$xml->add_nodo('uo_remitente',$f["uo_remitente"]);
			$xml->add_nodo('id_correspondencia_fk',$f["id_correspondencia_fk"]);
			$xml->add_nodo('padre',$f["padre"]);
			$xml->add_nodo('id_tipo_accion',$f["id_tipo_accion"]);
			$xml->add_nodo('nombre_tipo_accion',$f["nombre_tipo_accion"]);
			$xml->add_nodo('mensaje',$f["mensaje"]);
			$xml->add_nodo('estado',$f["estado"]);
			$xml->add_nodo('acciones',$f["acciones"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('observaciones_estado',$f["observaciones_estado"]);
			$xml->add_nodo('derivado',$f["derivado"]);
			$xml->add_nodo('dias_derivado',$f["dias_derivado"]);
			$xml->add_nodo('fecha_derivado',$f["fecha_derivado"]);
			$xml->add_nodo('cite',$f["cite"]);
			$xml->add_nodo('ver',$f["ver"]);
			
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