<?php
session_start();

include_once("../../control/LibModeloPresupuesto.php");
header('Content-type: application/download');
header('Content-Disposition: inline; filename=ejecucion_ins.dat');

$presupuestos=$_SESSION['PDF_ejecucion_institucional_presupuesto'];
$Custom = new cls_CustomDBPresupuesto();
$mes=substr( $_SESSION['PDF_fecha_ini'],3,2);

foreach ($presupuestos as $data){
	
	$res = $Custom->ListarEjecucionInstitucional(0,0,'codigo_partida','asc','0=0 ',"'(".$_SESSION['PDF_tipo_pres'].")'",$_SESSION['PDF_id_parametro'],$_SESSION['PDF_id_moneda'],$_SESSION['PDF_fecha_hasta'],$_SESSION['PDF_fecha_desde'],$data['id_presupuesto']);
	$datos=$Custom->salida;
	foreach ($datos as $d)
	{
		
		echo $data['gestion_pres']."|".
		$data['codigo_ent']."|".
		$mes."|".
		$data['cod_prg']."|".
		$data['cod_proy']."|".
		$data['cod_act']."|".
		$data['codigo_fuente']."|".
		$data['cod_fin']."|".
		$d['codigo_partida']."|".
		$d['cod_trans']."|".
		$d['presupuestado']."|".
		$d['presupuesto_vigente']."|".
		$d['compromiso']."|".
		$d['devengado']."|".
		$d['pagado']."\n"; 
	}
	
	
}


	
	
?>


