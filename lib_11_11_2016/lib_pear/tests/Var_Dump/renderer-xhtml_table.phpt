--TEST--
Renderer : XHTML_Table.
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

Var_Dump::displayInit(array('display_mode' => 'XHTML_Table'));
Var_Dump::display($array);

?>
--EXPECT--
<table class="var_dump"><caption>array(3)</caption><tr><th>key1</th><td><i>string(44)</i></td><td>The quick brown<br />
fox jumped over<br />
the lazy dog</td></tr><tr class="alt"><th>key2</th><td colspan="2"><table class="var_dump"><caption>&amp;array(3)</caption><tr><th>0</th><td><i>bool</i></td><td>true</td></tr><tr class="alt"><th>1</th><td><i>int</i></td><td>123</td></tr><tr><th>2</th><td><i>float</i></td><td>123.45</td></tr></table></td></tr><tr><th>key3</th><td colspan="2"><i>NULL</i></td></tr></table>