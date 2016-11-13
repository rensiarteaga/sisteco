<?php
/**
* Nombre de archivo:	    documentos_respaldo.php
* Propósito:				Contenedor HTML de los objetos de la vista
* Fecha de Creación:		18/05/2009 11:26:38
* Autor:					AVQ
**/
session_start();
?>
<!--<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01//EN' 'http://www.w3.org/TR/html4/strict.dtd'>-->
<html>
<head>

<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-15'>
<title>sis_contabilidad comprobante</title>
   <script type='text/javascript' src='../../../sis_contabilidad/vista/registro_comprobante/js/documentos_respaldo_combo.js'></script>
   <script type='text/javascript' src='../../../sis_contabilidad/vista/registro_comprobante/js/documentos_respaldo.js'></script>
   <script type='text/javascript' src='../../../sis_contabilidad/vista/registro_comprobante/js/documentos_respaldo_main.php?idContenedor=<?php echo "$idContenedor";?>&m_id_moneda=1&m_id_comprobante=<?php echo $m_id_comprobante;?>&m_acreedor=<?php echo $m_acreedor;?>&m_pedido=<?php echo $m_pedido;?>&m_concepto_cbte=<?php echo $m_concepto_cbte;?>&m_conformidad=<?php echo $m_conformidad;?>&m_aprobacion=<?php echo $m_aprobacion;?>&m_simbolo_moneda=<?php echo $m_simbolo_moneda;?>'></script>
</head>
<body>
</body>
</html>