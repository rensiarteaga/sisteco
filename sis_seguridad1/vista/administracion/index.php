<?php
//Enzo>: comentado para evitar que el archivo de session se cree en esta pagina.Para  hacer que se cree 
//solo una vez que un usuario se autentique.
session_start();
?>
<html> 
<head> 
<title>ENDESIS</title> 	
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
	<title>Sistema Integrado ENDESIS</title>
	<link rel="stylesheet" type="text/css" href="resources/docs.css"></link>
	<link rel="shortcut icon" href="../../../lib/images/favicon.ico" />
	<link rel="icon" href="../../../lib/images/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="../../../lib/ext-yui/resources/css/ext-all.css" />
	<link  id="theme" rel='stylesheet' type="text/css" href="../../../lib/ext-yui/resources/css/xtheme-aero.css"/>
	
	<link rel="stylesheet" type="text/css" href="../../../lib/ext-yui/examples/examples.css"/>
	<link rel="stylesheet" type="text/css" href="../../../lib/css/combos.css"/>
   <!-- LIBS    -->
<script type="text/javascript" src="../../../lib/ext-yui/adapter/ext/ext-base.js"></script>
<script type="text/javascript" charset="ISO-8859-1" src="../../../lib/ext-yui/ext-all.js"></script>
<script type="text/javascript" src="../../../lib/ext-yui/build/locale/ext-lang-sp-min_lt.js" type="text/javascript"></script>
<script type="text/javascript" src="../../../lib/js/lib.js"></script>
<script type="text/javascript" src="resources/md5.js"></script>
<script type="text/javascript" src="../../../lib/js/base64.js"></script>
<script type="text/javascript" src="resources/docs8.js"></script>
<script src="../../../lib/joint/raphael.js" type="text/javascript"></script> 
<script src="../../../lib/joint/joint.js" type="text/javascript"></script> 
<script src="../../../lib/joint/joint.dia.js" type="text/javascript"></script> 
<script src="../../../lib/joint/joint.dia.fsa.js" type="text/javascript"></script> 


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
.pngTransp{
   width:55px;
   height:55px;
   position:absolute;
   margin-left:70%;
   margin-top:8%;
   background:url(images/logo_gti.png) no-repeat center center;
   _background:none!important;
   filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/logo_gti.png',sizingMethod='scale');
	}
.divPos{
   position:absolute;
   margin-left:70%;
   margin-top:8%;
	}
</style>
</head>
<body scroll="no" id="docs" style="background:url(../../../lib/images/fondo_fer.jpg) no-repeat top center">
	
			<div id="auxiliar"></div>
   			<div id="Estado" class="x-layout-panel-hd"></div>
   			<div id="loginDlg" style="visibility:hidden;position:absolute;top:0px;">
   					<div class="x-dlg-hd">ENDESIS</div>
	            	<div class="x-dlg-bd">
	            		<div id="loginImg" class="pngTransp"></div>
						<p>&nbsp;</p>
	            		<div id="myForm" style="margin-top:5%; width:98%;"></div>
	            	</div>
	        </div>
	
</body>
</html>