<?php
//Classe utente
class User {
    private $id;
    private $nick;
    private $password;
    private $name;
    private $surname;
    private $pic;
    private $bio;
        
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
            $query = $pdo->prepare("SELECT id,nick,password,nome,cognome,pic,bio FROM link_profile WHERE nick = :nick");
            $query->execute(array(':nick' => $nick));
            if($query->rowCount() > 0) {
                $ris = $query->fetch(PDO::FETCH_OBJ);

                $this->id = $ris->id;
                $this->nick = $ris->nick;
                $this->password = $ris->password;
                $this->name = $ris->nome;
                $this->surname = $ris->cognome;
                $this->pic = $ris->pic;
                $this->bio = $ris->bio;
            }
            else
                return false;
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function getId() {
        return $this->id;
    }
    public function getNick() {
        return $this->nick;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getSurname() {
        return $this->surname;
    }
    
    public function getPic() {
        return $this->pic;
    }
    
    public function getBio() {
        return $this->bio;
    }
    
    public function checkMyPass($pass) {
        return ($pass === $this->password) ? true : false;
    }
}
?>