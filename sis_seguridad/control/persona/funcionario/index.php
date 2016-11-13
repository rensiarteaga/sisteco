<?php 
/* Redireccionar a una pagina diferente en el directorio actual de la peticion */
$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
header("Location: http://$host");
exit;
?>