<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
//include_once("../../rcm_LibModeloAlmacenes.php");
include_once("../../LibModeloActivoFijo.php");
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{    
	function Header()
	{	global $title;
	$this->SetLeftMargin(15);
	$funciones = new funciones();
	$this->Image('../../../../lib/images/logo_reporte.jpg',170,2,36,13);
	}

	function Footer()
	{		
		//Posición: a 1,5 cm del final
		$this->SetY(-22);
		//Arial italic 8
		$this->SetFont('Arial','B',7);
		//$this->Cell(10,4,'',0,0,'L');
		$this->Cell(95,4,$_SESSION['rep_af_responsable_af'],0,0,'C');
		$this->Cell(95,4,$_SESSION['rep_af_nombre_empleado'],0,0,'C');
		$this->ln(4);
		//$this->Cell(10,4,'',0,0,'L');
		$this->Cell(95,4,'Responsable Unidad de Activos Fijos',0,0,'C');
		//$this->Cell(20,4,'',0,0,'L');
		$this->Cell(95,4,'Responsable',0,0,'C');
		$this->ln(5);
		$this->SetFont('Arial','I',6);
		$fecha=date("d-m-Y");
		$hora=date("H:i:s");
		$this->Cell(90,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L');
		$this->Cell(80,10,'Página '.$this->PageNo().' de {nb}',0,0,'L');
		$this->Cell(70,10,'Fecha: '.$fecha ,0,0,'L');
		$this->ln(3);
		$this->Cell(70,10,'',0,0,'L');
		$this->Cell(100,10,'',0,0,'L');
		$this->Cell(170,10,'Hora: '.$hora ,0,0,'L');
		
	}

	/////////////////////////////////////////////////////////////////////////////

	function LoadData($id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado)
	{   
    $cant=10000;
	$puntero=0;
	$criterio_filtro="EMP.id_empleado=".$id_empleado;			
	
	//Leer las líneas del fichero
	$Custom=new cls_CustomDBActivoFijo();
	$Custom->ListarAsignacionResponsableActivo($cant,$puntero,'actif.codigo',$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$var1=$Custom->salida;
	return $var1;
	    /*echo $id_empleado;
	    exit;*/
	}

	//Tabla coloreada
	function FancyTable($header,$data,$id_empleado)
	{ 
		$this->SetDrawColor(190,190,190);
		$this->SetLineWidth(.1);
		
		$this->SetFont('Arial','B',12);
		//Movernos a la derecha
		$this->Cell(190,6,'ACTIVOS FIJOS BAJO RESPONSABILIDAD',0,0,'C');
		$this->Ln(10);
		$num=count($data);
	    $pag=0;
	   	$pag=$pag+1;
     	$this->SetFont('Arial','B',7);
		$this->Cell(30,4,'Responsable:',0,0,'L');
		$this->Cell(55,4,$_SESSION['rep_af_nombre_empleado'],0,0,'L');
		$this->Ln(3);
		$this->Cell(30,4,'Cargo :',0,0,'L');
		$this->Cell(55,4,$_SESSION['rep_af_cargo'],0,0,'L');
		$this->Ln(3);
		$this->Cell(30,4,'Unidad Organizacional :',0,0,'L');
		$this->Cell(55,4,$_SESSION['rep_af_unidad_organizacional'],0,0,'L');
		$this->Ln(6);
	 
	     //Leer las líneas del fichero
	     $this->SetFont('','B',6);
         $data1=array();
         $cont=1;
                 foreach($data as $d){
                     	 $aux=array();
                     	 array_push($aux,$cont);
        	     
        	           for($i=0;$i<12;$i++){
        	             array_push($aux,$d[$i]);
        	                 }
        	              $cont++;
        	              array_push($data1,$aux);
        	               }
        	               $data=$data1;
                           
       	                    //$this->SetWidths(array(10,20,90,50,18));
       	                    $this->SetWidths(array(10,15,30,70,45,18));
		                    $this->SetAligns( array('C','C','C','C','C','C'));// para centrear los titulos del header
        	                
		                    
		                     $y=$this->GetY();
		                     $this->susana($header);
		                     $y2=$this->GetY();
		                            	                        		                    
		                     $this->SetFont('','',5);//tamaño de la letra del detalle
		                     $this->SetAligns( array('C','L','L','L','L','R'));// para convertir el centrado lado izquierdo
		                     
		                     foreach ($data as $d)
		                        {  	$y=$this->GetY();
		                           $this->susana($d);
			                        $y2=$this->GetY();
			                    
		                        }
			                 
		                     ////para adicionar una pagina		                         
		                  /*  $rama_nombre=array();
		                      if($pag<$num){
		                    $this->AddPage();	
		                    }*/
			}//Fin funcion fancy table
}//Fin Clase PDF
$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
//Títulos de las columnas
$header=array('Nro.','CÓDIGO','DENOMINACIÓN','DESCRIPCIÓN','UBICACIÓN FÍSICA','FECHA ASIG.');//toodo lo que quiero mostrar en mis columnas
 /*echo $id_empleado;
	exit;*/
$data=$pdf->LoadData($id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado);

$pdf->SetFont('Arial','',18);
$pdf->SetAutoPageBreak(1,42);
$pdf->SetTopMargin(15);
$pdf->SetRightMargin(10);
$pdf->SetLeftMargin(10);
$pdf->AddPage();
$pdf->FancyTable($header,$data,$id_empleado);
$pdf->Output();
?>