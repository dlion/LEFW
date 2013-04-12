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
    
    public function getLinkByCategory($category) {
        $query = $this->pdo->prepare("SELECT id,name,url,category FROM link_link WHERE user = :id AND category = :cate");
        $query->execute(array(':id' => $this->id, ':cate' => $category));
        if($query->rowCount() > 0) {
            $ris = $query->fetchAll();
            return $ris;
        }
        else
            return false;
    }
    
    public function getAllLink() {
        $query = $this->pdo->prepare("SELECT id,name,url,category FROM link_link WHERE user = :id");
        $query->execute(array(':id' => $this->id));
        if($query->rowCount() > 0) {
            $ris = $query->fetchAll();
            return $ris;
        }
        else
            return false;
    }
    
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