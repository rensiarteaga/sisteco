--TEST--
Ignore list.
--FILE--
<?php

error_reporting(E_ALL);
require_once 'Var_Dump.php';
$vd = new Var_Dump(array('display_mode' => 'Text', 'ignore_list'=>array('object')));

class object {
    public $key1 = 'foo';
    public $key2 = 'bar';
}

$a = array(
    0 => "The quick brown\nfox jumped over\nthe lazy dog",
    1 => new object(),
    2 => array(TRUE, 123, 123.45)
);

echo $vd->toString($a);

?>
--EXPECT--
array(3) {
  0 => string(44) The quick brown
                  fox jumped over
                  the lazy dog
  1 => object(object) Not parsed.
  2 => array(3) {
    0 => bool true
    1 => int 123
    2 => float 123.45
  }
}