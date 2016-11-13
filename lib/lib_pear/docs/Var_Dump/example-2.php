<?php

include_once 'Var_Dump.php';

echo '<h1>example2.php : singleton approach</h1>';

/*
 * example2.php : Singleton approach
 *
 * Var_Dump::display() uses a singleton pattern, so if you want to
 * use this method, and configure the output to your needs, you will have
 * to call before the displayInit method with the appropriate parameters.
 * (for instance in the auto_prepend file)
 *
 */

// Initialise the HTML4 Table rendering (see Var_Dump/Renderer/HTML4_Table.php)
Var_Dump::displayInit(
    array(
        'display_mode' => 'HTML4_Table'
    ),
    array(
        'show_caption'   => FALSE,
        'bordercolor'    => '#DDDDDD',
        'bordersize'     => '2',
        'captioncolor'   => 'white',
        'cellpadding'    => '4',
        'cellspacing'    => '0',
        'color1'         => '#FFFFFF',
        'color2'         => '#F4F4F4',
        'before_num_key' => '<font color="#CC5450"><b>',
        'after_num_key'  => '</b></font>',
        'before_str_key' => '<font color="#5450CC">',
        'after_str_key'  => '</font>',
        'before_value'   => '<i>',
        'after_value'    => '</i>'
    )
);

/*
 * Displays an array
 */

echo '<h2>Array</h2>';

$fileHandler = tmpfile();
$linkedArray = array('John', 'Jack', 'Bill');
$array = array(
    'key-1' => 'The quick brown fox jumped over the lazy dog',
    'key-2' => 234,
    'key-3' => array(
        'key-3-1' => 31.789,
        'key-3-2' => & $linkedArray,
        'file'    => $fileHandler
    ),
    'key-4' => NULL
);
Var_Dump::display($array);

/*
 * Displays an object (with recursion)
 */

echo '<h2>Object (Recursive)</h2>';

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
$recursiveObject = new c_parent();
Var_Dump::display($recursiveObject);

/*
 * Displays a classic object
 */

echo '<h2>Object (Classic)</h2>';

class test {
    var $foo = 0;
    var $bar = '';
    function get_foo() {
        return $this->foo;
    }
    function get_bar() {
        return $this->bar;
    }
}
$object = new test();
$object->foo = 753;
$object->bar = '357';
Var_Dump::display($object);

fclose($fileHandler);

?>