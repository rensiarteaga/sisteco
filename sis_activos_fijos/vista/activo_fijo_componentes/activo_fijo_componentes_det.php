<?php
/**
* Nombre de archivo:	    activo_fijo_componentes.php
* Propósito:				Contenedor HTML de los objetos de la vista
* Fecha de Creación:		25-06-2007
*/
session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
<title>Componentes Activos Fijos</title>
   <script type="text/javascript" src="../../../sis_activos_fijos/vista/activo_fijo_componentes/js/activo_fijo_componentes_det.js"></script>	
   <script type="text/javascript" src="../../../sis_activos_fijos/vista/activo_fijo_componentes/js/activo_fijo_componentesCombo.js" ></script>	
   <script type="text/javascript" src="../../../sis_activos_fijos/vista/activo_fijo_componentes/js/activo_fijo_componentes_det_main.php?idContenedorPadre=<?php echo "$idContenedorPadre";?>&idContenedor=<?php echo "$idContenedor";?>&maestro_id_activo_fijo=<?php echo $maestro_id_activo_fijo;?>&maestro_codigo=<?php echo $maestro_codigo;?>&maestro_descripcion=<?php echo $maestro_descripcion;?>&maestro_id_sub_tipo_activo=<?php echo $maestro_id_sub_tipo_activo?>"></script>	
</head>
<body>
</body>
</html>