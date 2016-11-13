<?php
session_start();
/**
 * Autor: Marcos A. Flores Valda
 * Fecha de creacion: 07/01/2011
 * Descripción: Reporte de Depreciaciones
 * **/

require('../../../lib/fpdf/fpdf.php');
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
   		//$this->Image('../../../lib/images/logo_reporte.jpg',8,9,26,9);
  		$this->Ln(5); 		 		  
	}
	
	//Pie de página
	function Footer()
	{
	    //Posición: a 1,5 cm del final
	    $fecha=date("d-m-Y");
		$hora=date("H:i:s");
		$this->SetY(-10);
	    $this->SetFont('Arial','',6);
	    $this->Cell(80,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(40,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(80,3,'Sistema: ENDESIS - KARDEX',0,0,'L');
		$this->Cell(40,3,'',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	        
	}
}

$fecha=date("d-m-Y");

if($_SESSION['PDF_tipo_contrato'] == 'planta')
{
	if(eregi('years',$_SESSION['PDF_antiguedad']) == true)
	{
		$_SESSION['PDF_ant_int_anio'] = explode('years',$_SESSION['PDF_antiguedad']);
		$_SESSION['PDF_ant_int_mes'] = explode('mons',$_SESSION['PDF_ant_int_anio'][1]);		
	}
	else 
	{		
		$_SESSION['PDF_ant_int_mes'] = explode('mons',$_SESSION['PDF_antiguedad']);
		$_SESSION['PDF_ant_int_anio'] = '0';		
	}
		
	$_SESSION['PDF_ant_ext_anio'] = intval($_SESSION['PDF_antiguedad_ant'] / 12);
	$_SESSION['PDF_ant_ext_mes'] = $_SESSION['PDF_antiguedad_ant'] - (12 * $_SESSION['PDF_ant_ext_anio']);
	
	$_SESSION['PDF_ant_acum_anio'] = $_SESSION['PDF_ant_int_anio'][0] + $_SESSION['PDF_ant_ext_anio'];
	$_SESSION['PDF_ant_acum_mes'] = $_SESSION['PDF_ant_int_mes'][0] + $_SESSION['PDF_ant_ext_mes'];	
}

else 
{
	$_SESSION['PDF_ant_int_anio'] = ' ';
	$_SESSION['PDF_ant_int_mes'] = ' ';
	
	$_SESSION['PDF_ant_ext_anio'] = ' ';
	$_SESSION['PDF_ant_ext_mes'] = ' ';
	
	$_SESSION['PDF_ant_acum_anio'] = ' ';
	$_SESSION['PDF_ant_acum_mes'] = ' ';
	
	$_SESSION['PDF_dias_disp'] = 0;
	$_SESSION['PDF_suma'] = 0;
}

if($_SESSION['PDF_total_reg'] != 1)
{
	$_finicio = explode("-",$_SESSION['PDF_f_inicio']);
	$_SESSION['PDF_f_inicio'] = $_finicio[2].'/'.$_finicio[1].'/'.$_finicio[0]; 
	
	$_ffin = explode("-",$_SESSION['PDF_f_fin']);	
	$_SESSION['PDF_f_fin'] = $_ffin[2].'/'.$_ffin[1].'/'.$_ffin[0]; 
	
	$f_inicio = $_SESSION['PDF_f_inicio'];
	$f_fin = $_SESSION['PDF_f_fin'];
	
	$suma = $_SESSION['PDF_suma'];
	
	$total_x_tomar = $_SESSION['PDF_dias_comp'] + $suma;
}
else 
{
	$f_inicio = $_SESSION['PDF_fecha_inicio'];
	$f_fin = $_SESSION['PDF_fecha_fin'];	
		
	$suma = $_SESSION['PDF_horas'];
	
	$total_x_tomar = $_SESSION['PDF_horas'] + $_SESSION['PDF_dias_comp'];
}

if($_SESSION['PDF_dias_comp'] < 0)
{
	$total_x_tomar = 0;
	$_SESSION['PDF_dias_comp'] = 0;
}

$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true,7);
$pdf->SetMargins(7,5,5);

// ORIGINAL

//  TITULO
$pdf->Image('../../../lib/images/logo_reporte.jpg',8,9,26,9);
$pdf->SetFont('Arial','B',14); // celda de logo
$pdf->SetX(7);
$pdf->Cell(30,10,'',1,0,'C');
	    
$pdf->SetFont('Arial','B',14);
$pdf->Cell(140,10,'SOLICITUD DE LICENCIA',1,0,'C');

$pdf->SetFont('Arial','B',4);
$pdf->SetX(177);
$pdf->Cell(30,4,'Nº SOLICITUD: '.$_SESSION['PDF_num_solicitud'],'LTR',0,'L');

$pdf->SetFont('Arial','B',4);
$pdf->SetXY(177,12);
$pdf->Cell(30,4,'FECHA: '.$fecha,'LR',0,'L');

$pdf->SetFont('Arial','B',4);
$pdf->SetXY(177,15);
$pdf->Cell(30,4,'Nº EMPLEADO: '.$_SESSION['PDF_codigo_emp'],'LBR',1,'L');
   
//  CUERPO

$pdf->SetFont('Arial','B',5);
$pdf->Cell(100,3,'SOLICITANTE',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(100,3,'CARGO',1,1,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(100,3,$_SESSION['PDF_solicitante'],1,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(100,3,$_SESSION['PDF_cargo'],1,1,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(100,3,'CENTRO DE RESPONSABILIDAD',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(100,3,'LOCALIDAD',1,1,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(100,3,$_SESSION['PDF_centro_r'],1,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(100,3,$_SESSION['PDF_localidad'],1,1,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(100,3,'SOLICITUD DE LICENCIA POR',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(100,3,'DURACION',1,1,'C');

/*--------------------------------------------------*/

$pdf->Cell(100,1,'','LR',0,'C');
$pdf->Cell(100,1,'','LR',1,'C');

/*--------------------------------------------------*/

$pdf->SetFont('Arial','',5);
$pdf->Cell(5,3,' ','L',0,'C');

$pdf->SetFont('Arial','B',5); //casilla de vacacion  
$pdf->Cell(5,3,'',1,0,'C'); 

$pdf->Cell(2,1,'',0,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(18,3,'VACACION',0,0,'L');

$pdf->SetFont('Arial','',5);
$pdf->Cell(20,3,' ',0,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(50,3,'GESTIÓN: 2010 - 2011','R',1,'L');

/*--------------------------------------------------*/

$pdf->Cell(100,1,'','LR',1,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(5,3,' ','L',0,'C');

$pdf->SetFont('Arial','B',5); //casilla de compensacion  
$pdf->Cell(5,3,'X',1,0,'C'); 

$pdf->Cell(2,1,'',0,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(18,3,'COMPENSACION',0,0,'L');

$pdf->SetFont('Arial','',5);
$pdf->Cell(20,3,' ',0,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(50,3,'','R',1,'L');

/*--------------------------------------------------*/

$pdf->Cell(100,1,'','LR',1,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(5,3,' ','L',0,'C');

$pdf->SetFont('Arial','B',5); //casilla de compensacion  
$pdf->Cell(5,3,'',1,0,'C'); 

$pdf->Cell(2,1,'',0,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(18,3,'COMISION',0,0,'L');

$pdf->SetFont('Arial','',5);
$pdf->Cell(20,3,' ',0,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(50,3,'','R',1,'L');

/*--------------------------------------------------*/

$pdf->Cell(100,1,'','LR',1,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(5,3,' ','L',0,'C');

$pdf->SetFont('Arial','B',5); //casilla de compensacion  
$pdf->Cell(5,3,'',1,0,'C'); 

$pdf->Cell(2,1,'',0,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(18,3,'OTROS',0,0,'L');

$pdf->SetFont('Arial','',5);
$pdf->Cell(20,3,' ',0,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(50,3,'','R',1,'L');

/*--------------------------------------------------*/

$pdf->Cell(100,1,'','LR',0,'C');
$pdf->Cell(100,1,'','LR',1,'C');

/*--------------------------------------------------*/

$pdf->SetFont('Arial','B',5);
$pdf->SetXY(107,35);
$pdf->Cell(100,6,'                                                          DESDE EL:  '.$f_inicio,'LR',1,'L');

$pdf->SetFont('Arial','B',5);
$pdf->SetXY(107,38);
$pdf->Cell(100,6,'                                                          HASTA EL:  '.$f_fin,'LR',1,'L');

$pdf->SetFont('Arial','B',5);
$pdf->SetXY(107,43);
$pdf->Cell(100,8,'                                                          TOTAL:  '.$suma,'LR',1,'L');

/*--------------------------------------------------*/

$pdf->SetFont('Arial','B',7);
$pdf->Cell(200,4,'INFORME DE ADMINISTRACION DE PERSONAL PARA COMPENSACION',1,1,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(30,3,'FECHA DE INGRESO',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(70,3,'ANTIGUEDAD',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(100,3,'RESUMEN',1,1,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(10,3,'DIA',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(10,3,'MES',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(10,3,'AÑO',1,0,'C');
 
$pdf->SetFont('Arial','B',5);
$pdf->Cell(20,3,'AÑOS',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(20,3,'MESES',1,0,'C');

$pdf->SetFont('Arial','B',7);
$pdf->Cell(30,3,'',1,1,'C');

/*-----------------------fecha ingreso ---------------------------*/

$pdf->SetFont('Arial','',5);
$pdf->Cell(10,7,$_SESSION['PDF_dia'],1,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(10,7,$_SESSION['PDF_mes'],1,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(10,7,$_SESSION['PDF_anio'],1,1,'C');

/*--------------------------------------------------*/
$pdf->SetFont('Arial','',5);
$pdf->Cell(30,4,'',1,0,'C');

/*------------------------ antiguedad --------------------------*/

$pdf->SetFont('Arial','',5);
$pdf->SetXY(37,61);
$pdf->Cell(20,3.5,$_SESSION['PDF_ant_int_anio'][0],1,1,'C');

$pdf->SetFont('Arial','',5);
$pdf->SetXY(57,61);
$pdf->Cell(20,3.5,$_SESSION['PDF_ant_int_mes'][0],0,1,'C');

$pdf->SetFont('Arial','',5);
$pdf->SetXY(77,61);
$pdf->Cell(30,3.5,'Interna',1,1,'C');

/*--------------------------------------------------*/

$pdf->SetFont('Arial','',5);
$pdf->SetXY(37,64.5);
$pdf->Cell(20,3.5,$_SESSION['PDF_ant_ext_anio'],1,1,'C');

$pdf->SetFont('Arial','',5);
$pdf->SetXY(57,64.5);
$pdf->Cell(20,3.5,$_SESSION['PDF_ant_ext_mes'],1,1,'C');

$pdf->SetFont('Arial','',5);
$pdf->SetXY(77,64.5);
$pdf->Cell(30,3.5,'Externa',1,1,'C');

/*--------------------------------------------------*/

$pdf->SetFont('Arial','',5);
$pdf->SetXY(37,68);
$pdf->Cell(20,4,$_SESSION['PDF_ant_acum_anio'],1,1,'C');

$pdf->SetFont('Arial','',5);
$pdf->SetXY(57,68);
$pdf->Cell(20,4,$_SESSION['PDF_ant_acum_mes'],1,1,'C');

$pdf->SetFont('Arial','',5);
$pdf->SetXY(77,68);
$pdf->Cell(30,4,'Acumulada',1,1,'C');

/*------------------------ resumen --------------------------*/

$pdf->SetXY(107,57);
$pdf->Cell(100,6,'','LR',1,'R');

$pdf->SetXY(107,60);
$pdf->Cell(30,6,'Total por tomar: ','L',0,'R');

$pdf->SetXY(137,60);
$pdf->Cell(10,6,$total_x_tomar,0,0,'C');

$pdf->SetXY(147,60);
$pdf->Cell(30,6,' días',0,0,'L');

$pdf->SetXY(177,60);
$pdf->Cell(30,6,'','R',1,'L');


$pdf->SetXY(107,63);
$pdf->Cell(30,6,'Toma:: ','L',0,'R');

$pdf->SetXY(137,63);
$pdf->Cell(10,6,$suma,0,0,'C');

$pdf->SetXY(147,63);
$pdf->Cell(30,6,' días',0,0,'L');

$pdf->SetXY(177,63);
$pdf->Cell(30,6,'Saldo: '.$_SESSION['PDF_dias_comp'],'R',1,'L');


$pdf->SetXY(107,66);
$pdf->Cell(100,6,'','LR',1,'R'); 

/*--------------------------------------------------*/

$pdf->SetFont('Arial','B',5);
$pdf->MultiCell(200,10,'OBSERVACIONES: '.$_SESSION['PDF_obs'],1,1,'L');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(50,4,'FIRMA SOLICITANTE',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(50,4,'RESPONSABLE DEL CENTRO',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(50,4,'ADMINISTRACIÓN DE PERSONAL',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(50,4,'FIRMA AUTORIZADA',1,1,'C');

/*--------------------------------------------------*/

$pdf->SetFont('Arial','B',5);
$pdf->Cell(50,15,'',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(50,15,'',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(50,15,'',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(50,15,'',1,1,'C');

/*--------------------------------------------------*/
$pdf->SetFont('Arial','',5);
$pdf->Cell(200,10,'ORIGINAL',0,1,'R');

// FIN ORIGINAL

$pdf->Cell(200,10,'_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ ',0,0,'C'); // linea punteada

$pdf->Ln(20); 
$pdf->Cell(200,50,'',0,0,'C');

//  COPIA
//  TITULO

$pdf->Image('../../../lib/images/logo_reporte.jpg',8,131,26,9);
$pdf->SetFont('Arial','B',14); // celda de logo
$pdf->SetX(7);
$pdf->Cell(30,10,'',1,0,'C');
	    
$pdf->SetFont('Arial','B',14);
$pdf->Cell(140,10,'SOLICITUD DE LICENCIA',1,0,'C');

$pdf->SetFont('Arial','B',4);
$pdf->SetX(177);
$pdf->Cell(30,4,'Nº SOLICITUD: '.$_SESSION['PDF_num_solicitud'],'LTR',0,'L');

$pdf->SetFont('Arial','B',4);
$pdf->SetXY(177,134);
$pdf->Cell(30,4,'FECHA: '.$fecha,'LR',0,'L');

$pdf->SetFont('Arial','B',4);
$pdf->SetXY(177,137);
$pdf->Cell(30,4,'Nº EMPLEADO: '.$_SESSION['PDF_codigo_emp'],'LBR',1,'L');
   
//  CUERPO

$pdf->SetFont('Arial','B',5);
$pdf->Cell(100,3,'SOLICITANTE',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(100,3,'CARGO',1,1,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(100,3,$_SESSION['PDF_solicitante'],1,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(100,3,$_SESSION['PDF_cargo'],1,1,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(100,3,'CENTRO DE RESPONSABILIDAD',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(100,3,'LOCALIDAD',1,1,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(100,3,$_SESSION['PDF_centro_r'],1,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(100,3,$_SESSION['PDF_localidad'],1,1,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(100,3,'SOLICITUD DE LICENCIA POR',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(100,3,'DURACION',1,1,'C');

/*--------------------------------------------------*/

$pdf->Cell(100,1,'','LR',0,'C');
$pdf->Cell(100,1,'','LR',1,'C');

/*--------------------------------------------------*/

$pdf->SetFont('Arial','',5);
$pdf->Cell(5,3,' ','L',0,'C');

$pdf->SetFont('Arial','B',5); //casilla de vacacion  
$pdf->Cell(5,3,'',1,0,'C'); 

$pdf->Cell(2,1,'',0,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(18,3,'VACACION',0,0,'L');

$pdf->SetFont('Arial','',5);
$pdf->Cell(20,3,' ',0,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(50,3,'GESTIÓN: 2010 - 2011','R',1,'L');

/*--------------------------------------------------*/

$pdf->Cell(100,1,'','LR',1,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(5,3,' ','L',0,'C');

$pdf->SetFont('Arial','B',5); //casilla de compensacion  
$pdf->Cell(5,3,'X',1,0,'C'); 

$pdf->Cell(2,1,'',0,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(18,3,'COMPENSACION',0,0,'L');

$pdf->SetFont('Arial','',5);
$pdf->Cell(20,3,' ',0,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(50,3,'','R',1,'L');

/*--------------------------------------------------*/

$pdf->Cell(100,1,'','LR',1,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(5,3,' ','L',0,'C');

$pdf->SetFont('Arial','B',5); //casilla de compensacion  
$pdf->Cell(5,3,'',1,0,'C'); 

$pdf->Cell(2,1,'',0,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(18,3,'COMISION',0,0,'L');

$pdf->SetFont('Arial','',5);
$pdf->Cell(20,3,' ',0,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(50,3,'','R',1,'L');

/*--------------------------------------------------*/

$pdf->Cell(100,1,'','LR',1,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(5,3,' ','L',0,'C');

$pdf->SetFont('Arial','B',5); //casilla de compensacion  
$pdf->Cell(5,3,'',1,0,'C'); 

$pdf->Cell(2,1,'',0,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(18,3,'OTROS',0,0,'L');

$pdf->SetFont('Arial','',5);
$pdf->Cell(20,3,' ',0,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(50,3,'','R',1,'L');

/*--------------------------------------------------*/

$pdf->Cell(100,1,'','LR',0,'C');
$pdf->Cell(100,1,'','LR',1,'C');

/*--------------------------------------------------*/

$pdf->SetFont('Arial','B',5);
$pdf->SetXY(107,157);
$pdf->Cell(100,6,'                                                          DESDE EL: '.$f_inicio,'LR',1,'L');

$pdf->SetFont('Arial','B',5);
$pdf->SetXY(107,160);
$pdf->Cell(100,6,'                                                          HASTA EL: '.$f_fin,'LR',1,'L');

$pdf->SetFont('Arial','B',5);
$pdf->SetXY(107,165);
$pdf->Cell(100,8,'                                                          TOTAL: '.$suma,'LR',1,'L');

/*--------------------------------------------------*/

$pdf->SetFont('Arial','B',7);
$pdf->Cell(200,4,'INFORME DE ADMINISTRACION DE PERSONAL PARA COMPENSACION',1,1,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(30,3,'FECHA DE INGRESO',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(70,3,'ANTIGUEDAD',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(100,3,'RESUMEN',1,1,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(10,3,'DIA',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(10,3,'MES',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(10,3,'AÑO',1,0,'C');
 
$pdf->SetFont('Arial','B',5);
$pdf->Cell(20,3,'AÑOS',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(20,3,'MESES',1,0,'C');

$pdf->SetFont('Arial','B',7);
$pdf->Cell(30,3,'',1,1,'C');

/*--------------------------------------------------*/

$pdf->SetFont('Arial','',5);
$pdf->Cell(10,7,$_SESSION['PDF_dia'],1,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(10,7,$_SESSION['PDF_mes'],1,0,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(10,7,$_SESSION['PDF_anio'],1,1,'C');

/*--------------------------------------------------*/
$pdf->SetFont('Arial','',5);
$pdf->Cell(30,4,'',1,0,'C');

/*--------------------------------------------------*/

$pdf->SetFont('Arial','',5);
$pdf->SetXY(37,183);
$pdf->Cell(20,3.5,$_SESSION['PDF_ant_int_anio'][0],1,1,'C');

$pdf->SetFont('Arial','',5);
$pdf->SetXY(57,183);
$pdf->Cell(20,3.5,$_SESSION['PDF_ant_int_mes'][0],1,1,'C');

$pdf->SetFont('Arial','',5);
$pdf->SetXY(77,183);
$pdf->Cell(30,3.5,'Interna',1,1,'C');

/*--------------------------------------------------*/

$pdf->SetFont('Arial','',5);
$pdf->SetXY(37,186.5);
$pdf->Cell(20,3.5,$_SESSION['PDF_ant_ext_anio'],1,1,'C');

$pdf->SetFont('Arial','',5);
$pdf->SetXY(57,186.5);
$pdf->Cell(20,3.5,$_SESSION['PDF_ant_ext_mes'],1,1,'C');

$pdf->SetFont('Arial','',5);
$pdf->SetXY(77,186.5);
$pdf->Cell(30,3.5,'Externa',1,1,'C');

/*--------------------------------------------------*/

$pdf->SetFont('Arial','',5);
$pdf->SetXY(37,190);
$pdf->Cell(20,4,$_SESSION['PDF_ant_acum_anio'],1,1,'C');

$pdf->SetFont('Arial','',5);
$pdf->SetXY(57,190);
$pdf->Cell(20,4,$_SESSION['PDF_ant_acum_anio'],1,1,'C');

$pdf->SetFont('Arial','',5);
$pdf->SetXY(77,190);
$pdf->Cell(30,4,'Acumulada',1,1,'C');

/*--------------------------------------------------*/

$pdf->SetXY(107,179);
$pdf->Cell(100,6,'','LR',1,'R');

$pdf->SetXY(107,182);
$pdf->Cell(30,6,'Total por tomar: ','L',0,'R');

$pdf->SetXY(137,182);
$pdf->Cell(10,6,$total_x_tomar,0,0,'C');

$pdf->SetXY(147,182);
$pdf->Cell(30,6,' días',0,0,'L');

$pdf->SetXY(177,182);
$pdf->Cell(30,6,'','R',1,'L');


$pdf->SetXY(107,185);
$pdf->Cell(30,6,'Toma:: ','L',0,'R');

$pdf->SetXY(137,185);
$pdf->Cell(10,6,$suma,0,0,'C');

$pdf->SetXY(147,185);
$pdf->Cell(30,6,' días',0,0,'L');

$pdf->SetXY(177,185);
$pdf->Cell(30,6,'Saldo: '.$_SESSION['PDF_dias_comp'],'R',1,'L');


$pdf->SetXY(107,188);
$pdf->Cell(100,6,'','LR',1,'R');

/*--------------------------------------------------*/

$pdf->SetFont('Arial','B',5);
$pdf->Cell(200,10,'OBSERVACIONES: '.$_SESSION['PDF_obs'],1,1,'L');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(50,4,'FIRMA SOLICITANTE',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(50,4,'RESPONSABLE DEL CENTRO',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(50,4,'ADMINISTRACIÓN DE PERSONAL',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(50,4,'FIRMA AUTORIZADA',1,1,'C');

/*--------------------------------------------------*/

$pdf->SetFont('Arial','B',5);
$pdf->Cell(50,15,'',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(50,15,'',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(50,15,'',1,0,'C');

$pdf->SetFont('Arial','B',5);
$pdf->Cell(50,15,'',1,1,'C');

/*--------------------------------------------------*/
$pdf->SetFont('Arial','',5);
$pdf->Cell(200,10,'COPIA',0,1,'R');

// FIN COPIA

$pdf->Output();		
?>

