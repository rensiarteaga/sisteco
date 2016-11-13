--TEST--
Renderer : HTML4_Table.
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

Var_Dump::displayInit(array('display_mode' => 'HTML4_Table'));
Var_Dump::display($array);

?>
--EXPECT--
<table border="0" cellpadding="1" cellspacing="0" bgcolor="black"><tr><td><table border="0" cellpadding="4" cellspacing="0" width="100%"><caption style="color:white;background:#339900;">array(3)</caption><tr valign="top" bgcolor="#F8F8F8"><td bgcolor="#CCCCCC"><b>key1</b></td><td><font color="#000000">string(44)</font></td><td><font color="#006600">The quick brown<br />
fox jumped over<br />
the lazy dog</font></td></tr><tr valign="top" bgcolor="#E8E8E8"><td bgcolor="#CCCCCC"><b>key2</b></td><td colspan="2"><table border="0" cellpadding="1" cellspacing="0" bgcolor="black"><tr><td><table border="0" cellpadding="4" cellspacing="0" width="100%"><caption style="color:white;background:#339900;">&amp;array(3)</caption><tr valign="top" bgcolor="#F8F8F8"><td bgcolor="#CCCCCC"><b>0</b></td><td><font color="#000000">bool</font></td><td><font color="#006600">true</font></td></tr><tr valign="top" bgcolor="#E8E8E8"><td bgcolor="#CCCCCC"><b>1</b></td><td><font color="#000000">int</font></td><td><font color="#006600">123</font></td></tr><tr valign="top" bgcolor="#F8F8F8"><td bgcolor="#CCCCCC"><b>2</b></td><td><font color="#000000">float</font></td><td><font color="#006600">123.45</font></td></tr></table></td></tr></table></td></tr><tr valign="top" bgcolor="#F8F8F8"><td bgcolor="#CCCCCC"><b>key3</b></td><td colspan="2"><font color="#000000">NULL</font></td></tr></table></td></tr></table>