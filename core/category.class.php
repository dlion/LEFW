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
        $this->id = $id;
        $this->pdo = $pdo;
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
        $query = $this->pdo->prepare("INSERT INTO link_category(label,descr) VALUES(:label,:descr)");
        
        $ris = $query->execute(array(':label' => $label,
                                     ':descr' => $descr
                                    )
                              );
        return $ris;
    }
}
?>