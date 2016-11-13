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
    //Iniciaci�n de variables
    }
 
function Header()
{
    $this->Image('../../../lib/images/logo_reporte.jpg',230,2,35,15);
    $this->Ln(10);
}
//Pie de p�gina
function Footer()
{
    //Posici�n: a 1,5 cm del final
    $this->SetY(-25);
    //Arial italic 8
    $this->SetFont('Tahoma','',7);
    //N�mero de p�gina
    $this->SetFillColor(0,0,0);
	$this->Cell(245,0.3,'',1,1,'L',1);
    
    $this->SetX(120);
    $this->Cell(50,3,'Av. Ballivi�n N� 0503',0,1);
    $this->SetX(120);
    $this->Cell(50,3,'Edificio Colon 7mo Piso',0,1);
    $this->SetX(120);
    $this->Cell(50,3,'Telefono: 4520317 -4520321',0,1);
    $this->SetX(120);
    $this->Cell(50,3,'Fax: 4520318',0,1);
    $this->Cell(50,3,'Pagina '.$this->PageNo().' de {nb}',0,1,'L');
    $this->Cell(50,3,'Pedido N� 515',0,1,'L');
}

//Cabecera de p�gina

}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf-> AddFont('Tahoma','','tahoma.php');
$pdf-> AddFont('Arial','','arial.php');
$pdf->SetAutoPageBreak(true,25);

//-----------------------Primera Factura
$pdf->SetFont('Tahoma','',10);
$pdf->SetLeftMargin(15);
$pdf->SetFont('Arial','B',14);

/*Aqui declararemos todas las funciones obtenidas del control */
$proveedores =$_SESSION['PDF_proveedores'];
$items = $_SESSION['PDF_items'];
$totales = $_SESSION['PDF_totales'];
$plazos  = $_SESSION['PDF_plazos'];
$lugares_entrega = $_SESSION['PDF_lugares_entrega'];
$forma_pago = $_SESSION['PDF_forma_pago'];
$tiempo_validez = $_SESSION['PDF_tiempo_validez'];
$garantia =  $_SESSION['PDF_garantia'];
$observaciones = $_SESSION['PDF_observaciones'];
$size_proveedor=count($proveedores);   
$tam_item=count($items);
$cua_com_cab=$_SESSION['PDF_cuacomcab'];

$tabla_aimprimir= array();
//print_r($cua_com_cab);
$num_solicitud='';
for($v=0;$v<count($cua_com_cab);$v++){
	$fecha_hoy=$cua_com_cab[$v][1];
	if($v==0){
	$num_solicitud=$num_solicitud.$cua_com_cab[$v][0];
	}else{
	$num_solicitud=$num_solicitud.','.$cua_com_cab[$v][0];	
	}
	
}
$pdf->SetFont('Arial','B',16);
for($u=1;$u<=ceil($size_proveedor/3);$u++){
echo"cuantos veces sale esto"	
	
}
$pdf->Cell(250,10,'CUADRO COMPARATIVO DE OFERTAS',0,1,'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(250,5,$fecha_hoy,0,1,'L');
$pdf->SetX(50);
$pdf->Cell(250,5,'N� Solicitud: '. $num_solicitud,0,1,'L');
$pdf->SetX(50);
$pdf->Cell(250,5,'',0,1,'L');
//$pdf->Cell(250,5,'Gerencia:Gerenca Negocios y Exportaciones.0',1,1,'C');

$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(10,10,'Nro',1,0); 
$pdf->Cell(70,10,'Descripci�n del '.$_SESSION['PDF_titulo'],1,0); 
$pdf->Cell(20,10,'Cantidad',1,0); 
$pdf->Cell(20,10,'Unidad',1,0);
 
for ($j=0;$j<$size_proveedor;$j++)
{   
	$pdf->Cell(29,5,preview_text($proveedores[$j][1],12,0),1,0);
}
$pdf->SetXY(135,43.7);

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

$pdf->SetFont('Arial','',8); 
$pdf->SetWidths($variable);

$data=$_SESSION['PDF_cuacom_det'];
//nuevo array donde se acomodaran los datos

//cuantos items por cada proceso de compra

//aqui armo la tabla donde ya estara listo para imprimir
/*print_r($data);
exit; */

/*echo sizeof($data);
exit;*/
$k=0;
$m=0;
//$o=4;
$tipo_celda1=array(0,0,0,0,1,1);

$align1=array('R','L','R','R','R','R');
$tipo_celda=array();
$tipo_celda[0]=0;
$tipo_celda[1]=1;
$align=array();
$align[0]='R';	
$align[1]='R';	
for($i=0;$i<(count($data)/$size_proveedor);$i++){
	$o=4;
	$d=5;
	$r=1;
	for($l=$k;$l<($size_proveedor+$k);$l++){
		
		
            $tabla_aimprimir[$m][0]=$i+1;
		    $tabla_aimprimir[$m][1]=$data[$l][2];
		    $tabla_aimprimir[$m][2]=$data[$l][3];
		    $tabla_aimprimir[$m][3]=$data[$l][4];
		    $tabla_aimprimir[$m][$o]=$data[$l][5]; 
		    $tabla_aimprimir[$m][$o+1]=$data[$l][6];  
		    $o=$o+2;
		    $tipo_celda1[$d]=1;
		    $align1[$d]='R';
		    $d=$d+1;
		    $tipo_celda[$r]=1;
		    $align[$r]='R';
		    $r=$r+1;
		}
	
	
	$k=$k+$size_proveedor;
	$m=$m+1;
	
	
}


//aqui estoy haciendo imprimir para mostrar en pdf
//$pdf->SetFont('Arial','B',10);
 for($i=0;$i<count($tabla_aimprimir);$i++)
 {
 
   $pdf->filaCuaCom1($tabla_aimprimir[$i],$tipo_celda1,$align1);
 }

 //primera celda
$pdf->SetFillColor(0,0,0);
$pdf->Cell(120 +(29*$size_proveedor),0.15,'',1,1,'L',1);
$pdf->SetFillColor(200,200,200);

//aqui estara el costo total de los proveedores
//el importe neto.
// el impuesto de ley
/*$itemProveedor= array();
$itemProveedor[0]=1;
$itemProveedor[1]=2;
*/


$variable1 = array();
	$variable1[0]=120;
	$l1=1;
for ($n=0;$n<$size_proveedor;$n++)
	{ 
	$variable1[$l1]=29;
	$l1=$l1+1;
}

//el listado de los totales
     //importe total
     $o1=1;
     for($l=0;$l<$size_proveedor;$l++){
         $tabla_totales[0][0]='TOTAL(Bs)';
	     $tabla_totales[0][$o1]=$totales[$l][1];
	     $o1=$o1+1;
		}
	//precio neto
     $o2=1;
     for($l2=0;$l2<$size_proveedor;$l2++){
         $tabla_precio_neto[0][0]='Importe Neto(Bs)';
	     $tabla_precio_neto[0][$o2]=($totales[$l2][1])-($totales[$l2][1])*(0.15);
	     $o2=$o2+1;
		}
	// impuesto de ley 
	 $o3=1;
     for($l3=0;$l3<$size_proveedor;$l3++){
         $tabla_impuesto_ley[0][0]='Impuesto de Ley(Bs)';
	     $tabla_impuesto_ley[0][$o3]=(($totales[$l3][1])*(0.15));
	     $o3=$o3+1;
		}
			

$pdf->SetWidths($variable1);
$pdf->filaCuaCom1($tabla_totales[0],$tipo_celda,$align);
$pdf->filaCuaCom1($tabla_precio_neto[0],$tipo_celda,$align);
$pdf->filaCuaCom1($tabla_impuesto_ley[0],$tipo_celda,$align);
$pdf->SetFillColor(0,0,0);
$pdf->Cell(120 +(29*$size_proveedor),0.15,'',1,1,'L',1);
 $o4=1;
     for($l4=0;$l4<$size_proveedor;$l4++){
         $tabla_plazo_entrega[0][0]='Plazo de Entrega';
	     $tabla_plazo_entrega[0][$o4]=$plazos[$l4][1];
	     $o4=$o4+1;
		}

$pdf->SetWidths($variable1);
    $pdf->Row($tabla_plazo_entrega[0]);
$pdf->SetFillColor(0,0,0);
$pdf->Cell(120 +(29*$size_proveedor),0.15,'',1,1,'L',1);

//los listado de lugar entrega por proveedor y proceso de compra
 $o5=1;
     for($l5=0;$l5<$size_proveedor;$l5++){
         $tabla_lugar_entrega[0][0]='Lugar de Entrega';
	     $tabla_lugar_entrega[0][$o5]=$lugares_entrega[$l5][1];
	     $o5=$o5+1;
		}

$pdf->SetWidths($variable1);
    $pdf->Row($tabla_lugar_entrega[0]);
$pdf->SetFillColor(0,0,0);
$pdf->Cell(120 +(29*$size_proveedor),0.15,'',1,1,'L',1);
$pdf->SetFillColor(200,200,200);
//Forma de pago por proveedor y proceso de compra
$pdf->SetWidths($variable1);
 $o6=1;
     for($l6=0;$l6<$size_proveedor;$l6++){
         $tabla_forma_pago[0][0]='Forma de Pago';
	     $tabla_forma_pago[0][$o6]=$forma_pago[$l6][1];
	     $o6=$o6+1;
		}

    $pdf->Row($tabla_forma_pago[0]);
$pdf->SetFillColor(0,0,0);
$pdf->Cell(120 +(29*$size_proveedor),0.15,'',1,1,'L',1);
$pdf->SetFillColor(200,200,200);
//Validez de la oferta por proveedor y proceso de compra.
$pdf->SetWidths($variable1);
 $o7=1;
     for($l7=0;$l7<$size_proveedor;$l7++){
         $tabla_validez_oferta[0][0]='Validez de la oferta';
	     $tabla_validez_oferta[0][$o7]=$tiempo_validez[$l7][1];
	     $o7=$o7+1;
		}
    $pdf->Row($tabla_validez_oferta[0]);
$pdf->SetFillColor(0,0,0);
$pdf->Cell(120 +(29*$size_proveedor),0.15,'',1,1,'L',1);
$pdf->SetFillColor(200,200,200);
//Garantia por proveedor y proceso de compra
$pdf->SetWidths($variable1);
 $o8=1;
     for($l8=0;$l8<$size_proveedor;$l8++){
         $tabla_garantia[0][0]='Garantia';
	     $tabla_garantia[0][$o8]=$garantia[$l8][1];
	     $o8=$o8+1;
		}
   $pdf->Row($tabla_garantia[0]);
$pdf->SetFillColor(0,0,0);
$pdf->Cell(120 +(29*$size_proveedor),0.15,'',1,1,'L',1);
$pdf->SetFillColor(200,200,200);
//Observaciones por proceso y proveedor de compra
$pdf->SetWidths($variable1);
 $o9=1;
     for($l9=0;$l9<$size_proveedor;$l9++){
         $tabla_observaciones[0][0]='Observaciones';
	     $tabla_observaciones[0][$o9]=$observaciones[$l9][1];
	     $o9=$o9+1;
		}
    $pdf->Row($tabla_observaciones[0]);
$pdf->SetFillColor(0,0,0);
$pdf->Cell(120 +(29*$size_proveedor),0.15,'',1,1,'L',1);

$pdf->SetFont('Arial','B',10);   
$pdf->Cell(92,15,'',0,0,'C');
$pdf->Cell(93,15,'',0,1,'C');
/*$pdf->Cell(45,5,'','TLR',0,'C');
$pdf->Cell(45,5,'','TLR',1,'C');
*/
$pdf->Cell(92,5,'___________________',0,0,'C'); 
$pdf->Cell(93,5,'___________________',0,1,'C'); 
/*$pdf->Cell(45,5,'___________________','LR',0,'C'); 
$pdf->Cell(45,5,'___________________','LR',1,'C'); 
*
/*$pdf->Cell(45,5,'-------','LR',0,'C'); 
$pdf->Cell(45,5,'Mario Ayma Rodriguez','LR',1,'C'); 
*/
$pdf->SetFont('Arial','B',10);
//$pdf->Cell(45,5,'Receptor Centro','LBR',0,'C'); 
$pdf->Cell(92,5,'Firma Autorizada',0,0,'C'); 
$pdf->Cell(93,5,'Sello y Firma ',0,0,'C');



$pdf->SetFillColor(200,200,200);

function preview_text($TEXT, $LIMIT, $TAGS = 0) {

    // TRIM TEXT
    $TEXT = trim($TEXT);

    // STRIP TAGS IF PREVIEW IS WITHOUT HTML
    if ($TAGS == 0) $TEXT = preg_replace('/\s\s+/', ' ', strip_tags($TEXT));

    // IF STRLEN IS SMALLER THAN LIMIT RETURN
    if (strlen($TEXT) < $LIMIT) return $TEXT;

    if ($TAGS == 0) return substr($TEXT, 0, $LIMIT) . " ...";
    else {

        $COUNTER = 0;
        for ($i = 0; $i<= strlen($TEXT); $i++) {

            if ($TEXT{$i} == "<") $STOP = 1;

            if ($STOP != 1) {

                $COUNTER++;
            }

            if ($TEXT{$i} == ">") $STOP = 0;
            $RETURN .= $TEXT{$i};

            if ($COUNTER >= $LIMIT && $TEXT{$i} == " ") break;

        }

        return $RETURN . "...";
    }

}

$pdf->Output();
?>