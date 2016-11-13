<?php
require('../../../../lib/fpdf/fpdf.php');
//require('../../../../lib/fpdf/code39/code39.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../LibModeloActivoFijo.php");
class PDF extends FPDF
{

function LoadData($id_tipo_activo,$id_sub_tipo_activo,$id_regional)
{    $cant=20;
     $puntero=0;
     $sortcol='actif.codigo';
     $sortdir='asc';
     $criterio_filtro="subtip.id_sub_tipo_activo like ''$id_sub_tipo_activo''";
     $criterio_filtro=$criterio_filtro." and tipo.id_tipo_activo like ''$id_tipo_activo''";
        //Leer las líneas del fichero
    $Custom=new cls_CustomDBActivoFijo();
    $Custom->ListarCodigoBarras($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);	
    $var1=$Custom->salida;
    return $var1;
 }
//Tabla coloreada
function FancyTable($data)
{  	//Datos
	$columnas=0;
	$filas=0;
	
	 foreach($data as $row)//para recorrer areglos
      { if($filas==0){
      	     if($columnas==0) {
      	     	$this->SetLeftMargin(8);
      		    $this->SetX(8);
      	        $this->SetY(8); }
      	      if($columnas==1) {
      	      	$this->SetLeftMargin(60);
      		    $this->SetX(60);
      	        $this->SetY(8);}
      	      if($columnas==2) {
      	      	$this->SetLeftMargin(110);
      		    $this->SetX(110);
      	        $this->SetY(8);} 
      	      if($columnas==3) {
      	      	$this->SetLeftMargin(160);
      		    $this->SetX(160);
      	        $this->SetY(8);}   
      	  	  	 }
      	if($filas <= 12){
      	//ancho de la celda,alto,texto que quiero imprimir,para enmaracar LTRB ,o no sabemos, aliacion del texto
        $this->Cell(30,6,$row[1],0,0,'L'); //desccripcion
        $this->Ln(2);//entre
        $this->Cell(20,6,$row[4],0,0,'L'); //nombre regional
        $this->Ln(4);//descripcion y codigo de barras
        $this->SetFont('3of9','',20);
        $this->Cell(30,6,$row[0],0,0,'L'); //codigo
       	$this->Ln(4);//para saltar una linea entre codigo barras y codigo
       	$this->SetFont('Arial','',6);
       	$this->Cell(30,6,$row[0],0,0,'C');
       	$this->Ln(9);
       	$filas=$filas+1;
               }
         else{      
          $filas=0;
          $columnas=$columnas+1;
          if($columnas==4){
          	$columnas=0;
          $this->AddPage();	
          
          }
         }     
           
      }
      
      
  }
 }
$pdf=new PDF('P','mm','Letter');//configiracion de pagina vertical,milimetros,tamaño carta
$pdf->AliasNbPages();//Alias para el total de paginas
//Carga de datos
    $id_tipo_activo =  $id_tipo_activo;
	$id_sub_tipo_activo =  $id_sub_tipo_activo;
	$id_regional =  $id_regional;
	$data=$pdf->LoadData($id_tipo_activo,$id_sub_tipo_activo,$id_regional);
//echo json_encode($data);
$pdf->AddFont('3of9','','3of9.php');
$pdf->SetFont('Arial','',6);//tipo y tamaño de letra
//$pdf->SetFont('Arial','',7);//tipo y tamaño de letra
$pdf->SetAutoPageBreak(1,5);//para habilitar salto automatico de hoja 1 habiltado, 35 el margen de abajo 
$pdf->SetTopMargin(10);//margen superior
$pdf->SetRightMargin(10);//margen derecho
$pdf->SetLeftMargin(10);//margen izquierdo
$pdf->AddPage();//añade la primera pagina
$pdf->FancyTable($data);
//$pdf->Code39(80,40,$row[0],3,10);
$pdf->Output();//salida del documento
?>