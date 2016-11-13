--TEST--
toString() : resource.
--FILE--
<?php

error_reporting(E_ALL);
require_once 'Var_Dump.php';
$vd = new Var_Dump(array('display_mode' => 'Text'));

if ($handler = opendir('/tmp/')) {
    echo $vd->toString($handler);
    closedir($handler);
}

?>
--EXPECTREGEX--
^resource\(stream\)\s[0-9]+$