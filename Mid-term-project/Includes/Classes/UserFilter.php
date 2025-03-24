<?php

namespace Classes;

use Includes\Classes\Dbh;
use PDO;

require_once 'Dbh.php';

class UserFilter extends Dbh
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->connect();
    }

    public function getUserinfo()
    {
        try {
            $sql = "SELECT users.user_id, 
                           users.firstname, 
                           users.lastname, 
                           users.email, 
                           users.phone, 
                           credentials.username, 
                           credentials.role
                    FROM users
                    INNER JOIN credentials ON users.user_id = credentials.user_id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \PDOException("Error fetching users: " . $e->getMessage());
        }
    }
}
