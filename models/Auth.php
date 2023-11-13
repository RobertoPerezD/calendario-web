<?php

class Auth {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function authenticateUser($email, $password) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = :email AND password = :password");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                session_start();
                $_SESSION['name'] = $user['name'];
                $_SESSION['user'] = $user['id_user'];
                
                return 1;
            } else {
                return 0 ;
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
