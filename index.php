<?php
//Includo la configurazione e le classi
include_once('core/config.php');
//istanzio il tutto
$user = User::getIstanza('dlion',$db);

if(isset($_POST['name_site']) && isset($_POST['link_site']) && isset($_POST['password_site'])) {
    $ris = $user->insertLink($_POST['name_site'],$_POST['link_site'],$_POST['password_site']);
    /*if($ris == 1)
        echo '<div class="row">
                <div class="half centered"><h2>Inserimento Riuscito</h2></div>
              </div>';
    else
        echo '<div class="row">
                <div class="half centered"><h2>Impossibile Inserire</h2></div>
              </div>';
    */
}
$io = array (   
        "id" => $user->getId(),
        "nome" => $user->getName(),
        "cognome" => $user->getSurname(),
        "nick" => $user->getNick(),
        "pic" => $user->getPic(),
        "bio" => $user->getBio(),
        "link" => $user->getLink()
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
        <link rel="stylesheet" type="text/css" href="css/dl.css" />
        <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
    </head>
   </head>
    <body>
        <div class="wrapper">
            <header id="header" class="group">
		        <h1><?php echo htmlspecialchars($conf->getNameSite()." - ".$io['nick']); ?></h1>
		        <nav class="nav-g">
			        <ul>
				        <li><a href="#">Private Link</a></li>
                        <li><a href="#">Add Link</a></li>
				        <li><a href="#">Contact Us</a></li>
			        </ul>
		        </nav>
	        </header>
    	    <ul id="link" class="block-three">
                <li>
            	    <div class="inner">
                        <figure class="image-left">
                            <img src="<?php echo htmlspecialchars($io['pic']); ?>" alt="" width="200" height="200" />
                        </figure>
                        
            		    <h3><?php echo htmlspecialchars($io['nome']." ".$io['cognome']); ?></h3>
            		    <h4 class="subheader bold"><?php echo htmlspecialchars($io['nick']); ?></h4>
            		    <p><?php echo htmlspecialchars($io['bio']); ?></p>
                    </div>
            	</li>
                
                <li>
                <?php foreach($io['link'] as $linko) {?>
                    <div class="inner">
    			        <h3><?php echo htmlspecialchars($linko['name']); ?></h3>
                        <a href="<?php echo htmlspecialchars($linko['url']); ?>" target="_blank" rel="nofollow"><?php echo htmlspecialchars($linko['url']);?></a>
                    </div>
      <?php }?> </li>
                   
                <li>
                    <div class="inner">
                        <h2>Submit Link</h2>
                        <form method="post" action="" class="forms">
                            <ul>
                                <li>
                                    <label for="name_site" class="bold">Site Name</label>
                                    <input type="text" name="name_site" id="name_site" />
                                </li>
                                <li>
                                    <label for="link_site" class="bold">Site Link</label>
                                    <input type="text" name="link_site" id="link_site" />
                                </li>
                                <li>
                                    <label for="password_site" class="bold">Password</label>
                                    <input type="password" name="password_site" id="password_site" />
                                </li>
                                <li>
                                    <input type="submit" name="send" class="btn" value="Submit Link" />
                                </li>
                            </ul>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </body>
</html>