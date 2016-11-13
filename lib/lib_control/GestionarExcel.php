<?php 
/**
**********************************************************
Nombre de archivo:	    GestionarExcel.php
Propósito:				Permite generar reportes en EXCEL
Autor:					JGL
**********************************************************
*/
session_start();
include_once "../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php";
class GestionarExcel
{
var $fila=0;
var $columna=0;
var $contador=0;
var $columnas_reporte=0;
var $nombre_archivo = 'GestionarExcel.php';
var $nombre_reporte = 'Excel.php';
var $xls; // reporte excel
var $sheet; // hoja excel
var $titulo_Y_inicio=0;
var $titulo_Y_fin=2;
var $titulo_X_inicio=0;
var $titulo_X_fin=10;
var $detalle_cabecera;

//var $pixel_mm=0.0026358772;
var $pixel_mm=0.1357;
var $formato_titulo=array("Size"=>"18",
		 				"Align"=>"center",
		 				"Color"=>"black",
		 				'FgColor'=>'white',
		 				'Pattern'=>1,
		 				'Border'=>'LRTB',
		 				'BorderColor'=>'black',
		 				);
var $formato_detalle=array("Size"=>"12",
		 				"Align"=>"center",
		 				"Color"=>"white",
		 				'FgColor'=>'blue',
		 				'Pattern'=>1,
		 				'Border'=>'LRTB',
		 				'BorderColor'=>'black',
		 				);	
var $align='center',$size=12,$color='black',$fgColor='orange',$pattern=1,$border='LRTB',$BorderColor='black';		 				 				
 
 
function __construct($nombre = NULL)

{

if($nombre == NULL)

$this->xls =& new Spreadsheet_Excel_Writer();

else 

$this->xls =& new Spreadsheet_Excel_Writer($nombre);

}

function SetNombreReporte($nombre_reporte)

{

$this->xls->send($nombre_reporte);

$this->nombre_reporte = $nombre_reporte;
   
}

function SetNombreReporteModificado($nombre_reporte){

$ruta_reporte = ""; //"../../../lib/lib_control/";

$this->nombre_reporte = $ruta_reporte.$nombre_reporte;

}


	/*function __construct()
	{
		$this->xls =& new Spreadsheet_Excel_Writer();
	}
	
	function SetNombreReporte($nombre_reporte)
	{
		$this->xls->send($nombre_reporte);
		$this->nombre_reporte = $nombre_reporte;
	}
	*/
	function SetTitulo($titulo_nombre,$x,$y,$columnas)
	{ 	 
		//$imageObject = imagecreatefromjpeg("../../../lib/images/logo_reporte.jpg");
//imagegif($imageObject, $imageFile . '.gif');
//imagepng($imageObject, $imageFile . '.png');
	//imagewbmp($imageObject, "../../../lib/images/logo_reporte".'.bmp');

		$this->sheet->insertBitmap(0,$columnas-1,"../../../lib/images/logo_reporte.bmp",1,1,0.4,1);
		//$this->sheet->insertBitmap(0,1,"../../../lib/images/logo_reporte.jpg",0,0,1,1);
		//$this->sheet->insertBitmap(0,1,"../../../lib/imagenes/compro.bmp",0,0,1,1);
		$format_casilla =&$this->xls->addFormat($this->formato_titulo);
		$format_casilla->setAlign('merge');
		$this->sheet->write($y,$x,$titulo_nombre,$format_casilla);		
		
		$titulo_casilla=&$this->sheet->mergeCells($y,$x,$this->titulo_Y_fin+$y,$columnas-1);
		//$titulo_casilla=&$this->sheet->mergeCells($y,$x,$this->titulo_Y_fin,$columnas-1);
		$this->fila=$y+$this->titulo_Y_fin+1;
		$this->titulo_X_fin=$columnas;
	}
	
	function SetHoja($nombre_hoja)
	{
		$this->sheet =& $this->xls->addWorksheet($nombre_hoja);
	}
	
	function SetFila($fila)
	{
		$this->fila = $fila;
	}
	
	function SetCabeceraDetalle($detalle)
	{	$this->detalle_cabecera=$detalle;
		$format_casilla =& $this->xls->addFormat($this->formato_detalle);
		$format_casilla->setBold();
		$this->columna=0;
		//inserta las columnas del reporte
		$i=0;
		foreach ($this->detalle_cabecera['columna'] as $f)
		{	$this->sheet->setColumn($i,$i,$this->detalle_cabecera['width'][$i]*$this->pixel_mm);		 
			$this->sheet->write($this->fila,$this->columna,strtoupper($f),$format_casilla);
			$this->columna++;
			$i++;	
		}
		$this->columnas_reporte=$this->columna;
		$this->titulo_X_fin=$this->columna;
		
		$this->fila=$this->fila+1;
	}
	
	function setDetalle($detalle)
	{	foreach ($detalle as $filas)
		{ 	$this->contador=0;
			$this->columna=0;
			$i=0;
			//echo $this->detalle_cabecera['align'][$i]; exit();
			foreach ($this->detalle_cabecera['valor'] as $fila_columa)
			{	 
				$format_casilla =& $this->xls->addFormat(array(	'Size'=>$this->size,
												 				'Align'=>$this->detalle_cabecera['align'][$i],
												 				'Width'=>$this->detalle_cabecera['width'][$i],
												 				'Color'=>$this->color,
												 				//'FgColor'=>$this->fgColor,
												 				//'Pattern'=>$this->pattern,
												 				//'Border'=>$this->border,
												 				//'BorderColor'=>$this->BorderColor,
												 				));																				 				
				//echo print_r($format_casilla);
					$this->sheet->write($this->fila,$this->columna, $filas[$fila_columa],$format_casilla );
					$this->columna=$this->columna+1;
					$this->contador=$this->contador+1;		
					$i++;			 
			} 
  			$this->fila=$this->fila+1;			 
		}
	}
	
	function setFin()
	{
		$this->xls->close();
		if (PEAR::isError($this->xls)) {die($this->xls->getMessage());}
	}
}?>