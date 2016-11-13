<?php
/**
* Nombre de archivo:	    ActivoFijo.php
* Propósito:				Contenedor HTML de los objetos de la vista
* Autor:					Rensi Arteaga Copari
* Fecha de Creación:		25-06-2007
*/
session_start();
?>


<!--<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">-->
<html>
<head>
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">-->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">

<title>Activos Fijos</title>




<link rel="stylesheet" type="text/css" href="../../../lib/ext/resources/css/ext-all.css" />

<?php
//$_SESSION["ss_estilo_usuario"] ='';
//$_SESSION["ss_estilo_usuario"] = 'ytheme-aero.css';
//$_SESSION["ss_estilo_usuario"]='ytheme-galdaka.css';
//$_SESSION["ss_estilo_usuario"] = 'ytheme-vista.css';
$_SESSION["ss_estilo_usuario"] = 'xtheme-gray.css';

if($_SESSION["ss_estilo_usuario"]!='' || $_SESSION["ss_estilo_usuario"]!='default')
{
echo("<link rel='stylesheet' type='text/css' href='../../../lib/ext/resources/css/".$_SESSION["ss_estilo_usuario"]."'/>");
//echo("<link rel='stylesheet' type='text/css' href='".$origen."/../../../lib/ext-yui/resources/css/ytheme-aero.css"."'/>");

}
?>



  
	<link rel="stylesheet" type="text/css" href="../../../lib/ext/examples/examples.css"/>
   <!-- LIBS -->     
   <script type="text/javascript" src="../../../lib/ext/adapter/ext/ext-base.js"></script>
   <script type="text/javascript" src="../../../lib/ext/ext-all.js"></script>
   <script type="text/javascript" src="../../../lib/ext/build/locale/ext-lang-sp-min_lt.js" type="text/javascript"></script>
   
   
   
   <script type="text/javascript" src="../../../lib/js/lib.js"></script>
   <script type="text/javascript"  src="../../../lib/layout/LayoutMaestroDetalle.js"></script>
   <script type="text/javascript" src="../../../lib/js/libLovV4.js"></script>
      <script type="text/javascript" src="../../../lib/js/libFiltroExtructura.js"></script>
   <script type="text/javascript" src="../../../lib/js/Funciones7.js"></script>	
   <script type="text/javascript" src="js/activo_fijo_js2.php"></script>	
   <script type="text/javascript" src="js/activo_fijoCombo.js" ></script>	
   
       
    
   
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
}
  </style>  
</head>
<body>
 


   <!-- para armar el data combo -->
   
   	  <!--Basic dialog-->
   
   		 <div id="dlgInfo" style="visibility:hidden;position:absolute;top:0px;">
			  <div class="x-dlg-hd">Activos Fijos</div>
          		<div class="x-dlg-bd">
          			<!--formulario-->
          			<div id="form-ct2_dlgInfo">
	        		</div>
        		</div>
         	</div>
		</div> 
		
		<div id="dlgInfo_ep" style="visibility:hidden;position:absolute;top:0px;">
			  <div class="x-dlg-hd">Estructura Programática</div>
          		<div class="x-dlg-bd">
          			<!--formulario-->
          			<div id="form-ct2_dlgInfo_ep">
	        		</div>
        		</div>
         	</div>
		</div> 
	
<!-- fin dialog-->
    
<div id="content_ep">
	 <div id="content">
		   <div id ="container"></div>
	    	<!--fin container -->
	        	<!--GRID-->
	    		<div id="ext-grid"></div>
	    		<!-- FIN GRID-->
	    		<!--filtro-->
	    		 <div id="filtro" class="ylayout-panel-south">
	          			<div class="x-form-clear"></div>
				</div>
	            <!-- fin del filtro> -->
	            
	           
	   </div><!-- fin content -->
	    <div id="ext-grid_ep"></div>
   </div><!-- fin content_ep -->
</body>
</html>