<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDepartamentoContaConta.php
Propósito:				Permite realizar el listado en tpm_depto_conta
Tabla:					tpm_depto_conta
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2009-06-17 9:46:13
Versión:				1.0.0
Autor:					AVQ
**********************************************************
*/
session_start();
include_once('../LibModeloParametros.php');

$Custom = new cls_CustomDBParametros();
$nombre_archivo = 'ActionListarDepartamentoConta.php';

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

	if($sort == '') $sortcol = 'id_depto_conta';
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
	/*echo $id_depto;
	exit;*/
	if($tipo_vista=='rep_balance'){
	$criterio_filtro=$criterio_filtro ."AND DEPTO.id_subsistema=9";
	/*echo "entra aqui?".$id_depto;
	exit;*/
	}else{
	$criterio_filtro = $criterio_filtro . " AND DEPCON.id_depto=".$id_depto;
	}
	
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'DeptoConta');
	$sortcol = $crit_sort->get_criterio_sort();
	
	
	//Obtiene el total de los registros
	
	$res = $Custom -> ContarDepartamentoConta($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarDepartamentoConta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
       foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_depto_conta',$f["id_depto_conta"]);
			$xml->add_nodo('id_depto',$f["id_depto"]);
			$xml->add_nodo('id_fina_regi_prog_proy_acti',$f["id_ep"]);
			$xml->add_nodo('id_unidad_organizacional',$f["id_uo"]);
			$xml->add_nodo('sw_central',$f["sw_central"]);
			$xml->add_nodo('sw_estado',$f["sw_estado"]);
			$xml->add_nodo('nombre_depto',$f["nombre_depto"]);
			$xml->add_nodo('desc_ep',$f["desc_ep"]);
			$xml->add_nodo('nombre_unidad',$f["desc_uo"]);
			$xml->add_nodo('id_financiador',$f["id_financiador"]);
			$xml->add_nodo('id_regional',$f["id_regional"]);
			$xml->add_nodo('id_programa',$f["id_programa"]);
			$xml->add_nodo('id_proyecto',$f["id_proyecto"]);
			$xml->add_nodo('id_actividad',$f["id_actividad"]);
			$xml->add_nodo('codigo_financiador',$f["codigo_financiador"]);
			$xml->add_nodo('codigo_regional',$f["codigo_regional"]);
			$xml->add_nodo('codigo_programa',$f["codigo_programa"]);
			$xml->add_nodo('codigo_proyecto',$f["codigo_proyecto"]);
			$xml->add_nodo('codigo_actividad',$f["codigo_actividad"]);
			$xml->add_nodo('nombre_financiador',$f["nombre_financiador"]);
			$xml->add_nodo('nombre_regional',$f["nombre_regional"]);
			$xml->add_nodo('nombre_programa',$f["nombre_programa"]);
			$xml->add_nodo('nombre_proyecto',$f["nombre_proyecto"]);
			$xml->add_nodo('nombre_actividad',$f["nombre_actividad"]);
			$xml->add_nodo('id_cuenta_auxiliar',$f["id_cuenta_auxiliar"]);
			$xml->add_nodo('desc_cta_aux',$f["desc_cta_aux"]);
			$xml->add_nodo('sw_rendicion',$f["sw_rendicion"]);
			$xml->add_nodo('sw_documento',$f["sw_documento"]);
			$xml->add_nodo('id_depto_tesoro',$f["id_depto_tesoro"]);
			$xml->add_nodo('id_depto_conta_central',$f["id_depto_conta_central"]);
			$xml->add_nodo('nombre_depto_conta',$f["nombre_depto_conta"]);
			$xml->add_nodo('nombre_depto_tesoro',$f["nombre_depto_tesoro"]);
			$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
			$xml->add_nodo('desc_presupuesto',$f["desc_presupuesto"]);
			
			$xml->add_nodo('id_partida_sueldos',$f["id_partida_sueldos"]);
			$xml->add_nodo('id_cuenta_sueldos',$f["id_cuenta_sueldos"]);
			$xml->add_nodo('id_auxiliar_sueldos',$f["id_auxiliar_sueldos"]);
			$xml->add_nodo('id_cuenta_auxiliar_sueldos',$f["id_cuenta_auxiliar_sueldos"]);
			$xml->add_nodo('cuenta_aux_sueldo',$f["cuenta_aux_sueldo"]);
			$xml->add_nodo('partida_sueldo',$f["partida_sueldo"]);
			$xml->add_nodo('id_sucursal',$f["id_sucursal"]);
			$xml->add_nodo('nombre',$f["nombre"]);
			
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