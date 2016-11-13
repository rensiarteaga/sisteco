<?php
require('../../../lib/fpdf/fpdf.php');
//require('../../../lib/fpdf/mc_table.php');
define('FPDF_FONTPATH','font/');
include_once("../../control/LibModeloAdquisiciones.php");

class PDF extends FPDF
{
	//Cargar los datos
	//Cabecera de página

	function Header(){
	global $title;
	//$this->SetLeftMargin(15);
	//Logo
	$this->Image('../../../lib/images/logo_reporte.jpg',240,2,35,13);
   
	$this->SetFont('Arial','B',14);
	//Movernos a la derecha
	$this->Cell(273,10,'LISTADO DE ORDENES DE COMPRA',0,0,'C');
	$this->Ln(15);
	$this->SetFont('Arial','B',6);
	$this->Cell(7,5,'Nº OC','LTR',0,'C');
	$this->Cell(12,5,'FECHA','TR',0,'C');
	$this->Cell(25,5,'CATEGORIA','TR',0,'C');
	$this->Cell(13,5,'ESTADO','TR',0,'C');
	$this->Cell(21,5,'CODIGO','TR',0,'C');
	$this->Cell(35,5,'PROVEEDOR','TR',0,'C');
	$this->Cell(34,5,'OBSERVACIONES','TR',0,'C');
	$this->Cell(15,5,'IMPORTE','TR',0,'C');
	$this->Cell(15,5,'IMPORTE','TR',0,'C');
	$this->Cell(15,5,'SALDO POR','TR',0,'C');
	$this->Cell(15,5,'SALDO POR','TR',0,'C');
	$this->Cell(69,5,'SOL.                                 E.P.                                   U.O.','TR',0,'L');
	
    $this->Ln(3);
    $this->Cell(7,4,'','LRB',0,'C');
	$this->Cell(12,4,'','RB',0,'C');
	$this->Cell(25,4,'COMPRA','RB',0,'C');
	$this->Cell(13,4,'PROCESO','RB',0,'C');
	$this->Cell(21,4,'PROCESO','RB',0,'C');
	$this->Cell(35,4,'','RB',0,'C');
	$this->Cell(34,4,'','RB',0,'C');
	$this->Cell(15,4,'Bs','RB',0,'C');
	$this->Cell(15,4,'$us','RB',0,'C');
	$this->Cell(15,4,'PAGAR Bs','RB',0,'C');
	$this->Cell(15,4,'PAGAR $us','RB',0,'C');
	$this->Cell(69,4,'','RB',0,'C');
	$this->Ln(4);
	}
	//Pie de página
	function Footer(){
		$this->SetY(-7);
		//fecha
		$fecha=date("d-m-Y");
		//hora
		$hora=date("H:i:s");
		
		$this->SetFont('Arial','',6);
		$this->Cell(90,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(110,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(55,3,'',0,0,'C');
		$this->Cell(74,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(90,3,'SISTEMA: ENDESIS-COMPRO',0,0,'L');
		$this->Cell(110,3,'',0,0,'C');
		$this->Cell(55,3,'',0,0,'C');
		$this->Cell(74,3,'Hora: '.$hora,0,0,'L');		
	}
	function LoadData($tipo_adq,$id_proveedor,$fecha_inicio,$fecha_fin,$id_depto,$id_ep,$id_uo){
		$cant=15;
	    $puntero=0;
	    $sortcol="COT.fecha_orden_compra,PERIOD.periodo || '' / '' || COT.num_orden_compra";
	    $sortdir='asc';	    
	    $criterio_filtro="COT.fecha_orden_compra>= ''$fecha_inicio''";
	    $criterio_filtro=$criterio_filtro."  AND COT.fecha_orden_compra<= ''$fecha_fin''";
	    $criterio_filtro=$criterio_filtro." AND PROCOM.id_depto=".$id_depto;
	    if($id_proveedor!='%'){
	     	$criterio_filtro=$criterio_filtro.'  AND COT.id_proveedor='.$id_proveedor;
	    }
	    if($id_ep!='%'){
	    	$criterio_filtro=$criterio_filtro.'  AND PROCOM.id_proceso_compra IN (SELECT PROCOM.id_proceso_compra
                                                                                  FROM compro.tad_proceso_compra PROCOM
                                                                                  INNER JOIN compro.tad_solicitud_proceso_compra SOLPRO
                                                                                  ON SOLPRO.id_proceso_compra=PROCOM.id_proceso_compra
                                                                                  INNER JOIN compro.tad_solicitud_compra SOLCOM
                                                                                  ON SOLCOM.id_solicitud_compra=SOLPRO.id_solicitud_compra
                                                                                  WHERE SOLCOM.id_fina_regi_prog_proy_acti='.$id_ep.')';
	    }
	    if($id_uo!='%'){
	    	$criterio_filtro=$criterio_filtro.'  AND PROCOM.id_proceso_compra IN (SELECT PROCOM.id_proceso_compra
                                                                                  FROM compro.tad_proceso_compra PROCOM
                                                                                  INNER JOIN compro.tad_solicitud_proceso_compra SOLPRO
                                                                                  ON SOLPRO.id_proceso_compra=PROCOM.id_proceso_compra
                                                                                  INNER JOIN compro.tad_solicitud_compra SOLCOM
                                                                                  ON SOLCOM.id_solicitud_compra=SOLPRO.id_solicitud_compra
                                                                                  WHERE SOLCOM.id_unidad_organizacional='.$id_uo.')';
	    }
	    if($tipo_adq=='Bien'){
	    	$criterio_filtro=$criterio_filtro.'  AND COTDET1.id_item_aprobado IS NOT NULL';
	    }
	    elseif ($tipo_adq=='Servicio'){
	    	$criterio_filtro=$criterio_filtro.'  AND COTDET1.id_servicio IS NOT NULL';
	    }
	    //Leer las líneas del fichero
	    $Custom = new cls_CustomDBAdquisiciones();
		$Custom->ListarListaOC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	    $data=$Custom->salida;
	    return $data;
	    	    
	}
	//Tabla coloreada
	function FancyTable($data){
		//Colores, ancho de línea y fuente en negrita
		 $this->SetLineWidth(.1);
	   $this->SetWidths(array(0,7,0,12,25,13,21,35,34,0,0,15,15,15,15,69));
       $this->SetAligns(array('R','L','L','L','L','L','L','L','L','R','R','R','R','R','R','L'));
       $this->SetVisibles(array(0,1,0,1,1,1,1,1,1,0,0,1,1,1,1,1));
       $this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
       $this->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5));
       $this->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
       $this->setDecimales(array(0,0,0,0,0,0,0,0,0,2,2,2,2,2,2,0));
        $Custom1 = new cls_CustomDBAdquisiciones();
        	$data_ep=array();
       		
       for ($i=0;$i<count($data);$i++){
      $Custom1->ListarNumSolEPUO($cant,$puntero,$sortcol,$sortdir,'cotiza.id_cotizacion='.$data[$i][0],$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
       	$data_ep1=array();
       $data_ep=$Custom1->salida; 
        for($z=0;$z<count($data_ep);$z++){
      	$data_ep1[$z][0]=$data_ep[$z][0];
      	$data_ep1[$z][1]=$data_ep[$z][1];
      	$data_ep1[$z][2]=$data_ep[$z][2];
    } 
      
        
       
       $this->SetWidths1(array(6,29,34));
       $this->SetAlignsST(array('R','L','L'));
 	   $this->SetDecimalesST(array(0,0,0));
 	   $this->SetFormatNumberST(array(0,0,0));
       $this->MultiTabla1($data[$i],1,5,3,5,1,$data_ep1,15);
   
       
      }
		
		}
}

$pdf=new PDF('L','mm','Letter');
$pdf->AliasNbPages();
//Carga de datos
$data=$pdf->LoadData($tipo_adq,$id_proveedor,$fecha_inicio,$fecha_fin,$id_depto,$id_ep,$id_uo);
$pdf->SetFont('Arial','',14);
$pdf->SetAutoPageBreak(1,15);
$pdf->SetMargins(2,5,5);

$pdf->AddPage();
$pdf->FancyTable($data);
$pdf->Output();
?>