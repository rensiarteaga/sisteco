--TEST--
Text renderer : Wide mode.
--FILE--
<?php

error_reporting(E_ALL);
require_once 'Var_Dump.php';

$linkedArray = array(0 => 'John', 11 => 'Jack', 127 => 'Bill');
$array = array(
    'key-1' => 'The quick brown fox jumped over the lazy dog',
    'key-2' => array(
        'long-key' => & $linkedArray,
        'file' => NULL
    ),
    'long-key-3' => 234,
);

Var_Dump::displayInit(
    array('display_mode' => 'Text'),
    array('mode' => 'wide')
);
Var_Dump::display($array);

?>
--EXPECT--
array(3) {
  key-1      => string(44) The quick brown fox jumped over the lazy dog
  key-2      => array(2) {
                  long-key => &array(3) {
                                0   => string(4) John
                                11  => string(4) Jack
                                127 => string(4) Bill
                              }
                  file     => NULL
                }
  long-key-3 => int 234
}