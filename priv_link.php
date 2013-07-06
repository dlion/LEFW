<?php
//Configuration
include_once('core/config.php');

//Prendo tutte le categorie
$categoria = $category->getAllCategory();
//Counter Category
$i=0;
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
                        <li><span>Private Link</span></li>
        				<li><a href="add_link.php">Add Link</a></li>
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
    
    if($categoria !== false)
    {
        foreach($categoria as $cat)
        {
            $link_by_cat = $link->getPrivateLinkByCategory($cat['id']);
            if($link_by_cat !== false)
            {
                if($i % 4 == 0) 
                {?>
                    <div class='row'>
                <?php
                }
                $i++;?>
                    <div class='quarter'>
                        <h2><?php echo $cat['label']; ?></h2>
                        <h2 class='subheader'><?php echo $cat['descr']; ?></h2>
                        <table class='width-100 bordered'>
                            <thead class='thead'>
                <?php
                foreach($link_by_cat as $lincat)
                {?>
                    <tr>
                        <th>
                            <a href='<?php echo $lincat['url'];?>' rel='nofollow' target='_blank'><?php echo $lincat['name'];?></a>
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
                <h1>No categories found</h1>
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
    </body>
</html>
