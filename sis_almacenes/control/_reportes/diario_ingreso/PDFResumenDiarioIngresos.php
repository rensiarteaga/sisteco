<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../rcm_LibModeloAlmacenes.php");
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{
	var $sep_decim='.';
	var $sep_mil=',';
	
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    //Iniciación de variables
    }
	
	

	function Header()
	{
		global $title;
		$imprimir_footer=1;
		$this->SetLeftMargin(15);
		$w=array(7,20,20,83,30,30);
		$header=array('#','Fecha','Número','Super Grupo','Cantidad Recibida','Costo Valorado');
		
		$funciones = new funciones();
		//Logo
		$this->Image('../../../../lib/images/logo_reporte.jpg',170,2,35,15);
		
			
		// establecemos el idioma de la página
		setlocale (LC_TIME,"spanish", "es_ES@euro", "es_ES", "es");
		//creamos la cadena con los especificadores necesarios
		$formato = "%d de %B de %Y";
		//$formato = "%A, %d de %B de %Y";
		
		$this->SetFont('Arial','B',12);
		//Movernos a la derecha
		
		$this->Cell(185,4,'RESUMEN VALORADO DE INGRESOS',0,1,'C');
		$this->Ln();
		
		//$this->Cell(185,4,utf8_decode($_SESSION['res_sal_gestion']),0,1,'C');

		$fechad=$_SESSION["res_sal_fecha_desde"];

		$mes = substr($fechad, 0, 2);
		$dia = substr($fechad, 3, 2);
		$anio = substr($fechad, -4);
		$fechad=$dia.'-'.$mes.'-'.$anio;
		//Mostramos la fecha, ahora sí en el idioma deseado.
		$fechad=strftime($formato, strtotime($fechad));

		$fechah=$_SESSION["res_sal_fecha_hasta"];

		$mes = substr($fechah, 0, 2);
		$dia = substr($fechah, 3, 2);
		$anio = substr($fechah, -4);
		$fechah=$dia.'-'.$mes.'-'.$anio;

		//Mostramos la fecha, ahora sí en el idioma deseado.
		$fechah=strftime($formato, strtotime($fechah));
		
        $this->SetFont('Arial','B',8);
		$this->Cell(30,5,'Gestión:',0,0);
		$this->SetFont('Arial','',8);
        $this->Cell(110,5,''.$_SESSION['res_sal_gestion'],0,0,'L');
		
		//$this->SetX(150);
		$this->SetFont('Arial','B',8);
        $this->Cell(15,5,'Desde:',0,0,'L');
        $this->SetFont('Arial','',8);
        $this->Cell(50,5,''.$fechad,0,1,'L');
        
        $this->SetFont('Arial','B',8);
        $this->Cell(30,5,'EP:',0,0);
        $this->SetFont('Arial','',8);
        $this->Cell(110,5,''.$_SESSION['res_sal_codigo_ep'],0,0,'L');
        
        $this->SetFont('Arial','B',8);
        $this->Cell(15,5,'Hasta :',0,0,'L');
        $this->SetFont('Arial','',8);
        $this->Cell(50,5,''.$fechah,0,1,'L');
        
        
        $this->SetFont('Arial','B',8);
        $this->Cell(30,5,'Almacén:',0,0);
        $this->SetFont('Arial','',8);
        $this->Cell(110,5,''.$_SESSION['res_sal_desc_almacen'],0,1,'L');
        $this->SetFont('Arial','B',8);
        $this->Cell(30,5,'Almacén Lógico:',0,0);
        $this->SetFont('Arial','',8);
        $this->Cell(60,5,''.$_SESSION['res_sal_desc_almacen_logico'],0,0,'L');
        $this->SetFont('Arial','B',8);
        $this->Cell(15,5,'Origen:',0,0);
        $this->SetFont('Arial','',8);
        $this->Cell(85,5,''.$_SESSION['res_sal_solicitante'],0,1,'L');
        $this->Ln();
		
		$this->SetFont('Arial','',10);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(190,190,190);
		$this->SetLineWidth(.1);
		$this->SetFont('','',10);
		
		$this->SetFont('Arial','',7);
		//Imprime los rótulos de las columnas

		for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],5,$header[$i],1,0,'C',1);
		$this->Ln();

	}
	//Pie de página
	function Footer()
	{
		   $fecha=date("d-m-Y");
	       $hora=date("h:i:s");
	    $this->SetY(-10);
   	    $this->SetFont('Arial','',6);
   	    $this->Cell(190,0.2,'',1,1);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
		//fecha
	}

	//Tabla coloreada
	function FancyTable($data,$header,$header_det)
	{
		$cont=1;
		$wdet=array(7,20,20,83,30,30);
		$cant=100000;
		$puntero=0;
		$sortcol='ITEM.nombre';
		$sortdir='asc';
		$criterio_filtro="0=0";
		//$criterio_filtro=" INGRES.fecha_finalizado_cancelado = ''".$_SESSION["part_dia_fecha_desde"]."''";
		$Custom=new cls_CustomDBAlmacenes();
		
		$Custom->ListarResumenIngresoReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$_SESSION['res_sal_id_financiador'],$_SESSION['res_sal_id_regional'],$_SESSION['res_sal_id_programa'],$_SESSION['res_sal_id_proyecto'],$_SESSION['res_sal_id_actividad'],$_SESSION['res_sal_id_parametro_almacen'],$_SESSION['res_sal_fecha_desde'],$_SESSION['res_sal_fecha_hasta'],$_SESSION['res_sal_id_almacen'],$_SESSION['res_sal_id_almacen_logico']);
		$resp_ing=$Custom->salida;

		
			foreach($resp_ing as $row)
			{      
				//Contador hoja
				$prim_hoja=1;
				
				$this->SetFont('Arial','',10);
				$this->SetFillColor(255,255,255);
				$this->SetTextColor(0);
				$this->SetDrawColor(190,190,190);
				$this->SetLineWidth(.1);
				$this->SetFont('','',10);
				//Cabecera
			
				$fecha=date("d-m-Y");
		
				$this->SetFont('Arial','',6);
				$this->Cell($wdet[0],4,$cont,'LTRB',0,'C',$fill);
				
                $this->SetFont('Arial','B',6);
				$this->Cell($wdet[1],4,'  '.$row['fecha_finalizado_cancelado'],'LTRB',0,'L',$fill);
				$this->SetFont('Arial','',6);
				
				$this->Cell($wdet[2],4,$row['correlativo_ing'],'LTRB',0,'C',$fill);
				$this->Cell($wdet[3],4,$row['nombre'],'LTRB',0,'L',$fill);//$this->Cell($wdet[3],4,$row[10],'LTRB',0,'R',$fill);
				$this->Cell($wdet[4],4,$row[4],'LTRB',0,'R',$fill);
				$this->Cell($wdet[5],4,$row[3],'LTRB',1,'R',$fill);
				
				$cont++;
				
			}
	/*
		//Contador hoja
		$prim_hoja=1;

		$this->SetFont('Arial','',10);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(190,190,190);
		$this->SetLineWidth(.1);
		$this->SetFont('','',10);

		//Cabecera
			
		$fecha=date("d-m-Y");
		
		$cont=0;
		
		
		//$this->ImprimirTabla($resp_ing,5,0.6,$header,$w,$a);
		 $this->SetFont('Arial','',6);
         $this->SetWidths(array(7,20,20,20,83,30,30));
         $this->SetVisibles(array(1,0,1,1,1,1,1));
         $this->SetAligns(array('C','L','L','L','R','R','R'));
         $this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
         $this->SetFontsStyles(array('','','','','','B',''));
         $this->SetFontsSizes(array(5,5,6,6,6,6,6));
         $this->SetSpaces(array(3.5,3.5,3.5,3.5,3.5,3.5,3.5));
         $this->SetDecimales(array(0,0,0,2,2,2,2));

		
		for ($i=0;$i<sizeof($resp_ing);$i++){
 	        $cont=$i+1;
 	      
            $this->MultiTabla(array_merge((array)$cont,(array)$resp_ing[$i]),2,3,4,6);
       
          }*/

		 
	}




}

$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
//Títulos de las columnas
$header=array('#','Fecha','Número','Super Grupo','Cantidad Recibida','Costo Valorado');


//Carga de datos
$tipo=$tipo;
//$data=$pdf->LoadData();
//echo json_encode($tipo_torre);
$pdf->SetFont('Arial','',10);
$pdf->SetAutoPageBreak(1,20);
$pdf->SetMargins(10,10,10);
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(15);
$pdf->SetLeftMargin(15);
$pdf->AddPage();
//$pdf->Maestro($data,'Original',$header,$header_det);
$pdf->FancyTable('',$header,'');
$pdf->Output();
?>