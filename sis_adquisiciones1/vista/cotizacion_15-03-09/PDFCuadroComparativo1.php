<?php






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
    //Logo
  
  //  $this->Image('../../../lib/images/logo_reporte.jpg',170,2,35,15);
   
}
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-25);
    //Arial italic 8
    $this->SetFont('Tahoma','',7);
    //Número de página
    $this->SetFillColor(0,0,0);
	$this->Cell(185,0.3,'',1,1,'L',1);
    
    $this->SetX(100);
    $this->Cell(50,3,'Av. Ballivián Nº 0503',0,1);
    $this->SetX(100);
    $this->Cell(50,3,'Edificio Colon 7mo Piso',0,1);
    $this->SetX(100);
    $this->Cell(50,3,'Telefono: 4520317 -4520321',0,1);
    $this->SetX(100);
    $this->Cell(50,3,'Fax: 4520318',0,1);
    $this->Cell(50,3,'Pagina '.$this->PageNo().' de {nb}',0,1,'L');
    $this->Cell(50,3,'Pedido Nº 515',0,1,'L');
}

//Cabecera de página

}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf-> AddFont('Tahoma','','tahoma.php');
$pdf-> AddFont('Arial','','arial.php');

//-----------------------Primera Factura
$pdf->SetFont('Tahoma','',10);
$pdf->SetLeftMargin(15);
$pdf->SetFont('Arial','B',10);
/*$pdf->Cell(30,4,'Nro CB'.'-'.$_SESSION['PDF_num_cotizacion'].'-'.$_SESSION['PDF_gestion'],0,1);
$pdf->SetFont('Arial','',10);
//$pdf->SetX();
$pdf->SetFont('Arial','B',8);
$pdf->Cell(30,4,'Localidad',0,1); 
$pdf->SetFont('Arial','',8);
//$pdf->SetX(170);
$pdf->Cell(30,4,$_SESSION['ss_nombre_lugar'],0,1); 
//$pdf->SetX(170);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(10,4,'Día',1,0);
$pdf->Cell(10,4,'Mes',1,0);
$pdf->Cell(10,4,'Año',1,1);
//$pdf->SetX(170);
$fecha_completa=$_SESSION['PDF_fecha_reg'];
$dia=substr($fecha_completa,8,2);
$mes=substr($fecha_completa,5,2);
$anio=substr($fecha_completa,0,4);
$pdf->SetFont('Arial','',8);
$pdf->Cell(10,4,$dia,1,0);
$pdf->Cell(10,4,$mes,1,0);
$pdf->Cell(10,4,$anio,1,0);
$pdf->SetFont('Arial','BI',18);
$pdf->SetXY(45,4);

$pdf->Cell(105,20,'ORDEN DE COMPRA LOCAL',0,0,'C'); 
*///$pdf->SetX(170);
$pdf->Image('../../../lib/images/logo_reporte.jpg',170,2,35,15);
//$pdf->Cell(50,20,'',1,0); 

$pdf->SetFont('Arial','',10);
$pdf->Cell(185,5,'CUADRO COMPARATIVO DE OFERTAS',1,1,'C');
$pdf->Cell(185,5,'FECHA 2008/07',1,1,'C');
$pdf->Cell(185,5,'Nº CONVOCATORIA CCP-2007/98',1,1,'C');
$pdf->Cell(185,5,'Objeto: Provision de equipos de computación, impresora y escaner para proyecto Entre Rios',1,1,'C');
$pdf->Cell(185,5,'Gerencia:Gerenca Negocios y Exportaciones.0',1,1,'C');



 


$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(10,10,'Item',1,0); 
$pdf->Cell(70,10,'Descripción',1,0); 
$pdf->Cell(20,10,'Cantidad',1,0); 
$pdf->Cell(20,10,'Unidad',1,0);
$size_proveedor=2; 
for ($j=0;$j<$size_proveedor;$j++)
{
	$pdf->Cell(29,5,'Proveedor',1,0);
}
$pdf->SetXY(135,33.7);

$variable = array();
	$variable[0]=10;
	$variable[1]=70;
	$variable[2]=20;
	$variable[3]=20;
	$variable[4]=14;
	$variable[5]=15;
    $l=6;
for ($k=0;$k<$size_proveedor;$k++)
	{ 
	$pdf->Cell(14,5,'Precio U.',1,0);
	$pdf->Cell(15,5,'Precio T.',1,0);
	$variable[$l]=14;
	$variable[$l+1]=15;
	$l=$l+2;
}
$pdf->Ln(5);

$arrayDatos= array();
$arrayDatos[0]=1;
$arrayDatos[1]='mmmm no se que sera es un articulo que salda aproximos de la año';
$arrayDatos[2]=45;
$arrayDatos[3]='Pza';
/*$arrayDatos[1][0]=1;
$arrayDatos[1][1]='mmmm no se que sera es un articulo que salda aproximos de la año';
$arrayDatos[1][2]=45;
$arrayDatos[1][3]='Pza';
*/


$pdf->SetFont('Arial','',10); 
$pdf->SetWidths($variable);
//datos de la tabla
//$posy=$pdf->y;
//$posx=$pdf->x;
$data=$_SESSION['PDF_cuacom_det'];

//$cdata=count($data);
$cdata=4;

$tabla_aimprimir= array();
$tam_item=2;

$k=0;
$m=0;
$o=4;
for($i=0;$i<$tam_item;$i++){
	
	//$tabla_aimprimir1= array();
	for($l=$k;$l<($size_proveedor+$k);$l++){
		//print_r($data[$l][1]) ;
		//exit;
		
            $tabla_aimprimir[$m][0]=$data[$l][1];
		    $tabla_aimprimir[$m][1]=$data[$l][2];
		    $tabla_aimprimir[$m][2]=$data[$l][3];
		    $tabla_aimprimir[$m][3]=$data[$l][4];
		    $tabla_aimprimir[$m][$o]=$data[$l][5]; 
		    $tabla_aimprimir[$m][$o+1]=$data[$l][6];
		    $o=$o+2;
		}
	//	print_r($tabla_aimprimir);
	//	exit;
	
	$k=$k+$size_proveedor;
	$m=$m+1;
		//$o=
		//array_push($tabla_aimprimir,$tabla_aimprimir1);
	
}















//print_r($tabla_aimprimir);
//exit;
/*print_r($data[1][0]);
exit;*/

/* este proceso funciona pero no muy bien que hare a ver vere otra forma y ojala que funcione solo digo ojala funcione */ 
      
           //for($j=0;$j)
			//{   
			//	if($i+1<$cdata){
			
			//	if ($data[$i][0]==$data[$i+1][0])
			// $l=0;
			 // $k=4;
			  	//print_r($data[0][1]);
			  	//exit;
			  	//echo "----------------------------------------------------";
			   //$arReverse=array_reverse($data);
			   //print_r($arReverse);
			   //exit;
			  // $pro_datos=
			  	//for($i=0;$i<count($data);$i=$i+$size_proveedor)
				//{  
				   
				  //  $m=0;
				       
				//	for($j=0;$j<=count($data[$i]);$j++){
						 //echo($data[$i][$j]);
						// exit;
					   //  echo $i."--";
						//$k=4;
					  //  $tabla_aimprimir[$i][0]=$data[$i][1];
						/*$tabla_aimprimir[$l][0]=getCampoItem($data[0],1);
						$tabla_aimprimir[$l][1]=getCampoItem($data[0],2);
						$tabla_aimprimir[$l][2]=getCampoItem($data[$l],3);
						$tabla_aimprimir[$l][3]=getCampoItem($data[$l],4);
						$tabla_aimprimir[$l][$k]=getCampoItem($data[$l],5);
						$tabla_aimprimir[$l][$k+1]=getCampoItem($data[$l],6);
						$k=$k+2;
						*///}
						
					//	$l=$l+1;
						//echo $l;
					// $k=4;
				//}
				/*else
				   {
				   	 $k=4;
				    $tabla_aimprimir[$i+1][0]=getCampoItem($data[$i],1);
					$tabla_aimprimir[$i+1][1]=getCampoItem($data[$i],2);
					$tabla_aimprimir[$i+1][2]=getCampoItem($data[$i],3);
					$tabla_aimprimir[$i+1][3]=getCampoItem($data[$i],4);
					$tabla_aimprimir[$i+1][$k]=getCampoItem($data[$i],5);
					$tabla_aimprimir[$i+1][$k+1]=getCampoItem($data[$i],6);
					$k=$k+2;
				   }
				*/
			   // }
			//}


	/*for($i=0;$i<count($data);$i++)	
	{               if ($i==0){
	                $tabla_aimprimir[$i][0]=getCampoItem($data[$i],1);
					$tabla_aimprimir[$i][1]=getCampoItem($data[$i],2);
					$tabla_aimprimir[$i][2]=getCampoItem($data[$i],3);
					$tabla_aimprimir[$i][3]=getCampoItem($data[$i],4);
					array_shift($data);
	                 }
					else{
						if($tabla_aimprimir[$i][0]==$data[$i][0]){///verifica si el primer campo es el mismo entonces  
							 $k=4;
				             $tabla_aimprimir[$i+1][0]=getCampoItem($data[$i],1);
					         $tabla_aimprimir[$i+1][1]=getCampoItem($data[$i],2);
					         $tabla_aimprimir[$i+1][2]=getCampoItem($data[$i],3);
				          	 $tabla_aimprimir[$i+1][3]=getCampoItem($data[$i],4);
					         $tabla_aimprimir[$i+1][$k]=getCampoItem($data[$i],5);
					         $tabla_aimprimir[$i+1][$k+1]=getCampoItem($data[$i],6);
					         $k=$k+2;
							
						}
					}
					  
	}	*/
//print_r($tabla_aimprimir);
//exit;

function getCampoItem($a,$b){
	for ($j=0;$j<count($a);$j++)
	{
		$retorno=$a[$b];
	}
	return $retorno;
}

 for($i=0;$i<count($tabla_aimprimir);$i++)
 {
 
   $pdf->Row1($tabla_aimprimir[$i],'');
 }
/*for($i=0;$i<2;$i++)
    $pdf->Row1($arrayDatos);
   */
$pdf->SetFillColor(0,0,0);
$pdf->Cell(120 +(29*$size_proveedor),0.15,'',1,1,'L',1);
$pdf->SetFillColor(200,200,200);


$itemProveedor= array();
$itemProveedor[0]=1;
$itemProveedor[1]=2;
//$pos=$pdf->x;
 //$pdf->SetXY(135,$posy);
 /*$pdf->SetWidths(array(15,15));
for($i=0;$i<2;$i++)
    
    $pdf->SetXY(135,$posy);
    $pdf->Row($itemProveedor);
    $pdf->SetXY(135+10,$posy+10);*/
    
/*$pdf->SetFillColor(0,0,0);
$pdf->Cell(120 +(29*$size_proveedor),0.15,'',1,1,'L',1);
$pdf->SetFillColor(200,200,200);*/



//$cadena=array(10,70,20,20,14,15,$a,$b);
/*echo "fsdfsdf".$cadena[6];
exit;*/


/*$pdf->Cell(29,5,'Precio Unitario',1,0); 
$pdf->Cell(29,5,'Total (Bs. $us)',1,1);
*/




$variable1 = array();
	$variable1[0]=120;
	$l1=1;
for ($n=0;$n<$size_proveedor;$n++)
	{ 
	$variable1[$l1]=29;
	$l1=$l1+1;
}

$pdf->SetWidths($variable1);
for($m=0;$m<$size_proveedor;$m++)
    $pdf->Row(array('','',''));
$pdf->SetFillColor(0,0,0);
$pdf->Cell(120 +(29*$size_proveedor),0.15,'',1,1,'L',1);
//$pdf->Ln(0.5);
$pdf->SetFillColor(200,200,200);
//Lugar entrega
$pdf->SetWidths($variable1);
for($o=0;$o<$size_proveedor;$o++)
    $pdf->Row(array('','',''));
$pdf->SetFillColor(0,0,0);
$pdf->Cell(120 +(29*$size_proveedor),0.15,'',1,1,'L',1);
//$pdf->Ln(0.5);
$pdf->SetFillColor(200,200,200);
//Forma de pago
$pdf->SetWidths($variable1);
for($o=0;$o<$size_proveedor;$o++)
    $pdf->Row(array('','',''));
$pdf->SetFillColor(0,0,0);
$pdf->Cell(120 +(29*$size_proveedor),0.15,'',1,1,'L',1);
$pdf->SetFillColor(200,200,200);
//Validez de la oferta
$pdf->SetWidths($variable1);
for($p=0;$p<$size_proveedor;$p++)
    $pdf->Row(array('','',''));
$pdf->SetFillColor(0,0,0);
$pdf->Cell(120 +(29*$size_proveedor),0.15,'',1,1,'L',1);
$pdf->SetFillColor(200,200,200);
//Garantia
$pdf->SetWidths($variable1);
for($q=0;$q<$size_proveedor;$q++)
    $pdf->Row(array('','',''));
$pdf->SetFillColor(0,0,0);
$pdf->Cell(120 +(29*$size_proveedor),0.15,'',1,1,'L',1);
$pdf->SetFillColor(200,200,200);
//Observaciones
$pdf->SetWidths($variable1);
for($r=0;$r<$size_proveedor;$r++)
    $pdf->Row(array('','',''));
$pdf->SetFillColor(0,0,0);
$pdf->Cell(120 +(29*$size_proveedor),0.15,'',1,1,'L',1);
$pdf->SetFillColor(200,200,200);






//$pdf->Line(14);
/*$pdf->Cell(165,5,'SON: SIETE MIL CIENTO SETENTA Y TRES 007100 BOLIVIANOS',1,0);
//$pdf->SetFillColor(0,0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20,5,'717300',1,1,'R');
$pdf->SetFillColor(0,0,0);
$pdf->Cell(185,0.3,'',1,1,'L',1);
$pdf->Ln(0.5);
$pdf->SetFillColor(200,200,200);
$pdf->SetLineWidth(0.5);
$pdf->Cell(35,5,'Forma de Pago:',0,0);
$pdf->SetDrawColor(255,255,255);
$pdf->SetFont('Arial','',10); 
$pdf->Cell(57,5,'',1,0,'L',1);
$pdf->SetDrawColor(0,0,0);

$pdf->Cell(92,5,'p/ Empresa nacional de  Electricidad S. A.','L',1,'C');
//$pdf->Cell(57,5,'',0,1);
//$pdf->SetDrawColor(255,255,255);
$pdf->SetFont('Arial','B',10); 
$pdf->Cell(35,5,'Plazo de Entrega',0,0);
$pdf->SetDrawColor(255,255,255);
$pdf->SetFont('Arial','',10); 
$pdf->Cell(57,5,''.$_SESSION['PDF_fecha_venc'].'',1,0,'L',1);
$pdf->SetDrawColor(0,0,0);
$pdf->SetFont('Arial','B',10); 
$pdf->Cell(35,5,'','L',0);
$pdf->Cell(57,5,'',0,1);
$pdf->Cell(35,5,'Luegar de Entrega',0,0);
$pdf->SetDrawColor(255,255,255);
$pdf->SetFont('Arial','',10); 
$pdf->Cell(57,5,'Oficinas ENDE S.A.',1,0,'L',1);
$pdf->SetDrawColor(0,0,0);
$pdf->SetFont('Arial','B',10); 
$pdf->Cell(35,5,'','L',0);
$pdf->Cell(57,5,'',0,1);
$pdf->Cell(35,5,'Imputación:',0,0);
$pdf->SetDrawColor(255,255,255);
$pdf->SetFont('Arial','',10); 

$pdf->Cell(57,5,'',1,0,'L',1);
$pdf->SetDrawColor(0,0,0);
$pdf->SetFont('Arial','B',10); 
$pdf->Cell(46,5,'____________________','L',0,'C');
$pdf->Cell(46,5,'____________________',0,1,'C');

//$pdf->Cell(35,5,'',0,0);
$pdf->SetDrawColor(255,255,255);
$pdf->SetFont('Arial','',10); 
$pdf->Cell(92,5,'PLANTA TERMOELEC, ENTRE RIOS Bs.     2,391.00',1,0,'L',1);
$pdf->SetDrawColor(0,0,0);
$pdf->Cell(35,5,'Jefe División ','L',0,'C');
$pdf->Cell(57,5,'Jefe Dpto.  ',0,1,'C');

//$pdf->Cell(35,5,'',0,0);
$pdf->SetDrawColor(255,255,255);
$pdf->Cell(92,5,'ESTUDIO VIABILIDAD RIO MADERA     Bs. 2,391.00',1,0,'L',1);
$pdf->SetDrawColor(0,0,0);
$pdf->Cell(35,5,'Bienes','L',0,'C');
$pdf->Cell(57,5,'De Bienes y Servicios',0,1,'C');
$pdf->SetDrawColor(255,255,255);
$pdf->SetFont('Arial','B',10); 
$pdf->Cell(35,5,'Aprobación',0,0);
$pdf->SetFont('Arial','',10); 
$pdf->Cell(57,5,'CATEGORIA MENOR1',1,0,'L',1);
$pdf->SetDrawColor(0,0,0);
$pdf->Cell(35,5,'','L',0);
$pdf->Cell(57,5,'',0,1);

$pdf->SetLineWidth(0.1);
$pdf->SetFillColor(0,0,0);
$pdf->Cell(185,0.3,'',1,1,'L',1);
$pdf->Ln(5);
$pdf->SetFillColor(200,200,200);
$pdf->SetFont('Arial','B',10); 
$pdf->Cell(35,5,'Observaciones',0,0);
$pdf->SetFont('Arial','',10); 
//$pdf->SetDrawColor(255,255,255);
$pdf->Cell(135,5,'CONTRATACION POR COTIZACIONES PARA MONTOS MENORES A Bs 20.000',0,1);
$pdf->Cell(35,5,'Nro de Pedido(s): 1535,1751',0,1);
$pdf->SetFillColor(0,0,0);
$pdf->Cell(185,0.3,'',1,1,'L',1);
$pdf->Ln(5);
//$pdf->SetFillColor(200,200,200);
$pdf->SetFont('Arial','B',10);     
$pdf->Cell(35,5,'NOTA:',0,0);
$pdf->SetFont('Arial','',10); 
$pdf->MultiCell(150,5,'ROCHI SERVICIOS se compromete a entregar los bienes de acuerdo a la presente orden de compra; a cuyo fin y en señal de conformidad suscribe al pie del presente',0);    
    
$pdf->Cell(92,5,'',0,0,'C');
$pdf->Cell(93,5,'',0,1,'C');

$pdf->Cell(185,5,'Firma Proveedor o Sello',0,1,'R'); 
$pdf->MultiCell(185,5,'La presente Orden de Compra Local tiene calidad de contrato de sumnistro de acuerdo a los artículos 919 al 925 del Código de Comercio.',0);
$pdf->MultiCell(185,5,'El proveedor se compromete a entregar el suministro en el plazo de 30 dias calendario que seran computables a partir de la fecha de elaboracion de la presente orden de compra. El incumpliiento se sancionará con una multa del 0.5% del monto contratado por cada dia calendario de retraso, multa que no debe exceder el 10%s',0);    
*/

$pdf->Output();
?>