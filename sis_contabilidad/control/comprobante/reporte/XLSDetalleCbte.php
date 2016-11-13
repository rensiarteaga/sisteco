<?php
session_start ();
require_once ('../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
include_once('../LibModeloContabilidad.php');


$nombre_archivo = 'detalle_cbtes.xls';
$docexcel = new Spreadsheet_Excel_Writer ( );
$nuevahoja = & $docexcel->addWorksheet ( 'DETALLE DE CBTES');

$format_titulo =& $docexcel->addFormat();
$format_titulo->setBold();
$format_titulo->setAlign('center');

$format_numero =& $docexcel->addFormat();
$format_numero->setNumFormat('D-MMM-YYYY');

$fila = 0;
$columna = 0;

$nuevahoja->write ( 0, 0, 'ID CBTE',$format_titulo);
$nuevahoja->write ( 0, 1, 'NRO CBTE',$format_titulo );
$nuevahoja->write ( 0, 2, 'MOMENTO',$format_titulo );
$nuevahoja->write ( 0, 3, 'FECHA',$format_titulo);
$nuevahoja->write ( 0, 4, 'CONCETO' ,$format_titulo);
$nuevahoja->write ( 0, 5, 'GLOSA',$format_titulo );
$nuevahoja->write ( 0, 6, 'ACREEDOR',$format_titulo );
$nuevahoja->write ( 0, 7, 'APROBACION',$format_titulo );
$nuevahoja->write ( 0, 8, 'CONFORMIDAD',$format_titulo );
$nuevahoja->write ( 0, 9, 'PEDIDO',$format_titulo );
$nuevahoja->write ( 0, 10, 'ID SISTEMA',$format_titulo );
$nuevahoja->write ( 0, 11, 'ID USUARIO',$format_titulo );
$nuevahoja->write ( 0, 12, 'CLASE CBTE',$format_titulo);
$nuevahoja->write ( 0, 13, 'ID FKCBTE' ,$format_titulo);
$nuevahoja->write ( 0, 14, 'CHEQUE',$format_titulo );
$nuevahoja->write ( 0, 15, 'ORIGEN',$format_titulo );
$nuevahoja->write ( 0, 16, 'SW AFIJO',$format_titulo );
$nuevahoja->write ( 0, 17, 'SW ACTUALIZACION',$format_titulo );
$nuevahoja->write ( 0, 18, 'DPTO CONTABLE',$format_titulo );
$nuevahoja->write ( 0, 19, 'EPE',$format_titulo );
$nuevahoja->write ( 0, 20, 'PRESUPUESTO',$format_titulo );
$nuevahoja->write ( 0, 21, 'PARTIDA',$format_titulo);
$nuevahoja->write ( 0, 22, 'CUENTA' ,$format_titulo);
$nuevahoja->write ( 0, 23, 'AUXILIAR',$format_titulo );
$nuevahoja->write ( 0, 24, 'SIGMA',$format_titulo );
$nuevahoja->write ( 0, 25, 'OT',$format_titulo );
$nuevahoja->write ( 0, 26, 'DEBE',$format_titulo );
$nuevahoja->write ( 0, 27, 'HABER',$format_titulo );
$nuevahoja->write ( 0, 28, 'GASTO',$format_titulo );
$nuevahoja->write ( 0, 29, 'RECURSO',$format_titulo );

//OBTENCION DE LOS DATOS
$cbte = new cls_CustomDBContabilidad();
$res = $cbte->DetalleCbte('null', 'null', $_SESSION ['PDF_sortcol'], $_SESSION ['PDF_sortdir'], $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad, $_SESSION ['PDF_id_parametro'], $_SESSION ['PDF_id_moneda'], $_SESSION ['PDF_id_deptos'], $_SESSION ['PDF_fecha_ini'], $_SESSION ['PDF_fecha_fin'] );

if ($res) {
	$data = $cbte->salida;
	$fila = 1;

	foreach ( $data as $row ) {
		$nuevahoja->write ( $fila, 0, $row [0] );
		$nuevahoja->write ( $fila, 1, $row [1] );
		$nuevahoja->write ( $fila, 2, $row [2] );
		$nuevahoja->write ( $fila, 3, $row [3] );
		$nuevahoja->write ( $fila, 4, $row [4] );
		$nuevahoja->write ( $fila, 5, $row [5] );
		$nuevahoja->write ( $fila, 6, $row [6] );
		$nuevahoja->write ( $fila, 7, $row [7] );
		$nuevahoja->write ( $fila, 8, $row [8] );
		$nuevahoja->write ( $fila, 9, $row [9] );
		$nuevahoja->write ( $fila, 10, $row [10] );
		$nuevahoja->write ( $fila, 11, $row [11] );
		$nuevahoja->write ( $fila, 12, $row [12] );
		$nuevahoja->write ( $fila, 13, $row [13] );
		$nuevahoja->write ( $fila, 14, $row [14] );
		$nuevahoja->write ( $fila, 15, $row [15] );
		$nuevahoja->write ( $fila, 16, $row [16] );
		$nuevahoja->write ( $fila, 17, $row [17] );
		$nuevahoja->write ( $fila, 18, $row [18] );
		$nuevahoja->write ( $fila, 19, $row [19] );
		$nuevahoja->write ( $fila, 20, $row [20] );
		$nuevahoja->write ( $fila, 21, $row [21] );
		$nuevahoja->write ( $fila, 22, $row [22] );
		$nuevahoja->write ( $fila, 23, $row [23] );
		$nuevahoja->write ( $fila, 24, $row [24] );
		$nuevahoja->write ( $fila, 25, $row [25] );
		$nuevahoja->write ( $fila, 26, $row [26] );
		$nuevahoja->write ( $fila, 27, $row [27] );
		$nuevahoja->write ( $fila, 28, $row [28] );
		$nuevahoja->write ( $fila, 29, $row [29] );

		$fila ++; 
	} //FIN DE FOREACH
	$docexcel->send ( $nombre_archivo );
	$docexcel->close ();
} 
else 
{
	$resp = new cls_manejo_mensajes ( true, "401" );
	$resp->mensaje_error = 'MENSAJE ERROR = Error al generar el archivo xls';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje ();
	exit ();
}
?>