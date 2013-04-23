<?php
class Link {
    private $id;
    
    //Istanza
    private static $istanza = null;
    //PDO
    private $pdo;
    
    public static function getIstanza($id,$pdo) {
      if(self::$istanza == null)
        self::$istanza = new self($id,$pdo);
      
      return self::$istanza;
    }
    
    private function __construct($id,$pdo) {
        $this->id = $id;
        $this->pdo = $pdo;
    }
    
    //Return public links by a category and user
    public function getPublicLinkByCategory($category) {
        $query = $this->pdo->prepare("SELECT id,name,url,category FROM link_link WHERE user = :id AND category = :cate AND priv8 = '0' ORDER BY name");
        $query->execute(array(':id' => $this->id, ':cate' => $category));
        if($query->rowCount() > 0) {
            $ris = $query->fetchAll();
            return $ris;
        }
        else
            return false;
    }
    
    //Return private links by a category and user
    public function getPrivateLinkByCategory($category) {
        $query = $this->pdo->prepare("SELECT id,name,url,category FROM link_link WHERE user = :id AND category = :cate AND priv8 = '1' ORDER BY name");
        $query->execute(array(':id' => $this->id, ':cate' => $category));
        if($query->rowCount() > 0) {
            $ris = $query->fetchAll();
            return $ris;
        }
        else
            return false;
    }
    
    //Return all public links of an user
    public function getAllPublicLink() {
        $query = $this->pdo->prepare("SELECT id,name,url,category FROM link_link WHERE user = :id AND priv8 = '0' ORDER BY name");
        $query->execute(array(':id' => $this->id));
        if($query->rowCount() > 0) {
            $ris = $query->fetchAll();
            return $ris;
        }
        else
            return false;
    }
    
    //Return all private links of an user
    public function getAllPrivateLink() {
        $query = $this->pdo->prepare("SELECT id,name,url,category FROM link_link WHERE user = :id AND priv8 = '1' ORDER BY name");
        $query->execute(array(':id' => $this->id));
        if($query->rowCount() > 0) {
            $ris = $query->fetchAll();
            return $ris;
        }
        else
            return false;
    }
    
    //Return all links of an user
    public function getAllLink() {
        $query = $this->pdo->prepare("SELECT id,name,url,priv8,category FROM link_link WHERE user = :id ORDER BY name");
        $query->execute(array(':id' => $this->id));
        if($query->rowCount() > 0) {
            $ris = $query->fetchAll();
            return $ris;
        }
        else
            return false;
    }
    
    //Check if url is a true url
    public function checkURL($url) {
        $reg = '%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu';
        
        $url = htmlspecialchars(trim($url));
        
        if(preg_match($reg,$url))
            return true;
        else
        {
            $url = "http://".$url;
            
            return (preg_match($reg,$url)) ? true : false;
        }
    }
    
    //Insert a link with category
    public function insertLink($name,$url,$category,$priv) {
        
        if($this->checkURL($url) === true)
        {
            $url = htmlspecialchars(trim($url));
            $name = htmlspecialchars(trim($name));
            $category = htmlspecialchars(trim($category));
            $priv = htmlspecialchars(trim($priv));
        
            $query = $this->pdo->prepare("INSERT INTO link_link(name,url,user,priv8,category) VALUES(:name,:url,:user,:priv,:category)");
        
            $query->execute(array(':name' => $name,
                                        ':url' => $url,
                                        ':user' => $this->id,
                                        ':priv' => $priv,
                                        ':category' => $category
                                        )
                                    );
                                    
            return ($query->rowCount() > 0) ? true : false;
        }
        else
            return false;
    }
    
    //Delete link
    public function deleteLink($id) {
        $id = htmlspecialchars(trim($id));
        
        $query = $this->pdo->prepare("DELETE FROM link_link WHERE id = :id AND user = :user");
        $ris = $query->execute(array(':id' => $id,
                                     ':user' => $this->id
                                    )
                                );
                        
        return ($query->rowCount() > 0) ? true : false;
    }
    
    //Modify Name Link
    public function modifyNameLink($id,$name) {
        $id = htmlspecialchars(trim($id));
        $name = htmlspecialchars(trim($name));
        
        $query = $this->pdo->prepare("UPDATE link_link SET name = :name WHERE id = :id AND user = :user");
        $query->execute(array(':name' => $name,
                              ':id' => $id,
                              ':user' => $this->id
                            )
                        );
        return ($query->rowCount() > 0) ? true : false;
    }
    
    //Modify Url Link
    public function modifyUrlLink($id,$url) {
        if($this->checkURL($url) === true)
        {
            $url = htmlspecialchars(trim($url));
            $id = htmlspecialchars(trim($id));
            
            $query = $this->pdo->prepare("UPDATE link_link SET url = :url WHERE id = :id AND user = :user");
            $query->execute(array(':url' => $url,
                                  ':id' => $id,
                                  ':user' => $this->id
                                )
                            );
            return ($query->rowCount() > 0) ? true : false;
        }
        else
            return false;
    }
    
    public function modifyCategoryLink($id,$category) {
        $id = htmlspecialchars(trim($id));
        $category = htmlspecialchars(trim($category));
        
        $query = $this->pdo->prepare("UPDATE link_link SET category = :category WHERE id = :id AND user = :user");
        $query->execute(array(':category' => $category,
                              ':id' => $id,
                              ':user' => $this->id
                            )
                        );
        return ($query->rowCount() > 0) ? true : false;
    }
}
?>