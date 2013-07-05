<?php
//Configuration
include_once('core/config.php');

//If password is set or if I have session
if(isset($_POST['name']) && isset($_POST['url']) && isset($_POST['category']) && !empty($_POST['category']) && isset($_SESSION['saveme']) && $_SESSION['saveme'] == 'ok' ) {
    //If session is set and right or if is set a pass and pass is true
    $priv = (!isset($_POST['priv'])) ? 0 : 1;
            
    $link->insertLink($_POST['name'],$_POST['url'],$_POST['category'],$priv);    
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo htmlspecialchars($conf->getNameSite()." - ".$user->getNick()); ?></title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" type="text/css" href="css/kube.min.css" />
        <link rel="stylesheet" type="text/css" href="css/master.css" />
        <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <div class="wrapper">
            <header id="header" class="group">
                <h1><?php echo htmlspecialchars($conf->getNameSite()." - ".$user->getNick()); ?></h1>
                <nav class="nav-tabs">
                    <ul>
                        <li><a href='index.php'>Public Link</a></li>
                        <li><a href="priv_link.php">Private Link</a></li>
                        <li><span>Add Link</span></li>
                        <li><a href="del_link.php">Del Link</a></li>
                        <li><a href="mod_link.php">Modify Link</a></li>
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
                                <option value=''>Choose category</option>
                                <?php foreach($categoria as $cat){
                                        if($cat['label'] != "General"){?>
                                <option name="category" value="<?php echo $cat['id'];?>"><?php echo $cat['label'];?></option>
                                <?php }
                                    } ?>
                            </select>
                        </li>
                        <li>
                            <label for="priv" class="bold">Private</label>
                            <input type="checkbox" name="priv" id="priv" value='1'/>
                        </li>
                        <li class="push">
                            <input type="submit" name="send" class="btn" value="Submit" />
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
                <li><a href="edit_account.php">Edit Account</a> | </li>
                <li><a href='add_category.php'>Add Category</a></li>
                <li><a href='del_category.php'>Del Category</a></li>
                <li><a href='mod_category.php'>Modify Category</a></li>
            </ul>
            <ul id='about'>
                <li><a href='http://github.com/DLion/LEFW/'>ForkMe</a></li>
                <li><a href='http://dlion.it'>DLion</li>
            </ul>
        </footer>
        </div>
    </body>
</html>