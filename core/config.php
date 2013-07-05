<?php
//Init Session
session_start();
$INSTALL = "_FALSE_";
if($INSTALL == "_TRUE_")
{
	//Config Class
	include_once('config.class.php');
	//DB Class
	include_once('db.class.php');
	//User Class
	include_once('user.class.php');
	//Link Class
	include_once('link.class.php');
	//Category Class
	include_once('category.class.php');

	/*
	 * -- Configuration --
	 * - @host - Host where is the database
	 * - @database - Name of database
	 * - @user - User to use database
	 * - @password - Password to use database
	 * - @admin - Id of admin
	 */

	$conf = Config::getIstanza('_HOST_','_DB_NAME_','_DB_USER_','_DB_PASS_','_ID_ADMIN_');

	// DB and PDO istances
	$db = Db::getIstanza($conf);
	$db = $db->getPDO();
	//User Istance
	$user = User::getIstanza($conf->getIdAdmin(),$db);

	//Link Istance
	$link = Link::getIstanza($conf->getIdAdmin(),$db);

	//Category Istance
	$category = Category::getIstanza($conf->getIdAdmin(),$db);
}
else
	header("Location: /setup/install.php");
?>

