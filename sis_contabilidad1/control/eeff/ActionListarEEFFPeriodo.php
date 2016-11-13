<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDestino.php
Propósito:				Permite realizar el listado en tpr_destino
Tabla:					t_tpr_destino
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-07-04 08:54:29
Versión:				1.0.0
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
//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'nro_cuenta';
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
		$cant=100000000;
		$puntero=0;
	 
		$Excel->SetTitulo($titulo_reporte_excel,0,3,$nro_columnas); //Colocamos el titulo al reporte
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
		 
		$res = $Custom->ListarEEFFPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad, $_GET['ids_depto'],$_GET['id_moneda'],$_GET['ct_fecha'],$_GET['id_reporte_eeff'], $_GET['id_parametro'],$_GET['nivel'],$_GET['ids_periodo'],$_GET['sw_actualizacion']);
		 
		$Excel->setDetalle($Custom->salida);
		$Excel->setFin();		
	}else{
 		$cant=100000000;
		//Obtiene el total de los registros
		$res = $Custom -> ContarEEFFPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad, $_POST['ids_depto'],$_POST['id_moneda'],$_POST['ct_fecha'],$_POST['id_reporte_eeff'], $_POST['id_parametro'],$_POST['nivel'],$_POST['ids_periodo'],$_POST['sw_actualizacion']);
		
		if($res) $total_registros= $Custom->salida;
		
		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ListarEEFFPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad, $_POST['ids_depto'],$_POST['id_moneda'],$_POST['ct_fecha'],$_POST['id_reporte_eeff'], $_POST['id_parametro'],$_POST['nivel'],$_POST['ids_periodo'],$_POST['sw_actualizacion']);
				
		if($res){
			$contador=0;
			$xml = new cls_manejo_xml('ROOT');
			$xml->add_nodo('TotalCount',$total_registros);
					 
			foreach ($Custom->salida as $f){
				$xml->add_rama('ROWS');
				$xml->add_nodo('nro_cuenta',$f["nro_cuenta"]);
				$xml->add_nodo('nombre_cuenta',$f["nombre_cuenta"]);
				$xml->add_nodo('mes_1',$f["mes_1"]);
				$xml->add_nodo('mes_2',$f["mes_2"]);
				$xml->add_nodo('mes_3',$f["mes_3"]);
				$xml->add_nodo('mes_4',$f["mes_4"]);
				$xml->add_nodo('mes_5',$f["mes_5"]);
				$xml->add_nodo('mes_6',$f["mes_6"]);
				$xml->add_nodo('mes_7',$f["mes_7"]);
				$xml->add_nodo('mes_8',$f["mes_8"]);
				$xml->add_nodo('mes_9',$f["mes_9"]);
				$xml->add_nodo('mes_10',$f["mes_10"]);
				$xml->add_nodo('mes_11',$f["mes_11"]);
				$xml->add_nodo('mes_12',$f["mes_12"]);
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
