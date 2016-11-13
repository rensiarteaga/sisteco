<?php

session_start();

require('../../../lib/fpdf/fpdf.php');
//require('../../../lib/fpdf/mc_table.php');
define('FPDF_FONTPATH','font/');
class PDF extends FPDF
{   
	function PDF($orientation='L',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    //Iniciación de variables
    }
 
function Header()
{
    $this->Image('../../../lib/images/logo_reporte.jpg',230,2,35,15);
    $this->Ln(10);
}
//Pie de página
function Footer()
{
  $fecha=date("d-m-Y");
	$hora=date("h:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
   	   // $this->Cell(200,0.2,'',1,1);
		$this->Cell(100,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(70,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		//$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(100,3,'Sistema: ENDESIS -COMPRO',0,0,'L');
		$this->Cell(70,3,'',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
}

//Cabecera de página

}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf-> AddFont('Tahoma','','tahoma.php');
$pdf-> AddFont('Arial','','arial.php');
$pdf->SetAutoPageBreak(true,7);

//-----------------------Primera Factura
$pdf->SetFont('Tahoma','',10);
$pdf->SetLeftMargin(15);
$pdf->SetFont('Arial','B',14);

/*Aqui declararemos todas las funciones obtenidas del control */
$proveedores =$_SESSION['PDF_proveedores'];
$items = $_SESSION['PDF_items'];
$totales = $_SESSION['PDF_totales'];

$plazos  = $_SESSION['PDF_plazos'];
$lugares_entrega = $_SESSION['PDF_lugares_entrega'];
$forma_pago = $_SESSION['PDF_forma_pago'];
$tiempo_validez = $_SESSION['PDF_tiempo_validez'];
$garantia =  $_SESSION['PDF_garantia'];
$observaciones = $_SESSION['PDF_observaciones'];
$size_proveedor=count($proveedores);   
$tam_item=count($items);
$cua_com_cab=$_SESSION['PDF_cuacomcab'];
$tipo_adquisicion=$_SESSION['tipo_adq'];
$tabla_aimprimir= array();
//print_r($cua_com_cab);
$num_solicitud='';
for($v=0;$v<count($cua_com_cab);$v++){
	$fecha_hoy=$cua_com_cab[$v][1];
	if($v==0){
	$num_solicitud=$num_solicitud.$cua_com_cab[$v][0];
	}else{
	$num_solicitud=$num_solicitud.','.$cua_com_cab[$v][0];	
	}
	
}



if($tipo_adquisicion=='Bien'){
    $firma_resp_bys='Responsable Bienes';
}else{
    $firma_resp_bys='Responsable Servicios';
}

$m_porcentaje=$_SESSION['m_porcentaje'];
//$pdf->SetFont('Arial','B',16);
for($u=1;$u<=ceil($size_proveedor/3);$u++){//aqui empieza el for
//$pdf->Cell(10,10,'tantas cosas que mostrar',0,1,'C');
//$pdf->AddPage();	
$pdf->SetFont('Arial','B',16);
$pdf->Cell(250,10,'CUADRO COMPARATIVO DE OFERTAS',0,1,'C');
$pdf->SetFont('Arial','',8);
//$fecha1=date_create ($fecha_hoy); 
//$fecha=date_format( $fecha1,'d/m/Y');
$pdf->SetX(50);
$pdf->Cell(70,5,'',0,0,'L');
$pdf->Cell(60,5,'Expresado en '.$_SESSION['ss_moneda_principal'].'',0,1,'L');
$pdf->SetX(50);
$pdf->Cell(250,5,'Nº Solicitud: '. $num_solicitud,0,1,'L');
$pdf->SetX(50);
$pdf->Cell(250,5,'',0,1,'L');
//$pdf->Cell(250,5,'Gerencia:Gerenca Negocios y Exportaciones.0',1,1,'C');
	if((ceil($size_proveedor/3))==$u) {
        $pdf->SetDrawColor(0,0,0);
        //$pdf->SetLineWidth(0);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(10,10,'Nro',1,0); 
        $pdf->Cell(70,10,'Descripción del '.$_SESSION['PDF_titulo'],1,0); 
        $pdf->Cell(15,10,'Cant. S.',1,0); 
        $pdf->Cell(15,10,'Unidad',1,0);

        for ($j=(3*$u)-3;$j<$size_proveedor;$j++){   
	       $pdf->Cell(45,5,preview_text($proveedores[$j][1],25,0),1,0);
        }
        $pdf->SetXY(125,43.7);
        $variable = array(10,70,15,15,15,15,15);
        $variable_visibles = array(1,1,1,1,1,1,1);
        $variable_fonts_sizes=array(8,8,8,8,8,8,8);
        $variable_spaces=array(4,4,4,4,4,4,4);
        $variable_align=array('R','L','R','R','R','R','R');
        $variable_decimales=array(0,0,0,0,0,2,2);
	
        $l=6;
        for ($k=(3*$u)-3;$k<$size_proveedor;$k++){ 
            $pdf->Cell(15,5,'Cant. Cot.',1,0);		
	        $pdf->Cell(15,5,'Precio U.',1,0);
	        $pdf->Cell(15,5,'Precio T.',1,0);
	
        	$variable[$l]=15;
        	$variable[$l+1]=15;
        	$variable[$l+2]=15;
        	$variable_visibles[$l]=1;
        	$variable_visibles[$l+1]=1;
        	$variable_visibles[$l+2]=1;
        	$variable_fonts_sizes[$l]=8;
        	$variable_fonts_sizes[$l+1]=8;
        	$variable_fonts_sizes[$l+2]=8;
        	$variable_spaces[$l]=4;
        	$variable_spaces[$l+1]=4;
        	$variable_spaces[$l+2]=4;
        	$variable_align[$l]='R';
        	$variable_align[$l+1]='R';
        	$variable_align[$l+2]='R';
        	$variable_decimales[$l]=2;
        	$variable_decimales[$l+1]=0;
        	$variable_decimales[$l+2]=2;
        	
        	$l=$l+3;
        }
        /* este array es para definir las posiciones de las observaciones */

	        $variable_observaciones=array(10,70,15,15,45);
        	$variable_fonts_obs_sizes=array(8,8,8,8,8);
        	$variable_obs_spaces=array(4,4,4,4,4);
        	$variable_observaciones_visibles=array(1,1,1,1,1);
        	$variable_align_obs=array('R','L','R','R','J');

	        $l1=4;
            for ($k=(3*$u)-3;$k<$size_proveedor;$k++){ 
                $variable_observaciones[$l1+1]=45;
            	$variable_fonts_obs_sizes[$l1+1]=8;
            	$variable_obs_spaces[$l1+1]=4;
            	$variable_observaciones_visibles[$l1+1]=1;
            	$variable_align_obs[$l1+1]='J';
            	$l1=$l1+1;
            }


            $pdf->Ln(5);

            $pdf->SetFont('Arial','',8); 


            $data=$_SESSION['PDF_cuacom_det'];
            //nuevo array donde se acomodaran los datos
            
            //cuantos items por cada proceso de compra
            
            //aqui armo la tabla donde ya estara listo para imprimir
            /*print_r($data);
            exit; */
            
            /*echo sizeof($data);
            exit;*/
            $prov=0;
            $m=0;
            //$m1=0;
            //$o=4;
            /*$tipo_celda=array();
            $tipo_celda[0]=0;
            $tipo_celda[1]=1;
            $align=array();
            $align[0]='R';	
            $align[1]='R';	*/
            for($i=0;$i<(count($data)/$size_proveedor);$i++){
	               $o=4;
	               $d=6;
	               $r=1;
	               $s=0;
	               $o1=3;
	
		              for($l=(((3*$u)-3)+$prov);$l<=(($size_proveedor+$prov)-1);$l++){
		                  
		            	    $tabla_aimprimir[$m][0]=$i+1;
                		    $tabla_aimprimir[$m][1]=$data[$l][2];
                		    $tabla_aimprimir[$m][2]=$data[$l][3];
                		    $tabla_aimprimir[$m][3]=$data[$l][4];
                		    $tabla_aimprimir[$m][$o]=$data[$l][7]; 
                		    $tabla_aimprimir[$m][$o+1]=$data[$l][5];  
                		    $tabla_aimprimir[$m][$o+2]=$data[$l][6];  
                		   
                            $tabla_aimprimir_obs[$m][0]="";
                		    $tabla_aimprimir_obs[$m][1]="";
                		    $tabla_aimprimir_obs[$m][2]="";
                		    $tabla_aimprimir_obs[$m][3]="";
                		    
                		      
		                    $tabla_aimprimir_obs[$m][$o1+1]=$data[$l][9];
	   
                		    $o=$o+3;
                		    $o1=$o1+1;
                		    $tipo_celda1[$d]=1;
                		    $align1[$d]='R';
                		    $d=$d+1;
                		    $tipo_celda[$r]=1;
                		    $align[$r]='R';
                		    $r=$r+1;
                		    $s=$s+1;
                		   // echo $u;
                		   //  print_r($data[$l]);
                		    // echo "\n";
               // exit;
               		}
                		
                		
	               $prov=$prov+$size_proveedor;
	               $m=$m+1;
	       }
                    
	       
	       
	       //$pdf->SetFont('Arial','',8);

                    /* aqui calculamos para el tamaño de linea de acuerdo a los proveedores */
                if (($size_proveedor % ($u * 3))==0){
	                   $tam_linea=3;
                }else{
                    if(((3*$u)-$size_proveedor)<2){
                          $tam_linea=(((3*$u)-$size_proveedor)+1);	
                    }else{
                          $tam_linea=(((3*$u)-$size_proveedor)-1);	
                    }
                    
                }
                
                
                
                /* fin del cálculo de $tam_linea */
                //aqui estoy haciendo imprimir para mostrar en pdf
                /*print_r($tabla_aimprimir);
                exit;*/
               
                for($i1=0;$i1<count($tabla_aimprimir);$i1++){
                       $y=$pdf->GetY();
                       $pdf->SetWidths($variable);
                       $pdf->SetVisibles($variable_visibles);
                       $pdf->SetFontsSizes($variable_fonts_sizes);
                       $pdf->SetSpaces($variable_spaces);
                       $pdf->SetDecimales($variable_decimales);
                       $pdf->SetAligns($variable_align);
                       $pdf->MultiTabla($tabla_aimprimir[$i1],1,1,4,8); 
                       
                       $pdf->SetWidths($variable_observaciones);
                       $pdf->SetVisibles($variable_observaciones_visibles);
                       $pdf->SetFontsSizes($variable_fonts_obs_sizes);
                       $pdf->SetSpaces($variable_obs_spaces);
                       $pdf->SetAligns($variable_align_obs);
                       //$pdf->SetLineWidth(0.1);
                       $pdf->SetX(125);
                       $pdf->Cell(45*$tam_linea,0.01,'',1,1,'L',1);
                      // $pdf->MultiTabla($tabla_aimprimir_obs[$i1],1,1,4,8); 
                       $pdf->SetWidths($variable);
                       $pdf->Cell(110+45*$tam_linea,0.01,'',1,1,'L',1);
                       
                 }

                 //primera celda
                 $pdf->SetFillColor(0,0,0);
                    /*if(((3*$u)-$size_proveedor)<2){
                    $pdf->Cell(120 +(40*(((3*$u)-$size_proveedor)+1)),0.15,'',1,1,'L',1);	
                    }else{
                    	$pdf->Cell(120 +(40*(((3*$u)-$size_proveedor)-1)),0.15,'',1,1,'L',1);
                    }*/

                   // $pdf->Cell(110 +(45*$tam_linea),0.15,'',1,1,'L',1);
                    $pdf->SetFillColor(200,200,200);
                    
                    
                    //se define los parametros de los siguientes resultados
                    $variable1 = array(110);
                    $variable1_visibles = array(1);	
                    $variable1_fonts_sizes = array(8);	
                    $variable1_spaces=array(4);
                    $variable1_align=array('R');
                    	$l1=1;
                    for ($n=0;$n<$size_proveedor;$n++){ 
                        	$variable1[$l1]=45;
                        	$variable1_visibles[$l1]=1;
                        	$variable1_fonts_sizes[$l1]=8;
                        	$variable1_spaces[$l1]=4;
                        	$variable1_align[$l1]='L';
                        	$l1=$l1+1;
                    }
                    $pdf->SetWidths($variable1);
                    $pdf->SetVisibles($variable1_visibles);
                    $pdf->SetFontsSizes($variable1_fonts_sizes);
                    $pdf->SetSpaces($variable1_spaces);
                    $pdf->SetAligns($variable1_align);
                    
                    $pdf->SetFillColor(0,0,0);
                    $pdf->Cell(115 +(40*$tam_linea),0.15,'',1,1,'L',1);
                     $o4=1;
                     
                      for($l4=((3*$u)-3);$l4<$size_proveedor;$l4++){
                             $tabla_plazo_entrega[0][0]='Plazo de Entrega';
                    	     $tabla_plazo_entrega[0][$o4]=$plazos[$l4][1];
                    	     $o4=$o4+1;
                    	}
                    

   

                      //  $pdf->MultiTabla($tabla_plazo_entrega[0],1,1,4,8);
                        $pdf->SetFillColor(0,0,0);
                        $pdf->Cell(120 +(40*$tam_linea),0.15,'',1,1,'L',1);
                        
//los listado de lugar entrega por proveedor y proceso de compra
                         $o5=1;
                             for($l5=((3*$u)-3);$l5<$size_proveedor;$l5++){
                                 $tabla_lugar_entrega[0][0]='Lugar de Entrega';
                        	     $tabla_lugar_entrega[0][$o5]=$lugares_entrega[$l5][1];
                        	     $o5=$o5+1;
                        		}

                            //$pdf->SetWidths($variable1);
                            $pdf->MultiTabla($tabla_lugar_entrega[0],1,1,4,8);
                        $pdf->SetFillColor(0,0,0);
                        $pdf->Cell(120 +(40*$tam_linea),0.15,'',1,1,'L',1);
                        $pdf->SetFillColor(200,200,200);
                        //Forma de pago por proveedor y proceso de compra
                        //$pdf->SetWidths($variable1);
                         $o6=1;
                             for($l6=((3*$u)-3);$l6<$size_proveedor;$l6++){
                                 $tabla_forma_pago[0][0]='Forma de Pago';
                        	     $tabla_forma_pago[0][$o6]=$forma_pago[$l6][1];
                        	     $o6=$o6+1;
                        		}
                        
                            $pdf->MultiTabla($tabla_forma_pago[0],1,1,4,8);
                        $pdf->SetFillColor(0,0,0);
                        $pdf->Cell(120 +(40*$tam_linea),0.15,'',1,1,'L',1);
                        $pdf->SetFillColor(200,200,200);
                        //Validez de la oferta por proveedor y proceso de compra.
                        //$pdf->SetWidths($variable1);
                         $o7=1;
                             for($l7=((3*$u)-3);$l7<$size_proveedor;$l7++){
                                 $tabla_validez_oferta[0][0]='Validez de la oferta';
                        	     $tabla_validez_oferta[0][$o7]=$tiempo_validez[$l7][1];
                        	     $o7=$o7+1;
                        		}
                            $pdf->MultiTabla($tabla_validez_oferta[0],1,1,4,8);
                        $pdf->SetFillColor(0,0,0);
                        $pdf->Cell(120 +(40*$tam_linea),0.15,'',1,1,'L',1);
                        $pdf->SetFillColor(200,200,200);
                        //Garantia por proveedor y proceso de compra
                        //$pdf->SetWidths($variable1);
                         $o8=1;
                             for($l8=((3*$u)-3);$l8<$size_proveedor;$l8++){
                                 $tabla_garantia[0][0]='Garantia';
                        	     $tabla_garantia[0][$o8]=$garantia[$l8][1];
                        	     $o8=$o8+1;
                        		}
                           $pdf->MultiTabla($tabla_garantia[0],1,1,4,8);
                        $pdf->SetFillColor(0,0,0);
                        $pdf->Cell(120 +(40*$tam_linea),0.15,'',1,1,'L',1);
                         $pdf->SetFillColor(200,200,200);
                        //Observaciones por proceso y proveedor de compra
                        //$pdf->SetWidths($variable1);
                         $o9=1;
                             for($l9=((3*$u)-3);$l9<$size_proveedor;$l9++){
                                 $tabla_observaciones[0][0]='Observaciones';
                        	     $tabla_observaciones[0][$o9]=$observaciones[$l9][1].'                                                                                                                                 ';
                        	     $o9=$o9+1;
                        		}
                        $pdf->MultiTabla($tabla_observaciones[0],1,1,4,8);
                        $pdf->SetFillColor(0,0,0);
                        $pdf->Cell(120 +(40*$tam_linea),0.15,'',1,1,'L',1);
                        
                        
                        
                        
                
$pdf->Ln(15);                        

$pdf->Cell(120,5,'___________________________________',0,0,'C'); 
$pdf->Cell(120,5,'___________________________________',0,1,'C'); 
$pdf->SetFont('Arial','B',10);

//$pdf->Cell(45,5,'Receptor Centro','LBR',0,'C'); 
$pdf->Cell(120,5,''.$firma_resp_bys.'',0,0,'C'); 
$pdf->Cell(120,5,'Jefe Depto. Bienes y Servicios  ',0,1,'C');
$pdf->Ln(10);
$pdf->Cell(25,5,'Recomendación de Adjudicación:',0,1);
$pdf->Ln(5);

$pdf->Cell(250,5,'_______________________________________________________________________________________________________________________________',0,1,'L');

$pdf->Cell(250,5,'_______________________________________________________________________________________________________________________________',0,1,'L');

$pdf->Cell(250,5,'_______________________________________________________________________________________________________________________________',0,1,'L');

$pdf->Cell(250,5,'_______________________________________________________________________________________________________________________________',0,1,'L');

$pdf->Cell(250,5,'_______________________________________________________________________________________________________________________________',0,1,'L');
                 
                        
                        
                        
         } else {
                        		
                        $pdf->SetDrawColor(0,0,0);
                        //$pdf->SetLineWidth(0);
                        $pdf->SetFont('Arial','B',8);
                        $pdf->Cell(10,10,'Nro',1,0); 
                        $pdf->Cell(70,10,'Descripción del '.$_SESSION['PDF_titulo'],1,0); 
                        $pdf->Cell(15,10,'Cantidad',1,0); 
                        $pdf->Cell(15,10,'Unidad',1,0);
                         
                        for ($j=(3*$u)-3;$j<=(3*$u)-1;$j++)
                        {   
                        	$pdf->Cell(45,5,preview_text($proveedores[$j][1],25,0),1,0);
                        }
                        $pdf->SetXY(125,43.7);
                        
                        $variable = array(10,70,15,15,15,15,15);
                        $variable_visibles = array(1,1,1,1,1,1,1);
                        $variable_fonts_sizes=array(8,8,8,8,8,8,8);
                        $variable_spaces=array(4,4,4,4,4,4,4);
                        $variable_align=array('R','L','R','R','R','R','R');
                        $variable_decimales=array(0,0,0,0,0,2,2);
                        	
                         $l2=6;
                            for ($k2=(3*$u)-3;$k2<=(3*$u)-1;$k2++)
                        	{ 
                            $pdf->Cell(15,5,'Cant. Cot.',1,0);		
                        	$pdf->Cell(15,5,'Precio U.',1,0);
                        	$pdf->Cell(15,5,'Precio T.',1,0);
                        	
                        	$variable[$l2]=15;
                        	$variable[$l2+1]=15;
                        	$variable[$l2+2]=15;
                        	$variable_visibles[$l2]=1;
                        	$variable_visibles[$l2+1]=1;
                        	$variable_visibles[$l2+2]=1;
                        	$variable_fonts_sizes[$l2]=8;
                        	$variable_fonts_sizes[$l2+1]=8;
                        	$variable_fonts_sizes[$l2+2]=8;
                        	$variable_spaces[$l2]=4;
                        	$variable_spaces[$l2+1]=4;
                        	$variable_spaces[$l2+2]=4;
                        	$variable_align[$l2]='R';
                        	$variable_align[$l2+1]='R';
                        	$variable_align[$l2+2]='R';
                        	$variable_decimales[$l2]=2;
                        	$variable_decimales[$l2+1]=0;
                        	$variable_decimales[$l2+2]=2;
                        	
                        	$l2=$l2+3;
                        }
                        /* este array es para definir las posiciones de las observaciones */
                        
                        	$variable_observaciones=array(10,70,15,15,45);
                        	$variable_fonts_obs_sizes=array(8,8,8,8,8);
                        	$variable_obs_spaces=array(4,4,4,4,4);
                        	$variable_observaciones_visibles=array(1,1,1,1,1);
                        	$variable_align_obs=array('R','L','R','R','J');
                        
                        	$l1=4;
                            for ($k1=(3*$u)-3;$k1<=(3*$u)-1;$k1++)
                        	{ 
                            $variable_observaciones[$l1+1]=45;
                        	$variable_fonts_obs_sizes[$l1+1]=8;
                        	$variable_obs_spaces[$l1+1]=4;
                        	$variable_observaciones_visibles[$l1+1]=1;
                        	$variable_align_obs[$l1+1]='J';
                        	$l1=$l1+1;
                            }
                        $pdf->Ln(5);
                        
                        $pdf->SetFont('Arial','',8); 
                        
                        $data=$_SESSION['PDF_cuacom_det'];
                        $k2=0;
                        $m=0;
                        //$o=4;
                        /*$tipo_celda1=array(0,0,0,0,1,1,1);
                        
                        $align1=array('R','L','R','R','R','R');
                        $tipo_celda=array();
                        $tipo_celda[0]=0;
                        $tipo_celda[1]=1;
                        $align=array();
                        $align[0]='R';	
                        $align[1]='R';	*/
                        
                        for($i=0;$i<(count($data)/$size_proveedor);$i++){
                        	$o=4;
                        	$d=6;
                        	$r=1;
                        	$s=0;
                        	$o1=3;
                        	for($l1=((3*$u)-3)+$k2;$l1<((3*$u))+$k2;$l1++){
                        		
                        		//for($l=(((3*$u)-3)+$k);$l<=(($size_proveedor+$k)-1);$l++){
                        		    $tabla_aimprimir1[$m][0]=$i+1;
                        		    $tabla_aimprimir1[$m][1]=$data[$l1][2];
                        		    $tabla_aimprimir1[$m][2]=$data[$l1][3];
                        		    $tabla_aimprimir1[$m][3]=$data[$l1][4];
                        		    $tabla_aimprimir1[$m][$o]=$data[$l1][7]; 
                        		    $tabla_aimprimir1[$m][$o+1]=$data[$l1][5];  
                        		    $tabla_aimprimir1[$m][$o+2]=$data[$l1][6];  
                        		   
                        		    $tabla_aimprimir_obs1[$m][0]="";
                        		    $tabla_aimprimir_obs1[$m][1]="";
                        		    $tabla_aimprimir_obs1[$m][2]="";
                        		    $tabla_aimprimir_obs1[$m][3]="";
                        		      
                        		 //   $tabla_aimprimir_obs1[$m][$o1+1]="Observaciones: Cada empresario tiene mayor responsabilidad y tienen un buen curriculum";
                        	       $tabla_aimprimir_obs1[$m][$o1+1]=$data[$l][9];
                        	       //"Observaciones: Cada empresario tiene mayor responsabilidad y tienen un buen curriculum";
                        	   
                        		    $o=$o+3;
                        		    $o1=$o1+1;
                        		    $tipo_celda1[$d]=1;
                        		    $align1[$d]='R';
                        		    $d=$d+1;
                        		    $tipo_celda[$r]=1;
                        		    $align[$r]='R';
                        		    $r=$r+1;
                        		    $s=$s+1;
                        		}
                        		
                        		
                        	$k2=$k2+$size_proveedor;
                        	$m=$m+1;
                        	
                        	
                        	
                        	
                        }
                        
                        for($i1=0;$i1<count($tabla_aimprimir1);$i1++)
                         {
                           //$y=$pdf->GetY();
                           $pdf->SetWidths($variable);
                           $pdf->SetVisibles($variable_visibles);
                           $pdf->SetFontsSizes($variable_fonts_sizes);
                           $pdf->SetSpaces($variable_spaces);
                           $pdf->SetDecimales($variable_decimales);
                           $pdf->SetAligns($variable_align);
                           $pdf->MultiTabla($tabla_aimprimir1[$i1],1,1,4,8); 
                           
                           $pdf->SetWidths($variable_observaciones);
                           $pdf->SetVisibles($variable_observaciones_visibles);
                           $pdf->SetFontsSizes($variable_fonts_obs_sizes);
                           $pdf->SetSpaces($variable_obs_spaces);
                           $pdf->SetAligns($variable_align_obs);
                           //$pdf->SetLineWidth(0.1);
                           $pdf->SetX(125);
                           $pdf->Cell(45*3,0.01,'',1,1,'L',1);
                           //$pdf->MultiTabla($tabla_aimprimir_obs1[$i1],1,1,4,8); 
                           $pdf->SetWidths($variable);
                           $pdf->Cell(110+45*3,0.01,'',1,1,'L',1);
                           //$pdf->Cell(120 +(40*3),0.15,'',1,1,'L',1);
                        
                         }
                        
                         //primera celda
                        $pdf->SetFillColor(0,0,0);
                        $pdf->Cell(120 +(40*3),0.15,'',1,1,'L',1);
                        $pdf->SetFillColor(200,200,200);
                        
                        //aqui estara el costo total de los proveedores
                        //el importe neto.
                        // el impuesto de ley
                        /*$itemProveedor= array();
                        $itemProveedor[0]=1;
                        $itemProveedor[1]=2;
                        */
                        
                        
                        $variable1 = array(110);
                        $variable1_visibles = array(1);	
                        $variable1_fonts_sizes = array(8);	
                        $variable1_spaces=array(4);
                        $variable1_align=array('R');
                        	$l1=1;
                        for ($n=0;$n<$size_proveedor;$n++)
                        	{ 
                        	$variable1[$l1]=45;
                        	$variable1_visibles[$l1]=1;
                        	$variable1_fonts_sizes[$l1]=8;
                        	$variable1_spaces[$l1]=4;
                        	$variable1_align[$l1]='L';
                        	$l1=$l1+1;
                        }
                        $pdf->SetWidths($variable1);
                        $pdf->SetVisibles($variable1_visibles);
                        $pdf->SetFontsSizes($variable1_fonts_sizes);
                        $pdf->SetSpaces($variable1_spaces);
                        $pdf->SetAligns($variable1_align);
                        
                        $pdf->SetFillColor(0,0,0);
                        $pdf->Cell(120 +(40*3),0.15,'',1,1,'L',1);
                        $o4=1;
                             for($l4=((3*$u)-3);$l4<(3*$u);$l4++){
                                 $tabla_plazo_entrega1[0][0]='Plazo de Entrega';
                        	     $tabla_plazo_entrega1[0][$o4]=$plazos[$l4][1];
                        	     $o4=$o4+1;
                        		}
                        //$pdf->MultiTabla($tabla_plazo_entrega1[0],1,1,4,8);
                        $pdf->SetFillColor(0,0,0);
                        $pdf->Cell(120 +(40*3),0.15,'',1,1,'L',1);
                        
                        //los listado de lugar entrega por proveedor y proceso de compra
                         $o5=1;
                             for($l5=((3*$u)-3);$l5<(3*$u);$l5++){
                                 $tabla_lugar_entrega1[0][0]='Lugar de Entrega';
                        	     $tabla_lugar_entrega1[0][$o5]=$lugares_entrega[$l5][1];
                        	     $o5=$o5+1;
                        		}
                         
                            $pdf->MultiTabla($tabla_lugar_entrega1[0],1,1,4,8);
                        $pdf->SetFillColor(0,0,0);
                        $pdf->Cell(120 +(40*3),0.15,'',1,1,'L',1);
                        $pdf->SetFillColor(200,200,200);
                        //Forma de pago por proveedor y proceso de compra
                        //$pdf->SetWidths($variable1);
                         $o6=1;
                             for($l6=((3*$u)-3);$l6<(3*$u);$l6++){
                                 $tabla_forma_pago1[0][0]='Forma de Pago';
                        	     $tabla_forma_pago1[0][$o6]=$forma_pago[$l6][1];
                        	     $o6=$o6+1;
                        		}
                        //
                            $pdf->MultiTabla($tabla_forma_pago1[0],1,1,4,8);
                        $pdf->SetFillColor(0,0,0);
                        $pdf->Cell(120 +(40*3),0.15,'',1,1,'L',1);
                        $pdf->SetFillColor(200,200,200);
                        //Validez de la oferta por proveedor y proceso de compra.
                        //$pdf->SetWidths($variable1);
                         $o7=1;
                             for($l7=((3*$u)-3);$l7<(3*$u);$l7++){
                                 $tabla_validez_oferta1[0][0]='Validez de la oferta';
                        	     $tabla_validez_oferta1[0][$o7]=$tiempo_validez[$l7][1];
                        	     $o7=$o7+1;
                        		}
                        		
                            $pdf->MultiTabla($tabla_validez_oferta1[0],1,1,4,8);
                        $pdf->SetFillColor(0,0,0);
                        $pdf->Cell(120 +(40*3),0.15,'',1,1,'L',1);
                        $pdf->SetFillColor(200,200,200);
                        //Garantia por proveedor y proceso de compra
                        //$pdf->SetWidths($variable1);
                         $o8=1;
                             for($l8=((3*$u)-3);$l8<(3*$u);$l8++){
                                 $tabla_garantia1[0][0]='Garantia';
                        	     $tabla_garantia1[0][$o8]=$garantia[$l8][1];
                        	     $o8=$o8+1;
                        		}
                        
                           $pdf->MultiTabla($tabla_garantia1[0],1,1,4,8);
                        $pdf->SetFillColor(0,0,0);
                        $pdf->Cell(120 +(40*3),0.15,'',1,1,'L',1);
                        $pdf->SetFillColor(200,200,200);
                        //Observaciones por proceso y proveedor de compra
                        //$pdf->SetWidths($variable1);
                         $o9=1;
                             for($l9=((3*$u)-3);$l9<(3*$u);$l9++){
                                 $tabla_observaciones1[0][0]='Observaciones';
                        	     $tabla_observaciones1[0][$o9]=$observaciones[$l9][1];
                        	     $o9=$o9+1;
                        		}
                        		
                            $pdf->MultiTabla($tabla_observaciones1[0],1,1,4,8);
                        $pdf->SetFillColor(0,0,0);
                        $pdf->Cell(120 +(40*3),0.15,'',1,1,'L',1);
                        	
                        }
$pdf->SetFont('Arial','B',10);   
$pdf->Cell(92,15,'',0,0,'C');
$pdf->Cell(93,15,'',0,1,'C');
/*$pdf->Cell(45,5,'','TLR',0,'C');
$pdf->Cell(45,5,'','TLR',1,'C');
*/

/*$pdf->Cell(45,5,'___________________','LR',0,'C'); 
$pdf->Cell(45,5,'___________________','LR',1,'C'); 
*
/*$pdf->Cell(45,5,'-------','LR',0,'C'); 
$pdf->Cell(45,5,'Mario Ayma Rodriguez','LR',1,'C'); 
*/


$pdf->SetFillColor(200,200,200);

if($u==ceil($size_proveedor/3)){
}else{
$pdf->AddPage();		
}


} /*acaba el for */
function preview_text($TEXT, $LIMIT, $TAGS = 0) {

    // TRIM TEXT
    $TEXT = trim($TEXT);

    // STRIP TAGS IF PREVIEW IS WITHOUT HTML
    if ($TAGS == 0) $TEXT = preg_replace('/\s\s+/', ' ', strip_tags($TEXT));

    // IF STRLEN IS SMALLER THAN LIMIT RETURN
    if (strlen($TEXT) < $LIMIT) return $TEXT;

    if ($TAGS == 0) return substr($TEXT, 0, $LIMIT) . " ...";
    else {

        $COUNTER = 0;
        for ($i = 0; $i<= strlen($TEXT); $i++) {

            if ($TEXT{$i} == "<") $STOP = 1;

            if ($STOP != 1) {

                $COUNTER++;
            }

            if ($TEXT{$i} == ">") $STOP = 0;
            $RETURN .= $TEXT{$i};

            if ($COUNTER >= $LIMIT && $TEXT{$i} == " ") break;

        }

        return $RETURN . "...";
    }

}

$pdf->Output();
?>