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

//If password is correct add link to database
if(isset($_POST['name']) && isset($_POST['url']) && isset($_POST['pass']) && isset($_POST['category'])) {
    if($user->checkMyPass($_POST['pass']) === true)
    {
        $priv = (!isset($_POST['priv'])) ? 0 : 1;
            
        $ris = $link->insertLink($_POST['name'],$_POST['url'],$_POST['category'],$priv);
    }
    else
    {
        //Password errata
    }    
}
elseif(isset($_POST['name']) && isset($_POST['url']) && isset($_SESSION['saveme']) && isset($_POST['category']) && $_SESSION['saveme'] == 'ok')
{
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
    					<li><a href='index.php'>Home</a></li>
                        <li><a href="priv.php">Private</a></li>
    					<li><span>Add</span></li>
                        <li><a href="del.php">Del</a></li>
				    </ul>
			    </nav>
	        </header>
            <hr>
            <?php
            //Prendo tutte le categorie
            $categoria = $category->getAllCategory();
            ?>
            <form method="post" action="" class="forms columnar">
                <fieldset>
                    <ul>
                        <li>
                            <label for="name" class="bold">Name</label>
                            <input type="text" name="name" id="name" size="40" />
                        </li>
                        <li>
                            <label for="url" class="bold">Url</label>
                            <input type="text" name="url" id="url" size="40" />
                        </li>
                        <li>
                            <label for="category" class="bold">Category</label>
                            <select class="width-33" name="category" id="category">
                                <option>Choose category</option>
                                <?php if($categoria !== false){
                                foreach($categoria as $cat){ ?>
                                <option name="category" value="<?php echo $cat['id'];?>"><?php echo $cat['label'];?></option>
                                <?php }
                                }?>
                            </select>
                        </li>
                        <li>
                            <label>
                                <input type="checkbox" name="priv" id="priv" value='1'> Private
                            </label>
                        </li>
                    <?php 
                    if(!isset($_SESSION['saveme']) || $_SESSION['saveme'] !== 'ok')
                    {?>
                        <li>
                            <label for="pass" class="bold">Password</label>
                            <input type="password" name="pass" id="pass" size="40" />
                        </li>
                <?php
                    } ?>
                        <li class="push">
                            <input type="submit" name="send" class="btn" value="Submit" />
                        </li>
                    </ul>
                </fieldset>
            </form>
        </div>
    </body>
</html>