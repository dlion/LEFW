<?php
//Include classes
include_once('core.class.php');
//Istance of configuration
$conf = Config::getIstanza('host','db name','user','password','admin name');
//Istance of PDO
$db = Db::getIstanza($conf);
//Retrieve pdo
$db = $db->getPDO();
?>

