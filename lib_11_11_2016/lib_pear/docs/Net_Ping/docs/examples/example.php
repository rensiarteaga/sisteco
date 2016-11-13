<?php
  require_once "../../Ping.php";
  $ping = Net_Ping::factory();
  if(PEAR::isError($ping)) {
    echo $ping->getMessage();
  } else {
    $ping->setArgs(array('count' => 2, 'deadline' => 1));
    var_dump($ping->ping('example.com'));
  }
?>
