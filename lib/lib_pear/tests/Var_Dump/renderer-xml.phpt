--TEST--
Renderer : XML.
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

Var_Dump::displayInit(array('display_mode' => 'XML'));
Var_Dump::display($array);

?>
--EXPECT--
<group caption="array(3)">
  <element>
    <key>key1</key>
    <type>string(44)</type>
    <value>The quick brown
fox jumped over
the lazy dog</value>
  </element>
  <element>
    <key>key2</key>
    <type>group</type>
    <value>
      <group caption="&amp;array(3)">
        <element>
          <key>0</key>
          <type>bool</type>
          <value>true</value>
        </element>
        <element>
          <key>1</key>
          <type>int</type>
          <value>123</value>
        </element>
        <element>
          <key>2</key>
          <type>float</type>
          <value>123.45</value>
        </element>
      </group>
    </value>
  </element>
  <element>
    <key>key3</key>
    <type>NULL</type>
    <value></value>
  </element>
</group>