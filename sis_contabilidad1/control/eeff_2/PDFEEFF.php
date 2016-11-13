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

	
	 
//Cabecera de página
function Header()
{
	$this->SetLeftMargin(8);//margen izquierdo
	$funciones = new funciones();
    //Logo
    	$this->Image('../../../lib/images/logo_reporte.jpg',170,5,36,10);
    //$this->Image('../../../lib/images/logo_reporte_factur.jpg',210,5);//llama al logo
    //Arial bold 15
    $this->SetFont('Arial','B',12);//tifo de fuente
    //Movernos a la derecha
	$this->Ln(3);//salto de linea 
    //$this->Cell(100);//celda de dibujo
    //$this->Cell(0,7,"Empresa Nacional de Electricidad ",0,0,'L'); 
    $this->Ln();
    $this->Cell(0,7,$_SESSION['EEFF'],0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
    $this->SetFont('Arial','I',10);
    $this->Ln();
    $this->Cell(0,5,'Al '.$_SESSION['fecha_trans'],0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
    $this->SetFont('Arial','I',7);
    $this->Ln();
    $this->Cell(0,5,'(Expresado en '.$_SESSION['desc_moneda'].")",0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
    				
			 	
    
    
    $this->Ln(10);
      $this->SetFont('Arial','I',7);
    	
     $epe=" ";   
      $bandera=false;
     if($_SESSION['regional']){$epe=$epe." \n "." REGIONAL: ".$_SESSION['regional'];$bandera=true;}
       	if($_SESSION['financiador']){
     	if($bandera){$epe=$epe." \n "." FINANCIADOR: ".$_SESSION['financiador'];	
     	}else{$epe=$epe." FINANCIADOR: ".$_SESSION['financiador'];}
     	}
     			
		if($_SESSION['programa']){
     	if($bandera){$epe= $epe." \n "." PROGRAMA: ".$_SESSION['programa'];	
     	}else{$epe=$epe." PROGRAMA: ".$_SESSION['programa'];}
     	}	 
		if($_SESSION['programa']){
     	if($bandera){$epe=$epe." \n "." SUBPROGRAMA: ".$_SESSION['proyecto'];	
     	}else{$epe=$epe." SUBPROGRAMA: ".$_SESSION['proyecto'];}
     	}	
     	if($_SESSION['actividad']){
     	if($bandera){$epe=$epe." \n "." ACTIVIDAD: ".$_SESSION['actividad'];	
     	}else{$epe=$epe." ACTIVIDAD: ".$_SESSION['actividad'];}
     	}
  	   if($epe==" "){$epe="Todos";};
    	$this->Cell(45,4,'ESTRUCTURA PROGRAMATICA: ',0,0,'L',0);
    	
    	$this->MultiCell(200,3,$epe);
    	$this->Ln();
       	$this->Cell(45,4,'UNIDAD ORGANIZACIONAL:',0,0,'L',0);
        $this->MultiCell(200,3,$_SESSION['unidad_organizacional'] );
        $this->Ln();
		$this->Cell(45,4,'FUENTE DE FINANCIAMIENTO:',0,0,'L',0);
        $this->MultiCell(200,3,$_SESSION['Fuente_financiamiento']);
			$this->Ln();
	         if ($_SESSION['nivel']>3)
	         { 
	         	 $this->SetFont('Arial','B',7);
				$this->SetX($this->inicioX);
				$this->Cell(20,5,'CUENTA',1,0,'C',0);
				$this->Cell(70,5,'DETALLE',1,0,'C',0);
				$this->Cell(5,5,'',1,0,'C',0);
				$this->Cell(80,5,'PARCIAL',1,0,'C',0);
				$this->Cell(20,5,'TOTAL',1,0,'C',0);
				 $this->SetFont('Arial','',6);
	         }
			$this->Ln();
        
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
	 $this->SetFont('Arial','',6);

	   $cant = 15;
 	   $puntero = 0;
 	   $sortcol = 'id_rubro_cuenta';
 	   $sortdir = 'asc';
	 
	
	 
	$cond = new cls_criterio_filtro($decodificar);
//	$cond->add_criterio_extra("PRESUP.tipo_pres",$tipo_pres);
	 $criterio_filtro = $cond -> obtener_criterio_filtro();
	 $criterio_filtro=$criterio_filtro." and  RUBCUE.id_rubro in
(SELECT id_rubro FROM sci.tct_rubro where id_reporte_eeff=".$_SESSION['id_reporte_eeff'].")";
	 $res = $Custom->ListarRubroCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,
	 $hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	 // $res = $Custom->ListarConsiliacionPartida($_SESSION['limit'],$_SESSION['start'],'codigo_partida','asc',$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$_SESSION['tipo_pres'],$_SESSION['id_parametro'],$_SESSION['id_moneda'],$_SESSION['ids_fuente_financiamiento'],$_SESSION['ids_u_o'],$_SESSION['ids_financiador'],$_SESSION['ids_regional'],$_SESSION['ids_programa'],$_SESSION['ids_proyecto'],$_SESSION['ids_actividad'],$_SESSION['sw_vista'],$_SESSION['ids_concepto_colectivo']);

	if ($_SESSION['nivel']<=3){ 
	 	$posx1=70;
	   $posx2=130;
	   $anchoX=20;
	   $columnasX=3;
	   
		$this->SetX($this->inicioX);
		$this->Cell(20,5,'CUENTA',1,0,'C',0);
		$this->Cell(50,5,'DETALLE',1,0,'C',0);
		$this->Cell(40,5,'PARCIAL',1,0,'C',0);
		$this->Cell(20,5,'TOTAL',1,0,'C',0);
		
		$this->Cell(20,5,'CUENTA',1,0,'C',0);
		$this->Cell(50,5,'DETALLE',1,0,'C',0);
		$this->Cell(40,5,'PARCIAL',1,0,'C',0);
		$this->Cell(20,5,'TOTAL',1,0,'C',0);
		
	 if($res){
	 	$data=$Custom->salida;
		foreach($data as $row)
		{	 
	
		
			
			if ($row[5]==1) {$this->inicioX=10;}
			if ($row[5]==2) {$this->inicioX=140;}
				
			$res = $Custom->listarEEFFCuenta($_SESSION['id_parametro'],$_SESSION['id_moneda'],$_SESSION['ids_fuente_financiamiento'],$_SESSION['ids_u_o'],$_SESSION['ids_financiador'],$_SESSION['ids_regional'],$_SESSION['ids_programa'],$_SESSION['ids_proyecto'],$_SESSION['ids_actividad'],$_SESSION['fecha_trans'],$_SESSION['nivel'],$row[3],$_SESSION["ss_id_usuario"]);
			$data_cuenta =$Custom->salida;
			foreach($data_cuenta as $row_cuenta)
			{
			$this->Ln();
			if ($row[5]==1) {$this->SetXY($this->inicioX,$this->inicioY1); }
			if ($row[5]==2) {$this->SetXY($this->inicioX,$this->inicioY2); }
			
			
			
			$this->Cell(20,3,$row_cuenta[2],0,0,'L',0);
			$this->Cell(50,3,$row_cuenta[3],0,0,'L',0);
			$this->SetX($this->inicioX+$posx1+$anchoX*($columnasX-$row_cuenta[4]-1));
			$this->Cell(40,3,number_format($row_cuenta[5],2),0,0,'R',0);
			
			if ($row[5]==1) {$this->inicioY1=$this->inicioY1+3;}
			if ($row[5]==2) {$this->inicioY2=$this->inicioY2+3;}
			//$this->Cell(20,5,$row_cuenta[3],1,0,'C',0);
	   	    $fill=!$fill;
	   	    }
	    }
	}
	}
	else {
		$posx1=95;
	   $anchoX=20;
	   $columnasX=5;
	 
		
	   if($res){
		 
	 	$data=$Custom->salida;
		$indice_data=1;
	 	foreach($data as $row)
		{


			$res = $Custom->ContarEEFFCuenta($_SESSION['id_parametro'],$_SESSION['id_moneda'],$_SESSION['ids_fuente_financiamiento'],$_SESSION['ids_u_o'],$_SESSION['ids_financiador'],$_SESSION['ids_regional'],$_SESSION['ids_programa'],$_SESSION['ids_proyecto'],$_SESSION['ids_actividad'],$_SESSION['fecha_trans'],$_SESSION['nivel'],$row[3],$_SESSION["ss_id_usuario"]);
			if($res) $this->cantidad_cuenta= $Custom->salida;
			$res = $Custom->listarEEFFCuenta($_SESSION['id_parametro'],$_SESSION['id_moneda'],$_SESSION['ids_fuente_financiamiento'],$_SESSION['ids_u_o'],$_SESSION['ids_financiador'],$_SESSION['ids_regional'],$_SESSION['ids_programa'],$_SESSION['ids_proyecto'],$_SESSION['ids_actividad'],$_SESSION['fecha_trans'],$_SESSION['nivel'],$row[3],$_SESSION["ss_id_usuario"]);
				$data_cuenta =$Custom->salida;
				$this->nivel=7-$_SESSION['nivel'];
				foreach($data_cuenta as $row_cuenta)
				{
			 
					$this->Ln();
					$this->SetX($this->inicioX);
					if($this->bandera==0)
					{
					
					$this->nro_cuenta=$row_cuenta[2];
					$this->nombre_cuenta=$row_cuenta[3];
					$this->importe_cuenta=$row_cuenta[5];	
					$this->importe_rubro=$this->importe_rubro+$row_cuenta[5];	
					$this->nivel=$row_cuenta[4];
					$this->bandera++;
					/*$this->Cell(20,3,$this->nro_cuenta,0,0,'L',0);
					$this->Cell(50,3,$this->nombre_cuenta,0,0,'L',0);
					$this->SetX($this->inicioX+$posx1+$anchoX*($columnasX-$this->nivel));
					$this->Cell(20,3,number_format($this->importe_cuenta,2),'B',0,'R',0);*/
					} 
					else 
					{
						if ($this->nivel>$row_cuenta[4] ){
							$this->Cell(20,3,$this->nro_cuenta,0,0,'L',0);
							$this->Cell(50,3,$this->nombre_cuenta,0,0,'L',0);
							$this->SetX($this->inicioX+$posx1+$anchoX*($columnasX-$this->nivel));
							$this->Cell(20,3,number_format($this->importe_cuenta,2),'B',0,'R',0);
							$this->nro_cuenta=$row_cuenta[2];
							$this->nombre_cuenta=$row_cuenta[3];
							$this->importe_cuenta=$row_cuenta[5];	
							$this->nivel=$row_cuenta[4];
							$this->bandera++;
							}
							else {
							$this->Cell(20,3,$this->nro_cuenta,0,0,'L',0);
							$this->Cell(50,3,$this->nombre_cuenta,0,0,'L',0);
							$this->SetX($this->inicioX+$posx1+$anchoX*($columnasX-$this->nivel));
							$this->Cell(20,3,number_format($this->importe_cuenta,2),0,0,'R',0);
								
							$this->nro_cuenta=$row_cuenta[2];
							$this->nombre_cuenta=$row_cuenta[3];
							$this->importe_cuenta=$row_cuenta[5];	
							$this->nivel=$row_cuenta[4];
							$this->bandera++;
							}	
					}
					
					if($this->bandera==$this->cantidad_cuenta)
					{	$this->Ln();
						$this->SetX($this->inicioX);
							$this->Cell(20,3,$this->nro_cuenta,0,0,'L',0);
							$this->Cell(50,3,$this->nombre_cuenta,0,0,'L',0);
							$this->SetX($this->inicioX+$posx1+$anchoX*($columnasX-$this->nivel));
							$this->Cell(20,3,number_format($this->importe_cuenta,2),'B',0,'R',0);
							$this->nro_cuenta='';
							$this->nombre_cuenta='';
							$this->importe_cuenta='';	
							$this->nivel='';
							$this->bandera=0;
						
					}	
			 
				
				
				//$this->Cell(20,5,$row_cuenta[3],1,0,'C',0);
		   	    $fill=!$fill;
		   	    }


 
		   	    
		 
		 		if ( $data[ $indice_data][1] != $row[1])
					{
						 
					$this->Ln();	
					$this->SetX($this->inicioX);	   	    
					$this->SetFont('Arial','B',6);
					$this->Cell(175,3,"TOTAL ".$row[2] ,'B',0,'L',0);  
					$this->Cell(20,3,number_format($this->importe_rubro,2),'B',0,'R',0);  
					$this->importe_rubro=0;
					 $this->SetFont('Arial','',6);
					}  	 	
	 
		
		


		 $indice_data++;  	    
		   
		}
		
	}
   
 
 //  	$this->line(8,$this->GetY(),273,$this->GetY()); 
    
    
	}
    
	
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
    
    function imprimirLinea($cadena,$w)
    {
    	$res=0;
    	$res=number_format($cadena,2);
    	return $res;
    	 
    	
    }
    function imprimirCuenta()
    {
    	$res=0;
    	$res=number_format($cadena,2);
    	return $res;
    	 
    	
    }
    
 
   

}

if ($_SESSION['nivel']<=3){

//Creación del objeto de la clase heredada
$pdf=new PDF('L','mm','Letter');// main (posicion de la pagina,unidad de medida,tamaño)

$pdf->AliasNbPages();//contador de pagina 

$pdf->AddPage('L');//para modificar la orienacion de la pagina
$pdf->SetMargins(10,10,10,10);
$pdf->SetAutoPageBreak(true,15);
$pdf->SetFont('Times','',12);
$pdf->maestro();//es una funcion en la cual se crea el reporte
//$pdf->FancyTable($header,$data);

//$pdf->SetRightMargin(10);
$pdf->Output();//mostrar el reporte
}
else {
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
	
}
?>



 
