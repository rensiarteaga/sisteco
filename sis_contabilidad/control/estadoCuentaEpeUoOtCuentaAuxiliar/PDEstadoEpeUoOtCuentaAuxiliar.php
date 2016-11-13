<?php

session_start();
require('../../../lib/fpdf/fpdf.php');
require('../../../lib/funciones.inc.php');
include_once("../../../lib/configuracion.log.php");
include_once("../LibModeloContabilidad.php");
class PDF extends FPDF
{
		 
var $num_lineas=63;	
var $var_num_lineas=63;	
var $matrizCabecera= array();
var $reporte;
var $cabecera_indice=0;	 
var $contador=0;	
var $posicionY=0;
var $diferencialY=3;
var $sw_salto_pagina=0;
var $total_debe=0;
var $total_haber=0;
//Cabecera de página
function Header()
{
	$this->SetLeftMargin(8);//margen izquierdo
	$funciones = new funciones();
    //Logo
   
 }
function Cabecera($matrizCabecera)
{
	$this->SetLeftMargin(8);//margen izquierdo
	$funciones = new funciones();
	if ($this->sw_salto_pagina!=0){$this->AddPage('P');}
	if ($this->sw_salto_pagina==0){$this->sw_salto_pagina=1;}
	
	 
    //Logo
    
    	$this->Image('../../../lib/images/logo_reporte.jpg',170,5,36,10);
    
    //$this->Image('../../../lib/images/logo_reporte_factur.jpg',210,5);//llama al logo
    //Arial bold 15
    $this->SetFont('Arial','B',12);//tifo de fuente
    //Movernos a la derecha
	$this->posicionY=0;    
    $this->Ln();
    $this->SetFont('Arial','B',12);
    $this->SetXY(5,5);
	$this->MultiCell(0,4,"ESTADO DE CUENTAS ",0,'C');	
	$this->var_num_lineas=$this->var_num_lineas-1;

    $this->SetFont('Arial','I',8);
    $this->MultiCell(0,3,"(Expresado en ".$_SESSION['desc_moneda'].")",0,'C');
    $this->var_num_lineas=$this->var_num_lineas-1;
    $this->SetFont('Arial','I',7);
    $this->MultiCell(0,3," Del ".$_SESSION['fecha_inicio']." al ".$_SESSION['fecha_final_rep'],0,'C');
    $this->var_num_lineas=$this->var_num_lineas-1;  
    $this->posicionY=$this->posicionY+15;

    $this->Ln();
    $this->SetFont('Arial','I',7);
    //echo(print_r($matrizCabecera)); exit();
    
    //echo (count($matrizCabecera)); exit();
    
    for ($i=0; $i< count($matrizCabecera); $i++) {
		$this->Cell(50,3, $matrizCabecera[$i],0,'L');
		$this->posicionY=$this->posicionY+4;
		$this->Ln();
		$this->var_num_lineas=$this->var_num_lineas-1;
	}
	  $this->Ln(3);
    
		//$this->Cell(15,3,"FECHA",1,0,'L',0);//fecha_cbte
		//$this->Cell(20,3,"Nº CBTE",1,0,'L',0);//nro_cbte
		//$this->Cell(60,3,"CONCEPTO",1,0,'L',0);//concepto_cbte
		$this->Cell(90,3,"DESCOMPOSICIÓN",1,0,'L',0);//desc_componentes
		$this->Cell(25,3,"DEBE",1,0,'C',0);//importe_debe
		$this->Cell(25,3,"HABER",1,0,'C',0);//importe_haber
		$this->Cell(30,3,"SALDO DEBE",1,0,'C',0);//saldo
		$this->Cell(30,3,"SALDO HABER",1,0,'C',0);//saldo
		$this->posicionY=$this->posicionY+8;
	$this->Ln(3);					 
 
 
    
  }
  
  
//Pie de página
function Footer()
{
 	
	//Posición: a 1,5 cm del final
    
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //ip
    $ip = captura_ip();
    
    	//$this->line(8,$this->GetY(),273,$this->GetY()); 
	 //Número de página
    $fecha=date("d-m-Y");
	//hora
    $hora=date("H:i:s");
	$this->SetY(-15);
    $this->Cell(0,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L'); 
    $this->SetY(-15);
    $this->Cell(0,10,'Página '.$this->PageNo().' de {nb}',0,0,'C');     
    $this->SetY(-15);
    $this->Cell(0,10,'Fecha: '.$fecha ,0,0,'R');
    $this->ln(3);
    $this->Cell(0,10,'Hora: '.$hora ,0,0,'R');
    //fecha
   
}
 
 
function maestro()
{
	
 
	
	$Custom = new cls_CustomDBContabilidad();//$this->SetY(36);
	$this->SetLineWidth(.1);//ancho de las lineas 

	 $this->SetFont('Arial','',6);

	   $cant = 1000000;
 	   $puntero = 0;
 	   $sortcol = 'id_reporte';
 	   $sortdir = 'asc';
	 
	
	 
	$cond = new cls_criterio_filtro($decodificar);
//	$cond->add_criterio_extra("PRESUP.tipo_pres",$tipo_pres);
	 $criterio_filtro = $cond -> obtener_criterio_filtro();
	 //$criterio_filtro=$criterio_filtro." ";
	 
				
				
			 
	 
	 $res = $Custom->ListarEstadoEpeUoOtCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,
														 $_SESSION['id_gestion'],$_SESSION['id_depto'],
														 $_SESSION['fecha_inicio'],$_SESSION['fecha_final'],
														 $_SESSION['sw_cuenta'],$_SESSION['sw_auxiliar'],$_SESSION['sw_epe'],$_SESSION['sw_uo'],$_SESSION['sw_ot'],
														 $_SESSION['id_cuenta_inicial'],$_SESSION['id_cuenta_final'],$_SESSION['id_auxiliar_inicial'],$_SESSION['id_auxiliar_final'],
														 $_SESSION['id_epe_inicial'],$_SESSION['id_epe_final'],$_SESSION['id_uo_inicial'],$_SESSION['id_uo_final'],
														 $_SESSION['id_ot_inicial'],$_SESSION['id_ot_final'],$_SESSION['sw_estado_cbte'],$sw_listado,$_SESSION['id_moneda'] ,$_SESSION['sw_actualizacion']);
	 
	 
	  
		 
	   if($res){
					 
				 	$data=$Custom->salida;

					 
					$bandera_inicial=1;

				 	foreach($data as $row)
					{	 
						
						 
						
						if ($row[4]=="0" && $row[2]=='-1' ) {
							 

							$this->matrizCabecera[$this->cabecera_indice]=$row[5];	
							$this->cabecera_indice=$this->cabecera_indice+1;
							
							
							if ($data[ $this->contador+1][2]!="-1") {
								$this->Cabecera($this->matrizCabecera);
								$this->cabecera_indice=0;
								$this->Ln();							
							}
						   
						   
							 
						}
						else
						{
							 //$this->Cell(20,3,$row[0],0,0,'L',0);//id_tt_tct_reporte_uo_epe_ot_cta_aux
							 //$this->Cell(20,3,$row[1],0,0,'L',0);//id_reporte
							 //$this->Cell(20,3,$row[2],0,0,'L',0);//id_transaccion
							 $this->SetFont('Arial','',6);
						   $this->SetXY(8, $this->posicionY);  
						   $this->MultiCell(90,3,$row[6],'T','L','0');
						   
						   
						   	 
						   $this->SetXY(98, $this->posicionY); 
						   $this->MultiCell(25,3,number_format($row[7],2),'T','R');	 
						   $this->SetXY(123,$this->posicionY); 
						   $this->MultiCell(25,3,number_format($row[8],2),'T','R');	 
						   
						   
 
						   
						   
						   $this->SetXY(148, $this->posicionY);
						   IF ($row[7]>$row[8] ) {
						   	$this->MultiCell(30,3,number_format($row[7]-$row[8],2),'T','R');
						   }else $this->MultiCell(30,3,0,'T','R');	  
						   
						   
						   
						   $this->SetXY(178, $this->posicionY); 
						   IF ($row[8]>$row[7] ) {
						   	$this->MultiCell(30,3,number_format($row[8]-$row[7],2),'T','R');	  
						   }else $this->MultiCell(30,3,0,'T','R');	 
						   
						   $this->total_debe=$this->total_debe+$row[7] ;
						   $this->total_haber=$this->total_haber+$row[8] ;
						   
						  $this->posicionY=$this->posicionY+ (ceil(strlen($row[6])/40))*$this->diferencialY;
						   //echo isset($data[ $this->contador+1][4]);
						  
						 /*********************************************************************/
						 if (($data[ $this->contador+1][4]=="0" && $data[ $this->contador+1][2]=='-1')
						 //|| (isset($data[ $this->contador+1][4]) ==0 && isset( $data[$this->contador+1][2])==0 )
						 ) {
								 $this->SetXY(8, $this->posicionY);  
								   $this->MultiCell(90,3,"TOTAL",'T','L','0');
								   $this->SetXY(98, $this->posicionY); 
								   $this->MultiCell(25,3,number_format($this->total_debe,2),'T','R');	 
								   $this->SetXY(123,$this->posicionY); 
								   $this->MultiCell(25,3,number_format($this->total_haber,2),'T','R');	 
									
								   $this->SetXY(148, $this->posicionY);
								   IF ($this->total_debe>$this->total_haber ) {
								   	$this->MultiCell(30,3,number_format($this->total_debe-$this->total_haber,2),'T','R');
								   	
								   }else $this->MultiCell(30,3,0,'T','R');	  
								   
								   
								   $this->SetXY(178, $this->posicionY); 
								   IF ($this->total_haber>$this->total_debe ) {
								   	$this->MultiCell(30,3,number_format($this->total_haber-$this->total_debe,2),'T','R');	  
								   	
								   }else $this->MultiCell(30,3,0,'T','R');	
								   $this->total_debe=0;
								   $this->total_haber=0;	
						 } 
						 /*********************************************************************/
						   
						   
						   
						   
						   
						   $posicionY_sig=$this->posicionY+ (ceil(strlen($data[ $this->contador+1][6])/40))*$this->diferencialY;
						   $this->Ln();
							 //
		 					if ($this->posicionY>= 261 || $posicionY_sig >= 261){
		 						$this->Cabecera($this->matrizCabecera);
								$this->cabecera_indice=0;
								$this->Ln();	
		 					}
							 
						}
						 
				
					 $indice_data++;  	    
					 $bandera_inicial=0;  
					 $this->contador=$this->contador+1;
					}
					$this->SetXY(8, $this->posicionY);  
					$this->MultiCell(90,3,"TOTAL",'T','L','0');
					$this->SetXY(98, $this->posicionY); 
					$this->MultiCell(25,3,number_format($this->total_debe,2),'T','R');	 
					$this->SetXY(123,$this->posicionY); 
					$this->MultiCell(25,3,number_format($this->total_haber,2),'T','R');	 
					
					$this->SetXY(148, $this->posicionY);
					IF ($this->total_debe>$this->total_haber ) {
					$this->MultiCell(30,3,number_format($this->total_debe-$this->total_haber,2),'T','R');
					
					}else $this->MultiCell(30,3,0,'T','R');	  
					
					
					$this->SetXY(178, $this->posicionY); 
					IF ($this->total_haber>$this->total_debe ) {
					$this->MultiCell(30,3,number_format($this->total_haber-$this->total_debe,2),'T','R');	  
					
					}else $this->MultiCell(30,3,0,'T','R');	
					$this->total_debe=0;
					$this->total_haber=0;	
					 //  exit();	
		
	}
   
 
 //  	$this->line(8,$this->GetY(),273,$this->GetY()); 
    
    
	
    
	
}

    

}

 
	//Creación del objeto de la clase heredada
$pdf=new PDF('P','mm','Letter');// main (posicion de la pagina,unidad de medida,tamaño)

$pdf->AliasNbPages();//contador de pagina 

$pdf->AddPage('P');//para modificar la orienacion de la pagina
$pdf->SetMargins(10,10,10,10);
$pdf->SetAutoPageBreak(true,15);
$pdf->SetFont('Times','',12);
$pdf->maestro();//es una funcion en la cual se crea el reporte
//$pdf->FancyTable($header,$data);

//$pdf->SetRightMargin(10);
$pdf->Output();//mostrar el reporte
	

?>



 
