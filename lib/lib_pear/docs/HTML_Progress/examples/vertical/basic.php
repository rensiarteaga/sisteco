<?php 
@include '../include_path.php';
/**
 * Basic Vertical ProgressBar example.
 * 
 * @version    $Id: basic.php,v 1.1 2004/07/05 21:32:31 farell Exp $
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

require_once 'HTML/Progress.php';

$bar = new HTML_Progress(HTML_PROGRESS_BAR_VERTICAL);
$bar->setAnimSpeed(100);
$bar->setValue(85);
?>
<html>
<head>
<title>Basic Vertical ProgressBar example</title>
<style type="text/css">
<!--
<?php echo $bar->getStyle(); ?>

body {
	background-color: #FFFFFF;
	color: #000000;
	font-family: Verdana, Arial;
}

a:visited, a:active, a:link {
	color: navy;
}
// -->
</style>
<script type="text/javascript">
<!--
<?php echo $bar->getScript(); ?>
//-->
</script>
</head>
<body>
<h1><?php echo basename(__FILE__); ?></h1>

<?php 
echo $bar->toHtml(); 
$bar->run();
?>

<p>&lt;&lt; <a href="../index.html">Back examples TOC</a></p>

</body>
</html>