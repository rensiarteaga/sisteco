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
include_once('../LibModeloPresupuesto.php');
include_once('../../../lib/lib_control/GestionarExcel.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarConsolidacion.php';

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

	if($sort == '') $sortcol = 'codigo_partida';
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
	
	//--jgl fin

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	//$cond->add_criterio_extra("CATEGO.id_categoria",$m_id_categoria);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	
	//$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Destino');
	
	
	//$sortcol = $crit_sort->get_criterio_sort();
	


/*echo $_POST['ids_proyecto'], ;
	exit();*/

	
		//--jgl inicio
 if ($reporte_excel=='si')
	{	//echo  $_GET['id_financiador']." r=".$_GET['id_regional']." r=".$_GET['id_programa']." r=".$_GET['id_proyecto']." r=".$_GET['id_actividad']." r=".$_GET['tipo_pres']." r=".$_POST['id_parametro']." r=".$_GET['id_moneda']." r=".$_GET['ids_fuente_financiamiento']." r=".$_GET['ids_u_o']." r=".$_GET['ids_financiador']." r=".$_GET['ids_regional']." r=".$_GET['ids_programa']." r=".$_GET['ids_proyecto']." r=".$_GET['ids_actividad']." r=".$_GET['sw_vista']." r=".$_GET['ids_concepto_colectivo']; exit;
		//recupera los valores de las columnas
		for($i=0;$i<$nro_columnas;$i++)
		{
			if($_GET["valor_$i"]=='id_partida')
				{
					$datosCabecera['valor'][$i]='nombre_partida';
					$datosCabecera['columna'][$i]=$_GET["columna_$i"];
					$datosCabecera['align'][$i]=$_GET["align_$i"];
					$datosCabecera['width'][$i]=$_GET["width_$i"];
				}
				else
				{
					$datosCabecera['valor'][$i]=$_GET["valor_$i"];
					$datosCabecera['columna'][$i]=$_GET["columna_$i"];
					$datosCabecera['align'][$i]=$_GET["align_$i"];
					$datosCabecera['width'][$i]=$_GET["width_$i"];
				}		
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
		
		               // ListarConsiliacionPartida($cant,$puntero,$sortcol ,$sortdir,$criterio_filtro,$_POST['id_financiador'],$_POST['id_regional'],$_POST['id_programa'],$_POST['id_proyecto'],$_POST['id_actividad'],$_POST['tipo_pres'],$_POST['id_parametro'],$_POST['id_moneda'],$_POST['ids_fuente_financiamiento'],$_POST['ids_u_o'],$_POST['ids_financiador'],$_POST['ids_regional'],$_POST['ids_programa'],$_POST['ids_proyecto'],$_POST['ids_actividad'],$_POST['sw_vista'],$_POST['ids_concepto_colectivo']);
		$res = $Custom->ListarConsiliacionPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$_GET['id_financiador'],$_GET['id_regional'],$_GET['id_programa'],$_GET['id_proyecto'],$_GET['id_actividad'],$_GET['tipo_pres'],$_GET['id_parametro'],$_GET['id_moneda'],$_GET['ids_fuente_financiamiento'],$_GET['ids_u_o'],$_GET['ids_financiador'],$_GET['ids_regional'],$_GET['ids_programa'],$_GET['ids_proyecto'],$_GET['ids_actividad'],$_GET['sw_vista'],$_GET['ids_concepto_colectivo']);
	 
		$Excel->setDetalle($Custom->salida);
		$Excel->setFin();		
		}
	else {
//--jgl fin



	//Obtiene el total de los registros
	$res = $Custom -> ContarConsiliacionPartida($cant,$puntero,$sortcol ,$sortdir,$criterio_filtro,$_POST['id_financiador'],$_POST['id_regional'],$_POST['id_programa'],$_POST['id_proyecto'],$_POST['id_actividad'],$_POST['tipo_pres'],$_POST['id_parametro'],$_POST['id_moneda'],$_POST['ids_fuente_financiamiento'],$_POST['ids_u_o'],$_POST['ids_financiador'],$_POST['ids_regional'],$_POST['ids_programa'],$_POST['ids_proyecto'],$_POST['ids_actividad'],$_POST['sw_vista'],$_POST['ids_concepto_colectivo']);

	if($res) $total_registros= $Custom->salida;

	/*echo $ids_fuente_financiamiento;
	exit();*/
	


	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarConsiliacionPartida($cant,$puntero,$sortcol ,$sortdir,$criterio_filtro,$_POST['id_financiador'],$_POST['id_regional'],$_POST['id_programa'],$_POST['id_proyecto'],$_POST['id_actividad'],$_POST['tipo_pres'],$_POST['id_parametro'],$_POST['id_moneda'],$_POST['ids_fuente_financiamiento'],$_POST['ids_u_o'],$_POST['ids_financiador'],$_POST['ids_regional'],$_POST['ids_programa'],$_POST['ids_proyecto'],$_POST['ids_actividad'],$_POST['sw_vista'],$_POST['ids_concepto_colectivo'],$id_categoria_prog,$filtro_niveles);
	
	if($res)
	{	$contador=0;
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			
				$xml->add_nodo('id_partida',$f["id_partida"]);
				$xml->add_nodo('codigo_partida',$f["codigo_partida"]);
				 $xml->add_nodo('nombre_partida',$f["nombre_partida"]);
				
				$xml->add_nodo('desc_partida',$f["desc_partida"]);
				$xml->add_nodo('nivel_partida',$f["nivel_partida"]);
				$xml->add_nodo('sw_transaccional',$f["sw_transaccional"]);
				$xml->add_nodo('tipo_partida',$f["tipo_partida"]);
				$xml->add_nodo('id_parametro',$f["id_parametro"]);
				$xml->add_nodo('id_partida_padre',$f["id_partida_padre"]);
				$xml->add_nodo('tipo_memoria',$f["tipo_memoria"]);
				$xml->add_nodo('sw_movimiento ',$f["sw_movimiento"]);
				$xml->add_nodo('id_concepto_colectivo',$f["id_concepto_colectivo"]);
				$xml->add_nodo('id_partida_detalle',$f["id_partida_detalle"]);
				$xml->add_nodo('mes_01 ',$f["mes_01"]);
				$xml->add_nodo('mes_02 ',$f["mes_02"]);
				$xml->add_nodo('mes_03 ',$f["mes_03"]);
				$xml->add_nodo('mes_04 ',$f["mes_04"]);
				$xml->add_nodo('mes_05 ',$f["mes_05"]);
				$xml->add_nodo('mes_06 ',$f["mes_06"]);
				$xml->add_nodo('mes_07 ',$f["mes_07"]);
				$xml->add_nodo('mes_08 ',$f["mes_08"]);
				$xml->add_nodo('mes_09 ',$f["mes_09"]);
				$xml->add_nodo('mes_10 ',$f["mes_10"]);
				$xml->add_nodo('mes_11 ',$f["mes_11"]);
				$xml->add_nodo('mes_12 ',$f["mes_12"]);
				$xml->add_nodo('total ',$f["total"]);				
				$xml->add_nodo('id_partida_presupuesto',$f["id_partida_presupuesto"]);
				$xml->add_nodo('id_moneda ',$f["id_moneda"]);
				$xml->fin_rama();
		$contador++;
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
	//--jgl inicio 
   }
	//--jgl fin
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
