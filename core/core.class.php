<?php
//Classe per settare la configurazione
class Config {
    private $host;
    private $dbname;
    private $user_db;
    private $pass_db;
    private $name_site = "Links Every Fuckin' Where";
    private $admin;
    //Istanza
    private static $istanza = null;
    
    public static function getIstanza($host,$dbname,$user,$pass,$admin) {
      if(self::$istanza == null)
        self::$istanza = new self($host,$dbname,$user,$pass,$admin);
      
      return self::$istanza;
    }
    
    private function __construct($host,$dbname,$user,$pass,$admin) {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user_db = $user;
        $this->pass_db = $pass;
        $this->admin = $admin;
    }
    
    public function getHost() {
        return $this->host;
    }
    
    public function getDbName() {
        return $this->dbname;
    }
    
    public function getDbUser() {
        return $this->user_db;
    }
    
    public function getNameSite() {
        return $this->name_site;
    }
    
    public function getAdmin() {
        return $this->admin;
    }
    
    public function getDbPass(){
        return $this->pass_db;
    }
    
}
      
//Classe per la connessione al DB
class Db {
    private $db;
    //Istanza
    private static $istanza = null;
    
    public static function getIstanza($dato)
    {
      if(self::$istanza == null)
        self::$istanza = new self($dato);
      
      return self::$istanza;
    }
    
    private function __construct($dato) {
        try {
            $this->db = new PDO("mysql:host=".$dato->getHost().";dbname=".$dato->getDbName(), $dato->getDbUser(), $dato->getDbPass());
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function getPDO() {
        return $this->db;
    }
}

//Classe utente
class User {
    private $id;
    private $nick;
    private $password;
    private $name;
    private $surname;
    private $pic;
    private $bio;
    
    private $link;
    
    //Istanza
    private static $istanza = null;
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
            else {
                echo "Nessun utente trovato";
                exit;
            }
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
    
    public function checkPass($pass) {
        if($pass === $this->password)
            return 0;
        else
            return 1;
    }
    
    public function getLink() {
        $query = $this->pdo->prepare("SELECT id,name,url FROM link_link WHERE user = :id");
        $query->execute(array(':id' => $this->id));
        if($query->rowCount() > 0) {
            $ris = $query->fetchAll();
            return $ris;
        }
        else {
            echo "Nessun link associato a questo utente";
            exit;
        }
    }
    
    public function insertLink($name,$url,$password) {
        if($this->checkPass($password) === 0) {
            $query = $this->pdo->prepare("INSERT INTO link_link(name,url,user) VALUES(:name,:url,:user)");
            $query->execute(array(':name' => $name,
                                  ':url' => $url,
                                  ':user' => $this->id
                                )
                            );
            return 1;
        }
        else
            return -1;
    }
}
?>
