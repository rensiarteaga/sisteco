<?php
session_start ();
require_once ('../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
include_once ("../LibModeloSigma.php");

$nombre_archivo = 'ejecucion_gasto_inversion.xls';
$docexcel = new Spreadsheet_Excel_Writer ( );
$nuevahoja = & $docexcel->addWorksheet ( "EJECUCION GASTO - INVERSION" );

$format_titulo =& $docexcel->addFormat();
$format_titulo->setBold();
//$format_center =& $docexcel->addFormat();
$format_titulo->setAlign('center');

$format_numero =& $docexcel->addFormat();
$format_numero->setNumFormat('D-MMM-YYYY');

$fila = 0;
$columna = 0;
/*$valor_celda = 'prueba';
$nuevahoja->setColumn ( 1, 18, 15 );
$nuevahoja->write ( 1, 2, 'EJECUCIÓN PRESUPUESTARIA' ); //dibuja una celad con contenido y orientacion  x, y 
$nuevahoja->write ( 2, 2, 'Presupuesto de ' . $_SESSION ['PDF_desc_pres'] . " Gestión " . $_SESSION ['PDF_gestion_pres'] );
$nuevahoja->write ( 3, 2, 'Del ' . $_SESSION ['PDF_fecha_desde'] . ' Al ' . $_SESSION ['PDF_fecha_hasta'] );
$nuevahoja->write ( 4, 2, '(Expresado en ' . $_SESSION ['PDF_desc_moneda'] . ')' );
//adicionando la estructura programtica


$epe = " ";
$nuevahoja->write ( 6, 1, 'ESTRUCTURA PROGRAMATICA: ' );

if ($_SESSION ['PDF_regional']) {
	$epe = $epe . "REGIONAL: ";
	$nuevahoja->write ( 6, 2, $epe );
	$nuevahoja->write ( 6, 3, $_SESSION ['PDF_regional'] );
}
if ($_SESSION ['PDF_financiador']) {
	$epe = "FINANCIADOR: ";
	$nuevahoja->write ( 7, 2, $epe );
	$nuevahoja->write ( 7, 3, $_SESSION ['PDF_financiador'] );
}

if ($_SESSION ['PDF_programa']) {
	$epe = "PROGRAMA: ";
	$nuevahoja->write ( 8, 2, $epe );
	$nuevahoja->write ( 8, 3, $_SESSION ['PDF_programa'] );
}
if ($_SESSION ['PDF_proyecto']) {
	$epe = "PROYECTO: ";
	$nuevahoja->write ( 9, 2, $epe );
	$nuevahoja->write ( 9, 3, $_SESSION ['PDF_proyecto'] );
}
if ($_SESSION ['PDF_actividad']) {
	$epe = "ACTIVIDAD: ";
	$nuevahoja->write ( 10, 2, $epe );
	$nuevahoja->write ( 10, 3, $_SESSION ['PDF_actividad'] );
}

$nuevahoja->write ( 12, 1, 'UNIDAD ORGANIZACIONAL: ' );
$nuevahoja->write ( 12, 2, $_SESSION ['PDF_unidad_organizacional'] );
$nuevahoja->write ( 13, 1, 'FUENTE DE FINANCIAMIENTO: ' );
$nuevahoja->write ( 13, 2, $_SESSION ['PDF_Fuente_financiamiento'] );

if ($epe == " ") {
	$epe = "Todos";
	$nuevahoja->write ( 6, 3, $epe );
	$nuevahoja->write ( 7, 3, $epe );
	$nuevahoja->write ( 8, 3, $epe );
	$nuevahoja->write ( 9, 3, $epe );
	$nuevahoja->write ( 10, 3, $epe );
	$nuevahoja->write ( 12, 3, $epe );
	$nuevahoja->write ( 13, 3, $epe );
}
//fin de la estructura programatica
$nuevahoja->write ( 15, 1, 'CODIGO' );
$nuevahoja->write ( 15, 2, 'PARTIDA' );

IF ($_SESSION ['PDF_tipo_pres'] > 1) //PRESUPUESTOS DE GASTO E INVERSION
{
	$nuevahoja->write ( 15, 3, 'COMPROMETIDO' );
	$nuevahoja->write ( 15, 4, 'DEVENGADO' );
	$nuevahoja->write ( 15, 5, 'PAGADO' );
} else //PRESUPUESTOS DE RECURSOS
{
	$nuevahoja->write ( 15, 3, 'DEVENGADO' ); //DEVENGADO
	$nuevahoja->write ( 15, 4, 'INGRESADO' ); //INGRESADO		 
}*/

//DEFINICION DE COLUMNAS
/*$nuevahoja->write ( 0, 0, 'PRESUPUESTO' );
$nuevahoja->write ( 0, 1, 'GESTION' );
$nuevahoja->write ( 0, 2, 'ENTIDAD' );
$nuevahoja->write ( 0, 3, 'MES' );
$nuevahoja->write ( 0, 4, 'PROGRAMA' );
$nuevahoja->write ( 0, 5, 'PROYECTO' );
$nuevahoja->write ( 0, 6, 'ACTIVIDAD/OBRA' );
$nuevahoja->write ( 0, 7, 'FUENTE FINANCIAMIENTO' );
$nuevahoja->write ( 0, 8, 'ORGANISMO FINANCIADOR' );
$nuevahoja->write ( 0, 9, 'PARTIDA');
$nuevahoja->write ( 0, 10, 'ENTIDAD TRANSFERENCIA' );
$nuevahoja->write ( 0, 11, 'PRESUPUESTADO' );
$nuevahoja->write ( 0, 12, 'VIGENTE' );
$nuevahoja->write ( 0, 13, 'COMPROMETIDO' );
$nuevahoja->write ( 0, 14, 'DEVENGADO' );
$nuevahoja->write ( 0, 15, 'PAGADO' );*/

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
//$res = $sigma->EjecucionGastoInversion ( $_SESSION ['PDF_limit'], $_SESSION ['PDF_start'], $_SESSION ['PDF_sortcol'], $_SESSION ['PDF_sortdir'], $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad, $_SESSION ['PDF_id_declaracion'], $_SESSION ['PDF_tipo_presupuesto'] );
$res = $sigma->EjecucionGastoInversion ( 'null', 'null', $_SESSION ['PDF_sortcol'], $_SESSION ['PDF_sortdir'], $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad, $_SESSION ['PDF_id_declaracion'], $_SESSION ['PDF_tipo_presupuesto'] );

/*echo 'llega al final del listar'; 
exit ();*/ 

if ($res) 
{
	$data = $sigma->salida;
	$fila = 1;
	
	/*echo "<pre>";
	print_r($data);
	echo "</pre>";
	exit; */
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
		
		/*echo $fila; 
		exit ();*/
		
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