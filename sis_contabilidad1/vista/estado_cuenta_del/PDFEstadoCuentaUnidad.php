<?php

session_start();
require('../../../lib/fpdf/fpdf.php');
require('../../../lib/funciones.inc.php');
include_once("../../../lib/configuracion.log.php");
include_once("../../control/LibModeloContabilidad.php");


class PDF extends FPDF
{
	var $id_ep='';
	var $total_importe=0;
	var $total_valorado=0;
	var $cuenta_anterior='';
	var $primera_vez=0;
	var $cont=1;
	var $contador=0;
	var $total_count=0;	
	var $inicio='';
	var $moneda='';
	var $id_uo='';
	var $cantidad_meses='';
	var $id_cuenta='';
	var $id_moneda='';
	var $fecha_del='';
	var $fecha_al='';
	
	function Header()
	{
			$Custom = new cls_CustomDBContabilidad();//$this->SetY(36);
			$cant = 1000;
			$puntero = 0;
			$sortcol = 'TRANS.id_cuenta';
			$sortdir = 'asc';
			$id_moneda = $_SESSION['rep_id_moneda'];	
			$id_uo = $_SESSION['rep_id_uo']	;
			$fecha_del='01-01-'.$_SESSION['rep_del_fecha'];
			$fecha_al=$_SESSION['rep_al_fecha'];
			//$id_ep = $_SESSION['rep_id_ep']	;
			//$criterio_filtro ='0=0' ;				
			$criterio_filtro ='0=0' ;		
	
	    		$res = $Custom->ListarEstadoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$id_ep,$id_uo,$fecha_del,$fecha_al);
					$data=	$Custom->salida;

					if($puntero==0){
						$this->cuenta_anterior=$data[0][0];
						$this->primera_vez=1;
					}

		
		
		//------------
		$funciones = new funciones();
	  //$this-> AddFont('Arial','','arial.php');
$this->SetMargins(5,5,5);
$this->SetFont('Arial','B',16);
    $this->Image('../../../lib/images/logo_reporte.jpg',175,2,38,15);
   
$this->SetXY(40,5);
$this->Cell(140,15,'Estado de Cuentas por Unidad Organizacional',0,0,'C');
if($_SESSION['rep_id_moneda']=='1'){	$this->moneda='(en Bolivianos)';}
if($_SESSION['rep_id_moneda']=='2'){	$this->moneda='(en Dolares)';}
if($_SESSION['rep_id_moneda']=='3'){	$this->moneda='(en UFV´s)';}
$x=$this->GetX();
$this->Ln(10);
$this->SetFont('Arial','I',8);
$this->Cell(90,5,'',0,0);
$this->Cell(50,5,$this->moneda,0,0);
$this->SetFont('Arial','B',10);
$this->Ln(5);
//$this->SetFont('Arial','B',10);
$this->Cell(40,5,'Unidad Organizacional:',0,0);
$this->SetFont('Arial','I',8);
$this->Cell(55,5,$data[0][3],0,0);
$this->SetFont('Arial','B',10);
$this->Cell(30,5,'',0,0);
$this->Cell(10,5,'Del:',0,0);
$this->SetFont('Arial','I',8);
$this->Cell(55,5,'01-01-'.$_SESSION['rep_del_fecha'],0,0);
$this->ln(5);
$this->Cell(50,5,'',0,0);
$this->Cell(55,5,'',0,0);
$this->SetFont('Arial','B',10);
$this->Cell(30,5,'',0,0);
$this->Cell(10,5,'Al:',0,0);
$this->SetFont('Arial','I',8);
$this->Cell(55,5,$_SESSION['rep_al_fecha'],0,0);
$this->ln(5);
 $this->SetFont('Arial','B',6);
    $this->Cell(6,6,'Nº','LTRB',0,'C',0);
    $this->Cell(50,6,'CUENTA','LTRB',0,'C',0);
    $this->Cell(60,6,'AUXILIAR','LTRB',0,'C',0);
    $this->Cell(60,6,'ESTRUCTURA PROGRAMATICA','LTRB',0,'C',0);
    $this->Cell(30,6,'SALDO','LTRB',0,'C',0);
    $this->ln(); 
	    
	   
	}
	
	//Pie de página
	function Footer()
	{
	      //Posición: a 1,5 cm del final
	    $this->SetY(-15);
	    //Arial italic 8
	    $this->SetFont('Arial','I',8);
	    //ip
	    $ip = captura_ip();
	  
		 //Número de página
	    $fecha=date("d-m-Y");
		//hora
	    $hora=date("H:i:s");
		$this->Cell(60,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L'); 
	    $this->Cell(50,10,'Página '.$this->PageNo().' de {nb}',0,0,'R');     
	    $this->Cell(85,10,'Fecha: '.$fecha ,0,0,'R');
	    $this->ln(3);
	    $this->Cell(60,10,'',0,0,'L'); 
	    $this->Cell(50,10,'',0,0,'C');
	    $this->Cell(85,10,'Hora: '.$hora ,0,0,'R');
	    //fecha
	   
	}
	function maestro()
	{	
			$Custom = new cls_CustomDBContabilidad();//$this->SetY(36);
		
		
			$cant = 1000;
			$puntero = 0;
			//$sortcol = 'cli.nro_cuenta,cob.gestion_fac, cob.periodo_fac';
			$sortcol = 'TRANS.id_cuenta';
			$sortdir = 'asc';
			//$id_cuenta= $_SESSION['rep_id_cuenta'];
			$id_moneda = $_SESSION['rep_id_moneda'];	
			$id_uo = $_SESSION['rep_id_uo']	;
			$id_ep = $_SESSION['rep_id_ep']	;
				$fecha_del='01-01-'.$_SESSION['rep_del_fecha'];
			$fecha_al=$_SESSION['rep_al_fecha'];
			$criterio_filtro ='0=0' ;		
	//echo 'ep_pdf'.$id_ep;exit;
	    	$res=$Custom->ContarEstadoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$id_ep,$id_uo,$fecha_del,$fecha_al);
			
	    	if($res) $total_count= $Custom->salida;
			$ban=1;
			while($total_count>=$puntero)
	    	{	
	    		$res = $Custom->ListarEstadoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$id_ep,$id_uo,$fecha_del,$fecha_al);
				//echo "aqui";
	    		//echo $res; exit;
	    		if($res){
					$data=	$Custom->salida;
					$this->FancyTable($data,$ban,$total_count,$puntero);
					$ban++;
					//$this->FancyTable($data);
					if($puntero==0){
						$this->cuenta_anterior=$data[0][0];
						$this->primera_vez=1;
					}
				}
				$puntero=$puntero+1000;
	
			}
	}
	function FancyTable($data,$van,$total_count,$puntero)
	
	{
		$contador =$puntero;
		$funciones = new funciones();
	    $cont=1;
		
	    $this->SetLineWidth(.1);
	    $this->SetFont('Arial','',7);
	    //Restauración de colores y fuentes
	    $this->SetFillColor(224,235,255);
	    $this->SetTextColor(0);
	    $this->SetDrawColor(0,0,0);
	    //Datos
	    $fill=0;
	   foreach($data as $row)
	    {
	    	$this->SetFont('Arial','',6);
    	   	if($van==1){ 
    		//nro
			//$this->ln(); 
    		$this->Cell(6,5,$this->cont,1,0,'R',$fill);
		       //cuenta
		    $this->Cell(50,5,$row[1].'    '.$row[2],'1',0,'L',$fill);
		    //$this->ln(); 
			//auxiliar
		    $this->Cell(60,5,$row[6].'   '.$row[7],0,0,'L',$fill);
		    //unidad organizacional
		    $this->Cell(60,5,$row[5],0,0,'L',$fill);
		    //d
		    //$this->Cell(50,5,$row[3],0,0,'L',$fill);
		    //saldo
		    $this->Cell(30,5,number_format($row[4],2,'.',','),'R',0,'R',$fill);
	            
	    
	       	$this->ln();
	    	$this->cuenta_anterior=$row[0];
			//$this->total_consumo+=$row[5];
		 	$this->total_valorado+=$row[4];
	 	
    	 }
        elseif ($row[0]==$this->cuenta_anterior)
        {
        	
       
			$this->Cell(56,5,'',0,0,'C');
			//auxiliar
		    $this->Cell(60,5,$row[6].'    '.$row[7],'L',0,'L',$fill);
		    //unidad organizacioal
		    $this->Cell(60,5,$row[5],0,0,'L',$fill);
		     //saldo
		    $this->Cell(30,5,number_format($row[4],2,'.',','),'R',0,'R',$fill);
    	  	$this->cuenta_anterior=$row[0]; 
    	$this->ln();
      	$this->total_valorado+=$row[4];
       //echo "total ".$total_count."contador =".$contador; 
        	if($contador==$total_count-1)
	    	{
	    		$this->SetFont('Arial','B',6);
	    		$this->Cell(56,4,"",0,0,'R',0);
	    		$this->Cell(60,4,"",'T',0,'R',0);
	    		$this->Cell(30,4,"",'T',0,'R',0);
	    		$this->Cell(30,4,"Total Cuenta:",'RTB',0,'R',0);
	    		
	    		$this->Cell(30,4,number_format($this->total_valorado,2,'.',','),1,0,'R',0); 
			
				$this->SetFont('Arial','B',8);
	    
	       		$this->ln();
	    		$this->total_valorado_total+=$this->total_valorado;
	       		$this->Cell(116,4,"",0,0,'R',0);
	       		$this->Cell(30,4,"",0,0,'R',0);
	       		$this->Cell(30,4,"Total Unidad Organizacional: ",0,0,'R',0);
	    		$this->Cell(30,4,number_format($this->total_valorado_total,2,'.',','),'LTRB',0,'R',0);
	    		
	    		
	//    		$total_consumo=$row[5];
	//	 		$total_valorado=$row[6];
	    	} 
	    	//$contador--;
        }    		
    	
    	else {$this->cont++;
    		$this->SetFont('Arial','B',6);
    		$this->Cell(56,4,"",0,0,'R',0);
	    	$this->Cell(60,4,"",'T',0,'R',0);
	    	$this->Cell(30,4,"",'T',0,'R',0);
    		$this->Cell(30,4,"Total Cuenta:",1,0,'R',0);
    		$this->Cell(30,4,number_format($this->total_valorado,2,'.',','),1,0,'R',0); 
     		
			$this->total_valorado_total+=$this->total_valorado;
    		$this->ln();
    		//--
    		//nro
			$this->ln(); 
    		$this->Cell(6,5,$this->cont,1,0,'R',$fill);
		       //cuenta
		    $this->Cell(50,5,$row[1].'    '.$row[2],'1',0,'L',$fill);
		    //$this->ln(); 
			//auxiliar
		    $this->Cell(60,5,$row[6].'   '.$row[7],'T',0,'L',$fill);
		    //unidad organizacional
		    $this->Cell(60,5,$row[5],'T',0,'L',$fill);
		    //saldo
		    $this->Cell(30,5,number_format($row[4],2,'.',','),'TR',0,'R',$fill);
	            
	    
	       	$this->ln();
    		//--
    	   /*/$this->Cell(56,5,'',0,0,'C');
			//auxiliar
		    $this->Cell(60,5,$row[6].'    '.$row[7],'L',0,'L',$fill);
		    //unidad organizacioal
		    $this->Cell(60,5,$row[3],0,0,'L',$fill);
		    //saldo
		    $this->Cell(30,5,number_format($row[4],2,'.',','),'R',0,'R',$fill);
    		//--
	    	
	    	$this->ln();*/
	    	$this->cuenta_anterior=$row[0];
	    		    	
		 	$this->total_valorado=$row[4];
    	//$contador++;
    	}
	 	$contador++;
      	$van++;
      	$fill=!$fill;
      	//echo "total".$this->total_valorado_total;
     
	}

	 }
}

//Creación del objeto de la clase heredada
$pdf=new PDF('P','mm','Letter');

$pdf->AliasNbPages();

$pdf->AddPage('P');
$pdf->SetFont('Times','',12);
$pdf->SetAutoPageBreak(true,25);
$pdf->maestro();
//$pdf->FancyTable($header,$data);



$pdf->Output();
?>



?>
