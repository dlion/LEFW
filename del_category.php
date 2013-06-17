<?php
//Configuration
include_once('core/config.php');

if(isset($_POST['category']) && isset($_SESSION['saveme']) && $_SESSION['saveme'] === 'ok') {
    $erase = (!isset($_POST['erase'])) ? 0 : 1;
    $category->deleteCategory($_POST['category'],$erase);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo htmlspecialchars($conf->getNameSite()." - ".$io['nick']); ?></title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

	    <link rel="stylesheet" type="text/css" href="css/kube/kube.min.css" />
	    <link rel="stylesheet" type="text/css" href="css/kube/master.css" />
        <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <div class="wrapper">
            <header id="header" class="group">
		        <h1><?php echo htmlspecialchars($conf->getNameSite()." - ".$io['nick']); ?></h1>
                <nav class="nav-tabs">
                    <ul>
                        <li><a href='add_category.php'>Add Category</a></li>
                        <li><span>Del Category</span></li>
                        <li><a href='mod_category.php'>Modify Category</a></li>
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
        $categoria = $category->getAllCategory();?>
            <form method="post" action="" class="forms columnar">
                <fieldset>
                    <ul>
                        <li>
                            <label for="category" class="bold">Del Category</label>
                            <select class="width-33" name="category" id="category">
                                <option>Choose Category</option>
                                <?php foreach($categoria as $cat){
                                        if($cat['label'] != "General"){?>
                                <option name="category" value="<?php echo $cat['id'];?>"><?php echo $cat['label'];?></option>
                                <?php } 
                                    } ?>
                            </select>
                        </li>
                        <li>
                            <label for="erase" class="bold">Erase links</label>
                            <input type="checkbox" name="erase" id="erase" value='1'/>
                        </li>
                        <li class="push">
                            <input type="submit" name="send" class="btn" value="Delete" />
                        </li>
                    </ul>
                </fieldset>
            </form>
<?php
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
            <footer id="footer">
                <ul id='manage_category'>
                    <li><a href='index.php'>Public Link</a></li>
                    <li><a href="priv_link.php">Private Link</a></li>
                    <li><a href="add_link.php">Add Link</a></li>
                    <li><a href="del_link.php">Del Link</a></li>
                    <li><a href="mod_link.php">Modify Link</a></li>
                </ul>
                <ul id='about'>
                    <li><a href='http://github.com/DLion/LEFW/'>ForkMe</a></li>
                    <li><a href='http://dlion.it'>DLion</li>
                </ul>
            </footer>
        </div>
    </body>
</html>