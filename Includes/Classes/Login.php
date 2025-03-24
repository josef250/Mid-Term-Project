<?php

namespace Classes;

use Includes\Classes\Dbh;

require_once 'Dbh.php';

class Login extends Dbh
{
    private $username;
    private $password;
    private $pdo;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
        $this->pdo = $this->connect();
    }

    public function login()
    {
        try {
            $sql = "SELECT users.user_id, credentials.username, credentials.password, credentials.role 
                    FROM users
                    INNER JOIN credentials ON users.user_id = credentials.user_id 
                    WHERE credentials.username = :username";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $this->username);
            $stmt->execute();

            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$user) {
                return 'Invalid username';
            }

            if (password_verify($this->password, $user['password'])) {
                // Start a session and store user information
                session_start();
                $_SESSION['id'] = $user['user_id'];
                $_SESSION['role'] = $user['role'];
                return true;
            } else {
                return 'Invalid password';
            }
        } catch (\PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
