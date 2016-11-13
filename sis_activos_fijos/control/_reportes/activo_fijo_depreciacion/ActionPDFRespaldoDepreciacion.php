 <?php
/**
 * Nombre:		ActionPDFRespaldoDepreciacion.php		
 * Autor:		Elmer Velasquez		
 * Fecha creación:		19/03/2014
 *
 */
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
		
	switch ($txt_mes_fin)
	{
		case 1 : $txt_mes_fin='Enero'; break;	case 2 : $txt_mes_fin='Febrero';break;	
		case 3 : $txt_mes_fin='Marzo';break;	case 4 : $txt_mes_fin='Abril';break;
		case 5 : $txt_mes_fin='Mayo';break;		case 6 : $txt_mes_fin='Junio';break;
		case 7 : $txt_mes_fin='Julio';break;	case 8 : $txt_mes_fin='Agosto';break;
		case 9 : $txt_mes_fin='Septiembre';break;	case 10 : $txt_mes_fin='Octubre';break;
		case 11 : $txt_mes_fin='Noviembre';break;	case 12 : $txt_mes_fin='Diciembre';break;
	}
	$dia= ' '.date("d",(mktime(0,0,0,$txt_mes_fin+1,1,$txt_ano_fin)-1)).' ';
	$fecha=' '.$dia.' '.$txt_mes_fin.' '.$txt_ano_fin.' ';
	$fecha_ini='01 '.$txt_mes_fin.' '.$txt_ano_fin.' ';
	 
	$datos = array("$txt_mes_fin","$txt_ano_fin","$txt_desc_depto","$txt_desc_usuario","$txt_fecha_reg","$txt_proyecto","$id_grupo_depreciacion","$fecha","$fecha_ini");
	
	if( $id_grupo_depreciacion != null)
	{ 
		$criterio_filtro = array("$id_grupo_depreciacion","$codigo_regional");
		if($codigo_regional != 'TDD' && $codigo_regional != 'CBJ' && $codigo_regional!='OFID')
		{
			$res =$Custom->PDFRespaldoDepreciacion($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);
		}
		//$res =$Custom->PDFRespaldoDepreciacion($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);
		elseif ($codigo_regional=='CBJ')
		{
			//depto contable cobija
			$res =$Custom->PDFRespaldoDepreciacion($cant, $puntero, 'DEPTOCBJ', $sortcol, $criterio_filtro);
			if($res)  $_SESSION['pdf_cbj'] = $Custom->salida;
			else echo 'Error Funcion';
				
			$res =$Custom->PDFRespaldoDepreciacion($cant, $puntero,'SENA', $sortcol, $criterio_filtro);
				
			if($res)	$_SESSION['pdf_cbj_sena'] = $Custom->salida;
			else echo 'Error Funcion';
		}
		elseif ($codigo_regional == 'OFID')
		{
			$res = $Custom->PDFRespaldoDepreciacion($cant, $puntero,'OFID', $sortcol, $criterio_filtro);
			if ($res) 	$_SESSION['PDF_RESP_OFID'] = $Custom->salida;
			else echo 'Error Funcion';
		}
		else 
		{
			
			//obtencion programa DIST
			$res=$Custom->PDFRespaldoDepreciacion($cant, $puntero,'DISTRIB',$sortcol, $criterio_filtro);

			if($res)
			{
				$_SESSION['pdf_tdd_dist'] = $Custom->salida;
				
				$proy = $Custom->PDFRespaldoDepreciacion($cant, $puntero,'DISTRIB','PROYPEDT', $criterio_filtro);
				if($proy)
				{
					$_SESSION['pdf_tdd_dist_pedt'] = $Custom->salida;
				}
				else echo 'Error Funcion';
					
				
			}
			else echo 'Error Funcion';
		
			$res=$Custom->PDFRespaldoDepreciacion($cant, $puntero,'OTROS',$sortcol, $criterio_filtro);
			
			if($res)
				$_SESSION['pdf_tdd_otros'] = $Custom->salida;
			else echo 'Error Funcion';
		}
				
		if($res && $codigo_regional != 'TDD' && $codigo_regional != 'CBJ' && $codigo_regional!='OFID') 
		{
			$_SESSION['datos_respaldo']=$datos;
			
			$_SESSION['PDF_reporte_respaldo_depreciacion'] = $Custom->salida;
			
			header("location:../../../vista/_reportes/activo_fijo_depreciacion/PDF_RespaldoDepreciacion.php");
		}
		elseif ($codigo_regional == 'CBJ')
		{
			$_SESSION['datos_respaldo']=$datos;
			header("location:../../../vista/_reportes/activo_fijo_depreciacion/PDF_RespaldoDepreciacionCBJ.php");
		}
		elseif ($codigo_regional == 'OFID')
		{
			$_SESSION['datos_respaldo']=$datos;
			header("location:../../../vista/_reportes/activo_fijo_depreciacion/PDF_RespaldoDepreciacionOFID.php");
		}
		else
		{
			$_SESSION['datos_respaldo']=$datos;
			
			header("location:../../../vista/_reportes/activo_fijo_depreciacion/PDF_RespaldoDepreciacionTDD.php");
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