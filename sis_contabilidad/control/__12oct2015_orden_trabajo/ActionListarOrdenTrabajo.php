<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarOrdenTrabajo.php
Propósito:				Permite realizar el listado en tct_orden_trabajo
Tabla:					tct_tct_orden_trabajo
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-08-27 09:14:44
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');
include_once('../../../lib/lib_control/GestionarExcel.php');

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarOrdenTrabajo .php';

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

	if($sort == '') $sortcol = 'desc_orden';
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
	
	//--jgl inicio
	$cond = new cls_criterio_filtro($decodificar);
	if (sizeof($_GET) > 0){	 
		$CantFiltros=$_GET["CantFiltros"];
		$nro_columnas=$_GET["nro_columnas"];		
		$titulo_reporte_excel='ORDEN DE TRABAJO';		
		$get=true;
	}
	
	if (sizeof($_POST) > 0){
		$CantFiltros=$_POST["CantFiltros"];
		$nro_columnas=$_POST["nro_columnas"];	
		$titulo_reporte_excel=$_POST["titulo_reporte_excel"];		
		$get=false;
	}
	
	for($i=0;$i<$CantFiltros;$i++){ 		
		$cond->add_condicion_filtro($_GET["filterCol_$i"], $_GET["filterValue_$i"], $_GET["filterAvanzado_$i"]);
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	//--jgl fin
	
	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	if ($sw_nulo){}else{
	  	$criterio_filtro=$criterio_filtro." AND ORDTRA.estado_orden = 1";	
	}
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'OrdenTrabajo');
	$sortcol = $crit_sort->get_criterio_sort();
	
	//--jgl inicio
	if ($reporte_excel=='si')
	{	//recupera los valores de las columnas
		for($i=0;$i<$nro_columnas;$i++)
		{
			$datosCabecera['valor'][$i]=$_GET["valor_$i"];
			$datosCabecera['columna'][$i]=$_GET["columna_$i"];
			$datosCabecera['align'][$i]=$_GET["align_$i"];
			$datosCabecera['width'][$i]=$_GET["width_$i"];		
		}	
		$Excel = new GestionarExcel();
		$Excel->SetNombreReporte($titulo_reporte_excel);
		//echo $titulo_reporte_excel; exit();
		$Excel->SetHoja("Hoja 1 Datos");
		$Excel->SetFila(3);
		$cant=100000000;
		$puntero=0;
	
		$Excel->SetTitulo($titulo_reporte_excel,0,3,$nro_columnas); //Colocamos el titulo al reporte
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas		
	
		$res = $Custom->ListarOrdenTrabajo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
			 
		$Excel->setDetalle($Custom->salida);
		$Excel->setFin();		
	}
	else {
		//Obtiene el total de los registros
		$res = $Custom -> ContarOrdenTrabajo($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
		if($res) $total_registros= $Custom->salida;
	
		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ListarOrdenTrabajo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		
		if($res)
		{
			$xml = new cls_manejo_xml('ROOT');
			$xml->add_nodo('TotalCount',$total_registros);
			
			if ($sw_nulo){}else{
				$xml->add_rama('ROWS');
				$xml->add_nodo('id_orden_trabajo',Null);
				$xml->add_nodo('desc_orden',"Ninguno");
				$xml->add_nodo('motivo_orden',"Sin OT");
				$xml->add_nodo('fecha_inicio',"");
				$xml->add_nodo('fecha_final',"");
				$xml->add_nodo('estado_orden',0);
				$xml->add_nodo('id_usuario',1);
				$xml->add_nodo('desc_usuario',"");
				$xml->add_nodo('apellido_paterno_persona',"");
				$xml->add_nodo('apellido_materno_persona',"");
				$xml->add_nodo('nombre_persona',"");
				$xml->add_nodo('fecha_activa',"");
				$xml->fin_rama();
			}
			
			foreach ($Custom->salida as $f)
			{
				$xml->add_rama('ROWS');
				$xml->add_nodo('id_orden_trabajo',$f["id_orden_trabajo"]);
				$xml->add_nodo('desc_orden',$f["desc_orden"]);
				$xml->add_nodo('motivo_orden',$f["motivo_orden"]);
				$xml->add_nodo('fecha_inicio',$f["fecha_inicio"]);
				$xml->add_nodo('fecha_final',$f["fecha_final"]);
				$xml->add_nodo('estado_orden',$f["estado_orden"]);
				$xml->add_nodo('id_usuario',$f["id_usuario"]);
				$xml->add_nodo('desc_usuario',$f["desc_usuario"]);
				$xml->add_nodo('apellido_paterno_persona',$f["apellido_paterno_persona"]);
				$xml->add_nodo('apellido_materno_persona',$f["apellido_materno_persona"]);
				$xml->add_nodo('nombre_persona',$f["nombre_persona"]);
				$xml->add_nodo('fecha_activa',$f["fecha_activa"]);
				
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