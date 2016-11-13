<?php
session_start ();
require_once ('../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
include_once ("../LibModeloSigma.php");

$nombre_archivo = 'ejecucion_recurso.xls';
$docexcel = new Spreadsheet_Excel_Writer ( );
$nuevahoja = & $docexcel->addWorksheet ( "EJECUCION RECURSOS" );

$format_titulo =& $docexcel->addFormat();
$format_titulo->setBold();
//$format_center =& $docexcel->addFormat();
$format_titulo->setAlign('center');

$format_numero =& $docexcel->addFormat();
$format_numero->setNumFormat('D-MMM-YYYY');

$fila = 0;
$columna = 0;

//DEFINICION DE COLUMNAS
$nuevahoja->write ( 0, 0, 'PRESUPUESTO',$format_titulo);
$nuevahoja->write ( 0, 1, 'GESTION',$format_titulo );
$nuevahoja->write ( 0, 2, 'ENTIDAD',$format_titulo );
$nuevahoja->write ( 0, 3, 'MES',$format_titulo);
$nuevahoja->write ( 0, 4, 'PROGRAMA' ,$format_titulo);
$nuevahoja->write ( 0, 5, 'PROYECTO',$format_titulo );
$nuevahoja->write ( 0, 6, 'ACTIVIDAD/OBRA',$format_titulo );
$nuevahoja->write ( 0, 7, 'FUENTE FINANCIAMIENTO',$format_titulo );
$nuevahoja->write ( 0, 8, 'ORGANISMO FINANCIADOR',$format_titulo );
$nuevahoja->write ( 0, 9, 'PARTIDA',$format_titulo);
$nuevahoja->write ( 0, 10, 'ENTIDAD TRANSFERENCIA',$format_titulo );
$nuevahoja->write ( 0, 11, 'PRESUPUESTADO',$format_titulo );
$nuevahoja->write ( 0, 12, 'VIGENTE',$format_titulo );
$nuevahoja->write ( 0, 13, 'COMPROMETIDO',$format_titulo );
$nuevahoja->write ( 0, 14, 'DEVENGADO',$format_titulo );
$nuevahoja->write ( 0, 15, 'PAGADO',$format_titulo );

//OBTENCION DE LOS DATOS
$sigma = new cls_CustomDBSigma();
$res = $sigma->EjecucionRecurso ( 'null', 'null', $_SESSION ['PDF_sortcol'], $_SESSION ['PDF_sortdir'], $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad, $_SESSION ['PDF_id_declaracion'], $_SESSION ['PDF_tipo_presupuesto'] );
//$res = $sigma->EjecucionGastoInversion ( 'null', 'null', $_SESSION ['PDF_sortcol'], $_SESSION ['PDF_sortdir'], $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad, $_SESSION ['PDF_id_declaracion'], $_SESSION ['PDF_tipo_presupuesto'] );


if ($res) 
{
	$data = $sigma->salida;
	$fila = 1;

	foreach ( $data as $row ) 
	{
		$nuevahoja->write ( $fila, 0, $row [0] );
		$nuevahoja->write ( $fila, 1, $row [1] );
		$nuevahoja->write ( $fila, 2, $row [2] );
		$nuevahoja->write ( $fila, 3, $row [3] );
		$nuevahoja->writeString ( $fila, 4, $row[4] );
		$nuevahoja->writeString ( $fila, 5, $row[5] );
		$nuevahoja->writeString ( $fila, 6, $row[6] );
		$nuevahoja->write ( $fila, 7, $row [7] );
		$nuevahoja->write ( $fila, 8, $row [8] );
		$nuevahoja->write ( $fila, 9, $row [9] );
		$nuevahoja->write ( $fila, 10, $row [10] );
		$nuevahoja->write ( $fila, 11, $row [11] );
		$nuevahoja->write ( $fila, 12, $row [12] );
		$nuevahoja->write ( $fila, 13, $row [13] );
		$nuevahoja->write ( $fila, 14, $row [14] );
		$nuevahoja->write ( $fila, 15, $row [15] );
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