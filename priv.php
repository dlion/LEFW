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
    //Category Istance
    $category = Category::getIstanza($db);
}
else
{
    //Nessun user trovato
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
//Prendo tutte le categorie
$categoria = $category->getAllCategory();
//Counter Category
$i=0;
/*
Ora ho creato la classe delle categorie così da suddividere i link in categorie
Bisogna ancora aggiungere metodi per togliere le categorie
                          metodi per togliere link
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
    					<li><a href="index.php">Home</a></li>
                        <li><span>Private</span></li>
    					<li><a href="add.php">Add</a></li>
                        <li><a href="del.php">Del</a></li>
				    </ul>
			    </nav>
	        </header>
            <hr>
<?php
if(isset($_POST['pass']) && $user->checkMyPass($_POST['pass']) === true ||  isset($_SESSION['saveme']) && $_SESSION['saveme'] === 'ok')
{
    if(!isset($_SESSION['saveme']))
        $_SESSION['saveme'] = 'ok';
    
    if($categoria !== false)
    {
        foreach($categoria as $cat)
        {
            $link_by_cat = $link->getPrivateLinkByCategory($cat['id']);
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
                            <a href='<?php echo $lincat['url'];?>' rel='nofollow'><?php echo $lincat['name'];?></a>
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
    }
}
else
{?>
<form method="post" action="" class="forms columnar">
    <fieldset>
        <ul>
            <li>
                <label for="pass" class="bold">Password</label>
                <input type="password" name="pass" id="pass" size="40" />
            </li>
            <li class="push">
                <input type="submit" name="send" class="btn" value="Submit" />
            </li>
        </ul>
    </fieldset>
</form>
<?php    
}?>
        </div>
    </body>
</html>