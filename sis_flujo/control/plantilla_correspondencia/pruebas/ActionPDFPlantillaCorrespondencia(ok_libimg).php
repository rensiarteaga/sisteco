<?php
include("../../../lib/rtf_new/class_rtf_v2.php");

function obtenerGrafico()
{
	include ("../../../lib/agata/classes/jpgraph/jpgraph.php");
	include ("../../../lib/agata/classes/jpgraph/jpgraph_line.php");

	class MiGrafico extends Graph
	{
		function devolverGrafico()
		{
			ob_start(); 		// Esta funci�n habilitar� el uso de b�feres de salida.
								// Mientras los b�feres de salida est�n activos no se env�a salida desde el script
								// (m�s que las cabeceras), en su lugar la salida es almacenada en un b�fer interno.
			$this->Stroke();
			$imagenDeLaGrafica = ob_get_contents(); // Esta funci�n devolver� los 
											  		// contenidos del b�fer de salida sin limpiarlos, o FALSE,
												    // si no est� activo el uso del b�fer de salida.
			ob_end_clean(); 	// Limpiar (eliminar) y deshabilitar los b�feres de salida
			return $imagenDeLaGrafica;		
		}
	}
	$ydata = array(11,3,8,12,5,1,9,13,5,7);
	
	$MiGrafico = new MiGrafico(350,250,"auto");
	$MiGrafico->SetScale("textlin");
	$MiGrafico->img->SetMargin(30,90,40,50);
	$MiGrafico->xaxis->SetFont(FF_FONT1,FS_BOLD);
	$MiGrafico->title->Set("Dashed lineplot");
	
	$lineplot=new LinePlot($ydata);
	$lineplot->SetLegend("Test 1");
	$lineplot->SetColor("blue");
	$lineplot->SetStyle("dashed");
	
	$MiGrafico->Add($lineplot);
	
	return $MiGrafico->devolverGrafico();
}

	$Rtf = new Rtf();
	$Rtf->setPaperSize(5);
	$Rtf->setPaperOrientation(1);
	$Rtf->setDefaultFontFace(1);
	$Rtf->setDefaultFontSize(24);
	$Rtf->setAuthor("noginn");
	$Rtf->setOperator("me@noginn.com");
	$Rtf->setTitle("rtf Document");
	$Rtf->addColour("#000000");
	$Rtf->rtfImage('logo_reporte.jpg','jpg');
	$Rtf->rtfImage('membrete.jpg','jpg');
	$Rtf->addText("<h1>Titulo 1</h1>\n");
	$Rtf->addText("<h2>Titulo 2</h2>\n");
	$Rtf->addText("<h3>Titulo 3</h3>\n");
	$Rtf->addText("<u>subrayado</u> <strong>negrita</strong> <em>Italica</em> <sub>sub indice</sub> <sup>super indice</sup> <strike>tachado</strike>\n");
	$Rtf->addText("<TAB> veamos 1 tab\n");
	$Rtf->addText("<TAB><TAB> veamos 2 tab\n");
	$Rtf->addText("<BR><BR>saltos con br<BR>");
	$Rtf->addText("\n");
	//$Rtf->rtfBinImage(obtenerGrafico()); // rtfBinImage() es la función que recibe la imagen (en formato binario) que queres agregar, independientemente de la fuente que uses	
	$Rtf->addText("\n");
	$Rtf->addText("Grafico de JpGraph\n");
	$Rtf->getDocument("mi_rtf.rtf");
?>