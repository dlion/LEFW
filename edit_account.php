<?php
//Configuration
include_once('core/config.php');

if(isset($_POST['nick']) && !empty($_POST['nick']) || isset($_POST['password']) && isset($_SESSION['saveme']) && $_SESSION['saveme'] === 'ok') {
    if(!empty($_POST['password']) && isset($_POST['password']))
        $user->changePass($_POST['password']);
    if(!empty($_POST['nick']) && isset($_POST['nick']))
        $user->changeNick($_POST['nick']);
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
                        
                    </ul>
                </nav>
            </header>
            <hr>
<?php
if(isset($_POST['pass']) && $user->checkMyPass($_POST['pass']) === true ||  isset($_SESSION['saveme']) && $_SESSION['saveme'] === 'ok')
{
    if(!isset($_SESSION['saveme']))
        $_SESSION['saveme'] = 'ok';
?>    
    <form method="post" action="" class="forms columnar">
        <fieldset>
            <ul>
                <li>
                    <label for="nick" class="bold">Nick</label>
                    <input type="text" name="nick" id="nick" size="40" />
                </li>
                <li>
                    <label for="password" class="bold">Password</label>
                    <input type="text" name="password" id="password" size="40" />
                </li>
                <li class="push">
                    <input type="submit" name="send" class="btn" value="Change" />
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