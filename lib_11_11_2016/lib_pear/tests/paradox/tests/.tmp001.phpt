--TEST--
Reading a simple paradox database
--SKIPIF--
<?php if (!extension_loaded("paradox")) print "skip"; ?>
--POST--
--GET--
--INI--
--FILE--
<?php 
$dirname = dirname($SCRIPT_FILENAME);
$pxdoc = px_new();
$fp = fopen($dirname."/simpletest.db", "r");
px_open_fp($pxdoc, $fp);
$info = px_get_info($pxdoc);
print_r($info);
px_close($pxdoc);
px_delete($pxdoc);
?>
--EXPECT--
Array
(
    [fileversion] => 70
    [tablename] => test.db
    [numrecords] => 1
    [numfields] => 1
    [headersize] => 2048
    [maxtablesize] => 2
    [numdatablocks] => 1
    [numindexfields] => 0
    [codepage] => 1252
)
