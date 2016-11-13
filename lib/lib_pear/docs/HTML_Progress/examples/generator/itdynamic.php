<?php
/**
 * Generator usage example using ITDynamic QF renderer.
 *
 * @version    $Id: itdynamic.php,v 1.1 2004/06/27 13:08:05 farell Exp $
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress/generator.php';
require_once 'HTML/Progress/generator/ITDynamic.php';

session_start();

$tabbed = new HTML_Progress_Generator();
$tabbed->run();
?>