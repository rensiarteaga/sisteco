<?php
session_start ();
require_once('../../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
//include_once("../LibModeloPresupuesto.php");

$nombre_archivo = 'ejecucion_anual.xls';
$docexcel = new Spreadsheet_Excel_Writer ( );
$nuevahoja = & $docexcel->addWorksheet ( "EJECUCIÓN PRESUPUESTARIA ANUAL");

$format_titulo =& $docexcel->addFormat();
$format_titulo->setBold();
$format_titulo->setAlign('center');

$format_numero =& $docexcel->addFormat();
$format_numero->setNumFormat('D-MMM-YYYY');

$fila = 0;
$columna = 0;

$nuevahoja->write ( 0, 0, 'DESCRIPCION',$format_titulo);
$nuevahoja->write ( 0, 1, 'PPTO. INICIAL',$format_titulo );
$nuevahoja->write ( 0, 2, 'MODIFI. PPTO.',$format_titulo );
$nuevahoja->write ( 0, 3, 'PPTO. VIGENTE',$format_titulo);
$nuevahoja->write ( 0, 4, 'ENE EJEC',$format_titulo);
$nuevahoja->write ( 0, 5, 'FEB EJEC',$format_titulo);
$nuevahoja->write ( 0, 6, 'MAR EJEC',$format_titulo);
$nuevahoja->write ( 0, 7, 'ABR AEJEC',$format_titulo);
$nuevahoja->write ( 0, 8, 'MAY EJEC',$format_titulo);
$nuevahoja->write ( 0, 9, 'JUN EJEC',$format_titulo);
$nuevahoja->write ( 0, 10, 'JUL EJEC',$format_titulo);
$nuevahoja->write ( 0, 11, 'AGO EJEC',$format_titulo);
$nuevahoja->write ( 0, 12, 'SEP EJEC',$format_titulo);
$nuevahoja->write ( 0, 13, 'OCT EJEC',$format_titulo);
$nuevahoja->write ( 0, 14, 'NOV EJEC',$format_titulo);
$nuevahoja->write ( 0, 15, 'DIC EJEC',$format_titulo);
$nuevahoja->write ( 0, 16, 'TOTAL EJEC',$format_titulo);
$nuevahoja->write ( 0, 17, '% EJEC',$format_titulo);


//OBTENCION DE LOS DATOS
$data=$_SESSION['PDF_RPPDetalle'];
$fila = 1;

$sumaPreI=0;
$sumaPreM=0;
$sumaPreV=0;

$sumaEneE=0;
$sumaFebE=0;
$sumaMarE=0;
$sumaAbrE=0;
$sumaMayE=0;
$sumaJunE=0;
$sumaJulE=0;
$sumaAgoE=0;
$sumaSepE=0;
$sumaOctE=0;
$sumaNovE=0;
$sumaDicE=0;

$sumaTotE=0;

foreach ( $data as $row ) {
	$nuevahoja->write ( $fila, 0, $row [0] );
	$nuevahoja->write ( $fila, 1, $row [1] );
	$nuevahoja->write ( $fila, 2, $row [2] );
	$nuevahoja->write ( $fila, 3, $row [3] );
	$nuevahoja->write ( $fila, 4, $row [5] );
	$nuevahoja->write ( $fila, 5, $row [8] );
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
	$nuevahoja->write ( $fila, 17, $row [49] );
	
	$sumaPreI=$sumaPreI+$row[1];
	$sumaPreM=$sumaPreM+$row[2];
	$sumaPreV=$sumaPreV+$row[3];
	
	$sumaEneE=$sumaEneE+$row[5];
	$sumaFebE=$sumaFebE+$row[8];
	$sumaMarE=$sumaMarE+$row[11];
	$sumaAbrE=$sumaAbrE+$row[16];
	$sumaMayE=$sumaMayE+$row[19];
	$sumaJunE=$sumaJunE+$row[22];
	$sumaJulE=$sumaJulE+$row[27];
	$sumaAgoE=$sumaAgoE+$row[30];
	$sumaSepE=$sumaSepE+$row[33];
	$sumaOctE=$sumaOctE+$row[38];
	$sumaNovE=$sumaNovE+$row[41];
	$sumaDicE=$sumaDicE+$row[44];
	
	$sumaTotE=$sumaTotE+$row[47];
	
	$fila ++; 
} //FIN DE FOREACH
//ADICIONANDO LOS TOTALES
$nuevahoja->write($fila,0,'TOTALES',$negrita);		    
$nuevahoja->write($fila,1,$sumaPreI,$negrita);			
$nuevahoja->write($fila,2,$sumaPreM,$negrita);
$nuevahoja->write($fila,3,$sumaPreV,$negrita);

$nuevahoja->write($fila,4,$sumaEneE,$negrita);
$nuevahoja->write($fila,5,$sumaFebE,$negrita);
$nuevahoja->write($fila,6,$sumaMarE,$negrita);
$nuevahoja->write($fila,7,$sumaAbrE,$negrita);
$nuevahoja->write($fila,8,$sumaMayE,$negrita);
$nuevahoja->write($fila,9,$sumaJunE,$negrita);
$nuevahoja->write($fila,10,$sumaJulE,$negrita);
$nuevahoja->write($fila,11,$sumaAgoE,$negrita);
$nuevahoja->write($fila,12,$sumaSepE,$negrita);
$nuevahoja->write($fila,13,$sumaOctE,$negrita);
$nuevahoja->write($fila,14,$sumaNovE,$negrita);
$nuevahoja->write($fila,15,$sumaDicE,$negrita);

$nuevahoja->write($fila,16,$sumaTotE,$negrita);

$docexcel->send ( $nombre_archivo );
$docexcel->close ();

?>