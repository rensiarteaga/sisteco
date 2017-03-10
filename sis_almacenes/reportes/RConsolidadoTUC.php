<?php
// Extend the TCPDF class to create custom MultiRow
class RConsolidadoTUC extends  ReportePDF {
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
	var $desc_almacen;
	var $desc_almacen_logico;
	
	function datosHeader ( $detalle, $parametros) {
		$this->ancho_hoja = $this->getPageWidth()-PDF_MARGIN_LEFT-PDF_MARGIN_RIGHT-10;
		$this->datos_detalle = $detalle;		
		$this->SetMargins(5,30);
		$this->desc_almacen  = $parametros["desc_almacen"];
		$this->desc_almacen_logico  = $parametros["desc_almacen_logico"];
	}
	
	function Header() {
		//cabecera del reporte
		$this->Image(dirname(__FILE__).'/../../lib'.$_SESSION['_DIR_LOGO'], $this->ancho_hoja, 5, 30, 10);
		$this->ln(3);
		$this->SetFont('','BU',12);
		$this->Cell(0,5,"DISPONIBILIDADES DE UNIDAD CONSTRUCTIVA",0,1,'C');	
		
		$this->Ln(4);
		$this->SetFont('','B',10);
		
		$this->Cell(30, 3.5, utf8_encode('Almacén Físico:'), '',0,'L'); 
		$this->Cell(60, 3.5, utf8_encode($this->desc_almacen), '',0,'L');
		
		$this->Ln();
		$this->Cell(30, 3.5, utf8_encode('Almacén Lógico:'), '',0,'L'); 
		$this->Cell(60, 3.5, utf8_encode($this->desc_almacen_logico), '',0,'L');
		$this->Ln();
		$this->SetFont('','B',10);
		
		
		
		//Titulos de columnas superiores
		$this->Cell(10,3.5,'Nº','LTB',0,'C');
		$this->Cell(60,3.5,'UC','LTB',0,'C');
		$this->Cell(85 ,3.5,'Desc Item','LTB',0,'C');
		$this->Cell(25,3.5,'Cant Soli.','LTB',0,'C');
		$this->Cell(25,3.5,'Cant Disp.','LTBR',0,'C');
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
		
		$sw_dif = 0;
		
		
		
		
	}
	
	
	function generarReporte1C() {
			$this->setFontSubsetting(false);
			$this->AddPage();
			
			//configuracion de la tabla
			$this->SetFont('','',9);
			$conf_par_tablewidths=array(10,60, 85,25,25);
			$conf_par_tablealigns=array('C','L','L','R','R');
			$conf_par_tablenumbers=array(0,0,0,1,1);
			 $conf_tablebordersr=array();
			$conf_tabletextcolor=array();
			$this->tablewidths=$conf_par_tablewidths;
	        $this->tablealigns=$conf_par_tablealigns;
	        $this->tablenumbers=$conf_par_tablenumbers;
	        $this->tableborders=$conf_tableborders;
	        $this->tabletextcolor=$conf_tabletextcolor;
			
			$count  = 1;
			
			
						
	        foreach ($this->datos_detalle as $val) {
	        	
				   		
			
			
			$this->tabletextcolor==array(1,1,1,2,'red');
		       	
						$this->SetFillColor(224, 235, 255);
				        $this->SetTextColor(0);
				        $this->SetFont('','',8);
							
						
						if($val['codigo_item'] != ''){
							$RowArray = array(
				            			's0' => $count,
										's1' => $val['codigo_tuc_padre'],
				                        's2' =>  utf8_encode('('.$val['codigo_item'].') '.$val['nombre_item']),			                        
				                        
				                        's3' => $val['cantidad_solicitada'],
				                        's4' => $val['candidad_disponible']);
						}
						else{
							$RowArray = array(
				            			's0' => $count,
										's1' => $val['codigo_tuc_padre'],
				                        's2' =>  utf8_encode('('.$val['codigo_tuc'].') '.$val['nombre_tuc']), 
				                        's3' => $val['cantidad_solicitada'],
				                        's4' => $val['candidad_disponible']);
						}
						
						if($val['candidad_disponible'] < $val['cantidad_solicitada']){
							 $this-> MultiRow($RowArray,true,1);
						}
						else{
							$this-> MultiRow($RowArray,false,1);
						}				
							
						$count++;
					
				
			}	
			
	}
	
	
}
?>