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
        $query = $this->pdo->prepare("SELECT id,name,url,category FROM link_link WHERE user = :id AND category = :cate AND priv8 = '0'");
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
        $query = $this->pdo->prepare("SELECT id,name,url,category FROM link_link WHERE user = :id AND category = :cate AND priv8 = '1'");
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
        $query = $this->pdo->prepare("SELECT id,name,url,category FROM link_link WHERE user = :id AND priv8 = '0'");
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
        $query = $this->pdo->prepare("SELECT id,name,url,category FROM link_link WHERE user = :id AND priv8 = '1'");
        $query->execute(array(':id' => $this->id));
        if($query->rowCount() > 0) {
            $ris = $query->fetchAll();
            return $ris;
        }
        else
            return false;
    }
    
    //Insert a link with category
    public function insertLink($name,$url,$category) {
        
        $query = $this->pdo->prepare("INSERT INTO link_link(name,url,user,category) VALUES(:name,:url,:user,:category)");
        
        $ris = $query->execute(array(':name' => $name,
                                     ':url' => $url,
                                     ':user' => $this->id,
                                     ':category' => $category
                                    )
                                );
        return $ris;
    }
}
?>