<?php
//Enzo>: comentado para evitar que el archivo de session se cree en esta pagina.Para  hacer que se cree 
//solo una vez que un usuario se autentique.
//session_start();
?>

<html> 
<head> 
<title>LECTURA DE MARCAS</title> 
<link rel="stylesheet" type="text/css" href="resources/docs.css"></link>
	<link rel="shortcut icon" href="lib/images/favicon.ico" />
	<link rel="icon" href="lib/images/favicon.ico" />
    <style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
.Estilo3 {color: #FFFFFF; font-weight: bold; }
.Estilo6 {color: #000000}

.ima {
       border-top-style:none;
       border-right-style:none;
       border-bottom-style:none;
       border-left-style:none;
      }
-->
    </style>
</head> 
<body style="background:url(../../../lib/images/fondo_blanco.jpg) no-repeat;"> 

<table align="center">
<tr>
<td><H2>LECTURA DE MARCAS</H2></td>
</tr>
<tr>
<td>	
<form action="../../../sis_control_asistencia/control/carga/ActionGuardarArchivo.php" method="post" enctype="multipart/form-data" name="form1">
  <p align="center">Archivo:
   <input name="txt_archivo" type="file" id="archivo">
  </p>
  <p align="center"><input name="boton" type="submit" id="boton" value="Cargar Archivo"></p>
  
</form>
</td>

</tr>
<tr>
<td>
<?php
if($boton) {
    if (is_uploaded_file($HTTP_POST_FILES['archivo']['tmp_name'])) {
      copy($HTTP_POST_FILES['archivo']['tmp_name'], $HTTP_POST_FILES['archivo']['name']);
      $subio = true;
    }

if($subio) {
    echo "El archivo se subio con exito";
   
} else {
    echo "El archivo no cumple con las reglas establecidas";
}
die();
}
?>
</td>
</tr>
</table>
</body>
</html>


