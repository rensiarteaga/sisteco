--TEST--
toString() : float.
--FILE--
<?php

error_reporting(E_ALL);
require_once 'Var_Dump.php';
$vd = new Var_Dump(array('display_mode' => 'Text'));

echo
    $vd->toString(12.345678) . "\n" .
    $vd->toString(-12.345678) . "\n" .
    $vd->toString(2147483648) . "\n" .
    $vd->toString(-2147483648);

?>
--EXPECT--
float 12.345678
float -12.345678
float 2147483648
float -2147483648