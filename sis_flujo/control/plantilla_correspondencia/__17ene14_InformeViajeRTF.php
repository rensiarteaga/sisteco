<?php
$dir = dirname(__FILE__);
require_once $dir . '/../../../lib/phprtflite-1.2.0/lib/PHPRtfLite.php';

class InformeViajeRTF {
	private $rtf;
	private $remitente;
	private $destinatario;
	private $asunto;
	private $imgHeader;
	private $cargo;
	private $filename;
	
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
	
	public function writeRTF() {
		PHPRtfLite::registerAutoloader();
		$this->rtf = new PHPRtfLite();
		$this->rtf->setMargins(3, 2, 2, 2);
		
		
		$fontConfig = new PHPRtfLite_Font(8, "Tahoma");
		
		$borderConfig = new PHPRtfLite_Border($this->rtf, new PHPRtfLite_Border_Format(1, "#000"), new PHPRtfLite_Border_Format(1, "#000"), new PHPRtfLite_Border_Format(1, "#000"), new PHPRtfLite_Border_Format(1, "#000"));
		$titleFormat = new PHPRtfLite_ParFormat();
		$titleFormat->setSpaceBetweenLines(1);
		$titleFormat->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);
		
		$contentFormat = new PHPRtfLite_ParFormat();
		$contentFormat->setSpaceBetweenLines(2);
		$contentFormat->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_LEFT);
		
		$section = $this->rtf->addSection();
		$header = $section->addHeader();
		$header->setPosition(0.5);
		
		$table = $header->addTable(PHPRtfLite_Table::ALIGN_RIGHT);
		$table->addRow();
		$table->addColumnsList(array(20));
		$cell = $table->getCell(1,1);
		$imgParFormat = new PHPRtfLite_ParFormat();
		$imgParFormat->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_RIGHT);
		$cell->addImage($this->imgHeader, $imgParFormat);
		
		$fontConfigTitle = new PHPRtfLite_Font(10, "Tahoma");
		$fontConfigTitle->setBold(true);
		$section->writeText("A: ".$this->destinatario, $fontConfigTitle, $contentFormat);
		
		$section->writeText("DE:   ".$this->remitente, $fontConfigTitle, $contentFormat);
		$section->writeText("ASUNTO:   ".$this->asunto, $fontConfigTitle, $contentFormat);
		$section->writeText("<BR>");
		
		
		
		/******************/
		
		/******************/
		
		$tableDatosRefer = $section->addTable();
		$tableDatosRefer->addRow();
		$tableDatosRefer->addRow();
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
		
		$cell2->writeText("<TAB>                  DD  |  MM   |  AAAA<TAB><TAB><TAB>                   DD  |  MM   |  AAAA", new PHPRtfLite_Font(6, "Tahoma"), $contentFormat1);
		$cell2->writeText("<strong>FECHA INICIO VIAJE:    ____/____/_____<TAB><TAB>FECHA RETORNO VIAJE:  ____/____/_____</strong>", $fontConfig, $contentFormat1);
												
		$cell2->writeText("<TAB>                HH       MM<TAB><TAB><TAB>                  HH        MM", new PHPRtfLite_Font(6, "Tahoma"), $contentFormat1);
		$cell2->writeText("<strong>HORA INICIO VIAJE:     ____ : ____<TAB><TAB>HORA RETORNO VIAJE:   ____ : ____</strong>", $fontConfig, $contentFormat1);
		
		$cell2->writeText("<strong>TIPO DE TRANSPORTE:     AEREO:  ______ <TAB>     TERRESTRE:  ______ <TAB>   FLUVIAL:  ______</strong>", $fontConfig, $contentFormat);
		
		$cell2->writeText("<strong>LUGAR (ES) DESTINO: ____________________________________________________________________</strong>", $fontConfig, $contentFormat);
		$cell2->writeText("____________________________________________________________________________________________________", $fontConfig, $contentFormat);
		$cell2->writeText("<strong>CANTIDAD DIAS DE VIAJE: _____________    <TAB> CUENTA CON FONDO EN AVANCE:   SI _____    NO _____</strong>", $fontConfig, $contentFormat);
		//$cell2->writeText("RECONOCIMIENTO DEL VIÁTICO: (marcar con una X el que corresponda)", $fontConfig, $contentFormat);
		//$cell2->writeText("VIATICOS CON HOSPEDAJE: ____________   VIATICOS SIN HOSPEDAJE: ____________", $fontConfig, $contentFormat);
		
		$tableObjetivo = $section->addTable();
		$tableObjetivo->addRow();
		$tableObjetivo->addRow();
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
		$tableCambioItinerario->addRow();
		$tableCambioItinerario->addRow();
		$tableCambioItinerario->addColumnsList(array (16));
		
		$cell = $tableCambioItinerario->getCell(1, 1);
		$cell->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell->setBackgroundColor("#ddd");
		$cell->setBorder($borderConfig);
		$cell->writeText("<strong>CAMBIO DE ITINERARIO Y/O AMPLIACION DE FECHA</strong>", $fontConfig, $titleFormat);
		
		$cell2 = $tableCambioItinerario->getCell(2, 1);
		$cell2->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell2->setBorder($borderConfig);
		
		//$cell2->writeText("FECHA (S) DE CAMBIO: ______________________    DIAS DE CAMBIO: ___________________", $fontConfig, $contentFormat);
		//$cell2->writeText("MOTIVO DEL CAMBIO: ______________________________________________________________", $fontConfig, $contentFormat);
		$cell2->writeText("<Strong>AUTORIZADO POR: _______________________________________________________________________</Strong>", $fontConfig, $contentFormat);
		$cell2->writeText("<Strong>MOTIVO DE LAS PENALIDADES: </Strong>(marcar con una X el que corresponda)", $fontConfig, $contentFormat);
		$cell2->writeText("<Strong>CAMBIO DE HORA:  ________     CAMBIO DE FECHA:  __________     CAMBIO DE NOMBRE: _________</Strong>", $fontConfig, $contentFormat);
		
		
		$tableInforme = $section->addTable();
		$tableInforme->addColumnsList(array (2,2.9,8,1.6, 1.5));
		$tableInforme->addRow();
		$tableInforme->addRow();
		$tableInforme->addRow(1);
		$tableInforme->addRow(1);
		$tableInforme->addRow(1);
		$tableInforme->addRow(1);
		$tableInforme->addRow(1);
		$tableInforme->addRow(1);
		
		$tableInforme->mergeCellRange(1, 1, 1,5);
		
		$cell = $tableInforme->getCell(1, 1);
		$cell->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell->setBackgroundColor("#ddd");
		$cell->setBorder($borderConfig);
		$cell->writeText("<strong>INFORME DE ACTIVIDADES - (Describir por orden cronologico) - AGREGAR FILAS SI CORRESPONDE</strong>", new PHPRtfLite_Font(8, "Tahoma"), $titleFormat);
		
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
		
		$cell2 = $tableInforme->getCell(2, 4);
		$cell2->setBackgroundColor("#ddd");
		$cell2->setBorder($borderConfig);
		$cell2->setCellPaddings(0.1, 0.1, 0.1, 0.1,0.1);
		$cell2->writeText("<strong>VIATICOS CON HOSPEDAJE</strong>", new PHPRtfLite_Font(5, "Tahoma"), $titleFormat);
		
		$cell2 = $tableInforme->getCell(2, 5);
		$cell2->setBackgroundColor("#ddd");
		$cell2->setBorder($borderConfig);
		$cell2->setCellPaddings(0.1, 0.1, 0.1, 0.1,0.1);
		$cell2->writeText("<strong>VIATICOS SIN HOSPEDAJE</strong>", new PHPRtfLite_Font(5, "Tahoma"), $titleFormat);
		
		for ($i = 3; $i<=8; $i++) {
			for($j = 1; $j<=5; $j++) {
				$cell = $tableInforme->getCell($i, $j);
				$cell->setBorder($borderConfig);
				$cell->setCellPaddings(0.1, 0.1, 0.1, 0.1,0.1);
				$cell->setFont($fontConfig);
			}
		}
		
		$tableConclusiones = $section->addTable();
		$tableConclusiones->addRow();
		$tableConclusiones->addRow();
		
		$tableConclusiones->addColumnsList(array (16));
		
		$cell = $tableConclusiones->getCell(1, 1);
		$cell->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell->setBackgroundColor("#ddd");
		$cell->setBorder($borderConfig);
		$cell->writeText("<strong>DOCUMENTOS ADJUNTOS - (Indique los documentos que adjunta)</strong>", $fontConfig, $titleFormat);
		
		$cell2 = $tableConclusiones->getCell(2, 1);
		$cell2->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell2->setBorder($borderConfig);
		
		$cell2->writeText("<Strong>1.</Strong>", $fontConfig, $contentFormat);
		$cell2->writeText("<Strong>2.</Strong>", $fontConfig, $contentFormat);
		//$cell2->writeText("_________________________________________________________________________________", $fontConfig, $contentFormat);
		//$cell2->writeText("_________________________________________________________________________________", $fontConfig, $contentFormat);
		
		
		
		$tableFirmas = $section->addTable();
		$tableFirmas->addRow();
		$tableFirmas->addRow();
		$tableFirmas->addColumnsList(array (8,8));
		
		
		$cell = $tableFirmas->getCell(1, 1);
		
		$cell->setBorder($borderConfig);
		$cell->setCellPaddings(0.1, 0.1, 0.1, 0.1, 0.1,0.1);
		$cell->writeText("", $fontConfig, $contentFormat);
		$cell->writeText("", $fontConfig, $contentFormat);
		$cell->writeText("<strong>__________________</strong>", new PHPRtfLite_Font(8, "Tahoma"), $titleFormat);
		$cell->writeText("<strong>SOLICITANTE</strong>", new PHPRtfLite_Font(8, "Tahoma"), $titleFormat);
		//$contentFormat1->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);
		$cell->writeText("".$this->remitente, new PHPRtfLite_Font(8, "Tahoma"), $titleFormat);
		
		
		$cell = $tableFirmas->getCell(1,2);
		
		$cell->setBorder($borderConfig);
		$cell->setCellPaddings(0.1, 0.1, 0.1, 0.1, 0.1,0.1);
		$cell->writeText("", $fontConfig, $contentFormat);
		$cell->writeText("", $fontConfig, $contentFormat);
		$cell->writeText("<strong>__________________</strong>", new PHPRtfLite_Font(8, "Tahoma"), $titleFormat);
		$cell->writeText("<strong>APROBADO</strong>", new PHPRtfLite_Font(8, "Tahoma"), $titleFormat);
		
		
		
		
		
		//$section->writeText("Atentamente, <br><br><br>", $fontConfig);
		$endConsultorParFormat = new PHPRtfLite_ParFormat();
		$endConsultorParFormat->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);
		//$section->writeText($this->remitente, $fontConfig, $endConsultorParFormat);
		//$section->writeText("<strong>".$this->cargo."</strong>", $fontConfig, $endConsultorParFormat);
		$this->rtf->save($this->filename);
	}
}

?>