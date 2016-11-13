--TEST--
toString() : object.
--FILE--
<?php

error_reporting(E_ALL);
require_once 'Var_Dump.php';
$vd = new Var_Dump(array('display_mode' => 'Text'));

class object {
    public $key1 = "The quick brown\nfox jumped over\nthe lazy dog";
    public $key2 = array(TRUE, 123, 123.45);
    public $key3 = NULL;
}

echo $vd->toString(new object());

?>
--EXPECTREGEX--
object\(object\)(#[0-9]+ )?\(3\) {
  key1 => string\(44\) The quick brown
                     fox jumped over
                     the lazy dog
  key2 => array\(3\) {
    0 => bool true
    1 => int 123
    2 => float 123.45
  }
  key3 => NULL
}