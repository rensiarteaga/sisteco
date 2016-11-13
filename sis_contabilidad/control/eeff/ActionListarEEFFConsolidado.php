<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDestino.php
Prop�sito:				Permite realizar el listado en tpr_destino
Tabla:					t_tpr_destino
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		2008-07-04 08:54:29
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');
include_once('../../../lib/lib_control/GestionarExcel.php');

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarEEFF.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Par�metros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'nro_cuenta';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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
	//echo $titulo_reporte_excel; echo "get ".$_GET["titulo_reporte_excel"]; echo "post".$_GET["titulo_reporte_excel"];	exit();
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
	
	for($i=0;$i<$CantFiltros;$i++){ 		
		$cond->add_condicion_filtro($_GET["filterCol_$i"], $_GET["filterValue_$i"], $_GET["filterAvanzado_$i"]);
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	 
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
		//$cant=100000000;
		$cant=1000000; 
		$puntero=0;
		 
		$Excel->SetTitulo($titulo_reporte_excel,0,3,$nro_columnas); //Colocamos el titulo al reporte
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
		 
		$res = $Custom->ListarEEFFConsolidado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad, $_GET['ids_depto'],$_GET['id_moneda'],$_GET['fecha_trans'],$_GET['id_reporte_eeff'], $_GET['id_parametro'],$_GET['nivel'],$_GET['fecha_trans_ini'],$_GET['sw_actualizacion']);
		 
		$Excel->setDetalle($Custom->salida);
		$Excel->setFin();		
	}
	else {
		$cant=100000000;
 		//Obtiene el total de los registros
 		$res = $Custom -> ContarEEFFConsolidado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad, $_POST['ids_depto'],$_POST['id_moneda'],$_POST['fecha_trans'],$_POST['id_reporte_eeff'], $_POST['id_parametro'],$_POST['nivel'],$_POST['fecha_trans_ini'],$_POST['sw_actualizacion']);
		if($res) $total_registros= $Custom->salida;
		
		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ListarEEFFConsolidado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad, $_POST['ids_depto'],$_POST['id_moneda'],$_POST['fecha_trans'],$_POST['id_reporte_eeff'], $_POST['id_parametro'],$_POST['nivel'],$_POST['fecha_trans_ini'],$_POST['sw_actualizacion']);
		//echo  $Custom->query; exit(); 
		if($res)
		{	$contador=0;
			$xml = new cls_manejo_xml('ROOT');
			$xml->add_nodo('TotalCount',$total_registros);
			 
			foreach ($Custom->salida as $f){
				$xml->add_rama('ROWS');
				$xml->add_nodo('nro_cuenta',$f["nro_cuenta"]);
				$xml->add_nodo('nombre_cuenta',$f["nombre_cuenta"]);
				$xml->add_nodo('nro_cuenta_sigma',$f["nro_cuenta_sigma"]);
				$xml->add_nodo('nombre_cuenta_sigma',$f["nombre_cuenta_sigma"]);
				$xml->add_nodo('depto_0',$f["depto_0"]);
				$xml->add_nodo('depto_1',$f["depto_1"]);
				$xml->add_nodo('depto_2',$f["depto_2"]);
				$xml->add_nodo('depto_3',$f["depto_3"]);
				$xml->add_nodo('depto_4',$f["depto_4"]);
				$xml->add_nodo('depto_5',$f["depto_5"]);
				$xml->add_nodo('depto_6',$f["depto_6"]);
				$xml->add_nodo('depto_7',$f["depto_7"]);
				$xml->add_nodo('depto_8',$f["depto_8"]);
				$xml->add_nodo('depto_9',$f["depto_9"]);
				$xml->add_nodo('depto_10',$f["depto_10"]);
				$xml->add_nodo('depto_11',$f["depto_11"]);
				$xml->add_nodo('depto_12',$f["depto_12"]);
				$xml->add_nodo('depto_13',$f["depto_13"]);
				$xml->add_nodo('depto_14',$f["depto_14"]);
				$xml->add_nodo('depto_15',$f["depto_15"]);
				$xml->add_nodo('depto_16',$f["depto_16"]);
				$xml->add_nodo('depto_17',$f["depto_17"]);
				$xml->add_nodo('depto_18',$f["depto_18"]);
				$xml->add_nodo('depto_19',$f["depto_19"]);
				$xml->add_nodo('depto_20',$f["depto_20"]);
				$xml->add_nodo('depto_21',$f["depto_21"]);
				$xml->add_nodo('depto_22',$f["depto_22"]);
				$xml->add_nodo('depto_23',$f["depto_23"]);
				$xml->add_nodo('depto_24',$f["depto_24"]);
				$xml->add_nodo('depto_25',$f["depto_25"]);
				$xml->add_nodo('depto_26',$f["depto_26"]);
				$xml->add_nodo('depto_27',$f["depto_27"]);
				$xml->add_nodo('depto_28',$f["depto_28"]);
				$xml->add_nodo('depto_29',$f["depto_29"]);
				$xml->add_nodo('depto_30',$f["depto_30"]);
				$xml->add_nodo('total',$f["total"]);
				$xml->fin_rama();
				$contador++;
			}
			$xml->mostrar_xml();
		}else{
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
