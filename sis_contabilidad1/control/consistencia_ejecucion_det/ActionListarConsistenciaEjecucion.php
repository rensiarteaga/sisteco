<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarConsistenciaEjecucion.php
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
$nombre_archivo = 'ActionListarConsistenciaEjecucion.php';

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
	if(sizeof($_POST) > 0){
		$id_moneda=$_POST['id_moneda'];
		$sw_movimiento=$_POST['sw_movimiento'];
		$tipo_partida=$_POST['tipo_partida'];
		$fechainicio=$_POST['fecha_inicio'];
		$fechafinal=$_POST['fecha_final'];
		$momento=$_POST['momento'];
	}else {
		$id_moneda=$_GET['id_moneda'];
		$sw_movimiento=$_GET['sw_movimiento'];
		$tipo_partida=$_GET['tipo_partida'];
		$fechainicio=$_GET['fecha_inicio'];
		$fechafinal=$_GET['fecha_final'];
		$momento=$_GET['momento'];
	}
	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	//echo 'MOmento'.$momento;
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	$criterio_filtro=$criterio_filtro." AND cbte.nro_cbte is not null";
	if($id_moneda)
	{
		$criterio_filtro=$criterio_filtro." AND trv.id_moneda=".$id_moneda;
	}
	if($tipo_partida)
	{
		if($tipo_partida==3)
		{
			$criterio_filtro=$criterio_filtro." AND par.tipo_partida in (1,2)";
		}else {
			$criterio_filtro=$criterio_filtro." AND par.tipo_partida =".$tipo_partida;
		}
	}
	if($sw_movimiento)
	{
		if($sw_movimiento==3)
		{
			$criterio_filtro=$criterio_filtro." AND par.sw_movimiento in (1,2)";
		}else {
			$criterio_filtro=$criterio_filtro." AND par.sw_movimiento =".$sw_movimiento;
		}
	}
	if($fechainicio&&$fechafinal)
	{
		$criterio_filtro=$criterio_filtro." AND cbte.fecha_cbte BETWEEN "."\'".$fechainicio."\'"." AND "."\'".$fechafinal."\'";
	}
	
	if($momento>=0&&$momento<9)
	{
		$criterio_filtro=$criterio_filtro." AND cbte.momento_cbte = ".$momento;
		//echo 'CRITERIO'.$criterio_filtro; exit;
	}

	if ($reporte_excel=='si')
	{	//recupera los valores de las columnas
		
		for($i=0;$i<16;$i++){
			$datosCabecera['valor'][$i]=$_GET["valor_$i"];
			$datosCabecera['columna'][$i]=$_GET["columna_$i"];
			$datosCabecera['align'][$i]=$_GET["align_$i"];
			$datosCabecera['width'][$i]=$_GET["width_$i"];		
		}
			
		$Excel = new GestionarExcel();
		$titulo_reporte_excel="Detalle Consistencia Ejecucion";
		$Excel->SetNombreReporte($titulo_reporte_excel);
		$Excel->SetHoja("Hoja 1 Datos");
		$Excel->SetFila(3);
		$cant=1000;
		$puntero=0;
		//Obtiene el total de los registros
		
		$res = $Custom -> ContarConsEjec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		if($res){ $total_registros= $Custom->salida;}
		
		$Excel->SetTitulo($titulo_reporte_excel,0,3,16); //Colocamos el titulo al reporte
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
		while ($puntero<$total_registros){
		$res = $Custom->ListarConsEjec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$puntero=$puntero+$cant;
		$Excel->setDetalle($Custom->salida);
		}
		
				$Excel->setFin();		
		}
	else 
	{
	
	//Obtiene el total de los registros
 	$res = $Custom -> ContarConsEjec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarConsEjec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	if($res)
	{	
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
				$xml->add_nodo('nombre_depto',$f["nombre_depto"]);
				$xml->add_nodo('fecha_cbte',$f["fecha_cbte"]);
				$xml->add_nodo('id_comprobante',$f["id_comprobante"]);
				$xml->add_nodo('nro_cbte',$f["nro_cbte"]);
				$xml->add_nodo('concepto_cbte',$f["concepto_cbte"]);
				$xml->add_nodo('nro_cuenta',$f["nro_cuenta"]);
				$xml->add_nodo('nombre_cuenta',$f["nombre_cuenta"]);
				$xml->add_nodo('codigo_partida',$f["codigo_partida"]);
				$xml->add_nodo('nombre_partida',$f["nombre_partida"]);
				$xml->add_nodo('codigo_auxiliar',$f["codigo_auxiliar"]);
				$xml->add_nodo('nombre_auxiliar',$f["nombre_auxiliar"]);
				$xml->add_nodo('importe_debe',$f["importe_debe"]);
				$xml->add_nodo('importe_haber',$f["importe_haber"]);
				$xml->add_nodo('importe_gasto',$f["importe_gasto"]);
				$xml->add_nodo('importe_recurso',$f["importe_recurso"]);	
				$xml->add_nodo('momento_cbte',$f["momento_cbte"]);
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
