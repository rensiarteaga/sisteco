<?php

session_start();

require('../../../lib/fpdf/fpdf.php');
include_once("../../control/LibModeloAdquisiciones.php");
define('FPDF_FONTPATH','font/');
class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    $this-> AddFont('Tahoma','','tahoma.php');
$this-> AddFont('Arial','','arial.php');

    
    //Iniciaci�n de variables
    }
 var $widths;
 var $aligns;
function Header()
{
    //Logo
 //if($_SESSION["ss_id_usuario"]==120){
 // $this->Image('../../../lib/images/logo_reporte_factur__.jpg',170,2,35,15);
 //}else{
    $this->Image('../../../lib/images/logo_reporte.jpg',170,2,35,15);
 //}
    
//-----------------------Primera Solicitud

$this->SetFont('Tahoma','',10);
$this->SetLeftMargin(5);
$this->SetTopMargin(5);
 $this->SetAutoPageBreak(true,15);

 $this->SetFillColor(200,200,200);
$this->SetDrawColor(255,255,255);
$this->SetLineWidth(0.5);
//numero de version  
$this->SetFont('Arial','',6);
$this->Cell(10,3,$_SESSION['PDF_nro_generacion_sc'],1,1);
  
  
if($_SESSION['PDF_tipo_reporte']=='1'){
$this->Cell(200,7,'ORIGINAL',0,1,'L'); 

$this->SetFont('Arial','BI',14);

$this->Cell(180,5,'SOLICITUD DE '.$_SESSION['PDF_titulo'],0,1,'C');

if($_SESSION['PDF_titulo2']!=''){
	$this->SetFont('Arial','B',11);
	$this->Cell(180,5,'(Reformulada)',0,1,'C'); 
}
}
else{
	$this->Cell(200,7,'',0,1,'L'); 

$this->SetFont('Arial','BI',14);

$this->Cell(180,5,'VISTA PREVIA SOLICITUD DE '.$_SESSION['PDF_titulo'],0,1,'C');


	$this->SetFont('Arial','I',8);
	$this->Cell(180,5,'(DOCUMENTO NO V�LIDO PARA PROCEDER CON LA COMPRA)',0,1,'C'); 

	
}
$this->SetFont('Arial','B',8);
$this->Cell(185,5,'','T',1,'R');
$this->Cell(200,1,' ',0,1);

$this->SetFont('Arial','B',9);
$this->Cell(25,4,'N�mero',0,0); 
$this->Cell(45,4,'Localidad ',0,0); 
$this->Cell(30,4,'Fecha y Hora',0,0); 
$this->Cell(20,4,'Moneda',0,0);  
$this->Cell(65,4,'Modalidad',0,0);  
$this->Cell(15,4,'Gestion',0,1);  
$this->SetFont('Arial','',8);
/* cambiar el tipo de fecha */
$fecha1=date_create ($_SESSION['PDF_fecha_reg']); 
$fecha=date_format( $fecha1,'d/m/Y');


$this->Cell(25,4,$_SESSION['PDF_codigo_depto'].'  '.$_SESSION['PDF_num_solicitud'].'',0,0); 
$this->Cell(45,4,''.$_SESSION['PDF_localidad'].'',0,0); 
$this->Cell(30,4,''.$fecha.' '.$_SESSION['PDF_hora_reg'],0,0); 
$this->Cell(20,4,''.$_SESSION['PDF_moneda'].'',0,0); 
$this->Cell(65,4,''.$_SESSION['PDF_modalidad'].'',0,0); 
$this->Cell(15,4,''.$_SESSION['PDF_gestion'].'',0,1); 
$this->Ln(3);
/*$tam_texto = $this->NbLines(60,$_SESSION['PDF_nombre_unidad'].'');
$h=3*$tam_texto;
*/
$y=$this->GetY();
$this->SetFont('Arial','B',6);
$this->Cell(25,4,'Solicitante:',0,0);
$this->SetFont('Arial','',6);
$this->MultiCell(68,4,''.$_SESSION['PDF_nombre_solicitante'].'',1,'L',1); 

$this->SetXY(115,$y);
 $this->SetFont('Arial','B',6);
$this->Cell(25,4,'Cargo:',0,0); 
$this->SetFont('Arial','',6);
if($_SESSION["PDF_id_solicitud_compra"]==16352){
$this->MultiCell(68,4,'JEFE DEPARTAMENTO TECNICO',1,'L',1);	
}else{

$this->MultiCell(68,4,''.$_SESSION['PDF_cargo_empleado_solicitante'].'',1,'L',1);
}
 
$y=$this->GetY();
$this->SetFont('Arial','B',6);
$this->Cell(25,4,'Unidad Organizacional:',0,0);
$this->SetFont('Arial','',6);
if($_SESSION["ss_id_usuario"]==1200){
$this->MultiCell(68,4,'GTI - GERENCIA DE TECNOLOGIAS DE INFORMACI�N',1,'L',1); 	
}else{
$this->MultiCell(68,4,''.$_SESSION['PDF_nombre_unidad'].'',1,'L',1); 
}
$this->SetXY(115,$y);


$this->SetFont('Arial','B',6);
$this->Cell(25,4,'Programa:',0,0);
$this->SetFont('Arial','',6);
$this->MultiCell(68,4,''.$_SESSION['PDF_nombre_programa'].'',1,'L',1);




$y=$this->GetY();

$this->SetFont('Arial','B',6);
$this->Cell(25,4,'Regional:',0,0); 
$this->SetFont('Arial','',6);
$this->MultiCell(68,4,''.$_SESSION['PDF_nombre_regional'].'',1,'L',1);
$this->SetXY(115,$y);

$this->SetFont('Arial','B',6);
$this->Cell(25,4,'Sub-programa/Proyecto:',0,0);
$this->SetFont('Arial','',6);
$this->MultiCell(68,4,''.$_SESSION['PDF_nombre_proyecto'].'',1,'L',1);

$y=$this->GetY();

$this->SetFont('Arial','B',6);
$this->Cell(25,4,'Financiador:',0,0); 
$this->SetFont('Arial','',6);
$this->MultiCell(68,4,''.$_SESSION['PDF_nombre_financiador'].'',1,'L',1);


$this->SetXY(115,$y);
$this->SetFont('Arial','B',6);
$this->Cell(25,4,'Actividad:',0,0);
$this->SetFont('Arial','',6);
$this->MultiCell(68,4,''.$_SESSION['PDF_nombre_actividad'].'',1,'L',1);



if(strlen($_SESSION['PDF_ot'])>0){
$y=$this->GetY();

$this->SetFont('Arial','B',6);
$this->Cell(25,4,'Orden Trabajo:',0,0); 
$this->SetFont('Arial','',6);
$this->MultiCell(68,4,''.$_SESSION['PDF_ot'].'',1,'L',1);
}



$this->SetDrawColor(0,0,0);
$this->SetLineWidth(0); 
$this->Ln(2);
    
   // $this->Line(15,15,195,15);
   
}
//Pie de p�gina
function Footer()
{
    //Posici�n: a 1,5 cm del final
	/*$fecha=date("d-m-Y");
	$hora=date("H:i:s");*/
	$nombre_usuario=$_SESSION["ss_nombre_usuario"];
	
	//if($_SESSION['PDF_nom_usuario']!=''){
		$fecha=date_format(date_create ($_SESSION['PDF_fecha_reg']),'d-m-Y');
		$nombre_usuario=strtoupper($_SESSION["PDF_nom_usuario"]);
		list($hora1, $minut,$seg) = split('[:]', $_SESSION['PDF_hora_reg']); 
		$hora=date("H:i:s", mktime($hora1+1, $minut+32, $seg+27)); 
	//}
	if($_SESSION["ss_id_usuario"]==120){
		$fecha='23-03-2012';
		//$nombre_usuario='SILBERSTEIN CABRERA ERICK YASSIR';
	//	$nombre_usuario='VARGAS MALDONADO EDWIN ORLANDO';
		$hora='18:47:29';
	}
	    $this->SetY(-10);
   	    $this->SetFont('Arial','',6);
   	    
   	   // $this->Cell(70,3,'Usuario: '.$nombre_usuario,0,0,'L');
	  // $_SESSION['PDF_nombre_aprobacion']
   	    if($_SESSION["ss_id_usuario"]==120){
   	    $this->Cell(70,3,'Usuario: VALLEJO BELTRAN ENZO MAURICIO',0,0,'L');
			$this->Cell(50,3,'P�gina 1 de 3',0,0,'C');
			$this->Cell(52,3,'',0,0,'L');
			/*$this->Cell(18,3,'Fecha Imp.: '.$fecha,0,0,'L');*/
			$this->ln(3);
			$this->Cell(70,3,'Sistema: ENDESIS - COMPRO',0,0,'L');
			$this->Cell(50,3,'',0,0,'C');
			$this->Cell(52,3,'',0,0,'L');
   	    }else {
   	    
   	    
		    $this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
			$this->Cell(50,3,'P�gina '.$this->PageNo().' de {nb}',0,0,'C');
			$this->Cell(52,3,'',0,0,'L');
			/*$this->Cell(18,3,'Fecha Imp.: '.$fecha,0,0,'L');*/
			$this->ln(3);
			$this->Cell(70,3,'Sistema: ENDESIS - COMPRO',0,0,'L');
			$this->Cell(50,3,'',0,0,'C');
			$this->Cell(52,3,'',0,0,'L');
   	    }
		/*$this->Cell(18,3,'Hora: '.$hora,0,0,'L');*/
		$this->ln(3);
		if($_SESSION['PDF_tipo_reporte']=='1'){
			
			if($_SESSION["ss_id_usuario"]==120){
				$this->Cell(70,3,'3798f5ca75b6787f94323bee5fdbedf3cfc76345150081242124434',0,0,'L'); //20sep11: a pedido de Erios en sol de serv. 1/101 de NValdez
			}else{
			
			
			$this->Cell(70,3,sha1($_SESSION['PDF_num_solicitud'].$_SESSION['PDF_nombre_financiador'].$_SESSION['PDF_nombre_regional'].$_SESSION['PDF_nombre_programa'].$_SESSION['PDF_nombre_proyecto'].$_SESSION['PDF_nombre_actividad'].gregoriantojd(date('m'),date('d'),date('Y')).$hora.$_SESSION['PDF_monto_total']).date('y').'0'.date('m').'1'.date('d').'2'.date('H').date('i').date('s'),0,0,'L');
			
			}
			}
}


//Cabecera de p�gina

}

$pdf=new PDF();
 
$pdf->AddPage();
$poscab=0;
$poscab=$pdf->GetY();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,10);
//$pdf->SetDisplayMode(fullpage);
$Custom = new cls_CustomDBAdquisiciones();


$pdf->SetFont('Arial','B',9);
$pdf->Cell(203,2,'','T',1,'C');
$data_maestro=$_SESSION['PDF_partida'];

$pdf->SetFont('Arial','',10); 


$tam_data=count($data_maestro);
$reformulados=array();
$contador=1;
$aux=array();

for($j=0;$j<$tam_data;$j++)
 {
 	//si no tiene presupuestado para el a�o siguiente
 	if($data_maestro[$j][3]=='0' or $data_maestro[$j][3]=='0.00'){
	 	
 		$pdf->Cell(30,5,'C�digo Partida',0,0,'L'); 
		$pdf->Cell(100,5,'Nombre Partida',0,0,'L'); 
		$pdf->Cell(30,5,'Total Referencial',0,0,'R'); 
		$pdf->Cell(35,5,'   Disponibilidad',0,1,'L'); 
		
	 	
	 	$pdf->SetWidths(array(30,100,30,35));
		$pdf->SetAligns(array('L','L','R','L'));
		$pdf->SetVisibles(array(1,1,1,1));
		$pdf->SetDecimales(array(0,0,2,0));
		$pdf->SetFontsSizes(array(10,10,10,10));
		$pdf->SetFontsColors(array(array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0)));
		$pdf->SetFontsStyles(array('','','B','B'));
		$pdf->SetFormatNumber(array(0,0,1,0));
	    
	 	
	 	if($data_maestro[$j][4]=='NO DISPONIBLE'){
	 		$pdf->SetFontsColors(array(array(237,10,3),array(237,10,3),array(237,10,3),array(237,10,3)));
	       		    
	    }
	       
	    
	    $arreglo=array();
	    $arreglo[0][0]=$data_maestro[$j][0];
	    $arreglo[0][1]=$data_maestro[$j][1];
	    $arreglo[0][2]=$data_maestro[$j][2];
	    $arreglo[0][3]='   '.$data_maestro[$j][4];
	    $pdf->MultiTabla($arreglo[0],1,0,5,10,1);
	    
	  
 	}
 	//si tiene presupuestado apra el a�o siguiente
 	else{
 		
 		$pdf->Cell(25,5,'C�digo Partida',0,0,'L'); 
		$pdf->Cell(90,5,'Nombre Partida',0,0,'L'); 
		$pdf->Cell(45,5,'Total Gesti�n Actual',0,0,'R'); 
		$pdf->Cell(35,5,'   Disponibilidad',0,1,'L');
		
		$pdf->SetWidths(array(25,90,45,35));
		$pdf->SetAligns(array('L','L','R','L'));
		$pdf->SetVisibles(array(1,1,1,1));
		$pdf->SetDecimales(array(0,0,2,0));
		$pdf->SetFontsSizes(array(10,10,10,10));
		$pdf->SetFontsColors(array(array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0)));
		$pdf->SetFontsStyles(array('','','B','B'));
		$pdf->SetFormatNumber(array(0,0,1,0));
	     
		
	 	if($data_maestro[$j][4]=='NO DISPONIBLE'){
	 		$pdf->SetFontsColors(array(array(237,10,3),array(237,10,3),array(237,10,3),array(237,10,3)));
	       		    
	    }
	    
	    $arreglo=array();
	    $arreglo[0][0]=$data_maestro[$j][0];
	    $arreglo[0][1]=$data_maestro[$j][1];
	    $arreglo[0][2]=$data_maestro[$j][2];
	    $arreglo[0][3]='   '.$data_maestro[$j][4];
	    $pdf->MultiTabla($arreglo[0],1,0,5,10,1);
	        
	    
	    $pdf->Cell(115,5,'Monto referencial para Presupuesto de la siguiente gesti�n:',0,0,'L');
	    $pdf->Cell(45,5,number_format($data_maestro[$j][3],2),0,1,'R');
 		
 	}
    
    
 	//$pdf->MultiTabla($data_maestro[$j],0,0);
   $pdf->SetFontsColors(array(array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0)));
   $criterio_filtro='0=0 AND SOLCOM.id_solicitud_compra='.$_SESSION['PDF_id_solicitud_compra']." AND codigo_partida like ''".$data_maestro[$j][0]."''";
      	 if($_SESSION['PDF_es_item']==1){
   
   		$res = $Custom->ReporteVerificacionBien(100,0,'soldet.id_solicitud_compra_det','asc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
   }
   else{
   		//$res = $Custom->ReporteVerificacionServicio(100,0,'SERVIC.codigo','asc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
   		$res = $Custom->ReporteVerificacionServicio(100,0,'soldet.id_solicitud_compra_det','asc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
   }
$pdf->SetFont('Arial','B',8); 
$data=$Custom->salida;

$pdf->Cell(15,5,'No','LRT',0); 
$pdf->Cell(25,5,'C�digo','LRT',0); 


	$pdf->Cell(88,5,'Descripci�n','LRT',0);
	$pdf->Cell(10,5,'Unidad','LRT',0);



$pdf->Cell(15,5,'Cantidad','LRT',0);  
$pdf->Cell(25,5,'Precio','LRT',0); 
$pdf->Cell(25,5,'Precio','LRT',1);
$pdf->Cell(15,5,'','LRB',0); 
$pdf->Cell(25,5,'','LRB',0); 

	$pdf->Cell(88,5,'','LRB',0);
	$pdf->Cell(10,5,'Medida','LRB',0); 

$pdf->Cell(15,5,'','LRB',0);  
$pdf->Cell(25,5,'Unitario','LRB',0);
$pdf->Cell(25,5,'Total','LRB',1);



	$pdf->SetWidths(array(15,25,88,10,15,25,25));
	$pdf->SetAligns(array('R','L','L','L','R','R','R'));
	$pdf->SetVisibles(array(1,1,1,1,1,1,1,0,0));
	$pdf->SetFontsSizes(array(7,5,7,7,7,7,7,7));
	$pdf->SetDecimales(array(0,0,0,0,0,2,2));
	$pdf->SetSpaces(array(3.5,3.5,3.5,3.5,3.5,3.5,3.5));


$pdf->SetFont('Arial','',8); 



$cdata=count($data);

 for($i=0;$i<$cdata;$i++)
 {
 	
 	if($data[$i]['reformular']=='si'){
 		//echo $data[$i]['refo_item'];
 		array_push($reformulados,array($contador,$data[$i]['id_solicitud_compra_det']));
 		if($data[$i]['refo_item']=='si_item' && $data[$i]['refo_monto']=='si_monto'){
 			$pdf->SetFontsStyles(array('','U','U','','','U','U'));
 		}
 		elseif ($data[$i]['refo_item']=='si_item'){
 			
 			$pdf->SetFontsStyles(array('','U','U','','','',''));
 		}
 		else{
 			$pdf->SetFontsStyles(array('','','','','','U','U'));
 		}
 		
 	}
 	else{
 		$pdf->SetFontsStyles(array('','','','','','',''));
 	}
 	$aux=$data[$i];
 	array_unshift($aux,$contador);
 	
 		//$pdf->morepagestable($aux,10);
 	$data_rep[$i][0]=$contador;
 	$data_rep[$i][1]=$data[$i][0];
 	$data_rep[$i][2]=$data[$i][1];
 	$data_rep[$i][3]=$data[$i][2];
 	$data_rep[$i][4]=$data[$i][3];
 	$data_rep[$i][5]=$data[$i][4];
 	$data_rep[$i][6]=$data[$i][5];
 	
   	$pdf->MultiTabla($aux,0,1,3.5,7);
  // 	$poscab=15;
   	
  // 	$pdf->tablaDatosExtensos($data_rep,3,5,$poscab); 

   	$contador=$contador+1;
 }
 $pdf->Cell(203,0,'','T',1,'C');
 }

//$pdf->ln(40);

$pdf->SetFont('Arial','',8);
$pdf->Ln(5);
$pdf->Cell(36,5,'Justificaci�n:','',0);
$pdf->MultiCell(167,4,''.$_SESSION['PDF_observaciones'].'',0,'L',0);
$pdf->Ln(2);
$pdf->Cell(36,5,'Comit� de Evaluaci�n:','',0);
$pdf->MultiCell(167,4,''.$_SESSION['PDF_comite_calificacion'].'',0,'L',0);
$pdf->Ln(2);
$pdf->Cell(36,5,'Posibles Proveedores:','',0);
$pdf->MultiCell(167,4,''.$_SESSION['PDF_proveedores_propuestos'].'',0,'L',0);

$pdf->Ln(2);
$pdf->Cell(36,5,'Comite de Recepci�n:','',0);
$pdf->MultiCell(167,4,''.$_SESSION['PDF_comite_recepcion'].'',0,'L',0);
//$pdf->ln(10);

if($_SESSION['PDF_titulo2']!=''){
	$pdf->SetFont('Arial','B',10); 
	$pdf->Cell(180,5,'REFORMULACIONES',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(15,5,'No','LRT',0);  
	$pdf->Cell(25,5,'C�digo','LRT',0); 

	
		$pdf->Cell(88,5,'Descripci�n','LRT',0);
		$pdf->Cell(10,5,'Unidad','LRT',0);
	
	
	$pdf->Cell(15,5,'Cantidad','LRT',0);  
	$pdf->Cell(25,5,'Precio','LRT',0); 
	$pdf->Cell(25,5,'Precio','LRT',1);
	$pdf->Cell(15,5,'','LRB',0); 
	$pdf->Cell(25,5,'','LRB',0); 
	
		$pdf->Cell(88,5,'','LRB',0);
		$pdf->Cell(10,5,'Medida','LRB',0);
	
	$pdf->Cell(15,5,'','LRB',0);  
	$pdf->Cell(25,5,'Unitario','LRB',0);
	$pdf->Cell(25,5,'Total','LRB',1);
	
	
	
	$pdf->SetWidths(array(15,25,88,10,15,25,25));
	$pdf->SetAligns(array('R','L','L','L','R','R','R'));
	$pdf->SetVisibles(array(1,1,1,1,1,1,1,0,0));
	$pdf->SetFontsSizes(array(8,6,8,8,8,8,8,8));
	$pdf->SetFontsStyles(array('','','','','','',''));
	$pdf->SetDecimales(array(0,0,0,0,0,2,2));
	
	$cdata=count($reformulados);
	$refo=array();
	for($i=0;$i<$cdata;$i++)
 	{
 		$criterio_filtro='0=0 AND SOLDET.id_solicitud_compra_det='.$reformulados[$i][1].' ';
   if($_SESSION['PDF_titulo']=='BIENES'){
   		$res = $Custom->ReporteVerificacionBien(100,0,'SOLDET.id_solicitud_compra_det','asc',$criterio_filtro,1,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
   }
   else{
   		$res = $Custom->ReporteVerificacionServicio(100,0,'SOLDET.id_solicitud_compra_det','asc',$criterio_filtro,1,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
   }
   
   $refo=$Custom->salida;
   $aux=$refo[0];
   
 	array_unshift($aux,$reformulados[$i][0]);
 		$pdf->Cell(203,0,'','T',1,'C');
 		$pdf->MultiTabla($aux,1,1);
 		$pdf->MultiCell(203,4,'MOTIVO REFORMULACI�N: '.$aux[12],'LRBT');
 		$pdf->ln(4);
   		
 	}
 
	
	 
}

$criterio_filtro='0=0 AND SOLCOM.id_solicitud_compra='.$_SESSION['PDF_id_solicitud_compra']." AND codigo_partida like ''".$data_maestro[$j][0]."''";
   if($_SESSION['PDF_titulo']=='BIENES'){
   		$res = $Custom->ReporteVerificacionBien(100,0,'ITEM.codigo','asc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
   }
   else{
   		$res = $Custom->ReporteVerificacionServicio(100,0,'SERVIC.codigo','asc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
   }


//if($pdf->GetY()>80){
if($pdf->GetY()>230){
	//echo $pdf->GetY();
	$pdf->AddPage();
}

if($_SESSION['PDF_tipo_reporte']=='1'){
	
	
	if($_SESSION['PDF_id_solicitud_compra']==18564){
		$pdf->MultiCell(195,4,"\n\n\n\n____________________________"."\n".$_SESSION['PDF_nombre_aprobacion']."\n JEFE UNIDAD JURIDICA INTERINO \nFirma Autorizada",'','C',0);
	}else{
		
	
	
	
			$pdf->MultiCell(195,4,"\n\n\n\n____________________________"."\n".$_SESSION['PDF_nombre_aprobacion']."\n".strtoupper($_SESSION['PDF_cargo_empleado_aprobador'])."\nFirma Autorizada",'','C',0); 
	}
}

 


///////////////////////////////////fin de primera solicitud //////////////////////////////

$pdf->Output();
?>