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
		
		
		$fontConfig = new PHPRtfLite_Font(10, "Tahoma");
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
		
		$cell2->writeText("FECHA INICIO VIAJE: ____/____/_____<TAB>FECHA RETORNO VIAJE: ____/____/_____", $fontConfig, $contentFormat);
		$cell2->writeText("TIPO DE TRANSPORTE:   AEREO ______    TERRESTRE: ______    FLUVIAL: ______", $fontConfig, $contentFormat);
		$cell2->writeText("LUGAR (ES) DESTINO: ______________________________________________________________", $fontConfig, $contentFormat);
		$cell2->writeText("__________________________________________________________________________________", $fontConfig, $contentFormat);
		$cell2->writeText("DIAS DE VIAJE: _____________      CUENTA CON FONDO EN AVANCE    SI _____ NO _____", $fontConfig, $contentFormat);
		$cell2->writeText("RECONOCIMIENTO DEL VIÁTICO: (marcar con una X el que corresponda)", $fontConfig, $contentFormat);
		$cell2->writeText("VIATICOS CON HOSPEDAJE: ____________   VIATICOS SIN HOSPEDAJE: ____________", $fontConfig, $contentFormat);
		
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
		
		$cell2->writeText("__________________________________________________________________________________", $fontConfig, $contentFormat);
		$cell2->writeText("__________________________________________________________________________________", $fontConfig, $contentFormat);
		$cell2->writeText("__________________________________________________________________________________", $fontConfig, $contentFormat);
		$cell2->writeText("__________________________________________________________________________________", $fontConfig, $contentFormat);
		
		
		$tableCambioItinerario = $section->addTable();
		$tableCambioItinerario->addRow();
		$tableCambioItinerario->addRow();
		$tableCambioItinerario->addColumnsList(array (16));
		
		$cell = $tableCambioItinerario->getCell(1, 1);
		$cell->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell->setBackgroundColor("#ddd");
		$cell->setBorder($borderConfig);
		$cell->writeText("<strong>CAMBIO DE ITINERARIO</strong>", $fontConfig, $titleFormat);
		
		$cell2 = $tableCambioItinerario->getCell(2, 1);
		$cell2->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell2->setBorder($borderConfig);
		
		$cell2->writeText("FECHA (S) DE CAMBIO: ______________________    DIAS DE CAMBIO: ___________________", $fontConfig, $contentFormat);
		$cell2->writeText("MOTIVO DEL CAMBIO: ______________________________________________________________", $fontConfig, $contentFormat);
		$cell2->writeText("AUTORIZADO POR: _________________________________________________________________", $fontConfig, $contentFormat);
		$cell2->writeText("MOTIVO DE LAS PENALIDADES: (marcar con una X el que corresponda)", $fontConfig, $contentFormat);
		$cell2->writeText("CAMBIO DE HORA: ________  CAMBIO DE FECHA: __________  CAMBIO DE NOMBRE: _________", $fontConfig, $contentFormat);
		
		
		$tableInforme = $section->addTable();
		$tableInforme->addColumnsList(array (2.5,2.5,6,5));
		$tableInforme->addRow();
		$tableInforme->addRow();
		$tableInforme->addRow(1);
		$tableInforme->addRow(1);
		$tableInforme->addRow(1);
		$tableInforme->addRow(1);
		$tableInforme->addRow(1);
		$tableInforme->addRow(1);
		
		$tableInforme->mergeCellRange(1, 1, 1, 4);
		
		$cell = $tableInforme->getCell(1, 1);
		$cell->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell->setBackgroundColor("#ddd");
		$cell->setBorder($borderConfig);
		$cell->writeText("<strong>INFORME DE ACTIVIDADES</strong>", $fontConfig, $titleFormat);
		
		$cell2 = $tableInforme->getCell(2, 1);
		$cell2->setBackgroundColor("#ddd");
		$cell2->setBorder($borderConfig);
		$cell2->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell2->writeText("<strong>FECHA</strong>", $fontConfig, $titleFormat);
		
		$cell2 = $tableInforme->getCell(2, 2);
		$cell2->setBackgroundColor("#ddd");
		$cell2->setBorder($borderConfig);
		$cell2->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell2->writeText("<strong>LUGAR</strong>", $fontConfig, $titleFormat);
		
		$cell2 = $tableInforme->getCell(2, 3);
		$cell2->setBackgroundColor("#ddd");
		$cell2->setBorder($borderConfig);
		$cell2->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell2->writeText("<strong>ACTIVIDADES DESARROLLADAS</strong>", $fontConfig, $titleFormat);
		
		$cell2 = $tableInforme->getCell(2, 4);
		$cell2->setBackgroundColor("#ddd");
		$cell2->setBorder($borderConfig);
		$cell2->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell2->writeText("<strong>RESULTADOS OBTENIDOS</strong>", $fontConfig, $titleFormat);
		
		for ($i = 3; $i<=8; $i++) {
			for($j = 1; $j<=4; $j++) {
				$cell = $tableInforme->getCell($i, $j);
				$cell->setBorder($borderConfig);
				$cell->setCellPaddings(0.1, 0.1, 0.1, 0.1);
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
		$cell->writeText("<strong>CONCLUSIONES</strong>", $fontConfig, $titleFormat);
		
		$cell2 = $tableConclusiones->getCell(2, 1);
		$cell2->setCellPaddings(0.1, 0.1, 0.1, 0.1);
		$cell2->setBorder($borderConfig);
		
		$cell2->writeText("OBJETIVO CUMPLIDO:                SI: ______   NO: ______", $fontConfig, $contentFormat);
		$cell2->writeText("Explicar la evidencia del cumplimiento: _________________________________________________", $fontConfig, $contentFormat);
		$cell2->writeText("_________________________________________________________________________________", $fontConfig, $contentFormat);
		$cell2->writeText("_________________________________________________________________________________", $fontConfig, $contentFormat);
		
		$section->writeText("Atentamente, <br><br><br>", $fontConfig);
		$endConsultorParFormat = new PHPRtfLite_ParFormat();
		$endConsultorParFormat->setTextAlignment(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);
		$section->writeText($this->remitente, $fontConfig, $endConsultorParFormat);
		$section->writeText("<strong>".$this->cargo."</strong>", $fontConfig, $endConsultorParFormat);
		$this->rtf->save($this->filename);
	}
}

?>