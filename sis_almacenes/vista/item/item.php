<?php
/**
* Nombre de archivo:	    item.php
* Propósito:				Contenedor HTML de los objetos de la vista
* Fecha de Creación:		29-09-2007
*/
session_start();
?>

<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
<title>Item</title>
   <script type="text/javascript" src="../../../sis_almacenes/vista/item/js/item_combo.js"></script>
   <script type="text/javascript" src="../../../sis_almacenes/vista/item/js/item_main.php?idContenedor=<?php echo "$idContenedor";?>&registro=<?php if($registro!="") {echo "$registro"; }?>"></script>
</head>
<body>
</body>
</html>