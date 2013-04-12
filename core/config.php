<?php
//Config Class
include_once('config.class.php');
//DB Class
include_once('db.class.php');

/*
 * -- Configuration --
 * - @host - Host where is the database
 * - @database - Name of database
 * - @user - User to use database
 * - @password - Password to use database
 * - @admin - Name or nick of admin
 */
$conf = Config::getIstanza('host','db name','user','password','admin name');

// Istances
$db = Db::getIstanza($conf);
if($db != false)
    $db = $db->getPDO();
else
    //La connessione è fallita
?>

