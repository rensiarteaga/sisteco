<?php
require('../../../lib/fpdf/fpdf.php');
//include_once("../../rcm_LibModeloAlmacenes.php");
include_once("../LibModeloContabilidad.php");
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{    //Cargar los datos
	//Cabecera de página

	function Header()
	{	global $title;
	$this->SetLeftMargin(5);
	//Logo
	$this->Image('../../../lib/images/logo_reporte.jpg',230,4,30,10);
	$this->Ln(8);
		$this->SetLineWidth(.1);

		$this->SetFont('Arial','B',12);
		if($_SESSION['operacion_bancarizacion_det']=="compra"){
		  $this->Cell(255,10,'REGISTRO AUXILIAR - COMPRAS MAYORES A Bs 50.000.-',0,0,'C');	
		}
		else{
		  $this->Cell(255,10,'REGISTRO AUXILIAR - VENTAS MAYORES A Bs 50.000.-',0,0,'C');	
		}
		
		$this->Ln(7);
		$this->SetDrawColor(103,113,157);
		$this->SetFillColor(255,255,255);
		$this->SetFont('Arial','B',6);		
		$this->Cell(10,4,'Mod.','LTR',0,'C',1);
		$this->Cell(15,4,'Fecha','LTR',0,'C',1);
		$this->Cell(10,4,'Tipo','LTR',0,'C',1);
		$this->Cell(15,4,'','LTR',0,'C',1);
		$this->Cell(65,4,'Razón Social','LTR',0,'C',1);
		$this->Cell(10,4,'Nro de','LTR',0,'C',1);
		$this->Cell(15,4,'Monto del','LTR',0,'C',1);
		$this->Cell(15,4,'Nro de','LTR',0,'C',1);
		$this->Cell(18,4,'Nro de Cuenta','LTR',0,'C',1);
		$this->Cell(22,4,'Monto Pagado en','LTR',0,'C',1);
		$this->Cell(15,4,'Monto','LTR',0,'C',1);
		$this->Cell(15,4,'Nit Entidad','LTR',0,'C',1);
		$this->Cell(12,4,'Nro Doc.','LTR',0,'C',1);
		$this->Cell(16,4,'Tipo de','LTR',0,'C',1);
		$this->Cell(16,4,'Fecha del','LTR',0,'C',1);
		$this->Ln(4);
		$this->Cell(10,4,'Transac.','LBR',0,'C',1);
		$this->Cell(15,4,'Documento','LBR',0,'C',1);
		$this->Cell(10,4,'Transac.','LBR',0,'C',1);
		if($_SESSION['operacion_bancarizacion_det']=="compra"){
		  $this->Cell(15,4,'Nit Proveedor','LBR',0,'C',1);	
		  $this->Cell(65,4,'Proveedor','LBR',0,'C',1);
		}
		else{
		  $this->Cell(15,4,'Nit/CI Cliente',1,0,'C',1);		
		  $this->Cell(65,4,'Cliente','LBR',0,'C',1);
		}
		$this->Cell(10,4,'Doc.','LBR',0,'C',1);
		$this->Cell(15,4,'Doc.','LBR',0,'C',1);
		$this->Cell(15,4,'Autorización','LBR',0,'C',1);
		$this->Cell(18,4,'del Doc.','LBR',0,'C',1);
		$this->Cell(22,4,'Doc. de Pago','LBR',0,'C',1);
		$this->Cell(15,4,'Acumulado','LBR',0,'C',1);
		$this->Cell(15,4,'Financiera','LBR',0,'C',1);
		$this->Cell(12,4,'de Pago','LBR',0,'C',1);
		$this->Cell(16,4,'Doc. de Pago','LBR',0,'C',1);
		$this->Cell(16,4,'Doc. de Pago','LBR',0,'C',1);
		$this->Ln(4);
	}

	function Footer()
	{	//Posición: a 1,5 cm del final
		/*$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','I',6);
		//Número de página
		$fecha=date("d-m-Y");
		//hora
		$hora=date("H:i:s");
		$this->Cell(120,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L');
		$this->Cell(110,10,'Página '.$this->PageNo().' de {nb}',0,0,'L');
		$this->Cell(100,10,'Fecha: '.$fecha ,0,0,'L');
		$this->ln(3);
		$this->Cell(100,10,'',0,0,'L');
		$this->Cell(130,10,'',0,0,'L');
		$this->Cell(200,10,'Hora: '.$hora ,0,0,'L');*/
		 $fecha=date("d-m-Y");
	    $hora=date("H:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
   	    $this->Cell(100,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(70,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(100,3,'Sistema: ENDESIS - SCI',0,0,'L');
		$this->Cell(70,3,'',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
		
	}

  	/////////////////////////////////////////////////////////////////////////////
  	function LoadData($id_bancarizacion,$tipo_operacion){     
	$Custom=new cls_CustomDBContabilidad();
	$criterio_filtro="BANDET.id_bancarizacion=".$id_bancarizacion." AND BANDET.tipo_operacion=''$tipo_operacion''";
	
	
	$Custom->RepBancarizacionDet(10000,0,'BANDET.id_bancarizacion_det','asc',$criterio_filtro,NULL,NULL,NULL,NULL,NULL);
	$var1=$Custom->salida;
	//echo $Custom->salida; exit;
	return $var1;
	}

	//Tabla coloreada
	function FancyTable($data)
	{  
				
		$this->SetLineWidth(.1);//grosor de la linea
		//Cabecera
	  	$this->SetFont('Arial','B',5);
		$w=array(15,65,18,22,16,10,12);
			//Datos					
			$this->SetFont('Arial','',5);
			$i=1;	
			$this->SetDrawColor(103,113,157);
		    $this->SetFillColor(221,221,221);            	        
	        foreach($data as $row){
	        	$relleno=0;
	        	    if($i%2==0){
	        	    	$relleno=1;
	        	    }
	        	    $this->Cell($w[5],5,$row[0],1,0,'C',$relleno);//desc_detalle
					$this->Cell($w[0],5,$row[1],1,0,'C',$relleno);//desc_ret_incor
					$this->Cell($w[5],5,$row[2],1,0,'C',$relleno);//desc_ret_incor
					$this->Cell($w[0],5,$row[3],1,0,'C',$relleno);//desc_ret_incor
					$this->Cell($w[1],5,$row[4],1,0,'L',$relleno);//desc_ret_incor
					$this->Cell($w[5],5,$row[5],1,0,'C',$relleno);//desc_ret_incor
					$this->Cell($w[0],5,$row[6],1,0,'R',$relleno);//desc_ret_incor
					$this->Cell($w[0],5,$row[7],1,0,'C',$relleno);//desc_ret_incor
					$this->Cell($w[2],5,$row[8],1,0,'C',$relleno);//desc_ret_incor
					$this->Cell($w[3],5,$row[9],1,0,'R',$relleno);//desc_ret_incor
					$this->Cell($w[0],5,$row[10],1,0,'R',$relleno);//desc_ret_incor
					$this->Cell($w[0],5,$row[11],1,0,'C',$relleno);//desc_ret_incor
					$this->Cell($w[6],5,$row[12],1,0,'C',$relleno);//desc_ret_incor
					$this->Cell($w[4],5,$row[13],1,0,'C',$relleno);//desc_ret_incor
					$this->Cell($w[4],5,$row[14],1,0,'C',$relleno);//desc_ret_incor
				
					$this->Ln(5);
					$i=$i+1;
			}			      
	}
}
$pdf=new PDF('L','mm','Letter');
$pdf->AliasNbPages();

//Títulos de las columnas
$id_bancarizacion=$id_bancarizacion;
$tipo_operacion=$tipo_operacion;
$data=$pdf->LoadData($id_bancarizacion,$tipo_operacion);
  	/*echo($fecha_inicio);
	exit();*/
$pdf->SetFont('Arial','',12);
$pdf->SetAutoPageBreak(1,35);
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(5);
$pdf->SetLeftMargin(5);
$pdf->AddPage();
$pdf->FancyTable($data);
$pdf->Output();
?>