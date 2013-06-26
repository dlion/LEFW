<?php
//Configuration
include_once('core/config.php');

if(isset($_POST['name']) && isset($_POST['descr']) && isset($_POST['category_id']) && !empty($_POST['category_id']) && isset($_SESSION['saveme']) && $_SESSION['saveme'] == 'ok' ) {
    //If session is set and right or if is set a pass and pass is true
    $dest = $_POST['category_id'];
    $category->updateNameCategory($dest,$_POST['name']);
    $category->updateDescrCategory($dest,$_POST['descr']);
}
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
                        <li><a href='add_category.php'>Add Category</a></li>
                        <li><a href='del_category.php'>Del Category</a></li>
                        <li><span>Modify Category</span></li>
                    </ul>
                </nav>
            </header>
            <hr>
<?php
if(isset($_POST['pass']) && $user->checkMyPass($_POST['pass']) === true ||  isset($_SESSION['saveme']) && $_SESSION['saveme'] === 'ok')
{
    if(!isset($_SESSION['saveme']))
        $_SESSION['saveme'] = 'ok';
    
    //If choose a link to modify
    if(isset($_POST['category']) && $category->getCategoryById($_POST['category']) !== false) {
        foreach ($category->getCategoryById($_POST['category']) as $dati) {
            $id_category = $dati['id'];
            $nome = $dati['label'];
            $descr = $dati['descr'];
        }?>
            <form method="post" action="" class="forms columnar">
                <fieldset>
                    <ul>
                        <li>
                            <label for="name" class="bold">Name</label>
                            <input type="text" name="name" id="name" size="40" value="<?php echo $nome;?>" />
                        </li>
                        <li>
                            <label for="descr" class="bold">Description</label>
                            <input type="text" name="descr" id="descr" size="40" value="<?php echo $descr;?>" />
                        </li>
                        <li class="push">
                            <input type="hidden" name="category_id" value="<?php echo $id_category;?>"/>
                            <input type="submit" name="send" class="btn" value="Submit" />
                        </li>
                    </ul>
                </fieldset>
            </form>
    <?php
    }
    else
    {
        $categoria = $category->getAllCategory();?>
            <form method="post" action="" class="forms columnar">
                <fieldset>
                    <ul>
                        <li>
                            <label for="category" class="bold">Modify Category</label>
                            <select class="width-33" name="category" id="category">
                                <option value=''>Choose Category</option>
                                <?php foreach($categoria as $cat){ 
                                        if($cat['label'] != "General"){?>?>
                                <option name="category" value="<?php echo $cat['id'];?>"><?php echo $cat['label'];?></option>
                                <?php } 
                                }?>
                            </select>
                        </li>
                        <li class="push">
                            <input type="submit" name="send" class="btn" value="Modify" />
                        </li>
                    </ul>
                </fieldset>
            </form>
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