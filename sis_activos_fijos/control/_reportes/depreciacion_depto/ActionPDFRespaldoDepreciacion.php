<?php
session_start();
include_once("../../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();

$nombre_archivo = 'ActionPDFRespaldoDepreciacion.php';
if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}

if($_SESSION['autentificado']=='SI')
{
	$cant = 0;
	$puntero = 0;
	$sortdir = '';
	$sortcol = '';
	$criterio_filtro = "";
	
	if(isset($id_grupo_depreciacion) && $id_grupo_depreciacion > 0)
	{
		$criterio_filtro = "gd.id_grupo_depreciacion like($id_grupo_depreciacion)";
		$res = $Custom->obtenerCabeceraDepreciacionDepto($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);

		if(res)
		{ 
			$mes = "";
			switch ($Custom->salida[0]['mes_fin'])
			{
				case 1:$mes = 'Enero'; break; 
				case 2:$mes = 'Febrero';break;
				case 3:$mes = 'Marzo'; break; 
				case 4:$mes = 'Abril';break;
				case 5:$mes = 'Mayo'; break;
			    case 6:$mes = 'Junio'; break;
				case 7:$mes = 'Julio'; break; 
				case 8:$mes = 'Agosto';break;
				case 9	: $mes = 'Septiembre'; break;
				case 10:$mes = 'Octubre';break;
				case 11	: $mes = 'Noviembre'; break; 
				case 12:$mes = 'Diciembre'; break;
			}
			$datos = array("$mes",$Custom->salida[0]['ano_fin'],$Custom->salida[0]['desc_persona'],$Custom->salida[0][desc_depto],$Custom->salida[0]['proyecto'],"$id_grupo_depreciacion","$depto");
			$_SESSION['cabecera_respaldo_deptocbte'] = $datos;
			
			
			$criterio_filtro = array("$id_grupo_depreciacion","$id_dep_depto");
			$res = $Custom->PDFRespaldoDepreciacionDepto($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);
			
			if($res)
			{
				$_SESSION['pdf_depdepto_respaldo'] = $Custom->salida;
				header("location:../../../vista/_reportes/depreciacion_depto/PDFRespaldoDepreciacionDepto.php");
			}
			
		}
	}
}
else
{
	header("HTTP/1.0 401 No autorizado");
	header('Content-Type: text/plain; charset=iso-8859-1');
	echo "No tiene los permisos necesarios ";
}


?>