<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
//include_once("../../rcm_LibModeloAlmacenes.php");
include_once("../../LibModeloActivoFijo.php");
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{    //Cargar los datos
	//Cabecera de página

	function Header()
	{	global $title;
	$this->SetLeftMargin(15);
	$funciones = new funciones();
	//Logo
	$this->Image('../../../../lib/images/logo_reporte.jpg',230,2,36,13);
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
  	function LoadData($id_financiador,$id_regional,$id_programa,$id_proyecto,$fecha_inicio,$fecha_fin)
	{     $cant=20;
	      $puntero=0;
	      $sortcol='actif.codigo';
	      $sortdir='asc';
	      
           	//Leer las líneas del fichero
	
	$Custom=new cls_CustomDBActivoFijo();
	$Custom->ListarCuadroEP($cant,$puntero,$sortcol,$sortdir,'0=0',$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_inicio,$fecha_fin);
	$var1=$Custom->salida;
	return $var1;
	}

	//Tabla coloreada
	function FancyTable($header,$data)
	{  $this->SetDrawColor(190,190,190);
		$this->SetLineWidth(.1);

		$this->SetFont('Arial','B',12);
		$this->Cell(255,10,'CUADRO DE ACTIVO FIJO',0,0,'C');
		$this->Ln(7);
		$this->SetFont('Arial','B',10);
		$this->Cell(255,8,'AL  '.$_SESSION['rep_af_incor_dia'].' DE  '.$_SESSION['rep_af_incor_nombre_mes'].'  DE  '.$_SESSION['rep_af_incor_gestion_fin'],0,0,'C');
		$this->Ln(6);
		$this->SetFont('Arial','B',8);
		$this->Cell(255,8,'(EXPRESADO EN UFV)',0,0,'C');
		$this->Ln(6);
		
	 foreach($data as $row){
		$this->SetFont('Arial','B',6);
		$this->Cell(20,5,'Financiador:',0,0,'L');
		$this->Cell(55,5,$row[1],0,0,'L');
		$this->Ln(4);
		$this->Cell(20,5,'Regional:',0,0,'L');
		$this->Cell(55,5,$row[3],0,0,'L');
		$this->Ln(4);
		$this->Cell(20,5,'Programa:',0,0,'L');
		$this->Cell(55,5,$row[5],0,0,'L');
		$this->Ln(4);
		$this->Cell(20,5,'Proyecto:',0,0,'L');
		$this->Cell(55,5,$row[7],0,0,'L');
		$this->Ln(6);
		//Colores, ancho de línea y fuente en negrita
		  $cant=20;
	      $puntero=0;
	      $sortcol='actif.codigo';
	      $sortdir='asc';
	      	
			$Custom=new cls_CustomDBActivoFijo();
	        $Custom->ListarCuadro($cant,$puntero,$sortcol,$sortdir,'0=0',$row[0],$row[2],$row[4],$row[6],$row[8], $_SESSION['rep_af_incor_fecha_inicio'],$_SESSION['rep_af_incor_fecha_fin']);
	        $var1=$Custom->salida;
			 $this->SetLineWidth(.1);//grosor de la linea
		   		
	  	//Cabecera
	  	$this->SetFont('Arial','B',10);
		$w=array(40,20,20,20,20,20,20,20,20,20,20,15);
			$this->SetFont('Arial','',5);
			//Datos
					
			for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],7,$header[$i],1,0,'C');
			$this->Ln(8);
		            $suma_desc_valor_activo=0;//desc_valor_activo
		           	$suma_desc_ret_incor=0;//desc_ret_incor
					$suma_actualiz=0;//actualiz
					$suma_valor_actualiz=0;//valor_actualiz
					$suma_depreciacion_acum_ant=0;//depreciacion_acum_ant
					$suma_dep_actualiz=0;//dep_actualiz
					$suma_dep_valor_actuliz=0;//dep_valor_actuliz
					$suma_depreciacion=0;//depreciacion
					$suma_depreciacion_acum=0;//depreciacion_acum
					$suma_monto_vigente=0;//monto_vigente
					$suma_desc_vida_util=0;//desc_vida_util
	        
	        foreach($var1 as $row){
				     $this->Cell($w[0],8,$row[0],'LRTB',0,'L');//desc_detalle
					$this->Cell($w[1],8,$row[1],'LRTB',0,'R');//desc_valor_activo 
					$this->Cell($w[2],8,$row[2],'LRTB',0,'R');//desc_ret_incor
					$this->Cell($w[3],8,$row[3],'LRTB',0,'R');//actualiz
					$this->Cell($w[4],8,$row[4],'LRTB',0,'R');//valor_actualiz
					$this->Cell($w[5],8,$row[5],'LRTB',0,'R');//depreciacion_acum_ant
                    $this->Cell($w[6],8,$row[6],'LRTB',0,'R');//dep_actualiz
                    $this->Cell($w[7],8,$row[7],'LRTB',0,'R');//dep_valor_actuliz
                    $this->Cell($w[8],8,$row[8],'LRTB',0,'R');//depreciacion
                    $this->Cell($w[9],8,$row[9],'LRTB',0,'R');//depreciacion_acum
                    $this->Cell($w[10],8,$row[10],'LRTB',0,'R');//monto_vigente
                    $this->Cell($w[11],8,$row[11],'LRTB',0,'R');//desc_vida_util
					$this->Ln(8);
					
					$suma_desc_valor_activo      =$suma_desc_valor_activo+$row[1];//desc_valor_activo
					$suma_desc_ret_incor         =$suma_desc_ret_incor+$row[2];//desc_ret_incor
					$suma_actualiz               =$suma_actualiz+$row[3];//actualiz
					$suma_valor_actualiz         =$suma_valor_actualiz+$row[4];//valor_actualiz
					$suma_depreciacion_acum_ant  =$suma_depreciacion_acum_ant+$row[5];//depreciacion_acum_ant
					$suma_dep_actualiz           =$suma_dep_actualiz+$row[6];//dep_actualiz
					$suma_dep_valor_actuliz      =$suma_dep_valor_actuliz+$row[7];//dep_valor_actuliz
					$suma_depreciacion           =$suma_depreciacion+$row[8];//depreciacion
					$suma_depreciacion_acum      =$suma_depreciacion_acum+$row[9];//depreciacion_acum
					$suma_monto_vigente          =$suma_monto_vigente+$row[10];//monto_vigente
					$suma_desc_vida_util         =$suma_desc_vida_util+$row[11];//desc_vida_util
			}
			
		       $this->SetFont('Arial','B',7);			
			   $this->Cell($w[0],8,'TOTAL','LRTB',0,'L');//
			   $this->SetFont('Arial','',6);
			   $this->Cell($w[1],8,$suma_desc_valor_activo,'LRTB',0,'R');//
			   $this->Cell($w[2],8,$suma_desc_ret_incor,'LRTB',0,'R');//
			   $this->Cell($w[3],8,$suma_actualiz,'LRTB',0,'R');//
			   $this->Cell($w[4],8,$suma_valor_actualiz,'LRTB',0,'R');//
			   $this->Cell($w[5],8,$suma_depreciacion_acum_ant,'LRTB',0,'R');//
     		   $this->Cell($w[6],8,$suma_dep_actualiz,'LRTB',0,'R');//
			   $this->Cell($w[7],8,$suma_dep_valor_actuliz,'LRTB',0,'R');//
			   $this->Cell($w[8],8,$suma_depreciacion,'LRTB',0,'R');//
			   $this->Cell($w[9],8,$suma_depreciacion_acum,'LRTB',0,'R');//
			   $this->Cell($w[10],8,$suma_monto_vigente,'LRTB',0,'R');//
			   $this->Cell($w[11],8,$suma_desc_vida_util,'LRTB',0,'R');//     
			    
			   $this->AddPage();//para adicionar una pagina a una nueva EP				
			
		}
	 
				
	}

}

$pdf=new PDF('L','mm','Letter');
$pdf->AliasNbPages();
//Títulos de las columnas
$header=array('DETALLE','VALOR ACTIF','RET INCOR','ACTUALIZ','VALOR TOTAL','DEP ACUM INI','ACTUALIZ','DEP ACUM ACT','DEP GESTION','DEP ACUM','VALOR NETO','VIDA UTIL');//toodo lo que quiero mostrar en mis columnas
/*echo $fecha_inicio;
exit;*/
$data=$pdf->LoadData($id_financiador,$id_regional,$id_programa,$id_proyecto,$fecha_inicio,$fecha_fin);
  	/*echo($fecha_inicio);
	exit();*/
$pdf->SetFont('Arial','',12);
$pdf->SetAutoPageBreak(1,35);
$pdf->SetTopMargin(15);
$pdf->SetRightMargin(10);
$pdf->SetLeftMargin(10);
$pdf->AddPage();
$pdf->FancyTable($header,$data);
$pdf->Output();
?>