<?php

session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 16/03/2010
 * Descripción: Reporte de Listado de Procesos
 *
 *  **/

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



function Header()
{       
   $this->Image('../../../../lib/images/logo_reporte.jpg',180,2,35,15);
 
}
 
//Pie de página
/*function Footer()
{
   
        
      }*/


}  $id_uo=$_SESSION['id_unidad_organizacional'];
   $b=$_SESSION['tipo_reporte'];
	if ($b==0 && $id_uo=='%'){
    $pdf = new FPDF('L', 'mm', array(2300,800));
	}else{
	  $pdf=new PDF();	
	}
	
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,5);
    $pdf->SetMargins(5,5,5);  
    
    //$pdf-> AddFont('Arial','','arial.php'); 	
//$pdf->SetLeftMargin(15);
    $pdf->SetFont('Arial','B',10);
	
   
    
    
    $pdf->AddPage();


 	$vector=$_SESSION['PDF_listado_unidad_organizacional'];
	//print_r($vector);
	//$x=$pdf->GetX();
    $y=$pdf->GetY();
    // $max =0;
    $vector_niveles=array();
    $nivel=0;
    $id_padre_anterior=0;
    
    
   
    $vector_coordenadas= array();
    //primero colocare las coordenadas 
    
    
    $pdf->SetFont('Arial','B',8);
    
    $pdf->Cell(0,5,'DIAGRAMA ORGANIZACIONAL',0,1,'C');
 	for ($i=0;$i<count($vector);$i++){
 		
 		
 		$niveles=$vector[$i]["niveles"];
 		$nivel=substr_count($niveles, 'a');
 		
 	    $pdf->SetX((20*($nivel-1)));
 		//$pdf->Cell(((25*$nivel)+5),5,'','LT');
 		$x=$pdf->GetX();
 		$y=$pdf->GetY();
 		$pdf->Line($x-10, $y+2.5, $x,  $y+2.5);	 //line bottom
 		$pdf->Line($x-10, $y-2, $x-10,  $y+2);	
 		//aqui encontraré todos los niveles  esa rayita jejeje
 		
 		if ($pdf->GetY()>buscarPosicion($vector[$i]["id_padre"],$vector_coordenadas)){
 			$nro_hoja=$pdf->PageNo();
 			if (buscarNroHoja($vector[$i]["id_padre"],$vector_coordenadas)!=$pdf->PageNo()){
 				$pdf->Line($x-10,5,$x-10,$y);
 			}else{
 				$pdf->Line($x-10,buscarPosicion($vector[$i]["id_padre"],$vector_coordenadas),$x-10,$y);
 			}
 		
 		
 		}else{
 			$pdf->Line($x-10,5,$x-10,$y);
 		
 		}
 		
 		$funcionarios=ereg_replace("<br>","\n",$vector[$i]["funcionarios"]);
 		$pdf->SetFont('Arial','B',6);
 		$pdf->MultiCell(30,3,$vector[$i]["nombre_unidad"],1);
 		 $pdf->SetX((20*($nivel-1)));
 		$pdf->SetFont('Arial','',4);
 		//extraer el primer salto de linea.
 		//$funcionarios1=substr($funcionarios,0,2);
 		$funcionarios=substr($funcionarios,1,strlen($funcionarios));
 		$pdf->MultiCell(30,2,$funcionarios,1);
 		
 		$vector_coordenadas[$i][0]=$vector[$i]["id_unidad_organizacional"];//id-padre
 		$vector_coordenadas[$i][1]=$pdf->GetY();//posicion Y;
 		$vector_coordenadas[$i][2]=$pdf->PageNo();//posicion Y;

 		
 		//Aqui guardamos sus coordenadas de x y y preguntaremos al siguiente si es menor entonces que raye si no
 		$pdf->Ln(2);
 		
 		
		}
 		
$nivel;
$nivel_a_buscar;
$cant_niveles;	
$x_padre=0;
//dibujar lineas
//print_r($vector_coordenadas);
 function buscarPosicion($id_padre,$vector_coordenadas ){
		
 		for ($j=0;$j<count($vector_coordenadas);$j++){
 		
 			if ($vector_coordenadas[$j][0]==$id_padre){
 			   $y_padre=$vector_coordenadas[$j][1];
 			  
 			}
 		}
 		return $y_padre;
 	}	
 function buscarNroHoja($id_padre,$vector_coordenadas ){
		
 		for ($k=0;$k<count($vector_coordenadas);$k++){
 		
 			if ($vector_coordenadas[$k][0]==$id_padre){
 			   $y_nro_hoja=$vector_coordenadas[$k][2];
 			  
 			}
 		}
 		return $y_nro_hoja;
 	}	


$pdf->Output();




?>