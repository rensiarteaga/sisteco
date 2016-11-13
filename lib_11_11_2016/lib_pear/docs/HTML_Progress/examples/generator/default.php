<?php
@include '../include_path.php';
/**
 * Generator usage example using Default QF renderer
 * without any changes (all default options are used).
 *
 * @version    $Id: default.php,v 1.1 2004/06/27 13:08:05 farell Exp $
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress/generator.php';


session_start();

$tabbed = new HTML_Progress_Generator();
$tabbed->run();
?>