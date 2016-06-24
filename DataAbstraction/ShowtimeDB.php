<?php

class ShowtimeDB {
    
    private $conn;
    private static $instance = null;
    
    private function __construct() {
        try{
            $this->conn=new PDO("mysql:host=localhost;dbname=showtimedb;charset=UTF8", "dw", "dw");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }catch(PDOException $e){
            echo $e->getMessage();
            exit();
        }
    }
    
    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }
    
    public static function getInstance(){
        if(self::$instance == null){
            self::$instance=new ShowtimeDB();
        }
        return(self::$instance);
    }
        
     public function query($q, $parms=array()){
        $res=$this->conn->prepare($q);
        if($res){
            $res->execute($parms);
        }
        return($res);
    }
        
    public function __destruct(){
        if(self::$instance != null){
            $this->conn=null;
            self::$instance=null;
        }
    }
}