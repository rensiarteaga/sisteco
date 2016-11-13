<?php
/**
* Nombre de archivo:	    supergrupo.php
* Propósito:				Contenedor HTML de los objetos de la vista
* Autor:                    Susana Castro Guaman
* Fecha de Creación:		20-09-2007
*/
session_start();
?>
<!--<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">-->
<html>
<head>
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">-->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
<title>Super Grupo</title>
   <script type="text/javascript" src="../../../sis_almacenes/vista/supergrupo/js/supergrupo.js"></script>
   <script type="text/javascript" src="../../../sis_almacenes/vista/supergrupo/js/supergrupoCombo.js"></script>
   <script type="text/javascript" src="../../../sis_almacenes/vista/supergrupo/js/supergrupo_main.php?idContenedor=<?php echo "$idContenedor";?>&registro=<?php if($registro!="") {echo "$registro"; }?>"></script>
</head>
<body>
</body>
</html>