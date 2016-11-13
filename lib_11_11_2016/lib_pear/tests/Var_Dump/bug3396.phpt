--TEST--
Bug #3396 : toString() sets object variables.
--SKIPIF--
<?php 
if (version_compare(PHP_VERSION, '4.9.9', '<=')) print 'PHP 5 required';
?>
--FILE--
<?php

error_reporting(E_ALL);
require_once 'Var_Dump.php';
$vd = new Var_Dump(array('display_mode' => 'Text'));

class foo {
    protected $bar = "value";
}

echo $vd->toString(new foo());

?>
--EXPECTREGEX--
object\(foo\)(#[0-9]+ )?\(1\) {
  bar:protected => string\(5\) value
}