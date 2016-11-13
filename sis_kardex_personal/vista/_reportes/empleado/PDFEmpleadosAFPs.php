<?php
session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 13/06/2011
 * Descripción: Reporte de Empleados AFP's
 *
 *
 ***/
require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
 
class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    $this-> AddFont('Arial','','arial.php');
 
    //Iniciación de variables
    }

function SetNombreAFP($nombre_afp)
{
    $this->nombre_afp =$nombre_afp;
}
/*function SetTipoContrato($tipo_contrato)
{
    $this->tipoContrato =$tipo_contrato;
*/

function Header()
{       
   $this->Image('../../../../lib/images/logo_reporte.jpg',180,0,30,10);
   $cabecera=$_SESSION['PDF_cab_rep_planilla'];
   $this->SetFont('Arial','B',7);
	$this->Cell(30,3,'No. Patronal:511-2067',0,1);
	$this->Cell(30,3,'N.I.T.: 1023187029',0,1);
   $this->SetFont('Arial','BU',12);
   $this->Cell(0,5,'DETALLE ADICIONAL: FORMULARIO DE PAGO DE CONTRIBUYENTES ' ,0,1,'C');
    $this->Cell(0,5,''.$this->nombre_afp ,0,1,'C');
   $this->Cell(0,5,'Contribuciones al Sistema Integral de Pensiones' ,0,1,'C');
   $this->Cell(0,5,'PERIODO A COTIZAR: AÑO '.$cabecera[0]['gestion'].' MES '.$cabecera[0]['periodo'] ,0,1,'C');
    $this->SetFont('Arial','B',8);
   

   $this->Cell(15,3.5,'Doc. Identi',1,0,'C');
   $this->Cell(10,3.5,'Tipo',1,0,'C');
   $this->Cell(15,3.5,'N.U.A.',1,0,'C');
   $this->Cell(60,3.5,'Nombres',1,0,'C');
   $this->Cell(20,3.5,'DiasCot',1,0,'C');
   $this->Cell(20,3.5,'Nov',1,0,'C');
   $this->Cell(20,3.5,'Fech. Nov.',1,0,'C');
   $this->Cell(20,3.5,'Cotizable',1,1,'C');
    
}
 
//Pie de página
function Footer()
{
    
	  $this->SetY(-7);
   	$this->pieHash('KARDEX');
	
	/*//Posición: a 1,5 cm del final
    $fecha=date("d-m-Y");
	$hora=date("H:i:s");
	  $this->SetY(-7);
	  $this->SetFont('Arial','',6);
		//$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(70,3,'Fecha: '.$fecha,0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		
		$this->ln(3);
		//$this->Cell(70,3,'Sistema: ENDESIS - KARDEX',0,0,'L');
		//$this->Cell(50,3,'',0,0,'C');
		//$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
		$this->ln(3);
	*/
	
	  
   	  
}

}
  	$pdf=new PDF();	
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(10,5,5);  
    
    $pdf->SetFont('Arial','',6);
	
    

 
 	//$cabecera=$_SESSION['PDF_cab_rep_planilla'];
 	$detalle=$_SESSION["PDF_empleados_afps_detalle"];
	$vafps=$_SESSION["PDF_detalle_afp1"];
	
 	$pdf->SetWidths(array(15,10,15,60,20,20,20,20,20,20));
	$pdf->SetFills(array(0,0,0,0,0,0,0,0));
 	$pdf->SetAligns(array('L','L','L','L','R','R','R','R'));
 	$pdf->SetVisibles(array(1,1,1,1,1,1,1,1));
  	$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6));
 	$pdf->SetFontsStyles(array('','',''));
 	$pdf->SetSpaces(array(4,4,4,4,4,4,4,4));
 	$pdf->setDecimales(array(0,0,0,0,0,0,0,2));
    $pdf->SetFormatNumber(array(0,0,0,0,1,0,0,1));
 	$nombre_afp='';
 	$id_afp=0;
 	
 	
 	for ($i=0;$i<count($detalle);$i++){
 	 	if($detalle[$i]["nombre_afp"]<>$nombre_afp)
 	 			{      if ($i !=0){
 	 			   //	echo ($detalle[$i-1]['id_afp']."--");
 	 			    $v_afps=busAFP($vafps,$detalle[$i-1]['id_afp']);
 	 			   	 /*$sum_tot_ap_lab=$v_afps[0][0]+	$v_afps[0][1]+ $v_afps[0][2]+$v_afps[0][3];
 	                 $sum_tot_ap_pat=$v_afps[0][4]+	$v_afps[0][5]+ $v_afps[0][6];
 	                   $sum_total=$sum_tot_ap_lab+$sum_tot_ap_pat;
 	                */   $pdf->SetFont('Arial','',6);

$pdf->Cell(160,4,'TOTALES :',0,0,'R'); 	 		
$pdf->Cell(20,4,''.number_format($sum_devengado,2),0,1,'R'); 	
$pdf->SetFont('Arial','B',6);
$pdf->Cell(100,4,'RESUMEN :',0,1); 	 		
$pdf->SetFont('Arial','',6);
$pdf->Cell(100,4,'Número de Afiliados:',0,0); 	
$pdf->Cell(10,4,'',0,0,'R');  		
$pdf->Cell(50,4,''.number_format($num_afiliados,2),0,1,'R'); 	 	

$pdf->Cell(100,4,'Salarios Devengados:',0,0);
$pdf->Cell(10,4,'',0,0,'R');  		 	 		
$pdf->Cell(50,4,''.number_format($sum_devengado,2),0,1,'R'); 	 	

$pdf->Cell(100,4,'(-) Salario Por Tramite de Jubilación (A)',0,0); 	
$pdf->Cell(10,4,'',0,0,'R');  		
$pdf->Cell(50,4,number_format($sum_salario_tram_jub+$sum_jubilado_may65,2),0,1,'R'); 


$pdf->SetFont('Arial','',6);
$pdf->Cell(100,4,'TOTAL SALARIO DEVENGADO (A):',0,0); 
$pdf->Cell(10,4,'',0,0,'R'); 
$total_salario_devengado=$sum_devengado-$sum_salario_tram_jub-$sum_jubilado_may65;		
$pdf->Cell(50,4,''.number_format($total_salario_devengado,2),0,1,'R'); 
	 	

$pdf->Cell(100,4,'(-) Salario Trabajadores Activos > 65 años (B)',0,0); 	
$pdf->Cell(10,4,'',0,0,'R');  		
$pdf->Cell(50,4,number_format($sum_devengado_may65-$sum_jubilado_may65,2),0,1,'R'); 


$pdf->SetFont('Arial','',6);
$pdf->Cell(100,4,'TOTAL SALARIO DEVENGADO (B):',0,0); 
$pdf->Cell(10,4,'',0,0,'R'); 
$total_salario_devengadob=$sum_devengado-$sum_devengado_may65;
$pdf->Cell(50,4,''.number_format($total_salario_devengadob,2),0,1,'R'); 


//$total_salario_cotizable=$v_afps[0][0]/0.1;

//25/10/2011
/*$pdf->SetFont('Arial','',6);
$pdf->Cell(100,4,'Incapacidad Temporal:',0,0); 
$pdf->Cell(10,4,'',0,0,'R');  		
$pdf->Cell(50,4,''.number_format($v_afps[0][8],2),0,1,'R'); 	 	
*/
$pdf->SetFont('Arial','B',6);
$pdf->Cell(100,4,'TOTAL SALARIO COTIZABLE:',0,0); 
$pdf->Cell(10,4,'',0,0,'R');  		
$v_importe=($v_afps[0][7]+$v_afps[0][8]);
//$v_importe=($v_afps[0][7]);
$pdf->Cell(50,4,''.number_format($v_importe,2),0,1,'R'); 
//$sum_tot_ap_lab=($total_salario_devengado * 0.1)+($total_salario_devengadob * 0.0171) +($v_importe * 0.005) + ( $v_importe * 0.005); agosto2015
//$sum_tot_ap_lab=($v_importe * 0.1)+($v_importe * 0.0171) +($v_importe * 0.005) + ( $v_importe * 0.005);
$pdf->Cell(100,4,'APORTE LABORAL:',0,0); 	 
$pdf->Cell(10,4,'',0,0,'R');  		
$pdf->Cell(50,4,'',0,1,'R'); 	 	
$pdf->SetFont('Arial','',6);
$pdf->Cell(100,4,'Total Aporte Cuenta Individual',0,0); 	 					 		 		
$pdf->Cell(10,4,'10.00 %',0,0,'R');  		
//$pdf->Cell(50,4,''.number_format($v_afps[0][0],2),0,1,'R'); 	
$a_cuenta1=	$total_salario_devengado * 0.1; 	
$pdf->Cell(50,4,''.number_format($a_cuenta1,2),0,1,'R'); 	 	

$pdf->Cell(100,4,'Total Seguro de Riesgo Comun',0,0); 	 		
$pdf->Cell(10,4,'1.71 %',0,0,'R');  		
//$pdf->Cell(50,4,''. number_format($v_afps[0][1],2),0,1,'R'); 	
$a_cuenta2=	$total_salario_devengadob * 0.0171; 	
$pdf->Cell(50,4,''. number_format($a_cuenta2,2),0,1,'R'); 	 	

$pdf->Cell(100,4,'Total Comisión Administradora '.$nombre_afp,0,0); 	 		
$pdf->Cell(10,4,'0.50 %',0,0,'R');  		
//$pdf->Cell(50,4,''. number_format($v_afps[0][2],2),0,1,'R'); 	
$a_cuenta3=$v_importe * 0.005; 	
$pdf->Cell(50,4,''. number_format($a_cuenta3,2),0,1,'R'); 	 	

$pdf->Cell(100,4,'Total Aporte Solidario:',0,0); 	 		
$pdf->Cell(10,4,'0.50 %','B',0,'R');  		
$pdf->Cell(50,4,''.number_format( $a_cuenta3,2),'B',1,'R'); 	 	
$pdf->SetFont('Arial','B',6);
$pdf->Cell(100,4,'TOTAL APORTE LABORAL:',0,0); 	 		
$pdf->Cell(10,4,'',0,0,'R');  		
$sum_tot_ap_lab=$a_cuenta1+$a_cuenta2+(2*$a_cuenta3);
$pdf->Cell(50,4,''.number_format($sum_tot_ap_lab,2),0,1,'R'); 	 	
//$sum_tot_ap_pat=($total_salario_devengadob * 0.0171)+ ($v_importe * 0.02) + ($v_importe * 0.03); //agosto2015
//$sum_total= $sum_tot_ap_lab + $sum_tot_ap_pat;
$pdf->Cell(100,4,'APORTE PATRONAL:',0,0); 	 		
$pdf->Cell(10,4,'',0,0,'R');  		
$pdf->Cell(50,4,'',0,1,'R'); 	 	
$pdf->SetFont('Arial','',6);
$pdf->Cell(100,4,'Total Seguro Riesgo Profesional:',0,0); 	 		
$pdf->Cell(10,4,'1.71 %',0,0,'R');  		
$a_cuenta4=$total_salario_devengadob* 0.0171;
$pdf->Cell(50,4,''.number_format( $a_cuenta4,2),0,1,'R'); 	 	

$pdf->Cell(100,4,'Total Aporte Patronal y Vivienda:',0,0); 	 		
$pdf->Cell(10,4,'2.00 %',0,0,'R');  	
$a_cuenta5=	$v_importe * 0.02;	
$pdf->Cell(50,4,''.number_format( $a_cuenta5,2),0,1,'R'); 	 	

$pdf->Cell(100,4,'Total Aporte Solidario:',0,0); 	 		
$pdf->Cell(10,4,'3.00%','B',0,'R');  		
$a_cuenta6=$v_importe * 0.03;
$pdf->Cell(50,4,''.number_format( $a_cuenta6,2),'B',1,'R'); 		 	
$pdf->SetFont('Arial','B',6);
$pdf->Cell(100,4,'TOTAL APORTE PATRONAL:',0,0);
$pdf->Cell(10,4,'','B',0,'R');  		
$sum_tot_ap_pat=$a_cuenta4+$a_cuenta5+$a_cuenta6;
$pdf->Cell(50,4,''.number_format($sum_tot_ap_pat,2),'B',1,'R'); 	 	

$pdf->Cell(100,4,'TOTAL APORTE LABORAL Y PATRONAL SIP:',0,0); 	 		 	 		
$pdf->Cell(10,4,'',0,0,'R');  	
$sum_total= $sum_tot_ap_lab + $sum_tot_ap_pat;	
$pdf->Cell(50,4,''.number_format($sum_total,2),0,1,'R'); 	 		
 	 	
 	 		
 	 	 
 	 			   	
 	 			   }
 	 				
 	 				 $pdf->SetNombreAFP($detalle[$i]["nombre_afp"]);
 	 				  $pdf->AddPage();
 	 			     $nombre_afp=$detalle[$i]["nombre_afp"];
 	 			     $num_afiliados=0;
 	 			     $sum_devengado=0;
 	 			     $sum_salario_tram_jub=0;
 	 			     $sum_devengado_may65=0;
 	 			     $sum_jubilado_may65=0;
 	 			
 	 			
 	 			}
 	 			
 	 			if (strlen($detalle[$i]["a"])>0){
 	 				$detalle[$i][5]='I';
 	 				$detalle[$i][6]=	$detalle[$i]["a"];
 	 			}
 	 			if ($detalle[$i]['b']!=''){
 	 				$detalle[$i][5]='R';
 	 				$detalle[$i][6]=$detalle[$i]['b'];
 	 			}
 	 			
 	 			$pdf->SetLineWidth(0.05);
 	 			$num_afiliados=$num_afiliados+1;
				if($detalle[$i]['sw_jub55']=='si'){
				$sum_salario_tram_jub=$sum_salario_tram_jub+$detalle[$i]['valor'];
				}
				if($detalle[$i]['may65']=='si'){
				$sum_devengado_may65=$sum_devengado_may65+$detalle[$i]['valor'];
				}
				if($detalle[$i]['jub65']=='si'){
					$sum_jubilado_may65=$sum_jubilado_may65+$detalle[$i]['valor'];
				}
				
				
 	 			$sum_devengado=$sum_devengado+$detalle[$i]['valor'];
 	 			$pdf->MultiTabla($detalle[$i],0,3,4,6,1);
 	 			$pdf->SetLineWidth(0.1);
 	 			$id_afp_det=$detalle[$i]['id_afp'];
 	 			                  
 	 		}

$pdf->SetFont('Arial','',6);

 	 	$vafps=$_SESSION["PDF_detalle_afp1"];	
 	/*	print_r($vafps);
 	 	exit;*/
 	 			   	  $v_afps=busAFP($vafps,$id_afp_det);
 	 			/*   	  print_r($v_afps);
 	 	exit;*/
 	 			   	/* $sum_tot_ap_lab=$v_afps[0][0]+	$v_afps[0][1]+ $v_afps[0][2]+$v_afps[0][3];
 	                 $sum_tot_ap_pat=$v_afps[0][4]+	$v_afps[0][5]+ $v_afps[0][6];
 	                   $sum_total=$sum_tot_ap_lab+$sum_tot_ap_pat;
	                */ 
 $pdf->Cell(160,4,'TOTALES :',0,0,'R'); 	 		
$pdf->Cell(20,4,''.number_format($sum_devengado,2),0,1,'R'); 	
$pdf->SetFont('Arial','B',6);
$pdf->Cell(100,4,'RESUMEN :',0,1); 	 		
$pdf->SetFont('Arial','',6);
$pdf->Cell(100,4,'Número de Afiliados:',0,0); 	
$pdf->Cell(10,4,'',0,0,'R');  		
$pdf->Cell(50,4,''.number_format($num_afiliados,2),0,1,'R'); 	 	

$pdf->Cell(100,4,'Salarios Devengados:',0,0);
$pdf->Cell(10,4,'',0,0,'R');  		 	 		
$pdf->Cell(50,4,''.number_format($sum_devengado,2),0,1,'R'); 	 	

$pdf->Cell(100,4,'(-) Salario Por Tramite de Jubilación (A)',0,0); 	
$pdf->Cell(10,4,'',0,0,'R');  		
$pdf->Cell(50,4,number_format($sum_salario_tram_jub+$sum_jubilado_may65,2),0,1,'R'); 	 	
$pdf->SetFont('Arial','',6);

$pdf->Cell(100,4,'TOTAL SALARIO DEVENGADO (A):',0,0); 
$pdf->Cell(10,4,'',0,0,'R');  
$total_salario_devengado=$sum_devengado-$sum_salario_tram_jub-$sum_jubilado_may65;		
$pdf->Cell(50,4,''.number_format($total_salario_devengado,2),0,1,'R'); 	


$pdf->Cell(100,4,'(-) Salario Trabajadores Activos > 65 años (B)',0,0); 	
$pdf->Cell(10,4,'',0,0,'R');  		
$pdf->Cell(50,4,number_format($sum_devengado_may65-$sum_jubilado_may65,2),0,1,'R'); 	 	
$pdf->SetFont('Arial','',6);



$pdf->Cell(100,4,'TOTAL SALARIO DEVENGADO (B):',0,0); 
$pdf->Cell(10,4,'',0,0,'R');  
$total_salario_devengadob=$sum_devengado-$sum_devengado_may65;		
$pdf->Cell(50,4,''.number_format($total_salario_devengadob,2),0,1,'R'); 	
 	
/*$pdf->SetFont('Arial','',6);
$pdf->Cell(100,4,'Incapacidad Temporal:',0,0); 
$pdf->Cell(10,4,'',0,0,'R');  		
$pdf->Cell(50,4,''.number_format($v_afps[0][8],2),0,1,'R'); 	 	
*/
//$total_salario_cotizable=$v_afps[0][0]/0.1;

$pdf->SetFont('Arial','B',6);
$pdf->Cell(100,4,'TOTAL SALARIO COTIZABLE:',0,0); 
$pdf->Cell(10,4,'',0,0,'R');  		
//$pdf->Cell(50,4,''.number_format($total_salario_cotizable,2),0,1,'R'); 
$v_importe=($v_afps[0][7]+$v_afps[0][8]);
//$v_importe=($v_afps[0][7]);
//$pdf->Cell(50,4,''.number_format($total_salario_cotizable,2),0,1,'R'); 
$pdf->Cell(50,4,''.number_format($v_importe,2),0,1,'R'); 

//$sum_tot_ap_lab=($v_importe * 0.1)+($v_importe * 0.0171) +($v_importe * 0.005) +( $v_importe * 0.005);
//$sum_tot_ap_lab=($total_salario_devengado * 0.1)+($v_importe * 0.0171) +($v_importe * 0.005) +( $v_importe * 0.005);
//$sum_tot_ap_lab=($total_salario_devengado * 0.1)+($total_salario_devengadob * 0.0171) +($v_importe * 0.005) +( $v_importe * 0.005);//agosto2015
$pdf->Cell(100,4,'APORTE LABORAL:',0,0); 	 
$pdf->Cell(10,4,'',0,0,'R');  		
$pdf->Cell(50,4,'',0,1,'R'); 	 	
$pdf->SetFont('Arial','',6);
$pdf->Cell(100,4,'Total Aporte Cuenta Individual',0,0); 	 					 		 		
$pdf->Cell(10,4,'10.00 %',0,0,'R');  		
//$pdf->Cell(50,4,''.number_format($v_afps[0][0],2),0,1,'R'); 	 	
//$pdf->Cell(50,4,''.number_format($v_importe * 0.1,2),0,1,'R'); 
$a_cuenta1=	$total_salario_devengado * 0.1; 	
$pdf->Cell(50,4,''.number_format($a_cuenta1,2),0,1,'R'); 	 	
$pdf->Cell(100,4,'Total Seguro de Riesgo Comun',0,0); 	 		
$pdf->Cell(10,4,'1.71 %',0,0,'R');  		
//$pdf->Cell(50,4,''. number_format($v_afps[0][1],2),0,1,'R'); 	 	
//$pdf->Cell(50,4,''. number_format($v_importe * 0.0171,2),0,1,'R'); 	 
$a_cuenta2=	$total_salario_devengadob * 0.0171;
$pdf->Cell(50,4,''. number_format($a_cuenta2,2),0,1,'R');
$pdf->Cell(100,4,'Total Comisión Administradora '.$nombre_afp,0,0); 	 		
$pdf->Cell(10,4,'0.50 %',0,0,'R');  		
//$pdf->Cell(50,4,''. number_format($v_afps[0][2],2),0,1,'R'); 	 	
$a_cuenta3=$v_importe * 0.005;
$pdf->Cell(50,4,''. number_format($a_cuenta3,2),0,1,'R'); 	 	

$pdf->Cell(100,4,'Total Aporte Solidario:',0,0); 	 		
$pdf->Cell(10,4,'0.50 %','B',0,'R');  		
$pdf->Cell(50,4,''.number_format( $a_cuenta3,2),'B',1,'R'); 	 	
$pdf->SetFont('Arial','B',6);
$pdf->Cell(100,4,'TOTAL APORTE LABORAL:',0,0); 	 		
$pdf->Cell(10,4,'',0,0,'R');  	
$sum_tot_ap_lab=$a_cuenta1+$a_cuenta2+(2*$a_cuenta3);	
$pdf->Cell(50,4,''.number_format($sum_tot_ap_lab,2),0,1,'R'); 	 	
//$sum_tot_ap_pat =($total_salario_devengadob * 0.0171)+ ($v_importe * 0.02) + ($v_importe * 0.03); //agosto2015
//$sum_tot_ap_pat=($v_importe * 0.0171)+ ($v_importe * 0.02) + ($v_importe * 0.03);

$pdf->Cell(100,4,'APORTE PATRONAL:',0,0); 	 		
$pdf->Cell(10,4,'',0,0,'R');  		
$pdf->Cell(50,4,'',0,1,'R'); 	 	
$pdf->SetFont('Arial','',6);
$pdf->Cell(100,4,'Total Seguro Riesgo Profesional:',0,0); 	 		
$pdf->Cell(10,4,'1.71 %',0,0,'R');  		
//$pdf->Cell(50,4,''.number_format( $v_importe * 0.0171,2),0,1,'R');
$a_cuenta4=$total_salario_devengadob * 0.0171;
$pdf->Cell(50,4,''.number_format( $a_cuenta4,2),0,1,'R'); 	 	

$pdf->Cell(100,4,'Total Aporte Patronal y Vivienda:',0,0); 	 		
$pdf->Cell(10,4,'2.00 %',0,0,'R');  
$a_cuenta5=	$v_importe * 0.02;	
$pdf->Cell(50,4,''.number_format($a_cuenta5 ,2),0,1,'R'); 	 	

$pdf->Cell(100,4,'Total Aporte Solidario:',0,0); 	 		
$pdf->Cell(10,4,'3.00%','B',0,'R');  		
$a_cuenta6=$v_importe * 0.03;
$pdf->Cell(50,4,''.number_format( $a_cuenta6,2),'B',1,'R'); 	 	
$pdf->SetFont('Arial','B',6);
$pdf->Cell(100,4,'TOTAL APORTE PATRONAL:',0,0);
$pdf->Cell(10,4,'','B',0,'R');  	
$sum_tot_ap_pat=$a_cuenta4+$a_cuenta5+$a_cuenta6;	
$pdf->Cell(50,4,''.number_format($sum_tot_ap_pat,2),'B',1,'R'); 	 	
$sum_total= $sum_tot_ap_lab + $sum_tot_ap_pat;
$pdf->Cell(100,4,'TOTAL APORTE LABORAL Y PATRONAL SIP:',0,0); 	 		 	 		
$pdf->Cell(10,4,'',0,0,'R');  		
$pdf->Cell(50,4,''.number_format($sum_total,2),0,1,'R'); 	 		
 	
 	function busAFP($vafps,$id_afp){
 	 	    $v_detalle=$vafps;
 	 	for ($k=0;$k<count($v_detalle);$k++){
 	 		if ($id_afp==$v_detalle[$k]['id_afp']){
 	 			switch ($v_detalle[$k]['codigo']){
 	 			   case 'AFP_SSO':
 	 			         
 	 			    $v_detalle_cab[0][0]=$v_detalle[$k]['importe'];
 	 			    break;
 	 			   case 'AFP_RCOM':
 	 			   	$v_detalle_cab[0][1]=$v_detalle[$k]['importe'];
 	 			    break;
 	 			   case 'AFP_CADM':
 	 			   	$v_detalle_cab[0][2]=$v_detalle[$k]['importe'];
 	 			    break;
 	 			    case 'APLAB_SOL':
 	 			   	$v_detalle_cab[0][3]=$v_detalle[$k]['importe'];
 	 			    break;
 	 			    case 'AFP_RIEPRO':
 	 			   	$v_detalle_cab[0][4]=$v_detalle[$k]['importe'];
 	 			    break;
 	 			    case 'AFP_VIVIE':
 	 			   	$v_detalle_cab[0][5]=$v_detalle[$k]['importe'];
 	 			    break;
 	 			    case 'APPAT_SOL':
 	 			   	$v_detalle_cab[0][6]=$v_detalle[$k]['importe'];
 	 			    break;
 	 			    case 'COTIZABLE':
 	 			   	$v_detalle_cab[0][7]=$v_detalle[$k]['importe'];
 	 			    break;
 	 			    case 'INCTEMP':
 	 			   	$v_detalle_cab[0][8]=$v_detalle[$k]['importe'];
 	 			    break;
 	 			}   
 	 			   
 	 			   
 	 			   
 	 		
 	 		}
 	 		
 	 	}
 	 	return $v_detalle_cab;
 	 } 	
 	 
 	 
 	

$pdf->Output();

?>