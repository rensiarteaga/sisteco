--TEST--
Bug #490  : Recursions not managed.
--SKIPIF--
<?php 
if (version_compare(PHP_VERSION, '4.9.9', '<=')) print 'PHP 5 required';
?>
--FILE--
<?php

error_reporting(E_ALL);
require_once 'Var_Dump.php';
$vd = new Var_Dump(array('display_mode' => 'Text'));

class c_parent {
    function c_parent() {
        $this->myChild = new child($this);
        $this->myName = 'c_parent';
    }
}
class child {
    function child(& $c_parent) {
        $this->myParent = & $c_parent;
    }
}

echo $vd->toString(new c_parent());

?>
--EXPECTREGEX--
object\(c_parent\)(#[0-9]+ )?\(2\) {
  myChild => object\(child\)(#[0-9]+ )?\(1\) {
    myParent => object\(c_parent\)(#[0-9]+ )?\(2\) {
      myChild => object\(child\)(#[0-9]+ )?\(1\) {
        myParent => \*RECURSION\*
      }
      myName => string\(8\) c_parent
    }
  }
  myName => string\(8\) c_parent
}