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
    
    public function checkURL($url) {
        $reg = '%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu';
        
        $url = htmlspecialchars(trim($url));
        
        if(preg_match($reg,$url))
            return true;
        else
        {
            $url = "http://".$url;
            if(preg_match($reg,$url))
                return true;
            else
                return false;
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
        
            $ris = $query->execute(array(':name' => $name,
                                        ':url' => $url,
                                        ':user' => $this->id,
                                        ':priv' => $priv,
                                        ':category' => $category
                                        )
                                    );
            return $ris;
        }
        else
            return false;
    }
}
?>