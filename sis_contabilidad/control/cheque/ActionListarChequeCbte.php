<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCheque.php
Propósito:				Permite realizar el listado en tct_cheque
Tabla:					tct_tct_cheque
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-10-17 11:24:35
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');
include_once('../../../lib/lib_control/GestionarExcel.php');
$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarChequeCbte.php';

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

	if($sort == '') $sortcol = 'che.tipo_cheque, che.nro_cheque';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'desc';
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
	/*$cond->add_criterio_extra("CUEBAN.id_cuenta_bancaria",$m_id_cuenta_bancaria);
	$cond->add_criterio_extra("CHEVAL.id_moneda",$m_id_moneda);
	$cond->add_criterio_extra("CHEQUE.id_transaccion",$m_id_transaccion);
	*/
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	if($m_id_gestion){
	  	$criterio_filtro=$criterio_filtro." AND parges.id_gestion=".$m_id_gestion;
	}
	
	if($m_id_cuenta_bancaria){
	  	$criterio_filtro=$criterio_filtro." AND che.id_cuenta_bancaria=".$m_id_cuenta_bancaria;	
	}
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Cheque2');
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
		$res = $Custom->ListarChequeCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	 	$Excel->setDetalle($Custom->salida);
		
		$Excel->setFin();		
		}
	else {
		//Obtiene el total de los registros
		$res = $Custom -> ContarChequeCbte($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
		if($res) $total_registros= $Custom->salida;
	
		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ListarChequeCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		
		if($res)
		{
			$xml = new cls_manejo_xml('ROOT');
			$xml->add_nodo('TotalCount',$total_registros);
	
			foreach ($Custom->salida as $f)
			{
				$xml->add_rama('ROWS');
				$xml->add_nodo('id_cheque',$f["id_cheque"]);
				$xml->add_nodo('nombre',$f["nombre"]);
				$xml->add_nodo('nro_cuenta_banco',$f["nro_cuenta_banco"]);
				$xml->add_nodo('nro_cheque',$f["nro_cheque"]);
				$xml->add_nodo('nombre_cheque',$f["nombre_cheque"]);
				$xml->add_nodo('fecha_cheque',$f["fecha_cheque"]);
				$xml->add_nodo('nro_cbte',$f["nro_cbte"]);
				$xml->add_nodo('codigo_depto',$f["codigo_depto"]);
				$xml->add_nodo('importe_cheque',$f["importe_cheque"]);
				$xml->add_nodo('moneda',$f["moneda"]);
				$xml->add_nodo('observaciones_anulacion',$f["observaciones_anulacion"]);
				$xml->add_nodo('estado_cheque',$f["estado_cheque"]);
				$xml->add_nodo('tipo_cheque',$f["tipo_cheque"]);
				$xml->add_nodo('id_cuenta_bancaria',$f["id_cuenta_bancaria"]);
				$xml->add_nodo('desc_banco',$f["desc_banco"]);
				$xml->add_nodo('id_comprobante',$f["id_comprobante"]);
				$xml->add_nodo('id_moneda',$f["id_moneda"]);
				$xml->add_nodo('simbolo',$f["simbolo"]);
				$xml->add_nodo('desc_clase',$f["desc_clase"]);
				$xml->add_nodo('momento_cbte',$f["momento_cbte"]);
                            $xml->add_nodo('nro_deposito',$f["nro_deposito"]);
	           
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