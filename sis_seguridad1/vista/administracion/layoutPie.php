<?php session_start();
$estilo=$_SESSION["ss_estilo_usuario"];
?>
<div class="x-layout-panel-hd"><table width="100%"><tr><td><?php echo "Usuario: ".$_SESSION["ss_nombre_usuario"];?></td><td><?php echo "Base de Datos: ".$_SESSION["ss_nombre_basedatos"];?></td><td><?php echo "Lugar: ".$_SESSION["ss_nombre_lugar"];?></td></tr></table><div>