<?php
//Configuration
include_once('core/config.php');
//User Class
include_once('core/user.class.php');
//Link Class
include_once('core/link.class.php');
//Category Class
include_once('core/category.class.php');

//User Istance
//In this moment I developed to one user (me)
$user = User::getIstanza('dlion',$db);
if($user != false)
{
    //Link Istance
    $link = Link::getIstanza($user->getId(),$db);
}
else
{
    //Nessun user trovato
}

//Category Istance
$category = Category::getIstanza($db);


//If password is correct add link to database
if(isset($_POST['name_site']) && isset($_POST['link_site']) && isset($_POST['password_site']) && isset($_POST['category'])) {
    if($user->checkMyPass($_POST['password_site']) === true)
        $ris = $link->insertLink($_POST['name_site'],$_POST['link_site'],$_POST['category']);
    else
    {
        //Password errata
    }
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
/*
Ora ho creato la classe delle categorie così da suddividere i link in categorie
Bisogna ancora aggiungere metodi per togliere le categorie
                          metodi per togliere link
*/
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo htmlspecialchars($conf->getNameSite()." - ".$io['nick']); ?></title>

	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	    <link rel="stylesheet" type="text/css" href="css/kube.min.css" />
	    <link rel="stylesheet" type="text/css" href="css/master.css" />
        <link rel="stylesheet" type="text/css" href="css/dl.css" />
        <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
    </head>
   </head>
    <body>
        <div class="wrapper">
            <header id="header" class="group">
		        <h1><?php echo htmlspecialchars($conf->getNameSite()." - ".$io['nick']); ?></h1>
	        </header>
        </div>
    </body>
</html>