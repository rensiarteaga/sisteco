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
$nuevahoja->write ( 0, 0, 'SISIN',$format_titulo);
$nuevahoja->write ( 0, 1, 'PROG',$format_titulo);
$nuevahoja->write ( 0, 2, 'ACTIV',$format_titulo);
$nuevahoja->write ( 0, 3, 'DESCRIPCION',$format_titulo);
$nuevahoja->write ( 0, 4, 'PPTO. INICIAL',$format_titulo );
$nuevahoja->write ( 0, 5, 'MODIFI. PPTO.',$format_titulo );
$nuevahoja->write ( 0, 6, 'PPTO. VIGENTE',$format_titulo);
$nuevahoja->write ( 0, 7, 'ENE EJEC',$format_titulo);
$nuevahoja->write ( 0, 8, 'FEB EJEC',$format_titulo);
$nuevahoja->write ( 0, 9, 'MAR EJEC',$format_titulo);
$nuevahoja->write ( 0, 10, 'ABR AEJEC',$format_titulo);
$nuevahoja->write ( 0, 11, 'MAY EJEC',$format_titulo);
$nuevahoja->write ( 0, 12, 'JUN EJEC',$format_titulo);
$nuevahoja->write ( 0, 13, 'JUL EJEC',$format_titulo);
$nuevahoja->write ( 0, 14, 'AGO EJEC',$format_titulo);
$nuevahoja->write ( 0, 15, 'SEP EJEC',$format_titulo);
$nuevahoja->write ( 0, 16, 'OCT EJEC',$format_titulo);
$nuevahoja->write ( 0, 17, 'NOV EJEC',$format_titulo);
$nuevahoja->write ( 0, 18, 'DIC EJEC',$format_titulo);
$nuevahoja->write ( 0, 19, 'TOTAL EJEC',$format_titulo);
$nuevahoja->write ( 0, 20, '% EJEC',$format_titulo);


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
	$nuevahoja->write ( $fila, 4, $row [4] );
	$nuevahoja->write ( $fila, 5, $row [5] );
	$nuevahoja->write ( $fila, 6, $row [6] );
	$nuevahoja->write ( $fila, 7, $row [8] );
	$nuevahoja->write ( $fila, 8, $row [11] );
	$nuevahoja->write ( $fila, 9, $row [14] );
	$nuevahoja->write ( $fila, 10, $row [19] );
	$nuevahoja->write ( $fila, 11, $row [22] );
	$nuevahoja->write ( $fila, 12, $row [25] );
	$nuevahoja->write ( $fila, 13, $row [30] );
	$nuevahoja->write ( $fila, 14, $row [33] );
	$nuevahoja->write ( $fila, 15, $row [36] );
	$nuevahoja->write ( $fila, 16, $row [41] );
	$nuevahoja->write ( $fila, 17, $row [44] );
	$nuevahoja->write ( $fila, 18, $row [47] );
	$nuevahoja->write ( $fila, 19, $row [50] );
	$nuevahoja->write ( $fila, 20, $row [52] );
	
	$sumaPreI=$sumaPreI+$row[4];
	$sumaPreM=$sumaPreM+$row[5];
	$sumaPreV=$sumaPreV+$row[6];
	
	$sumaEneE=$sumaEneE+$row[8];
	$sumaFebE=$sumaFebE+$row[11];
	$sumaMarE=$sumaMarE+$row[14];
	$sumaAbrE=$sumaAbrE+$row[19];
	$sumaMayE=$sumaMayE+$row[22];
	$sumaJunE=$sumaJunE+$row[25];
	$sumaJulE=$sumaJulE+$row[30];
	$sumaAgoE=$sumaAgoE+$row[33];
	$sumaSepE=$sumaSepE+$row[36];
	$sumaOctE=$sumaOctE+$row[41];
	$sumaNovE=$sumaNovE+$row[44];
	$sumaDicE=$sumaDicE+$row[47];
	
	$sumaTotE=$sumaTotE+$row[50];
	
	$fila ++; 
} //FIN DE FOREACH
//ADICIONANDO LOS TOTALES
$nuevahoja->write($fila,3,'TOTALES',$negrita);		    
$nuevahoja->write($fila,4,$sumaPreI,$negrita);			
$nuevahoja->write($fila,5,$sumaPreM,$negrita);
$nuevahoja->write($fila,6,$sumaPreV,$negrita);

$nuevahoja->write($fila,7,$sumaEneE,$negrita);
$nuevahoja->write($fila,8,$sumaFebE,$negrita);
$nuevahoja->write($fila,9,$sumaMarE,$negrita);
$nuevahoja->write($fila,10,$sumaAbrE,$negrita);
$nuevahoja->write($fila,11,$sumaMayE,$negrita);
$nuevahoja->write($fila,12,$sumaJunE,$negrita);
$nuevahoja->write($fila,13,$sumaJulE,$negrita);
$nuevahoja->write($fila,14,$sumaAgoE,$negrita);
$nuevahoja->write($fila,15,$sumaSepE,$negrita);
$nuevahoja->write($fila,16,$sumaOctE,$negrita);
$nuevahoja->write($fila,17,$sumaNovE,$negrita);
$nuevahoja->write($fila,18,$sumaDicE,$negrita);

$nuevahoja->write($fila,19,$sumaTotE,$negrita);

$docexcel->send ( $nombre_archivo );
$docexcel->close ();

?>