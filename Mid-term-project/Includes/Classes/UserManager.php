<?php

namespace Classes;

use Includes\Classes\Dbh;
use PDO;
use PDOException;

require_once 'Dbh.php';

class UserManager extends Dbh
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->connect();
    }

    public function beginTransaction()
    {
        $this->pdo->beginTransaction();
    }

    public function commitTransaction()
    {
        $this->pdo->commit();
    }

    public function rollBackTransaction()
    {
        $this->pdo->rollBack();
    }

    public function insertUser($firstname, $lastname, $email, $phone)
    {
        try {
            $sql = "INSERT INTO users (firstname, lastname, email, phone) VALUES (:firstname, :lastname, :email, :phone)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':email' => $email,
                ':phone' => $phone
            ]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            throw new PDOException("Failed to insert user: " . $e->getMessage());
        }
    }

    public function insertCredentials($userId, $username, $role, $password)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO credentials (user_id, username, role, password) VALUES (:user_id, :username, :role, :password)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':user_id' => $userId,
                ':username' => $username,
                ':role' => $role,
                ':password' => $hashedPassword
            ]);
        } catch (PDOException $e) {
            throw new PDOException("Failed to insert credentials: " . $e->getMessage());
        }
    }

    public function deleteUser($userId)
    {
        try {
            $this->pdo->beginTransaction();

            // Delete from credentials first
            $stmt1 = $this->pdo->prepare("DELETE FROM credentials WHERE user_id = :user_id");
            $stmt1->execute([':user_id' => $userId]);

            // Delete from users
            $stmt2 = $this->pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
            $stmt2->execute([':user_id' => $userId]);

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new PDOException("Failed to delete user: " . $e->getMessage());
        }
    }

    public function editUser($userId, $firstname, $lastname, $email, $phone, $username, $role)
    {
        try {
            $this->pdo->beginTransaction();

            $stmt1 = $this->pdo->prepare("
                UPDATE users SET firstname = :firstname, lastname = :lastname, 
                                 email = :email, phone = :phone 
                WHERE user_id = :user_id
            ");
            $stmt1->execute([
                ':firstname' => $firstname,
                ':lastname'  => $lastname,
                ':email'     => $email,
                ':phone'     => $phone,
                ':user_id'   => $userId
            ]);

            $stmt2 = $this->pdo->prepare("
                UPDATE credentials SET username = :username, role = :role 
                WHERE user_id = :user_id
            ");
            $stmt2->execute([
                ':username' => $username,
                ':role'     => $role,
                ':user_id'  => $userId
            ]);

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new PDOException("Failed to update user: " . $e->getMessage());
        }
    }

    public function resetPassword($username, $email, $newPassword)
    {
        try {
            // Check if user exists
            $stmt = $this->pdo->prepare("
                SELECT users.user_id FROM users
                INNER JOIN credentials ON users.user_id = credentials.user_id
                WHERE credentials.username = :username AND users.email = :email
            ");
            $stmt->execute([
                ':username' => $username,
                ':email' => $email
            ]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return false;
            }

            // Update password
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $stmt = $this->pdo->prepare("UPDATE credentials SET password = :password WHERE user_id = :user_id");
            $stmt->execute([
                ':password' => $hashedPassword,
                ':user_id'  => $user['user_id']
            ]);

            return true;
        } catch (PDOException $e) {
            throw new PDOException("Failed to reset password: " . $e->getMessage());
        }
    }

    public function getUserById($userId)
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT users.user_id, users.firstname, users.lastname, 
                       users.email, users.phone, credentials.username, credentials.role
                FROM users
                INNER JOIN credentials ON users.user_id = credentials.user_id
                WHERE users.user_id = :user_id
            ");
            $stmt->execute([':user_id' => $userId]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Failed to get user: " . $e->getMessage());
        }
    }
}
