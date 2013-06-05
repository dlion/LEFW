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
        try {

            if(!empty($id) && !empty($pdo)) {
                $this->id = $id;
                $this->pdo = $pdo;
            }
            else 
                throw new Exception("Errore nell'istanziamento delle categorie!");
        }
        catch(Exception $e) {
            die($e->getMessage());
        }
    }

    public function getLinkById($link) {
        $query = $this->pdo->prepare("SELECT id,name,url,category,priv8 FROM link_link WHERE user = :id AND id = :link");
        $query->execute(array(':id' => $this->id, ':link' => $link));
        if($query->rowCount() > 0) {
            $ris = $query->fetchAll();
            return $ris;
        }
        else
            return false;
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
        return preg_match("#\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))#im",$url);
    }
    
    //Insert a link with category
    public function insertLink($name,$url,$category,$priv) {
        try {
            $check = $this->checkURL($url);
            if($check === 1)
            {
                $name = htmlspecialchars(trim($name));
                $url = htmlspecialchars(trim($url));
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
                                    
                if($query->rowCount() > 0)
                    return true;
                else
                    throw new Exception("Query Error!");
            }
            elseif($check === 0)
                throw new Exception("Insert a valid link!");
                
            else
                throw new Exception("Impossible insert a link!");
        }catch(Exception $e) {
            die($e->getMessage());
        }
    }
    
    //Delete link
    public function deleteLink($id) {
        $id = htmlspecialchars(trim($id));
    
        $query = $this->pdo->prepare("DELETE FROM link_link WHERE id = :id AND user = :user");
        $ris = $query->execute(array(':id' => $id,
                                     ':user' => $this->id
                                    )
                                );
    }
    
    //Modify Name Link
    public function updateNameLink($id,$name) {
        $id = htmlspecialchars(trim($id));
        $name = htmlspecialchars(trim($name));
        
        $query = $this->pdo->prepare("UPDATE link_link SET name = :name WHERE id = :id AND user = :user");
        $query->execute(array(':name' => $name,
                              ':id' => $id,
                              ':user' => $this->id
                            )
                        );
    }
    
    //Modify Url Link
    public function updateUrlLink($id,$url) {
        try {
            $check = $this->checkURL($url);
            if($check === 1)
            {
                $url = htmlspecialchars(trim($url));
                $id = htmlspecialchars(trim($id));
            
                $query = $this->pdo->prepare("UPDATE link_link SET url = :url WHERE id = :id AND user = :user");
                $query->execute(array(':url' => $url,
                                      ':id' => $id,
                                      ':user' => $this->id
                                    )
                                );
            }
            elseif($check === 0)
                throw new Exception("Insert a valid link!");
            else
                throw new Exception("Impossible update a link!");
        }catch(Exception $e) {
            die($e->getMessage());
        }
    }
    
    public function updateCategoryLink($id,$category) {
        $id = htmlspecialchars(trim($id));
        $category = htmlspecialchars(trim($category));
    
        $query = $this->pdo->prepare("UPDATE link_link SET category = :category WHERE id = :id AND user = :user");
        $query->execute(array(':category' => $category,
                              ':id' => $id,
                              ':user' => $this->id
                            )
                        );
    }

    public function updatePriv8Link($id,$priv8) {
        $id = htmlspecialchars(trim($id));
        $priv8 = htmlspecialchars(trim($priv8));

        $query = $this->pdo->prepare("UPDATE link_link SET priv8 = :priv8 WHERE id = :id AND user = :user");
        $query->execute(array(':priv8' => $priv8,
                              ':id' => $id,
                              ':user' => $this->id
                              )
                        );
    }
}
?>