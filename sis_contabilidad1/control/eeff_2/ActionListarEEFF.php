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
	
	
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
 //echo 	$_POST['id_reporte_eeff'].$_POST['id_parametro'].$_POST['id_moneda'].$_POST['fecha_trans'].$_POST['nivel'];  exit ();
 
 


	//Obtiene el total de los registros
 $res = $Custom -> ContarEEFFBG($cant,$puntero,$sortcol ,$sortdir,$criterio_filtro,$_POST['id_financiador'],$_POST['id_regional'],$_POST['id_programa'],$_POST['id_proyecto'],$_POST['id_actividad'],	$_POST['id_reporte_eeff'],	$_POST['id_parametro'],	$_POST['id_moneda'],	$_POST['ids_fuente_financiamiento'],	$_POST['ids_u_o'],	$_POST['ids_financiador'],	$_POST['ids_regional'],	$_POST['ids_programa'],	$_POST['ids_proyecto'],	$_POST['ids_actividad'],	$_POST['fecha_trans'],$_POST['nivel'] );
//$res=true;
	if($res) $total_registros= $Custom->salida;

	/*echo $ids_fuente_financiamiento;
	exit();*/




	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarEEFFBG($cant,$puntero,$sortcol ,$sortdir,$criterio_filtro,$_POST['id_financiador'],$_POST['id_regional'],$_POST['id_programa'],$_POST['id_proyecto'],$_POST['id_actividad'],$_POST['id_reporte_eeff'],$_POST['id_parametro'],$_POST['id_moneda'],$_POST['ids_fuente_financiamiento'],$_POST['ids_u_o'],$_POST['ids_financiador'],$_POST['ids_regional'],$_POST['ids_programa'],$_POST['ids_proyecto'],$_POST['ids_actividad'],$_POST['fecha_trans'],$_POST['nivel']  );
	
	if($res)
	{	$contador=0;
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
				$xml->add_nodo('id_cuenta',$f["id_cuenta"]);
				$xml->add_nodo('id_cuenta_padre',$f["id_cuenta_padre"]);
				$xml->add_nodo('nro_cuenta',$f["nro_cuenta"]);
				$xml->add_nodo('nombre_cuenta',$f["nombre_cuenta"]);
				$xml->add_nodo('nivel_cuenta',$f["nivel_cuenta"]);
				$xml->add_nodo('saldo',$f["saldo"]);
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
