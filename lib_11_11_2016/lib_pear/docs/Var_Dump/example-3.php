<?php

include_once 'Var_Dump.php';

echo '<h1>example3.php : factory approach</h1>';

/*
 * example3.php : Factory approach
 *
 * If you want to use a factory object, you will have to instanciate an
 * object with the appropriate parameters, and then to use the "toString"
 * method, as the display method is inacurate in this case.
 *
 */

// Initialise the HTML4 Table rendering (see Var_Dump/Renderer/HTML4_Table.php)
$myVarDump = & Var_Dump::factory(
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
echo $myVarDump->toString($array);

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
echo $myVarDump->toString($recursiveObject);

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
echo $myVarDump->toString($object);

/*
 * Displays a variable using the display() method
 */

echo '<h2>Var_Dump::display()</h2>';
echo '<p>Singleton method, uses the default configuration parameters for the rendering, because we are not using the previously instanciated object</p>';

Var_Dump::display($array);

fclose($fileHandler);

?>