 <?php
/**
 * Nombre:				
 * Autor:				
 * Fecha creación:		
 *
 */
session_start();
include_once("../../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();

$nombre_archivo = 'ActionPDFRespaldoCbtes.php';

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

	if( $m_id_grupo_proceso != null)
	{
		$criterio_filtro = " grup.id_grupo_proceso LIKE($m_id_grupo_proceso) ";
		
		$fecha = new DateTime($fecha_proceso);
		$array_cabecera = array($fecha->format("d/m/Y"),$departamento,$descripcion);
		
		if($txt_proceso == 'BAJA')
		{
			$res =$Custom->ReporteActivosFijosRespaldoCbtesBaja($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);
			if($res)
			{
				$_SESSION['PDF_respaldo_cbteBaja'] = $Custom->salida;
				header("location:../../../vista/_reportes/respaldo_cbtes/PDF_ReporteRespaldoCbtesBaja.php?cabecera=".serialize($array_cabecera));
			}
			else
			{
				echo  "error funcion";
			}
		}
		else 
		{
			echo "Los respaldos de los cbtes de alta estan en pendientes.";
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