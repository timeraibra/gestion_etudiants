<?php
require_once '../models/Etudiant.php';

class EtudiantController {
    private $etudiantModel;

    public function __construct($pdo) {
        $this->etudiantModel = new Etudiant($pdo);
    }

    // 📋 LISTE
    public function index() {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $search = $_GET['search'] ?? '';
        $etudiants = $this->etudiantModel->getAll($search);

        require '../views/etudiants/index.php';
    }

    // ➕ CREATE
    public function create() {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nom = htmlspecialchars(trim($_POST['nom']));
            $prenom = htmlspecialchars(trim($_POST['prenom']));
            $email = htmlspecialchars(trim($_POST['email']));
            $classe_id = (int) $_POST['classe_id'];

            if ($nom === '' || $prenom === '' || $email === '' || $classe_id === 0) {
                $message = "Tous les champs sont obligatoires";
            } else {
                $this->etudiantModel->create($nom, $prenom, $email, $classe_id);
                header("Location: index.php?page=dashboard");
                exit;
            }
        }

        require '../views/etudiants/create.php';
    }

    // ✏️ EDIT
    public function edit() {
        $id = $_GET['id'];

        $etudiant = $this->etudiantModel->find($id);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];

            $this->etudiantModel->update($id, $nom, $prenom, $email);

            header("Location: index.php?page=dashboard");
            exit;
        }

        require '../views/etudiants/edit.php';
    }

    // 🗑️ DELETE
    public function delete() {
        $id = $_GET['id'];

        if ($_SESSION['user']['role'] != 'admin') {
            die("Accès refusé");
        }

        $this->etudiantModel->delete($id);

        header("Location: index.php?page=dashboard");
        exit;
    }
}