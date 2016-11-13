<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarGrupoProcComMul.php
Propósito:				Permite realizar el listado en tad_grupo_sp_det
Tabla:					t_tad_grupo_sp_det
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-20 17:42:58
Versión:				1.0.0
Autor:					Rensi Arteaga Copari
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionListarGrupoProcComMul .php';

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

	if($sort == '') $sortcol = 'id_proceso_compra_det';
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

	//$cond->add_criterio_extra("PRCOMULDET.id_proceso_compra_det",$m_id_proceso_compra_det);

	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'GrupoSpDet');
	$sortcol = $crit_sort->get_criterio_sort();

 
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarGrupoProcDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_proceso_compra,$id_item,$id_servicio);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarGrupoProcDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_proceso_compra,$id_item,$id_servicio);

	if($res){
		$xml = new cls_manejo_xml('ROOT');
		
		$conta=0;

		$grupo='';
		$llave=0;


       
		foreach ($Custom->salida as $f){
			if($llave==$f["id_proceso_compra_det"] || $llave==0){
				if($grupo!=''){
					//$grupo.=",<a href=\"javascript:_CP.loadWindows('../../../sis_adquisiciones/vista/caracteristica/caracteristica_min.php?m_id_solicitud_compra_det=".$f['id_solicitud_compra_det']."','Caracteristicas Adicionales',{ventana:{width:'90%',height:'90%'}})\">[".$f['periodo']."/".$f['num_solicitud'].",".$f['periodo']."/".$f['num_solicitud_sis']."]</a>";
					
					$grupo.=",<a href=\"javascript:_CP.loadWindows('../../../sis_adquisiciones/vista/caracteristica/caracteristica_min.php?m_id_solicitud_compra_det=".$f['id_solicitud_compra_det']."','Caracteristicas Adicionales',{ventana:{width:'90%',height:'90%'}})\">[".$f['periodo']."/".$f['num_solicitud']."]</a>";
					$solicitantes.=", ".$f["solicitante"];
					$id_proc_det=$f['id_proceso_compra_det'];

				}
				else{
					//$grupo="<a href=\"javascript:_CP.loadWindows('../../../sis_adquisiciones/vista/caracteristica/caracteristica_min.php?m_id_solicitud_compra_det=".$f['id_solicitud_compra_det']."','Caracteristicas Adicionales',{ventana:{width:'90%',height:'90%'}})\">[".$f['periodo']."/".$f['num_solicitud'].",".$f['periodo']."/".$f['num_solicitud_sis']."]</a>";
					$grupo="<a href=\"javascript:_CP.loadWindows('../../../sis_adquisiciones/vista/caracteristica/caracteristica_min.php?m_id_solicitud_compra_det=".$f['id_solicitud_compra_det']."','Caracteristicas Adicionales',{ventana:{width:'90%',height:'90%'}})\">[".$f['periodo']."/".$f['num_solicitud']."]</a>";
				    $solicitantes=$f["solicitante"];
				    $id_proc_det=$f['id_proceso_compra_det'];
				}

			}
			else{


				$conta++;
				$grupo=urlencode($grupo);
				$grupo=str_replace("a+","a%20",$grupo);
				
				$xml->add_rama('ROWS');
				$xml->add_nodo('numero',$conta);
				$xml->add_nodo('id_proceso_compra_det',$id_proc_det);
				$xml->add_nodo('id_proceso_compra',$f["id_proceso_compra"]);
				$xml->add_nodo('grupo',$grupo);
				$xml->add_nodo('solicitantes',$solicitantes);
				
				$xml->fin_rama();

				//$grupo="<a href=\"javascript:_CP.loadWindows('../../../sis_adquisiciones/vista/caracteristica/caracteristica_min.php?m_id_solicitud_compra_det=".$f['id_solicitud_compra_det']."','Caracteristicas Adicionales',{ventana:{width:'90%',height:'90%'}})\">[".$f['periodo']."/".$f['num_solicitud'].",".$f['periodo']."/".$f['num_solicitud_sis']."]</a>";
				$grupo="<a href=\"javascript:_CP.loadWindows('../../../sis_adquisiciones/vista/caracteristica/caracteristica_min.php?m_id_solicitud_compra_det=".$f['id_solicitud_compra_det']."','Caracteristicas Adicionales',{ventana:{width:'90%',height:'90%'}})\">[".$f['periodo']."/".$f['num_solicitud']."]</a>";
				
				$solicitantes=$f["solicitante"];
			}
			
			
			
			

			$llave=$f["id_proceso_compra_det"];
			$id_proc_det=$f["id_proceso_compra_det"];
		}

		$grupo=urlencode($grupo);
		$grupo=str_replace("a+","a%20",$grupo);
		
		
		
		$conta++;
		$xml->add_rama('ROWS');
		$xml->add_nodo('numero',$conta);
		$xml->add_nodo('id_proceso_compra_det',$id_proc_det);
		$xml->add_nodo('id_proceso_compra',$f["id_proceso_compra"]);
		$xml->add_nodo('grupo',$grupo);
		$xml->add_nodo('solicitantes',$solicitantes);
		$xml->fin_rama();


		$xml->add_nodo('TotalCount',$conta);

		$xml->mostrar_xml();
		
		
	/////////////////////////////////////////////////////	
	
	/*
		foreach ($Custom->salida as $f){

	
		
		
		$conta++;
		$xml->add_rama('ROWS');
		$xml->add_nodo('numero',$conta);
		$xml->add_nodo('id_proceso_compra_det',$f["id_proceso_compra_det"]);
		$xml->add_nodo('id_proceso_compra',$f["id_proceso_compra"]);
		//$xml->add_nodo('grupo',$grupo);
		$xml->add_nodo('solicitantes',$solicitantes);
		$xml->fin_rama();

		}
		$xml->add_nodo('TotalCount',$conta);

		$xml->mostrar_xml();
		*/
		
		
	}
	else{
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