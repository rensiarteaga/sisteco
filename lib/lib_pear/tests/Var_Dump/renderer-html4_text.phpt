--TEST--
Renderer : HTML4_Text.
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

Var_Dump::displayInit(array('display_mode' => 'HTML4_Text'));
Var_Dump::display($array);

?>
--EXPECT--
<pre>array(3) {
  key1 =&gt; <font color="#006600">string(44)</font> <font color="#339900">The quick brown
</font>                     <font color="#339900">fox jumped over
</font>                     <font color="#339900">the lazy dog</font>
  key2 =&gt; &array(3) {
    0 =&gt; <font color="#006600">bool</font> <font color="#339900">true</font>
    1 =&gt; <font color="#006600">int</font> <font color="#339900">123</font>
    2 =&gt; <font color="#006600">float</font> <font color="#339900">123.45</font>
  }
  key3 =&gt; <font color="#006600">NULL</font>
}
</pre>