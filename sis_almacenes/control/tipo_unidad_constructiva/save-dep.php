<?
$tree = stripslashes($_REQUEST['data']);
$ar = json_decode($tree);
print("<pre>");
		print_r($ar);
		print("</pre>");
exit;

//file_put_contents('./dep-tree.json', $tree);
?>