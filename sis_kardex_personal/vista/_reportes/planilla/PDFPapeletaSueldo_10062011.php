<?php
session_start();
/**Autor: Ana Marï¿½a Villegas Quispe
 * Fecha Mod: 20/10/2010
 * Desc:   Reporte de solicitud de fondos se inserto 3 hojas en uno 
 
 */

require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
     $this-> AddFont('Arial','','arial.php');
    //Iniciaciï¿½n de variables
    }
 function SetPrograma($nombre_programa)
{
    $this->nombre_programa=$nombre_programa;
}   
 //Cabecera
function Header()
{
	

}
//Pie de pï¿½gina
function Footer()
{
 $fecha=date("d-m-Y");
	$hora=date("h:i:s");
	    $this->SetY(-10);
   	    $this->SetFont('Arial','',6);
   	    //$this->Cell(200,0.2,'',1,1);
		/*$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - KARDEX',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	*/
   }

}

$pdf=new PDF();



$detalle=$_SESSION['PDF_lista_papeleta_sueldo'];

$tam_det=count($detalle)/14;


$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,10);
$pdf->SetMargins(5,5,5);
$pdf->SetFont('Arial','B',10);
$indice=0;


for($j=0;$j<$tam_det;$j++){
	
$pdf->AddPage();
	
	$cabecera=$_SESSION["PDF_cab_rep_planilla"];	
	
	$inicio_boleta=$pdf->GetY();
	
	for ($i=$indice;$i<($indice+14);$i++){
		
		
		$codigo_empleado=$detalle[$i]['codigo_empleado'];
		$nombre_empleado=$detalle[$i]['nombre_completo'];
		$nombre_cargo=$detalle[$i]['nombre_cargo'];
		$nivel=$detalle[$i]['nivel'];
		$saldo_rc_iva=$detalle[$i]['saldo_rc_iva'];
		switch ($detalle[$i]['codigo']){
			case 'HORNORM':  $hornorm=$detalle[$i]['valor'];
			   break;
			case 'SUELMES':  $suelmes=$detalle[$i]['valor'];
			   break;
			 case 'BONANT':  $bonant=$detalle[$i]['valor'];
			   break;
			case 'AFP_SSO':  $afp_sso=$detalle[$i]['valor'];
			   break;
			case 'AFP_RCOM':  $afp_recom=$detalle[$i]['valor'];
			   break;
			case 'AFP_CADM':  $afp_cadm=$detalle[$i]['valor'];
			   break;
			case 'AFCOOP':  $afcoop=$detalle[$i]['valor'];
			   break;
			case 'APCOOP':  $apcoop=$detalle[$i]['valor'];
			   break;
			case 'TOTDESC':  $totdesc=$detalle[$i]['valor'];
			   break;
			case 'DESCVAR':  $descvar=$detalle[$i]['valor'];
			   break; 
			case 'RC-IVA':  $rc_iva=$detalle[$i]['valor'];
			   break;
			   
			case 'APLAB_SOL':  $aplab_sol=$detalle[$i]['valor'];
			   break;
			
			case 'APNAL_SOL':  $apnal_sol=$detalle[$i]['valor'];
			   break;
			   
			case 'LIQPAG':  $liqpag=$detalle[$i]['valor'];
							$liq_pag_literal=$detalle[$i]['liq_pag_literal'];
			   break;
		}
	}
	$indice=$indice+14;
	
	

$pdf->SetFont('Arial','B',14);
$y=$inicio_boleta;

	//$pdf->SetXY(172,$pdf->GetY());
	
	$pdf->Cell(40,11,'','',1);
	//$pdf->Image('../../../../lib/images/logo_reporte.jpg',15,4,25,10);
	//$pdf->Image('../../../../lib/images/fondo_ende.jpg',20,20,150,67);
	$pdf->SetXY(45,$y);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(127,22,' PAPELETA DE SUELDO:'.$cabecera[0]['periodo'].'-'.$cabecera[0]['gestion'],'',1,'C');
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY(145,$y+7);
	$x=$pdf->GetX();
	
					
	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY(167,$y);
	$pdf->Cell(45,4,'No Patronal:511-2067','',1,'C'); 
	$pdf->SetX(170);
	$pdf->Cell(42,6,'N.I.T. 102370','',1,'C'); 
	$pdf->Cell(207,12,'','',1,'C');
	
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(13,6,'Código','RT',0,'C');
	$pdf->Cell(82,6,'Nombres y Apellidos','RT',0,'C');
	$pdf->Cell(98,6,'Cargo','RT',0,'C');
	$pdf->Cell(10,6,'Niv','T',0,'C');
	$pdf->Cell(2,6,'','',1,'C');
	//datos
	
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(13,6,$codigo_empleado,'RB',0,'C');
	$pdf->Cell(82,6,$nombre_empleado,'RB',0,'C');
	$pdf->Cell(98,6,$nombre_cargo,'RB',0,'C');
	$pdf->Cell(10,6,$nivel,'B',0,'C');
	$pdf->Cell(2,6,'','',1,'C');
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'SUELDO BÁSICO:','',0,'L');
	$pdf->Cell(20,6,number_format($suelmes,2),'',0,'R');
	$pdf->Cell(5,6,'','R',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(50,6,'AFP CUENTA INDIVIDUAL','',0,'L');
	$pdf->Cell(15,6,'10%:','',0,'R');
	$pdf->Cell(25,6,'','',0,'R');
	$pdf->Cell(10,6,number_format($afp_sso,2),'',0,'R');
	$pdf->Cell(5,6,'','',1,'C');
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'','',0,'L');
	$pdf->Cell(20,6,'','',0,'R');
	$pdf->Cell(5,6,'','R',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(50,6,'AFP SEGURO RIESGO COMUN','',0,'L');
	$pdf->Cell(15,6,'1.71%:','',0,'R');
	$pdf->Cell(25,6,'','',0,'R');
	$pdf->Cell(10,6,number_format($afp_recom,2),'',0,'R');
	$pdf->Cell(5,6,'','',1,'C');
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'BONO DE ANTIGUEDAD:','',0,'L');
	$pdf->Cell(20,6,number_format($bonant,2),'',0,'R');
	$pdf->Cell(5,6,'','R',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(50,6,'AFP COM ADM.','',0,'L');
	$pdf->Cell(15,6,'0.50%:','',0,'R');
	$pdf->Cell(25,6,'','',0,'R');
	$pdf->Cell(10,6,number_format($afp_cadm,2),'',0,'R');
	$pdf->Cell(5,6,'','',1,'C');
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'','',0,'L');
	$pdf->Cell(20,6,'','',0,'R');
	$pdf->Cell(5,6,'','R',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(90,6,'TOTAL DESCUENTOS DE LEY','',0,'L');
	$pdf->Cell(10,6,number_format($afp_sso+$afp_recom+$afp_cadm,2),'T',0,'R');
	$pdf->Cell(5,6,'','',1,'C');
	
	
	$pdf->Cell(2,10,'','',0);
	$pdf->Cell(70,10,'','',0,'L');
	$pdf->Cell(20,10,'','',0,'R');
	$pdf->Cell(5,10,'','R',0);
	$pdf->Cell(5,10,'','',0);
	$pdf->Cell(90,10,'','',0,'L');
	$pdf->Cell(10,10,'','',0,'C');
	$pdf->Cell(5,10,'','',1,'C');
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'','',0,'L');
	$pdf->Cell(20,6,'','',0,'R');
	$pdf->Cell(5,6,'','R',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(90,6,'APORTE CACSEL','',0,'L');
	$pdf->Cell(10,6,number_format($afcoop,2),'',0,'R');
	$pdf->Cell(5,6,'','',1,'C');
	
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'','',0,'L');
	$pdf->Cell(20,6,'','',0,'R');
	$pdf->Cell(5,6,'','R',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(50,6,'CACSEL',0,'L');
	$pdf->Cell(10,6,'4%:','',0,'R');
	$pdf->Cell(30,6,'','',0,'R');
	$pdf->Cell(10,6,number_format($apcoop,2),'',0,'R');
	$pdf->Cell(5,6,'','',1,'C');
	
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'','B',0,'L');
	$pdf->Cell(20,6,'','B',0,'R');
	$pdf->Cell(5,6,'','RB',0);
	$pdf->Cell(5,6,'','LB',0);
	$pdf->Cell(90,6,'DESCUENTOS VARIOS','B',0,'L');
	$pdf->Cell(10,6,number_format($descvar,2),'B',0,'R');
	$pdf->Cell(5,6,'','',1,'C');
	
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'TOTAL INGRESOS(Bs):','',0,'L');
	$pdf->Cell(20,6,number_format($suelmes+$bonant,2),'',0,'R');
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(90,6,'TOTAL DESCUENTOS(Bs)','B',0,'L');
	//$pdf->Cell(10,4,number_format($afcoop+$apcoop+$descvar,2)+number_format($afp_sso+$afp_recom+$afp_cadm,2),'B',0,'R');
	$pdf->Cell(10,6,number_format($totdesc,2),'B',0,'R');
	$pdf->Cell(5,6,'','',1,'C');
	
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'','',0,'L');
	$pdf->Cell(20,6,'','',0,'R');
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->SetFont('Arial','BI',8);
	$pdf->Cell(90,6,'LIQUIDO PAGABLE(Bs)','LTB',0,'L');
	$pdf->Cell(10,6,number_format($liqpag,2),'TBR',0,'R');
	$pdf->SetFont('Arial','',10);
	
	$pdf->Cell(5,6,'','',1,'C');
	
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'','',0,'L');
	$pdf->Cell(20,6,'','',0,'R');
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(100,6,'LIQUIDO PAGABLE: '.$liq_pag_literal.' Bs','',0,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(5,6,'','',1,'C');
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'RETENCION RC-IVA','',0,'L');
	$pdf->Cell(20,6,''.number_format($rc_iva,2),'',0,'R');
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(100,6,'','',0,'L');
	$pdf->Cell(5,6,'','',1,'C');
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'HORAS TRABAJADAS','',0,'L');
	$pdf->Cell(20,6,$hornorm,'',0,'R');
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(100,6,'','',0,'L');
	$pdf->Cell(5,6,'','',1,'C');
	

	

	//*********************************************************************************
	/*+++++++++++++++++++++++++++++++++++++*/
	$y=$pdf->GetY()+20;
	$pdf->SetXY(5,$pdf->GetY()+30);
	
	$pdf->Cell(40,11,'','',1);
	//$pdf->Image('../../../../lib/images/logo_reporte.jpg',15,4,25,10);
	//$pdf->Image('../../../../lib/images/fondo_ende.jpg',20,20,150,67);
	$pdf->SetXY(45,$y);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(127,22,' PAPELETA DE SUELDO:'.$cabecera[0]['periodo'].'-'.$cabecera[0]['gestion'],'',1,'C');
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY(145,$y+7);
	$x=$pdf->GetX();
	
					
	$pdf->SetFont('Arial','B',10);
	$pdf->SetXY(167,$y);
	$pdf->Cell(45,4,'No Patronal:511-2067','',1,'C'); 
	$pdf->SetX(170);
	$pdf->Cell(42,6,'N.I.T. 102370','',1,'C'); 
	$pdf->Cell(207,12,'','',1,'C');
	
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(13,6,'Código','RT',0,'C');
	$pdf->Cell(82,6,'Nombres y Apellidos','RT',0,'C');
	$pdf->Cell(98,6,'Cargo','RT',0,'C');
	$pdf->Cell(10,6,'Niv','T',0,'C');
	$pdf->Cell(2,6,'','',1,'C');
	//datos
	
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(13,6,$codigo_empleado,'RB',0,'C');
	$pdf->Cell(82,6,$nombre_empleado,'RB',0,'C');
	$pdf->Cell(98,6,$nombre_cargo,'RB',0,'C');
	$pdf->Cell(10,6,$nivel,'B',0,'C');
	$pdf->Cell(2,6,'','',1,'C');
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'SUELDO BÁSICO:','',0,'L');
	$pdf->Cell(20,6,number_format($suelmes,2),'',0,'R');
	$pdf->Cell(5,6,'','R',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(50,6,'AFP CUENTA INDIVIDUAL','',0,'L');
	$pdf->Cell(15,6,'10%:','',0,'R');
	$pdf->Cell(25,6,'','',0,'R');
	$pdf->Cell(10,6,number_format($afp_sso,2),'',0,'R');
	$pdf->Cell(5,6,'','',1,'C');
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'','',0,'L');
	$pdf->Cell(20,6,'','',0,'R');
	$pdf->Cell(5,6,'','R',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(50,6,'AFP SEGURO RIESGO COMUN','',0,'L');
	$pdf->Cell(15,6,'1.71%:','',0,'R');
	$pdf->Cell(25,6,'','',0,'R');
	$pdf->Cell(10,6,number_format($afp_recom,2),'',0,'R');
	$pdf->Cell(5,6,'','',1,'C');
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'BONO DE ANTIGUEDAD:','',0,'L');
	$pdf->Cell(20,6,number_format($bonant,2),'',0,'R');
	$pdf->Cell(5,6,'','R',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(50,6,'AFP COM ADM.','',0,'L');
	$pdf->Cell(15,6,'0.50%:','',0,'R');
	$pdf->Cell(25,6,'','',0,'R');
	$pdf->Cell(10,6,number_format($afp_cadm,2),'',0,'R');
	$pdf->Cell(5,6,'','',1,'C');
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'','',0,'L');
	$pdf->Cell(20,6,'','',0,'R');
	$pdf->Cell(5,6,'','R',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(90,6,'TOTAL DESCUENTOS DE LEY','',0,'L');
	$pdf->Cell(10,6,number_format($afp_sso+$afp_recom+$afp_cadm,2),'T',0,'R');
	$pdf->Cell(5,6,'','',1,'C');
	
	
	$pdf->Cell(2,10,'','',0);
	$pdf->Cell(70,10,'','',0,'L');
	$pdf->Cell(20,10,'','',0,'R');
	$pdf->Cell(5,10,'','R',0);
	$pdf->Cell(5,10,'','',0);
	$pdf->Cell(90,10,'','',0,'L');
	$pdf->Cell(10,10,'','',0,'C');
	$pdf->Cell(5,10,'','',1,'C');
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'','',0,'L');
	$pdf->Cell(20,6,'','',0,'R');
	$pdf->Cell(5,6,'','R',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(90,6,'APORTE CACSEL','',0,'L');
	$pdf->Cell(10,6,number_format($afcoop,2),'',0,'R');
	$pdf->Cell(5,6,'','',1,'C');
	
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'','',0,'L');
	$pdf->Cell(20,6,'','',0,'R');
	$pdf->Cell(5,6,'','R',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(50,6,'CACSEL',0,'L');
	$pdf->Cell(10,6,'4%:','',0,'R');
	$pdf->Cell(30,6,'','',0,'R');
	$pdf->Cell(10,6,number_format($apcoop,2),'',0,'R');
	$pdf->Cell(5,6,'','',1,'C');
	
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'','B',0,'L');
	$pdf->Cell(20,6,'','B',0,'R');
	$pdf->Cell(5,6,'','RB',0);
	$pdf->Cell(5,6,'','LB',0);
	$pdf->Cell(90,6,'DESCUENTOS VARIOS','B',0,'L');
	$pdf->Cell(10,6,number_format($descvar,2),'B',0,'R');
	$pdf->Cell(5,6,'','',1,'C');
	
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'TOTAL INGRESOS(Bs):','',0,'L');
	$pdf->Cell(20,6,number_format($suelmes+$bonant,2),'',0,'R');
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(90,6,'TOTAL DESCUENTOS(Bs)','B',0,'L');
	//$pdf->Cell(10,4,number_format($afcoop+$apcoop+$descvar,2)+number_format($afp_sso+$afp_recom+$afp_cadm,2),'B',0,'R');
	$pdf->Cell(10,6,number_format($totdesc,2),'B',0,'R');
	$pdf->Cell(5,6,'','',1,'C');
	
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'','',0,'L');
	$pdf->Cell(20,6,'','',0,'R');
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->SetFont('Arial','BI',8);
	$pdf->Cell(90,6,'LIQUIDO PAGABLE(Bs)','LTB',0,'L');
	$pdf->Cell(10,6,number_format($liqpag,2),'TBR',0,'R');
	$pdf->SetFont('Arial','',10);
	
	$pdf->Cell(5,6,'','',1,'C');
	
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'','',0,'L');
	$pdf->Cell(20,6,'','',0,'R');
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(100,6,'LIQUIDO PAGABLE: '.$liq_pag_literal.' Bs','',0,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(5,6,'','',1,'C');
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'RETENCION RC-IVA','',0,'L');
	$pdf->Cell(20,6,''.number_format($rc_iva,2),'',0,'R');
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(100,6,'','',0,'L');
	$pdf->Cell(5,6,'','',1,'C');
	
	$pdf->Cell(2,6,'','',0);
	$pdf->Cell(70,6,'HORAS TRABAJADAS','',0,'L');
	$pdf->Cell(20,6,$hornorm,'',0,'R');
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(5,6,'','',0);
	$pdf->Cell(100,6,'','',0,'L');
	$pdf->Cell(5,6,'','',1,'C');
	
	$pdf->Cell(100,6,'',0,0,'C');
	$pdf->Cell(0,6,'______________________________',0,1,'C');
	$pdf->Cell(100,6,'',0,0,'C');
	$pdf->Cell(0,6,'RECIBI CONFORME',0,1,'C');
	
//$pdf->Ln(30);	
//$pdf->Cell(15,10,'fffff',1,1);
	//}

/*if($j+1<$cant_adj){
 $pdf->AddPage();
}*/
//}
}
$pdf->Output();


?>