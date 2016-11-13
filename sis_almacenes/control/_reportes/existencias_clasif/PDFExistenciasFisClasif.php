<?php
require_once('../../../../lib/lib_reportes/reporte.php');
include_once("../../LibModeloAlmacenes.php");

class PDF extends Reporte
{
	var $id_almacen;
	var $id_almacen_ep;
	var $id_almacen_logico;
	var $id_supergrupo;
	var $id_grupo;
	var $id_subgrupo;
	var $id_id1;
	var $id_id2;
	var $id_id3;
	var $id_item;

	function Header(){
		//coloca titulo al reporte la cntidad de parametros por linea y la posicion del logo R-> derecha  L->izquierda
		$this->ArmaHeader("EXISTENCIA FÍSICA DE MATERIALES",3,'R');
		//llama al constructor del padre
		parent::Header();
		//añade una parámetro a la cabecera en el orden en q se van insertando
		//y la cantidad de parametros indicados por linea

		$this->addParametro("Fecha Inicio","23/07/2008",'C');
		$this->addParametro("Fecha Fin","15/08/2008",'C');
		$this->addParametro("Fecha Inicio","23/07/2008",'C');
		$this->addParametro("Fecha Fin","15/08/2008",'C');
		$this->addParametro("Fecha Inicio","23/07/2008",'C');
		$this->addParametro("Fecha Fin","15/08/2008",'C');

		$this->ln(13);
		$anchos=array(10,25,40,80,15,15,20,20,20);
		$nombres=array('Nro.','Código','Nombre','Descripción','Estado','Peso (Kg)','Cantidad Ingresos','Cantidad Salidas','Saldo');
		$this->SetAligns(array('L','L','L','L','L','R','R','R','R'));
		//coloca la cabecera y los anchos de las columnas a dibujar
		$this->cabeceraColDet($anchos,$nombres,1);
	}

	function LoadDataMaestro()
	{
		$cant=1000;
		$puntero=0;
		$sortcol='TIPOUC.nombre';
		$sortdir='asc';
		$criterio_filtro=' INGRES.id_ingreso = '.$_SESSION["rep_ing_id_ingreso"];
		/*echo "query: ".$criterio_filtro;
		exit;*/
		//Leer las líneas del fichero
		$Custom=new cls_CustomDBAlmacenes();
		$Custom->NotaIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

		$resp=$Custom->salida;

		return $resp;
	}

	function LoadDataDetalle()
	{
		$cant=1000;
		$puntero=0;
		$sortcol='ITEM.codigo,ITEM.nombre';
		$sortdir='asc';
		$criterio_filtro="KARLOG.id_almacen_logico LIKE '$this->id_almacen_logico'";
		$criterio_filtro.=" AND ALMAEP.id_almacen_ep LIKE '$this->id_almacen_ep'";
		$criterio_filtro.=" AND ALMACE.id_almacen LIKE '$this->id_almacen'";
		$criterio_filtro.=" AND SUPGRU.id_supergrupo LIKE '$this->id_supergrupo'";
		$criterio_filtro.=" AND SUPGRU.id_supergrupo LIKE '$this->id_grupo'";
		$criterio_filtro.=" AND GRUPO.id_grupo LIKE '$this->id_subgrupo'";
		$criterio_filtro.=" AND SUBGRU.id_subgrupo LIKE '$this->id_subgrupo'";
		$criterio_filtro.=" AND IDENT1.id_id1 LIKE '$this->id_id1'";
		$criterio_filtro.=" AND IDENT2.id_id2 LIKE '$this->id_id2'";
		$criterio_filtro.=" AND IDENT3.id_id3 LIKE '$this->id_id3'";
		$criterio_filtro.=" AND ITEM.id_item LIKE '$this->id_item'";

		$cond="'{''1'','$this->id_almacen','$this->id_almacen_ep','$this->id_almacen_logico'}'";

		/*echo"cond: ".$cond;
		exit;*/
		
		/*echo "query: ".$criterio_filtro;
		exit;*/

		//Leer las líneas del fichero
		$Custom=new cls_CustomDBAlmacenes();
		$Custom->ListarExistencias($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$cond);

		$resp=$Custom->salida;

		/*print "<pre>";
		print_r($resp);
		print "</pre>";*/

		return $resp;
	}

	function Maestro($data)
	{
		$this->AddPage();
		$this->SetFont('Arial','',10);
		$this->Cell(120,10,'Proveedor:   '.$data[0][5],0,0,'L');//,'LR',0,'C');
		$this->Ln(5);
		$this->Cell(120,10,'Concepto:   '.$data[0][6],0,0,'L');//,'LR',0,'C');
		$this->Ln(5);
		$this->Cell(120,10,'Enregado por:   '.$data[0][7],0,0,'L');//,'LR',0,'C');
		$this->Ln(5);
		$this->Cell(120,10,'Nro. Remisión:   '.$data[0][2],0,0,'L');//,'LR',0,'C');
		//$this->Ln(5);
		$this->SetX(130);
		$this->Cell(120,10,'Fecha Remisión:   '.$data[0][3],0,0,'L');//,'LR',0,'C');
		$this->Ln(5);
		$this->Cell(120,10,'Fecha de Ingreso Almacén:   '.$data[0][4],0,0,'L');//,'LR',0,'C');
		$this->Ln(10);
	}

	//Tabla coloreada
	function FancyTable($data,$header,$header_det)
	{
		//Contador
		$cont=1;

		$this->SetFont('Arial','',7);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(190,190,190);
		$this->SetLineWidth(.1);
		$this->SetFont('','',8);
		//Cabecera
		$w=array(6,30,13,10,11,84,20,18);
		//$w=array(25,20,20,40,60,30);
		//('Código','Cantidad','Unidad','Calidad','Descripción del Material','Peso Neto (kg)');
		$wi=array(35,60,60,30);
		$wdet=array(6,20,45,80,20,20);
		$rama=array();
		$rama_nombre=array();
		$fecha=date("d-m-Y");

		//print ('<pre>');
		//print_r($header);
		//print ('</pre>');
		//$this->SetY(30);

		//Imprime los rótulos de las columnasis
		$this->SetFont('Arial','',6);
		for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],5,$header[$i],1,0,'C',1);
		$this->Ln();


		$cant=1000;
		$puntero=0;
		$sortcol='ITEM.id_supergrupo asc, ITEM.nombre asc';
		$sortdir='asc';
		$criterio_filtro=' INGDET.id_ingreso = '.$_SESSION["rep_ing_id_ingreso"];
		/*echo "query: ".$criterio_filtro;
		exit;*/
		//Leer las líneas del fichero
		$Custom=new cls_CustomDBAlmacenes();
		$Custom->ListarIngresoDetalleReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

		$resp=$Custom->salida;

		$this->SetFont('','',6);
		//Se imprime los datos del reporte
		$cant_total=0;
		$tot=count($resp);

		foreach($resp as $row)
		{
			//Verifica si es el último registro para dibujar la línea inferior
			/*if($cont==$tot){
			//Por ser último registro, se pone como 51 la variable fil para que dibuje la línea inferior
			$this->fil=51;
			}

			//Verifica si es la última línea de la página
			if($this->fil>50){
			//Imprime la línea inferior
			$this->Cell($w[0],3.5,$cont,'LBR',0,'C',$fill);//LTRB
			$this->Cell($w[1],3.5,$row[0],'LBR',0,'L',$fill);
			$this->Cell($w[2],3.5,$row[3],'LBR',0,'R',$fill);
			$this->Cell($w[3],3.5,$row[5],'LBR',0,'C',$fill);
			$this->Cell($w[4],3.5,$row[7],'LBR',0,'C',$fill);
			$this->Cell($w[5],3.5,$row[8],'LBR',0,'L',$fill);
			$this->Cell($w[6],3.5,$row[4],'LBR',0,'R',$fill);
			$this->Cell($w[7],3.5,$row[9],'LBR',1,'R',$fill);
			//Inicializa el contador de filas
			$this->fil=1;
			//Notifica que es una página nueva
			$this->inicio_pag=true;
			}
			else {
			if($this->inicio_pag){
			//Por ser inicio de página imprime los rótulos de las columnas
			$this->SetFont('','',8);
			for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],5,$header[$i],1,0,'C',1);
			$this->Ln();
			$this->inicio_pag=false;
			$this->SetFont('','',6);
			}*/
			//Imprime los datos solo con líneas de la izquierda y derecha
			$this->Cell($w[0],3.5,$cont,'LTBR',0,'C',$fill);
			$this->Cell($w[1],3.5,$row[0],'LTBR',0,'L',$fill);
			$this->Cell($w[2],3.5,$row[3],'LTBR',0,'R',$fill);
			$this->Cell($w[3],3.5,$row[5],'LTBR',0,'C',$fill);
			$this->Cell($w[4],3.5,$row[7],'LTBR',0,'C',$fill);
			$this->Cell($w[5],3.5,$row[8],'LTBR',0,'L',$fill);
			$this->Cell($w[6],3.5,$row[4],'LTBR',0,'R',$fill);
			$this->Cell($w[7],3.5,$row[9],'LTBR',1,'R',$fill);
			//}
			//Actualiza los datos auxiliares
			$cant_total+=$row[3];
			$cont=$cont+1;
			$this->fil++;
		}

		//Imprime el total de las cantidades
		$this->Cell($w[0],3.5,'','LB',0,'C',$fill);
		$this->Cell($w[1],3.5,'Cantidad Total: ','B',0,'R',$fill);
		$this->Cell($w[2],3.5,$cant_total,'B',0,'R',$fill);
		$this->Cell(143,3.5,'','BR',1,'R',$fill);

		//Imprime las observaciones si es que hubieran
		$this->Cell(192,3.5,'Observaciones:','LR',1,'L',$fill);
		$this->Cell(192,3.5,$data[0][11],'LBR',1,'L',$fill);

		// Se imprime el detalle de cada UC solicitada
		/*foreach($data as $row)
		{
		$imprimir_footer=0;
		//Obtiene el detalle
		$cont=1;
		$cant=100;
		$puntero=0;
		$sortcol='OSUCDE.id_tipo_unidad_constructiva';
		$sortdir='asc';
		$criterio_filtro=' OSUCDE.id_salida = '.$_SESSION["rep_mat_id_salida"].' AND OSUCDE.id_tipo_unidad_constructiva = '.$row[6];
		$Det=new cls_CustomDBAlmacenes();
		$Det->PedidoMaterialesUCDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$detalle=$Det->salida;
		$this->AddPage();

		//Imprime el título del detalle
		$this->SetFont('Arial','B',12);
		$this->Cell(185,13,'SALIDA DE MATERIALES',0,0,'C');
		$this->Ln(6);
		$this->Cell(185,10,$data[0][0],0,0,'C');//,'LR',0,'C');
		$this->Ln(6);
		$this->SetFont('Arial','',10);

		$this->Cell(120,10,'Solicitante: '.$data[0][7],0,0,'L');//,'LR',0,'C');
		$this->Ln(4);
		$this->Cell(120,10,'Receptor autorizado: '.$data[0][1],0,0,'L');//,'LR',0,'C');
		$this->Cell(140,10,'Fecha: '.$data[0][2],0,0,'L');//,'LR',0,'C');
		$this->Ln(4);
		$this->Cell(120,10,'Unidad Constructiva:    '.$detalle[0][8],0,0,'L');//,'LR',0,'C');
		$this->Ln(4);
		$this->Cell(120,10,'Componente:    '.$detalle[0][1],0,0,'L');//,'LR',0,'C');
		$this->Ln(4);
		$this->Cell(120,10,'Cantidad:    '.round($detalle[0][2] * 100)/100,0,1,'L');//,'LR',0,'C'); round(valor_float * 100) / 100

		//Imprime los rótulos del detalle
		$this->SetFont('Arial','',8);
		for($i=0;$i<count($header_det);$i++)
		$this->Cell($wdet[$i],7,$header_det[$i],1,0,'C',1);
		$this->Ln();

		$this->SetFont('Arial','',7);
		foreach($detalle as $row)
		{
		$this->Cell($wdet[0],4,$cont,'LTRB',0,'C',$fill);
		$this->Cell($wdet[1],4,$row[3],'LTRB',0,'L',$fill);
		$this->Cell($wdet[2],4,$row[4],'LTRB',0,'L',$fill);
		$this->Cell($wdet[3],4,$row[5],'LTRB',0,'L',$fill);
		$this->Cell($wdet[4],4,round($row[6]*100)/100,'LTRB',0,'R',$fill);
		$this->Cell($wdet[5],4,round($row[7]*100)/100,'LTRB',1,'R',$fill);
		$cont=$cont+1;
		}


		}*/


		/*if($tipo=="raiz"){
		for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
		$this->Ln();
		//Restauración de colores y fuentes
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('Arial','',8);
		//Datos
		$fill=0;
		//$CustomCantidad= new rcm_cls_CustomDBAlmacenes();

		foreach($data as $row)
		{
		if($row["tipo"]=="item"){

		$this->Cell($w[0],6,$row[3],'LTRB',0,'L',$fill);
		$this->Cell($w[1],6,$row[4],'LTRB',0,'L',$fill);
		$this->Cell($w[2],6,$fecha,'LTRB',0,'L',$fill);
		}
		else{

		$this->Cell($w[0],6,$row[1],'LTRB',0,'L',$fill);
		$this->Cell($w[1],6,$row[2],'LTRB',0,'L',$fill);
		$this->Cell($w[2],6,$fecha,'LTRB',0,'L',$fill);
		$rama[]=$row["id_tipo_unidad_constructiva"];
		$rama_nombre[]=$row["nombre"];
		$composicion=$row["id_composicion_tuc"];
		$filtro="TUCREEM.id_composicion_tuc=$composicion";
		$sort="TIPOUC.codigo";
		$dir="ASC";
		$CustomReemp=new cls_CustomDBAlmacenes();
		$CustomReemp->ListarTipoUnidadConsReemplazo(15,0,$sort,$dir,$filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$nodes_reemp=$CustomReemp->salida;
		if(sizeof($nodes_reemp!=0)){

		foreach ($nodes_reemp as $reemp){
		$rama[]=$reemp["id_tipo_unidad_constructiva"];
		$rama_nombre[]=$reemp["desc_nombre"];
		$this->Ln();
		$this->Cell($w[0],6,$reemp["desc_tipo_unidad_constructiva"],'LTRB',0,'L',!$fill);
		$this->Cell($w[1],6,$reemp["desc_nombre"],'LTRB',0,'L',!$fill);
		$this->Cell($w[2],6,$fecha,'LTRB',0,'L',!$fill);
		$fill=!$fill;

		}

		}

		}
		$this->Ln();
		$fill=!$fill;



		}
		//////////////////////////////////////////////////
		//////////////////////////////////////////////////

		if(sizeof($rama)!=0){
		$header_item=array('Código','Material','Descripción','Cantidad');
		$i=0;
		foreach ($rama as $id){
		$datos=$this->LoadData($id,"rama");
		$_SESSION['nombre_cabecera']=$rama_nombre[$i];
		$this->AddPage();
		$_SESSION['nombre_pie']=$rama_nombre[$i];
		$this->FancyTable($header_item,$datos,"rama");
		$i=$i+1;

		}

		}

		}
		else{
		for($i=0;$i<count($header);$i++)
		$this->Cell($wi[$i],7,$header[$i],1,0,'C',1);
		$this->Ln();
		//Restauración de colores y fuentes
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('Arial','',8);
		//Datos
		$fill=0;
		foreach($data as $row)
		{
		$this->Cell($wi[0],6,$row[3],'LTRB',0,'L',$fill);
		$this->Cell($wi[1],6,$row[4],'LTRB',0,'L',$fill);
		$this->Cell($wi[2],6,$row[6],'LTRB',0,'L',$fill);
		$this->Cell($wi[3],6,$row[8],'LTRB',0,'R',$fill);
		//$this->Cell($wi[4],6,$row[8]*$row[11],'LTRB',0,'R',$fill);
		$this->Ln();
		$fill=!$fill;
		}
		}*/


	}

	/*function AcceptPageBreak()
	{
	if($this->col>41)
	{

	}
	}*/

}

$pdf=new PDF('pdf','maestro-detalle','Letter','L');
//define las etiquetas del maestro y la alineacion
$pdf->defineMaestro(array('etiqueta1','etiqueta2','etiqueta3'),'L');
//dibuja el reporte
$pdf->AliasNbPages();
$pdf->AddPage('L');
$pdf->SetFont('Times','',12);
$pdf->SetAutoPageBreak(true,25);
$matriz=array(array('1 hd hd dfhfdgfdhgfd','hfdfdgfdh dh gfdhgfdgfdhgf2','hgdgfd hgf hgfdhgfd3','hgddhgfdgd4 5 6 7'),
array('1hgfdh gfd','hdhgfd2',' gfh df fd3','4 hdfdhwgdsfgfds gfdsgfds fgds  5 6 7'),
array('1gfdsgfds fds sdgfdsgfdsgfdsgfdsg gfds','2gfds fds gdsfgfds gfds gfdsgfdsgfds','3gfdsgfdsgfdsgfds','4 5gfdsgfdsgfdsg gfdsg sdfg 6 7'),
array('1','2gfdsg fdsg fds','3gfdsgfdsgfdsg fds dsfgfdsg gfdsgfdsg','4 5gfdsg fdsgfdsgfdsgfdsg gfdsgfdsgfsd gfdsg 6 7'));
$pdf->datoMaestro(array('dato1','dato2','dato3'));
//dibujo la matriz y le mando 1 o 0 dependiendo de si quiero bordes o no

/*$pdf->id_almacen=$id_almacen;
$pdf->id_almacen_ep=$id_almacen;
$pdf->id_almacen_logico=$id_almacen_logico;
$pdf->id_supergrupo=$id_supergrupo;
$pdf->id_grupo=$id_grupo;
$pdf->id_subgrupo=$id_subgrupo;
$pdf->id_id1=$id_id1;
$pdf->id_id2=$id_id2;
$pdf->id_id3=$id_id3;
$pdf->id_item=$id_item;*/


$pdf->id_almacen="'%'";
$pdf->id_almacen_ep="'%'";
$pdf->id_almacen_logico="'%'";
$pdf->id_supergrupo="'%'";
$pdf->id_grupo="'%'";
$pdf->id_subgrupo="'%'";
$pdf->id_id1="'%'";
$pdf->id_id2="'%'";
$pdf->id_id3="'%'";
$pdf->id_item="'%'";

$data=$pdf->LoadDataDetalle();


$pdf->SetLineWidth(.1);
$pdf->SetFillColor(190,190,190);
$pdf->imprimir_tabla($data,1,1);
//imprime el reporte
$pdf->Output();
?>