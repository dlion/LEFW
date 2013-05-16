<?php
//Init Session
session_start();
//Config Class
include_once('config.class.php');
//DB Class
include_once('db.class.php');
//User Class
include_once('user.class.php');

/*
 * -- Configuration --
 * - @host - Host where is the database
 * - @database - Name of database
 * - @user - User to use database
 * - @password - Password to use database
 * - @admin - Nickname of admin inserted in the databse
 */
 
$conf = Config::getIstanza('@host','@database','@user','@password','@admin');

// DB and PDO istances
$db = Db::getIstanza($conf);
$db = $db->getPDO();
//User Istance
$user = User::getIstanza($conf->getAdmin(),$db);
?>
