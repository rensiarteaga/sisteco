<?php
session_start();
require('../../../lib/fpdf/fpdf.php');
require('../../../lib/funciones.inc.php');
include_once("../../../lib/configuracion.log.php");
include_once("../LibModeloPresupuesto.php");

		
class PDF extends FPDF
{
		
	 
	//Cabecera de página
	function Header()
	{
		$this->SetLeftMargin(15);//margen izquierdo
		$funciones = new funciones();
	    //Logo
	    	$this->Image('../../../lib/images/logo_reporte.jpg',240,5,36,10);
	    //$this->Image('../../../lib/images/logo_reporte_factur.jpg',210,5);//llama al logo
	    //Arial bold 15
	    $this->SetFont('Arial','B',12);//tifo de fuente
	    //Movernos a la derecha
		$this->Ln(3);//salto de linea 
	    //$this->Cell(100);//celda de dibujo
	    
	    $this->Cell(0,7,'CONSISTENCIA DE EJECUCIÓN PRESUPUESTARIA ',0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->SetFont('Arial','I',8);
	    $this->Ln();
	    $this->Cell(0,4,'Departamento Contable:'.$_SESSION['PDF_g_depto'],0,0,'C'); //dibuja una celad con contenido y orientacion  x, y
	    $this->Ln();
	    $this->Cell(0,4,'Presupuesto:'.$_SESSION['PDF_g_presupuesto'],0,0,'C'); //dibuja una celad con contenido y orientacion  x, y  
	    $this->SetFont('Arial','I',7);
	    $this->Ln();
	    $this->Cell(0,4,'Del '.$_SESSION['PDF_m_fecha_inicio_rep'].' Al '.$_SESSION['PDF_m_fecha_fin_rep']." ",0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->Ln(3);
	    $this->Cell(0,4,'(Expresado en '.$_SESSION['PDF_id_moneda_desc'].")",0,0,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->Ln(7);//10
	    $this->SetFont('Arial','I',7);
	    	
	    $epe=" ";   
	    $bandera=false;
		 
	    $this->SetFont('Arial','B',6);	
	}	
		 
  	function maestro(){
  		$this->SetFillColor(200, 200, 200);	//Plomo oscuro
		$this->SetFont('Arial','B',8);
 
 		$this->Cell(15,4,'CÓDIGO ','LTRB',0,'C',true);  
 		$this->Cell(90,4,'PARTIDA','LTRB',0,'C',true); 
 		$this->Cell(30,4,'EJE. CONTABILIDAD','LTRB',0,'C',true);  
 		$this->Cell(30,4,'EJE. PRESUPUESTO','LTRB',0,'C',true);  
 		$this->Cell(30,4,'DIFERENCIA','LTRB',0,'C',true);
 		$this->Ln(3);//salto de linea 
 
		$this->SetLineWidth(.1);//ancho de las lineas 
		$this->SetFillColor(224,235,255);//color de fondo las celdas 
	    $this->SetTextColor(0);//color de la letra
		$this->SetFont('Arial','',6);
		 
		$cond = new cls_criterio_filtro($decodificar);
		for($i=0;$i<$_SESSION['PDF_CantFiltros'];$i++)
		{
			$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
		}
 		$Custom = new cls_CustomDBPresupuesto();//$this->SetY(36);
		$cant=100000;
		$puntero=0;
		$sortcol = 'contabilidad.codigo_partida';
 		$sortdir = 'asc';
	 
		$criterio_filtro = $cond -> obtener_criterio_filtro();
		$res = $Custom->ListarConsistenciaEjecucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$_SESSION['PDF_m_fecha_fin'],$_SESSION['PDF_m_fecha_inicio'],$_SESSION['PDF_m_ids_presupuesto'],$_SESSION['PDF_m_ids_depto'], $_SESSION['PDF_id_moneda']);
		
		
		 if($res)
		 {
		 	$fill=!$fill;
			$data=$Custom->salida;
			foreach($data as $row)
			{	   
				$this->Cell(15,4,$row[1],'LR',0,'L',$fill);
				$this->Cell(90,4,$row[2],'LR',0,'L',$fill);
				$this->Cell(30,4,number_format($row[3],2),'LR',0,'R',$fill);
				$this->Cell(30,4,number_format($row[4],2),'LR',0,'R',$fill);
				$this->Cell(30,4,number_format($row[5],2),'LR',0,'R',$fill);
				$this->Ln();
					
				$fill=!$fill;
			}
		 } 
  	}
	//Pie de página
	function Footer()
	{
	    $this->SetY(-15);
	    $this->SetFont('Arial','I',8);
	    $ip = captura_ip();
	    
	    $fecha=date("d-m-Y");
		$hora=date("H:i:s");
	     
   	    $this->SetFont('Arial','',6);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - PRESTO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
	}   
}

//Creación del objeto de la clase heredada
$pdf=new PDF('P','mm','Letter');// main (posicion de la pagina,unidad de medida,tamaño)

$pdf->AliasNbPages();//contador de pagina 

$pdf->AddPage();//para modificar la orienacion de la pagina
$pdf->SetAutoPageBreak(true,15);
$pdf->SetFont('Times','',12);
$pdf->maestro();//es una funcion en la cual se crea el reporte

$pdf->Output();//mostrar el reporte
?>
