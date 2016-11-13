<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
//include_once("../../rcm_LibModeloAlmacenes.php");
include_once("../../LibModeloControlAsistencia.php");
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{    //Cargar los datos
	//Cabecera de página

	function Header()
	{	global $title;
	$this->SetLeftMargin(15);
	$funciones = new funciones();
	//Logo
	$this->Image('../../../../lib/images/logo_reporte.jpg',230,4,30,10);
	$this->Ln(8);
		$this->SetLineWidth(.1);

		$this->SetFont('Arial','B',12);
		$this->Cell(255,10,'ENTRADA / SALIDA DIARIA',0,0,'C');
		$this->Ln(7);
		$this->SetFont('Arial','B',10);
		$this->Cell(30,8,'FUNCIONARIO:',0,0,'L');
		$this->SetFont('Arial','',10);
		$this->Cell(170,8,$_SESSION['funcionario'],0,0,'L');
		$this->Ln(7);
		$this->SetFont('Arial','B',10);
		$this->Cell(20,8,'DESDE:',0,0,'L');
		$this->SetFont('Arial','',10);
		$this->Cell(30,8,cambiarFormatoFecha($_SESSION['fecha_desde'],1),0,0,'L');
		$this->SetFont('Arial','B',10);
		$this->Cell(20,8,'HASTA:',0,0,'L');
		$this->SetFont('Arial','',10);
		$this->Cell(30,8,cambiarFormatoFecha($_SESSION['fecha_hasta'],1),0,0,'L');
		$this->SetFont('Arial','',6);
		$this->Cell(130,8,'Donde: E A.M.= Entrada A.M. , S A.M.= Salida A.M. , E P.M.= Entrada P.M. , S P.M.= Salida P.M.',0,0,'R');
		$this->Ln(8);
		$this->SetDrawColor(103,113,157);
		$this->SetFillColor(253,184,19);
		$this->SetFont('Arial','B',8);		
		$this->Cell(20,8,'FECHA',1,0,'C',1);
		$this->Cell(20,8,'DIA',1,0,'C',1);
		$this->Cell(25,8,'E A.M.(Depurada)',1,0,'C',1);
		$this->Cell(25,8,'E A.M.(Marcada)',1,0,'C',1);
		$this->Cell(25,8,'S A.M.(Depurada)',1,0,'C',1);
		$this->Cell(25,8,'S A.M.(Marcada)',1,0,'C',1);
		$this->Cell(25,8,'E P.M.(Depurada)',1,0,'C',1);
		$this->Cell(25,8,'E P.M.(Marcada)',1,0,'C',1);
		$this->Cell(25,8,'S P.M.(Depurada)',1,0,'C',1);
		$this->Cell(25,8,'S P.M.(Marcada)',1,0,'C',1);
		$this->Ln(8);
	}

	function Footer()
	{	//Posición: a 1,5 cm del final
		$this->SetY(-15);
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
		$this->Cell(200,10,'Hora: '.$hora ,0,0,'L');
		
	}

  	/////////////////////////////////////////////////////////////////////////////
  	function LoadData($id_empleado,$fecha_ini,$fecha_fin)
	{     $cant=10000;
		  $puntero=0;
	      $sortcol='lr.fecha';
	      $sortdir='asc';
		  $criterio_filtro="lr.id_empleado=".$id_empleado;
		  $criterio_filtro=$criterio_filtro." AND lr.fecha >= ''$fecha_ini''";
	      $criterio_filtro=$criterio_filtro." AND lr.fecha <= ''$fecha_fin''";			
		 
		
           	//Leer las líneas del fichero
	
	$Custom=new cls_CustomDBControlAsistencia();
	$Custom->ListarDetalleMarcadasDepuradas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$var1=$Custom->salida;
	return $var1;
	}

	//Tabla coloreada
	function FancyTable($data)
	{  
				
		
		
	    $this->SetLineWidth(.1);//grosor de la linea
		//Cabecera
	  	$this->SetFont('Arial','B',8);
		$w=array(20,20,25,25,25,25,25,25,25,25);
			//Datos					
			$this->SetFont('Arial','',8);
			$i=1;	
			$this->SetDrawColor(103,113,157);
		    $this->SetFillColor(221,221,221);            	        
	        foreach($data as $row){
	        	$relleno=0;
	        	    if($i%2==0){
	        	    	$relleno=1;
	        	    }
	        	    $this->Cell($w[0],5,cambiarFormatoFecha($row[1],0),1,0,'C',$relleno);//desc_valor_activo 
				    $this->Cell($w[1],5,$row[2],1,0,'C',$relleno);//desc_detalle
					$this->Cell($w[2],5,$row[4],1,0,'C',$relleno);//desc_ret_incor
					$this->Cell($w[3],5,$row[5],1,0,'C',$relleno);//desc_ret_incor
					$this->Cell($w[4],5,$row[6],1,0,'C',$relleno);//desc_ret_incor
					$this->Cell($w[5],5,$row[7],1,0,'C',$relleno);//desc_ret_incor
					$this->Cell($w[6],5,$row[8],1,0,'C',$relleno);//desc_ret_incor
					$this->Cell($w[7],5,$row[9],1,0,'C',$relleno);//desc_ret_incor
					$this->Cell($w[8],5,$row[10],1,0,'C',$relleno);//desc_ret_incor
					$this->Cell($w[9],5,$row[11],1,0,'C',$relleno);//desc_ret_incor
					$this->Ln(5);
					$i=$i+1;
			}
					      
	}

}
function cambiarFormatoFecha($fecha,$band){ 
    if($band==0){
    list($anio,$mes,$dia)=explode("-",$fecha); 
    return $dia."-".$mes."-".$anio;	
    }
	 else{
	 	list($mes,$dia,$anio)=explode("/",$fecha); 
    return $dia."/".$mes."/".$anio;
	 }
}
$pdf=new PDF('L','mm','Letter');
$pdf->AliasNbPages();
//Títulos de las columnas
        $id_empleado=$id_empleado;
		$fecha_ini=$fecha_ini;
		$fecha_fin=$fecha_fin;
$data=$pdf->LoadData($id_empleado,$fecha_ini,$fecha_fin);
  	/*echo($fecha_inicio);
	exit();*/
$pdf->SetFont('Arial','',12);
$pdf->SetAutoPageBreak(1,35);
$pdf->SetTopMargin(15);
$pdf->SetRightMargin(10);
$pdf->SetLeftMargin(10);
$pdf->AddPage();
$pdf->FancyTable($data);
$pdf->Output();
?>