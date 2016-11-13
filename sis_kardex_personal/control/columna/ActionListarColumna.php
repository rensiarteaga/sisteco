<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarColumna.php
Propósito:				Permite realizar el listado en tkp_columna
Tabla:					t_tkp_columna
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2010-08-19 10:28:40
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloKardexPersonal.php');

include_once('../../../lib/lib_control/GestionarExcel.php');
$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = 'ActionListarColumna .php';

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

	if($sort == '') $sortcol = 'id_columna';
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
	
	$cond->add_criterio_extra("COLUMNA.id_tipo_planilla",$id_tipo_planilla);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	if($m_id_gestion>0){
		$criterio_filtro=$criterio_filtro." AND pka.id_gestion=$m_id_gestion";
	}
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'ColumnaPla_123');
	$sortcol = $crit_sort->get_criterio_sort();
	
	
	/***/////////////
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
		
		 $res = $Custom->ListarColumna($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$_GET['m_id_combrobante'],$_GET['m_id_moneda']);
																
		 
		$Excel->setDetalle($Custom->salida);
		$Excel->setFin();		
	}else{

	//Obtiene el total de los registros
	$res = $Custom -> ContarColumna($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarColumna($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_columna',$f["id_columna"]);
			$xml->add_nodo('id_tipo_planilla',$f["id_tipo_planilla"]);
			$xml->add_nodo('desc_tipo_planilla',$f["desc_tipo_planilla"]);
			$xml->add_nodo('id_columna_tipo',$f["id_columna_tipo"]);
			$xml->add_nodo('desc_tipo_columna',$f["desc_tipo_columna"]);
			$xml->add_nodo('formula',$f["formula"]);
			$xml->add_nodo('valor_defecto',$f["valor_defecto"]);
			$xml->add_nodo('estado_reg',$f["estado_reg"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('id_usuario',$f["id_usuario"]);
			$xml->add_nodo('usuario',$f["usuario"]);
			$xml->add_nodo('def_tipo_columna',$f["def_tipo_columna"]);
			$xml->add_nodo('formula_original',$f["formula_original"]);
			$xml->add_nodo('codigo',$f["codigo"]);
			$xml->add_nodo('en_reporte',$f["en_reporte"]);
			$xml->add_nodo('orden_reporte',$f["orden_reporte"]);
			$xml->add_nodo('total',$f["total"]);
			$xml->add_nodo('auxiliar',$f["auxiliar"]);
			$xml->add_nodo('orden_ejecucion',$f["orden_ejecucion"]);
			$xml->add_nodo('fecha_inicio',$f["fecha_inicio"]);
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