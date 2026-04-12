<?php
session_start();

// ✅ 1. Charger la base AVANT TOUT
require_once '../config/config.php';

// ✅ 2. Charger les modèles
require_once '../models/Etudiant.php';

// ✅ 3. Initialiser le modèle
$etudiantModel = new Etudiant($pdo);

// ✅ 4. Récupérer recherche
$search = $_GET['search'] ?? '';
$etudiants = $etudiantModel->getAll($search);

// ✅ 5. Router (gestion des pages)
$page = $_GET['page'] ?? 'login';

switch ($page) {

    case 'login':
        require_once '../views/auth/login.php';
        break;

    // 🔥 DASHBOARD ADMIN (accès complet)
    case 'dashboard':
        // 🔒 Vérifier connexion
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit;
        }

        // 🔒 Vérifier rôle admin
       if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] != 'admin') {
    die("Accès refusé");
}

        require_once '../views/etudiants/index.php';
        break;

    // 🔥 DASHBOARD ETUDIANT (accès limité)
    case 'dashboard_user':
        // 🔒 Vérifier connexion
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit;
        }

        require_once '../views/etudiants/dashboard_user.php';
        break;

    case 'create':
        // 🔒 Seul admin peut ajouter
        if ($_SESSION['user']['role'] != 'admin') {
            die("Accès refusé");
        }

        require_once '../views/etudiants/create.php';
        break;

    case 'edit':
        // 🔒 Seul admin peut modifier
        if ($_SESSION['user']['role'] != 'admin') {
            die("Accès refusé");
        }

        require_once '../views/etudiants/edit.php';
        break;

    case 'delete':
        // 🔒 Seul admin peut supprimer
        if ($_SESSION['user']['role'] != 'admin') {
            die("Accès refusé");
        }

        require_once '../views/etudiants/delete.php';
        break;

    case 'logout':
        // 🔐 Déconnexion utilisateur
        session_destroy();
        header("Location: index.php?page=login");
        exit;

    default:
        echo "Page introuvable";
}