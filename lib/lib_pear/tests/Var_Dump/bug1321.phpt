--TEST--
Bug #1321 : Numeric zero values are not shown.
--FILE--
<?php

error_reporting(E_ALL);
require_once 'Var_Dump.php';
$vd = new Var_Dump(array('display_mode' => 'Text'));

class zero {
    public $i = 0;
    public $f = 0.0;
}

echo
    $vd->toString(new zero()) . "\n" .
    $vd->toString(array(0, 0.0));

?>
--EXPECTREGEX--
object\(zero\)(#[0-9]+ )?\(2\) {
  i => int 0
  f => float 0
}
array\(2\) {
  0 => int 0
  1 => float 0
}