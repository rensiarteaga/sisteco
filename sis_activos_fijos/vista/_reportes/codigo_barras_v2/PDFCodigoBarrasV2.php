<?php

session_start();
/**
 * Autor: Silvia Ximena Ortiz Fernández
 * Fecha de creacion: 08/02/2011
 * Descripción: Reporte de codigo_barras_prueba
**/

require('../../../../lib/fpdf/fpdf.php');
require('Code128.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../../control/LibModeloActivoFijo.php");

//define('FPDF_FONTPATH','font/');
 
class PDF extends FPDF
{   
}
		
		$v_setdetalle1=$_SESSION["PDF_tamano"];

		$cant=500;
		$puntero=0;
		$criterio_filtro= " 0=0 and af.id_sub_tipo_activo like ''".$_SESSION["PDF_id_sub_tipo_activo"]."''";
		$criterio_filtro.=" and af.id_activo_fijo like ''".$_SESSION["PDF_id_activo_fijo"]."''";
		$criterio_filtro.=" and ta.id_tipo_activo like ''".$_SESSION["PDF_id_tipo_activo"]."''";
		
		//RCM 03-11-2011: debido a registro de códigos de activos fijos manuales (con guiones y con cualquier estructura), se quita el ordenamiento
		//numèrico del correlativo de los códigos
		//$sortcol='substr(af.codigo,6,5)::integer';
		$sortcol='af.codigo';
		$sortdir='asc';	
		
		$Custom = new cls_CustomDBActivoFijo();
		$res = $Custom->ContarCodigoBarrasPrueba($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$total_registros= $Custom->salida;	

	/* Condición para ingresar a los codigos de barras de acuerdo al tamaño elegido si elije 
		Mediano se mostrara el codigo de barras dibujado con su codigo y su descripcion */
	if($v_setdetalle1=='Mediano')
	{
		while($puntero<$total_registros)
		{	
			// Llama al ListarCodigoBarrasPrueba		
			$res = $Custom->ListarCodigoBarrasPrueba($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
			$v_setdetalle=$Custom->salida;
			
				$pdf=new PDF_Code128('L','cm',array(2.85,4.5));
				$pdf->SetAutoPageBreak(0.2);
				
				//Condicion para dibujar los codigos de barras de acuerdo a los activos fijos
				for($i=0;$i<count($v_setdetalle);$i++)
				{	 
					$pdf->SetTopMargin(0,2);//margen superior
					$pdf->SetRightMargin(0,1);//margen derecho
					$pdf->SetLeftMargin(0.1);//margen izquierdo
	
					$code='Code 128';
					
					/* Añade una pagina
					* L: Orientacion del papel por defecto viene P, en este caso es L horizontal para su 
						correcta impresion
					* cm: Por defecto viene en mm, en este caso es en cm
					* $format: por defecto es A4, pero para los codigos de barras es necesario determinar el 
								tamaño de la pagina manualmente para ello utilizo array(2.85,4.5)
					*/
					$pdf->AddPage('L','cm',array(2.85,4.5));
					//Configuracion del Formato que tendra el encabezado: ENDE
					$pdf->SetFont('Arial','B',7);
					/*Define la posicion actual en la que se encontrara el texto ENDE donde:
					* x:  abscisa
					* y: ordenada
					*/
					$pdf->SetXY(0.1,0.4);
					// Este método imprime el texto desde la posición actual.
					$pdf->Write(0,'ENDE');
					
					/* Este script se encarga de códigos de barras Código 128  (A, B y C). 
					Todos  los 128 caracteres ASCII  están disponibles. 
					En este caso se utilizara la serie B
					Code128 (float x, float y, 'Texto', float w, float h)
					w: es el ancho que tendra el codigo de barras. anteriormente el tamaño era 3 pero el 
						lector no lo reconocia y le modifique por 3.5 y ahi lo reconoce
					y: es el alto que tendra el codigo de barras, si se le reduce el alto del codigo puede 
						que el lector no lo reconozca por tal motivo lo deje en 1cm*/
					//Aqui dibuja el codigo de barras
					$pdf->Code128(0.7,0.6,''.$v_setdetalle[$i][0],3.5,1);
					
					//Configuracion de formato y posicion para que se muestre el codigo pero esta vez en cadena
					$pdf->SetXY(1.5,1.8);
					$pdf->SetFont('Arial','B',9);
					$pdf->Write(0,''.$v_setdetalle[$i][0]);
					//Configuracion de formato y posicion para que se muestre la descripcion del codigo
					$pdf->SetFont('Arial','',6);
					$pdf->SetXY(0.1,2);
					//GetStringWidth: Calcula la longitud de la cadena en este caso el limite sera 30
					$pdf->Write($pdf->GetStringWidth(30),$v_setdetalle[$i][1]);
					$pdf->Ln(1);
					
				}
					//Incrementa el puntero de 500 en 500
					$puntero+=500;
					//Output:guarda o envía el documento
					$pdf->Output();						
		}
	}
	/* Condición para ingresar a los codigos de barras de acuerdo al tamaño elegido si elije 
		Pequeño se mostrara el texto del codigo con un borde alrededor del mismo sin mas detalles*/
	if($v_setdetalle1=='Pequeno')
	{
		while($puntero<$total_registros)
		{	
		
			$res = $Custom->ListarCodigoBarrasPrueba($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
			$v_setdetalle=$Custom->salida;
			
			$pdf=new PDF_Code128('L','cm',array(2.5,5));

			$pdf->SetAutoPageBreak(0.1);
		
			for($i=0;$i<count($v_setdetalle);$i++)
			{	 
				//$pdf->SetTopMargin(0,5);//margen superior
				//$pdf->SetRightMargin(0,1);//margen derecho
				//$pdf->SetLeftMargin(0.1);//margen izquierdo

				$pdf->AddPage('L','cm',array(2.5,5));
				
				 $pdf->SetFont('Arial','B',6.5);
				 $pdf->SetXY(1.7,0.1);
				 //Imprime un celda con su borde 
			     $pdf->MultiCell(1.5,0.5,''.$v_setdetalle[$i][0],1,'C');
			     //Salto de Linea
			    // $pdf->Ln(10);
			}
				$puntero+=500;
				$pdf->Output();	
		}
	}
?>
