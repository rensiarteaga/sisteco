<?php
session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 27/06/
 * Descripción: Reporte de Empleados Curriculum Vitae
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

/*function SetNombreAFP($nombre_afp)
{
    $this->nombre_afp =$nombre_afp;
}*/
/*function SetTipoContrato($tipo_contrato)
{
    $this->tipoContrato =$tipo_contrato;
*/

function Header()
{       
   $this->Image('../../../../lib/images/logo_reporte.jpg',180,0,30,10);
  /* $cabecera=$_SESSION['PDF_cab_rep_planilla'];
   $this->SetFont('Arial','B',7);
	$this->Cell(30,3,'No. Patronal:511-2067',0,1);
	$this->Cell(30,3,'N.I.T.: 1023187029',0,1);
   $this->SetFont('Arial','BU',12);
   
  */
 	
 //	$this->SetFont('Arial','BI',6);
 // $this->Cell(0,5,'CURRICULUM VITAE ' ,0,1,'C');
    /*$this->Cell(0,5,''.$this->nombre_afp ,0,1,'C');
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
    */
}
 
//Pie de página
function Footer()
 {  $this->SetY(-9);
   	$this->pieHash('KARDEX');
 	
	}

}
  	$pdf=new PDF();	
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(10,5,5);  
    
    $pdf->SetFont('Arial','',6);
	$pdf->AddPage();
    

 
 	$datos_emp=$_SESSION["PDF_empleados_datos"];
 	$detalle_capacitacion=$_SESSION["PDF_empleado_capacitacion_detalle"];
	$detalle_trabajo=$_SESSION["PDF_empleado_trabajos_detalle"];
	$detalle_relaciones_familiares=$_SESSION["PDF_empleado_relaciones_familiares"];
	
	$tipo_reporte=$_SESSION["PDF_tipo_reporte"];
	
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
 	
 	$pdf->SetFont('Arial','BI',10);
 	
    $pdf->SetFillColor(81,169,215);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetDrawColor(81,169,215);
    if($tipo_reporte=='datos_personales'){
    	$pdf->Cell(80,10,'DATOS PERSONALES',1,1,'C',1);
    }else{
    $pdf->Cell(80,10,'CURRICULUM VITAE',1,1,'C',1);	
    }
    
    $inicio_cv=$pdf->GetY()-3;
    $pdf->SetY($pdf->GetY());
      $pdf->SetTextColor(0,84,148);
    $pdf->MultiCell(60,5,''.$datos_emp[0]['nombre_completo'],0,'L');
    $pdf->SetFillColor(255,255,255);
   $pdf-> Rect(70, 12, 30, 32 ,'DF');
   
  /* echo "../../../../sis_seguridad/control/persona/archivo/".$_SESSION['PDF_numero_cv'].".".$_SESSION['PDF_extension_cv'];
   exit;*/
   // ../../../sis_seguridad/control/persona/archivo/
   // $pdf->Image('../../../../sis_seguridad/control/persona/archivo/1600.jpeg',71,13,28,28);
    
    $pdf->Image('../../../../sis_seguridad/control/persona/archivo/'.$_SESSION['PDF_numero_cv'].'.'.$_SESSION['PDF_extension_cv'],75,18,18,18);	
   /* 
    $pdf->Cell(30,32,'','LTB',1,'L',1);*/
  
    $pdf->SetFont('Arial','B',7);
    $pdf->SetXY(100,$inicio_cv);
  
    $pdf->Cell(25,4,'C.I.: ','LT',0);
    
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(75,4,$datos_emp[0]['doc_id'],'TR',1);
   
    $pdf->SetX(100);
        $pdf->SetFont('Arial','B',7);
    $pdf->Cell(25,4,'Genero: ','L',0);
      $pdf->SetFont('Arial','',7);
    $pdf->Cell(75,4,$datos_emp[0]['genero'],'R',1);
    $pdf->SetX(100);
        $pdf->SetFont('Arial','B',7);
    $pdf->Cell(25,4,'Fecha Nacimiento:','L',0);
      $pdf->SetFont('Arial','',7);
    $pdf->Cell(75,4,$datos_emp[0]['fecha_nacimiento'],'R',1);
    $pdf->SetX(100);
        $pdf->SetFont('Arial','B',7);
    $pdf->Cell(25,4,'Dirección','L',0);
      $pdf->SetFont('Arial','',7);
    $pdf->Cell(75,4,$datos_emp[0]['direccion'],'R',1);
    $pdf->SetX(100);
        $pdf->SetFont('Arial','B',7);
    $pdf->Cell(25,4,'Telefono','L',0);
      $pdf->SetFont('Arial','',7);
    $pdf->Cell(75,4,$datos_emp[0]['telefono'],'R',1);
    $pdf->SetX(100);
        $pdf->SetFont('Arial','B',7);
    $pdf->Cell(25,4,'Correo Electrónico','L',0);
      $pdf->SetFont('Arial','',7);
    $pdf->Cell(75,4,$datos_emp[0]['email'],'R',1);
        $pdf->SetFont('Arial','B',7);
         $pdf->SetX(100);
    $pdf->Cell(25,4,'Nro. Contrato','L',0);
      $pdf->SetFont('Arial','',7);
    $pdf->Cell(75,4,$datos_emp[0]['nro_contrato'],'R',1);
     $pdf->SetX(100);
        $pdf->SetFont('Arial','B',7);
    $pdf->Cell(25,4,'Tipo Contrato A.','LB',0);
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(75,4,$datos_emp[0]['tipo_contrato'],'RB',1);
    $pdf->ln(1);
    	$pdf->SetFont('Arial','BI',6);
    	 	
    $pdf->SetFillColor(81,169,215);
    $pdf->SetTextColor(255,255,255);
 	$pdf->Cell(15,3,'EDUCACIÓN',0,1,'L',1);
 	   $pdf->SetTextColor(0,0,0);
 	   $pdf->Ln(1);
    $pdf->SetFont('Arial','',6);
 	for ($i=0;$i<count($detalle_capacitacion);$i++){
 		  $pdf->SetFont('Arial','BI',6);
 	    $pdf->Cell(80,4,$detalle_capacitacion[$i]['nombre_institucion'],'B',0);
 	    $pdf->Cell(15,4,$detalle_capacitacion[$i]['nombre_nivel'],'B',0);
 	    $pdf->Cell(70,4,$detalle_capacitacion[$i]['nombre_titulo'].'  '.$detalle_capacitacion[$i]['reg_profesional'],'B',0,'L');
 	    $pdf->Cell(30,4,$detalle_capacitacion[$i]['graduacion'],'B',1,'R');
 	     $pdf->SetFont('Arial','',4);
 	       $pdf->SetTextColor(0,129,197);
 	    $pdf->Cell(80,2,'Institución',0,0,'L');
 	    $pdf->Cell(15,2,'Nivel',0,0,'L');
 	    $pdf->Cell(70,2,'Nombre Título',0,0,'L');
 	    $pdf->Cell(30,2,'Fecha Título',0,1,'R');
 
 	      $pdf->SetTextColor(0,0,0);
 	    $pdf->SetFont('Arial','',6);
 	    $pdf->Cell(5,4,'',0,0);
 	    $pdf->MultiCell(190,4,$detalle_capacitacion[$i]['descripcion'],0,1);
 	    $pdf->SetFont('Arial','BI',6);
 	}
 	  // $pdf->SetFillColor(186,193,245);
    //$pdf->SetTextColor(22,39,156);
    
 	 $pdf->SetTextColor(255,255,255);
 	
 	$pdf->Cell(28,3,'EXPERIENCIA LABORAL',0,1,'L',1);
 	   $pdf->SetTextColor(0,0,0);
 
     $pdf->SetFont('Arial','BI',6);
   /*  print_r($detalle_trabajo);
     exit;*/
 	for ($j=0;$j<count($detalle_trabajo);$j++){
 	    $pdf->Cell(80,4,$detalle_trabajo[$j]['ins_nombre'],'B',0);
 	    $pdf->Cell(85,4,$detalle_trabajo[$j]['cargo'],'B',0);
 	    //$pdf->Cell(70,4,'Licenciada en Informatica','B',0,'L');
 	    $pdf->Cell(30,4,$detalle_trabajo[$j]['fecha_ini'].' al '.$detalle_trabajo[$j]['fecha_fin'],'B',1,'R');
 	    
 	     $pdf->SetFont('Arial','',4);
 	       $pdf->SetTextColor(0,129,197);
 	    $pdf->Cell(80,2,'Institución',0,0,'L');
 	    $pdf->Cell(85,2,'Cargo',0,0,'L');
 	    $pdf->Cell(30,2,'Fechas',0,1,'R');
 
 	      $pdf->SetTextColor(0,0,0);
 	      
 	    $pdf->SetFont('Arial','',6);
 	    $pdf->Cell(5,3,'',0,0);
 	    $pdf->SetTextColor(101,148,44);
 	    $pdf->Cell(185,3,'Responsabilidades',0,1);
 	    $pdf->SetTextColor(0,0,0);
 	    $pdf->Cell(5,4,'',0,0);
 	    $pdf->MultiCell(190,4,$detalle_trabajo[$j]['descripcion'],0,1);
 	   //  $pdf->MultiCell(185,4,'Habilidades Adquiridas',0,1);
 	    $pdf->SetFont('Arial','BI',6);
 	}
 	

 	
 	
 	
 	//////////////////////// Relaciones Familiares ////////////////////////////////////////////////////////////
 	if($tipo_reporte=='datos_personales'){
 	//aqui añadire  los datos de la relaciòn familiar 
 		//Relaciones familiares
 	$pdf->SetWidths(array(75,15,15,10,15,70));
	$pdf->SetFills(array(0,0,0,0,0,0,0,0));
 	$pdf->SetAligns(array('L','C','C','C','C','R'));
 	$pdf->SetVisibles(array(1,1,1,1,1,1));
  	$pdf->SetFontsSizes(array(6,6,6,6,6,6));
 	$pdf->SetFontsStyles(array('','','','','',''));
 	$pdf->SetSpaces(array(4,4,4,4,4,4));
 	$pdf->setDecimales(array(0,0,0,0,0,0));
    $pdf->SetFormatNumber(array(0,0,0,0,0,0));
 /*	print_r($detalle_relaciones_familiares);
 	exit;*/
  $pdf->SetTextColor(255,255,255);
 	
 	$pdf->Cell(28,3,'RELACIÓN FAMILIAR',0,1,'L',1);
 	$pdf->SetTextColor(0,0,0);
 	for ($k=0;$k<count($detalle_relaciones_familiares);$k++){

 		
 		$pdf->Multitabla($detalle_relaciones_familiares[$k],3,0,4,6,1);
 		
 		   $pdf->SetFont('Arial','',4);
 	       $pdf->SetTextColor(0,129,197);
 	    $pdf->Cell(75,2,'Nombre Completo','T',0,'L');
 	    $pdf->Cell(15,2,'Fecha Nacimiento','T',0,'C');
 	    $pdf->Cell(15,2,'Doc. ID','T',0,'C');
 	    $pdf->Cell(10,2,'Genero','T',0,'C');
 	     $pdf->Cell(10,2,'Relación','T',0,'C');
 	    $pdf->Cell(75,2,'Institución','T',1,'R');
 
 	      $pdf->SetTextColor(0,0,0);
 	      
 	   
 	    $pdf->SetFont('Arial','BI',6);
 	}
 	
 		$pdf->Ln(4);
 		$pdf->Cell(195,4,'NIVEL DE PARENTESCO  (Registre SI o NO)',0,1);
 		
 	    $pdf->SetFont('Arial','',6);
     $pdf->MultiCell(195,4,'Declaro que ....... tengo parentesco con trabajadores de ENDE y/o de las empresas subsidiarias que forman parte de la Corporación, dentro el cuarto grado de consanguinidad o segundo de afinidad. En caso de que la respuesta sea afirmativa, especifique nombre y Empresa.',0,1);
      	
 	
      $pdf->MultiCell(195,4,'Los datos consignados constituyen declaración jurada, los mismos que estarán sujetos a verificación por parte de ENDE. Asimismo, autorizo la verificación de la información proporcionada. En caso de comprobarse datos falsos, se procederá a iniciar las acciones que correspondan.',0);
     	
 	}
 	$pdf->Ln(1);
 	$fecha=date('d-m-Y');
     $pdf->Cell(195,4,"Cochabamba,  $fecha",0,1,'R');
     
     
     $pdf->Ln(10);
     $pdf->Cell(60,4,'',0,0);
     $pdf->Cell(50,4,'','B',0);
     $pdf->Cell(60,4,'',0,1);
     
     $pdf->Cell(60,4,'',0,0);
     $pdf->Cell(50,4,'FIRMA',0,0,'C');
     $pdf->Cell(60,4,'',0,1);
    
     
$pdf->Output();

?>