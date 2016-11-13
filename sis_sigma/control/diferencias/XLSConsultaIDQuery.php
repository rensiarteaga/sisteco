<?php
session_start ();
require_once ('../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
include_once ("../LibModeloSigma.php");

if ($_SESSION ['PDF_tipo_dato'] == '1') {$nombre_archivo = 'consulta_id_cbte.xls';}
if ($_SESSION ['PDF_tipo_dato'] == '2') {$nombre_archivo = 'consulta_id_cta_doc.xls';}
if ($_SESSION ['PDF_tipo_dato'] == '3') {$nombre_archivo = 'consulta_id_devengado.xls';}
if ($_SESSION ['PDF_tipo_dato'] == '4') {$nombre_archivo = 'consulta_id_sol_compra.xls';}
if ($_SESSION ['PDF_tipo_dato'] == '5') {$nombre_archivo = 'consulta_id_rendicion.xls';}
if ($_SESSION ['PDF_tipo_dato'] == '6') {$nombre_archivo = 'consulta_id_planilla.xls';}

$docexcel = new Spreadsheet_Excel_Writer ( );
$nuevahoja = & $docexcel->addWorksheet ( "CONSULTA ID - ".$_SESSION ['PDF_id_dato']);

$format_titulo =& $docexcel->addFormat();
$format_titulo->setBold();
$format_titulo->setAlign('center');

$format_numero =& $docexcel->addFormat();
$format_numero->setNumFormat('D-MMM-YYYY');

$fila = 0;
$columna = 0;

$nuevahoja->write ( 0, 0, 'ID CBTE.',$format_titulo);
$nuevahoja->write ( 0, 1, 'ID PARTIDA',$format_titulo );
$nuevahoja->write ( 0, 2, 'PARTIDA',$format_titulo );
$nuevahoja->write ( 0, 3, 'FECHA EJEC.',$format_titulo);
$nuevahoja->write ( 0, 4, 'IMPORTE',$format_titulo);
$nuevahoja->write ( 0, 5, 'MOMENTO',$format_titulo);
$nuevahoja->write ( 0, 6, 'ID CTA.DOCUMENTADA',$format_titulo);
$nuevahoja->write ( 0, 7, 'ID DEVENGADO',$format_titulo);
$nuevahoja->write ( 0, 8, 'ID SOL.COMPRA',$format_titulo);
$nuevahoja->write ( 0, 9, 'ID CTA.RENDICION',$format_titulo);
$nuevahoja->write ( 0, 10, 'ID PLANILLA',$format_titulo);
$nuevahoja->write ( 0, 11, 'ID PARTIDA EJE.',$format_titulo);
$nuevahoja->write ( 0, 12, 'USUARIO REG',$format_titulo);

//OBTENCION DE LOS DATOS
$sigma = new cls_CustomDBSigma();
$res = $sigma->ConsultaIDQuery('null', 'null', $_SESSION ['PDF_sortcol'], $_SESSION ['PDF_sortdir'], $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $_SESSION ['PDF_tipo_dato'], $_SESSION ['PDF_id_declaracion'], $_SESSION ['PDF_id_partida'], $_SESSION ['PDF_id_dato'] );

if ($res) {
	$data = $sigma->salida;
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