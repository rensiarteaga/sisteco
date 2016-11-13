<?php

session_start();
require('../../../lib/fpdf/fpdf.php');
require('../../../lib/funciones.inc.php');
include_once("../../../lib/configuracion.log.php");
include_once('../LibModeloContabilidad.php');
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
		$this->SetLeftMargin(20);
		$funciones = new funciones();
	    //Logo
	    $this->Image('../../../lib/images/logo_reporte_factur.jpg',170,2,35,15);
	    //Arial bold 15
	    $this->SetFont('Arial','B',12);
	    //Movernos a la derecha
	    $this->Cell(85);
	    
	    $this->Cell(5,13,' AUXILIARES DE CUENTAS',0,0,'C');
	    $this->Ln(7);
	    $this->Cell(94);
	    $this->SetFont('Arial','I',9);
	    
	   // $inicio = $this->Mes_literal($_SESSION['periodo']);		
	    $this->Cell(94);
	
	    $this->Ln(8);
	    $this->line(20,22,190,22);
	   
	    //$this->Cell(10);
	    $this->line(20,22,20,31);
	    $this->line(190,22,190,31);
	    $this->SetFont('Arial','B',8);
	    $this->Cell(10,11,'Nº',0,0,'C',0);
	    $this->Cell(40,11,'CODIGO',0,0,'C',0);
	    $this->Cell(80,11,'AUXILIAR',0,0,'C',0);
	    $this->Cell(40,11,'ESTADO',0,0,'C',0);
	   // $this->Cell(35,11,'IDENTIFICADOR',0,0,'C',0);
	   // $this->Cell(40,11,'UNIDAD',0,0,'C',0);	    
	  //  $this->Cell(30,11,'PARTIDA',0,0,'C',0);	    
	    //$this->Cell(70,11,'CUENTA ACTIVO',0,0,'C',0);	    
	  //  $this->Cell(25,11,'AUXILIAR',0,0,'C',0);	    
	   // $this->Cell(70,11,'CUENTA GASTO',0,0,'C',0);	 210   
	    //$this->Cell(25,11,'AUXILIAR',0,0,'C',0);	    
	    	   
	   
	    //$this->Cell(35,11,'1',0,0,'C',0);
	   // $this->Cell(40,11,'ORGANIZACIONAL',0,0,'C',0);	   
	   // $this->Cell(30,11,'',0,0,'C',0);
	    //$this->Cell(70,11,'AUXILIAR ACTIVO',0,0,'C',0);	    
	   // $this->Cell(25,11,'ACTIVO',0,0,'C',0);	    
	   // $this->Cell(25,11,'GASTO',0,0,'C',0);	    
	   // $this->Cell(70,11,'AUXILIAR GASTO',0,0,'C',0);	    
	   
	    $this->line(20,27,190,27);
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
		$Custom = new cls_CustomDBContabilidad();		
		
		$cant = 100000;
		$puntero = 0;
		$sortcol = 'codigo_auxiliar';
		$sortdir = 'asc';
		$criterio_filtro=$_SESSION['criterio_filtro'];
		//echo $criterio_filtro;exit;
		$res=$Custom->ContarAuxiliar($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		
    	if($res) $total_count= $Custom->salida;
		
		while($total_count>=$puntero)
    	{	
    		$res = $Custom->ListarAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
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
		$Custom = new cls_CustomDBContabilidad();
		$contador = $puntero;
		$funciones = new funciones();
	    $cont=1;
		
	    $this->SetLineWidth(.1);
	    $this->SetFont('Arial','',7);
	    //Restauración de colores y fuentes
	    $this->SetFillColor(224,235,255);
	    $this->SetTextColor(0);
	    $this->SetDrawColor(0,0,0);	    
	    $fill=0;
	    
	    foreach($data as $row)
	    {	
	    	if ($row[3]==1){$row[3]="Activo";}
	    	if ($row[3]==2){$row[3]="Inactivo";}
	    	
	    	$this->SetFont('Arial','',6);    		
    		$this->Cell(20,5,$this->cont,'L',0,'L',$fill);
	        //supergrupo
	        $this->Cell(40,5,$row[1],'0',0,'L',$fill);
	        //grupo
	        $this->Cell(80,5,$row[2],0,0,'L',$fill);
	        //subgrupo
	        $this->Cell(30,5,$row[3],'R',0,'L',$fill);
	        //id1
	      //  $this->Cell(40,5,$row[10],0,0,'L',$fill);
	        //unidad org
	       // $this->Cell(50,5,$row[26],'0',0,'L',$fill);
	         //partida
	        //$this->Cell(40,5,$row[19],'0',0,'L',$fill);
	        //cuenta ac
	       // $this->Cell(60,5,$row[17],0,0,'L',$fill);
	        //cuenta gast
	       // $this->Cell(60,5,$row[24],'R',0,'L',$fill);
	        $this->Ln();
	        
	    
	       $this->cont=$this->cont+1;
        	//$fill=!$fill;
	    	if($contador==$total_count-1)
	    	{
	    		$this->Cell(10,1,'','T',0,'R',$fill);
		        $this->Cell(40,1,'','T',0,'R',$fill);
		        $this->Cell(80,1,'','T',0,'C',$fill);
		        $this->Cell(40,1,'','T',0,'L',$fill);
		        
		         $this->Ln();
		           		
	    	}
	    	$contador++;
    	}
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
		$this->Cell(50,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L'); 
	    $this->Cell(90,10,'Página '.$this->PageNo().' de {nb}',0,0,'C');     
	    $this->Cell(50,10,'Fecha: '.$fecha ,0,0,'C');
	    $this->ln(3);
	    $this->Cell(50,10,'Sistema: ENDESIS - ALMIN',0,0,'L'); 
	    $this->Cell(90,10,'',0,0,'C');
	    $this->Cell(50,10,'Hora: '.$hora ,0,0,'C');	    	   
	}
}

//Creación del objeto de la clase heredada
$pdf=new PDF('L','mm','Letter');

$pdf->AliasNbPages();

$pdf->AddPage('P');
$pdf->SetFont('Times','',12);
$pdf->SetAutoPageBreak(true,25);
$pdf->maestro();
$pdf->Output();
?>
