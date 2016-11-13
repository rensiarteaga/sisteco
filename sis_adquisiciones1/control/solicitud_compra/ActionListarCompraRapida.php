<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCompraRapida.php
Propósito:				Permite realizar el listado en tad_solicitud_compra
Tabla:					tad_tad_solicitud_compra
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-07-01 16:29:11
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionListarCompraRapida .php';

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

	if($sort == ''){ $sortcol = 'id_solicitud_compra';}
	elseif($sort=='num_solicitud_peri')$sortcol='periodo,num_solicitud';
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


	if($sort=='num_solicitud_peri')
	{
		$sortcol="periodo $sortdir,num_solicitud $sortdir";
	}
	else{
		$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'SolicitudCompraRap');
		$sortcol = $crit_sort->get_criterio_sort();
	}


	if($tipo_adq=='Servicio'){
		$criterio_filtro=$criterio_filtro." AND TIPADQ.tipo_adq=''Servicio''";
	}
	if($tipo_adq=='Bien'){
		$criterio_filtro=$criterio_filtro." AND TIPADQ.tipo_adq=''Bien''";
	}


	//echo $sortcol;
	//exit;

	$id_empresa=$_SESSION["ss_id_empresa"];

	
	//JRR:  se comenta por que en la vista vad_soldet_grupo se controlan lassolicitudes con detalles no agrupados 
	//añadimos criterio de filtro para que se listen solo solicitudes con detalle pendiente
	//$criterio_filtro=$criterio_filtro." AND SOLCOM.id_solicitud_compra in (select id_solicitud_compra from compro.tad_solicitud_compra_det where estado_reg=''pendiente'')";
	//Obtiene el total de los registros
	$res = $Custom -> ContarCompraRapida($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_empresa);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCompraRapida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_empresa);

	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_solicitud_compra',$f["id_solicitud_compra"]);
			$xml->add_nodo('num_solicitud',$f["num_solicitud"]);
			$xml->add_nodo('id_fina_regi_prog_proy_acti',$f["id_fina_regi_prog_proy_acti"]);
			$xml->add_nodo('desc_fina_regi_prog_proy_acti',$f["desc_fina_regi_prog_proy_acti"]);
			$xml->add_nodo('id_empleado_frppa_solicitante',$f["id_empleado_frppa_solicitante"]);
			$xml->add_nodo('desc_empleado_tpm_frppa',$f["desc_empleado_tpm_frppa"]);


			$xml->add_nodo('localidad',$f["localidad"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
			$xml->add_nodo('id_unidad_organizacional',$f["id_unidad_organizacional"]);
			$xml->add_nodo('desc_unidad_organizacional',$f["desc_unidad_organizacional"]);
			$xml->add_nodo('id_tipo_categoria_adq',$f["id_tipo_categoria_adq"]);
			$xml->add_nodo('desc_tipo_categoria_adq',$f["desc_tipo_categoria_adq"]);
			$xml->add_nodo('tipo_adjudicacion',$f["tipo_adjudicacion"]);
			$xml->add_nodo('tipo_adq',$f["tipo_adq"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('nombre',$f["nombre"]);

			$xml->add_nodo('id_financiador',$f["id_financiador"]);
			$xml->add_nodo('id_regional',$f["id_regional"]);
			$xml->add_nodo('id_programa',$f["id_programa"]);
			$xml->add_nodo('id_proyecto',$f["id_proyecto"]);
			$xml->add_nodo('id_actividad',$f["id_actividad"]);
			$xml->add_nodo('nombre_financiador',$f["nombre_financiador"]);
			$xml->add_nodo('nombre_regional',$f["nombre_regional"]);
			$xml->add_nodo('nombre_programa',$f["nombre_programa"]);
			$xml->add_nodo('nombre_proyecto',$f["nombre_proyecto"]);
			$xml->add_nodo('nombre_actividad',$f["nombre_actividad"]);
			$xml->add_nodo('codigo_financiador',$f["codigo_financiador"]);
			$xml->add_nodo('codigo_regional',$f["codigo_regional"]);
			$xml->add_nodo('codigo_programa',$f["codigo_programa"]);
			$xml->add_nodo('codigo_proyecto',$f["codigo_proyecto"]);
			$xml->add_nodo('codigo_actividad',$f["codigo_actividad"]);
			$xml->add_nodo('num_solicitud_peri',$f["periodo"]."/".$f["num_solicitud"]);
			$xml->add_nodo('gestion',$f["gestion"]);

			$xml->add_nodo('categoria',$f["categoria"]);
			

			if($f["permite_agrupar"]==1){
				$xml->add_nodo('permite_agrupar','Si');
			}
			else{

				$xml->add_nodo('permite_agrupar','No');

			}
            
           $xml->add_nodo('avance',$f["avance"]);
           $xml->add_nodo('gestion_sgte',$f["gestion_sgte"]);
		   $xml->add_nodo('id_depto',$f["id_depto"]);

			$xml->add_nodo('nro_solicitud_cadena',$f["nro_solicitud_cadena"]);

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