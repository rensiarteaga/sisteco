--TEST--
toString() : null.
--FILE--
<?php

error_reporting(E_ALL);
require_once 'Var_Dump.php';
$vd = new Var_Dump(array('display_mode' => 'Text'));

echo $vd->toString(NULL);

?>
--EXPECT--
NULL