<?php

session_start();
require('../../../lib/fpdf/fpdf.php');
require('../../../lib/funciones.inc.php');
include_once("../../../lib/configuracion.log.php");
include_once("../LibModeloContabilidad.php");
class PDF extends FPDF
{
		var  $posicionDebe=0;
		var  $posicionHaber=0;
		
var $inicioX=10;
var $inicioY=75;
var $inicioY1=75;
var $inicioY2=75;
var $nivel=7;
var $nro_cuenta;
var $nombre_cuenta;
var $importe_cuenta;
var $bandera;
var $cantidad_cuenta;
var $bandera_rubro=0;
var $rubro;
var $nombre_rubro;
var $importe_rubro=0;
var $ancho_columna_mes=14;
var $cuenta_ban='no';
	
	 
//Cabecera de página
function Header()
{
	$this->SetLeftMargin(8);//margen izquierdo
	$funciones = new funciones();
    //Logo
    $this->Image('../../../lib/images/logo_reporte.jpg',180,4,36,15);
 
    //$this->Image('../../../lib/images/logo_reporte_factur.jpg',210,5);//llama al logo
    //Arial bold 15
    $this->SetFont('Arial','B',12);//tifo de fuente
    //Movernos a la derecha
	$this->Ln(3);//salto de linea 
    //$this->Cell(100);//celda de dibujo
    $this->SetFont('Arial','I',7);
     $this->SetFont('Arial','B',12);//tifo de fuente
    $this->Cell(0,7,'SALDOS BANCARIOS POR PERIODO',0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 

    $this->SetFont('Arial','I',7);
    $this->Ln();
    $this->Cell(0,5,'(Expresado en '.$_SESSION['desc_moneda'].", Gestión:".$_SESSION['gestion']." )",0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
  
    $this->Ln(6);
      $this->SetFont('Arial','I',7);
    	
     $epe=" ";   
      $bandera=false;
 	
	$this->SetFont('Arial','B',7);
	$this->SetX($this->inicioX);
	$this->Cell(60,5,'CUENTA BANCARIA',1,0,'C',0);
	$this->Cell(25,5,'PERIODO',1,0,'C',0);
	$this->Cell(25,5,'INGRESO',1,0,'C',0);
	$this->Cell(25,5,'EGRESO',1,0,'C',0);
	$this->Cell(25,5,'SALDO',1,0,'C',0);
	$this->Cell(30,5,'SALDO ACUMULADO',1,0,'C',0);
	
	$this->SetFont('Arial','',5);
	      
	$this->SetY(31);
        
  }

function mes($numero){
	if ($numero==1){
		return 'ENERO';
	}
	if ($numero==1){
		return 'FEBRERO';
	}
	if ($numero==2){
		return 'FEBRERO';
	}
	if ($numero==3){
		return 'MARZO';
	}
	if ($numero==4){
		return 'ABRIL';
	}
	if ($numero==5){
		return 'MAYO';
	}
	if ($numero==6){
		return 'JUNIO';
	}
	if ($numero==7){
		return 'JULIO';
	}
	if ($numero==8){
		return 'AGOSTO';
	}
	if ($numero==9){
		return 'SEPTIEMBRE';
	}
	if ($numero==10){
		return 'OCTUBRE';
	}
	if ($numero==11){
		return 'NOVIEMBRE';
	}
	if ($numero==12){
		return 'DICIEMBRE';
	}
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
//	$this->SetFillColor(224,235,255);//color de fondo las celdas 
  //  $this->SetTextColor(0);//color de la letra
    //$this->SetDrawColor(128,0,0);//rgv color de dibujo
	 $this->SetFont('Arial','',5);
	   $cant = 1000000;
 	   $puntero = 0;
 	   $sortcol = 'nro_cuenta';
 	   $sortdir = 'asc';
	$cond = new cls_criterio_filtro($decodificar);
//	$cond->add_criterio_extra("PRESUP.tipo_pres",$tipo_pres);
	 $criterio_filtro = $cond -> obtener_criterio_filtro();
	 $criterio_filtro=$criterio_filtro." ";
	 
	 $res = $Custom->ListarSaldosBancariosPeriodo(	$cant,$puntero,$sortcol,$sortdir,$criterio_filtro,
	 									$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad, 
	 									$_SESSION['ids_ctaban'],$_SESSION['id_moneda'],$_SESSION['fecha_trans'],
	 									$_SESSION['id_reporte_eeff'], $_SESSION['id_parametro'],$_SESSION['nivel'],
	 									$_SESSION['ids_periodo'],$_SESSION['sw_actualizacion']);
	//echo $Custom->query; exit();
	   if($res){
					$this->SetFillColor(224,235,255);//color de fondo las celdas  
				 	$data=$Custom->salida;
					$indice_data=1;
				 	foreach($data as $row)
				 	{   	$this->SetX($this->inicioX); 
				 		   
				 		if ($cuenta_ban=="no"){
				 			$this->Cell(60,3,$row[1],1,0,'L',0);
				 			//$this->Ln();//salto de linea
				 			$this->Cell(60,3,"",0,0,'L',$fill); 	
						   	$this->Cell(25,3,$this->mes($row[2]),0,0,'L',$fill);
						   	$this->Cell(25,3,$row[3],1,0,'R',$fill);
						   	$this->Cell(25,3,$row[4],1,0,'R',$fill);
						   	$this->Cell(25,3,$row[5],1,0,'R',$fill);
						   	$this->Cell(30,3,$row[6],1,0,'R',$fill);
						   	$cuenta_ban=$row[1];				   
					 		$this->Ln(1);//salto de linea 
				 	   	    $fill=!$fill;					 
				 		}
				 		if($cuenta_ban==$row[1]){
				 			//$this->Cell(50,3,$row[0],0,0,'L',$fill);
						   	$this->Cell(60,3,"",0,0,'L',0);
						   	$this->Cell(25,3,$this->mes($row[2]),1,0,'L',$fill);
						   	$this->Cell(25,3,number_format($row[3],2),1,0,'R',$fill);
						   	$this->Cell(25,3,number_format($row[4],2),1,0,'R',$fill);
						   	$this->Cell(25,3,number_format($row[5],2),1,0,'R',$fill);
						 	$this->Cell(30,3,number_format($row[6],2),1,0,'R',$fill);
						   	$cuenta_ban=$row[1];				   
				 	   	    $fill=!$fill;					 
					 		$this->Ln();//salto de linea 	
				 		}
				 		if($cuenta_ban!=$row[1]){
				 			//$this->Cell(50,3,$row[0],0,0,'L',$fill); 
				 			 	$this->Ln(2);//salto de linea
						   	$this->Cell(60,3,$row[1],1,0,'L',$fill);
						   	$this->Ln();//salto de linea
				 			$this->Cell(60,3,"",0,0,'L',0);
						   	$this->Cell(25,3,$this->mes($row[2]),1,0,'L',$fill);
						  	$this->Cell(25,3,number_format($row[3],2),1,0,'R',$fill);
						   	$this->Cell(25,3,number_format($row[4],2),1,0,'R',$fill);
						   	$this->Cell(25,3,number_format($row[5],2),1,0,'R',$fill);
						 	$this->Cell(30,3,number_format($row[6],2),1,0,'R',$fill);
						   	$cuenta_ban=$row[1];				   
				 	   	    $fill=!$fill;
				 	   	    $this->Ln();//salto de linea
				 		}	
				 	}	
	}
 //  	$this->line(8,$this->GetY(),273,$this->GetY()); 	
}

    function VerificarLinea($row)
    {
    	$band=false;
    	for($i=0;$i<13;$i++)
    	{
    		if($row[$i]!="")
    		{
    			$band=true;
    		}
    		
    	}
    	return $band;
    }
}

 
	//Creación del objeto de la clase heredada
$pdf=new PDF('P','mm','Letter');// main (posicion de la pagina,unidad de medida,tamaño)

$pdf->AliasNbPages();//contador de pagina 

$pdf->AddPage('P');//para modificar la orienacion de la pagina
$pdf->SetMargins(10,10,10,10);
$pdf->SetAutoPageBreak(true,17);
$pdf->SetFont('Times','',12);
$pdf->maestro();//es una funcion en la cual se crea el reporte
//$pdf->FancyTable($header,$data);

//$pdf->SetRightMargin(10);
$pdf->Output();//mostrar el reporte
	
 
?>



 
