<?php
//Classe utente
class User {
    private $nick;
    private $password;
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
            //Salvo il pdo
            $this->pdo = $pdo;
            //Prendo i dati dell'utente
            $query = $pdo->prepare("SELECT nick,password FROM link_profile WHERE id = :id");
            $query->execute(array(':id' => $id));
            
            if($query->rowCount() > 0) {
                $ris = $query->fetch(PDO::FETCH_OBJ);
                $this->nick = $ris->nick;
                $this->password = $ris->password;
                $this->id = $id;
            }
            else throw new Exception("User not found");
        }
        catch(Exception $e) {
            die($e->getMessage());
        }
    }

    public function getNick() {
        return $this->nick;
    }
    
    public function checkMyPass($pass) {
        $pass = hash("sha256",$pass);
        return ($pass == $this->password) ? true : false;
    }

    public function changeNick($another) {
        $another = htmlspecialchars(trim($another));
        $query = $this->pdo->prepare("UPDATE link_profile SET nick = :another WHERE id = :id");
        $query->execute(array(':another' => $another,
                              ':id' => $this->id
                              )
                        );
    }

    public function changePass($passnew) {
        $passnew = hash("sha256",htmlspecialchars(trim($passnew)));
        $query = $this->pdo->prepare("UPDATE link_profile SET password = :passnew WHERE id = :id");
        $query->execute(array(':passnew' => $passnew,
                              ':id' => $this->id
                              )
                        );
    }
}
?>