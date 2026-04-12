<?php
session_start();
require_once '../config/config.php';

// 🔐 Vérifier connexion
if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

// 🔐 Vérifier rôle admin
if ($_SESSION['user']['role'] !== 'admin') {
    die("⛔ Accès refusé");
}

// 🔍 Vérifier ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID invalide");
}

$id = (int) $_GET['id'];

// 🗑️ Suppression sécurisée
$stmt = $pdo->prepare("DELETE FROM etudiants WHERE id = ?");
$stmt->execute([$id]);

// 🔄 Redirection
header("Location: index.php?page=dashboard");
exit;