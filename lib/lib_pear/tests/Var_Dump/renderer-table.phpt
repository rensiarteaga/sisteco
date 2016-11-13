--TEST--
Renderer : Table.
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
    array('display_mode' => 'Table'),
    array(
        'before_str_key' => '"',
        'after_str_key'  => '"',
        'before_type'    => '[',
        'after_type'     => ']'
    )
);

Var_Dump::display($array);

?>
--EXPECT--
<table><caption>array(3)</caption><tr><td>"key1"</td><td>[string(44)]</td><td>The quick brown<br />
fox jumped over<br />
the lazy dog</td></tr><tr><td>"key2"</td><td colspan="2"><table><caption>&amp;array(3)</caption><tr><td>0</td><td>[bool]</td><td>true</td></tr><tr><td>1</td><td>[int]</td><td>123</td></tr><tr><td>2</td><td>[float]</td><td>123.45</td></tr></table></td></tr><tr><td>"key3"</td><td colspan="2">[NULL]</td></tr></table>