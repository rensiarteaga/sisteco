<?php
session_start ();
require_once('../../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
//include_once("../LibModeloPresupuesto.php");

$nombre_archivo = 'ejecucion_mensual.xls';
$docexcel = new Spreadsheet_Excel_Writer ( );
$nuevahoja = & $docexcel->addWorksheet ( "EJECUCIÓN PRESUPUESTARIA MENSUAL");

$format_titulo =& $docexcel->addFormat();
$format_titulo->setBold();
$format_titulo->setAlign('center');

$format_numero =& $docexcel->addFormat();
$format_numero->setNumFormat('D-MMM-YYYY');

$fila = 0;
$columna = 0;

$nuevahoja->write ( 0, 0, 'DESCRIPCION',$format_titulo);
$nuevahoja->write ( 0, 1, 'PPTO. INICIAL',$format_titulo );
$nuevahoja->write ( 0, 2, 'PPTO. VIGENTE A',$format_titulo );
$nuevahoja->write ( 0, 3, 'EJEC. ACUMULADA A ',$format_titulo);
$nuevahoja->write ( 0, 4, '% EJECUCION',$format_titulo);


//OBTENCION DE LOS DATOS .$_SESSION['PDF_mes']
$data=$_SESSION['PDF_RPPDetalle'];
$fila = 1;

$sumaPreI=0;
$sumaPreV=0;
$sumaEjeA=0;

foreach ( $data as $row ) {
	
	$nuevahoja->write ( $fila, 0, $row [0] );
	$nuevahoja->write ( $fila, 1, $row [1] );
	$nuevahoja->write ( $fila, 2, $row [2] );
	$nuevahoja->write ( $fila, 3, $row [3] );
	$nuevahoja->write ( $fila, 4, $row [4] );
	/*$nuevahoja->write ( $fila, 5, $row [8] );
	$nuevahoja->write ( $fila, 6, $row [11] );
	$nuevahoja->write ( $fila, 7, $row [16] );
	$nuevahoja->write ( $fila, 8, $row [19] );
	$nuevahoja->write ( $fila, 9, $row [22] );
	$nuevahoja->write ( $fila, 10, $row [27] );
	$nuevahoja->write ( $fila, 11, $row [30] );
	$nuevahoja->write ( $fila, 12, $row [33] );
	$nuevahoja->write ( $fila, 13, $row [38] );
	$nuevahoja->write ( $fila, 14, $row [41] );
	$nuevahoja->write ( $fila, 15, $row [44] );
	$nuevahoja->write ( $fila, 16, $row [47] );
	$nuevahoja->write ( $fila, 17, $row [49] );*/
	
	$sumaPreI=$sumaPreI+$row[1];
	$sumaPreV=$sumaPreV+$row[2];
	$sumaEjeA=$sumaEjeA+$row[3];
	
	$fila ++; 
} //FIN DE FOREACH

//ADICIONANDO LOS TOTALES
$nuevahoja->write($fila,0,'TOTALES',$negrita);		    
$nuevahoja->write($fila,1,$sumaPreI,$negrita);			
$nuevahoja->write($fila,2,$sumaPreV,$negrita);
$nuevahoja->write($fila,3,$sumaEjeA,$negrita);

$docexcel->send ( $nombre_archivo );
$docexcel->close ();

?>