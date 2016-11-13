<?php
require('../../../lib/fpdf/fpdf.php');
//include_once("../../rcm_LibModeloAlmacenes.php");
include_once("../LibModeloKardexPersonal.php");
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
		$this->Cell(255,10,'RESUMEN DE COSTOS DE PERSONAL POR PRESUPUESTO (Expresado en Bs.)',0,0,'C');
		$this->Ln(7);
		$this->SetFont('Arial','B',10);
		$this->Cell(20,8,'Gestión :',0,0,'L');
		$this->SetFont('Arial','',10);
		$this->Cell(30,8,$_SESSION['gestion_resumen_costo_centro'],0,0,'L');
		$this->SetFont('Arial','B',10);
		$this->Cell(20,8,'Planilla:',0,0,'L');
		$this->SetFont('Arial','',10);
		$this->Cell(30,8,$_SESSION['planilla_costo_centro'],0,0,'L');
		$this->Ln(7);
		$this->SetFont('Arial','B',10);
		$this->Cell(20,8,'Mes:',0,0,'L');
		$this->SetFont('Arial','',10);
		$this->Cell(30,8,$_SESSION['mes_resumen_costo_centro'],0,0,'L');
		$this->SetFont('Arial','B',10);
		$this->Cell(20,8,'Distrito:',0,0,'L');
		$this->SetFont('Arial','',10);
		$this->Cell(30,8,$_SESSION['PDF_nombre_lugar_costos'],0,0,'L');
		$this->Ln(7);
		$this->SetDrawColor(103,113,157);
		$this->SetFillColor(255,255,255);
		$this->SetFont('Arial','B',8);		
		$this->Cell(73,4,'','LTR',0,'C',1);
		$this->Cell(32,4,'Estructura','LTR',0,'C',1);
		$this->Cell(45,4,'Servicios Personales',1,0,'C',1);
		$this->Cell(15,4,'','LTR',0,'C',1);
		$this->Cell(15,4,'','LTR',0,'C',1);
		$this->Cell(15,4,'','LTR',0,'C',1);
		$this->Cell(15,4,'','LTR',0,'C',1);
		$this->Cell(15,4,'Rein.','LTR',0,'C',1);
		$this->Cell(15,4,'Total','LTR',0,'C',1);
		$this->Cell(15,4,'','LTR',0,'C',1);
		$this->Cell(15,4,'','LTR',0,'C',1);
		$this->Ln(4);
		$this->Cell(73,4,'Presupuesto','LBR',0,'C',1);
		$this->Cell(32,4,'Programática','LBR',0,'C',1);
		$this->Cell(15,4,'Hrs. Norm.',1,0,'C',1);
		$this->Cell(15,4,'Hrs. Extr.',1,0,'C',1);
		$this->Cell(15,4,'Hrs. RecN.',1,0,'C',1);
		$this->Cell(15,4,'Sub Total','LBR',0,'C',1);
		$this->Cell(15,4,'Aguin','LBR',0,'C',1);
		$this->Cell(15,4,'Subsidio','LBR',0,'C',1);
		$this->Cell(15,4,'IncTmp','LBR',0,'C',1);
		$this->Cell(15,4,'NoCotiz.','LBR',0,'C',1);
		$this->Cell(15,4,'Carg. Soc.','LBR',0,'C',1);
		$this->Cell(15,4,'Ben. Soc.','LBR',0,'C',1);
		$this->Cell(15,4,'TotalGral.','LBR',0,'C',1);
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
		$this->Cell(100,3,'Sistema: ENDESIS - KARDEX',0,0,'L');
		$this->Cell(70,3,'',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
		
	}

  	/////////////////////////////////////////////////////////////////////////////
  	function LoadData($id_planilla,$fecha_planilla){     
	$Custom=new cls_CustomDBKardexPersonal();
	$Custom->ResumenCostosPersonalDis(0,0,'nombre_lugar','asc','0=0',NULL,NULL,NULL,NULL,NULL,$id_planilla,$fecha_planilla);
	$var1=$Custom->salida;
	return $var1;
	}

	//Tabla coloreada
	function FancyTable($data)
	{  
				
		$suma_normal=0.00;
		$suma_extra=0.00;
		$suma_nocturno=0.00;
		$suma_subtotal=0.00;
		$suma_aguin=0.00;
		$suma_subsid=0.00;
		$suma_inctmp=0.00;
		$suma_reintnc=0.00;
		$suma_carga_soc=0.00;
		$suma_indemniz=0.00;
		$suma_total_gral=0.00;
		
	    $this->SetLineWidth(.1);//grosor de la linea
		//Cabecera
	  	$this->SetFont('Arial','B',6);
		$w=array(73,15,32);
			//Datos					
			$this->SetFont('Arial','',6);
			$i=1;	
			$this->SetDrawColor(103,113,157);
		    $this->SetFillColor(221,221,221);
		    $nombre_lugar=$_SESSION['PDF_nombre_lugar_costos'];            	        
	        foreach($data as $row){
	        	$relleno=0;
	        	    if($i%2==0){
	        	    	$relleno=1;
	        	    }
	        	    if($_SESSION['PDF_nombre_lugar_costos']!=$row[15]){
	        	    	$_SESSION['PDF_nombre_lugar_costos']=$row[15];
	        	    	$this->Cell($w[0],5,'','LBT',0,'R',$relleno);//desc_detalle
			            $this->Cell($w[2],5,'Totales (Bs.):','BTR',0,'R',$relleno);//desc_detalle
					    $this->Cell($w[1],5,round($suma_normal,2),1,0,'R',$relleno);//desc_ret_incor
					    $this->Cell($w[1],5,round($suma_extra,2),1,0,'R',$relleno);//desc_ret_incor
					    $this->Cell($w[1],5,round($suma_nocturno,2),1,0,'R',$relleno);//desc_ret_incor
					    $this->Cell($w[1],5,round($suma_subtotal,2),1,0,'R',$relleno);//desc_ret_incor
					    $this->Cell($w[1],5,round($suma_aguin,2),1,0,'R',$relleno);//desc_ret_incor
					    $this->Cell($w[1],5,round($suma_subsid,2),1,0,'R',$relleno);//desc_ret_incor
					    $this->Cell($w[1],5,round($suma_inctmp,2),1,0,'R',$relleno);//desc_ret_incor
					    $this->Cell($w[1],5,round($suma_reintnc,2),1,0,'R',$relleno);//desc_ret_incor
					    $this->Cell($w[1],5,round($suma_carga_soc,2),1,0,'R',$relleno);//desc_ret_incor
					    $this->Cell($w[1],5,round($suma_indemniz,2),1,0,'R',$relleno);//desc_ret_incor
					    $this->Cell($w[1],5,round($suma_total_gral,2),1,0,'R',$relleno);//desc_ret_incor
					    $suma_normal=0.00;
		$suma_extra=0.00;
		$suma_nocturno=0.00;
		$suma_subtotal=0.00;
		$suma_aguin=0.00;
		$suma_subsid=0.00;
		$suma_inctmp=0.00;
		$suma_reintnc=0.00;
		$suma_carga_soc=0.00;
		$suma_indemniz=0.00;
		$suma_total_gral=0.00;
	        	    	$this->AddPage();
	        	    }
	        	   
	        	    $this->Cell($w[0],5,$row[1],1,0,'L',$relleno);//desc_detalle
					$this->Cell($w[2],5,$row[2],1,0,'L',$relleno);//desc_ret_incor
					$this->Cell($w[1],5,round($row[3],2),1,0,'R',$relleno);//desc_ret_incor
					$this->Cell($w[1],5,round($row[4],2),1,0,'R',$relleno);//desc_ret_incor
					$this->Cell($w[1],5,round($row[5],2),1,0,'R',$relleno);//desc_ret_incor
					$this->Cell($w[1],5,round($row[6],2),1,0,'R',$relleno);//desc_ret_incor
					$this->Cell($w[1],5,round($row[7],2),1,0,'R',$relleno);//desc_ret_incor
					$this->Cell($w[1],5,round($row[8],2),1,0,'R',$relleno);//desc_ret_incor
					$this->Cell($w[1],5,round($row[9],2),1,0,'R',$relleno);//desc_ret_incor
					$this->Cell($w[1],5,round($row[10],2),1,0,'R',$relleno);//desc_ret_incor
					$this->Cell($w[1],5,round($row[11],2),1,0,'R',$relleno);//desc_ret_incor
					$this->Cell($w[1],5,round($row[12],2),1,0,'R',$relleno);//desc_ret_incor
					$this->Cell($w[1],5,round($row[13],2),1,0,'R',$relleno);//desc_ret_incor
					$this->Ln(5);
					$i=$i+1;
					$suma_normal=$suma_normal+$row[3];
		            $suma_extra=$suma_extra+$row[4];
		            $suma_nocturno=$suma_nocturno+$row[5];
		            $suma_subtotal=$suma_subtotal+$row[6];
		            $suma_aguin=$suma_aguin+$row[7];
		            $suma_subsid=$suma_subsid+$row[8];
		            $suma_inctmp=$suma_inctmp+$row[9];
		            $suma_reintnc=$suma_reintnc+$row[10];
		            $suma_carga_soc=$suma_carga_soc+$row[11];
		            $suma_indemniz=$suma_indemniz+$row[12];
		            $suma_total_gral=$suma_total_gral+$row[13];
			}
			        $this->Cell($w[0],5,'','LBT',0,'R',$relleno);//desc_detalle
			            $this->Cell($w[2],5,'Totales (Bs.):','BTR',0,'R',$relleno);//desc_detalle
					    $this->Cell($w[1],5,round($suma_normal,2),1,0,'R',$relleno);//desc_ret_incor
					    $this->Cell($w[1],5,round($suma_extra,2),1,0,'R',$relleno);//desc_ret_incor
					    $this->Cell($w[1],5,round($suma_nocturno,2),1,0,'R',$relleno);//desc_ret_incor
					    $this->Cell($w[1],5,round($suma_subtotal,2),1,0,'R',$relleno);//desc_ret_incor
					    $this->Cell($w[1],5,round($suma_aguin,2),1,0,'R',$relleno);//desc_ret_incor
					    $this->Cell($w[1],5,round($suma_subsid,2),1,0,'R',$relleno);//desc_ret_incor
					    $this->Cell($w[1],5,round($suma_inctmp,2),1,0,'R',$relleno);//desc_ret_incor
					    $this->Cell($w[1],5,round($suma_reintnc,2),1,0,'R',$relleno);//desc_ret_incor
					    $this->Cell($w[1],5,round($suma_carga_soc,2),1,0,'R',$relleno);//desc_ret_incor
					    $this->Cell($w[1],5,round($suma_indemniz,2),1,0,'R',$relleno);//desc_ret_incor
					    $this->Cell($w[1],5,round($suma_total_gral,2),1,0,'R',$relleno);//desc_ret_incor
					
					$this->Ln(5);
					      
	}

}
$pdf=new PDF('L','mm','Letter');
$pdf->AliasNbPages();
//Títulos de las columnas
		$id_planilla=$id_planilla;
		$fecha_planilla=$fecha_planilla;
$data=$pdf->LoadData($id_planilla,$fecha_planilla);
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