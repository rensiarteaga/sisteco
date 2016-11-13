<?php
session_start(); echo "entra aqui"; exit;
$nombre_archivo = 'ActionPDFOrdenCompra.php';
if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    $tipo_adq=$tipo_adquisicion;
    $id_proveedor=$proveedor;
    $fecha_inicio=$fecha_ini;
    $fecha_fin=$fecha_fin;
    $id_depto=$departamento;
    $id_ep=$id_ep;
    $id_uo=$id_unidad_organizacional;
//	header("location: ../../../../vista/orden_compra/PDFListaOrdenCompra.php?tipo_adq=".$tipo_adq."&id_proveedor=".$id_proveedor."&fecha_inicio=".$fecha_inicio."&fecha_fin=".$fecha_fin."&id_depto=".$id_depto."&id_ep=".$id_ep."&id_uo=".$id_uo);
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>