--TEST--
toString() : array.
--FILE--
<?php

error_reporting(E_ALL);
require_once 'Var_Dump.php';
$vd = new Var_Dump(array('display_mode' => 'Text'));

$linkedArray = array(TRUE, 123, 123.45);
$array = array(
    'key1' => 'The quick brown' . "\n" . 'fox jumped over' . "\n" . 'the lazy dog',
    'key2' => & $linkedArray,
    'key3' => NULL
);

echo $vd->toString($array);

?>
--EXPECT--
array(3) {
  key1 => string(44) The quick brown
                     fox jumped over
                     the lazy dog
  key2 => &array(3) {
    0 => bool true
    1 => int 123
    2 => float 123.45
  }
  key3 => NULL
}