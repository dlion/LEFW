<?php
//Classe utente
class User {
    private $id;
    private $nick;
    private $password;

    //Istanza
    private static $istanza = null;
    //PDO
    private $pdo;
    
    public static function getIstanza($nick,$pdo) {
      if(self::$istanza == null)
        self::$istanza = new self($nick,$pdo);
      
      return self::$istanza;
    }
    
    private function __construct($nick,$pdo) {
        try {
            //Salvo il pdo
            $this->pdo = $pdo;
            //Prendo i dati dell'utente
            $query = $pdo->prepare("SELECT id,nick,password FROM link_profile WHERE nick = :nick");
            $query->execute(array(':nick' => $nick));
            
            if($query->rowCount() > 0) {
                $ris = $query->fetch(PDO::FETCH_OBJ);

                $this->id = $ris->id;
                $this->nick = $ris->nick;
                $this->password = $ris->password;
            }
            else throw new Exception("L'utente cercato non è stato trovato");
        }
        catch(Exception $e) {
            die($e->getMessage());
        }
    }

    public function getId() {
        return $this->id;
    }
    public function getNick() {
        return $this->nick;
    }
    
    public function checkMyPass($pass) {
        $pass = hash("sha256",$pass);
        return ($pass == $this->password) ? true : false;
    }
}
?>