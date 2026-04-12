<?php
require_once '../models/User.php';

class AuthController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    // 🔐 LOGIN
    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->login($username, $password);

            if ($user) {
                $_SESSION['user'] = $user;

                if ($user['role'] == 'admin') {
                    header("Location: index.php?page=dashboard");
                } else {
                    header("Location: index.php?page=dashboard_user");
                }
                exit;
            } else {
                $error = "Identifiants incorrects";
            }
        }

        require '../views/auth/login.php';
    }

    // 🔓 LOGOUT
    public function logout() {
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }
}