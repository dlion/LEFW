<?php
include_once('core.class.php');

$conf = Config::getIstanza('host','db name','user','password','admin name');
$db = Db::getIstanza($conf);
$db = $db->getPDO();
?>

