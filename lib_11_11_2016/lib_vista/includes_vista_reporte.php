<?php
   $host  = $_SERVER['HTTP_HOST'];
			$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			$origen = "http://$host$uri";
			//echo "url: ".$origen."<br>";
?>  
 

 <link rel="stylesheet" type="text/css" href=" <?php echo $origen ?>/../../../../lib/ext-yui/resources/css/ext-all.css" />

<?php
//$_SESSION["ss_estilo_usuario"] ='';
//$_SESSION["ss_estilo_usuario"] = 'ytheme-aero.css';
//$_SESSION["ss_estilo_usuario"]='ytheme-galdaka.css';
//$_SESSION["ss_estilo_usuario"] = 'ytheme-vista.css';
//$_SESSION["ss_estilo_usuario"] = 'ytheme-gray.css';

if($_SESSION["ss_estilo_usuario"]!='' || $_SESSION["ss_estilo_usuario"]!='default')
{
echo("<link rel='stylesheet' type='text/css' href='".$origen."/../../../../lib/ext-yui/resources/css/".$_SESSION["ss_estilo_usuario"]."'/>");
}
?>



  
	<link rel="stylesheet" type="text/css" href="<?php echo $origen ?>/../../../../lib/ext-yui/examples/examples.css"/>
   <!-- LIBS -->     
   <script type="text/javascript" src="<?php echo $origen ?>/../../../../lib/ext-yui/adapter/yui/yui-utilities.js"></script>
   <script type="text/javascript" src="<?php echo $origen ?>/../../../../lib/ext-yui/adapter/yui/ext-yui-adapter.js"></script>
   <script type="text/javascript" src="<?php echo $origen ?>/../../../../lib/ext-yui/ext-all.js"></script>
   <script src="<?php echo $origen ?>/../../../../lib/ext-yui/build/locale/ext-lang-sp-min_lt.js" type="text/javascript"></script>
   