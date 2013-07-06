<?php
//Configuration
include_once('core/config.php');

if(isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['url']) && !empty($_POST['url']) && isset($_POST['category']) && !empty($_POST['category']) && isset($_POST['link_id']) && !empty($_POST['link_id']) && isset($_SESSION['saveme']) && $_SESSION['saveme'] == 'ok' ) {
    //If session is set and right or if is set a pass and pass is true
    $priv = (!isset($_POST['priv'])) ? 0 : 1;
    $dest = $_POST['link_id'];
    $link->updateNameLink($dest,$_POST['name']);
    $link->updateUrlLink($dest,$_POST['url']);
    $link->updateCategoryLink($dest,$_POST['category']);
    $link->updatePriv8Link($dest,$priv);
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
    
    //If choose a link to modify
    if(isset($_POST['link']) && $link->getLinkById($_POST['link']) !== false) {
        $categoria = $category->getAllCategory();
        foreach ($link->getLinkById($_POST['link']) as $dati) {
            $id_link = $dati['id'];
            $nome = $dati['name'];
            $url = $dati['url'];
            $cate = $dati['category'];
            $priv8 = $dati['priv8'];
        }?>
            <form method="post" action="" class="forms columnar">
                <fieldset>
                    <ul>
                        <li>
                            <label for="name" class="bold">Name</label>
                            <input type="text" name="name" id="name" size="40" value="<?php echo $nome;?>" />
                        </li>
                        <li>
                            <label for="url" class="bold">Url</label>
                            <input type="text" name="url" id="url" size="40" value="<?php echo $url;?>" />
                        </li>
                        <li>
                            <label for="category" class="bold">Category</label>
                            <select class="width-33" name="category" id="category">
                                <option value=''>Choose category</option>
                                <?php foreach($categoria as $cat){ 
                                        if($cat['label'] != "General"){?>
                                <option name="category" value="<?php echo $cat['id'];?>" <?php echo ($cat['id'] == $cate) ? "selected" : "";?>><?php echo $cat['label'];?></option>
                                <?php } 
                                    }?>
                            </select>
                        </li>
                        <li>
                            <label for="priv" class="bold">Private</label>
                            <input type="checkbox" name="priv" id="priv" value='1' <?php echo ($priv8 == 1) ? "checked" : "";?>/>
                        </li>
                        <li class="push">
                            <input type="hidden" name="link_id" value="<?php echo $id_link;?>"/>
                            <input type="submit" name="send" class="btn" value="Submit" />
                        </li>
                    </ul>
                </fieldset>
            </form>
    <?php
    }
    else
    {
        $all_link = $link->getAllLink();?>
            <form method="post" action="" class="forms columnar">
                <fieldset>
                    <ul>
                        <li>
                            <label for="link" class="bold">Modify Link</label>
                            <select class="width-33" name="link" id="link">
                                <option value=''>Choose Link</option>
                                <?php foreach($all_link as $link_del){ 
                                        $where_cat = $category->getCategoryById($link_del['category']);?>
                                <option name="link" value="<?php echo $link_del['id'];?>"><?php echo $link_del['name']." --------- ".$where_cat[0]['label'];?></option>
                                <?php }?>
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
<?php
if(isset($_SESSION['saveme'])) {
          echo '<li><a href="edit_account.php">Edit Account</a> | </li>'; } ?>
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
