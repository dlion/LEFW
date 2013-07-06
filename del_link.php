<?php
//Configuration
include_once('core/config.php');

if(isset($_POST['link']) && isset($_SESSION['saveme']) && $_SESSION['saveme'] === 'ok')
    $link->deleteLink($_POST['link']);
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
                        <li><a href="index.php">Public Link</a></li>
                        <li><a href="priv_link.php">Private Link</a></li>
                        <li><a href="add_link.php">Add Link</a></li>
                        <li><span>Del Link</span></li>
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
    
    $all_link = $link->getAllLink();?>
            <form method="post" action="" class="forms columnar">
                <fieldset>
                    <ul>
                        <li>
                            <label for="link" class="bold">Del Link</label>
                            <select class="width-33" name="link" id="link">
                                <option value=''>Choose Link</option>
                                <?php foreach($all_link as $link_del){ ?>
                                <option name="link" value="<?php echo $link_del['id'];?>"><?php echo $link_del['name'];?></option>
                                <?php }?>
                            </select>
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
<?php
if(isset($_SESSION['saveme']))
          echo '<li><a href="edit_account.php">Edit Account</a> | </li>'; ?>
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
