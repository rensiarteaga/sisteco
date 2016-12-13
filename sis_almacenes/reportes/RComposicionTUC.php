<?php
// Extend the TCPDF class to create custom MultiRow
class RComposicionTUC extends  ReportePDF {
	var $datos_titulo;
	var $datos_detalle;
	var $desde;
	var $hasta;
	var $nivel;
	var $ancho_hoja;
	var $gerencia;
	var $numeracion;
	var $ancho_sin_totales;
	var $cantidad_columnas_estaticas;
	var $codigos;
	var $total_activo;
	var $total_pasigo;
	var $total_patrimonio;
	var $total_ingreso;
	var $total_egreso;
	var $tipo_balance;
	var $incluir_cierre;
	
	function datosHeader ( $detalle) {
		$this->ancho_hoja = $this->getPageWidth()-PDF_MARGIN_LEFT-PDF_MARGIN_RIGHT-10;
		$this->datos_detalle = $detalle;		
		$this->SetMargins(5,30);
	}
	
	function Header() {
		//cabecera del reporte
		$this->Image(dirname(__FILE__).'/../../lib'.$_SESSION['_DIR_LOGO'], $this->ancho_hoja, 5, 30, 10);
		$this->ln(7);
		$this->SetFont('','BU',12);
		$this->Cell(0,5,"COMPOSICION DE UNIDAD CONSTRUCTIVA",0,1,'C');	
		
		$this->Ln(7);
		$this->SetFont('','B',10);
		
		//Titulos de columnas superiores
		$this->Cell(10,3.5,'Nº','LTB',0,'C');
		$this->Cell(40,3.5,'UC','LTB',0,'C');
		$this->Cell(80,3.5,'Desc Item','LTB',0,'C');
		$this->Cell(25,3.5,'Cant Soli.','LTB',0,'C');
		$this->Cell(25,3.5,'Cant Disp.','LTB',0,'C');
		$this->Cell(25,3.5,'Cant Faltante','LTBR',0,'C');
		$this->ln();	
		
	
		
		
   }
	
	function generarReporte() {
		
		$this->total_activo = 0;
	    $this->total_pasigo = 0;
	    $this->total_patrimonio = 0;
		$this->total_ingreso = 0;
		$this->total_egreso = 0;		
		//Reporte de unasola columna de monto
		
		$this->generarReporte1C();
		
		
		//escribe formula contabla
		$this->SetFont('times', 'BI', 17);
		$tactivo = number_format( $this->total_activo , 2 , '.' , ',' );
		$tpasivo = number_format( $this->total_pasivo , 2 , '.' , ',' );
		$tpatrimonio = number_format( $this->total_patrimonio , 2 , '.' , ',' );
		$tingreso = number_format( $this->total_ingreso , 2 , '.' , ',' );
		$tegreso = number_format( $this->total_egreso , 2 , '.' , ',' );
		$resultado = $this->total_ingreso - $this->total_egreso;
		$resultado = number_format( $resultado , 2 , '.' , ',' );
		$sw_dif = 0;
		
		
		
		
	}
	
	
	function generarReporte1C() {
			$this->setFontSubsetting(false);
			$this->AddPage();
			
			//configuracion de la tabla
			$this->SetFont('','',9);
			$conf_par_tablewidths=array(10,40,80,25,25,25);
			$conf_par_tablealigns=array('C','L','L','R','R','R');
			$conf_par_tablenumbers=array(0,0,0,1,1,1);
			 $conf_tableborders=array();
			$conf_tabletextcolor=array();
			$this->tablewidths=$conf_par_tablewidths;
	        $this->tablealigns=$conf_par_tablealigns;
	        $this->tablenumbers=$conf_par_tablenumbers;
	        $this->tableborders=$conf_tableborders;
	        $this->tabletextcolor=$conf_tabletextcolor;
			
			$count  = 1;
						
	        foreach ($this->datos_detalle as $val) {	       		
			
		       	
						$this->SetFillColor(224, 235, 255);
				        $this->SetTextColor(0);
				        $this->SetFont('','',8);
							
						
						
						$RowArray = array(
				            			's0' => $count,
										's1' => $val['desc_uc'],
				                        's2' => '('.$val['item'].') '.$val['desc_item'],
				                        's3' => $val['cantidad_solicitada'],
				                        's4' => $val['cant_disp'],
				                        's5' => $val['cant_faltante']);
										
						$this-> MultiRow($RowArray,$fill,1);	
						$count++;
					
				
			}	
			
	}
	
	
}
?>