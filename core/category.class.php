<?php
class Category {
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
            if(!empty($pdo) && !empty($id)) {
                $this->pdo = $pdo;
                $this->id = $id;
            }
            else
                throw new Exception("Errore nell'istanziamento delle categorie.", 1);
        }
        catch(Exception $e) {
            die($e->getMessage());
        }
                
    }

    public function getAllCategory() {
        $query = $this->pdo->prepare("SELECT id,label,descr FROM link_category WHERE user = :user ORDER BY label");
        $query->execute(array(':user' => $this->id));
        if($query->rowCount() > 0) {
            $ris = $query->fetchAll();
            return $ris;
        }
        else
            return false;
    }
    
    public function getCategoryById($id) {
        $query = $this->pdo->prepare("SELECT id,label,descr FROM link_category WHERE id = :id AND user = :user");
        $query->execute(array(':id' => $id, ':user' => $this->id));
        if($query->rowCount() > 0) {
            $ris = $query->fetchAll();
            return $ris;
        }
        else
            return false;
    }
    
    public function getCategoryByLabel($label) {
        $query = $this->pdo->prepare("SELECT id,label,descr FROM link_category WHERE label = :label AND user = :user");
        $query->execute(array(':label' => $label,':user' => $this->id));
        if($query->rowCount() > 0) {
            $ris = $query->fetchAll();
            return $ris;
        }
        else
            return false;
    }
    
    public function insertCategory($label,$descr) {
        if(!empty($label))
        {
            $label = htmlspecialchars(trim($label));
            $descr = htmlspecialchars(trim($descr));
            
            $query = $this->pdo->prepare("INSERT INTO link_category(label,descr,user) VALUES(:label,:descr,:user)");
        
            $ris = $query->execute(array(':label' => $label,
                                         ':descr' => $descr,
                                         ':user' => $this->id
                                        )
                                  );
            return $ris;
        }
        else
            return false;
    }
}
?>