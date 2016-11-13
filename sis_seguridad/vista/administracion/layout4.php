<?php
/**
* Nombre de archivo:	    layoutphp
* Propósito:				Contenedor principal de todos los sistemas
* Autor:					Rensi Arteaga Copari
* Fecha de Creación:		25-06-2007
*/
session_start();
?>
<!--<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">-->
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
	<title>Sistema Integrado ENDESIS</title>
	<link rel="stylesheet" type="text/css" href="resources/docs.css"></link>
	<link rel="shortcut icon" href="../../../lib/images/favicon.ico" />
	<link rel="icon" href="../../../lib/images/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="../../../lib/ext-yui/resources/css/ext-all.css" />
	<link rel='stylesheet' type="text/css" href="../../../lib/ext-yui/resources/css/<?php echo $_SESSION["ss_estilo_usuario"];?>"/>
	<link rel="stylesheet" type="text/css" href="../../../lib/ext-yui/examples/examples.css"/>
   <!-- LIBS    -->
<script type="text/javascript" src="../../../lib/ext-yui/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="../../../lib/ext-yui/ext-all.js"></script>
<script type="text/javascript" src="../../../lib/ext-yui/build/locale/ext-lang-sp-min_lt.js" type="text/javascript"></script>
<script type="text/javascript" src="../../../lib/js/lib.js"></script>
<script type="text/javascript" src="resources/docs4.js"></script>
<script type="text/javascript"  src="../../../lib/layout/LayoutMaestro.js"></script>
<script type="text/javascript"  src="../../../lib/layout/LayoutMaestroEP.js"></script>
<script type="text/javascript"  src="../../../lib/layout/LayoutMaestroDetalle3.js"></script>
<script type="text/javascript"  src="../../../lib/layout/LayoutDetalle.js"></script>
<script type="text/javascript"  src="../../../lib/layout/LayoutProcesos.js"></script>
<script type="text/javascript" src="../../../lib/js/BaseParametrosReporte.js"></script>
<script type="text/javascript" src="../../../lib/js/Funciones7.js"></script>	
<script type="text/javascript" src="../../../lib/js/libLovV4.js"></script>
<script type="text/javascript" src="../../../lib/js/libFiltroEstructura.js"></script>
  <style type="text/css">
	body {font:normal 9pt verdana; margin:0;padding:0;border:0px none;overflow:hidden;}
	#header{
	  
	    border-bottom: 1px solid #083772;
	    padding:5px 4px;
	}
	#footer{
	   
	    border-top: 1px solid #083772;
	    padding:2px 4px;
	    color:white;
	    font:normal 8pt arial,helvetica;
    }
	
	#content p {
	    margin:5px;
	}

    .x-layout-panel-north, .x-layout-panel-south, #content .x-layout-panel-center{
        border:0px none;
    }
    #content .x-layout-panel-south{
        border-top:1px solid #aca899;
    }
    #content .x-layout-panel-center{
        border-bottom:1px solid #aca899;
    }
    .ylayout-panel-south  {
	BORDER-RIGHT: 0px; BORDER-TOP: 0px; BORDER-LEFT: 0px; BORDER-BOTTOM: 0px; BACKGROUND-COLOR: #c3daf9
}

    #Layer1 {
	position:absolute;
	width:200px;
	height:115px;
	z-index:1;
}
    
     .x-layout-collapsed-west{
   background-image: url(../../../lib/images/menu.gif);
   background-repeat:no-repeat;
   background-position:center;
}

.x-layout-collapsed-east{
   background-image: url(../../../lib/images/ayuda.gif);
   background-repeat:no-repeat;
   background-position:center;
}</style> 
</head>
<body scroll="no" id="docs"><div id="loading"><div class="loading-indicator">Cargando...</div></div>
	<div id="header" class="ylayout-inactive-content">	
		<!-- logotipo -->
	<img src="../../../lib/images/cabecera_p2_cor.jpg" style="float:right;margin-right:0px;"/>
	<img src="../../../lib/images/cabecera_p1_cor.jpg" style="float: left; margin-left:0px;"/>
	</div>
	<div id="auxiliar"></div>
	<div id="classes" class="ylayout-inactive-content">
	<?php require "../../control/menu/ActionListaPermiso.php"; ?>       
	</div>

	<iframe id="main" id="main" frameborder="no"></iframe>
	<div id="Estado" class="x-layout-panel-hd"> 
			<table width="100%">
			<tr><td>
			 		<?php echo "Usuario: ".$_SESSION["ss_nombre_usuario"];?>
			 	</td>
			 	<td>
			 		<?php echo "Base de Datos: ".$_SESSION["ss_nombre_basedatos"];?>
			 	</td>
			 		<td>
			 		<?php echo "Lugar: ".$_SESSION["ss_nombre_lugar"];?>
			 	</td>
			</tr>
		</table>		
	</div>	
</body>
</html>