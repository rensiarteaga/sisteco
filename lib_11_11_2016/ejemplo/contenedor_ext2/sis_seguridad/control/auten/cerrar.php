<?php 
session_start() ;
session_unset();
session_destroy(); // destruyo la sesión 
header("Location: ../../../index.php"); 

/*
Para hacer una redirección 301 (permanente), utilizaremos un código PHP como este:

header("HTTP/1.1 301 Moved Permanently");
header("Location: nueva_pagina.html");

Para hacer una redirección 302 con PHP (temporal) el código sería así:

header("HTTP/1.1 302 Moved Temporarily");
header("Location: nueva_pagina.html"); 
*/
//header("Location: http://192.168.0.8/endesis/index.php"); 
exit;
?>