<?php
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
        }catch(Exception $e) {
            die($e->getMessage());
        }
    }
    
    public function getPDO() {
        return $this->db;
    }
}
?>