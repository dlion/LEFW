<!DOCTYPE html>
<html>
    <head>
<?php
//Page to install LEFW, adding user, category, database structure,etc.
if(isset($_POST['db_host']) && isset($_POST['db_name']) && isset($_POST['db_user']) && isset($_POST['db_pass']) && isset($_POST['user_admin']) && isset($_POST['pass_admin']))
{
	$HOST = htmlspecialchars($_POST['db_host']);
	$DB_NAME = htmlspecialchars($_POST['db_name']);
	$DB_USER = htmlspecialchars($_POST['db_user']);
	$DB_PASS = htmlspecialchars($_POST['db_pass']);
	$NICK_ADMIN = htmlspecialchars($_POST['user_admin']);
	$PASS_ADMIN = hash("sha256",htmlspecialchars($_POST['pass_admin']));

	//Create DB Structure
	try {
		$pdo = new PDO("mysql:host=$HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);
		//Create Category Table
		$query = $pdo->prepare("CREATE TABLE IF NOT EXISTS link_category (
								  id int(11) NOT NULL AUTO_INCREMENT,
								  label varchar(100) NOT NULL,
								  descr varchar(255) DEFAULT NULL,
								  user int(11) NOT NULL,
								  PRIMARY KEY (id),
								  KEY user (user) 
								  ) ENGINE=MyISAM  DEFAULT CHARSET=latin1;");
		$query->execute();	

		//Create Link Table
		$query = $pdo->prepare("CREATE TABLE IF NOT EXISTS link_link (
								  id int(11) NOT NULL AUTO_INCREMENT,
								  name varchar(255) DEFAULT NULL,
								  url varchar(255) NOT NULL,
								  category int(11) NOT NULL,
								  priv8 int(1) NOT NULL DEFAULT '0',
								  user int(11) NOT NULL,
								  PRIMARY KEY (id),
								  KEY user (user),
								  KEY category (category),
								  KEY priv8 (priv8),
								  KEY url (url)
								) ENGINE=MyISAM  DEFAULT CHARSET=latin1;");
		$query->execute();

		//Create Profile Table
		$query = $pdo->prepare("CREATE TABLE IF NOT EXISTS link_profile (
								  id int(11) NOT NULL AUTO_INCREMENT,
								  nick varchar(50) NOT NULL,
								  password varchar(255) NOT NULL,
								  PRIMARY KEY (id),
								  UNIQUE KEY nick (nick)
								) ENGINE=MyISAM  DEFAULT CHARSET=latin1;");
		$query->execute();

		//Create User
		$query = $pdo->prepare("INSERT INTO link_profile(nick,password) VALUES(:nick,:password)");
		$query->execute(array(
							':nick' => $NICK_ADMIN,
							':password' => $PASS_ADMIN
                            )
						);

		if($query->rowCount() == 0)
			throw new Exception("Query Error");

		$last_id = $pdo->lastInsertId();

		//Create General Category
		$query = $pdo->prepare("INSERT INTO link_category(label,descr,user) VALUES(:label,:descri,:user)");
		$query->execute(array(
							':label' => 'General',
							':descri' => 'General Category',
							':user' => $last_id
							)
						);
		if($query->rowCount() == 0)
			throw new Exception("Query Error");

	}catch(Exception $e) {
        die($e->getMessage());
    	}

    $str = implode("",file($_SERVER['DOCUMENT_ROOT']."/core/config.php"));

	$str = str_replace("_HOST_",$HOST, $str);
	$str = str_replace("_DB_NAME_",$DB_NAME, $str);
	$str = str_replace("_DB_USER_",$DB_USER, $str);
	$str = str_replace("_DB_PASS_",$DB_PASS, $str);
	$str = str_replace("_ID_ADMIN_", $last_id, $str);
	$str = str_replace("_FALSE_", "_TRUE_", $str);

	//Set Config File
	$config = fopen($_SERVER['DOCUMENT_ROOT']."/core/config.php", "w");
	fwrite($config, $str);
	fclose($config);
?>
    	<title>Installation Setup - LEFW</title>

	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	    <link rel="stylesheet" type="text/css" href="/css/kube.min.css"/>
	    <link rel="stylesheet" type="text/css" href="/css/master.css" />
        <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
    </head>
    <body>
    	<div class="wrapper">
    		<header id="header" class="group">
		        <h1>LEFW is installed successful - LEFW</h1>
			</header>
			<p>Now is possible to delete 'setup' dir</p>
<?php
}
else
{
?>
        <title>Installation Setup - LEFW</title>

	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	    <link rel="stylesheet" type="text/css" href="/css/kube.min.css"/>
	    <link rel="stylesheet" type="text/css" href="/css/master.css" />
        <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
    </head>
    <body>
    	<div class="wrapper">
    		<header id="header" class="group">
		        <h1>Installation Setup - LEFW</h1>
			</header>
    		<hr>
    		 <form method="post" action="" class="forms columnar">
                <fieldset>
                    <ul>
                        <li>
                            <label for="db_host" class="bold">Database Host</label>
                            <input type="text" name="db_host" id="db_host" size="40" />
                        </li>

                        <li>
                            <label for="db_name" class="bold">Database Name</label>
                            <input type="text" name="db_name" id="db_name" size="40" />
                        </li>

                        <li>
                            <label for="db_user" class="bold">User Database</label>
                            <input type="text" name="db_user" id="db_user" size="40" />
                        </li>

                        <li>
                            <label for="db_pass" class="bold">Password Database</label>
                            <input type="password" name="db_pass" id="db_pass" size="40" />
                        </li>

						<li>
                            <label for="user_admin" class="bold">Nick Admin</label>
                            <input type="text" name="user_admin" id="user_admin" size="40" />
                        </li>

                        <li>
                        	<label for="pass_admin" class="bold">Password Admin</label>
                        	<input type="password" name="pass_admin" id="pass_admin" size="40" />
                        </li>
						
                        <li class="push">
                            <input type="submit" name="send" class="btn" value="Create Database and User" />
                        </li>
                    </ul>
                </fieldset>
            </form>
<?php
}
?>
        <footer id="footer">
        	<ul id='about'>
                <li><a href='http://github.com/DLion/LEFW/'>ForkMe</a></li>
                <li><a href='http://dlion.it'>DLion</li>
            </ul>
        </footer>
        </div>
    </body>
</html>