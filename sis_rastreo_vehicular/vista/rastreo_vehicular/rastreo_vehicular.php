<?php
/**
* Nombre de archivo:	    Rastreo Satelital
* Prop�sito:				Contenedor HTML de los objetos de la vista
* Fecha de Creaci�n:		24-11-2014
* Autor:					UNNKNOW
*/
session_start();
?>
<!--<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01//EN' 'http://www.w3.org/TR/html4/strict.dtd'>-->
<html>
<head>

<!-- <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-15'> -->

<title>Rastreo Vehicular</title> 

<script language="JavaScript"> document.rastreo.submit();</script> 
<script>
function cargarPestania() 
{
	window.open("http://dev-rastreo.ende.bo");
}
</script> 

</head>
					
<body>
<!-- 			 <a id="help-forums" href="http://extjs.com/forum/">Help Forums</a> -->
			<table  width="100%" >
			<tr height="150"></tr>
			<tr>
				<td></td>
				<td align="center" height="250" width="200"> 
						<img src="../../../sis_rastreo_vehicular/imagenes/RadarDetenido.png" 
						onmouseover="this.src='../../../sis_rastreo_vehicular/imagenes/RadarMovimiento.gif'"
						onmouseout="this.src='../../../sis_rastreo_vehicular/imagenes/RadarDetenido.png'"	
						id="logo" title="Click para Ingresar al Sistema de Rastreo Satelital" 
						onclick="cargarPestania()"/> 
				</td>
				<td></td>	
			</tr>	
			<tr height="150"></tr>
			</table>
				
			<FORM NAME="rastreo" METHOD="POST"  ACTION="http://dev-rastreo.ende.bo" target="_blank">
			<INPUT TYPE=HIDDEN NAME="session" VALUE="<?php echo base64_encode(serialize(array("ss_nombre_usuario"=>$_SESSION["ss_nombre_usuario"], "ss_id_empleado" => $_SESSION["ss_id_empleado"])));?>">
			</FORM>
				 
</body>

</html> 