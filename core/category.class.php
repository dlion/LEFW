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
                throw new Exception("Errore nell'istanziamento delle categorie.");
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
    
    public function insertCategory($label,$descr) {
        try
        {
            if(!empty($label) && !empty($descr))
            {
                $label = htmlspecialchars(trim($label));
                $descr = htmlspecialchars(trim($descr));

                if($label != "General") {
                    $query = $this->pdo->prepare("INSERT INTO link_category(label,descr,user) VALUES(:label,:descr,:user)");
        
                    $query->execute(array(':label' => $label,
                                          ':descr' => $descr,
                                          ':user' => $this->id
                                        )
                                    );
                    if($query->rowCount() > 0)
                        return true;
                    else
                        throw new Exception("Query Error!");
                }
                else
                    throw new Exception("'General' is a reserved name");
            }
            else
                throw new Exception("Insert name and description!");
        }catch(Exception $e) {
            die($e->getMessage());
        }
    }

    public function deleteCategory($id,$erase) {
        try {
            $id = htmlspecialchars(trim($id));
            $erase = htmlspecialchars(trim($erase));

            if($erase == 1) {
                //Delete all links associated
                $query = $this->pdo->prepare("DELETE FROM link_link WHERE user = :user AND category = :category");
                $query->execute(array(':user' => $this->id,
                                      ':category' => $id
                                      )
                                );
            }
            else {
                //Find General Category
                $query = $this->pdo->prepare("SELECT id FROM link_category WHERE label = :label AND user = :user");
                $query->execute(array(':label' => "General", ':user' => $this->id));
                if($query->rowCount() > 0) {
                    $ris = $query->fetchAll();
                    //Move all links to general category
                    $query = $this->pdo->prepare("UPDATE link_link SET category = :general, priv8 = '1' WHERE user = :user AND category = :category");
                    $query->execute(array(':general' => $ris[0]['id'],
                                          ':user' => $this->id,
                                          ':category' => $id
                                          )
                                    );
                }
                else
                    throw new Exception("Impossible to recognize 'General' category");
            }
            //Delete category
            $query = $this->pdo->prepare("DELETE FROM link_category WHERE id = :id AND user = :user");
            $query->execute(array(':id' => $id,
                                  ':user' => $this->id
                                )
                            );
        }catch(Exception $e) {
            die($e->getMessage());
        }
                
    }

    public function updateNameCategory($id,$name) {
        try {
            if(!empty($id) && !empty($name)) {
                $id = htmlspecialchars(trim($id));
                $name = htmlspecialchars(trim($name));
        
                $query = $this->pdo->prepare("UPDATE link_category SET label = :name WHERE id = :id AND user = :user");
                $query->execute(array(':name' => $name,
                                      ':id' => $id,
                                      ':user' => $this->id
                                    )
                                );
            }
            else
                throw new Exception("Insert a valid name!");
        }catch(Exception $e) {
            die($e->getMessage());
        }
    }

    public function updateDescrCategory($id,$descr) {
        try {
            if(!empty($id) && !empty($descr)) {
                $id = htmlspecialchars(trim($id));
                $descr = htmlspecialchars(trim($descr));
        
                $query = $this->pdo->prepare("UPDATE link_category SET descr = :name WHERE id = :id AND user = :user");
                $query->execute(array(':name' => $descr,
                                      ':id' => $id,
                                      ':user' => $this->id
                                    )
                                );
            }
            else
                throw new Exception("Insert a valid description!");
        }catch(Exception $e) {
            die($e->getMessage());
        }
    }
}
?>