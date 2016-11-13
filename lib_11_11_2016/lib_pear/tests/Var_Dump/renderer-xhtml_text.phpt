--TEST--
Renderer : XHTML_Text.
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

Var_Dump::displayInit(array('display_mode' => 'XHTML_Text'));
Var_Dump::display($array);

?>
--EXPECT--
<pre class="var_dump">array(3) {
  key1 =&gt; <span class="type">string(44)</span> <span class="value">The quick brown
</span>                     <span class="value">fox jumped over
</span>                     <span class="value">the lazy dog</span>
  key2 =&gt; &array(3) {
    0 =&gt; <span class="type">bool</span> <span class="value">true</span>
    1 =&gt; <span class="type">int</span> <span class="value">123</span>
    2 =&gt; <span class="type">float</span> <span class="value">123.45</span>
  }
  key3 =&gt; <span class="type">NULL</span>
}
</pre>