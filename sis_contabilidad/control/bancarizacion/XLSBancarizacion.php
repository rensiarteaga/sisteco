<?php
session_start ();

require_once ('../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
include_once ("../LibModeloContabilidad.php");

$nombre_archivo = "bancarizacion_".$tipo_operacion."_".$id_bancarizacion.".xls";
$docexcel = new Spreadsheet_Excel_Writer ( );
$nuevahoja = & $docexcel->addWorksheet ( "BANCARIZACION-".$tipo_operacion);

$format_titulo =& $docexcel->addFormat();
$format_titulo->setBold();
//$format_center =& $docexcel->addFormat();
$format_titulo->setAlign('center');

$format_numero =& $docexcel->addFormat();
$format_numero->setNumFormat('D-MMM-YYYY');

$fila = 0;
$columna = 0;

//DEFINICION DE COLUMNAS
$nuevahoja->write ( 0, 0, 'CONS',$format_titulo);
$nuevahoja->write ( 0, 1, 'DEPTO.',$format_titulo);
$nuevahoja->write ( 0, 2, 'ID CBTE.PAGO',$format_titulo );
$nuevahoja->write ( 0, 3, 'FECHA CBTE.PAGO',$format_titulo );
$nuevahoja->write ( 0, 4, 'ACREEDOR CBTE.PAGO',$format_titulo );
$nuevahoja->write ( 0, 5, 'ID CBTE.DEV',$format_titulo );
$nuevahoja->write ( 0, 6, 'FECHA CBTE.DEV',$format_titulo);
$nuevahoja->write ( 0, 7, 'ACREEDOR CBTE.DEV',$format_titulo );
$nuevahoja->write ( 0, 8, 'MODALIDAD',$format_titulo );
$nuevahoja->write ( 0, 9, 'FECHA FACTURA',$format_titulo );
$nuevahoja->write ( 0, 10, 'TIPO TRANS.',$format_titulo );
$nuevahoja->write ( 0, 11, 'NIT',$format_titulo );
$nuevahoja->write ( 0, 12, 'RAZON SOCIAL',$format_titulo );
$nuevahoja->write ( 0, 13, 'Nº FACTURA',$format_titulo );
$nuevahoja->write ( 0, 14, 'IMPORTE FACTURA',$format_titulo );
$nuevahoja->write ( 0, 15, 'Nº AUTORI.',$format_titulo );
$nuevahoja->write ( 0, 16, 'CTA. BANCARIA',$format_titulo );
$nuevahoja->write ( 0, 17, 'IMPORTE PAGADO',$format_titulo );
$nuevahoja->write ( 0, 18, 'ACUMULADO',$format_titulo );
$nuevahoja->write ( 0, 19, 'NIT ENT.FINAN.',$format_titulo );
$nuevahoja->write ( 0, 20, 'Nº PAGO',$format_titulo );
$nuevahoja->write ( 0, 21, 'TIPO PAGO',$format_titulo );
$nuevahoja->write ( 0, 22, 'FECHA PAGO',$format_titulo );

//OBTENCION DE LOS DATOS
$Custom = new cls_CustomDBContabilidad();
$criterio_filtro="BANDET.id_bancarizacion=".$id_bancarizacion." AND BANDET.tipo_operacion=''$tipo_operacion''";
$res = $Custom->XlsBancarizacion(10000,0,'BANDET.id_bancarizacion_det','asc',$criterio_filtro,NULL,NULL,NULL,NULL,NULL);

//echo $Custom->salida ; exit();
if ($res) 
{
	$data = $Custom->salida;
	$fila = 1;

	foreach ( $data as $row ) 
	{
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
		$fila ++;
		
	} //FIN DE FOREACH writeString
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