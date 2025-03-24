<?php

namespace Includes\Classes;
use PDO;
use PDOException;

class Dbh
{
 private $host = "database";
 private $user = "root";
 private $pass = "Ac2YtdW4fiAJ6pf";
 private $dbname = "mid_term_project";

 protected function connect(){

     try {
         $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;
         $pdo = new PDO($dsn, $this->user, $this->pass);
         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         return $pdo;
     }catch (PDOException $e){
         throw new PDOException("Connection failed: " . $e->getMessage());
     }

 }

}