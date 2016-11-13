<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarRegistroComprobante.php
Propósito:				Permite realizar el listado en tct_comprobante
Tabla:					tct_tct_comprobante
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-09-16 17:55:38
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarLibroMayor .php';

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

	if($sort == '') $sortcol = 'id_comprobante';
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
	
	/*echo 'por_rango:'.$por_rango;
	echo '&&cuenta_ini:'.$cuenta_ini;
	echo '&&cuenta_fin:'.$cuenta_fin;
	exit;*/

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
    $criterio_filtro = $cond -> obtener_criterio_filtro();
	
	$id_usuario=$_SESSION["ss_id_usuario"];
	
	function cambiar_a_postgres($fecha){
	    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
	    $lafecha=$mifecha[2]."-".$mifecha[1]."-".$mifecha[3];
	    return $lafecha;
    }
    $fecha_inicio_b=cambiar_a_postgres($fecha_inicio);
    $fecha_fin_b=cambiar_a_postgres($fecha_fin);
    
    if($por_rango=='true'){
    	$id_cuenta='NULL';
    } else{
    	$cuenta_ini='';
    	$cuenta_fin='';
    }
    
    $ids_auxiliare = $_POST["ids_auxiliar"];
	
	if($ids_auxiliare !=''){
		$criterio_filtro=$criterio_filtro." AND TRANSA.id_auxiliar IN ($ids_auxiliare) ";
	}
    
    //echo "ig_gestion:".$id_gestion;
    //exit;
    
	//Obtiene el total de los registros
	$res = $Custom -> ContarReporteLibroMayorDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$fecha_inicio_b,$fecha_fin_b,$id_auxiliar,$id_depto,$cuenta_ini,$cuenta_fin,$por_rango,$id_gestion);
	if($res) $total_registros= $Custom->salida;
	//echo $Custom->query;;
	//exit;
	//$total_registros=10000;
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ReporteLibroMayorDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$fecha_inicio_b,$fecha_fin_b,$id_auxiliar, $id_depto,$cuenta_ini,$cuenta_fin,$por_rango,$id_gestion);
	
	//echo $Custom->query;;
	//exit;
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('fecha_cbte',$f["fecha_cbte"]);
			$xml->add_nodo('prefijo',$f["prefijo"]);
			$xml->add_nodo('nro_cbte',$f["nro_cbte"]);
			$xml->add_nodo('concepto_cbte',$f["concepto_cbte"]);
			$xml->add_nodo('tipo_cambio',$f["tipo_cambio"]);
			$xml->add_nodo('importe_debe',$f["importe_debe"]);
			$xml->add_nodo('importe_haber',$f["importe_haber"]);
			$xml->add_nodo('saldo',$f["saldo"]);
			$xml->add_nodo('id_cuenta',$f["id_cuenta"]);
			$xml->add_nodo('desc_cuenta',$f["desc_cuenta"]);
			
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