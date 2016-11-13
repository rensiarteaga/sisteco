--TEST--
Renderer : Text.
--FILE--
<?php

error_reporting(E_ALL);
require_once 'Var_Dump.php';

$linkedArray = array(TRUE, 123, 123.45);
$array = array(
    'key1' => 'The quick brown' . "\n" . 'fox jumped over' . "\n" . 'the lazy dog',
    'key2' => & $linkedArray,
    'key3' => NULL
);

Var_Dump::displayInit(
    array('display_mode' => 'Text'),
    array(
        'show_eol'       => ' *',
        'offset'         => 3,
        'opening'        => '(',
        'closing'        => ')',
        'operator'       => ' -> ',
        'before_num_key' => '\'',
        'after_num_key'  => '\'',
        'before_str_key' => '"',
        'after_str_key'  => '"',
        'before_type'    => '[',
        'after_type'     => ']'
    )
);

Var_Dump::display($array);

?>
--EXPECT--
array(3) (
   "key1" -> [string(44)] The quick brown *
                          fox jumped over *
                          the lazy dog
   "key2" -> &array(3) (
      '0' -> [bool] true
      '1' -> [int] 123
      '2' -> [float] 123.45
   )
   "key3" -> [NULL]
)