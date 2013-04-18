<?php
//Classe per settare la configurazione
class Config {
    private $host;
    private $dbname;
    private $user_db;
    private $pass_db;
    const name_site = 'Links Every Fuckin\' Where';
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
        return Config::name_site;
    }
    
    public function getAdmin() {
        return $this->admin;
    }
    
    public function getDbPass(){
        return $this->pass_db;
    }
    
}
?>