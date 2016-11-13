<?php
 /**
 * Nombre clase:	cls_manejo_arbol.php
 * Propósito:		intermediario para el manejo del api de agata
 * Autor:			Rensi Arteaga
 * Fecha creación:	11-07-2007
 *
 */
session_start();
// Include the AgataAPI class
include_once (dirname(__FILE__).'/../agata/classes/core/AgataAPI.class');
// Class: FreeMED.Agata7
//
//	Wrapper for Agata Reports 7.x (official version)
//
class cls_manejo_reportes {

	// Constructor: Agata7
	function cls_manejo_reportes ( ) {
		$this->api = new AgataAPI();
		// Set defaults
		$this->api->setLanguage('es'); // lenguaje espeñol
	}

	// Method: CreateReport
	//
	//	Create a report and store the information in this object.
	//
	// Parameters:
	//
	//	$format - Rendering engine used to create the output.
	//	Valid values are: Pdf, Ps, Html, etc
	//
	//	$report - Name of the report file used to create this
	//	report.
	//
	//	$parameters - (optional) Additional qualifiers as an
	//	associative array.
	//
	// Returns:
	//
	//	Boolean, successful
	//
	function CreateReport ( $format, $report, $parameters = NULL ) {
		
		$this->api->setReportPath($report);
		$this->api->setProject('endesis');//project

		$this->api->setOutputPath($output);
		$this->api->setFormat(strtolower($format));
		if (strtolower($format) == 'pdf') { $this->api->setLayout('default-PDF'); }
		
		//parametros por defecto que se le pasan al reporte
		$this->api->setParameter('$login_usuario', ' '.$_SESSION["ss_nombre_usuario"]); //nombre usuario
		$this->api->setParameter('$id_usuario', $_SESSION["ss_id_usuario"]); //nombre usuario
		//parametros enviados por el ActionRpt
		if (is_array($parameters)) {
			foreach ($parameters AS $k => $v) {
				$this->api->setParameter($k, $v);
			}
		}

		$report = $this->api->getReport();
		
		$merge = $this->DetermineMergedFormat ( $report );

		if (!$merge) {
			$ok = $this->api->generateReport ( );
		} else {
			$ok = $this->api->generateDocument ( );
			//$ok = $this->api->generateReport ( );
			
		}
	} // end method CreateReport


	// Method: DetermineMergedFormat
	//
	//	Figure out if a report is supposed to be an Agata "Merge"
	//	report or not
	//
	// Parameters:
	//
	//	$report - Array, passed by reference, which contains the
	//	representation of a report's XML format.
	//
	// Returns:
	//
	//	Boolean, true if merged report, false if not.
	//
	function DetermineMergedFormat ( &$report ) {
		if (strlen($report['Report']['Merge']['ReportHeader']) > 10) {
			return true;
		} else {
			return false;
		}
	} // end method DetermineMergedFormat

	// Method: ReportToFile
	//
	//	Moves a completed report to a specified filename.
	//
	// Parameters:
	//
	//	$filename - Target file name
	//
	// Returns:
	//
	//	Boolean, if successful
	//
	function ReportToFile ( $filename ) {
		if (!$this->report_file) { return false; }
		$fp = fopen ( $filename, 'w' );
		if (!$fp) { return $fp; }
		fwrite($fp, $this->report_file);
		fclose($fp);
		return true;
	} // end method ReportToFile


	// Method: _ReadMetaInformation
	//
	//	Get report meta-information
	//
	// Returns:
	//
	//	Array containing an associative array containing the
	//	meta-information.
	//
	function _ReadMetaInformation ( $report ) {
                // Get meta-information from the report
                $this->api->setReportPath($report);
                $report = $this->api->getReport();

		return $report['Report']['Properties'];
	} // end method _ReadMetaInformation
} // end class Agata
?>