<?php
//Configuration
include_once('core/config.php');
//Link Class
include_once('core/link.class.php');
//Category Class
include_once('core/category.class.php');

//Category Istance
$category = Category::getIstanza($db);

//Link Istance
$link = Link::getIstanza($user->getId(),$db);

//User Information
$io = array (   
        "id" => $user->getId(),
        "nome" => $user->getName(),
        "cognome" => $user->getSurname(),
        "nick" => $user->getNick(),
        "pic" => $user->getPic(),
        "bio" => $user->getBio()
    );
//Prendo tutte le categorie
$categoria = $category->getAllCategory();
//Counter Category
$i=0;
/*
Ora ho creato la classe delle categorie così da suddividere i link in categorie
Bisogna ancora aggiungere metodi per togliere le categorie
                          motodi per cambiare la password
                          implementare la criptazione della password
                          
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
        <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <div class="wrapper">
            <header id="header" class="group">
		        <h1><?php echo htmlspecialchars($conf->getNameSite()." - ".$io['nick']); ?></h1>
                <nav class="nav-tabs">
                    <ul>
    					<li><span>Public Link</span></li>
                        <li><a href="priv_link.php">Private Link</a></li>
        				<li><a href="add_link.php">Add Link</a></li>
                        <li><a href="del_link.php">Del Link</a></li>
                        <li><a href="mod_link.php">Modify Link</a></li>
				    </ul>
			    </nav>
	        </header>
            <hr>
<?php
if($categoria !== false)
{
    foreach($categoria as $cat)
    {
        $link_by_cat = $link->getPublicLinkByCategory($cat['id']);
        if($link_by_cat != false)
        {
            if($i % 4 == 0) 
            {?>
                <div class='row split'>
            <?php
            }
            $i++;?>
                <div class='quarter'>
                    <h2><?php echo $cat['label']; ?></h2>
                    <h2 class='subheader'><?php echo $cat['descr']; ?></h2>
                    <table class='width-100 bordered'>
                        <thead class='thead-black'>
            <?php
            foreach($link_by_cat as $lincat)
            {?>
                <tr>
                    <th>
                        <a href='<?php echo $lincat['url'];?>' rel='nofollow' target="_blank"><?php echo $lincat['name'];?></a>
                    </th>
                </tr>
            <?php
            }?>  
                    </thead>
                </table>
            </div>
            <?php
            if($i % 4 == 0)
            {?>
                </div>
            <?php
                $i=0;
            }
            
        }
    }
}
else
{?>
    <div class='row split'>
        <div class='fivesixth text-centered'>
            <h1>Nessuna Categoria Trovata</h1>
            <h1 class='subheader'>L'utente non ha inserito alcuna categoria.</h1>
        </div>
    </div>
<?php 
}?>
        </div>
    </body>
</html>
