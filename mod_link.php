<?php
//Configuration
include_once('core/config.php');
//Link Class
include_once('core/link.class.php');
//Category Class
include_once('core/category.class.php');

//Link Istance
$link = Link::getIstanza($user->getId(),$db);
//Category Istance
$category = Category::getIstanza($db);


//If password is set or if I have session
if(isset($_POST['name']) && isset($_POST['url']) && isset($_POST['category']) && isset($_SESSION['saveme']) && $_SESSION['saveme'] == 'ok' ) {
    //If session is set and right or if is set a pass and pass is true
    $priv = (!isset($_POST['priv'])) ? 0 : 1;
            
    $ris = $link->insertLink($_POST['name'],$_POST['url'],$_POST['category'],$priv);      
}

//User Information
$io = array (   
        "id" => $user->getId(),
        "nome" => $user->getName(),
        "cognome" => $user->getSurname(),
        "nick" => $user->getNick(),
        "pic" => $user->getPic(),
        "bio" => $user->getBio()
    );
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo htmlspecialchars($conf->getNameSite()." - ".$io['nick']); ?></title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <link rel="stylesheet" type="text/css" href="css/kube.min.css" />
	    <link rel="stylesheet" type="text/css" href="css/master.css" />
        <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <div class="wrapper">
            <header id="header" class="group">
		        <h1><?php echo htmlspecialchars($conf->getNameSite()." - ".$io['nick']); ?></h1>
                <nav class="nav-tabs">
                    <ul>
    					<li><a href='index.php'>Public Link</a></li>
                        <li><a href="priv_link.php">Private Link</a></li>
    					<li><a href="add_link.php">Add Link</a></li>
                        <li><a href="del_link.php">Del Link</a></li>
                        <li><span>Modify Link</span></li>
				    </ul>
			    </nav>
	        </header>
            <hr>
<?php
if(isset($_POST['pass']) && $user->checkMyPass($_POST['pass']) === true ||  isset($_SESSION['saveme']) && $_SESSION['saveme'] === 'ok')
{
    if(!isset($_SESSION['saveme']))
        $_SESSION['saveme'] = 'ok';
        
        //Prendo tutte le categorie
        $categoria = $category->getAllCategory();
        
}?>
