<?php
/*Clase de Ejemplo de Uso de la libreria reporte para reportes
  genericos.
*/
//reporte.php y herencia de reporte
require_once('reporte.php');
require_once('../jpgraph/src/jpgraph.php');
require_once("../jpgraph/src/jpgraph_gantt.php");
class PDF extends Reporte
{
	//sobreescribir la funcion header
	function Header(){
		//coloca titulo al reporte la cntidad de parametros por linea y la posicion del logo R-> derecha  L->izquierda
		$this->ArmaHeader("TITULO DEL REPORTE",3,'R');
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
		//Dibuja una linea horizontal del ancho de la pagina cualquiera q esta sea
		$this->lineaHor();
		$anchos=array(50,30,40,60);
		$nombres=array('aaaaaaaaaaaaa','bbbbbbbbbbbbb ','ccccccccccccccccccccccccccccccc','gfsdgrewh bcdzg gfsdg fds');
		//coloca la cabecera y los anchos de las columnas a dibujar
		$this->cabeceraColDet($anchos,$nombres,1);
	}
	function dibujaGrafico(){
	
		// Basic Gantt graph
		$graph = new GanttGraph();
		$graph->title->Set("Using the builtin icons");
		
		// Explicitely set the date range 
		// (Autoscaling will of course also work)
		$graph->SetDateRange('2001-10-06','2002-8-23');
		
		
		// 1.5 line spacing to make more room
		$graph->SetVMarginFactor(1.5);
		
		// Setup some nonstandard colors
		$graph->SetMarginColor('lightgreen@0.8');
		$graph->SetBox(true,'yellow:0.6',2);
		$graph->SetFrame(true,'darkgreen',4);
		$graph->scale->divider->SetColor('yellow:0.6');
		$graph->scale->dividerh->SetColor('yellow:0.6');
		
		// Display month and year scale with the gridlines
		$graph->ShowHeaders(GANTT_HMONTH | GANTT_HYEAR | GANTT_HWEEK );
		$graph->scale->month->grid->SetColor('gray');
		$graph->scale->month->grid->Show(true);
		$graph->scale->year->grid->SetColor('gray');
		$graph->scale->year->grid->Show(true);
		
		// For the titles we also add a minimum width of 100 pixels for the Task name column
		$graph->scale->actinfo->SetColTitles(
		    array('Tipo','Estado','Duracion','Inicio','Fin'),array(30,100));
		$graph->scale->actinfo->SetBackgroundColor('green:0.5@0.5');
		$graph->scale->actinfo->SetFont(FF_ARIAL,FS_NORMAL,10);
		$graph->scale->actinfo->vgrid->SetStyle('solid');
		$graph->scale->actinfo->vgrid->SetColor('gray');
		
		// Uncomment this to keep the columns but show no headers
		//$graph->scale->actinfo->Show(false);
		
		
		
		// Store the icons in the first column and use plain text in the others
		$data = array(
		    array(0,array("Solicitud","Pre-study","102 days","23 Nov '01","1 Mar '02")
		          , "2001-10-23","2001-10-23"),
		    array(1,array("preaprobacion","Prototype","21 days","26 Oct '01","16 Nov '01"),
		          "2001-10-23","2001-10-23"),
		    array(2,array("aprobacion","Report","12 days","1 Mar '02","13 Mar '02"),
		          "2001-10-23","2001-10-23")
		);
		    
		// Create the bars and add them to the gantt chart
		for($i=0; $i<count($data); ++$i) {
		    if($i==0){
		    	$bar = new GanttBar($data[$i][0],$data[$i][1],$data[$i][2],$data[$i][3],'',8);
			    $bar->title->SetFont(FF_FONT1,FS_BOLD,11);		
			    $bar->rightMark->Show();
			    $bar->rightMark->SetType(MARK_RIGHTTRIANGLE);
			    $bar->rightMark->SetWidth(8);
			    $bar->rightMark->SetColor('black');
			    $bar->rightMark->SetFillColor('black');
		    
			    $bar->leftMark->Show();
			    $bar->leftMark->SetType(MARK_LEFTTRIANGLE);
			    $bar->leftMark->SetWidth(8);
			    $bar->leftMark->SetColor('black');
			    $bar->leftMark->SetFillColor('black');
		    
			    $bar->SetPattern(BAND_SOLID,'black');
			    $csimpos = 6;
			     // Setup caption
			    $bar->caption->Set($data[$i][$csimpos-1]);
		
			    // Check if this activity should have a CSIM target ?
			    if( !empty($data[$i][$csimpos]) ) {
				$bar->SetCSIMTarget($data[$i][$csimpos]);
				$bar->SetCSIMAlt($data[$i][$csimpos+1]);
			    }
			    if( !empty($data[$i][$csimpos+2]) ) {
				$bar->title->SetCSIMTarget($data[$i][$csimpos+2]);
				$bar->title->SetCSIMAlt($data[$i][$csimpos+3]);
			    }
		
			    $graph->Add($bar);
		    }
			else{
				$bar = new GanttBar($data[$i][0],$data[$i][1],$data[$i][2],$data[$i][3],10);
			    if( count($data[$i])>4 )
			        $bar->title->SetFont($data[$i][4],$data[$i][5],$data[$i][6]);
			    $bar->SetPattern(BAND_RDIAG,"yellow");
			    
			    $bar->SetFillColor("gray");
			    $bar->progress->SetPattern(GANTT_SOLID,"darkgreen");
			    $bar->title->SetCSIMTarget(array('#1'.$i,'#2'.$i,'#3'.$i,'#4'.$i,'#5'.$i),array('11'.$i,'22'.$i,'33'.$i));
			    $graph->Add($bar);
			}
		}
		
		// ... and display it
		$im=$graph->Stroke(_IMG_HANDLER);
    	$alto=Image::GetWidth($im);
    	$ancho=Image::GetHeight($im);
		$alto=$alto/2.834;
		$alto=$ancho/2.834;
		
		
		$this->GDImage($im,10,100,$ancho,$alto);
		
		imagedestroy($im);
		
	}
	
}

//Creación del objeto de la clase heredada
$pdf=new PDF('pdf','maestro-detalle','A4','L');
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
$pdf->dibujaTabla($matriz,1);
//dibuja el diagrama de gantt
$pdf->dibujaGrafico();
//imprime el reporte
$pdf->Output();

?>
