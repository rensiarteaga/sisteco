<?php
/**
* Nombre de archivo:	    balance_ss
* Propósito:				Contenedor HTML de los objetos de la vista
* Fecha de Creación:		2009-06-18 15:27:06
* Autor:					AVQ
*/
session_start();
?>
<!--<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01//EN' 'http://www.w3.org/TR/html4/strict.dtd'>-->
<html>
<head>

<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-15'>
<title>Reporte de Balance sumas  y saldos</title>
   
<script type='text/javascript' src='../../../sis_contabilidad/vista/balance_ss/js/balance_ss.js'></script>
<script type='text/javascript' src='../../../sis_contabilidad/vista/balance_ss/js/balance_ss_combo.js'></script>
<script type='text/javascript' src='../../../sis_contabilidad/vista/balance_ss/js/balance_ss_main.php?idContenedorPadre=<?php echo "$idContenedorPadre";?>&idContenedor=<?php echo "$idContenedor";?>&tipo_pres=<?php echo $m_tipo_pres;?>&id_parametro=<?php echo $m_id_parametro;?>&id_moneda=<?php echo $m_id_moneda;?>&gestion_pres=<?php echo $m_gestion_pres;?>&desc_pres=<?php echo $m_desc_pres;?>&desc_moneda=<?php echo $m_desc_moneda;?>&sw_vista=<?php echo $m_sw_vista;?>&desc_estado_gral=<?php echo $m_desc_estado_gral;?>'></script>	

 

 </head>
<body>
</body>
</html>