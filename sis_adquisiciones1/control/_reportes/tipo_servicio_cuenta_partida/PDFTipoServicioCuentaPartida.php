<?php

session_start();
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once('../../LibModeloAdquisiciones.php');
//echo llega;

class PDF extends FPDF
{
	var $total_consumo=0;
	var $total_importe=0;
	var $total_valorado=0;
	var $cuenta_anterior='';
	var $primera_vez=0;
	var $cont=1;
	var $contador=0;
	var $total_count=0;	
	var $inicio='';
	var $fin='';
	var $mes_literal='';
	var $cantidad_meses='';
	var $categoria='';
	var $ruta='';
	//Cabecera de página
	
	function Header()
	{
		$this->SetLeftMargin(5);
		$funciones = new funciones();
	    //Logo
	    $this->Image('../../../../lib/images/logo_reporte_factur.jpg',285,2);
	    //Arial bold 15
	    $this->SetFont('Arial','B',12);
	    //Movernos a la derecha
	    $this->Cell(85);
	    
	    $this->Cell(140,13,'TIPO SERVICIO CUENTA PARTIDA',0,0,'C');
	    $this->Ln(7);
	    $this->Cell(94);
	    $this->SetFont('Arial','I',9);
	    
	   // $inicio = $this->Mes_literal($_SESSION['periodo']);		
	    $this->Cell(94);
	
	    $this->Ln(8);
	    $this->line(5,22,350,22);
	   
	    //$this->Cell(10);
	    $this->line(5,22,5,31);
	    $this->line(350,22,350,31);
	    $this->SetFont('Arial','B',8);
	    $this->Cell(10,11,'Nº',0,0,'C',0);
	    $this->Cell(70,11,'SERVICIO',0,0,'C',0);
	    $this->Cell(60,11,'UNIDAD ORGANIZACIONAL',0,0,'C',0);
	    $this->Cell(90,11,'PARTIDA',0,0,'C',0);
	    $this->Cell(70,11,'CUENTA',0,0,'C',0);
	    $this->Cell(30,11,'AUXILIAR',0,0,'C',0);	    
	    	   
	    $this->Ln(4);
	    
	    $this->Cell(10,11,'',0,0,'C',0);
	    $this->Cell(15,11,'',0,0,'C',0);
	    $this->Cell(30,11,'',0,0,'C',0);
	    $this->Cell(55,11,'',0,0,'C',0);
	    $this->Cell(48,11,'',0,0,'C',0);
	    $this->Cell(25,11,'',0,0,'C',0);	   
	    
	   
	    $this->line(5,31,350,31);
	    $this->Ln(8);
	}
	
	function Mes_literal($mes)
	{			
		switch ($mes){
	     case 1:
				return $mes_literal="Enero";         
	         break;
	     case 2:
				return $mes_literal="Febrero";         
	         break;
	     case 3:
				return $mes_literal="Marzo";         
	         break;
	     case 4:
				return $mes_literal="Abril";         
	         break;
	     case 5:
				return $mes_literal="Mayo";         
	         break;
	     case 6:
				return $mes_literal="Junio";         
	         break;
	     case 7:
				return $mes_literal="Julio";         
	         break;
	     case 8:
				return $mes_literal="Agosto";         
	         break;
	     case 9:
				return $mes_literal="Septiembre";         
	         break;
	     case 10:
				return $mes_literal="Octubre";         
	         break;
	     case 11:
				return $mes_literal="Noviembre";         
	         break;
	     case 12:
				return $mes_literal="Diciembre";         
	         break;
	         default:
	          echo 'No Hay ';       
		}	
	}	
	
	function maestro()
	{		
		$Custom = new cls_CustomDBAdquisiciones();		
		
		$cant = 100000;
		$puntero = 0;
		$sortcol = 'desc_servicio';
		$sortdir = 'asc';
		$criterio_filtro='0=0';
		
		$res=$Custom->ContarTipoServicioCuentaPartida($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		
    	if($res) $total_count= $Custom->salida;
		
		while($total_count>=$puntero)
    	{	
    		$res = $Custom->ListarTipoServicioCuentaPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
			//echo "aqui";
    		//echo $res; exit;
    		if($res)
    		{
				$data=	$Custom->salida;
				$this->FancyTable($data,$ban,$total_count,$puntero);
				$ban++;
				//$this->FancyTable($data);
				if($puntero==0)
				{
					$this->cuenta_anterior=$data[0][0];
					$this->primera_vez=1;
				}
			}
			$puntero=$puntero+1000;	
		}
	}
	
	function FancyTable($data,$van,$total_count,$puntero)	
	{
		$contador = $puntero;
		$funciones = new funciones();
	    $cont=1;
		
	    $this->SetLineWidth(.1);
	    $this->SetFont('Arial','',5);
	    //Restauración de colores y fuentes
	    $this->SetFillColor(224,235,255);
	    $this->SetTextColor(0);
	    $this->SetDrawColor(0,0,0);	    
	    $fill=0;
		   
		 $this->SetVisibles(array(1,1,1,1,1,1,1));
	    $this->SetWidths(array(7,73,65,95,70,35));
	    $this->SetFills(array(1,1,1,1,1,1));		
		$this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial'));
		$this->SetFontsStyles(array('','','','','',''));
	    $this->SetFontsSizes(array(5,5,5,5,5,5));
		$this->SetSpaces(array(3,3,3,3,3,3));
		$this->SetDecimales(array(0,0,0,0,0,0));
	    $this->SetFormatNumber(array(0,0,0,0,0,0));
//	$pdf->SetAligns(array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R'));
		
	   for ($j=0;$j<sizeof($data);$j++)
	    {	
	    	$data_mod[$j][0]=$j+1;
			$data_mod[$j][1]=$data[$j][18];
			$data_mod[$j][2]=$data[$j][20];
			$data_mod[$j][3]=$data[$j][4];
			$data_mod[$j][4]=$data[$j][2];
			$data_mod[$j][5]=$data[$j][14];
		
    	}
		
		 for ($i=0;$i<sizeof($data_mod);$i++)
	    {
	    	//a los registros pares los pintamos de celeste
			if(($i % 2)==0)
			{
				$this->SetFillColor(224,235,255);//color de fondo las celdas 
				//$pdf->SetFillColor(168,199,255);//color de fondo las celdas 
			}
			else  //a los registos impares con fondo blanco
			{
				$this->SetFillColor(255,255,255);//color de fondo las celdas 
			}
			
			//a las partidas agrupadoras les damos un fotmato diferenete 
			/*if($detalle_documentos[$i][3]!=1)
			{
				$pdf->SetFontsStyles(array('BU','B','BU','BU','BU','BU','BU','BU','BU','BU','BU','BU','BU','BU'));
			}		
				*/
			$this->Multitabla($data_mod[$i],0,5,3,5,1);
			//$pdf->SetFontsStyles(array('','','','','','','','','','','','','','',''));		
		}
		
		
		
	   /* foreach($data as $row)
	    {	
	    	$this->SetFont('Arial','',6);    		
    		$this->Cell(7,5,$this->cont,'L',0,'L',$fill);
	        //servicio
	        $this->Cell(73,5,$row[18],'0',0,'L',$fill);
	        //unidad
	        $this->Cell(65,5,$row[20],0,0,'L',$fill);
	        //partida
	        $this->Cell(95,5,$row[4],0,0,'L',$fill);
	        //cuenta
	        $this->Cell(70,5,$row[2],0,0,'L',$fill);
	        //mauxiliar
	        $this->Cell(35,5,$row[14],'R',0,'L',$fill);
	         $this->Ln();
	    
	       $this->cont=$this->cont+1;
        	$fill=!$fill;
	    	if($contador==$total_count-1)
	    	{
	    		$this->Cell(7,1,'','T',0,'R',$fill);
		        $this->Cell(73,1,'','T',0,'R',$fill);
		        $this->Cell(48,1,'','T',0,'C',$fill);
		        $this->Cell(50,1,'','T',0,'L',$fill);
		        $this->Cell(54,1,'','T',0,'L',$fill);
		        $this->Cell(30,1,'','T',0,'R',$fill);
		         $this->Ln();
		           		
	    	}
	    	$contador++;
    	}*/
    }
	    
	    //Pie de página
	function Footer()
	{
	    //Posición: a 1,5 cm del final
	    $this->SetY(-15);
	    //Arial italic 8
	    $this->SetFont('Arial','I',8);
	    //ip
	    $ip = captura_ip();
	  
		//Número de página
	    $fecha=date("d-m-Y");		
	    $hora=date("H:i:s");
		$this->Cell(80,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L'); 
	    $this->Cell(200,10,'Página '.$this->PageNo().' de {nb}',0,0,'C');     
	    $this->Cell(85,10,'Fecha: '.$fecha ,0,0,'C');
	    $this->ln(3);
	    $this->Cell(80,10,'Sistema: ENDESIS - COMPRO',0,0,'L'); 
	    $this->Cell(200,10,'',0,0,'C');
	    $this->Cell(85,10,'Hora: '.$hora ,0,0,'C');	    	   
	}
}

//Creación del objeto de la clase heredada
$pdf=new PDF('L','mm','Legal');

$pdf->AliasNbPages();

$pdf->AddPage('L');
$pdf->SetFont('Times','',12);
$pdf->SetAutoPageBreak(true,25);
$pdf->maestro();
$pdf->Output();
?>
