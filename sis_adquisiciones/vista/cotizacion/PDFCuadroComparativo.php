<?php
/*Autor: Ana Maria villegas
  Fecha ultima de actulizacion 14/07/09
  Descripcion ultima mod: Se añadió el campo observaciones adjudicacion
*/
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
	$hora=date("H:i:s");
	    $this->SetY(-10);
   	    $this->SetFont('Arial','',6);
   	    $this->Cell(100,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(70,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(100,3,'Sistema: ENDESIS - COMPRO',0,0,'L');
		$this->Cell(70,3,'',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
		$this->ln(3);
		$this->Cell(70,3,sha1(gregoriantojd(date('m'),date('d'),date('Y')).$hora),0,1,'L');
    }

}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf-> AddFont('Arial','','arial.php');
$pdf->SetAutoPageBreak(true,10);

//$pdf->SetFont('Tahoma','',10);
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
$array_cuacom_det=$_SESSION['PDF_cuacom_det'];
$tabla_aimprimir= array();

$num_solicitud='';
for($v=0;$v<count($cua_com_cab);$v++){
	$fecha_hoy=$cua_com_cab[$v][1];
	$tipo_adq=$cua_com_cab[$v][2];
	$nro_proceso=$cua_com_cab[$v][4];
	$cod_proceso=$cua_com_cab[$v][3];
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
/* Hasta  aqui la declaración de variables obtenidas 
 * Empezamos con el número de paginas que se va a obtener
 * $u es el número de hojas eso es dependiendo de la cantidad de proveedores que existe siempre dividiendo entre 3*/
for($u=1;$u<=ceil($size_proveedor/3);$u++){
// ************************cabecera del reporte ***********************************************
$pdf->setY(7);
$pdf->SetFont('Arial','B',6);
 $pdf->Cell(50,5,'ORIGINAL',0,1);
 $pdf->Ln(1.6);
$pdf->SetFont('Arial','B',16);
$pdf->Cell(250,10,'CUADRO COMPARATIVO DE OFERTAS',0,1,'C');
$pdf->SetFont('Arial','',8);
$pdf->SetX(50);
$pdf->Cell(70,4,'',0,0,'L');
$pdf->Cell(60,4,'Expresado en '.$_SESSION['ss_moneda_principal'].'',0,1,'L');
$pdf->SetX(35);
$pdf->Cell(70,4,'',0,0,'L');
$pdf->Cell(60,4,'Formato: Compacto',0,1,'C');
$pdf->Cell(50,4,'Nº Proceso: '. $nro_proceso,0,0,'L');
$pdf->Cell(140,4,'Codigo Proceso: '. $cod_proceso,0,0,'L');
$pdf->Cell(50,4,'Nº Solicitud: '. $num_solicitud,0,1,'L');



$pdf->Cell(250,3,'',0,1,'L');
     /*Esto es para la ultima hoja por ejemplo si tenemos dos proveedores $u será 1 si son 6 proveedores $u sera 2  
      * ingresará a este expresión siempre y cuando sea el ultimo por ejemplo si son 6 proveedores para cuando $u sea igual a 2
      */
	if((ceil($size_proveedor/3))==$u) {
		/*********************** cabecera del cuadro *********** dibujo la primera parte de la cabecera del cuadro*******/
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(10,10,'Nro',1,0); 
        $pdf->Cell(70,10,'Descripción del '.$_SESSION['PDF_titulo'],1,0); 
        $pdf->Cell(15,10,'Cant. S.',1,0); 
        $pdf->Cell(15,10,'Unidad',1,0);
        //dependiendo del tamaño de los proveedores  formará el resto de la cabecera del cuadro
        for ($a=(3*$u)-3;$a<$size_proveedor;$a++){   
	       $pdf->Cell(45,5,preview_text($proveedores[$a][1],25,0),1,0);
        }
        
        //Se definen los anchos de columna,espacios, alineación requisitos para MultiTabla
     
        $variable = array(10,70,15,15,15,15,15);
        $variable_visibles = array(1,1,1,1,1,1,1);
        $variable_fonts_sizes=array(8,8,8,8,8,8,8);
        $variable_spaces=array(3.5,3.5,3.5,3.5,3.5,3.5,3.5);
        $variable_align=array('R','L','R','R','R','R','R');
        $variable_decimales=array(0,0,0,0,0,2,2);
	    $indice_array=6; //para que el array prosiga desde ese indice
        
	    $pdf->SetXY(125,43.7);
        //esto es para definir dinamicamente dependiendo de los proveedores
        for ($b=(3*$u)-3;$b<$size_proveedor;$b++){ 
            $pdf->Cell(15,5,'Cant. Cot.',1,0);		
	        $pdf->Cell(15,5,'Precio U.',1,0);
	        $pdf->Cell(15,5,'Precio T.',1,0);
	
        	$variable[$indice_array]=15;
        	$variable[$indice_array+1]=15;
        	$variable[$indice_array+2]=15;
        	$variable_visibles[$indice_array]=1;
        	$variable_visibles[$indice_array+1]=1;
        	$variable_visibles[$indice_array+2]=1;
        	$variable_fonts_sizes[$indice_array]=8;
        	$variable_fonts_sizes[$indice_array+1]=8;
        	$variable_fonts_sizes[$indice_array+2]=8;
        	$variable_spaces[$indice_array]=4;
        	$variable_spaces[$indice_array+1]=4;
        	$variable_spaces[$indice_array+2]=4;
        	$variable_align[$indice_array]='R';
        	$variable_align[$indice_array+1]='R';
        	$variable_align[$indice_array+2]='R';
        	$variable_decimales[$indice_array]=2;
        	$variable_decimales[$indice_array+1]=0;
        	$variable_decimales[$indice_array+2]=2;
        	
        	$indice_array=$indice_array+3;
        }
        /* este array es para definir las anchos de columna,espacios y alineación para la tabla de Observaciones*/
        $variable_observaciones=array(10,70,15,15,45);
       	$variable_fonts_obs_sizes=array(8,8,8,8,8);
       	$variable_obs_spaces=array(3.5,3.5,3.5,3.5,3.5);
       	$variable_observaciones_visibles=array(1,1,1,1,1);
       	$variable_align_obs=array('R','L','R','R','J');
       	  
         //esto es para definir dinamicamente dependiendo de los proveedores
	        $indice_array_obs=4;
            for ($c=(3*$u)-3;$c<$size_proveedor;$c++){ 
                $variable_observaciones[$indice_array_obs+1]=45;
            	$variable_fonts_obs_sizes[$indice_array_obs+1]=8;
            	$variable_obs_spaces[$indice_array_obs+1]=4;
            	$variable_observaciones_visibles[$indice_array_obs+1]=1;
            	$variable_align_obs[$indice_array_obs+1]='J';
            	$indice_array_obs=$indice_array_obs+1;
            }
/*******************************Hasta aqui la definición de datos y cabecera del cuadro comparativo************************************/
            $pdf->Ln(5);
            $pdf->SetFont('Arial','',8); 
            $indice_prov=0;   //esta variable es la que saltara al indice del mismo item pero otro proveedor
            $indice_tai=0;    //indice de la tabla a imprimir
            
           for($d=0;$d<(count($array_cuacom_det)/$size_proveedor);$d++){
	               $colum_dinamica=4;      // esta variable sirve para que crezca las columnas dinamicamente empieza por 4 porque ya existe 4 columnas definidas las sgtes serán dinamicamente
	               $colum_dinamica_obs=3;
	              for($e=(((3*$u)-3)+$indice_prov);$e<=(($size_proveedor+$indice_prov)-1);$e++){
		                  
		            	    $tabla_aimprimir[$indice_tai][0]=$d+1;
                		    $tabla_aimprimir[$indice_tai][1]=$array_cuacom_det[$e][2];
                		    $tabla_aimprimir[$indice_tai][2]=$array_cuacom_det[$e][3];
                		    $tabla_aimprimir[$indice_tai][3]=$array_cuacom_det[$e][4];
                		    $tabla_aimprimir[$indice_tai][$colum_dinamica]=$array_cuacom_det[$e][7]; 
                		    $tabla_aimprimir[$indice_tai][$colum_dinamica+1]=$array_cuacom_det[$e][5];  
                		    $tabla_aimprimir[$indice_tai][$colum_dinamica+2]=$array_cuacom_det[$e][6];  
                		   
                            $tabla_aimprimir_obs[$indice_tai][0]="";
                		    $tabla_aimprimir_obs[$indice_tai][1]="";
                		    $tabla_aimprimir_obs[$indice_tai][2]="";
                		    $tabla_aimprimir_obs[$indice_tai][3]="";
                		    $tabla_aimprimir_obs[$indice_tai][$colum_dinamica_obs+1]=$array_cuacom_det[$e][9];
	            		    $colum_dinamica=$colum_dinamica+3;
                		    $colum_dinamica_obs=$colum_dinamica_obs+1;
                	
               		}
                	
	               $indice_prov=$indice_prov+$size_proveedor;
	               $indice_tai=$indice_tai+1;
	       }
/****************** Se obtiene el tamaño de linea de acuerdo a los proveedores **********************/
                if (($size_proveedor % ($u * 3))==0){
	                   $tam_linea=3;
                }else{
                    if(((3*$u)-$size_proveedor)<2){
                          $tam_linea=(((3*$u)-$size_proveedor)+1);	
                    }else{
                          $tam_linea=(((3*$u)-$size_proveedor)-1);	
                    }
                    
                }
                
 /********************** Dibujo de la Tabla del Cuadro Comparativo **************************/               
               
                for($f=0;$f<count($tabla_aimprimir);$f++){
                       $y=$pdf->GetY();
                       //Definición de espacios,letra,decimales y anchos para el detalle
                       $pdf->SetWidths($variable);
                       $pdf->SetVisibles($variable_visibles);
                       $pdf->SetFontsSizes($variable_fonts_sizes);
                       $pdf->SetSpaces($variable_spaces);
                       $pdf->SetDecimales($variable_decimales);
                       $pdf->SetAligns($variable_align);
                       
                       $pdf->MultiTabla($tabla_aimprimir[$f],1,1,3.5,8); 
                       //************Para la parte de Observaciones
                       $pdf->SetWidths($variable_observaciones);
                       $pdf->SetVisibles($variable_observaciones_visibles);
                       $pdf->SetFontsSizes($variable_fonts_obs_sizes);
                       $pdf->SetSpaces($variable_obs_spaces);
                       $pdf->SetAligns($variable_align_obs);
                       $pdf->SetX(125);
                       $pdf->Cell(45*$tam_linea,0.01,'',1,1,'L',1);
                       if($tipo_adquisicion=='Servicio')
                       {
                         $pdf->MultiTabla($tabla_aimprimir_obs[$f],1,1,3.5,8); //////////// 	
                       }
                      
                       $pdf->SetWidths($variable);
                       $pdf->Cell(110+45*$tam_linea,0.01,'',1,1,'L',1);
                       
                 }
                 //$pdf->SetFillColor(200,200,200);
/************************* Fin De la Primera parte del Cuadro Comparativo *********************/   
/************************** Definición de variables para observaciones para lugar de entrega ********************/              
                   $variable1 = array(110);
                    $variable1_visibles = array(1);	
                    $variable1_fonts_sizes = array(8);	
                    $variable1_spaces=array(4);
                    $variable1_align=array('R');
                    
                    $indice_inf=1; //indice de inicio para lugar 
                    for ($g=0;$g<$size_proveedor;$g++){ 
                        	$variable1[$indice_inf]=45;
                        	$variable1_visibles[$indice_inf]=1;
                        	$variable1_fonts_sizes[$indice_inf]=8;
                        	$variable1_spaces[$indice_inf]=4;
                        	$variable1_align[$indice_inf]='L';
                        	$indice_inf=$indice_inf+1;
                    }
                    $pdf->SetWidths($variable1);
                    $pdf->SetVisibles($variable1_visibles);
                    $pdf->SetFontsSizes($variable1_fonts_sizes);
                    $pdf->SetSpaces($variable1_spaces);
                    $pdf->SetAligns($variable1_align);
                    
                  
/************************************************* Impresion de Plazo de Entrega **********************************/                    
                    $pdf->Cell(115 +(40*$tam_linea),0.05,'',1,1,'L',1);
                     
                    $indice_plazo=1;
                     
                      for($h=((3*$u)-3);$h<$size_proveedor;$h++){
                             $tabla_plazo_entrega[0][0]='Plazo de Entrega';
                    	     $tabla_plazo_entrega[0][$indice_plazo]=$plazos[$h][1];
                    	     $indice_plazo=$indice_plazo+1;
                    	}
                       $pdf->MultiTabla($tabla_plazo_entrega[0],1,3,4,8);
 /*******************************  Impresión de Lugar de Entrega ***************************************************/                      
                       $indice_lugar=1;
                             for($i=((3*$u)-3);$i<$size_proveedor;$i++){
                                 $tabla_lugar_entrega[0][0]='Lugar de Entrega';
                        	     $tabla_lugar_entrega[0][$indice_lugar]=$lugares_entrega[$i][1];
                        	     $indice_lugar=$indice_lugar+1;
                        		}
                        $pdf->MultiTabla($tabla_lugar_entrega[0],1,3,4,8);
/******************************* Impresión de Forma de Pago ********************************************************/
                        $indice_forma=1;
                             for($j=((3*$u)-3);$j<$size_proveedor;$j++){
                                 $tabla_forma_pago[0][0]='Forma de Pago';
                        	     $tabla_forma_pago[0][$indice_forma]=$forma_pago[$j][1];
                        	     $indice_forma=$indice_forma+1;
                        		}
                        
                        $pdf->MultiTabla($tabla_forma_pago[0],1,3,4,8);
                                         
/******************************* Impresión de Validez Oferta ********************************************************/
                        
                         $indice_validez=1;
                             for($k=((3*$u)-3);$k<$size_proveedor;$k++){
                                 $tabla_validez_oferta[0][0]='Validez de la oferta';
                        	     $tabla_validez_oferta[0][$indice_validez]=$tiempo_validez[$k][1];
                        	     $indice_validez=$indice_validez+1;
                        		}
                        $pdf->MultiTabla($tabla_validez_oferta[0],1,3,4,8);
               
                        
/****************************** Impresión de Garantia ****************************************************************/
                         $indice_garantia=1;
                             for($l=((3*$u)-3);$l<$size_proveedor;$l++){
                                 $tabla_garantia[0][0]='Garantia';
                        	     $tabla_garantia[0][$indice_garantia]=$garantia[$l][1];
                        	     $indice_garantia=$indice_garantia+1;
                        		}
                        $pdf->MultiTabla($tabla_garantia[0],1,3,4,8);
                 
/******************************  Impresion de Observaciones ***************************************************/                         
                        $indice_observaciones=1;
                             for($m=((3*$u)-3);$m<$size_proveedor;$m++){
                                 $tabla_observaciones[0][0]='Observaciones';
                        	     $tabla_observaciones[0][$indice_observaciones]=$observaciones[$m][1].'                                                                                                                                 ';
                        	     $indice_observaciones=$indice_observaciones+1;
                        		}
                        $pdf->MultiTabla($tabla_observaciones[0],1,3,4,8);
                       
$pdf->Ln(15);                        

$pdf->Cell(120,5,'___________________________________',0,0,'C'); 
$pdf->Cell(120,5,'___________________________________',0,1,'C'); 
$pdf->SetFont('Arial','B',10);

//$pdf->Cell(240,5,''.$firma_resp_bys.'',0,1,'C'); 
$pdf->Cell(120,5,'Representante Unidad Solicitante  ',0,0,'C');
$pdf->Cell(120,5,'Representante Unidad de Bienes y Servicios  ',0,1,'C');
$pdf->Ln(10);
$pdf->Cell(25,5,'Recomendación de Adjudicación:',0,1);
$pdf->Ln(5);
if ($_SESSION['PDF_observaciones_adjudicacion']=='')
{
$pdf->Cell(250,5,'_______________________________________________________________________________________________________________________________',0,1,'L');

$pdf->Cell(250,5,'_______________________________________________________________________________________________________________________________',0,1,'L');

$pdf->Cell(250,5,'_______________________________________________________________________________________________________________________________',0,1,'L');

$pdf->Cell(250,5,'_______________________________________________________________________________________________________________________________',0,1,'L');

$pdf->Cell(250,5,'_______________________________________________________________________________________________________________________________',0,1,'L');
	
}else{
	$pdf->MultiCell(250,5,$_SESSION['PDF_observaciones_adjudicacion'],0);
}
                 
         } 
else {
                        		
                        $pdf->SetDrawColor(0,0,0);
                        $pdf->SetFont('Arial','B',8);
                        $pdf->Cell(10,10,'Nro',1,0); 
                        $pdf->Cell(70,10,'Descripción del '.$_SESSION['PDF_titulo'],1,0); 
                        $pdf->Cell(15,10,'Cantidad',1,0); 
                        $pdf->Cell(15,10,'Unidad',1,0);
                         
                        for ($n=(3*$u)-3;$n<=(3*$u)-1;$n++)
                        {   
                        	$pdf->Cell(45,5,preview_text($proveedores[$n][1],25,0),1,0);
                        }
                        $pdf->SetXY(125,43.7);
                        
                        $variable = array(10,70,15,15,15,15,15);
                        $variable_visibles = array(1,1,1,1,1,1,1);
                        $variable_fonts_sizes=array(8,8,8,8,8,8,8);
                        $variable_spaces=array(3.5,3.5,3.5,3.5,3.5,3.5,3.5);
                        $variable_align=array('R','L','R','R','R','R','R');
                        $variable_decimales=array(0,0,0,0,0,2,2);
                      //esto es para definir dinamicamente dependiendo de los proveedores
                         $indice_array1=6;
                            for ($o=(3*$u)-3;$o<=(3*$u)-1;$o++)
                        	{ 
                            $pdf->Cell(15,5,'Cant. Cot.',1,0);		
                        	$pdf->Cell(15,5,'Precio U.',1,0);
                        	$pdf->Cell(15,5,'Precio T.',1,0);
                        	
                        	$variable[$indice_array1]=15;
                        	$variable[$indice_array1+1]=15;
                        	$variable[$indice_array1+2]=15;
                        	$variable_visibles[$indice_array1]=1;
                        	$variable_visibles[$indice_array1+1]=1;
                        	$variable_visibles[$indice_array1+2]=1;
                        	$variable_fonts_sizes[$indice_array1]=8;
                        	$variable_fonts_sizes[$indice_array1+1]=8;
                        	$variable_fonts_sizes[$indice_array1+2]=8;
                        	$variable_spaces[$indice_array1]=4;
                        	$variable_spaces[$indice_array1+1]=4;
                        	$variable_spaces[$indice_array1+2]=4;
                        	$variable_align[$indice_array1]='R';
                        	$variable_align[$indice_array1+1]='R';
                        	$variable_align[$indice_array1+2]='R';
                        	$variable_decimales[$indice_array1]=2;
                        	$variable_decimales[$indice_array1+1]=0;
                        	$variable_decimales[$indice_array1+2]=2;
                        	
                        	$indice_array1=$indice_array1+3;
                        }
                        /* este array es para definir las posiciones de las observaciones */
                        	$variable_observaciones=array(10,70,15,15,45);
                        	$variable_fonts_obs_sizes=array(8,8,8,8,8);
                        	$variable_obs_spaces=array(3.5,3.5,3.5,3.5,3.5);
                        	$variable_observaciones_visibles=array(1,1,1,1,1);
                        	$variable_align_obs=array('R','L','R','R','J');
                        
                        	$indice_array_obs1=4;
                            for ($p=(3*$u)-3;$p<=(3*$u)-1;$p++)
                        	{ 
                            $variable_observaciones[$indice_array_obs1+1]=45;
                        	$variable_fonts_obs_sizes[$indice_array_obs1+1]=8;
                        	$variable_obs_spaces[$indice_array_obs1+1]=4;
                        	$variable_observaciones_visibles[$indice_array_obs1+1]=1;
                        	$variable_align_obs[$indice_array_obs1+1]='J';
                        	$indice_array_obs1=$indice_array_obs1+1;
                            }
                        $pdf->Ln(5);
/*******************************Hasta aqui la definición de datos y cabecera del cuadro comparativo************************************/
                        
                        $pdf->SetFont('Arial','',8); 
                      $array_cuacom_det=$_SESSION['PDF_cuacom_det'];
                        $k2=0;
                        $m1=0;
                        //$o=4;
                        /*$tipo_celda1=array(0,0,0,0,1,1,1);
                        
                        $align1=array('R','L','R','R','R','R');
                        $tipo_celda=array();
                        $tipo_celda[0]=0;
                        $tipo_celda[1]=1;
                        $align=array();
                        $align[0]='R';	
                        $align[1]='R';	*/
                        
                        for($i=0;$i<(count($array_cuacom_det)/$size_proveedor);$i++){
                        	$o=4;
                        	$d=6;
                        	$r=1;
                        	$s=0;
                        	$o1=3;
                        	for($li1=((3*$u)-3)+$k2;$li1<((3*$u))+$k2;$li1++){
                        		
                        		//for($l=(((3*$u)-3)+$k);$l<=(($size_proveedor+$k)-1);$l++){
                        		    $tabla_aimprimir1[$m1][0]=$i+1;
                        		    $tabla_aimprimir1[$m1][1]=$array_cuacom_det[$li1][2];
                        		    $tabla_aimprimir1[$m1][2]=$array_cuacom_det[$li1][3];
                        		    $tabla_aimprimir1[$m1][3]=$array_cuacom_det[$li1][4];
                        		    $tabla_aimprimir1[$m1][$o]=$array_cuacom_det[$li1][7]; 
                        		    $tabla_aimprimir1[$m1][$o+1]=$array_cuacom_det[$li1][5];  
                        		    $tabla_aimprimir1[$m1][$o+2]=$array_cuacom_det[$li1][6];  
                        		   
                        		    $tabla_aimprimir_obs1[$m1][0]="";
                        		    $tabla_aimprimir_obs1[$m1][1]="";
                        		    $tabla_aimprimir_obs1[$m1][2]="";
                        		    $tabla_aimprimir_obs1[$m1][3]="";
                        		      
                        		 //   $tabla_aimprimir_obs1[$m][$o1+1]="Observaciones: Cada empresario tiene mayor responsabilidad y tienen un buen curriculum";
                        	       $tabla_aimprimir_obs1[$m1][$o1+1]=$array_cuacom_det[$l][9];
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
                        	$m1=$m1+1;
                        	
                        	
                        	
                        	
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
                           $pdf->MultiTabla($tabla_aimprimir1[$i1],1,1,3.5,8); 
                           
                           $pdf->SetWidths($variable_observaciones);
                           $pdf->SetVisibles($variable_observaciones_visibles);
                           $pdf->SetFontsSizes($variable_fonts_obs_sizes);
                           $pdf->SetSpaces($variable_obs_spaces);
                           $pdf->SetAligns($variable_align_obs);
                           //$pdf->SetLineWidth(0.1);
                           $pdf->SetX(125);
                           $pdf->Cell(45*3,0.01,'',1,1,'L',1);
                            if($tipo_adquisicion=='Servicio')
                       {
                         $pdf->MultiTabla($tabla_aimprimir_obs1[$i1],1,1,3.5,8); //////////// 	
                       }
                           //$pdf->MultiTabla($tabla_aimprimir_obs1[$i1],1,1,4,8); 
                           $pdf->SetWidths($variable);
                           $pdf->Cell(110+45*3,0.01,'',1,1,'L',1);
                           //$pdf->Cell(120 +(40*3),0.15,'',1,1,'L',1);
                        
                         }     
                         //primera celda
                        $pdf->SetFillColor(0,0,0);
                        $pdf->Cell(120 +(40*3),0.15,'',1,1,'L',1);
                        $pdf->SetFillColor(200,200,200);
                        
                    
                        $variable1 = array(110);
                        $variable1_visibles = array(1);	
                        $variable1_fonts_sizes = array(8);	
                        $variable1_spaces=array(4);
                        $variable1_align=array('R');
                        	$l1=1;
                        for ($t=0;$t<$size_proveedor;$t++)
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
                        
                             for($v=((3*$u)-3);$v<(3*$u);$v++){
                                 $tabla_plazo_entrega1[0][0]='Plazo de Entrega';
                        	     $tabla_plazo_entrega1[0][$o4]=$plazos[$v][1];
                        	     $o4=$o4+1;
                        		}
                        $pdf->MultiTabla($tabla_plazo_entrega1[0],1,3,4,8);
                        
                         $o5=1;
                             for($w=((3*$u)-3);$w<(3*$u);$w++){
                                 $tabla_lugar_entrega1[0][0]='Lugar de Entrega';
                        	     $tabla_lugar_entrega1[0][$o5]=$lugares_entrega[$w][1];
                        	     $o5=$o5+1;
                        		}
                         
                            $pdf->MultiTabla($tabla_lugar_entrega1[0],1,3,4,8);
                        //Forma de pago por proveedor y proceso de compra
                         $o6=1;
                             for($x=((3*$u)-3);$x<(3*$u);$x++){
                                 $tabla_forma_pago1[0][0]='Forma de Pago';
                        	     $tabla_forma_pago1[0][$o6]=$forma_pago[$x][1];
                        	     $o6=$o6+1;
                        		}
                        //
                        $pdf->MultiTabla($tabla_forma_pago1[0],1,3,4,8);
                        //Validez de la oferta por proveedor y proceso de compra.
                        //$pdf->SetWidths($variable1);
                         $o7=1;
                             for($y=((3*$u)-3);$y<(3*$u);$y++){
                                 $tabla_validez_oferta1[0][0]='Validez de la oferta';
                        	     $tabla_validez_oferta1[0][$o7]=$tiempo_validez[$y][1];
                        	     $o7=$o7+1;
                        		}
                        		
                            $pdf->MultiTabla($tabla_validez_oferta1[0],1,3,4,8);
                        //Garantia por proveedor y proceso de compra
                        //$pdf->SetWidths($variable1);
                         $o8=1;
                             for($z=((3*$u)-3);$z<(3*$u);$z++){
                                 $tabla_garantia1[0][0]='Garantia';
                        	     $tabla_garantia1[0][$o8]=$garantia[$z][1];
                        	     $o8=$o8+1;
                        		}
                        
                        $pdf->MultiTabla($tabla_garantia1[0],1,3,4,8);
                        //Observaciones por proceso y proveedor de compra
                        //$pdf->SetWidths($variable1);
                         $o9=1;
                             for($z1=((3*$u)-3);$z1<(3*$u);$z1++){
                                 $tabla_observaciones1[0][0]='Observaciones';
                        	     $tabla_observaciones1[0][$o9]=$observaciones[$z1][1];
                        	     $o9=$o9+1;
                        		}
                        		
                        $pdf->MultiTabla($tabla_observaciones1[0],1,3,4,8);
                        	
                        }
$pdf->SetFont('Arial','B',10);   
$pdf->Cell(92,15,'',0,0,'C');
$pdf->Cell(93,15,'',0,1,'C');



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