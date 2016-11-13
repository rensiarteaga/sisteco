<?php
$dir = dirname(__FILE__);
require_once $dir . '/../../../lib/phprtflite-1.2.0/lib/PHPRtfLite.php';
require_once $dir . '/../../../lib/rtf_new/class_rtf_v2.php';



class InformeViajeRTF {
	private $rtf;
	private $remitente;
	private $destinatario;
	private $asunto;
	private $imgHeader;
	private $cargo;
	private $filename;
	private $destviaje;
	public function setRemitente($remitente) {
		$this->remitente = $remitente;
	}
	
	public function getRemitente() {
		return $this->remitente;
	}
	
	public function setDestinatario($destinatario) {
		$this->destinatario = $destinatario;
	}
	
	public function getDestinatario() {
		return $this->destinatario;
	}
	
	public function setAsunto($asunto) {
		$this->asunto = $asunto;
	}
	
	public function getAsunto() {
		return $this->asunto;
	}
	
	public function setImgHeader($imgHeader) {
		$this->imgHeader = $imgHeader;
	}
	
	public function getImgHeader() {
		return $this->imgHeader;
	}
	
	public function setCargo($cargo) {
		$this->cargo = $cargo;
	}
	
	public function getCargo() {
		return $this->cargo;
	}
	
	public function setFilename($filename) {
		$this->filename = $filename;
	}
	
	public function getFilename() {
		return $this->filename;
	}

	public function setDestViaje($destViaje){
		$this->destviaje = $destViaje;
	}
	
	public function getDestViaje(){
		return $this->destviaje;
	}
	
	
	function acentos_enies($cadena) {
		$minusculas = array ("á"=>"á","é"=>"é","í"=>"í","ó"=>"ó", "ú"=>"ú","ñ"=>"ñ");
		$mayusculas = array ("Á"=>"Á","É"=>"É","Í"=>"Í","Ó"=>"Ó", "Ú"=>"Ú","Ñ"=>"Ñ");
	
		$cad = strtr($cadena,$minusculas);
		$cad = strtr($cadena,$mayusculas);
		return $cad;
	}
		
		public function writeRTF() {
		
		
		PHPRtfLite::registerAutoloader();
		$this->rtf = new PHPRtfLite();
		$this->rtf->setMargins(3,2,2,0);
		
		
		$fontConfig = new PHPRtfLite_Font(7, "Tahoma");
		
		$borderConfig = new PHPRtfLite_Border($this->rtf, new PHPRtfLite_Border_Format(1, "#000"), new PHPRtfLite_Border_Format(1, "#000"), new PHPRtfLite_Border_Format(1, "#000"), new PHPRtfLite_Border_Format(1, "#000"));
		$titleFormat = new PHPRtfLite_ParFormat();
		$titleFormat->setSpaceBetweenLines(1);
		$titleFormat->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);
		
		
		$contentFormat = new PHPRtfLite_ParFormat();
		$contentFormat->setSpaceBetweenLines(1);
		$contentFormat->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_LEFT);
		
		$section = $this->rtf->addSection();
		$header = $section->addHeader();
		$header->setPosition(0.5);
		
		$table = $header->addTable(PHPRtfLite_Table::ALIGN_RIGHT);
		$table->addRow(0.3);
		$table->addColumnsList(array(20));
		$cell = $table->getCell(1,1);
		$imgParFormat = new PHPRtfLite_ParFormat();
		$imgParFormat->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_RIGHT);
		$cell->addImage($this->imgHeader, $imgParFormat);
		
		
	
		
		$fontConfigTitle = new PHPRtfLite_Font(9, "Tahoma");
		$fontConfigTitle->setBold(true);
		$section->writeText("A: ".acentos_enies($this->destinatario), $fontConfigTitle, $contentFormat);
		
		$section->writeText("DE:   ".acentos_enies($this->remitente)." - ". $this->cargo, $fontConfigTitle, $contentFormat);
		$Rtf=new Rtf();
		
		$section->writeText("ASUNTO:   ". $this->asunto, $fontConfigTitle, $contentFormat);
		$section->writeText("<BR>");
		/******************/
		
		$Rtf->addText("preuabaaa");
		
		
		
		/******************/
		
		$tableDatosRefer = $section->addTable();
		$tableDatosRefer->addRow(0.3);
		$tableDatosRefer->addRow(0.3);
		$tableDatosRefer->addColumnsList(array (16));
		
		$cell = $tableDatosRefer->getCell(1, 1);
		$cell->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell->setBackgroundColor("#ddd");
		$cell->setBorder($borderConfig);
		$cell->writeText("<strong>DATOS REFERENCIALES DE LA COMISION</strong>", $fontConfig, $titleFormat);
		
		$cell2 = $tableDatosRefer->getCell(2, 1);
		$cell2->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell2->setBorder($borderConfig);
		
		$contentFormat1 = new PHPRtfLite_ParFormat();
		$contentFormat1->setSpaceBetweenLines(0.2);
		$contentFormat1->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_LEFT);
		
		$cell2->writeText("<TAB>            DD  |  MM  |  AAAA<TAB><TAB><TAB>             DD  |  MM  |  AAAA", new PHPRtfLite_Font(6, "Tahoma"), $contentFormat1);
		$cell2->writeText("<strong>FECHA INICIO VIAJE:    ____/____/_____<TAB><TAB>FECHA RETORNO VIAJE:  ____/____/_____</strong>", $fontConfig, $contentFormat1);
												
		$cell2->writeText("<TAB>                HH       MM<TAB><TAB><TAB>                  HH        MM", new PHPRtfLite_Font(6, "Tahoma"), $contentFormat1);
		$cell2->writeText("<strong>HORA INICIO VIAJE:     ____ : ____<TAB><TAB>HORA RETORNO VIAJE:   ____ : ____</strong>", $fontConfig, $contentFormat1);
		
		$cell2->writeText("<strong>TIPO DE TRANSPORTE:     AEREO:  ______ <TAB>     TERRESTRE:  ______ <TAB>   FLUVIAL:  ______</strong>", $fontConfig, $contentFormat);
		
		$cell2->writeText("<strong>LUGAR (ES) DESTINO: ____________________________________________________________________</strong>", $fontConfig, $contentFormat);
		$cell2->writeText("____________________________________________________________________________________________________", $fontConfig, $contentFormat);
		$cell2->writeText("<strong>Nro. DIAS DE VIAJE: _____________    <TAB> CUENTA CON FONDO EN AVANCE:   SI _____    NO _____</strong>", $fontConfig, $contentFormat);
		//$cell2->writeText("RECONOCIMIENTO DEL VIÁTICO: (marcar con una X el que corresponda)", $fontConfig, $contentFormat);
		//$cell2->writeText("VIATICOS CON HOSPEDAJE: ____________   VIATICOS SIN HOSPEDAJE: ____________", $fontConfig, $contentFormat);
		
		$tableObjetivo = $section->addTable();
		$tableObjetivo->addRow(0.);
		$tableObjetivo->addRow(0.3);
		$tableObjetivo->addColumnsList(array (16));
		
		$cell = $tableObjetivo->getCell(1, 1);
		$cell->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell->setBackgroundColor("#ddd");
		$cell->setBorder($borderConfig);
		$cell->writeText("<strong>OBJETIVO DE LA COMISION DE VIAJE</strong>", $fontConfig, $titleFormat);
		
		$cell2 = $tableObjetivo->getCell(2, 1);
		$cell2->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell2->setBorder($borderConfig);
		
		$cell2->writeText("<TAB><TAB><TAB><TAB><TAB><TAB><TAB><TAB><TAB><TAB><TAB><TAB>", $fontConfig, $contentFormat);
		//$cell2->writeText("__________________________________________________________________________________", $fontConfig, $contentFormat);
		//$cell2->writeText("__________________________________________________________________________________", $fontConfig, $contentFormat);
		//$cell2->writeText("__________________________________________________________________________________", $fontConfig, $contentFormat);
		
		
		$tableCambioItinerario = $section->addTable();
		$tableCambioItinerario->addColumnsList(array (4.2,11.8));
		$tableCambioItinerario->addRow(0.3);
		$tableCambioItinerario->addRow(0.3);
		$tableCambioItinerario->addRow(0.3);
		$tableCambioItinerario->addRow(0.3);
		//$tableCambioItinerario->addColumnsList(array (16));
		$tableCambioItinerario->mergeCellRange(1, 1, 1,2);
		$cell = $tableCambioItinerario->getCell(1, 1);
		$cell->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell->setBackgroundColor("#ddd");
		$cell->setBorder($borderConfig);
		
		$cell->writeText("<strong>CAMBIO DE ITINERARIO Y/O AMPLIACION DE FECHA</strong>", $fontConfig, $titleFormat);
		
		$tableCambioItinerario->mergeCellRange(2, 1, 2,2);
		$cell2 = $tableCambioItinerario->getCell(2, 1);
		$cell2->setBorder($borderConfig);
		$cell2->setCellPaddings(0.1, 0.1, 0.1, 0.1, 0.1,0.1);
		//$cell2->writeText("FECHA (S) DE CAMBIO: ______________________    DIAS DE CAMBIO: ___________________", $fontConfig, $contentFormat);
		//$cell2->writeText("MOTIVO DEL CAMBIO: ______________________________________________________________", $fontConfig, $contentFormat);
		$cell2->writeText("<Strong>AUTORIZADO POR: _______________________________________________________________________</Strong>", $fontConfig, $contentFormat);
		
		
		//$tableCambioItinerario->mergeCellRange(3, 1, 3,2);
		
		$cell2 = $tableCambioItinerario->getCell(3, 1);
	
		$borderConfigD = new PHPRtfLite_Border($this->rtf,new PHPRtfLite_Border_Format(1, "#000"), new PHPRtfLite_Border_Format(1, "#000"),  null, new PHPRtfLite_Border_Format(1, "#000"));
		
		$cell2->setBorder($borderConfigD);
		$cell2->writeText("<Strong>MOTIVO DE LAS PENALIDADES: </Strong>", $fontConfig, $contentFormat );
		$cell2 = $tableCambioItinerario->getCell(3, 2);
	
	
		$borderConfigI = new PHPRtfLite_Border($this->rtf, null, new PHPRtfLite_Border_Format(1, "#000"), new PHPRtfLite_Border_Format(1, "#000"), new PHPRtfLite_Border_Format(1, "#000"));
		
		
		
		$cell2->setBorder($borderConfigI);
		$cell2->writeText("(marcar con una X el que corresponda)",new PHPRtfLite_Font(5, "Tahoma"),$contentFormat);
		
		$tableCambioItinerario->mergeCellRange(4, 1, 4,2);
		
		$cell2 = $tableCambioItinerario->getCell(4, 1);
		$cell2->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell2->setBorder($borderConfig);
		$cell2->writeText("<Strong>CAMBIO DE HORA:  ________     CAMBIO DE FECHA:  __________     CAMBIO DE NOMBRE: _________</Strong>", $fontConfig, $contentFormat);
		
		
		
		
		
		$tableInforme = $section->addTable();
		$tableInforme->addColumnsList(array (2,2.9,4,4,1.6, 1.5));
		$tableInforme->addRow(0.1);
		$tableInforme->addRow(0.1);
		$tableInforme->addRow(0.1);
		$tableInforme->addRow(0.1);
		$tableInforme->addRow(0.1);
		$tableInforme->addRow(0.1);
	//	$tableInforme->addRow(0.1);
	//	$tableInforme->addRow(0.1);
		
		
		$tableInforme->mergeCellRange(1, 1, 1,3);
		$cell = $tableInforme->getCell(1, 1);
		$cell->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell->setBackgroundColor("#ddd");
		$cell->setBorder($borderConfigD);
		
		$titleFormatD = new PHPRtfLite_ParFormat();
		$titleFormatD->setSpaceBetweenLines(1);
		$titleFormatD->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_RIGHT);
		$cell->writeText("<strong>INFORME DE ACTIVIDADES CRONOLOGICA</strong>", new PHPRtfLite_Font(7, "Tahoma"), $titleFormatD);
		
		
		$tableInforme->mergeCellRange(1, 4, 1,6);
		$cell = $tableInforme->getCell(1,4);
		//$cell->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell->setBackgroundColor("#ddd");
		$cell->setBorder($borderConfigI);
		$titleFormatI = new PHPRtfLite_ParFormat();
		$titleFormatI->setSpaceBetweenLines(0.9);
		$titleFormatI->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_LEFT);
		$cell->writeText("<strong> (INSERTAR FILAS SI CORRESPONDE)</strong>",new PHPRtfLite_Font(5, "Tahoma"), $titleFormatI);
		
		
		$cell2 = $tableInforme->getCell(2, 1);
		$cell2->setBackgroundColor("#ddd");
		$cell2->setBorder($borderConfig);
		$cell2->setCellPaddings(0.1, 0.1, 0.1, 0.1, 0.1,0.1);
		$cell2->writeText("<strong>FECHA</strong>", new PHPRtfLite_Font(6, "Tahoma"), $titleFormat);
		
		$cell2 = $tableInforme->getCell(2, 2);
		$cell2->setBackgroundColor("#ddd");
		$cell2->setBorder($borderConfig);
		$cell2->setCellPaddings(0.1, 0.1, 0.1, 0.1, 0.1,0.1);
		$cell2->writeText("<strong>LUGAR</strong>", new PHPRtfLite_Font(6, "Tahoma"), $titleFormat);
		
		
	
		$cell2 = $tableInforme->getCell(2, 3);
		$cell2->setBackgroundColor("#ddd");
		$cell2->setBorder($borderConfig);
		$cell2->setCellPaddings(0.1, 0.1, 0.1, 0.1,0.1);
		$cell2->writeText("<strong>ACTIVIDADES DESARROLLADAS</strong>", new PHPRtfLite_Font(6, "Tahoma"), $titleFormat);
		$tableInforme->mergeCellRange(2, 3, 2,4);
		$cell2 = $tableInforme->getCell(2, 5);
		$cell2->setBackgroundColor("#ddd");
		$cell2->setBorder($borderConfig);
		$cell2->setCellPaddings(0.1, 0.1, 0.1, 0.1,0.1);
		$cell2->writeText("<strong>VIATICOS CON HOSPEDAJE</strong>", new PHPRtfLite_Font(5, "Tahoma"), $titleFormat);
		
		$cell2 = $tableInforme->getCell(2, 6);
		$cell2->setBackgroundColor("#ddd");
		$cell2->setBorder($borderConfig);
		$cell2->setCellPaddings(0.1, 0.1, 0.1, 0.1,0.1);
		$cell2->writeText("<strong>VIATICOS SIN HOSPEDAJE</strong>", new PHPRtfLite_Font(5, "Tahoma"), $titleFormat);
		
		for ($i = 3; $i<=6; $i++) {
			for($j = 1; $j<=6; $j++) {
				
				
				if($j==3){
					$tableInforme->mergeCellRange($i, $j, $i,$j+1);
				}
				$cell = $tableInforme->getCell($i, $j);
				$cell->setBorder($borderConfig);
				$cell->setCellPaddings(0.1, 0.1, 0.1, 0.1,0.1);
				$cell->setFont($fontConfig);
			}
		}
		
		$tableConclusiones = $section->addTable();
		$tableConclusiones->addRow(0.1);
		$tableConclusiones->addRow(0.3);
		
		$tableConclusiones->addColumnsList(array (8,8));
		
		
		///////////desde aqui
		$cell = $tableConclusiones->getCell(1, 1);
		$cell->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell->setBackgroundColor("#ddd");
		$cell->setBorder($borderConfigD);
		$cell->writeText("<strong>DOCUMENTOS ADJUNTOS</strong>", $fontConfig, $titleFormatD);
		
		
		$cell = $tableConclusiones->getCell(1, 2);
		$cell->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell->setBackgroundColor("#ddd");
		$cell->setBorder($borderConfigI);
		$cell->writeText("<strong>(INDIQUE LOS DOCUMENTOS QUE ADJUNTA)</strong>", new PHPRtfLite_Font(5, "Tahoma"), $titleFormatI);
		$tableConclusiones->mergeCellRange(2,1,2,2);
		$cell2 = $tableConclusiones->getCell(2, 1);
		$cell2->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell2->setBorder($borderConfig);
		
		$cell2->writeText("<Strong>1.</Strong>", $fontConfig, $contentFormat);
		$cell2->writeText("<Strong>2.</Strong>", $fontConfig, $contentFormat);
		//$cell2->writeText("_________________________________________________________________________________", $fontConfig, $contentFormat);
		//$cell2->writeText("_________________________________________________________________________________", $fontConfig, $contentFormat);
		
		
		
		$tableFirmas = $section->addTable();
		$tableFirmas->addRow(0.1);
		$tableFirmas->addRow(0.1);
		$tableFirmas->addColumnsList(array (8,8));
		
		
		$cell = $tableFirmas->getCell(1, 1);
		
		$cell->setBorder($borderConfig);
		$cell->setCellPaddings(0.1, 0.1, 0.1, 0.1, 0.1,0.1);
		$cell->writeText("", $fontConfig, $contentFormat);
		$cell->writeText("", $fontConfig, $contentFormat);
		$cell->writeText("<strong>__________________</strong>", new PHPRtfLite_Font(7, "Tahoma"), $titleFormat);
		$cell->writeText("<strong>SOLICITANTE</strong>", new PHPRtfLite_Font(7, "Tahoma"), $titleFormat);
		//$contentFormat1->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);
		$cell->writeText("".$this->remitente, new PHPRtfLite_Font(7, "Tahoma"), $titleFormat);
		
		
		$cell = $tableFirmas->getCell(1,2);
		
		$cell->setBorder($borderConfig);
		$cell->setCellPaddings(0.1, 0.1, 0.1, 0.1, 0.1,0.1);
		$cell->writeText("", $fontConfig, $contentFormat);
		$cell->writeText("", $fontConfig, $contentFormat);
		$cell->writeText("<strong>__________________</strong>", new PHPRtfLite_Font(7, "Tahoma"), $titleFormat);
		$cell->writeText("<strong>APROBADO</strong>", new PHPRtfLite_Font(7, "Tahoma"), $titleFormat);
		$cell->writeText("".$this->destviaje, new PHPRtfLite_Font(7, "Tahoma"), $titleFormat);
		
		
		
		
		//$section->writeText("Atentamente, <br><br><br>", $fontConfig);
		$endConsultorParFormat = new PHPRtfLite_ParFormat();
		$endConsultorParFormat->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);
		//$section->writeText($this->remitente, $fontConfig, $endConsultorParFormat);
		//$section->writeText("<strong>".$this->cargo."</strong>", $fontConfig, $endConsultorParFormat);
		$this->rtf->save($this->filename);
	}
}

?>