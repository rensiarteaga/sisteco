--TEST--
Create an new paradox database
--SKIPIF--
<?php if (!extension_loaded("paradox")) print "skip"; ?>
--POST--
--GET--
--INI--
--FILE--
<?php 
$dirname = dirname($SCRIPT_FILENAME);
$fp = fopen($dirname."/px2.db", "w+");
$pxdoc = new paradox_pxdoc();
$fields = array(array("col1", "S"), array("col2", "I"));
@$pxdoc->create_fp($fp, $fields);
$pxdoc->set_tablename("testtabelle");
$pxdoc->close($pxdoc);
?>
--EXPECT--
