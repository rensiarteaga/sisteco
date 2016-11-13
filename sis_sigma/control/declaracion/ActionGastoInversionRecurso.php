<?php
/**
**********************************************************
Nombre de archivo:	    ActionGastoInversionRecurso.php
Propósito:				Permite realizar el listado en tsi_declaracion
Tabla:					tsi_declaracion
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-10-16 12:20:40
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloSigma.php');

$Custom = new cls_CustomDBSigma();
$nombre_archivo ='ActionGastoInversionRecurso.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 100000;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_proveedor';
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
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Declaracion_dfaewr');
	$sortcol = $crit_sort->get_criterio_sort();
	
	//adicionado para realizar las consulta "gasto e inversoin" o "recurso"
	//williams escobar
if ($reporte_excel=='si')
	{   
		
	  //llamada a la funcion de que arma la consulta de la base da dato    
	  $excel_csv = $Custom-> GastoInversionRecurso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$_POST["id_declaracion"],$_POST["tipo_presupuesto"],'si');
	  
	  /*echo "<pre>";
	  print_r($excel_csv);	   
	  echo "</pre>";
	  exit; */
	    if(!$excel_csv)
	    {	   
		    $resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = "Error Al Generar la Consulta";
			$resp->origen = "ActionGastoInversionRecurso";
			$resp->proc = "ActionGastoInversionRecurso";
			$resp->nivel = 3;
			$resp->query = "";
			echo $resp->get_mensaje();
			exit;
		}
		// reemplazando en la consulta las comillas simples (') por las comillas dobles ('')		
	   $excel_csv= str_replace("'" , "''" , $excel_csv);
	   
	   // creando el objeto de la clase que contiene el metodo para la exportar a excel
	   $archivo=new cls_CustomDBContabilidad();
	   
	   // ejecutando la funcion 
	   //echo 'archivo:'.$nombre_file;exit;
	   $res=$archivo->ExportarXls($excel_csv,$nombre_file);
		if(!$res)
		{   
		    $resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje(); 
			exit;
		}
	    //llevar el archivo creado en postgresql al servidor web
		//falta los parametros de permisos, direccion ip en linux para mover
		//exec('cp /home/archivos_xls/'.$nombre_file.'  /opt/lampp/htdocs/endesis_desarrollo/sis_contabilidad/control/xlsabd/arch_adjuntos/'.$nombre_file,$salida,$array);//FUNCIONA BIEN ESTA LIniA DE CODIGO
		//$cmd="su usr_endesis_xls -c 'scp usr_endesis_xls@10.10.0.11:/tmp/$nombre_file  /opt/lampp/htdocs/endesis/sis_sigma/control/_reportes/tmp/'";
		$cmd="ssh -lusr_endesis_xls 10.10.0.11 scp /tmp/$nombre_file  usr_endesis_xls@10.10.0.12:/opt/lampp/htdocs/endesis/sis_sigma/control/_reportes/tmp/";
		exec($cmd);
		
		
		//Respuesta
	$xml = new cls_manejo_xml('ROOT');
	$xml->add_nodo('TotalCount',1);
	$xml->add_rama('ROWS');
	$xml->add_nodo('error',0);
	$xml->add_nodo('mensaje','Archivo generados '.$nombre_file);
	$xml->fin_rama();
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