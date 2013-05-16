<?php
class Category {
     private $id;
    
    //Istanza
    private static $istanza = null;
    //PDO
    private $pdo;
    
    public static function getIstanza($pdo) {
      if(self::$istanza == null)
        self::$istanza = new self($pdo);
      
      return self::$istanza;
    }
    
    private function __construct($pdo) {
        try {
            if(!empty($pdo)) {
                $this->pdo = $pdo;
            }
            else
                throw new Exception("Errore nell'istanziamento delle categorie.", 1);
        }
        catch(Exception $e) {
            die($e->getMessage());
        }
                
    }

    public function getAllCategory() {
        $query = $this->pdo->prepare("SELECT id,label,descr FROM link_category");
        $query->execute();
        if($query->rowCount() > 0) {
            $ris = $query->fetchAll();
            return $ris;
        }
        else
            return false;
    }
    
    public function getCategoryById($id) {
        $query = $this->pdo->prepare("SELECT id,label,descr FROM link_category WHERE id = :id");
        $query->execute(array(':id' => $id));
        if($query->rowCount() > 0) {
            $ris = $query->fetchAll();
            return $ris;
        }
        else
            return false;
    }
    
    public function getCategoryByLabel($label) {
        $query = $this->pdo->prepare("SELECT id,label,descr FROM link_category WHERE label = :label");
        $query->execute(array(':label' => $label));
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
            
            $query = $this->pdo->prepare("INSERT INTO link_category(label,descr) VALUES(:label,:descr)");
        
            $ris = $query->execute(array(':label' => $label,
                                         ':descr' => $descr
                                        )
                                  );
            return $ris;
        }
        else
            return false;
    }
}
?>
