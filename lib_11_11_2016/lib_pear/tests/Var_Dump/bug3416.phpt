--TEST--
Bug #3416 : PHP5 Protected and private attributes not shown.
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
    public $bar1 = 'value1';
    protected $bar2 = 'value2';
    private $bar3 = 'value3';
}

echo $vd->toString(new foo());

?>
--EXPECTREGEX--
object\(foo\)(#[0-9]+ )?\(3\) {
  bar1 => string\(6\) value1
  bar2:protected => string\(6\) value2
  bar3:private => string\(6\) value3
}