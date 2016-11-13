<?php
/**
* Nombre de archivo:	    Depreciacion.php
* Propósito:				Contenedor HTML de los objetos de la vista
* Fecha de Creación:		25-06-2007
*/
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">--> 
<meta http-equiv="Content-Type" content="text/html charset=iso-8859-15">
<!--<meta http-equiv="Content-Type" content="text/html; charset=utf8">-->
<title>Depreciacion</title>
<?php 
include_once('../../../../lib/lib_vista/includes_vista_reporte.php');
?>
   <script type="text/javascript" src="../../../../lib/js/lib.js"></script>
   <script type="text/javascript" src="../../../../lib/layout/LayoutProcesos.js"></script>
   <script type="text/javascript" src="../../../../lib/js/BaseParametrosReporte.js"></script>	
   <script type="text/javascript" src="js/rep_depreciacion_js.php"></script>	
   <script type="text/javascript" src="js/rep_depreciacion_combo.js" ></script>	
</head>
<body>
 
 <div id="content">
	   <div id ="container"></div>
    	<!--fin container -->
    
  	   <div id ="container_formulario" class="ylayout-inactive-content"  >

  	        <div id="formulario"></div>
   <!-- <div class="x-box-tl"><div class="x-box-tr"><div class="x-box-tc"></div></div></div>
    <div class="x-box-ml"><div class="x-box-mr"><div class="x-box-mc">
        <h3 style="margin-bottom:5px;">Multi-column, nesting and fieldsets</h3>
        <div id="formulario"></div>
      
    </div></div></div>
    <div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>-->
       </div>	 

    	      <!-- fin del filtro> -->
  </div><!-- fin content -->

</body>
</html>