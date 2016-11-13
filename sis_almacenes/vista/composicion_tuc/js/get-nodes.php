
<?php

$txt = <<<EOF
[
	&#123;'id'&#58; "A1", 'text'&#58; 'Pasta1', 'cls'&#58; 'folder', 'leaf'&#58;false,
		"children" &#58; 
			[ 
				&#123;"text" &#58; "Arquivo A1", "id" &#58; "A2", "leaf" &#58; true, "cls" &#58; "file"&#125;,
				&#123;"text" &#58; "Arquivo A2", "id" &#58; "A3", "leaf" &#58; true, "cls" &#58; "file"&#125;,
				&#123;"text" &#58; "Arquivo A3", "id" &#58; "A4", "leaf" &#58; true, "cls" &#58; "file"&#125;,
				&#123;"text" &#58; "Arquivo A4", "id" &#58; "A5", "leaf" &#58; true, "cls" &#58; "file"&#125;,
				&#123;"text" &#58; "Arquivo A5", "id" &#58; "A6", "leaf" &#58; true, "cls" &#58; "file"&#125;
			&#93;
	&#125;,	
	&#123;'id'&#58; "B1", 'text'&#58; 'Pasta2', 'cls'&#58; 'folder', 'leaf'&#58;false,
		"children" &#58; 
			[ 
				&#123;"text" &#58; "Arquivo B1", "id" &#58; "B2", "leaf" &#58; true, "cls" &#58; "file"&#125;,
				&#123;"text" &#58; "Arquivo B2", "id" &#58; "B3", "leaf" &#58; true, "cls" &#58; "file"&#125;,
				&#123;"text" &#58; "Arquivo B3", "id" &#58; "B4", "leaf" &#58; true, "cls" &#58; "file"&#125;,
				&#123;"text" &#58; "Arquivo B4", "id" &#58; "B5", "leaf" &#58; true, "cls" &#58; "file"&#125;,
				&#123;"text" &#58; "Arquivo B5", "id" &#58; "B6", "leaf" &#58; true, "cls" &#58; "file"&#125;
			&#93;
	&#125;	
&#93;
EOF;
echo $txt;
?>