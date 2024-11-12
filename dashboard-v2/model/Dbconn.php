<?php 

 class conn{
private $dbname="ecommerce";
private $host="localhost";
private $user ="root";
private $passWord="";

protected function connect(){
    try{
        $pdo = new PDO ("mysql:host=" .$this->host . ";dbname=". $this->dbname , $this->user ,$this->passWord );
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo ;

    }catch(PDOException $e){
   die("Connection failed" . $e->getMessage());
    }
}




 }