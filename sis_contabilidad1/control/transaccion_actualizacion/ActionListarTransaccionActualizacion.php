<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarTransaccionActualizacion.php
Propósito:				Permite desplegar los detalle de actualizacion
Tabla:					tct_transaccion_actualizacion
Parámetros:				$cant
$puntero
$sortcol
$sortdir
$criterio_filtro
$id_usuario_asignacion

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		15/12/2010
Versión:				1.0.0
Autor:					Ana Maria Villegas Quispe
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");
include_once('../../../lib/lib_control/GestionarExcel.php');
$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarTransaccionActualizacion.php';

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

	//if($sort == '') $sortcol = 'id_actualizacion_detalle';
	if($sort == '') $sortcol = 'comprob.id_comprobante';
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
	$cond->add_criterio_extra("traact.id_actualizacion_detalle",$id_actualizacion_detalle);
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	//$criterio_filtro = $criterio_filtro. ' AND traact.id_actualizacion_detalle='.$id_actualizacion_detalle;
	//echo $criterio_filtro;
	//exit;
	if (sizeof($_GET) > 0){
	 
		$CantFiltros=$_GET["CantFiltros"];
		$nro_columnas=$_GET["nro_columnas"];		
		$titulo_reporte_excel=$_GET["titulo_reporte_excel"];		
		$get=true;
	}
	if (sizeof($_POST) > 0){
		$CantFiltros=$_POST["CantFiltros"];
		$nro_columnas=$_POST["nro_columnas"];	
		$titulo_reporte_excel=$_POST["titulo_reporte_excel"];		
		$get=false;
	}
	//echo "criterio".$criterio_filtro;
	//exit;
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Transaccion_Actualizacion');
	$sortcol = $crit_sort->get_criterio_sort();
	 if ($reporte_excel=='si')
	{	//recupera los valores de las columnas
		for($i=0;$i<$nro_columnas;$i++){
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
		
		 
		$res = $Custom->ListarTransaccionActualizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);										
		 
		$Excel->setDetalle($Custom->salida);
		$Excel->setFin();		
		}else{
	//Obtiene el total de los registros
	$res = $Custom -> ContarTransaccionActualizacion($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarTransaccionActualizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	//echo $Custom->query;
	//exit;
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			
			$xml->add_nodo('id_transaccion_actualizacion',$f["id_transaccion_actualizacion"]);
 			$xml->add_nodo('id_transaccion',$f["id_transaccion"]);
 			$xml->add_nodo('identificador',$f["identificador"]);
  			$xml->add_nodo('saldo',$f["saldo"]);
  			$xml->add_nodo('saldo_actualizado',$f["saldo_actualizado"]);
  			$xml->add_nodo('id_actualizacion_detalle',$f["id_actualizacion_detalle"]);
  			$xml->add_nodo('importe_moneda_actualizacion',$f["importe_moneda_actualizacion"]);
  			$xml->add_nodo('tipo_actualizacion',$f["tipo_actualizacion"]);
  			$xml->add_nodo('tipo_cambio_inicial',$f["tipo_cambio_inicial"]);
  			$xml->add_nodo('tipo_cambio_final',$f["tipo_cambio_final"]);
  			$xml->add_nodo('diferencial_actualizacion',$f["diferencial_actualizacion"]);
  			$xml->add_nodo('id_actualizacion_detalle_saldo',$f["id_actualizacion_detalle_saldo"]);
 			$xml->add_nodo('fecha',$f["fecha"]);
 		
			
			
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
