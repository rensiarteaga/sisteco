<?php
session_start();
unset($_SESSION['verif_exist_uc']);
$_SESSION['verif_exist_uc']=array();
echo json_encode($_SESSION['verif_exist_uc']);
?>