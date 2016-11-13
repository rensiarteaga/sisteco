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

var $mayor_importe_debe=0;
var $mayor_importe_haber=0;
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
	$this->MultiCell(0,4,"LIBRO MAYOR ",0,'C');	
	$this->var_num_lineas=$this->var_num_lineas-1;

    $this->SetFont('Arial','I',8);
    $this->MultiCell(0,3,"(Expresado en ".$_SESSION['desc_moneda'].")",0,'C');
    $this->var_num_lineas=$this->var_num_lineas-1;
    $this->SetFont('Arial','I',7);
    $this->MultiCell(0,3,"Del ".$_SESSION['fecha_inicio_rep']." Al ".$_SESSION['fecha_final_rep'],0,'C');
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
    
		$this->Cell(15,3,"FECHA",1,0,'L',0);//fecha_cbte
		$this->Cell(20,3,"Nº CBTE",1,0,'L',0);//nro_cbte
		$this->Cell(60,3,"CONCEPTO",1,0,'L',0);//concepto_cbte
		$this->Cell(60,3,"DESCOMPOSICIÓN",1,0,'L',0);//desc_componentes
		$this->Cell(15,3,"DEBE",1,0,'L',0);//importe_debe
		$this->Cell(15,3,"HABER",1,0,'L',0);//importe_haber
		$this->Cell(15,3,"SALDO",1,0,'L',0);//saldo
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
 	    $sortcol = 'id_tt_tct_reporte_uo_epe_ot_cta_aux asc, id_reporte asc , nro_cbte';
 	   $sortdir = 'asc';
	 
	
	 
	$cond = new cls_criterio_filtro($decodificar);
//	$cond->add_criterio_extra("PRESUP.tipo_pres",$tipo_pres);
	 $criterio_filtro = $cond -> obtener_criterio_filtro();
	 //$criterio_filtro=$criterio_filtro." ";
	 
				
				
			 
	 
	 $res = $Custom->ListarMayorEpeUoOtCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,
														 $_SESSION['id_gestion'],$_SESSION['id_depto'],
														 $_SESSION['fecha_inicio'],$_SESSION['fecha_final'],
														 $_SESSION['sw_cuenta'],$_SESSION['sw_auxiliar'],$_SESSION['sw_epe'],$_SESSION['sw_uo'],$_SESSION['sw_ot'],
														 $_SESSION['id_cuenta_inicial'],$_SESSION['id_cuenta_final'],$_SESSION['id_auxiliar_inicial'],$_SESSION['id_auxiliar_final'],
														 $_SESSION['id_epe_inicial'],$_SESSION['id_epe_final'],$_SESSION['id_uo_inicial'],$_SESSION['id_uo_final'],
														 $_SESSION['id_ot_inicial'],$_SESSION['id_ot_final'],$_SESSION['sw_estado_cbte'],$sw_listado,$_SESSION['id_moneda'],$_SESSION['sw_actualizacion'] );
	 
	 
	  //echo $Custom->query; exit();
		 
	   if($res){
					 
				 	$data=$Custom->salida;

					 
					$bandera_inicial=1;
					$indice_data=1;
				 	foreach($data as $row)
					{	 
						
						 
						
						if ($row[4]=="0" && $row[2]=='-1' ) {
							
							
							 

							$this->matrizCabecera[$this->cabecera_indice]=$row[5];	
							$this->cabecera_indice=$this->cabecera_indice+1;
							
							
							if ($data[ $this->contador+1][2]!="-1") {
												if($this->mayor_importe_debe>0 ||$this->mayor_importe_haber>0){
													/*insertar totales*/
												$this->SetFont('Arial','',6);
												$this->SetXY(8, $this->posicionY);  
												$this->MultiCell(155,3,"TOTAL",'T',0,'L');	
												//$this->MultiCell(15,3, $this->posicionY,1,0,'J');	
												
												$this->SetXY(163, $this->posicionY); 
												$this->MultiCell(15,3,number_format($this->mayor_importe_debe,2),'T','R');	 
												$this->SetXY(178,$this->posicionY); 
												
												$this->MultiCell(15,3,number_format($this->mayor_importe_haber,2),'T','R');	 
												/*
												$this->SetXY(193, $this->posicionY); 
												$this->MultiCell(15,3,"",'T','R');	  
												*/
												
												
												$this->mayor_importe_debe=0;
												$this->mayor_importe_haber=0;
												}
								
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
						   $this->MultiCell(15,3,$row[3],'T',0,'L');	
						   //$this->MultiCell(15,3, $this->posicionY,1,0,'J');	
						    	
						   $this->SetXY(23, $this->posicionY); 
						   $this->MultiCell(20,3,$row[4],'T','C');	 
						   	 
						   $this->SetXY(163, $this->posicionY); 
						   $this->MultiCell(15,3,number_format($row[7],2),'T','R');	 
						   $this->SetXY(178,$this->posicionY); 
						   $this->MultiCell(15,3,number_format($row[8],2),'T','R');	 
						   $this->SetXY(193, $this->posicionY); 
						   $this->MultiCell(15,3,number_format($row[9],2),'T','R');	  
						   
						   
						  
						   
						  
						 
						   $this->SetXY(103, $this->posicionY); 
						   $this->MultiCell(60,3,$row[6],'T','J');
						   
						   $this->SetXY(43, $this->posicionY); 
						   $this->MultiCell(60,3,$row[5],'T','J');	 
						   $comprobante=ceil(strlen($row[5])/40);
						   $componente=ceil(strlen($row[6])/40);
						   
						   $maximo=$comprobante;
						   if ($comprobante<$componente) {
						   	 $maximo=$componente;
						   }
						   $this->posicionY=$this->posicionY+ ($maximo)*$this->diferencialY;
						   
						   
						   
						   
						   $posicionY_sig=$this->posicionY+ (ceil(strlen($data[ $this->contador+1][5])/40))*$this->diferencialY;
						   $this->Ln();
							//suma las columnas del debe y el haber
							$this->mayor_importe_debe=$this->mayor_importe_debe+$row[7];
							$this->mayor_importe_haber=$this->mayor_importe_haber+$row[8];
						    //imprime el ultimo total
						   
						   if (""==$data[$indice_data]) {
									if($this->mayor_importe_debe>0 ||$this->mayor_importe_haber>0){
												/*insertar totales*/
												$this->SetFont('Arial','',6);
												$this->SetXY(8, $this->posicionY);  
												$this->MultiCell(155,3,"TOTAL",'T',0,'L');	
												//$this->MultiCell(15,3, $this->posicionY,1,0,'J');	
												
												$this->SetXY(163, $this->posicionY); 
												$this->MultiCell(15,3,number_format($this->mayor_importe_debe,2),'T','R');	 
												$this->SetXY(178,$this->posicionY); 
												
												$this->MultiCell(15,3,number_format($this->mayor_importe_haber,2),'T','R');	 
												/*
												$this->SetXY(193, $this->posicionY); 
												$this->MultiCell(15,3,"",'T','R');	  
												*/
												
												
												$this->mayor_importe_debe=0;
												$this->mayor_importe_haber=0;
									}
						   }
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
					
					  //exit();	
		
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



 
