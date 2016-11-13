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
	    $this->SetY(-3);
   	    $this->SetFont('Arial','',5);
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

$tam_det=count($detalle)/42;



$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,3);
$pdf->SetMargins(5,5,5);
$pdf->SetFont('Arial','B',5);
$indice=0;


//$inicio_boleta=$pdf->GetY();
//$pdf->AddPage();
for($j=0;$j<$tam_det;$j++){
	//if (($j % 2)==0){

	/*} else {
		
		$pdf->Ln(15);
	}*/
	if (($j % 2)==0){
$pdf->AddPage();
	} else {
		
		$pdf->Ln(18);
	}    
	$cabecera=$_SESSION["PDF_cab_rep_planilla"];

	//print_r($detalle);exit;
	for ($i=$indice;$i<($indice+42);$i++){
		
		$inicio_boleta=$pdf->GetY();
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
			case 'PRESTCOOP':  $prestcoop=$detalle[$i]['valor'];
							
			   break;
			case 'ALUMPUB':  $alumpub=$detalle[$i]['valor'];
							
			   break;
			  
			case 'DESATR':  $desatr=$detalle[$i]['valor'];
							
			   break;
			   case 'COMPDEP':  $compdep=$detalle[$i]['valor'];
							
			   break;
			  case 'APSIND':  $apsind=$detalle[$i]['valor'];
							
			   break;
			   case 'DESCAP':  $descap=$detalle[$i]['valor'];
							
			   break;
			   case 'APSIB':  $apsib=$detalle[$i]['valor'];
							
			   break;
			   case 'DESCUOTA':  $descuota=$detalle[$i]['valor'];
							
			   break;
			   case 'DESUNICO':  $desunico=$detalle[$i]['valor'];
							
			   break;
			    case 'DESQUIN':  $desquin=$detalle[$i]['valor'];
							
			   break;
			    case 'RETJUD':  $retjud=$detalle[$i]['valor'];
							
			   break;
			    case 'SUBLAC':  $sublac=$detalle[$i]['valor'];
							
			   break;
			    case 'SUBPRE':  $subpre=$detalle[$i]['valor'];
							
			   break;
			    case 'SAL_MESIG':  $sal_mesig=$detalle[$i]['valor'];
							
			   break;
			        case 'HOREXT':  $horext=$detalle[$i]['valor'];
			   break;
			        case 'HORNOCT':  $hornoct=$detalle[$i]['valor'];
			   break;
			        case 'BONHOREXT':  $bonhorext=$detalle[$i]['valor'];
			   break;
			        case 'RECNOC':  $recnoc=$detalle[$i]['valor'];
			   break;
			        case 'ASIGDIS':  $asigdis=$detalle[$i]['valor'];
			   break;
			  case 'BONFRON':  $bonfron=$detalle[$i]['valor'];
			   break;
			  case 'SUBNAT':  $subnat=$detalle[$i]['valor'];
			   break;
			 
			  case 'SUBSEP':  $subsep=$detalle[$i]['valor'];
			   break;
			   case 'INCTEMP':  $inctemp=$detalle[$i]['valor'];
			   break;
			   case 'REINTCOT':  $reintcot=$detalle[$i]['valor'];
			   break;
			    case 'REINTBANT':  $reintbant=$detalle[$i]['valor'];
			   break;
			  //modificacion para planilla de octubre/2013
			   case 'REINT_SAL':  $reintsal=$detalle[$i]['valor'];
			   break;
			   case 'REINTBFRON':  $reintbfron=$detalle[$i]['valor'];
			   break;
			   
			   case 'REINTBEXT':  $reintbext=$detalle[$i]['valor'];
			   break;
			   
			 /*  case 'COMPINCAP':  $comincap=$detalle[$i]['valor'];
			   break;*/
		}
	}
	$indice=$indice+42;
	
	
	
$pdf->SetFont('Arial','B',14);
$y=$inicio_boleta;

	//$pdf->SetXY(172,$pdf->GetY());
	
	$pdf->Cell(40,23,'','',1);
	//$pdf->Image('../../../../lib/images/logo_reporte.jpg',15,4,25,10);
	//$pdf->Image('../../../../lib/images/fondo_ende.jpg',20,20,150,67);
	$pdf->SetXY(45,$y);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(127,20,' PAPELETA DE SUELDO:'.$cabecera[0]['periodo'].'-'.$cabecera[0]['gestion'],'',1,'C');
	$pdf->SetFont('Arial','',10);
	//if ($j==0){
		
	    $pdf->SetXY(145,$y+5);
	//}else{
		//echo "entra cuando es distinto de 0";
		//exit;
		//$pdf->SetXY(145,$y);
	//}
	
	$x=$pdf->GetX();
	
					
	$pdf->SetFont('Arial','B',9);
	$pdf->SetXY(167,$y);
	$pdf->Cell(45,4,'No Patronal:511-2067','',1,'C'); 
	$pdf->SetX(170);
	$pdf->Cell(42,6,'N.I.T. 1023187029','',1,'C'); 
	$pdf->Cell(207,12,'','',1,'C');
	
	
	$pdf->Cell(2,5,'','',0);
	$pdf->Cell(13,5,'Código','RT',0,'C');
	$pdf->Cell(82,5,'Nombres y Apellidos','RT',0,'C');
	$pdf->Cell(98,5,'Cargo','RT',0,'C');
	$pdf->Cell(10,5,'Niv','T',0,'C');
	$pdf->Cell(2,5,'','',1,'C');
	//datos
	
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(2,5,'','',0);
	$pdf->Cell(13,5,$codigo_empleado,'RB',0,'C');
	$pdf->Cell(82,5,$nombre_empleado,'RB',0,'C');
	$pdf->Cell(98,5,$nombre_cargo,'RB',0,'C');
	$pdf->Cell(10,5,$nivel,'B',0,'C');
	$pdf->Cell(2,5,'','',1,'C');
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(2,4,'','',0);
	$pdf->Cell(70,4,'SUELDO BÁSICO:','',0,'L');
	$pdf->Cell(20,4,number_format($suelmes,2),'',0,'R');
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(50,4,'AFP CUENTA INDIVIDUAL','',0,'L');
	$pdf->Cell(15,4,'10%:','',0,'R');
	$pdf->Cell(25,4,'','',0,'R');
	$pdf->Cell(10,4,number_format($afp_sso,2),'',0,'R');
	$pdf->Cell(5,4,'','',1,'C');
	
	//$pdf->Cell(2,4,'','',0);
	$pdf->Cell(2,4,'','',0);
	if ($inctemp>0) {
	$pdf->Cell(70,4,'INCAPACIDAD TEMPORAL','',0,'L');
	$pdf->Cell(20,4,number_format($inctemp,2).'','',0,'R');
	}else{
	$pdf->Cell(70,4,'','',0,'L');
	$pdf->Cell(20,4,'','',0,'R');
	}
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(50,4,'AFP SEGURO RIESGO COMUN','',0,'L');
	$pdf->Cell(15,4,'1.71%:','',0,'R');
	$pdf->Cell(25,4,'','',0,'R');
	$pdf->Cell(10,4,number_format($afp_recom,2),'',0,'R');
	$pdf->Cell(5,4,'','',1,'C');
/***** 1 **/	
$pdf->Cell(2,4,'','',0);
if (is_null($bonant) || $bonant<=0) {
	$pdf->Cell(70,4,'','',0,'L');
	$pdf->Cell(20,4,'','',0,'R');
	
}else{
	$pdf->Cell(70,4,'BONO DE ANTIGUEDAD:','',0,'L');
	$pdf->Cell(20,4,number_format($bonant,2),'',0,'R');
	
}
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(50,4,'AFP COM ADM.','',0,'L');
	$pdf->Cell(15,4,'0.50%:','',0,'R');
	$pdf->Cell(25,4,'','',0,'R');
	$pdf->Cell(10,4,number_format($afp_cadm,2),'',0,'R');
	$pdf->Cell(5,4,'','',1,'C');
	/****2 ***/
	$pdf->Cell(2,4,'','',0);
	if (is_null($bonhorext) || $bonhorext<=0) {
		$pdf->Cell(70,4,'','',0,'L');
	    $pdf->Cell(20,4,'','',0,'R');
	}else{
		$pdf->Cell(50,4,'HORAS EXTRA:','',0,'L');
		$pdf->Cell(20,4,''.floor($horext),'',0,'L');
	    $pdf->Cell(20,4,''.number_format($bonhorext,2),'',0,'R');
	
	}
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	if (is_null($aplab_sol) || $aplab_sol<=0) {
	$pdf->Cell(50,4,'','',0,'L');
	$pdf->Cell(15,4,'','',0,'R');
	$pdf->Cell(25,4,'','',0,'R');
	$pdf->Cell(10,4,'','',0,'R');
		
	}else{
	$pdf->Cell(50,4,'APORTE SOLIDARIO','',0,'L');
	$pdf->Cell(15,4,'0.50%:','',0,'R');
	$pdf->Cell(25,4,'','',0,'R');
	$pdf->Cell(10,4,number_format($aplab_sol,2),'',0,'R');
		
	}
	$pdf->Cell(5,4,'','',1,'C');
	/***3**/
	$pdf->Cell(2,4,'','',0);
	if (is_null($recnoc) || $recnoc<=0) {
	    $pdf->Cell(70,4,'','',0,'L');
	    $pdf->Cell(20,4,'','',0,'R');
		
	}else{
	    $pdf->Cell(50,4,'RECARGO NOCTURNO:','',0,'L');
	    $pdf->Cell(20,4,''.floor($hornoct),'',0,'L');
	    $pdf->Cell(20,4,''.number_format($recnoc,2),'',0,'R');
		
	}
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	if (is_null($apnal_sol) || $apnal_sol<=0) {
	   $pdf->Cell(50,4,'','',0,'L');
	   $pdf->Cell(15,4,'','',0,'R');
	   $pdf->Cell(25,4,'','',0,'R');
	   $pdf->Cell(10,4,'','',0,'R');
	}else{
	   $pdf->Cell(50,4,'APORTE NACIONAL SOLIDARIO','',0,'L');
	   $pdf->Cell(15,4,'','',0,'R');
	   $pdf->Cell(25,4,'','',0,'R');
	   $pdf->Cell(10,4,number_format($apnal_sol,2),'',0,'R');
		
	}
	
	$pdf->Cell(5,4,'','',1,'C');
	/***4***/
	$pdf->Cell(2,4,'','',0);
	if (is_null($asigdis) || $asigdis<=0) {
		$pdf->Cell(70,4,'','',0,'L');
	    $pdf->Cell(20,4,'','',0,'R');

	}else{
		$pdf->Cell(70,4,'ASIG. DISPONIBILIDAD','',0,'L');
	    $pdf->Cell(20,4,''.number_format($asigdis,2),'',0,'R');

	}
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(90,4,'TOTAL DESCUENTOS DE LEY','',0,'L');
	$pdf->Cell(10,4,number_format($afp_sso+$afp_recom+$afp_cadm+$aplab_sol+$apnal_sol,2),'T',0,'R');
	$pdf->Cell(5,4,'','',1,'C');
	
	/*
	$pdf->Cell(2,5,'','',0);
	if (is_null($bonfron) || $bonfron<=0) {
		$pdf->Cell(70,5,'','',0,'L');
	$pdf->Cell(20,5,'','',0,'R');
	
	}else{
		$pdf->Cell(70,5,'BONO FRONTERA','',0,'L');
	$pdf->Cell(20,5,''.number_format($bonfron,2),'',0,'R');
	
	}
	$pdf->Cell(5,5,'','R',0);
	$pdf->Cell(5,5,'','',0);
	$pdf->Cell(90,5,'','',0,'L');
	$pdf->Cell(10,5,'','',0,'C');
	$pdf->Cell(5,5,'','',1,'C');
	*/
	//$pdf->Ln(1);
	/***5**/
	$pdf->Cell(2,4,'','',0);
	if (is_null($bonfron) || $bonfron<=0) {
		$pdf->Cell(70,5,'','',0,'L');
	$pdf->Cell(20,4,'','',0,'R');
	
	}else{
		$pdf->Cell(70,4,'BONO FRONTERA','',0,'L');
	$pdf->Cell(20,4,''.number_format($bonfron,2),'',0,'R');
	
	}
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	
	if (is_null($rc_iva) || $rc_iva<=0) {
		$pdf->Cell(90,4,'','',0,'L');
	    $pdf->Cell(10,4,'','',0,'R');
	
	}else{
		$pdf->Cell(90,4,'RETENCION RC-IVA','',0,'L');
	    $pdf->Cell(10,4,''.number_format($rc_iva,2),'',0,'R');
	
	}
	
	$pdf->Cell(5,4,'','',1,'C');
	
	/*****6***/
	$pdf->Cell(2,4,'','',0);
	if (is_null($subpre) || $subpre<=0) {
		$pdf->Cell(70,4,'','',0,'L');
	    $pdf->Cell(20,4,'','',0,'R');
	
	}else{
		$pdf->Cell(70,4,'SUBSIDIO PRENATAL','',0,'L');
	    $pdf->Cell(20,4,''.number_format($subpre,2),'',0,'R');
	
	}
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	if (is_null($desquin) || $desquin<=0) {
	   $pdf->Cell(90,4,'','',0,'L');
	   $pdf->Cell(10,4,'','',0,'R');
		
	}else{
		$pdf->Cell(90,4,'ANTICIPO','',0,'L');
	    $pdf->Cell(10,4,number_format($desquin,2),'',0,'R');
	
	}
	$pdf->Cell(5,4,'','',1,'C');
	
	/*****7  **/
	
	$pdf->Cell(2,4,'','',0);
	if (is_null($subnat) || $subnat<=0) {
	    $pdf->Cell(70,4,'','',0,'L');
	    $pdf->Cell(20,4,'','',0,'R');	
	}else {
		$pdf->Cell(70,4,'SUBSIDIO NATALIDAD','',0,'L');
	$pdf->Cell(20,4,''.number_format($subnat,2),'',0,'R');
	}
	
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	if (is_null($prestcoop) || $prestcoop<=0) {
	     $pdf->Cell(90,4,'','',0,'L');
	     $pdf->Cell(10,4,'','',0,'R');
		
	}else{
		$pdf->Cell(90,4,'PRESTAMO CACSEL','',0,'L');
	    $pdf->Cell(10,4,number_format($prestcoop,2),'',0,'R');
	
	}
	$pdf->Cell(5,4,'','',1,'C');
	/*******8***/
	$pdf->Cell(2,4,'','',0);
	if (is_null($sublac) || $sublac<=0) {
		$pdf->Cell(70,4,'','',0,'L');
	    $pdf->Cell(20,4,'','',0,'R');
	
	}else{
		$pdf->Cell(70,4,'SUBSIDIO LACTANCIA','',0,'L');
	    $pdf->Cell(20,4,''.number_format($sublac,2),'',0,'R');
	
	}
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	if (is_null($afcoop) || $afcoop<=0) {
	    
		$pdf->Cell(90,4,'','',0,'L');
	    $pdf->Cell(10,4,'','',0,'R');
		
		} 
	else
	{
	    $pdf->Cell(90,4,'APORTE CACSEL','',0,'L');
	    $pdf->Cell(10,4,number_format($afcoop,2),'',0,'R');
			
		}
	$pdf->Cell(5,4,'','',1,'C');
	
	/*****9  ****/
	$pdf->Cell(2,4,'','',0);
	if (is_null($subsep) || $subsep<=0) {
		$pdf->Cell(70,4,'','',0,'L');
	    $pdf->Cell(20,4,'','',0,'R');
	
	}else{
		$pdf->Cell(70,4,'SUBSIDIO SEPELIO','',0,'L');
	$pdf->Cell(20,4,''.number_format($subsep,2),'',0,'R');
	
	}
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	if (is_null($apcoop) || $apcoop<=0) {
		$pdf->Cell(50,4,'',0,'L');
	    $pdf->Cell(10,4,':','',0,'R');
	    $pdf->Cell(30,4,'','',0,'R');
	    $pdf->Cell(10,4,'','',0,'R');

	}else{
		$pdf->Cell(50,4,'CACSEL',0,'L');
	    $pdf->Cell(10,4,'4%:','',0,'R');
	    $pdf->Cell(30,4,'','',0,'R');
	    $pdf->Cell(10,4,number_format($apcoop,2),'',0,'R');

	}
	
		$pdf->Cell(5,4,'','',1,'C');
	/****10***/
	$pdf->Cell(2,4,'','',0);
    if (is_null($reintcot) || $reintcot<=0) {
	
		$pdf->Cell(70,4,'','',0,'L');
		$pdf->Cell(20,4,'','',0,'R');
	}else{
		$pdf->Cell(70,4,'REINTEGRO COTIZABLE','',0,'L');
		$pdf->Cell(20,4,number_format($reintcot,2),'',0,'R');
		
	}
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(50,4,'ASIG. ENERG. ELEC.',0,'L');
	$pdf->Cell(10,4,'','',0,'R');
	$pdf->Cell(30,4,'','',0,'R');
	$pdf->Cell(10,4,number_format($alumpub,2),'',0,'R');
	$pdf->Cell(5,4,'','',1,'C');
	
	/***11**/
	$pdf->Cell(2,4,'','',0);
	if (is_null($reintbant) || $reintbant<=0) {
		$pdf->Cell(70,4,'','',0,'L');
		$pdf->Cell(20,4,'','',0,'R');
	}else{
		$pdf->Cell(70,4,'REINTEGRO BONO ANTIGUEDAD','',0,'L');
		$pdf->Cell(20,4,number_format($reintbant,2),'',0,'R');
		
	}
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	
	
	if (is_null($desatr) || $desatr<=0) {
	    $pdf->Cell(50,4,'',0,'L');
		$pdf->Cell(10,4,'','',0,'R');
		$pdf->Cell(30,4,'','',0,'R');
		$pdf->Cell(10,4,'','',0,'R');   
	}else{
		$pdf->Cell(50,4,'DESC. ATRASO',0,'L');
		$pdf->Cell(10,4,'','',0,'R');
		$pdf->Cell(30,4,'','',0,'R');
		$pdf->Cell(10,4,number_format($desatr,2),'',0,'R');
	}
	
	$pdf->Cell(5,3,'','',1,'C');
	/***Aporte sindicato *****/
	
	
	/*12*/
	
	$pdf->Cell(2,4,'','',0);//planilla oct2013
	if (is_null($reintbfron) || $reintbfron<=0) {
		$pdf->Cell(70,4,'','',0,'L');
		$pdf->Cell(20,4,'','',0,'R');
	}else{
		$pdf->Cell(70,4,'REINTEGRO BONO FRONTERA','',0,'L');
		$pdf->Cell(20,4,number_format($reintbfron,2),'',0,'R');
	
	}
	
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	
	if ($apsind<=0){
		$pdf->Cell(90,4,'','',0,'L');
	$pdf->Cell(10,4,'','',0,'R');
	
	}else{
		$pdf->Cell(90,4,'APORTE SINDICATO','',0,'L');
	$pdf->Cell(10,4,number_format($apsind,2),'',0,'R');
	
	}
	$pdf->Cell(5,3,'','',1,'C');
	
	
	//6/11/2013
	$pdf->Cell(2,3,'','',0);
   if (is_null($reintbext) || $reintbext<=0) {
		$pdf->Cell(70,4,'','',0,'L');
		$pdf->Cell(20,4,'','',0,'R');
	}else{
		$pdf->Cell(70,4,'REINTEGRO BONO HRA EXTRA','',0,'L');
		$pdf->Cell(20,4,number_format($reintbext,2),'',0,'R');
	
	}
	$pdf->Cell(5,3,'','R',0);
	$pdf->Cell(5,3,'','',0);
	
	
	if (is_null($reintsal) || $reintsal<=0) {
		$pdf->Cell(50,3,'',0,'L');
	$pdf->Cell(10,3,'','',0,'R');
	$pdf->Cell(30,3,'','',0,'R');
	$pdf->Cell(10,3,'','',0,'R');  
	
	}else{
		
		$pdf->Cell(50,3,'REINTEGRO ENE-OCT/2014',0,'L');
		$pdf->Cell(10,3,'','',0,'R');
		$pdf->Cell(30,3,'','',0,'R');
		$pdf->Cell(10,3,number_format($reintsal,2),'',0,'R');
	}
	
	$pdf->Cell(5,3,'','',1,'C');
	
	/***fin Aporte sindicato *****/
	$pdf->Cell(2,3,'','',0);
	if($comincap>0){
		$pdf->Cell(70,3,'COMPLEMENTO INC.TEMP.','B',0,'L');
		$pdf->Cell(20,3,number_format($comincap,2),'B',0,'R');
	}else{
		$pdf->Cell(70,3,'','B',0,'L');
		$pdf->Cell(20,3,'','B',0,'R');
	}
	$pdf->Cell(5,3,'','RB',0);
	$pdf->Cell(5,3,'','LB',0);
	
	$total_desc_varios=$retjud
	//+$descvar
	+$compdep+$descap+$apsib+$descuota+$desunico;
	if ($total_desc_varios<=0){
		$pdf->Cell(90,3,'','B',0,'L');
	$pdf->Cell(10,3,'','B',0,'R');
	
	}else{
		$pdf->Cell(90,3,'DESCUENTOS VARIOS','B',0,'L');
	$pdf->Cell(10,3,number_format($total_desc_varios,2),'B',0,'R');
	
	}
	$pdf->Cell(5,4,'','',1,'C');
	
	
	if($_SESSION["ss_id_usuario"]==120){
		//print_r($suelmes+$bonant+$bonhorext+$recnoc +$asigdis+$bonfron+$reintcot+$reintbant+$sublac+$subnat+$inctemp); exit;
	}
	
	$pdf->Cell(2,4,'','',0);
	$pdf->Cell(70,4,'TOTAL INGRESOS(Bs):','',0,'L');
	$pdf->Cell(20,4,number_format($suelmes+$bonant+$bonhorext+$recnoc +$asigdis+$bonfron+$reintcot+$reintbant+$sublac+$subnat+$inctemp+$reintbfron+$reintbext+$subpre+$subsep+$comincap,2),'',0,'R');
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(90,4,'TOTAL DESCUENTOS(Bs)','B',0,'L');
	//$pdf->Cell(10,4,number_format($afcoop+$apcoop+$descvar,2)+number_format($afp_sso+$afp_recom+$afp_cadm,2),'B',0,'R');
	$pdf->Cell(10,4,number_format($totdesc,2),'B',0,'R');
	$pdf->Cell(5,4,'','',1,'C');
	
	
	$pdf->Cell(2,5,'','',0);
	$pdf->Cell(70,5,'','',0,'L');
	$pdf->Cell(20,5,'','',0,'R');
	$pdf->Cell(5,5,'','',0);
	$pdf->Cell(5,5,'','',0);
	$pdf->SetFont('Arial','BI',8);
	$pdf->Cell(90,5,'LIQUIDO PAGABLE(Bs)','LTB',0,'L');
	$pdf->Cell(10,5,number_format($liqpag,2),'TBR',0,'R');
	$pdf->SetFont('Arial','',10);
	
	$pdf->Cell(5,5,'','',1,'C');
	
	
	$pdf->Cell(2,5,'','',0);
	$pdf->Cell(70,5,'','',0,'L');
	$pdf->Cell(20,5,'','',0,'R');
	$pdf->Cell(5,5,'','',0);
	$pdf->Cell(5,5,'','',0);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(100,5,'LIQUIDO PAGABLE: '.$liq_pag_literal.' Bs','',0,'L');
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(5,5,'','',1,'C');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(2,5,'','',0);
	$pdf->Cell(70,5,'SALDO RC-IVA','',0,'L');
	if ($sal_mesig<=0){
	   $pdf->Cell(20,5,'','',0,'R');
	}else{
	   $pdf->Cell(20,5,''.number_format($sal_mesig,2),'',0,'R');
	}
	
	$pdf->Cell(5,5,'','',0);
	$pdf->Cell(5,5,'','',0);
	$pdf->Cell(100,5,'','',0,'L');
	$pdf->Cell(5,5,'','',1,'C');
	
	$pdf->Cell(2,5,'','',0);
	$pdf->Cell(70,5,'HORAS TRABAJADAS','',0,'L');
	$pdf->Cell(20,5,number_format($hornorm,0),'',0,'R');
	$pdf->Cell(5,5,'','',0);
	$pdf->Cell(5,5,'','',0);
	$pdf->Cell(100,5,'','',0,'L');
	$pdf->Cell(5,5,'','',1,'C');

	
	/*$pdf->Cell(100,1,'',1,0,'C');
	$pdf->Cell(0,2,'______________________________',1,1,'C');
	*/
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',5);
	$pdf->Cell(2,5,'','',0);
	$pdf->Cell(100,2,''.sha1($nombre_empleado.$suelmes.$cabecera[0]['periodo'].$cabecera[0]['gestion']),0,0,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(20,5,'',0,0,'C');
	$pdf->Cell(60,5,'RECIBI CONFORME','T',0,'C');
	$pdf->Cell(20,5,'',0,1,'C');
	$pdf->SetXY(8,($pdf->GetY()-3));
	$pdf->SetFont('Arial','',5);
	$pdf->Cell(5,2,'Endesis',0,1,'C');
	
	/*$pdf->Cell(2,4,'','',1);
	$pdf->Cell(2,2,'','',0);
	$pdf->SetFont('Arial','',5);
	$pdf->Cell(70,2,sha1($nombre_empleado.$suelmes.$cabecera[0]['periodo'].$cabecera[0]['gestion']),0,1,'L');
	$pdf->Cell(3,1,'','',0);
	$pdf->Cell(5,2,'Endesis','',1,'C');
	$pdf->SetFont('Arial','',10);*/
	//$pdf->Cell(0,6,'',0,1);
 //$pdf->AddPage();
	//*********************************************************************************
	/*+++++++++++++++++++++++++++++++++++++*/
	/*$y=$pdf->GetY()+13;
	$pdf->SetXY(5,$pdf->GetY()+13);
	
	$pdf->Cell(40,11,'','',1);
	//$pdf->Image('../../../../lib/images/logo_reporte.jpg',15,4,25,10);
	//$pdf->Image('../../../../lib/images/fondo_ende.jpg',20,20,150,67);
	$pdf->SetXY(45,$y); 
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(127,20,' PAPELETA DE SUELDO:'.$cabecera[0]['periodo'].'-'.$cabecera[0]['gestion'],'',1,'C');
	$pdf->SetFont('Arial','',10);
	//if ($j==0){
		
	    $pdf->SetXY(145,$y+5);
	//}else{
		//echo "entra cuando es distinto de 0";
		//exit;
		//$pdf->SetXY(145,$y);
	//}
	
	$x=$pdf->GetX();
	
					
	$pdf->SetFont('Arial','B',9);
	$pdf->SetXY(167,$y);
	$pdf->Cell(45,4,'No Patronal:511-2067','',1,'C'); 
	$pdf->SetX(170);
	$pdf->Cell(42,6,'N.I.T. 102370','',1,'C'); 
	$pdf->Cell(207,12,'','',1,'C');
	
	
	$pdf->Cell(2,5,'','',0);
	$pdf->Cell(13,5,'Código','RT',0,'C');
	$pdf->Cell(82,5,'Nombres y Apellidos','RT',0,'C');
	$pdf->Cell(98,5,'Cargo','RT',0,'C');
	$pdf->Cell(10,5,'Niv','T',0,'C');
	$pdf->Cell(2,5,'','',1,'C');
	//datos
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(2,4,'','',0);
	$pdf->Cell(13,4,$codigo_empleado,'RB',0,'C');
	$pdf->Cell(82,4,$nombre_empleado,'RB',0,'C');
	$pdf->Cell(98,4,$nombre_cargo,'RB',0,'C');
	$pdf->Cell(10,4,$nivel,'B',0,'C');
	$pdf->Cell(2,4,'','',1,'C');
	
	$pdf->Cell(2,4,'','',0);
	$pdf->Cell(70,4,'SUELDO BÁSICO:','',0,'L');
	$pdf->Cell(20,4,number_format($suelmes,2),'',0,'R');
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(50,4,'AFP CUENTA INDIVIDUAL','',0,'L');
	$pdf->Cell(15,4,'10%:','',0,'R');
	$pdf->Cell(25,4,'','',0,'R');
	$pdf->Cell(10,4,number_format($afp_sso,2),'',0,'R');
	$pdf->Cell(5,4,'','',1,'C');
	
	$pdf->Cell(2,4,'','',0);
	$pdf->Cell(70,4,'','',0,'L');
	$pdf->Cell(20,4,'','',0,'R');
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(50,4,'AFP SEGURO RIESGO COMUN','',0,'L');
	$pdf->Cell(15,4,'1.71%:','',0,'R');
	$pdf->Cell(25,4,'','',0,'R');
	$pdf->Cell(10,4,number_format($afp_recom,2),'',0,'R');
	$pdf->Cell(5,4,'','',1,'C');
	
	$pdf->Cell(2,4,'','',0);
	$pdf->Cell(70,4,'BONO DE ANTIGUEDAD:','',0,'L');
	$pdf->Cell(20,4,number_format($bonant,2),'',0,'R');
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(50,4,'AFP COM ADM.','',0,'L');
	$pdf->Cell(15,4,'0.50%:','',0,'R');
	$pdf->Cell(25,4,'','',0,'R');
	$pdf->Cell(10,4,number_format($afp_cadm,2),'',0,'R');
	$pdf->Cell(5,4,'','',1,'C');
	
	$pdf->Cell(2,4,'','',0);
	$pdf->Cell(70,4,'','',0,'L');
	$pdf->Cell(20,4,'','',0,'R');
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(50,4,'APORTE SOLIDARIO','',0,'L');
	$pdf->Cell(15,4,'0.50%:','',0,'R');
	$pdf->Cell(25,4,'','',0,'R');
	$pdf->Cell(10,4,number_format($aplab_sol,2),'',0,'R');
	$pdf->Cell(5,4,'','',1,'C');
	
	$pdf->Cell(2,4,'','',0);
	$pdf->Cell(70,4,'','',0,'L');
	$pdf->Cell(20,4,'','',0,'R');
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(50,4,'APORTE NACIONAL SOLIDARIO','',0,'L');
	$pdf->Cell(15,4,'','',0,'R');
	$pdf->Cell(25,4,'','',0,'R');
	$pdf->Cell(10,4,number_format($apnal_sol,2),'',0,'R');
	$pdf->Cell(5,4,'','',1,'C');
	
	$pdf->Cell(2,4,'','',0);
	$pdf->Cell(70,4,'','',0,'L');
	$pdf->Cell(20,4,'','',0,'R');
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(90,4,'TOTAL DESCUENTOS DE LEY','',0,'L');
	$pdf->Cell(10,4,number_format($afp_sso+$afp_recom+$afp_cadm+$aplab_sol+$apnal_sol,2),'T',0,'R');
	$pdf->Cell(5,4,'','',1,'C');
	
	
	$pdf->Cell(2,5,'','',0);
	$pdf->Cell(70,5,'','',0,'L');
	$pdf->Cell(20,5,'','',0,'R');
	$pdf->Cell(5,5,'','R',0);
	$pdf->Cell(5,5,'','',0);
	$pdf->Cell(90,5,'','',0,'L');
	$pdf->Cell(10,5,'','',0,'C');
	$pdf->Cell(5,5,'','',1,'C');
	
	$pdf->Cell(2,4,'','',0);
	$pdf->Cell(70,4,'','',0,'L');
	$pdf->Cell(20,4,'','',0,'R');
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(90,4,'PRESTAMO CACSEL','',0,'L');
	$pdf->Cell(10,4,number_format($prestcoop,2),'',0,'R');
	$pdf->Cell(5,4,'','',1,'C');
	
	$pdf->Cell(2,4,'','',0);
	$pdf->Cell(70,4,'','',0,'L');
	$pdf->Cell(20,4,'','',0,'R');
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(90,4,'APORTE CACSEL','',0,'L');
	$pdf->Cell(10,4,number_format($afcoop,2),'',0,'R');
	$pdf->Cell(5,4,'','',1,'C');
	
	
	$pdf->Cell(2,4,'','',0);
	$pdf->Cell(70,4,'','',0,'L');
	$pdf->Cell(20,4,'','',0,'R');
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(50,4,'CACSEL',0,'L');
	$pdf->Cell(10,4,'4%:','',0,'R');
	$pdf->Cell(30,4,'','',0,'R');
	$pdf->Cell(10,4,number_format($apcoop,2),'',0,'R');
	$pdf->Cell(5,4,'','',1,'C');
	
	$pdf->Cell(2,4,'','',0);
	$pdf->Cell(70,4,'','',0,'L');
	$pdf->Cell(20,4,'','',0,'R');
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(50,4,'ASIG. ENERG. ELEC.',0,'L');
	$pdf->Cell(10,4,'','',0,'R');
	$pdf->Cell(30,4,'','',0,'R');
	$pdf->Cell(10,4,number_format($alumpub,2),'',0,'R');
	$pdf->Cell(5,4,'','',1,'C');
	
	$pdf->Cell(2,4,'','',0);
	$pdf->Cell(70,4,'','',0,'L');
	$pdf->Cell(20,4,'','',0,'R');
	$pdf->Cell(5,4,'','R',0);
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(50,4,'DESC. ATRASO',0,'L');
	$pdf->Cell(10,4,'','',0,'R');
	$pdf->Cell(30,4,'','',0,'R');
	$pdf->Cell(10,4,number_format($desatr,2),'',0,'R');
	$pdf->Cell(5,4,'','',1,'C');
	
	 
	$pdf->Cell(2,4,'','',0);
	$pdf->Cell(70,4,'','B',0,'L');
	$pdf->Cell(20,4,'','B',0,'R');
	$pdf->Cell(5,4,'','RB',0);
	$pdf->Cell(5,4,'','LB',0);
	$pdf->Cell(90,4,'DESCUENTOS VARIOS','B',0,'L');
	$pdf->Cell(10,4,number_format($desquin+$retjud+$sublac+$subpre+$descvar+$compdep+$apsind+$descap+$apsib+$descuota+$desunico,2),'B',0,'R');
	$pdf->Cell(5,4,'','',1,'C');
	
	
	$pdf->Cell(2,4,'','',0);
	$pdf->Cell(70,4,'TOTAL INGRESOS(Bs):','',0,'L');
	$pdf->Cell(20,4,number_format($suelmes+$bonant,2),'',0,'R');
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(90,4,'TOTAL DESCUENTOS(Bs)','B',0,'L');
	//$pdf->Cell(10,4,number_format($afcoop+$apcoop+$descvar,2)+number_format($afp_sso+$afp_recom+$afp_cadm,2),'B',0,'R');
	$pdf->Cell(10,4,number_format($totdesc,2),'B',0,'R');
	$pdf->Cell(5,4,'','',1,'C');
	
	
	$pdf->Cell(2,4,'','',0);
	$pdf->Cell(70,4,'','',0,'L');
	$pdf->Cell(20,4,'','',0,'R');
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(5,4,'','',0);
	$pdf->SetFont('Arial','BI',8);
	$pdf->Cell(90,4,'LIQUIDO PAGABLE(Bs)','LTB',0,'L');
	$pdf->Cell(10,4,number_format($liqpag,2),'TBR',0,'R');
	$pdf->SetFont('Arial','',10);
	
	$pdf->Cell(5,4,'','',1,'C');
	
	
	$pdf->Cell(2,4,'','',0);
	$pdf->Cell(70,4,'','',0,'L');
	$pdf->Cell(20,4,'','',0,'R');
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(5,4,'','',0);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(100,4,'LIQUIDO PAGABLE: '.$liq_pag_literal.' Bs','',0,'L');
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(5,4,'','',1,'C');
	
	$pdf->Cell(2,4,'','',0);
	$pdf->Cell(70,4,'RETENCION RC-IVA','',0,'L');
	$pdf->Cell(20,4,''.number_format($rc_iva,2),'',0,'R');
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(100,4,'','',0,'L');
	$pdf->Cell(5,4,'','',1,'C');
	
	$pdf->Cell(2,4,'','',0);
	$pdf->Cell(70,4,'HORAS TRABAJADAS','',0,'L');
	$pdf->Cell(20,4,$hornorm,'',0,'R');
	$pdf->Cell(5,4,'','',0);
	$pdf->Cell(5,4,'','',0);
	//$pdf->Cell(100,4,'','',0,'L');
	$pdf->Cell(5,4,'','',1,'C');
	
	$pdf->Cell(2,5,'','',1);
	$pdf->Cell(2,2,'','',0);
	$pdf->SetFont('Arial','',5);
	$pdf->Cell(70,2,sha1($nombre_empleado.$suelmes.$cabecera[0]['periodo'].$cabecera[0]['periodo'].gregoriantojd(date('m'),date('d'),date('Y')).$hora),0,1,'L');
	$pdf->Cell(3,1,'','',0);
	$pdf->Cell(5,2,'Endesis','',1,'C');
	$pdf->SetFont('Arial','',10);
	
	//$pdf->Cell(100,9,'',0,0,'C');
	//$pdf->Cell(0,1,'',0,1,'C');
	$pdf->Cell(100,1,'',0,0,'C');
	$pdf->Cell(0,2,'______________________________',0,1,'C');
	$pdf->Cell(100,5,'',0,0,'C'); 
	$pdf->Cell(0,5,'RECIBI CONFORME',0,1,'C');
	
//$pdf->Ln(30);	
//$pdf->Cell(15,10,'fffff',1,1);
	//}

/*if($j+1<$cant_adj){
 $pdf->AddPage();
}*/
//}*/
}
$pdf->Output();


?>