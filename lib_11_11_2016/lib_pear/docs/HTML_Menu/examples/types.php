<?php
/**
 * Basic usage example for HTML_Menu, showing all available menu types
 * 
 * $Id: types.php,v 1.2 2004/01/17 12:33:16 avb Exp $
 * 
 * @package HTML_Menu
 * @author Alexey Borzov <avb@php.net>
 */

require_once 'HTML/Menu.php';
require_once './data/menu.php';

$types = array('tree', 'urhere', 'prevnext', 'rows', 'sitemap');

$menu =& new HTML_Menu($data);
$menu->forceCurrentUrl('/item1.2.2.php');

foreach ($types as $type) {
    echo "\n<h1>Trying menu type &quot;{$type}&quot;</h1>\n";
    $menu->show($type);
}
?>
