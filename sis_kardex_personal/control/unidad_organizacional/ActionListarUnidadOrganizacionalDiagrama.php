<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarUnidadOrganizacionalArb.php
Propósito:				Permite realizar el listado en tkp_unidad_organizacional
Tabla:					tkp_unidad_organizacional, tkp_estructura_organizacional
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2007-11-07 15:46:18
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloKardexPersonal.php');

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = 'ActionListarUnidadOrganizacionalDiagrama.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 30000;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id';
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
	

    	 $criterio_filtro=" 0=0"; //este es para la vista
   // }else{
    	//$criterio_filtro=" LOWER(funcionarios) LIKE LOWER(''%%'')"; //este es para el organigrama
    //}
   
    $v_id=1;
    $v_cad="%a%a".$id_unidad_organizacional."a%";
    $v_crit_fil=" niveles like ''$v_cad'' or niveles in (select niveles from organigrama_filtro where niveles=''311a2a'' or niveles =''311a'') ";
  //  echo $v_cad."filtro->".$v_crit_fil; exit;
	$res = $Custom->ListarUnidadOrganizacionalDiagrama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$v_id,'0=0');
		
	$_SESSION["PDF_listado_unidad_organizacional"]=$Custom->salida;
	if($res) $total_registros= $Custom->salida;
	/*echo $_GET["tipo_reporte"];
	exit;*/
	
    $_SESSION['tipo_reporte']=$_GET["tipo_reporte"];
	$_SESSION['id_unidad_organizacional']=$_GET['id_unidad_organizacional'];
	if($res)
	{   
		$_SESSION['tipo_reporte']=$tipo_reporte;
		header("location:../../vista/_reportes/diagrama_uniorg/PDFUniOrgDiagrama.php");
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
	    header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";

}?>