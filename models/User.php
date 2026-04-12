<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // 🔐 Connexion utilisateur
    public function login($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE username = ?");
        $stmt->execute([$username]);

        $user = $stmt->fetch();

        if ($user && md5($password) === $user['password']) {
            return $user;
        }

        return false;
    }
}