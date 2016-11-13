<?php
/**
 * Generator usage example using HTMLPage renderer.
 *
 * @version    $Id: generator_htmlpage.php,v 1.1 2004/02/13 15:46:27 farell Exp $
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress/generator.php';
require_once 'HTML/Progress/generator/HTMLPage.php';

session_start();

$tabbed = new HTML_Progress_Generator();
$tabbed->run();
?>