<?php

include_once 'Var_Dump.php';

echo '<h1>example6.php : Globals</h1>';

/*
 * example6.php : Globals
 *
 */

Var_Dump::displayInit(
    array(
        'display_mode' => 'HTML4_Text'
    ),
    array(
        'mode' => 'normal',
        'offset' => 4
    )
);

Var_Dump::display($GLOBALS);

?>