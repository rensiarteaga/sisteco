<?php
exec('ls ../../../../../',$salida);
foreach($salida as $line) { echo "$line<br>"; }

?>