<?php
// Test CVS

require_once 'Excel/reader.php';


// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();

$data->setOutputEncoding('CP1251');

$data->read('ana.xls');



error_reporting(E_ALL ^ E_NOTICE);

for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
	for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
		echo "\"".$data->sheets[0]['cells'][$i][$j]."\",";
	}
	echo "\n";

}


?>
